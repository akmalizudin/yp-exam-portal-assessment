<x-app-layout>
    @php
        $isSubmitted = !is_null($attempt->submitted_at); //check the submitted time, to determine if exam is taken or not
    @endphp

    {{-- if exam taken, turn to read-only --}}
    @if (!$isSubmitted)
        <form method="POST" action="{{ route('student.exams.submit', $exam) }}">
            @csrf
    @endif
    <div>
        <div class="shadow rounded" style="margin: 1rem; background-color: #eff6ff;">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-semibold">{{ $exam->title }}</h2>
                        <p class="text-sm text-gray-600">Subject: {{ $exam->subject->name }}</p>
                    </div>
                    <a href="{{ route('student.exams.index') }}" class="text-sm underline"><- Back to Exams</a>
                </div>

                @if (session('error'))
                    <div class="rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 text-sm">
                    <div class="rounded border p-2">
                        <p class="text-gray-500">Started At</p>
                        <p class="font-medium">{{ optional($attempt->started_at)->format('d M Y, H:i') ?? '-' }}</p>
                    </div>
                    <div class="rounded border p-2">
                        <p class="text-gray-500">Expires At</p>
                        <p class="font-medium">{{ optional($attempt->expires_at)->format('d M Y, H:i') ?? '-' }}</p>
                    </div>
                    <div class="rounded border p-2">
                        <p class="text-gray-500">Status</p>
                        <p class="font-medium">
                            @if ($attempt->submitted_at)
                                Submitted
                            @else
                                In Progress
                            @endif
                        </p>
                    </div>
                    <div class="rounded border p-2">
                        <p class="text-gray-500">Time Remaining</p>
                        <p class="font-medium font-mono">
                            @if (!$attempt->submitted_at && $attempt->expires_at)
                                <span id="exam-countdown"
                                    data-expires-at="{{ $attempt->expires_at->timestamp * 1000 }}">
                                    --:--:--
                                </span>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>

                @if ($exam->description)
                    <div>
                        <h3 class="font-semibold mb-2">Description</h3>
                        <p class="text-gray-700">{{ $exam->description }}</p>
                    </div>
                @endif

                @if ($isSubmitted)
                    <div class="rounded border border-blue-200 bg-blue-50 px-4 py-3 text-blue-700 text-sm">
                        This exam has been submitted. Answers are read-only.
                    </div>
                @endif

                <div>
                    <h3 class="font-semibold mb-4">Questions</h3>

                    @if ($exam->questions->isEmpty())
                        <p class="text-gray-600">No questions available for this exam yet.</p>
                    @else
                        <div>
                            @foreach ($exam->questions as $index => $question)
                                @php
                                    $savedAnswer = $attempt->answers->firstWhere('question_id', $question->id);
                                @endphp
                                <div class="rounded border p-4 mb-2">
                                    <p class="font-medium mb-2">Q{{ $index + 1 }}.
                                        {{ $question->question_text }}</p>

                                    @if ($question->options->isNotEmpty())
                                        @foreach ($question->options as $option)
                                            <div>
                                                <label>
                                                    <input type="radio" name="answers[{{ $question->id }}]"
                                                        value="{{ $option->id }}"
                                                        @if ($savedAnswer && (int) $savedAnswer->selected_option_id === (int) $option->id) checked @endif
                                                        @if ($isSubmitted) disabled @else required @endif>
                                                    {{ $option->option_text }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <textarea name="answers[{{ $question->id }}]" rows="4" class="w-full resize-none border rounded px-3 py-2"
                                            placeholder="Type your answer here..." @if ($isSubmitted) readonly @else required @endif>{{ $savedAnswer?->text_answer }}</textarea>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                @unless ($isSubmitted)
                    <div>
                        <button type="submit" class="px-4 py-2 rounded" style="background-color: #1d4ed8; color: #ffffff">
                            Submit Exam
                        </button>
                    </div>
                @endunless
            </div>
        </div>
    </div>
    @if (!$isSubmitted)
        </form>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countdownElement = document.getElementById('exam-countdown');

            if (!countdownElement) {
                return;
            }

            const formatRemaining = (ms) => {
                const totalSeconds = Math.floor(ms / 1000);
                const hours = Math.floor(totalSeconds / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;

                return [hours, minutes, seconds]
                    .map((value) => String(value).padStart(2, '0'))
                    .join(':');
            };

            const tick = () => {
                const expiresAt = Number(countdownElement.dataset.expiresAt);
                const remaining = expiresAt - Date.now();

                if (remaining <= 0) {
                    countdownElement.textContent = '00:00:00';
                    countdownElement.classList.add('text-red-600');
                    return;
                }

                countdownElement.textContent = formatRemaining(remaining);
            };

            tick();
            setInterval(tick, 1000);
        });
    </script>
</x-app-layout>
