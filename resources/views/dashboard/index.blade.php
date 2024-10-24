<x-app-layout>

    <x-slot name="meta_title">{{ __('messages.dashboard') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.dashboard') }}</x-slot>
    <x-slot name="title">{{ __('messages.dashboard') }}</x-slot>

    <x-slot name="header">
        <h2 class="my-2 lg:my-4 sm:mb-6 lg:mb-8 sm:px-2 font-bold">{{ __('messages.hello') .' '. $username }} !</h2>
    </x-slot>

    <div class="relative w-full max-w-md shadow-sm sm:rounded-lg bg-white dark:bg-gray-800">
        <div
            class="absolute top-0 sm:-top-2.5 right-0 sm:-right-2.5 w-10 h-10 flex items-center justify-center font-bold text-xs shadow-md sm:rounded-full {{ $color }} text-white {{ $tasks_total == 0 ? 'dark:text-black' : '' }}"
        >
            {{ round($progress) }}%
        </div>
        <div class="px-10 py-12 text-gray-900 dark:text-gray-100">
            <h3 class="mb-4 text-2xl font-semibold uppercase flex items-center justify-start">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 me-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                </svg>
                {{ __('messages.tasks') }}
            </h3>
            <div class="flex items-center justify-start space-x-2">
                <div class="py-2 px-4 sm:rounded-lg bg-gray-800 text-white dark:bg-white dark:text-black">
                    {{ __('messages.total') }}: <span class="font-bold">{{ $tasks_total }}</span>
                </div>
                <div class="py-2 px-4 sm:rounded-lg bg-pink-700 text-white">
                    {{ __('messages.opened') }}: <span class="font-bold">{{ $tasks_opened }}</span>
                </div>
                <div class="py-2 px-4 sm:rounded-lg bg-teal-600 text-white">
                    {{ __('messages.closed') }}: <span class="font-bold">{{ $tasks_closed }}</span>
                </div>
            </div>
        </div>
        <div class="{{ $progress < 100 ? 'sm:rounded-bl-lg' : 'sm:rounded-b-lg' }} bg-gray-200">
            <div class="block h-2 text-center font-bold {{ $progress < 100 ? 'sm:rounded-bl-lg' : 'sm:rounded-b-lg' }} {{ $color }} text-white" style="width:{{ round($progress) }}%"></div>
        </div>
    </div>

    <div class="bg-pink-600"></div>
    <div class="bg-orange-500"></div>
    <div class="bg-blue-500"></div><div class="bg-teal-500"></div>
</x-app-layout>
