<x-app-layout>
    <div class="bg-white p-6 shadow rounded" style="margin: 1rem">

        <h2 class="text-xl font-bold">
            Result for: {{ $attempt->student->name }}
        </h2>

        <a href="{{ route('lecturer.exams.results', $exam) }}" class="text-sm underline">
            <- Back to Results </a>

                <p class="mb-4 mt-4">
                    Score: {{ $attempt->score }}
                </p>

                @foreach ($attempt->answers as $answer)
                    @php
                        $isCorrect =
                            $answer->question->type === 'mcq'
                                ? (bool) $answer->selectedOption?->is_correct
                                : $answer->awarded_marks > 0;
                    @endphp

                    <div
                        class="border p-4 mb-4 rounded {{ $isCorrect ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50' }}">
                        <p><strong>{{ $answer->question->question_text }}</strong></p>

                        @if ($answer->question->type === 'mcq')
                            <p>
                                Selected:
                                <span style="color: {{ $isCorrect ? '#e53e3e' : '#38a169' }}">
                                    {{ $answer->selectedOption?->option_text ?? '-' }}
                                </span>
                            </p>

                            <p>
                                Correct:
                                {{ $answer->question->options->where('is_correct', true)->first()?->option_text }}
                            </p>
                        @else
                            <p>
                                Answer:
                                <span style="color: {{ $isCorrect ? '#e53e3e' : '#38a169' }}">
                                    {{ $answer->text_answer }}
                                </span>
                            </p>
                        @endif

                        <p>Marks Awarded: {{ $answer->awarded_marks }}</p>
                    </div>
                @endforeach

    </div>
</x-app-layout>
