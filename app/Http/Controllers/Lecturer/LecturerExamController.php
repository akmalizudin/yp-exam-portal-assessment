<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Subject;
use Illuminate\Http\Request;

class LecturerExamController extends Controller
{
    public function index(Request $request)
    {
        $exams = Exam::where('created_by', $request->user()->id)
            ->with('subject')
            ->withCount('questions')
            ->get();

        return view('lecturer.exams.index', compact('exams'));
    }

    public function create(Request $request)
    {
        // Only show subjects under lecturer's classroom(s)
        $subjects = Subject::all(); // simplify for now

        return view('lecturer.exams.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'required|integer|min:1',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
        ]);

        Exam::create([
            'subject_id' => $request->subject_id,
            'created_by' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'time_limit_minutes' => $request->time_limit_minutes,
            'starts_at' => $request->starts_at ?: null,
            'ends_at' => $request->ends_at ?: null,
            'is_published' => false,
        ]);

        return redirect()->route('lecturer.exams.index')
            ->with('success', 'Exam created successfully.');
    }

    public function results(Request $request, Exam $exam) //function to show exam results for lecturer
    {
        // return 403 if exam does not belong to the lecturer
        if ($exam->created_by !== $request->user()->id) {
            abort(403);
        }

        $attempts = ExamAttempt::with('student')
            ->where('exam_id', $exam->id)
            ->orderByDesc('submitted_at')
            ->get();

        return view('lecturer.exams.results', compact('exam', 'attempts'));
    }

    public function togglePublish(Request $request, Exam $exam)
    {
        if ($exam->created_by !== $request->user()->id) {
            abort(403);
        }

        // Only allow publishing if the exam has at least one question.
        if (!$exam->is_published && !$exam->questions()->exists()) {
            return back()->with('error', 'Cannot publish exam with no questions.');
        }

        $exam->update([
            'is_published' => !$exam->is_published,
        ]);

        return back()->with('success', 'Exam status updated.');
    }

    // to see detailed result of an exam attempt
    public function showResult(Request $request, Exam $exam, ExamAttempt $attempt)
    {
        if ($exam->created_by !== $request->user()->id) {
            abort(403);
        }

        if ($attempt->exam_id !== $exam->id) {
            abort(404);
        }

        $attempt->load('student', 'answers.question.options');

        return view(
            'lecturer.exams.result-detail',
            compact('exam', 'attempt')
        );
    }
}
