<x-app-layout>
    <div class=" mx-auto bg-white p-6 shadow rounded m-4" style="margin: 1rem">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-bold">Classroom Management</h2>
            <a href="{{ route('dashboard') }}" class="underline text-sm">Back to Home</a>
        </div>

        <form method="POST" action="{{ route('lecturer.classrooms.store') }}">
            <div class="flex flex-col items-center gap-2 mb-6">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Classroom name"
                    class="border rounded w-full" required>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="Classroom code"
                    class="border rounded w-full" required>
                <button type="submit" class="px-4 py-2 rounded" style="background-color: #1d4ed8; color: #ffffff; width: 250px;">Add Classroom</button>
            </div>
        </form>

        <table class="w-full border">
            <thead>
                <tr>
                    <th class="border p-2 text-start" style="background-color: #dbeafe">Name</th>
                    <th class="border p-2 text-start" style="background-color: #dbeafe">Code</th>
                    <th class="border p-2 text-start" style="background-color: #dbeafe">Students</th>
                    <th class="border p-2 text-start" style="background-color: #dbeafe">Subjects</th>
                    <th class="border p-2 text-start" style="background-color: #dbeafe">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($classrooms as $classroom)
                    <tr>
                        <td class="border p-2">{{ $classroom->name }}</td>
                        <td class="border p-2">{{ $classroom->code }}</td>
                        <td class="border p-2">{{ $classroom->students_count }}</td>
                        <td class="border p-2">{{ $classroom->subjects_count }}</td>
                        <td class="border p-2">
                            <div class="inline-flex items-center gap-2 text-sm">
                                <a href="{{ route('lecturer.classrooms.edit', $classroom) }}" class="underline">Edit</a>
                                <span class="text-gray-400">/</span>
                                <form method="POST" action="{{ route('lecturer.classrooms.destroy', $classroom) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="underline">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border p-2 text-center text-gray-500">No classrooms yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
