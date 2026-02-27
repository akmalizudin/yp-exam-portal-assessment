# YP Exam Portal Assessment

A role-based exam portal built with Laravel 11 + Breeze.

## Tech Stack
- Laravel 11
- Laravel Breeze (Blade)
- SQLite (default setup)
- Tailwind CSS

## Roles
- Lecturer
- Student

## Core Features Implemented
1. Authentication
- Secure login/registration using Laravel Breeze.

2. Role-Based Access Control
- Lecturer and student roles are enforced in routes using middleware.

3. Exam Creation & Management (Lecturer)
- Create exams by subject.
- Add questions (MCQ and open-text).
- Edit/delete questions.
- Publish/unpublish exams.

4. Class & Subject Structure
- Students belong to a classroom.
- Subjects belong to classrooms.

5. Access Control by Class
- Students only see/start exams whose subject belongs to their classroom.

6. Time-Limited Attempts
- Exam attempts have expiry based on exam time limit.
- Submission is blocked after expiry.

7. Results
- Lecturer can view exam attempts and per-student result details.

8. Dashboard
- Role-aware dashboard with quick actions for lecturer/student.

## Local Setup (SQLite)
```bash
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
npm install
npm run build
php artisan serve
```

## Seeded Accounts
Default password for all users: `Password123!`

- Lecturer: `lecturer@test.com`
- Student: `akmal@test.com`
- Student: `student2@test.com`
- Student: `student3@test.com`
- Student: `student4@test.com`

## Notes About PHP Version
This project targets Laravel 11 and works best on PHP 8.4 for clean output.

If you use PHP 8.5, you may see upstream vendor deprecation notices related to PDO MySQL constants in some environments. This does not affect core app functionality.

## Run Tests
```bash
php artisan test
```
