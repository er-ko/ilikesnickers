<x-public-layout>

	<x-slot name="meta_title">{{ $page->meta_title }}</x-slot>
	<x-slot name="meta_desc">{{ $page->meta_description }}</x-slot>

	<div class="mt-12">
		<div class="flex items-end justify-between flex-wrap px-3 mb-3 text-gray-800 dark:text-gray-200">
			<h1 class="font-semibold text-2xl">{{ $page->title_h1 }}</h1>
		</div>
		<div class="p-8 shadow-sm sm:rounded-lg text-black bg-white dark:text-white dark:bg-gray-800">
			<span class="font-mono">{!! $page->content !!}</span>
		</div>
	</div>
</x-public-layout>