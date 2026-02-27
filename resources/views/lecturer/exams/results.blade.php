<x-app-layout>
    <div class="bg-white shadow rounded" style="margin: 1rem">
        <div class=" mx-auto bg-white p-6 shadow rounded">

            <h2 class="text-xl font-bold mb-3">
                Results: {{ $exam->title }}
            </h2>

            <a href="{{ route('lecturer.exams.index') }}" class="text-sm underline">
                <- Back to My Exams </a>

                    <table class="w-full mt-6 border">
                        <thead>
                            <tr>
                                <th class="border p-2 text-start" style="background-color: lightgray">Student</th>
                                <th class="border p-2 text-start" style="background-color: lightgray">Email</th>
                                <th class="border p-2 text-start" style="background-color: lightgray">Score</th>
                                <th class="border p-2 text-start" style="background-color: lightgray">Status</th>
                                <th class="border p-2 text-start" style="background-color: lightgray">Submitted At</th>
                                <th class="border p-2 text-start" style="background-color: lightgray">Time Taken To Complete</th>
                                <th class="border p-2 text-start" style="background-color: lightgray">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attempts as $attempt)
                                @php
                                    $status = 'In Progress';
                                    if ($attempt->submitted_at) {
                                        $status = 'Submitted';
                                    } elseif ($attempt->expires_at && now()->greaterThan($attempt->expires_at)) {
                                        $status = 'Expired';
                                    }
                                @endphp
                                <tr>
                                    <td class="border p-2">{{ $attempt->student->name }}</td>
                                    <td class="border p-2">{{ $attempt->student->email }}</td>
                                    <td class="border p-2">
                                        {{ $attempt->score ?? '-' }}
                                    </td>
                                    <td class="border p-2">{{ $status }}</td>
                                    <td class="border p-2">
                                        {{ $attempt->submitted_at?->format('Y-m-d H:i') ?? '-' }}
                                    </td>
                                    <td class="border p-2">
                                        @if ($attempt->submitted_at && $attempt->started_at)
                                            {{ $attempt->submitted_at->diffForHumans($attempt->started_at, true) }}
                                        @elseif($attempt->expires_at && now()->greaterThan($attempt->expires_at))
                                            {{ $attempt->expires_at->diffForHumans($attempt->started_at, true) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="border p-2">
                                        <a class="underline text-blue-600"
                                            href="{{ route('lecturer.exams.results.show', [$exam, $attempt]) }}">
                                            View
                                        </a>
                                    </td>
                            @endforeach

                            @if ($attempts->isEmpty())
                                <tr>
                                    <td class="border p-2" colspan="5">No attempts yet.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

        </div>
    </div>
</x-app-layout>
