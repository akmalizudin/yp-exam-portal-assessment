<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Subject;
use Illuminate\Http\Request;

class LecturerSubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('classroom')
            ->orderBy('name')
            ->get();

        $classrooms = Classroom::orderBy('name')->get();

        return view('lecturer.subjects.index', compact('subjects', 'classrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Subject::create($validated);

        return redirect()
            ->route('lecturer.subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    public function edit(Subject $subject)
    {
        $classrooms = Classroom::orderBy('name')->get();

        return view('lecturer.subjects.edit', compact('subject', 'classrooms'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $subject->update($validated);

        return redirect()
            ->route('lecturer.subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()
            ->route('lecturer.subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}
