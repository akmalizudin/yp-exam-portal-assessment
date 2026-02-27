# Online Examination & Student Management Portal

A role-based portal for online examination and student management built with Laravel 11 and Breeze.

## Tech Stack
- Laravel 11
- Laravel Breeze (Blade)
- SQLite (default local setup)
- Tailwind CSS

## Requirement Coverage

### Core Features
1. Roles (Lecturer, Student)
- Implemented using `role` enum and role middleware (`role:lecturer`, `role:student`).

2. Authentication
- Implemented with Laravel Breeze (register, login, logout, password flow).

3. Exam Creation (MCQ + Open Text)
- Lecturer can create exams.
- Lecturer can add/edit/delete questions of type `mcq` and `open_text`.

4. Class Management
- Students are assigned to classrooms (`users.classroom_id`).
- Lecturer classroom management UI is available.

5. Subject Management
- Subjects are linked to classrooms (`subjects.classroom_id`).
- Lecturer subject management UI is available.

6. Access Control by Class
- Students can only view/start exams for subjects in their own classroom.

7. Time Limit
- Exam attempt stores `started_at` and `expires_at`.
- Submission/access is blocked when attempt expires.

8. Additional Features
- Publish/unpublish exam.
- Publish is disabled when an exam has no questions.
- Lecturer result list and per-attempt detail view.
- Role-aware Home dashboard.

### Technical Requirements
1. Laravel 11 + Breeze
- Completed (`laravel/framework` v11.x, Breeze installed).

2. Database choice
- SQLite used by default for quick local setup.

3. Public GitHub repository
- Add your repository link below before submission:
- `https://github.com/<your-username>/<your-repo>`

4. README document
- This document is included.

## Local Setup (SQLite)
```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

Open: `http://127.0.0.1:8000`

## Seeded Accounts
Default password for all seeded users: `Password123!`

- Lecturer: `lecturer@test.com`
- Student: `akmal@test.com`
- Student: `student2@test.com`
- Student: `student3@test.com`
- Student: `student4@test.com`

## Quick Demo Flow

### Lecturer flow
1. Log in as `lecturer@test.com`.
2. Go to **Home**.
3. Open **Manage Classrooms** and **Manage Subjects** (optional data setup).
4. Open **Go to My Exams** and create an exam.
5. Manage questions (MCQ/open-text).
6. Publish the exam.
7. Open **View Results** after student submission.
8. Review seeded draft scenarios:
   - `Draft Exam With Questions` (unpublished)
   - `Draft Exam No Questions` (unpublished, publish disabled until questions are added)

### Student flow
1. Log in as `akmal@test.com`.
2. Open Exams page.
3. Start an available exam.
4. Answer questions and submit before time expires.

## Seeded Exam Data
- `Basic Web Development Quiz` (published)
- `Draft Exam With Questions` (unpublished)
- `Draft Exam No Questions` (unpublished)

## Tests
```bash
php artisan test
```

## Notes
- Recommended PHP version: **8.4** for clean output.
- If running on PHP 8.5, you may see upstream vendor deprecation notices in some environments.

## Author
- Akmal Izudin
- GitHub: `https://github.com/akmalizudin`
