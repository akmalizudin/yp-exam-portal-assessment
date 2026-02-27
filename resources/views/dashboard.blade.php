<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div>
        <div class="shadow rounded" style="margin: 1rem; background-color: #eff6ff;">
            @php
                $user = auth()->user();
                $classroomName = $user?->classroom?->name ?? 'Not assigned yet';
            @endphp

            <div class="overflow-hidden shadow-sm sm:rounded-lg p-6" style="background-color: #ffffff;">
                <p class="text-gray-700 mb-6">
                    Welcome back, <span class="font-semibold">{{ $user->name }}</span>.
                </p>

                @if ($user->isLecturer())
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="border rounded p-4" style="border-color: #bfdbfe;">
                            <h3 class="font-semibold text-lg">Exams</h3>
                            <p class="text-sm text-gray-600 mt-1">Create, manage questions, publish, and review results.</p>
                            <a href="{{ route('lecturer.exams.index') }}"
                                class="mt-4 inline-block px-4 py-2 rounded text-sm"
                                style="background-color: #1d4ed8; color: #ffffff;">
                                Go to My Exams
                            </a>
                        </div>

                        <div class="border rounded p-4" style="border-color: #bfdbfe;">
                            <h3 class="font-semibold text-lg">Class & Subject</h3>
                            <p class="text-sm text-gray-600 mt-1">Manage classrooms, student grouping, and subjects.</p>
                            <a href="{{ route('lecturer.classrooms.index') }}"
                                class="mt-4 mr-2 inline-block px-4 py-2 rounded text-sm"
                                style="background-color: #1d4ed8; color: #ffffff;">
                                Manage Classrooms
                            </a>
                            <a href="{{ route('lecturer.subjects.index') }}"
                                class="mt-4 inline-block px-4 py-2 rounded text-sm"
                                style="background-color: #1d4ed8; color: #ffffff;">
                                Manage Subjects
                            </a>
                        </div>
                    </div>
                @elseif ($user->isStudent())
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="border rounded p-4" style="border-color: #bfdbfe;">
                            <h3 class="font-semibold text-lg">Exams</h3>
                            <p class="text-sm text-gray-600 mt-1">View available exams and continue attempts.</p>
                            <a href="{{ route('student.exams.index') }}"
                                class="mt-4 inline-block px-4 py-2 rounded text-sm"
                                style="background-color: #1d4ed8; color: #ffffff;">
                                Go to Exams
                            </a>
                        </div>

                        <div class="border rounded p-4" style="border-color: #bfdbfe;">
                            <h3 class="font-semibold text-lg">Classroom</h3>
                            <p class="text-sm text-gray-600 mt-1">Your class: {{ $classroomName }}</p>
                            <a href="{{ route('profile.edit') }}"
                                class="mt-4 inline-block px-4 py-2 rounded text-sm"
                                style="background-color: #1d4ed8; color: #ffffff;">
                                View Profile
                            </a>
                        </div>
                    </div>
                @else
                    <p class="text-gray-700">Your account role is not configured yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
