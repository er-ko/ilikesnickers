<x-app-layout>
	<x-slot name="meta_title">{{ __('booking_slot') }}</x-slot>
	<x-slot name="meta_desc">{{ __('booking_slot') }}</x-slot>
	<x-slot name="title">{{ __('booking_slot') }}</x-slot>

	<x-slot name="submit">
		<a href="{{ route('booking.slot.create') }}" class="p-2.5 pl-4 duration-300 shadow rounded-l-full bg-teal-600 text-white hover:bg-teal-700">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
			</svg>
		</a>
	</x-slot>		
	
	<div class="p-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
		@if ($bookings->isEmpty())
			<p class="py-4 italic text-center font-light dark:text-gray-400">{{ __('no_booking_slot') }}</p>
		@else
			<div class="overflow-auto">
				<table class="table-auto w-full text-sm">
					<thead>
						<tr class="lowercase bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
							<th class="px-2 pt-4 pb-2 text-center sm:rounded-tl-lg">#</th>
							<th class="px-2 pt-4 pb-2 text-left">{{ __('title') }}</th>
							<th class="px-2 pt-4 pb-2">{{ __('priority') }}</th>
							<th class="px-2 pt-4 pb-2">{{ __('public') }}</th>
							<th class="px-2 pt-4 pb-2 sm:rounded-tr-lg"></th>
						</tr>
					</thead>
					<tbody>
					@foreach ($bookings as $booking)
						<tr class="border-b border-gray-100 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 transition duration-400">
							<td class="p-2 w-20 min-w-20 text-center">{{ $booking->id }}</td>
							<td class="p-2 whitespace-nowrap">{{ $booking->title }}</td>
							<td class="p-2 w-28 min-w-28 text-center">{{ $booking->priority }}</td>
							<td class="p-2 w-16 min-w-16 text-center">
								@if($booking->active)
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
							<td class="p-2 w-20 min-w-20 text-center">
								<a href="{{ route('booking.slot.edit', $booking->id) }}" class="inline-block text-gray-300 hover:text-gray-700 dark:text-gray-500 dark:hover:text-gray-300 transition duration-400 relative top-0.5 mx-1">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
										<path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
									</svg>
								</a>
								<form method="POST" action="{{ route('booking.slot.destroy', $booking->id) }}" class="inline-block relative top-0.5" x-data>
									@csrf
									@method('DELETE')
									<button type="submit" class="text-gray-300 hover:text-pink-600" @click="if(!confirm('{{ __('are_you_sure') }}?')) $event.preventDefault()">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
											<path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
										</svg>
									</button>
								</form>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		@endif
		{{ $bookings->links() }}
	</div>
</x-app-layout>