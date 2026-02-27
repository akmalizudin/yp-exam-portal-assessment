<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $class = Classroom::where('code', 'A2026')->first();

        // generate lecturer
        User::firstOrCreate(
            ['email' => 'lecturer@test.com'],
            [
                'name' => 'Sir Zakaria',
                'password' => Hash::make('Password123!'),
                'role' => UserRole::Lecturer,
                'classroom_id' => $class?->id,
            ]
        );

        // generate students
        // first fixed student
        User::firstOrCreate(
            ['email' => 'akmal@test.com'],
            [
                'name' => 'Akmal Izudin',
                'password' => Hash::make('Password123!'),
                'role' => UserRole::Student,
                'classroom_id' => $class?->id,
            ]
        );

        // Generate 3 more students
        for ($i = 2; $i <= 4; $i++) {
            User::firstOrCreate(
                ['email' => "student{$i}@test.com"],
                [
                    'name' => fake()->name(),
                    'password' => Hash::make('Password123!'),
                    'role' => UserRole::Student,
                    'classroom_id' => $class?->id,
                ]
            );
        }
    }
}
