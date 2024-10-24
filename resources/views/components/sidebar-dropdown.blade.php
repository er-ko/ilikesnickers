@props(['active', 'contentClasses' => 'bg-white dark:bg-gray-800'])

@php
$classes = ($active ?? false)
    ? 'w-full flex items-end p-4 sm:p-2 lg:p-4 mt-1 text-sm font-semibold text-gray-900 bg-gray-200 rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-900 dark:focus:bg-gray-900 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline'
    : 'w-full flex items-end p-4 sm:p-2 lg:p-4 mt-1 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-900/50 dark:focus:bg-gray-900 dark:focus:text-white dark:hover:text-white dark:text-gray-400 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline';
@endphp

<div class="relative" @click.away="open = false" x-data="{ open: false }">
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
        class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg z-50"
    >
        <div class="p-2 sm:p-1 lg:p-2 bg-white rounded-md shadow dark:bg-gray-900">
            {{ $content }}
        </div>
    </div>
</div>
