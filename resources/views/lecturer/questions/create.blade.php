<x-app-layout>
    <div class="bg-white p-6 shadow rounded" style="margin: 1rem">

        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-bold">Add Question</h2>
            <a href="{{ route('lecturer.questions.index', $exam) }}" class="text-sm underline">
                <- Back to Question
            </a>
        </div>

        <form method="POST" action="{{ route('lecturer.questions.store', $exam) }}">
            @csrf

            <div class="mb-4">
                <label>Question Text <span class="text-red-600">*</span></label>
                <textarea name="question_text" class="border rounded w-full" placeholder="e.g., What is does HTML stands for?"
                    required></textarea>
            </div>

            <div class="mb-4">
                <label>Type <span class="text-red-600">*</span></label>
                <select name="type" id="questionType" class="border rounded w-full" required>
                    <option value="open_text">Open Text</option>
                    <option value="mcq">Multiple Choice</option>
                </select>
            </div>

            <div class="mb-4">
                <label>Marks <span class="text-red-600">*</span></label>
                <input type="number" name="marks" min="1" required class="border rounded w-full"
                    placeholder="e.g., 5">
            </div>

            <div id="mcqOptions" class="hidden">
                <label>Options</label>

                <div id="optionsContainer">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex gap-2 mb-2 items-center">
                            <input type="radio" name="correct_option" value="{{ $i }}">
                            <input type="text" name="options[]" class="border rounded w-full"
                                placeholder="Option {{ $i + 1 }}">
                        </div>
                    @endfor
                </div>
            </div>

            <button type="submit" class="px-4 py-2 rounded" style="background-color: #d3d3d3ab">
                Save Question
            </button>

        </form>

    </div>

    <script>
        document.getElementById('questionType').addEventListener('change', function() {
            const mcqDiv = document.getElementById('mcqOptions');
            if (this.value === 'mcq') {
                mcqDiv.classList.remove('hidden');
            } else {
                mcqDiv.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
