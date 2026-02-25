<x-app-layout>
    <div class="p-4">
        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">

            <h2 class="text-xl font-bold mb-4">Create Exam</h2>

            <form method="POST" action="{{ route('lecturer.exams.store') }}">
                @csrf

                <div class="mb-4">
                    <label>Subject <span class="text-red-600">*</span></label>
                    <select name="subject_id" required class="border rounded w-full">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label>Title <span class="text-red-600">*</span></label>
                    <input type="text" name="title" required placeholder="e.g., Midterm Exam - Algebra" class="border rounded w-full">
                </div>

                <div class="mb-4">
                    <label>Description</label>
                    <textarea name="description" placeholder="Optional: Add exam instructions or notes" class="border rounded w-full"></textarea>
                </div>

                <div class="mb-4">
                    <label>Time Limit (minutes) <span class="text-red-600">*</span></label>
                    <input type="number" name="time_limit_minutes" min="1" required placeholder="e.g., 60" class="border rounded w-full">
                </div>

                <button type="submit" class="px-4 py-2 rounded" style="background-color: #d3d3d3ab">
                    Save Exam
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
