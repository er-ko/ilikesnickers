<x-app-layout>

    <x-slot name="meta_title">{{ __('countries') }}</x-slot>
	<x-slot name="meta_desc">{{ __('countries') }}</x-slot>
    <x-slot name="title">{{ __('countries') }}</x-slot>

	<div class="p-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
		<div class="overflow-auto">
			<table class="table-auto w-full text-sm">
				<thead>
					<tr class="lowercase bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
						<th class="px-2 pt-4 pb-2 text-center sm:rounded-tl-lg">#</th>
						<th class="px-2 pt-4 pb-2 text-center">{{ __('code') }}</th>
						<th class="px-2 pt-4 pb-2 text-left">{{ __('name') }}</th>
						<th class="px-2 pt-4 pb-2">{{ __('default') }}</th>
						<th class="px-2 pt-4 pb-2">{{ __('public') }}</th>
						<th class="px-2 pt-4 pb-2">{{ __('delivery') }}</th>
						<th class="px-2 pt-4 pb-2 sm:rounded-tr-lg"></th>
					</tr>
				</thead>
				<tbody>
				@foreach ($countries as $country)
					<tr class="duration-300 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-900">
						<td class="p-2 w-16 min-w-16 text-center">{{ $country->id }}</td>
						<td class="p-2 w-16 min-w-16 text-center">{{ $country->code }}</td>
						<td class="p-2 whitespace-nowrap">{{ $country->name }}</td>
						<td class="p-2 w-16 min-w-16 text-center">
							@if($default == $country->id)
								<span class="inline-flex p-1 rounded-full bg-teal-500/20 text-teal-800 dark:bg-teal-500/50 dark:text-teal-300">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
										<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
									</svg>                                              
								</span>
							@else
								<span class="inline-flex p-1 rounded-full bg-pink-500/20 text-pink-800 dark:bg-pink-500/50 dark:text-pink-300">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
										<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
									</svg>
								</span>
							@endif
						</td>
						<td class="p-2 w-16 min-w-16 text-center">
							@if($country->public)
								<span class="inline-flex p-1 rounded-full bg-teal-500/20 text-teal-800 dark:bg-teal-500/50 dark:text-teal-300">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
										<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
									</svg>                                              
								</span>
							@else
								<span class="inline-flex p-1 rounded-full bg-pink-500/20 text-pink-800 dark:bg-pink-500/50 dark:text-pink-300">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
										<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
									</svg>
								</span>
							@endif
						</td>
						<td class="p-2 w-16 min-w-16 text-center">
							@if($country->delivery)
								<span class="inline-flex p-1 rounded-full bg-teal-500/20 text-teal-800 dark:bg-teal-500/50 dark:text-teal-300">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
										<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
									</svg>                                              
								</span>
							@else
								<span class="inline-flex p-1 rounded-full bg-pink-500/20 text-pink-800 dark:bg-pink-500/50 dark:text-pink-300">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
										<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
									</svg>
								</span>
							@endif
						</td>
						<td class="p-2 w-12 min-w-12 text-center">
							<a href="{{ route('country.edit', $country->id) }}" class="inline-block duration-300 text-gray-300 hover:text-gray-700 dark:text-gray-500 dark:hover:text-gray-300">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
									<path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
								</svg>
							</a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		{{ $countries->links() }}
	</div>

</x-app-layout>