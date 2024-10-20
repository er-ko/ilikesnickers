<x-app-layout>

    <x-slot name="meta_title">{{ __('messages.new_contact') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.new_contact') }}</x-slot>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight text-gray-800 dark:text-gray-200">
                {{ __('messages.new_contact') }}
            </h2>
            <a href="{{ route('address-book.create') }}" target="_self" class="px-2 text-teal-600 hover:text-teal-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-6 mb-12 sm:px-6 lg:px-8" x-data="{ group: 'tab-address' }">
		<div class="flex items-center justify-between flex-wrap mx-2 space-y-4 sm:space-y-0 mb-4">
			<div class="flex items-center justify-center sm:justify-start w-full sm:w-fit dark:text-gray-200">
				<div
					class="w-fit mx-x0.5 py-1 px-3 hover:cursor-pointer rounded-lg" @click.prevent="group = 'tab-address'"
					:class="{ 'bg-black text-white dark:bg-white dark:text-black': group == 'tab-address'}"
				>
					{{ __('messages.address') }}
				</div>
                <div
					class="w-fit mx-x0.5 py-1 px-3 hover:cursor-pointer rounded-lg" @click.prevent="group = 'tab-invoice'"
					:class="{ 'bg-black text-white dark:bg-white dark:text-black': group == 'tab-invoice'}"
				>
					{{ __('messages.invoice') }}
				</div>
			</div>
		</div>
		<div class="relative">
			<form method="POST" action="{{ route('address-book.store') }}" id="form-store">
				@csrf
				<div x-show="group == 'tab-address'">
					@include('address-books.partials.address')
				</div>
                <div x-show="group == 'tab-invoice'">
					@include('address-books.partials.invoice')
				</div>
			</form>
        </div>
    </div>
</x-app-layout>