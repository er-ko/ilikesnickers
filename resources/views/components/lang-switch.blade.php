<div class="relative" x-data="{ menu: false }" @click.outside="menu = false" x-cloak>
	<button
		class="block shadow duration-300 py-3 p-4 bg-white hover:bg-gray-200 dark:bg-black dark:hover:bg-gray-800 text-gray-400 dark:text-gray-600 hover:text-gray-500 focus:text-gray-500 dark:hover:text-gray-500 dark:focus:text-gray-500"
		:class="theme ? 'text-gray-700 dark:text-gray-300' : 'text-gray-400 dark:text-gray-600 hover:text-gray-500 focus:text-gray-500 dark:hover:text-gray-500 dark:focus:text-gray-500'"
		@click="menu = ! menu"
	>
		@foreach ($languages as $lang)
			@if ($lang->locale === app()->getLocale())
				<img src="{{ asset('/storage/flags/'. $lang->flag) }}" class="w-5" />
			@endif
		@endforeach
	</button>

	<div
		x-show="menu"
		class="absolute right-0 z-10 flex origin-top-right flex-col min-w-40 rounded-md bg-white shadow-xl ring-1 ring-gray-900/5 dark:bg-gray-800"
		@click="menu = false"
	>
		@foreach ($languages as $lang)
			<a
				href="/locale/{{ $lang->locale }}"
				class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400"
			>
				<img src="{{ asset('/storage/flags/'. $lang->flag) }}" class="w-[22px]" />
				{{ $lang->name }}
			</a>
		@endforeach
	</div>
</div>
