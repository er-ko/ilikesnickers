<x-app-layout>

    <x-slot name="meta_title">{{ __('messages.new_contact') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.new_contact') }}</x-slot>
	<x-slot name="title">{{ __('messages.new_contact') }}</x-slot>

	<div class="flex items-center justify-center mt-2 mb-6 space-x-1">
		<button
			form="form-store"
			type="submit"
			class="px-4 py-1 text-base lowercase sm:rounded-md duration-300 bg-teal-600 text-white hover:bg-teal-700"
		>
			{{ __('messages.save') }}
		</button>
		<a
			href="{{ route('address-book.index') }}"
			class="px-4 py-1 text-base lowercase sm:rounded-md duration-300 bg-pink-600 text-white hover:bg-pink-700"
		>
			{{ __('messages.cancel') }}
		</a>
	</div>

    <div x-data="{ group: 'tab-general' }">
		<div class="flex items-center justify-between flex-wrap space-y-4 sm:space-y-0 mb-4">
			<div class="flex items-center justify-center sm:justify-start w-full sm:w-fit dark:text-gray-200">
				<div
					class="w-fit mx-x0.5 py-1 px-3 hover:cursor-pointer rounded-lg" @click.prevent="group = 'tab-general'"
					:class="{ 'bg-black text-white dark:bg-white dark:text-black': group == 'tab-general'}"
				>
					{{ __('messages.general') }}
				</div>
				<div
					class="w-fit mx-x0.5 py-1 px-3 hover:cursor-pointer rounded-lg" @click.prevent="group = 'tab-address'"
					:class="{ 'bg-black text-white dark:bg-white dark:text-black': group == 'tab-address'}"
				>
					{{ __('messages.address') }}
				</div>
			</div>
		</div>
		<div class="relative">
			<form method="POST" action="{{ route('address-book.store') }}" id="form-store">
				@csrf
				<div x-show="group == 'tab-general'">
					@include('address-books.partials.general')
				</div>
				<div x-show="group == 'tab-address'">
					@include('address-books.partials.address')
				</div>
			</form>
        </div>
    </div>
</x-app-layout>