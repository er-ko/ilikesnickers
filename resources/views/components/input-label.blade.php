@props(['value'])
@props(['required' => false])

<label {{ $attributes->merge(['class' => 'block px-1 font-medium text-sm uppercase text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
    @if ($required) <span class="text-pink-700">*</span> @endif
</label>
