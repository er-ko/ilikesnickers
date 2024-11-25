<x-public-layout>

	<x-slot name="meta_title">{{ $post->meta_title }}</x-slot>
	<x-slot name="meta_desc">{{ $post->meta_description }}</x-slot>

	<x-slot name="postClose">
        @auth
			<form method="post" action="{{ route('post.store') }}" onsubmit="submit(); window.close()">
				<button type="submit" class="py-3 pr-3.5 pl-5 rounded-l-full shadow duration-300 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-700 dark:text-white dark:hover:bg-pink-800">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
					</svg>
				</button>
			</form>
		@endauth
    </x-slot>

	<div class="px-2">
		<div class="flex items-end justify-between flex-wrap mb-3 text-gray-800 dark:text-gray-200">
			<h1 class="font-semibold text-lg lg:text-2xl">{{ $post->title_h1 }}</h1>
			<span class="font-mono text-sm text-gray-500">{{ date(request()->session()->get('date_format'), strtotime($post->created_at)) }}</span>
		</div>
		@if ($post->image)
			<img src="{{ asset('/storage/posts/'. $post->image) }}" class="w-full mb-6" />
		@endif
		<span class="font-mono">{!! $post->content !!}</span>
	</div>

</x-public-layout>