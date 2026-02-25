<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Exam;
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

        Exam::firstOrCreate(
            ['title' => 'HTML & CSS Quiz 1', 'subject_id' => $subject->id],
            [
                'created_by' => $lecturer->id,
                'description' => 'Basic HTML and CSS quiz',
                'time_limit_minutes' => 15,
                'is_published' => true,
            ]
        );
    }
}
