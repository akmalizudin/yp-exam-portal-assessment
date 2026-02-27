<x-app-layout>
    <div class="bg-white shadow rounded" style="margin: 1rem">
        <div class="max-w-6xl mx-auto bg-white p-6 shadow rounded">

            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-bold">My Exams</h2>

                <a href="{{ route('lecturer.exams.create') }}" class="px-4 py-2 rounded inline-block"
                    style="background-color: #d3d3d3ab">
                    Create Exam
                </a>
            </div>

            <table class="w-full mt-6 border">
                <thead>
                    <tr>
                        <th class="border p-2 text-start" style="background-color: lightgray">Date & Time</th>
                        <th class="border p-2 text-start" style="background-color: lightgray">Title</th>
                        <th class="border p-2 text-start" style="background-color: lightgray">Subject</th>
                        <th class="border p-2 text-start" style="background-color: lightgray">Time Limit</th>
                        <th class="border p-2 text-start" style="background-color: lightgray">Status</th>
                        <th class="border p-2 text-start" style="background-color: lightgray">Actions</th>
                        {{-- <th class="border p-2 text-start" style="background-color: lightgray">Manage</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exams as $exam)
                        <tr>
                            <td class="border p-2">{{ $exam->created_at->format('Y-m-d H:i') }}</td>
                            <td class="border p-2">{{ $exam->title }}</td>
                            <td class="border p-2">{{ $exam->subject->name }}</td>
                            <td class="border p-2">{{ $exam->time_limit_minutes }} mins</td>
                            <td class="border p-2">
                                {{ $exam->is_published ? 'Published' : 'Draft' }}
                            </td>
                            <td class="border p-2">
                                <div class="inline-flex flex-wrap items-center gap-2 text-sm">
                                    <a href="{{ route('lecturer.questions.index', $exam) }}"
                                        class="underline hover:no-underline">
                                        Manage Questions
                                    </a>

                                    <span class="text-gray-400">/</span>

                                    <a class="underline hover:no-underline"
                                        href="{{ route('lecturer.exams.results', $exam) }}">
                                        View Results
                                    </a>

                                    <span class="text-gray-400">/</span>

                                    <form method="POST" action="{{ route('lecturer.exams.toggle', $exam) }}"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="underline hover:no-underline"
                                            style="color: {{ $exam->is_published ? '#e53e3e' : '#38a169' }}">
                                            {{ $exam->is_published ? 'Unpublish' : 'Publish' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
