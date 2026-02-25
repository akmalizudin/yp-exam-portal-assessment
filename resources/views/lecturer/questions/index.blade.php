<x-app-layout>
    <div class="bg-white p-6 shadow rounded" style="margin: 1rem">

        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-bold">
                Questions for: {{ $exam->title }}
            </h2>

            <a href="{{ route('lecturer.questions.create', $exam) }}" class="px-4 py-2 rounded inline-block"
                style="background-color: #d3d3d3ab">
                Add Question
            </a>
        </div>

        <div class="mt-6">
            @foreach ($exam->questions as $question)
                <div class="border p-4 mb-4">
                    <p><strong>{{ $question->question_text }}</strong>
                        ({{ $question->type === 'mcq' ? 'Multiple Choice' : 'Short Answer' }})
                        ({{ $question->marks }} marks)
                    </p>

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
            @endforeach
        </div>

    </div>
</x-app-layout>
