<x-public-layout>
    
    <x-slot name="meta_title">{{ $manufacturer->name }}</x-slot>
	<x-slot name="meta_desc">{{ $manufacturer->name }}</x-slot>

	<x-slot name="postClose">
        @auth
            <form method="post" action="{{ route('manufacturer.index') }}" onsubmit="submit(); window.close()">
                <button type="submit" class="py-3 pr-3.5 pl-5 rounded-l-full shadow duration-300 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-700 dark:text-white dark:hover:bg-pink-800">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
					</svg>
				</button>
			</form>
		@else
			<a href="{{ route('manufacturer.index') }}" class="py-3 pr-3.5 pl-5 rounded-l-full shadow duration-300 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-700 dark:text-white dark:hover:bg-pink-800">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
					<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
				</svg>
			</a>
		@endauth
    </x-slot>

	<div class="w-full mt-12">
		<h1 class="mb-4 px-2 font-semibold text-2xl">{{ $manufacturer->name }}</h1>
		<div class="p-8 shadow-sm sm:rounded-lg text-black bg-white dark:text-white dark:bg-gray-800">
			<span class="font-mono">{!! $manufacturer->content !!}</span>
			<div class="flex items-center justify-center flex-wrap mb-6 text-gray-800 dark:text-gray-200">
				@if ($manufacturer->image)
					<img src="{{ asset('/storage/manufacturers/'. $manufacturer->image) }}" class="w-48" />
				@endif
			</div>
		</div>
	</div>

</x-public-layout>