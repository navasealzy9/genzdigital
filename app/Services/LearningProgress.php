<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LearningProgress
{
    public function forStudent(int $courseId, int $userId): array
    {
        $lessons = DB::table('learning_lessons')->where('course_id', $courseId)->where('published', true)->pluck('id');
        $completed = DB::table('learning_completions')->where('user_id', $userId)->whereIn('lesson_id', $lessons)->count();
        $assignments = DB::table('learning_assignments')->where('course_id', $courseId)->where('published', true)->get();
        $submissions = DB::table('learning_submissions')->where('user_id', $userId)->whereIn('assignment_id', $assignments->pluck('id'))->get()->keyBy('assignment_id');
        $passedAssignments = $assignments->filter(fn ($a) => isset($submissions[$a->id]) && $submissions[$a->id]->graded_at && $submissions[$a->id]->score >= $a->pass_score)->count();
        $quizzes = DB::table('learning_quizzes')->where('course_id', $courseId)->where('published', true)->pluck('id');
        $passedQuizzes = DB::table('learning_attempts')->where('user_id', $userId)->whereIn('quiz_id', $quizzes)->whereNotNull('submitted_at')->where('passed', true)->distinct()->count('quiz_id');
        $total = $lessons->count() + $assignments->count() + $quizzes->count();
        $done = $completed + $passedAssignments + $passedQuizzes;

        return [
            'lessons' => $lessons->count(), 'completed_lessons' => $completed,
            'assignments' => $assignments->count(), 'passed_assignments' => $passedAssignments,
            'quizzes' => $quizzes->count(), 'passed_quizzes' => $passedQuizzes,
            'percentage' => $total ? (int) floor($done * 100 / $total) : 0,
            'eligible' => $lessons->isNotEmpty() && $done === $total,
        ];
    }
}
