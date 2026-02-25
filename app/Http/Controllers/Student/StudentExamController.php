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

        $exams = Exam::with(['subject', 'attempts'])
            ->where('is_published', true)
            ->whereHas('subject', function ($query) use ($user) {
                $query->where('classroom_id', $user->classroom_id);
            })
            ->get();

        return view('student.exams.index', compact('exams'));
    }
}
