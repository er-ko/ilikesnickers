<x-app-layout>

    <x-slot name="meta_title">{{ __('dashboard') }}</x-slot>
	<x-slot name="meta_desc">{{ __('dashboard') }}</x-slot>
    <x-slot name="title">{{ __('dashboard') }}</x-slot>

    <x-slot name="header">
        <h2 class="my-2 lg:my-4 sm:mb-6 lg:mb-8 sm:px-2 font-bold">{{ __('hello') .' '. $username }} !</h2>
    </x-slot>

    <div class="flex flex-col lg:flex-row items-start justify-between space-y-2 lg:space-y-0 space-x-0 lg:space-x-2">
        @include('dashboard.partials.task')
        @include('dashboard.partials.translate')
    </div>

</x-app-layout>