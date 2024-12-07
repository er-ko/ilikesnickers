<x-app-layout>

	<x-slot name="meta_title">{{ __('edit') .': '. $language->name }}</x-slot>
	<x-slot name="meta_desc">{{ __('language') }}</x-slot>
	<x-slot name="title">{{ __('edit_language') }}</x-slot>

	<x-slot name="submit">
		<button form="form-store" type="submit" class="p-2.5 pl-4 rounded-l-full duration-300 bg-teal-600 text-white hover:bg-teal-700 dark:bg-teal-700 dark:hover:bg-teal-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
			</svg>
		</button>
		<a href="{{ route('language.index') }}" class="py-2.5 px-3 duration-300 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-700 dark:hover:bg-pink-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
			</svg>
		</a>
	</x-slot>

	<div class="h-full" x-data="{ group: 'tab-general'}">
		<div class="flex items-center justify-between flex-wrap space-y-4 sm:space-y-0 mb-4">
			<div class="flex items-center justify-center sm:justify-start w-full sm:w-fit dark:text-gray-200">
				<div
					class="w-fit mx-x0.5 py-1 px-3 hover:cursor-pointer rounded-lg" @click.prevent="group = 'tab-general'"
					:class="{ 'bg-black text-white dark:bg-white dark:text-black': group == 'tab-general'}"
				>
					{{ __('general') }}
				</div>
				<div
					class="w-fit mx-x0.5 py-1 px-3 hover:cursor-pointer rounded-lg" @click.prevent="group = 'tab-translate'"
					:class="{ 'bg-black text-white dark:bg-white dark:text-black': group == 'tab-translate'}"
				>
					{{ __('translate') }}
				</div>
			</div>
		</div>
		<form method="POST" action="{{ route('language.update', $language) }}" id="form-store" class="h-full">
			@csrf
			@method('patch')
			<div class="w-full max-w-md mx-auto" x-show="group == 'tab-general'">
				@include('languages.partials.general')
			</div>
			<div x-show="group == 'tab-translate'">
				@include('languages.partials.translate')
			</div>
		</form>
    </div>
</x-app-layout>