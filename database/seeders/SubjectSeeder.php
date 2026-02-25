<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $class = Classroom::where('code', 'A2026')->first();

        if (!$class) {
            return;
        }

        $class->subjects()->firstOrCreate(
            ['name' => 'Web Programming'],
            ['description' => 'Introduction to web development']
        );

        $class->subjects()->firstOrCreate(
            ['name' => 'Mathematics'],
            ['description' => 'Fundamental concepts of mathematics']
        );
    }
}
