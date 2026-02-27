<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lecturer = User::where('role', UserRole::Lecturer)->first();
        $subject = Subject::first();

        if (!$lecturer || !$subject) {
            return;
        }

        $exam = Exam::firstOrCreate(
            [
                'title' => 'Basic Web Development Quiz',
                'subject_id' => $subject->id
            ],
            [
                'created_by' => $lecturer->id,
                'description' => 'Basic web development quiz',
                'time_limit_minutes' => 15,
                'is_published' => true,
            ]
        );

        $mcq = Question::updateOrCreate(
            ['exam_id' => $exam->id, 'question_text' => 'What does HTML stands for?'],
            ['type' => 'mcq', 'marks' => 2]
        );

        $mcq->options()->updateOrCreate(
            ['option_text' => 'Hyper Text Markup Language'],
            ['is_correct' => true]
        );
        $mcq->options()->updateOrCreate(
            ['option_text' => 'High Tech Modern Language'],
            ['is_correct' => false]
        );
        $mcq->options()->updateOrCreate(
            ['option_text' => 'Home Tool Markup Language'],
            ['is_correct' => false]
        );
        $mcq->options()->updateOrCreate(
            ['option_text' => 'Hyperlink and Text Markup Language'],
            ['is_correct' => false]
        );

        Question::updateOrCreate(
            ['exam_id' => $exam->id, 'question_text' => 'Explain how to use CSS to style a webpage?'],
            ['type' => 'open_text', 'marks' => 5]
        );

        // Unpublished exam with questions
        $draftWithQuestions = Exam::firstOrCreate(
            [
                'title' => 'Draft Exam With Questions',
                'subject_id' => $subject->id,
            ],
            [
                'created_by' => $lecturer->id,
                'description' => 'Draft exam containing at least one question.',
                'time_limit_minutes' => 20,
                'is_published' => false,
            ]
        );

        $draftQuestion = Question::updateOrCreate(
            ['exam_id' => $draftWithQuestions->id, 'question_text' => 'What does CSS stand for?'],
            ['type' => 'mcq', 'marks' => 2]
        );

        $draftQuestion->options()->updateOrCreate(
            ['option_text' => 'Cascading Style Sheets'],
            ['is_correct' => true]
        );
        $draftQuestion->options()->updateOrCreate(
            ['option_text' => 'Computer Style System'],
            ['is_correct' => false]
        );

        // Unpublished exam with no questions
        Exam::firstOrCreate(
            [
                'title' => 'Draft Exam No Questions',
                'subject_id' => $subject->id,
            ],
            [
                'created_by' => $lecturer->id,
                'description' => 'Draft exam intentionally left without questions.',
                'time_limit_minutes' => 20,
                'is_published' => false,
            ]
        );
    }
}
