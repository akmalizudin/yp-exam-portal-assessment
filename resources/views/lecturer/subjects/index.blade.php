<x-app-layout>
    <div class=" mx-auto bg-white p-6 shadow rounded mt-6" style="margin: 1rem">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-bold">Subject Management</h2>
            <a href="{{ route('dashboard') }}" class="underline text-sm">Back to Home</a>
        </div>

        <form method="POST" action="{{ route('lecturer.subjects.store') }}">
            <div class="flex flex-col items-center gap-2 mb-6">
                @csrf
                <select name="classroom_id" class="border rounded w-full" required>
                    <option value="">Select classroom</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" @selected(old('classroom_id') == $classroom->id)>
                            {{ $classroom->name }} ({{ $classroom->code }})
                        </option>
                    @endforeach
                </select>

                <input type="text" name="name" value="{{ old('name') }}" placeholder="Subject name"
                    class="border rounded w-full" required>

                <input type="text" name="description" value="{{ old('description') }}"
                    placeholder="Description (optional)" class="border rounded w-full">

                <button type="submit" class="px-4 py-2 rounded" style="background-color: #d3d3d3ab; width: 250px">Add
                    Subject</button>
            </div>


        </form>

        <table class="w-full border">
            <thead>
                <tr>
                    <th class="border p-2 text-start" style="background-color: lightgray">Subject</th>
                    <th class="border p-2 text-start" style="background-color: lightgray">Classroom</th>
                    <th class="border p-2 text-start" style="background-color: lightgray">Description</th>
                    <th class="border p-2 text-start" style="background-color: lightgray">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subjects as $subject)
                    <tr>
                        <td class="border p-2">{{ $subject->name }}</td>
                        <td class="border p-2">{{ $subject->classroom->name }} ({{ $subject->classroom->code }})</td>
                        <td class="border p-2">{{ $subject->description ?: '-' }}</td>
                        <td class="border p-2">
                            <div class="inline-flex items-center gap-2 text-sm">
                                <a href="{{ route('lecturer.subjects.edit', $subject) }}" class="underline">Edit</a>
                                <span class="text-gray-400">/</span>
                                <form method="POST" action="{{ route('lecturer.subjects.destroy', $subject) }}"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="underline">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border p-2 text-center text-gray-500">No subjects yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
