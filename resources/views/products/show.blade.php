<x-public-layout>
	
	<x-slot name="meta_title">{{ $product->meta_title }}</x-slot>
	<x-slot name="meta_desc">{{ $product->meta_description }}</x-slot>

	<x-slot name="postClose">
		<a href="{{ route('category.index') }}" class="py-3 pr-3.5 pl-5 rounded-l-full shadow duration-300 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-700 dark:text-white dark:hover:bg-pink-800">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
				<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
			</svg>
		</a>
		<a href="{{ route('category.index') }}" class="py-3 p-4 shadow duration-300 bg-teal-600 text-white hover:bg-pink-700 dark:bg-pink-700 dark:text-white dark:hover:bg-pink-800">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
				<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
			</svg>
		</a>
    </x-slot>
	<div class="w-full flex flex-col">
		<div class="w-full h-fit grid gap-0 grid-cols-1 lg:grid-cols-2">
			<div class="bg-white dark:bg-gray-800">
				@if ($product->file)
					<div class="carousel w-full" data-flickity='{ "freeScroll": true, "wrapAround": true }'>
						<div class="carousel-cell">
							<img src="{{ asset('/storage/products/'. $product->id .'/'. $product->file) }}" />
						</div>
						@if ($images)
							@foreach ($images as $image)
								<div class="carousel-cell">
									<img src="{{ asset('/storage/products/'. $product->id .'/'. $image->file) }}" />
								</div>
							@endforeach
						@endif
					</div>
				@endif
			</div>
			<div class="p-8 bg-gray-600 text-gray-200">
				<h1 class="w-full font-semibold text-2xl mb-6 text-white">{{ $product->title_h1 }}</h1>
				<div>
					<span class="mr-1">{{ __('manufacturer') }}:</span>
					<span>{{ $product->manufacturer }}</span>
				</div>
				<div class="flex items-center justify-start space-x-1 my-6">
					<x-text-input type="number" name="qty" value="1" min="1" step="1" class="!mt-0 w-full max-w-32 text-black text-center" />
					<x-primary-button>{{ __('buy') }}</x-primary-button>
				</div>
			</div>
		</div>
	
		<div class="mt-8">{!! $product->content !!}</div>
	</div>

	@push('slotscript')
		<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    @endpush
</x-public-layout>