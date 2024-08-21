<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 min-h-[40rem]">
        <!-- Page Heading -->
        <header class="max-w-3xl">
            <p class="mb-2 text-sm font-semibold text-blue-600">Setting</p>
            <h1 class="block text-2xl font-bold text-gray-800 sm:text-3xl dark:text-white">
                {{ __('Edit Profile') }}
            </h1>
        </header>
        <!-- End Page Heading -->

        <div class="py-5">
            <div class="max-w-7xl mx-auto space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                @if(auth()->user()->isUser())
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
