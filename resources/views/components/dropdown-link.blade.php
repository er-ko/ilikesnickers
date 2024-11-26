@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block p-4 sm:p-3 lg:p-4 mt-0.5 text-sm font-semibold text-gray-900 bg-gray-200/75 rounded-lg dark:text-gray-300 dark:bg-gray-900 dark:hover:bg-gray-900 dark:focus:bg-gray-900 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline'
    : 'block p-4 sm:p-3 lg:p-4 mt-0.5 text-sm font-semibold text-gray-900 bg-gray-100/75 rounded-lg dark:bg-transparent dark:hover:bg-gray-900/50 dark:focus:bg-gray-900 dark:focus:text-white dark:hover:text-white dark:text-gray-400 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
