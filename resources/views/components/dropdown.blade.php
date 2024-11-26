@props(['active', 'contentClasses' => 'bg-white dark:bg-gray-800'])

@php
$classes = ($active ?? false)
    ? 'w-full flex items-center justify-between p-4 sm:p-2 lg:p-4 mt-1 text-sm font-semibold text-gray-900 bg-gray-200 rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-900 dark:focus:bg-gray-900 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline'
    : 'w-full flex items-center justify-between p-4 sm:p-2 lg:p-4 mt-1 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-900/50 dark:focus:bg-gray-900 dark:focus:text-white dark:hover:text-white dark:text-gray-400 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline';
@endphp

<div class="relative" x-data="{ open: {{ $active ? 'true' : 'false' }} }">
    <button {{ $attributes->merge(['class' => $classes]) }} @click="open = !open">
        {{ $trigger }}
	</button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="w-full mt-1 origin-top-right"
    >
        <div class="bg-white dark:bg-gray-900">
            {{ $content }}
        </div>
    </div>
</div>
