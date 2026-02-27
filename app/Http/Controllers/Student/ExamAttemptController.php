<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;

class ExamAttemptController extends Controller
{
    public function start(Request $request, Exam $exam)
    {
        $user = $request->user();

        if (!$user || !$user->isStudent()) {
            abort(403);
        }

        if (!$exam->is_published) {
            abort(403);
        }

        if ($exam->subject->classroom_id !== $user->classroom_id) {
            abort(403);
        }

        if ($exam->attemptFor($user)) {
            return redirect()->route('student.exams.show', $exam);
        }

        if ($exam->starts_at && now()->lt($exam->starts_at)) {
            return redirect()
                ->route('student.exams.index')
                ->with('error', 'Exam is not open yet.');
        }

        if ($exam->ends_at && now()->gt($exam->ends_at)) {
            return redirect()
                ->route('student.exams.index')
                ->with('error', 'Exam availability window has closed.');
        }

        ExamAttempt::create([
            'exam_id' => $exam->id,
            'student_id' => $user->id,
            'started_at' => now(),
            'expires_at' => now()->addMinutes($exam->time_limit_minutes),
        ]);

        return redirect()->route('student.exams.show', $exam);
    }
}
