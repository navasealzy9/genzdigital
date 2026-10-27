<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Gen5Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class Gen5Test extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $one;

    private User $two;

    private int $course;

    private int $match;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin', 'status' => 'Active']);
        $this->one = User::factory()->create(['role' => 'student', 'status' => 'Active']);
        $this->two = User::factory()->create(['role' => 'student', 'status' => 'Active']);
        $this->course = DB::table('learning_courses')->insertGetId(['title' => 'GEN5 class', 'code' => 'G5', 'instructor' => 'Instructor', 'status' => 'published']);
        foreach ([$this->one, $this->two] as $user) {
            DB::table('learning_enrollments')->insert(['course_id' => $this->course, 'user_id' => $user->id, 'status' => 'active']);
        }
        $this->match = app(Gen5Game::class)->create($this->admin, ['course_id' => $this->course, 'title' => 'City battle', 'team_one' => 'Emerald', 'team_two' => 'Coral', 'duration_minutes' => 1]);
    }

    private function ready(): void
    {
        $this->actingAs($this->one)->postJson('/gen5/'.$this->match.'/join')->assertOk();
        $this->actingAs($this->two)->postJson('/gen5/'.$this->match.'/join')->assertOk();
        $this->actingAs($this->admin)->postJson('/admin/gen5/'.$this->match.'/control', ['action' => 'start'])->assertOk();
    }

    private function act(User $user, string $action, int $x, int $y)
    {
        return $this->actingAs($user)->postJson('/gen5/'.$this->match.'/action', compact('action', 'x', 'y'));
    }

    public function test_only_admin_can_create_control_assign_and_project_matches(): void
    {
        $this->get('/admin/gen5')->assertRedirect('/login');
        $this->actingAs($this->one)->get('/admin/gen5')->assertForbidden();
        $this->postJson('/admin/gen5', [])->assertForbidden();
        $this->postJson('/admin/gen5/'.$this->match.'/control', ['action' => 'start'])->assertForbidden();
        $this->get('/admin/gen5/'.$this->match.'/screen')->assertForbidden();
        $this->actingAs($this->admin)->get('/admin/gen5')->assertOk()->assertSee('City battle');
        $this->get('/admin/gen5/'.$this->match)->assertOk()->assertSee('target="_blank"', false)->assertSee('/screen');
        $this->get('/admin/gen5/'.$this->match.'/screen')->assertOk()->assertSee('gen5-projector')->assertDontSee('admin-sidebar');
    }

    public function test_match_creation_validates_duration_and_prevents_two_open_games_for_a_class(): void
    {
        $this->actingAs($this->admin)->postJson('/admin/gen5', ['course_id' => $this->course, 'title' => 'New game', 'team_one' => 'A', 'team_two' => 'B', 'duration_minutes' => 0])->assertUnprocessable()->assertJsonValidationErrors('duration_minutes');
        $data = ['course_id' => $this->course, 'title' => 'New game', 'team_one' => 'A', 'team_two' => 'B', 'duration_minutes' => 5];
        $this->postJson('/admin/gen5', $data)->assertStatus(409);
        $this->postJson('/admin/gen5/'.$this->match.'/control', ['action' => 'cancel'])->assertOk();
        $this->post('/admin/gen5', $data)->assertRedirect();
        $this->assertDatabaseCount('gen5_matches', 2);
    }

    public function test_students_only_see_and_join_their_own_active_class_games(): void
    {
        $outsider = User::factory()->create(['role' => 'student', 'status' => 'Active']);
        $this->actingAs($outsider)->get('/gen5')->assertOk()->assertDontSee('City battle');
        $this->get('/gen5/'.$this->match)->assertForbidden();
        $this->postJson('/gen5/'.$this->match.'/join')->assertForbidden();
        $this->getJson('/gen5/'.$this->match.'/state')->assertForbidden();
        $this->actingAs($this->one)->get('/gen5')->assertOk()->assertSee('City battle');
        $this->get('/')->assertOk()->assertSee('GEN5');
        DB::table('learning_enrollments')->where('user_id', $this->one->id)->update(['status' => 'suspended']);
        $this->postJson('/gen5/'.$this->match.'/join')->assertForbidden();
    }

    public function test_automatic_balancing_idempotent_join_and_roster_lock_after_start(): void
    {
        $this->ready();
        $players = DB::table('gen5_players')->orderBy('id')->get();
        $this->assertSame(1, $players[0]->team);
        $this->assertSame(2, $players[1]->team);
        $this->actingAs($this->one)->postJson('/gen5/'.$this->match.'/join')->assertOk();
        $this->assertDatabaseCount('gen5_players', 2);
        $late = User::factory()->create(['role' => 'student', 'status' => 'Active']);
        DB::table('learning_enrollments')->insert(['course_id' => $this->course, 'user_id' => $late->id, 'status' => 'active']);
        $this->actingAs($late)->postJson('/gen5/'.$this->match.'/join')->assertStatus(409);
        $this->actingAs($this->admin)->postJson('/admin/gen5/'.$this->match.'/players/'.$players[0]->id.'/team', ['team' => 2])->assertStatus(409);
    }

    public function test_admin_can_assign_lobby_teams_but_start_requires_both_teams(): void
    {
        $this->actingAs($this->admin)->postJson('/admin/gen5/'.$this->match.'/control', ['action' => 'start'])->assertUnprocessable();
        $this->actingAs($this->one)->postJson('/gen5/'.$this->match.'/join')->assertOk();
        $player = DB::table('gen5_players')->first();
        $this->actingAs($this->admin)->postJson('/admin/gen5/'.$this->match.'/players/'.$player->id.'/team', ['team' => 2])->assertOk()->assertJsonPath('players.0.team', 2);
        $this->postJson('/admin/gen5/'.$this->match.'/control', ['action' => 'start'])->assertUnprocessable();
    }

    public function test_moves_allow_border_crossing_but_block_teleporting_spam_and_out_of_bounds(): void
    {
        $this->ready();
        $this->act($this->one, 'move', 10, 1)->assertUnprocessable();
        $this->act($this->one, 'move', 3, 1)->assertOk();
        $this->act($this->one, 'move', 4, 1)->assertStatus(429);
        $this->travel(1)->seconds();
        DB::table('gen5_players')->where('user_id', $this->one->id)->update(['x' => 9]);
        $this->act($this->one, 'move', 10, 1)->assertOk()->assertJsonPath('state.me.x', 10);
        $this->act($this->one, 'move', 20, 1)->assertUnprocessable()->assertJsonValidationErrors('x');
        $this->act($this->one, 'move', -1, 1)->assertUnprocessable();
    }

    public function test_three_build_actions_complete_one_building_and_shared_state_has_identical_score(): void
    {
        $this->ready();
        $this->act($this->one, 'build', 2, 1)->assertOk()->assertJsonPath('state.scores.1', 0);
        $this->act($this->one, 'build', 2, 1)->assertStatus(429);
        $this->travel(1)->seconds();
        $this->act($this->one, 'build', 2, 1)->assertOk();
        $this->travel(1)->seconds();
        $this->act($this->one, 'build', 2, 1)->assertOk()->assertJsonPath('state.scores.1', 1);
        $this->travel(1)->seconds();
        $this->act($this->one, 'build', 2, 1)->assertStatus(409);
        foreach ([$this->one, $this->two, $this->admin] as $user) {
            $this->actingAs($user)->getJson('/gen5/'.$this->match.'/state')->assertOk()->assertJsonPath('scores.1', 1)->assertJsonPath('scores.2', 0);
        }
    }

    public function test_players_cannot_build_in_enemy_territory_attack_home_or_act_remotely(): void
    {
        $this->ready();
        $this->act($this->one, 'build', 8, 1)->assertUnprocessable();
        DB::table('gen5_players')->where('user_id', $this->one->id)->update(['x' => 10]);
        $this->act($this->one, 'build', 10, 1)->assertUnprocessable();
        $this->act($this->one, 'attack', 10, 1)->assertUnprocessable();
        DB::table('gen5_players')->where('user_id', $this->one->id)->update(['x' => 2]);
        $this->act($this->one, 'build', 2, 1)->assertOk();
        $this->travel(1)->seconds();
        $this->act($this->one, 'attack', 2, 1)->assertUnprocessable();
    }

    public function test_enemy_can_damage_destroy_and_defender_can_repair_without_double_scoring(): void
    {
        $this->ready();
        for ($i = 0; $i < 3; $i++) {
            $this->act($this->one, 'build', 2, 1)->assertOk();
            $this->travel(1)->seconds();
        }
        DB::table('gen5_players')->where('user_id', $this->two->id)->update(['x' => 3, 'y' => 1]);
        $this->act($this->two, 'attack', 2, 1)->assertOk()->assertJsonPath('state.scores.1', 0)->assertJsonPath('state.buildings.0.height', 2);
        $this->act($this->one, 'build', 2, 1)->assertOk()->assertJsonPath('state.scores.1', 1);
        for ($i = 0; $i < 3; $i++) {
            $this->travel(1)->seconds();
            $this->act($this->two, 'attack', 2, 1)->assertOk();
        }
        $this->getJson('/gen5/'.$this->match.'/state')->assertJsonCount(0, 'buildings')->assertJsonPath('scores.1', 0);
    }

    public function test_deadline_freezes_score_and_persists_winner_even_if_an_action_arrives_late(): void
    {
        $this->ready();
        for ($i = 0; $i < 3; $i++) {
            $this->act($this->one, 'build', 2, 1)->assertOk();
            $this->travel(1)->seconds();
        }
        $this->travel(61)->seconds();
        $this->act($this->one, 'build', 3, 1)->assertStatus(409)->assertJsonPath('state.match.status', 'finished')->assertJsonPath('state.match.winner', 1);
        $this->assertDatabaseHas('gen5_matches', ['id' => $this->match, 'status' => 'finished', 'winner' => 1, 'score_one' => 1, 'score_two' => 0]);
        $this->actingAs($this->admin)->postJson('/admin/gen5/'.$this->match.'/control', ['action' => 'start'])->assertStatus(409);
        $this->assertDatabaseCount('learning_completions', 0);
        $this->assertDatabaseCount('learning_attempts', 0);
    }

    public function test_identical_final_scores_produce_a_draw_and_scheduler_finalizes_without_clients(): void
    {
        $this->ready();
        $this->travel(61)->seconds();
        $this->artisan('gen5:finish-expired')->assertSuccessful();
        $this->assertDatabaseHas('gen5_matches', ['id' => $this->match, 'status' => 'finished', 'winner' => 0, 'score_one' => 0, 'score_two' => 0]);
        $this->actingAs($this->admin)->get('/admin/gen5')->assertOk()->assertSee('ស្មើគ្នា');
    }

    public function test_lobby_cancelled_and_unjoined_students_cannot_act_or_change_another_players_identity(): void
    {
        $this->act($this->one, 'build', 2, 1)->assertStatus(409);
        $this->ready();
        $outsider = User::factory()->create(['role' => 'student', 'status' => 'Active']);
        DB::table('learning_enrollments')->insert(['course_id' => $this->course, 'user_id' => $outsider->id, 'status' => 'active']);
        $player = DB::table('gen5_players')->where('user_id', $this->one->id)->first();
        $this->actingAs($outsider)->postJson('/gen5/'.$this->match.'/action', ['action' => 'build', 'x' => 2, 'y' => 1, 'user_id' => $this->one->id, 'player_id' => $player->id, 'team' => 1])->assertForbidden();
        $this->actingAs($this->admin)->postJson('/admin/gen5/'.$this->match.'/control', ['action' => 'cancel'])->assertOk()->assertJsonPath('state.match.status', 'cancelled');
        $this->act($this->one, 'build', 2, 1)->assertStatus(409);
        $this->assertDatabaseHas('gen5_matches', ['id' => $this->match, 'winner' => null]);
    }

    public function test_suspension_or_archiving_revokes_access_to_a_running_match(): void
    {
        $this->ready();
        DB::table('learning_enrollments')->where('user_id', $this->one->id)->update(['status' => 'suspended']);
        $this->act($this->one, 'build', 2, 1)->assertForbidden();
        $this->getJson('/gen5/'.$this->match.'/state')->assertForbidden();
        DB::table('learning_courses')->where('id', $this->course)->update(['status' => 'archived']);
        $this->actingAs($this->two)->getJson('/gen5/'.$this->match.'/state')->assertForbidden();
    }

    public function test_generate_includes_the_entire_active_class_and_evenly_splits_more_than_eighty_students(): void
    {
        $extra = User::factory()->count(80)->create(['role' => 'student', 'status' => 'Active']);
        foreach ($extra as $user) {
            DB::table('learning_enrollments')->insert(['course_id' => $this->course, 'user_id' => $user->id, 'status' => 'active']);
        }
        $inactive = User::factory()->create(['role' => 'student', 'status' => 'Inactive']);
        $suspended = User::factory()->create(['role' => 'student', 'status' => 'Active']);
        foreach ([$inactive, $suspended, $this->admin] as $user) {
            DB::table('learning_enrollments')->insert(['course_id' => $this->course, 'user_id' => $user->id, 'status' => $user->id === $suspended->id ? 'suspended' : 'active']);
        }
        $outsider = User::factory()->create(['role' => 'student', 'status' => 'Active']);
        $this->actingAs($this->admin)->postJson('/admin/gen5/'.$this->match.'/generate-teams')->assertOk()->assertJsonCount(82, 'players');
        $players = DB::table('gen5_players')->where('match_id', $this->match)->get();
        $this->assertSame(41, $players->where('team', 1)->count());
        $this->assertSame(41, $players->where('team', 2)->count());
        $this->assertSame(82, $players->pluck('user_id')->unique()->count());
        $this->assertSame(82, $players->map(fn ($p) => $p->x.':'.$p->y)->unique()->count());
        foreach ([$inactive, $suspended, $this->admin, $outsider] as $user) {
            $this->assertDatabaseMissing('gen5_players', ['match_id' => $this->match, 'user_id' => $user->id]);
        }
        $ids = $players->pluck('id', 'user_id')->sortKeys()->all();
        $this->postJson('/admin/gen5/'.$this->match.'/generate-teams')->assertOk()->assertJsonCount(82, 'players');
        $this->assertSame($ids, DB::table('gen5_players')->where('match_id', $this->match)->pluck('id', 'user_id')->sortKeys()->all());
        $this->assertDatabaseCount('learning_enrollments', 85);
    }

    public function test_odd_class_sizes_keep_every_student_with_one_person_difference_and_generated_students_can_resume(): void
    {
        $third = User::factory()->create(['role' => 'student', 'status' => 'Active']);
        DB::table('learning_enrollments')->insert(['course_id' => $this->course, 'user_id' => $third->id, 'status' => 'active']);
        $this->actingAs($this->admin)->postJson('/admin/gen5/'.$this->match.'/generate-teams')->assertOk()->assertJsonCount(3, 'players');
        $counts = DB::table('gen5_players')->where('match_id', $this->match)->selectRaw('team, COUNT(*) as total')->groupBy('team')->pluck('total', 'team');
        $this->assertSame(1, abs($counts[1] - $counts[2]));
        $this->postJson('/admin/gen5/'.$this->match.'/control', ['action' => 'start'])->assertOk();
        $this->actingAs($third)->postJson('/gen5/'.$this->match.'/join')->assertOk()->assertJsonPath('me.user_id', $third->id);
        $this->assertDatabaseCount('gen5_players', 3);
    }

    public function test_only_admin_can_generate_and_running_teams_cannot_be_regenerated(): void
    {
        $this->actingAs($this->one)->postJson('/admin/gen5/'.$this->match.'/generate-teams')->assertForbidden();
        $this->ready();
        $before = DB::table('gen5_players')->get()->toJson();
        $this->actingAs($this->admin)->postJson('/admin/gen5/'.$this->match.'/generate-teams')->assertStatus(409);
        $this->assertSame($before, DB::table('gen5_players')->get()->toJson());
    }

    public function test_generating_with_too_few_students_does_not_erase_the_existing_lobby(): void
    {
        $this->actingAs($this->one)->postJson('/gen5/'.$this->match.'/join')->assertOk();
        DB::table('learning_enrollments')->where('user_id', $this->two->id)->update(['status' => 'suspended']);
        $this->actingAs($this->admin)->postJson('/admin/gen5/'.$this->match.'/generate-teams')->assertStatus(422);
        $this->assertDatabaseCount('gen5_players', 1);
    }

    public function test_snapshots_share_profile_avatars_and_names_without_private_account_information(): void
    {
        $this->one->update(['name' => 'Sok Dara', 'avatar' => 'uploads/avatars/dara.png']);
        $this->two->update(['avatar' => 'javascript:alert(1)']);
        $this->ready();
        $response = $this->actingAs($this->admin)->getJson('/gen5/'.$this->match.'/state')->assertOk()
            ->assertJsonPath('players.0.name', 'Sok Dara')->assertJsonPath('players.0.avatar', asset('uploads/avatars/dara.png'))
            ->assertJsonPath('players.1.avatar', null);
        $this->assertArrayNotHasKey('email', $response->json('players.0'));
        $this->assertArrayNotHasKey('password', $response->json('players.0'));
        $this->one->update(['avatar' => 'https://example.test/photo.jpg']);
        $this->getJson('/gen5/'.$this->match.'/state')->assertJsonPath('players.0.avatar', 'https://example.test/photo.jpg');
    }
}
