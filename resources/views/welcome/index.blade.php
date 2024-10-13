<x-public-layout>

    <x-slot name="meta_title">{{ __('messages.welcome') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.welcome in the box') }}?</x-slot>

    <div class="w-full flex flex-col items-center justify-center">
        <img src="{{ asset('favicon.png') }}" class="w-full max-w-[350px] mt-8" />
        <h1 class="font-bold text-3xl text-center lowercase text-black dark:text-white">{{ __('messages.welcome_in_the_box') }} </h1>
    </div>

</x-public-layout>
