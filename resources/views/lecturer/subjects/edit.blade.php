<x-app-layout>
    <div class=" mx-auto bg-white p-6 shadow rounded mt-6" style="margin: 1rem">
        <h2 class="text-xl font-bold mb-4">Edit Subject</h2>

        <a href="{{ route('lecturer.subjects.index') }}" class="underline text-sm">Back to Subjects</a>

        <form method="POST" action="{{ route('lecturer.subjects.update', $subject) }}" class="mt-4">
            @csrf
            @method('PATCH')

            <div>
                <label>Classroom</label>
                <select name="classroom_id" class="border rounded w-full" required>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" @selected(old('classroom_id', $subject->classroom_id) == $classroom->id)>
                            {{ $classroom->name }} ({{ $classroom->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Subject Name</label>
                <input type="text" name="name" value="{{ old('name', $subject->name) }}" class="border rounded w-full"
                    placeholder="Subject name" required>
            </div>

            <div class="mb-4">
                <label>Description</label>
                <input type="text" name="description" value="{{ old('description', $subject->description) }}"
                    class="border rounded w-full" placeholder="Description (optional)">
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('lecturer.subjects.index') }}" class="px-4 py-2 rounded inline-block"
                    style="background-color: #d3d3d3ab">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded" style="background-color: #d3d3d3ab">Update Subject</button>
            </div>
        </form>
    </div>
</x-app-layout>
