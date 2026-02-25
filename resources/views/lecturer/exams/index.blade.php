<x-app-layout>
    <div class="py-12">
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
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Time Limit</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exams as $exam)
                        <tr>
                            <td>{{ $exam->title }}</td>
                            <td>{{ $exam->subject->name }}</td>
                            <td>{{ $exam->time_limit_minutes }} mins</td>
                            <td>
                                {{ $exam->is_published ? 'Published' : 'Draft' }}
                            </td>
                            <td>
                                <a href="{{ route('lecturer.questions.index', $exam) }}" class="text-blue-600 underline">
                                    Manage Questions
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
