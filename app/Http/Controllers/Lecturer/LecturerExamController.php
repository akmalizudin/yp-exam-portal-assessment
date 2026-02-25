<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;

class LecturerExamController extends Controller
{
    public function index(Request $request)
    {
        $exams = Exam::where('created_by', $request->user()->id)
            ->with('subject')
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
        ]);

        Exam::create([
            'subject_id' => $request->subject_id,
            'created_by' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'time_limit_minutes' => $request->time_limit_minutes,
            'is_published' => false,
        ]);

        return redirect()->route('lecturer.exams.index')
            ->with('success', 'Exam created successfully.');
    }
}
