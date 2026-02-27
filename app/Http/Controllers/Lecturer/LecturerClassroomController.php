<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LecturerClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::withCount(['students', 'subjects'])
            ->orderBy('name')
            ->get();

        return view('lecturer.classrooms.index', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:classrooms,code'],
        ]);

        Classroom::create($validated);

        return redirect()
            ->route('lecturer.classrooms.index')
            ->with('success', 'Classroom created successfully.');
    }

    public function edit(Classroom $classroom)
    {
        return view('lecturer.classrooms.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('classrooms', 'code')->ignore($classroom->id),
            ],
        ]);

        $classroom->update($validated);

        return redirect()
            ->route('lecturer.classrooms.index')
            ->with('success', 'Classroom updated successfully.');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return redirect()
            ->route('lecturer.classrooms.index')
            ->with('success', 'Classroom deleted successfully.');
    }
}
