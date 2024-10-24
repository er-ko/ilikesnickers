<x-app-layout>

    <x-slot name="meta_title">{{ __('messages.profile') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.profile') }}</x-slot>
    <x-slot name="title">{{ __('messages.profile') }}</x-slot>

    <div class="grid gap-4 grid-cols-1 xl:grid-cols-3">
        <div class="xl:col-span-2 space-y-4">
            <div class="py-6 px-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="py-6 px-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="h-fit py-6 px-2 sm:p-4 bg-gray-50 dark:bg-black shadow sm:rounded-lg">
            <div class="max-w-xl xl:text-center">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
