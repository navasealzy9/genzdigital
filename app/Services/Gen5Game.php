<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Gen5Game
{
    public const WIDTH = 20;

    public const HEIGHT = 12;

    public const BUILD_HEIGHT = 3;

    public const MOVE_MS = 220;

    public const ACTION_MS = 900;

    public function find(int $id): object
    {
        $match = DB::table('gen5_matches')->find($id);
        abort_unless($match, 404);

        return $match;
    }

    public function authorize(User $user, object $match): void
    {
        if ($user->role === 'admin') {
            return;
        }
        abort_unless($user->role === 'student' && DB::table('learning_enrollments as e')
            ->join('learning_courses as c', 'c.id', '=', 'e.course_id')
            ->where('e.course_id', $match->course_id)->where('e.user_id', $user->id)
            ->where('e.status', 'active')->where('c.status', '!=', 'archived')->exists(), 403,
            'GEN5 is only available to active students enrolled in this class.');
    }

    public function create(User $admin, array $data): int
    {
        $this->expire();

        return DB::transaction(function () use ($admin, $data) {
            $course = DB::table('learning_courses')->where('id', $data['course_id'])->lockForUpdate()->first();
            abort_unless($course && $course->status !== 'archived', 422, 'Choose an available class.');
            abort_if(DB::table('gen5_matches')->where('course_id', $course->id)->whereIn('status', ['lobby', 'live'])->exists(), 409, 'This class already has an open GEN5 match. Finish or cancel it first.');

            return DB::table('gen5_matches')->insertGetId($data + [
                'created_by' => $admin->id, 'status' => 'lobby', 'board' => '{}', 'events' => '[]',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        });
    }

    public function join(User $user, int $id): void
    {
        DB::transaction(function () use ($user, $id) {
            $match = DB::table('gen5_matches')->where('id', $id)->lockForUpdate()->first();
            abort_unless($match, 404);
            $this->authorize($user, $match);
            abort_unless($user->role === 'student', 403);
            if (DB::table('gen5_players')->where('match_id', $id)->where('user_id', $user->id)->exists()) {
                return;
            }
            abort_unless($match->status === 'lobby', 409, 'The roster is locked after the match starts. Join the next match.');
            $counts = $this->eligiblePlayers($match)->selectRaw('p.team, COUNT(*) as total')->groupBy('p.team')->pluck('total', 'team');
            $team = ($counts[1] ?? 0) <= ($counts[2] ?? 0) ? 1 : 2;
            $members = (int) ($counts[$team] ?? 0);
            abort_if($members >= 40, 409, 'This match is full (40 students per team).');
            DB::table('gen5_players')->insert([
                'match_id' => $id, 'user_id' => $user->id, 'team' => $team,
                'x' => $team === 1 ? 2 : self::WIDTH - 3, 'y' => 1 + $members % (self::HEIGHT - 2),
                'created_at' => now(), 'updated_at' => now(),
            ]);
            $this->event($match, 'joined', $team, $user->name);
            $this->persist($match);
        });
    }

    public function control(int $id, string $action): array
    {
        return DB::transaction(function () use ($id, $action) {
            $match = DB::table('gen5_matches')->where('id', $id)->lockForUpdate()->first();
            abort_unless($match, 404);
            $this->finishIfDue($match);
            if ($action === 'start') {
                if ($match->status !== 'lobby') {
                    return ['error' => 'Only a waiting match can start.', 'code' => 409];
                }
                $teams = $this->eligiblePlayers($match)->distinct()->pluck('p.team');
                abort_unless($teams->contains(1) && $teams->contains(2), 422, 'At least one active enrolled student is required on each team.');
                $match->status = 'live';
                $match->started_at = now()->format('Y-m-d H:i:s.v');
                $match->ends_at = now()->addMinutes($match->duration_minutes)->format('Y-m-d H:i:s.v');
                $this->event($match, 'started');
                $this->persist($match);
            } elseif ($action === 'finish') {
                if ($match->status !== 'live') {
                    return ['error' => 'This match is not running.', 'code' => 409];
                }
                $this->finish($match);
            } else {
                if (! in_array($match->status, ['lobby', 'live'], true)) {
                    return ['error' => 'This match has already ended.', 'code' => 409];
                }
                $match->status = 'cancelled';
                $match->finished_at = now()->format('Y-m-d H:i:s.v');
                $this->event($match, 'cancelled');
                $this->persist($match);
            }

            return ['ok' => true];
        });
    }

    public function assign(int $id, int $player, int $team): void
    {
        DB::transaction(function () use ($id, $player, $team) {
            $match = DB::table('gen5_matches')->where('id', $id)->lockForUpdate()->first();
            abort_unless($match, 404);
            abort_unless($match->status === 'lobby', 409, 'Teams lock when the match starts.');
            $row = DB::table('gen5_players')->where('match_id', $id)->where('id', $player)->first();
            abort_unless($row, 404);
            abort_if(DB::table('gen5_players')->where('match_id', $id)->where('team', $team)->where('id', '!=', $player)->count() >= 40, 409, 'This team is full.');
            DB::table('gen5_players')->where('id', $row->id)->update(['team' => $team, 'x' => $team === 1 ? 2 : self::WIDTH - 3, 'updated_at' => now()]);
            $this->persist($match);
        });
    }

    public function act(User $user, int $id, array $data): array
    {
        return DB::transaction(function () use ($user, $id, $data) {
            $match = DB::table('gen5_matches')->where('id', $id)->lockForUpdate()->first();
            abort_unless($match, 404);
            $this->authorize($user, $match);
            $this->finishIfDue($match);
            if ($match->status !== 'live') {
                return ['error' => 'The match is not running or time has expired.', 'code' => 409];
            }
            $player = DB::table('gen5_players')->where('match_id', $id)->where('user_id', $user->id)->first();
            abort_unless($user->role === 'student' && $player, 403, 'Join the match before playing.');
            $x = (int) $data['x'];
            $y = (int) $data['y'];
            $distance = abs($player->x - $x) + abs($player->y - $y);
            $time = now()->getTimestampMs();
            if ($data['action'] === 'move') {
                abort_unless($distance === 1, 422, 'Move one tile at a time.');
                if ($time < $player->next_move_at) {
                    return ['error' => 'Movement is cooling down.', 'code' => 429, 'retry_after_ms' => $player->next_move_at - $time];
                }
                DB::table('gen5_players')->where('id', $player->id)->update(['x' => $x, 'y' => $y, 'next_move_at' => $time + self::MOVE_MS, 'updated_at' => now()]);
            } else {
                abort_unless($distance <= 1, 422, 'Walk next to the building first.');
                if ($time < $player->next_action_at) {
                    return ['error' => 'Your tool is recharging.', 'code' => 429, 'retry_after_ms' => $player->next_action_at - $time];
                }
                $territory = $x < self::WIDTH / 2 ? 1 : 2;
                $board = json_decode($match->board, true);
                $key = $x.':'.$y;
                $building = $board[$key] ?? ['x' => $x, 'y' => $y, 'team' => $territory, 'height' => 0];
                if ($data['action'] === 'build') {
                    abort_unless($territory === $player->team, 422, 'Build only inside your own territory.');
                    abort_if($building['height'] >= self::BUILD_HEIGHT, 409, 'This building is complete. Choose another tile.');
                    $building['height']++;
                    $board[$key] = $building;
                    if ($building['height'] === self::BUILD_HEIGHT) {
                        $this->event($match, 'built', $player->team, $user->name);
                    }
                    DB::table('gen5_players')->where('id', $player->id)->increment('builds');
                } else {
                    abort_unless($territory !== $player->team && $building['height'] > 0, 422, 'Choose an enemy building to attack.');
                    $building['height']--;
                    if ($building['height'] === 0) {
                        unset($board[$key]);
                        $this->event($match, 'destroyed', $player->team, $user->name);
                    } else {
                        $board[$key] = $building;
                        $this->event($match, 'attacked', $player->team, $user->name);
                    }
                    DB::table('gen5_players')->where('id', $player->id)->increment('attacks');
                }
                $match->board = json_encode((object) $board);
                DB::table('gen5_players')->where('id', $player->id)->update(['next_action_at' => $time + self::ACTION_MS, 'updated_at' => now()]);
            }
            $this->persist($match);

            return ['ok' => true];
        });
    }

    public function snapshot(User $user, int $id): array
    {
        $match = $this->find($id);
        $this->authorize($user, $match);
        if ($match->status === 'live' && now()->gte(Carbon::parse($match->ends_at))) {
            DB::transaction(function () use ($id) {
                $row = DB::table('gen5_matches')->where('id', $id)->lockForUpdate()->first();
                $this->finishIfDue($row);
            });
            $match = $this->find($id);
        }

        // Read a consistent revision while actions are serialized on the match row.
        return DB::transaction(function () use ($user, $id) {
            $match = DB::table('gen5_matches')->where('id', $id)->sharedLock()->first();
            $players = $this->eligiblePlayers($match)->select('p.id', 'p.user_id', 'p.team', 'p.x', 'p.y', 'p.next_move_at', 'p.next_action_at', 'p.builds', 'p.attacks', 'u.name')->orderBy('p.id')->get();
            $board = array_values(json_decode($match->board, true));
            $scores = $this->scores($board);

            return [
                'server_time' => now()->getTimestampMs(), 'revision' => $match->revision,
                'match' => ['id' => $match->id, 'title' => $match->title, 'status' => $match->status,
                    'team_one' => $match->team_one, 'team_two' => $match->team_two,
                    'duration_minutes' => $match->duration_minutes, 'winner' => $match->winner,
                    'ends_at' => $match->ends_at ? Carbon::parse($match->ends_at)->getTimestampMs() : null],
                'world' => ['width' => self::WIDTH, 'height' => self::HEIGHT, 'build_height' => self::BUILD_HEIGHT, 'move_ms' => self::MOVE_MS, 'action_ms' => self::ACTION_MS],
                'scores' => $match->status === 'finished' ? [1 => $match->score_one, 2 => $match->score_two] : $scores,
                'buildings' => $board, 'players' => $players,
                'me' => $players->firstWhere('user_id', $user->id), 'events' => json_decode($match->events, true),
            ];
        });
    }

    public function expire(): void
    {
        $ids = DB::table('gen5_matches')->where('status', 'live')->where('ends_at', '<=', now())->pluck('id');
        foreach ($ids as $id) {
            DB::transaction(function () use ($id) {
                $match = DB::table('gen5_matches')->where('id', $id)->lockForUpdate()->first();
                $this->finishIfDue($match);
            });
        }
    }

    private function eligiblePlayers(object $match)
    {
        return DB::table('gen5_players as p')->join('users as u', 'u.id', '=', 'p.user_id')
            ->join('learning_enrollments as e', fn ($join) => $join->on('e.user_id', '=', 'p.user_id')->where('e.course_id', $match->course_id))
            ->where('p.match_id', $match->id)->where('e.status', 'active')->where('u.status', 'Active')->where('u.role', 'student');
    }

    private function finishIfDue(object $match): void
    {
        if ($match->status === 'live' && now()->gte(Carbon::parse($match->ends_at))) {
            $this->finish($match);
        }
    }

    private function finish(object $match): void
    {
        $scores = $this->scores(json_decode($match->board, true));
        $match->status = 'finished';
        $match->score_one = $scores[1];
        $match->score_two = $scores[2];
        $match->winner = $scores[1] === $scores[2] ? 0 : ($scores[1] > $scores[2] ? 1 : 2);
        $match->finished_at = now()->format('Y-m-d H:i:s.v');
        $this->event($match, 'finished');
        $this->persist($match);
    }

    private function scores(array $board): array
    {
        $scores = [1 => 0, 2 => 0];
        foreach ($board as $building) {
            if ($building['height'] === self::BUILD_HEIGHT) {
                $scores[$building['team']]++;
            }
        }

        return $scores;
    }

    private function event(object $match, string $type, ?int $team = null, ?string $name = null): void
    {
        $events = json_decode($match->events, true);
        array_unshift($events, ['type' => $type, 'team' => $team, 'name' => $name, 'at' => now()->getTimestampMs()]);
        $match->events = json_encode(array_slice($events, 0, 12));
    }

    private function persist(object $match): void
    {
        $match->revision++;
        DB::table('gen5_matches')->where('id', $match->id)->update([
            'status' => $match->status, 'board' => $match->board, 'events' => $match->events, 'revision' => $match->revision,
            'started_at' => $match->started_at, 'ends_at' => $match->ends_at, 'finished_at' => $match->finished_at,
            'winner' => $match->winner, 'score_one' => $match->score_one, 'score_two' => $match->score_two, 'updated_at' => now(),
        ]);
    }
}
