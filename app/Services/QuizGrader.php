<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QuizGrader
{
    public function finish(int $id, array $answers = []): void
    {
        DB::transaction(function () use ($id, $answers) {
            $attempt = DB::table('learning_attempts')->where('id', $id)->lockForUpdate()->first();
            if (! $attempt || $attempt->submitted_at) {
                return;
            }
            $quiz = DB::table('learning_quizzes')->find($attempt->quiz_id);
            $questions = collect(json_decode($attempt->questions, true));
            // After expiry, grade only answers already saved before the deadline.
            if (now()->gte(Carbon::parse($attempt->expires_at))) {
                $answers = json_decode($attempt->answers ?? '{}', true);
            }
            $answers = array_intersect_key($answers, $questions->keyBy('id')->all());
            $earned = $questions->sum(fn ($q) => ($answers[$q['id']] ?? null) === $q['correct_option'] ? $q['points'] : 0);
            $percentage = round($earned * 100 / $attempt->total_points, 2);
            DB::table('learning_attempts')->where('id', $id)->update([
                'answers' => json_encode($answers), 'earned_points' => $earned, 'percentage' => $percentage,
                'passed' => $percentage >= $quiz->pass_percentage, 'submitted_at' => now(), 'updated_at' => now(),
            ]);
        });
    }

    public function expire(?int $userId = null): void
    {
        $query = DB::table('learning_attempts')->whereNull('submitted_at')->where('expires_at', '<=', now());
        if ($userId) {
            $query->where('user_id', $userId);
        }
        foreach ($query->pluck('id') as $id) {
            $this->finish($id);
        }
    }
}
