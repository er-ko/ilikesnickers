@props(['active', 'contentClasses' => 'bg-white dark:bg-gray-800'])

@php
$classes = ($active ?? false)
    ? 'w-full flex items-center justify-between px-4 lg:px-6 py-5 border-b border-indigo-400 dark:border-teal-500 text-sm font-normal leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
    : 'w-full flex items-center justify-between px-4 lg:px-6 py-5 border-b border-gray-100 dark:border-gray-700 text-sm font-light leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<div class="relative w-full" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div class="flex" @click="open = ! open">
		<button {{ $attributes->merge(['class' => $classes]) }}>
        	{{ $trigger }}
		</button>
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute top-0 -right-[301px] z-50 w-[300px] shadow-lg"
            style="display: none;"
            @click="open = false">
        <div class="rounded-r-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
