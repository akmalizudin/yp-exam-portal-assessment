<x-app-layout>
    <div>
        <div class="bg-white shadow rounded" style="margin: 1rem">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h2 class="text-xl font-semibold mb-4">Available Exams</h2>

                @if (session('error'))
                    <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full border">
                    <thead>
                        <tr>
                            <th class="border p-2 text-start" style="background-color: lightgray">Title</th>
                            <th class="border p-2 text-start" style="background-color: lightgray">Subject</th>
                            <th class="border p-2 text-start" style="background-color: lightgray">Available Window</th>
                            <th class="border p-2 text-start" style="background-color: lightgray">Exam Status</th>
                            <th class="border p-2 text-start" style="background-color: lightgray">Time Limit</th>
                            <th class="border p-2 text-start" style="background-color: lightgray">Attempt Status</th>
                            <th class="border p-2 text-start" style="background-color: lightgray">Time Left</th>
                            <th class="border p-2 text-start" style="background-color: lightgray">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exams as $exam)
                            @php
                                $attempt = $exam->attempts->first();
                                $isUpcoming = $exam->starts_at && now()->lt($exam->starts_at);
                                $isClosed = $exam->ends_at && now()->gt($exam->ends_at);
                                $isOpen = !$isUpcoming && !$isClosed;
                            @endphp
                            <tr>
                                <td class="border p-2">{{ $exam->title }}</td>
                                <td class="border p-2">{{ $exam->subject->name }}</td>
                                <td class="border p-2 text-sm">
                                    {{ $exam->starts_at?->format('Y-m-d H:i') ?? 'Anytime' }}
                                    -
                                    {{ $exam->ends_at?->format('Y-m-d H:i') ?? 'No end date' }}
                                </td>
                                <td class="border p-2">
                                    @if ($isUpcoming)
                                        Upcoming
                                    @elseif($isClosed)
                                        Closed
                                    @else
                                        Open
                                    @endif
                                </td>
                                <td class="border p-2">{{ $exam->time_limit_minutes }} mins</td>
                                <td class="border p-2">
                                    @if (!$attempt)
                                        Not Started
                                    @elseif(!$attempt->submitted_at)
                                        In Progress
                                    @else
                                        Completed
                                    @endif
                                </td>
                                <td class="border p-2">
                                    @if ($attempt && !$attempt->submitted_at && $attempt->expires_at)
                                        <span class="exam-countdown font-mono" data-expires-at="{{ $attempt->expires_at->timestamp * 1000 }}">
                                            --:--:--
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border p-2">
                                    @if (!$attempt)
                                        @if ($isOpen)
                                            <form method="POST" action="{{ route('student.exams.start', $exam) }}">
                                                @csrf
                                                <button type="submit">Start</button>
                                            </form>
                                        @elseif($isUpcoming)
                                            <span class="text-gray-500 text-sm">Not open yet</span>
                                        @else
                                            <span class="text-red-600 text-sm">Closed</span>
                                        @endif
                                    @else
                                        <a href="{{ route('student.exams.show', $exam) }}" class="underline">
                                            View
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countdownElements = document.querySelectorAll('.exam-countdown');

            if (!countdownElements.length) {
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
                const now = Date.now();

                countdownElements.forEach((element) => {
                    const expiresAt = Number(element.dataset.expiresAt);
                    const remaining = expiresAt - now;

                    if (remaining <= 0) {
                        element.textContent = '00:00:00';
                        element.classList.add('text-red-600');
                        return;
                    }

                    element.textContent = formatRemaining(remaining);
                });
            };

            tick();
            setInterval(tick, 1000);
        });
    </script>
</x-app-layout>
