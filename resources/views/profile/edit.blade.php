<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="shadow rounded" style="margin: 1rem; background-color: #eff6ff;">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <div class="border rounded p-4">
                    <h3 class="text-lg font-medium text-gray-900">Account Summary</h3>
                    <div class="mt-4 space-y-2 text-sm text-gray-700">
                        <p><span class="font-semibold">Name:</span> {{ $user->name }}</p>
                        <p><span class="font-semibold">Email:</span> {{ $user->email }}</p>
                        <p><span class="font-semibold">Role:</span> {{ ucfirst($user->role->value) }}</p>
                        <p><span class="font-semibold">Classroom:</span>
                            {{ $user->classroom?->name ?? 'Not assigned yet' }}</p>
                    </div>
                </div>

            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="border rounded p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="border rounded p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="border rounded p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
