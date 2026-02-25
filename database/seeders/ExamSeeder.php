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
                'title' => 'Math Quiz 1',
                'subject_id' => $subject->id
            ],
            [
                'created_by' => $lecturer->id,
                'description' => 'Basic math quiz',
                'time_limit_minutes' => 15,
                'is_published' => true,
            ]
        );

        // MCQ Question
        $mcq = Question::create([
            'exam_id' => $exam->id,
            'question_text' => 'What does HTML stands for?',
            'type' => 'mcq',
            'marks' => 2,
        ]);

        $mcq->options()->createMany([
            ['option_text' => 'Hyper Text Markup Language', 'is_correct' => true],
            ['option_text' => 'High Tech Modern Language', 'is_correct' => false],
            ['option_text' => 'Home Tool Markup Language', 'is_correct' => false],
            ['option_text' => 'Hyperlink and Text Markup Language', 'is_correct' => false],
        ]);

        // Open Text Question
        Question::create([
            'exam_id' => $exam->id,
            'question_text' => 'Explain how to use CSS to style a webpage?',
            'type' => 'open_text',
            'marks' => 5,
        ]);
    }
}
