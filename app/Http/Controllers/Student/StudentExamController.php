<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class StudentExamController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $exams = Exam::with([
            'subject',
            'attempts' => fn($query) => $query->where('student_id', $user->id),
        ])
            ->where('is_published', true)
            ->whereHas('subject', function ($query) use ($user) {
                $query->where('classroom_id', $user->classroom_id);
            })
            ->get();

        return view('student.exams.index', compact('exams'));
    }

    public function show(\Illuminate\Http\Request $request, \App\Models\Exam $exam)
    {
        $user = $request->user();

        $attempt = $exam->attemptFor($user);

        if (!$attempt) {
            return redirect()->route('student.exams.index');
        }

        // block access only for in-progress attempts that are already expired
        if (!$attempt->submitted_at && $attempt->expires_at && now()->greaterThan($attempt->expires_at)) {
            return redirect()->route('student.exams.index')
                ->with('error', 'Exam time expired.');
        }

        $exam->load('questions.options');
        $attempt->load('answers');

        return view('student.exams.show', compact('exam', 'attempt'));
    }

    // to submit the exam attempt, calculate score, and save the answers
    public function submit(Request $request, Exam $exam)
    {
        $user = $request->user();
        $attempt = $exam->attemptFor($user);

        if (!$attempt || $attempt->submitted_at) {
            return redirect()->route('student.exams.index');
        }

        if ($attempt->expires_at && now()->greaterThan($attempt->expires_at)) {
            return redirect()->route('student.exams.index')
                ->with('error', 'Exam time expired.');
        }

        $totalScore = 0;

        foreach ($exam->questions as $question) {
            $answerInput = $request->input("answers.{$question->id}");

            $awardedMarks = 0;

            if ($question->type === 'mcq') {
                $correctOption = $question->options()->where('is_correct', true)->first();

                if ($correctOption && $answerInput == $correctOption->id) {
                    $awardedMarks = $question->marks;
                }
            }

            $attempt->answers()->create([
                'question_id' => $question->id,
                'selected_option_id' => $question->type === 'mcq' ? $answerInput : null,
                'text_answer' => $question->type === 'open_text' ? $answerInput : null,
                'awarded_marks' => $awardedMarks,
            ]);

            $totalScore += $awardedMarks;
        }

        $attempt->update([
            'score' => $totalScore,
            'submitted_at' => now(),
        ]);

        return redirect()->route('student.exams.index')
            ->with('success', 'Exam submitted successfully.');
    }
}
