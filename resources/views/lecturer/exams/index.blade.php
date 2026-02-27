<x-app-layout>
    <div class="bg-white shadow rounded" style="margin: 1rem">
        <div class="mx-auto bg-white p-6 shadow rounded">

            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-bold">My Exams</h2>

                <a href="{{ route('lecturer.exams.create') }}" class="px-4 py-2 rounded inline-block"
                    style="background-color: #d3d3d3ab">
                    Create Exam
                </a>
            </div>

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

            <table class="w-full mt-6 border">
                <thead>
                    <tr>
                        <th class="border p-2 text-start" style="background-color: lightgray">Date & Time</th>
                        <th class="border p-2 text-start" style="background-color: lightgray">Title</th>
                        <th class="border p-2 text-start" style="background-color: lightgray">Subject</th>
                        <th class="border p-2 text-start" style="background-color: lightgray">Available Window</th>
                        <th class="border p-2 text-start" style="background-color: lightgray">No. of Questions</th>
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
                            <td class="border p-2 text-sm">
                                {{-- {{ $exam->starts_at?->format('Y-m-d H:i') ?? 'Anytime' }}
                                - --}}
                                {{ $exam->ends_at?->format('Y-m-d H:i') ?? 'No end date' }}
                            </td>
                            <td class="border p-2 {{ $exam->questions_count === 0 ? 'text-red-600 font-semibold' : '' }}">
                                {{ $exam->questions_count }}
                                {{-- @if ($exam->questions_count === 0)
                                    <span class="ml-2 rounded bg-amber-100 px-2 py-0.5 text-xs text-amber-700 font-normal">
                                        Add questions
                                    </span>
                                @endif --}}
                            </td>
                            <td class="border p-2">{{ $exam->time_limit_minutes }} mins</td>
                            <td class="border p-2">
                                {{ $exam->is_published ? 'Published' : 'Draft' }}
                            </td>
                            <td class="border p-2 whitespace-nowrap">
                                <div class="inline-flex items-center text-sm ">
                                    <a href="{{ route('lecturer.questions.index', $exam) }}"
                                        class="underline hover:no-underline whitespace-nowrap" style="padding-right: 5px">
                                        Manage Questions
                                    </a>

                                    <span class="mx-1 text-gray-400">/</span>

                                    <a class="underline hover:no-underline" style="padding-right: 5px; padding-left: 5px"
                                        href="{{ route('lecturer.exams.results', $exam) }}">
                                        View Results
                                    </a>

                                    <span class="mx-1 text-gray-400">/</span>

                                    <form method="POST" action="{{ route('lecturer.exams.toggle', $exam) }}"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')

                                        @php
                                            $cannotPublish = !$exam->is_published && $exam->questions_count === 0;
                                        @endphp

                                        <button type="submit" class="underline hover:no-underline disabled:no-underline"
                                            style="color: {{ $cannotPublish ? '#9ca3af' : ($exam->is_published ? '#e53e3e' : '#38a169') }}"
                                            @disabled($cannotPublish)
                                            title="{{ $cannotPublish ? 'Add at least one question before publishing' : '' }}">
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
