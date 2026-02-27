<x-app-layout>
    <div class="p-4">
        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">

            <h2 class="text-xl font-bold mb-2">Create Exam</h2>

            <a href="{{ route('lecturer.exams.index') }}" class="text-sm underline">
                <- Back to My Exams
            </a>

            <form method="POST" action="{{ route('lecturer.exams.store') }}">
                @csrf

                <div class="mb-4 mt-4">
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
                    <input type="text" name="title" required placeholder="e.g., Midterm Exam - Algebra"
                        class="border rounded w-full">
                </div>

                <div class="mb-4">
                    <label>Description</label>
                    <textarea name="description" placeholder="Optional: Add exam instructions or notes" class="border rounded w-full"></textarea>
                </div>

                <div class="mb-4">
                    <label>Time Limit (minutes) <span class="text-red-600">*</span></label>
                    <input type="number" name="time_limit_minutes" min="1" required placeholder="e.g., 60"
                        class="border rounded w-full">
                </div>

                <div class="mb-4">
                    <label>Available From</label>
                    <input type="datetime-local" id="starts_at" name="starts_at" value="{{ old('starts_at') }}"
                        min="{{ now()->format('Y-m-d\\TH:i') }}"
                        class="border rounded w-full">
                </div>

                <div class="mb-4">
                    <label>Available Until</label>
                    <input type="datetime-local" id="ends_at" name="ends_at" value="{{ old('ends_at') }}"
                        min="{{ now()->format('Y-m-d\\TH:i') }}"
                        class="border rounded w-full">
                </div>

                <button type="submit" class="px-4 py-2 rounded" style="background-color: #1d4ed8; color: #ffffff">
                    Save Exam
                </button>
            </form>

        </div>
    </div>

    <script>
        // to set min date dynamic based on the start date
        document.addEventListener('DOMContentLoaded', function() {
            const startsAtInput = document.getElementById('starts_at');
            const endsAtInput = document.getElementById('ends_at');

            if (!startsAtInput || !endsAtInput) return;

            const syncEndsAtMin = () => {
                const baseMin = "{{ now()->format('Y-m-d\\TH:i') }}";
                const selectedStart = startsAtInput.value;
                const nextMin = selectedStart && selectedStart > baseMin ? selectedStart : baseMin;

                endsAtInput.min = nextMin;

                if (endsAtInput.value && endsAtInput.value < nextMin) {
                    endsAtInput.value = '';
                }
            };

            startsAtInput.addEventListener('change', syncEndsAtMin);
            syncEndsAtMin();
        });
    </script>
</x-app-layout>
