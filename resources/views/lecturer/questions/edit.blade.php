<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded mt-6">

        <h2 class="text-xl font-bold">Edit Question</h2>

        <a href="{{ route('lecturer.questions.index', $question->exam_id) }}" class="text-sm underline">
            <- Back to Questions </a>

                <form method="POST" action="{{ route('lecturer.questions.update', $question) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4 mt-4">
                        <label>Question:</label>
                        <textarea name="question_text" class="border rounded w-full" placeholder="Enter question text" required>{{ $question->question_text }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label>Marks:</label>
                        <input type="number" name="marks" value="{{ $question->marks }}" min="1" required
                            class="border rounded w-full" placeholder="Enter marks">
                    </div>

                    @if ($question->type === 'mcq')
                        <div class="mb-4">
                            <label>Options</label>

                            @foreach ($question->options as $index => $option)
                                <div class="flex items-center gap-2 mb-2">
                                    <input type="radio" name="correct_option" value="{{ $option->id }}"
                                        {{ $option->is_correct ? 'checked' : '' }}>

                                    <input type="text" name="options[{{ $option->id }}]"
                                        value="{{ $option->option_text }}" class="border rounded w-full"
                                        placeholder="Enter option {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex items-center gap-2">
                        <a href="{{ route('lecturer.questions.index', $question->exam_id) }}"
                            class="px-4 py-2 rounded inline-block" style="background-color: #d3d3d3ab">
                            Cancel
                        </a>

                        <button type="submit" class="px-4 py-2 rounded" style="background-color: #d3d3d3ab">
                            Update Question
                        </button>
                    </div>

                </form>

    </div>
</x-app-layout>
