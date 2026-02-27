<x-app-layout>
    <div class="bg-white p-6 shadow rounded" style="margin: 1rem">

        <div class="mb-2 flex items-center justify-between">
            <h2 class="text-xl font-bold">
                Questions for: {{ $exam->title }}
            </h2>

            <a href="{{ route('lecturer.questions.create', $exam) }}" class="px-4 py-2 rounded inline-block"
                style="background-color: #1d4ed8; color: #ffffff">
                Add Question
            </a>
        </div>

        <a href="{{ route('lecturer.exams.index') }}" class="text-sm underline">
            <- Back to My Exams </a>

                <div class="mt-4">
                    @forelse ($exam->questions as $question)
                        <div class="border p-4 mb-4">
                            <p><strong>{{ $question->question_text }}</strong>
                                ({{ $question->type === 'mcq' ? 'Multiple Choice' : 'Short Answer' }})
                                ({{ $question->marks }} marks)
                            </p>

                            <div class="mb-2 inline-flex items-center gap-2 text-sm">
                                <a href="{{ route('lecturer.questions.edit', $question) }}" class="underline">
                                    Edit
                                </a>
                                <span class="text-gray-400">/</span>
                                <form method="POST" action="{{ route('lecturer.questions.destroy', $question) }}"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="underline">Delete</button>
                                </form>
                            </div>

                            @if ($question->type === 'mcq')
                                <ul class="list-disc ml-2">
                                    @foreach ($question->options as $option)
                                        <li>
                                            - {{ $option->option_text }}
                                            @if ($option->is_correct)
                                                <b>(Correct Answer)</b>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @empty
                        <div class="border rounded p-4 text-gray-600">
                            No questions yet.
                        </div>
                    @endforelse
                </div>

    </div>
</x-app-layout>
