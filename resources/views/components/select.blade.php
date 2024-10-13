@props(['value'])

<select {{ $attributes->merge(['class' => 'mt-1 block w-full py-2 px-3 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-teal-600 dark:focus:ring-teal-600']) }}>
    {{ $value ?? $slot }}
</select>
