<x-app-layout>

	<x-slot name="meta_title">{{ __('edit') .': '. $currency->name }}</x-slot>
	<x-slot name="meta_desc">{{ __('currency') }}</x-slot>
	<x-slot name="title">{{ __('edit_currency') }}</x-slot>

	<x-slot name="submit">
		<button form="form-store" type="submit" class="p-2.5 pl-4 rounded-l-full duration-300 bg-teal-600 text-white hover:bg-teal-700 dark:bg-teal-700 dark:hover:bg-teal-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
			</svg>
		</button>
		<a href="{{ route('currency.index') }}" class="py-2.5 px-3 duration-300 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-700 dark:hover:bg-pink-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
			</svg>
		</a>
	</x-slot>

	<form method="POST" action="{{ route('currency.update', $currency) }}" id="form-store" class="h-full flex items-center justify-center">
        @csrf
		@method('patch')
        <div class="w-full max-w-md">
            @include('currencies.partials.general')    
        </div>
    </form>

</x-app-layout>