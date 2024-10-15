@auth
<x-app-layout>

	<x-slot name="meta_title">{{ __('messages.products') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.products') }}</x-slot>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight text-gray-800 dark:text-gray-200">
                {{ __('messages.products') }}
            </h2>
            <a href="{{ route('product.create') }}" target="_self" class="px-2 text-teal-600 hover:text-teal-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    list of products
                </div>
            </div>
		</div>
	</div>
</x-app-layout>
@else

<x-public-layout>
	public
</x-public-layout>

@endauth