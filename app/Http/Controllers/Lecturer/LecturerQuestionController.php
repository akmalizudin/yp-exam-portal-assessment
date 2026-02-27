<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class LecturerQuestionController extends Controller
{
    public function index(Exam $exam)
    {
        $exam->load('questions.options');

        return view('lecturer.questions.index', compact('exam'));
    }

    public function create(Exam $exam)
    {
        return view('lecturer.questions.create', compact('exam'));
    }

    public function edit(Question $question)
    {
        $question->load('options');

        return view('lecturer.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $question->update([
            'question_text' => $request->question_text,
            'marks' => $request->marks,
        ]);

        if ($question->type === 'mcq') {

            foreach ($request->options as $optionId => $text) {

                $option = $question->options()->find($optionId);

                if ($option) {
                    $option->update([
                        'option_text' => $text,
                        'is_correct' => $optionId == $request->correct_option,
                    ]);
                }
            }
        }

        return redirect()
            ->route('lecturer.questions.index', $question->exam_id)
            ->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return back()->with('success', 'Deleted.');
    }

    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:mcq,open_text',
            'marks' => 'required|integer|min:1',
        ]);

        $question = Question::create([
            'exam_id' => $exam->id,
            'question_text' => $request->question_text,
            'type' => $request->type,
            'marks' => $request->marks,
        ]);

        if ($request->type === 'mcq') {

            $request->validate([
                'options' => 'required|array|min:2',
                'options.*' => 'required|string',
                'correct_option' => 'required|integer',
            ]);

            foreach ($request->options as $index => $optionText) {
                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct' => $index == $request->correct_option,
                ]);
            }
        }

        return redirect()
            ->route('lecturer.questions.index', $exam)
            ->with('success', 'Question added successfully.');
    }
}
