<?php

namespace App\Http\Controllers;

use App\Services\Gen5Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Gen5Controller extends Controller
{
    public function index(Request $request, Gen5Game $game)
    {
        $game->expire();
        $admin = $request->user()->role === 'admin';
        $matches = DB::table('gen5_matches as m')->join('learning_courses as c', 'c.id', '=', 'm.course_id')
            ->select('m.*', 'c.title as course_title', 'c.code as course_code')
            ->selectSub(DB::table('gen5_players')->selectRaw('COUNT(*)')->whereColumn('match_id', 'm.id'), 'player_count');
        if (! $admin) {
            $matches->where('c.status', '!=', 'archived')->whereExists(fn ($q) => $q->selectRaw('1')->from('learning_enrollments as e')
                ->whereColumn('e.course_id', 'm.course_id')->where('e.user_id', $request->user()->id)->where('e.status', 'active'));
        }
        $matches = $matches->orderByDesc('m.id')->paginate(12);
        $courses = $admin ? DB::table('learning_courses')->where('status', '!=', 'archived')->orderBy('title')->get() : collect();

        return view('gen5.index', compact('matches', 'courses', 'admin'));
    }

    public function store(Request $request, Gen5Game $game)
    {
        $data = $request->validate([
            'course_id' => 'required|integer|exists:learning_courses,id',
            'title' => 'required|string|max:160', 'team_one' => 'required|string|max:60|different:team_two',
            'team_two' => 'required|string|max:60', 'duration_minutes' => 'required|integer|min:1|max:60',
        ]);
        $id = $game->create($request->user(), $data);

        return redirect()->route('admin.gen5.show', $id)->with('success', 'GEN5 lobby created. Students can now join from GEN5.');
    }

    public function show(Request $request, Gen5Game $game, int $match)
    {
        $initial = $game->snapshot($request->user(), $match);
        $course = DB::table('learning_courses')->find($game->find($match)->course_id);
        $admin = $request->user()->role === 'admin';
        $screen = $request->routeIs('admin.gen5.screen');

        return response()->view('gen5.arena', compact('initial', 'course', 'admin', 'screen'))
            ->header('Cache-Control', 'private, no-store');
    }

    public function state(Request $request, Gen5Game $game, int $match)
    {
        return response()->json($game->snapshot($request->user(), $match))->header('Cache-Control', 'private, no-store');
    }

    public function join(Request $request, Gen5Game $game, int $match)
    {
        $game->join($request->user(), $match);
        if ($request->expectsJson()) {
            return $this->state($request, $game, $match);
        }

        return redirect()->route('gen5.show', $match)->with('success', 'Your team is ready. Wait for the administrator to start the match.');
    }

    public function action(Request $request, Gen5Game $game, int $match)
    {
        $data = $request->validate([
            'action' => 'required|in:move,build,attack',
            'x' => 'required|integer|min:0|max:'.(Gen5Game::WIDTH - 1),
            'y' => 'required|integer|min:0|max:'.(Gen5Game::HEIGHT - 1),
        ]);
        $result = $game->act($request->user(), $match, $data);

        return response()->json(['state' => $game->snapshot($request->user(), $match)] + $result, $result['code'] ?? 200)
            ->header('Cache-Control', 'private, no-store');
    }

    public function control(Request $request, Gen5Game $game, int $match)
    {
        $data = $request->validate(['action' => 'required|in:start,finish,cancel']);
        $result = $game->control($match, $data['action']);
        if ($request->expectsJson()) {
            return response()->json(['state' => $game->snapshot($request->user(), $match)] + $result, $result['code'] ?? 200);
        }
        if (isset($result['error'])) {
            return back()->withErrors(['match' => $result['error']]);
        }

        return back()->with('success', 'GEN5 match updated.');
    }

    public function assign(Request $request, Gen5Game $game, int $match, int $player)
    {
        $data = $request->validate(['team' => 'required|integer|in:1,2']);
        $game->assign($match, $player, (int) $data['team']);

        return $this->state($request, $game, $match);
    }
}
