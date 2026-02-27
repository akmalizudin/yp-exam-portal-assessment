<x-app-layout>
    <div class=" mx-auto bg-white p-6 shadow rounded mt-6" style="margin: 1rem">
        <h2 class="text-xl font-bold mb-4">Edit Classroom</h2>

        <a href="{{ route('lecturer.classrooms.index') }}" class="underline text-sm">Back to Classrooms</a>

        <form method="POST" action="{{ route('lecturer.classrooms.update', $classroom) }}" class="mt-4">
            @csrf
            @method('PATCH')

            <div>
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $classroom->name) }}" class="border rounded w-full"
                    placeholder="Classroom name" required>
            </div>

            <div class="mb-4">
                <label>Code</label>
                <input type="text" name="code" value="{{ old('code', $classroom->code) }}" class="border rounded w-full"
                    placeholder="Classroom code" required>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('lecturer.classrooms.index') }}" class="px-4 py-2 rounded inline-block"
                    style="background-color: #dbeafe; color: #1e3a8a; border: 1px solid #bfdbfe;">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded" style="background-color: #1d4ed8; color: #ffffff">Update Classroom</button>
            </div>
        </form>
    </div>
</x-app-layout>
