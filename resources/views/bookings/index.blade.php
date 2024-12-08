@auth
	<x-app-layout>

		<x-slot name="meta_title">{{ __('booking') }}</x-slot>
		<x-slot name="meta_desc">{{ __('booking') }}</x-slot>
		<x-slot name="title">{{ __('booking') }}</x-slot>

		<div class="p-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
			@if ($bookings->isEmpty())
				<p class="py-4 italic text-center font-light dark:text-gray-400">{{ __('no_booking') }}</p>
			@else
				<div class="overflow-auto">
					<table class="table-auto w-full text-sm">
						<thead>
							<tr class="lowercase bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
								<th class="px-2 pt-4 pb-2 text-center sm:rounded-tl-lg">#</th>
								<th class="px-2 pt-4 pb-2 text-center">{{ __('start') }}</th>
								<th class="px-2 pt-4 pb-2 text-left">{{ __('full_name') }}</th>
								<th class="px-2 pt-4 pb-2 text-left">{{ __('slot') }}</th>
								<th class="px-2 pt-4 pb-2 text-left">{{ __('activity') }}</th>
								<th class="px-2 pt-4 pb-2 text-center">{{ __('created') }}</th>
								<th class="px-2 pt-4 pb-2 sm:rounded-tr-lg"></th>
							</tr>
						</thead>
						<tbody>
						@foreach ($bookings as $booking)
							<tr class="border-b border-gray-100 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 transition duration-400">
								<td class="p-2 w-20 min-w-20 text-center">{{ $booking->id }}</td>
								<td class="p-2 w-32 min-w-32 text-center">
									@if (request()->session()->get('time_format') === '12')
										{{ date('h:i A', strtotime( explode(' ', $booking->start )[1] )) }}
									@else
										{{ date('H:i', strtotime( explode(' ', $booking->start )[1] )) }}
									@endif
									<br />
									{{ date(request()->session()->get('date_format'), strtotime( explode(' ', $booking->start )[0] )) }}
								</td>
								<td class="p-2 w-64 min-w-64 whitespace-nowrap">{{ $booking->full_name }}</td>
								<td class="p-2 whitespace-nowrap">{{ $booking->slot }}</td>
								<td class="p-2 whitespace-nowrap">{{ $booking->activity }}</td>
								<td class="p-2 w-28 min-w-28 text-center">{{ date(request()->session()->get('date_format'), strtotime($booking->created_at)) }}</td>
								<td class="p-2 w-16 min-w-16 text-center">
									<a href="{{ route('booking.edit', $booking->id) }}" class="inline-block text-gray-300 hover:text-gray-700 dark:text-gray-500 dark:hover:text-gray-300 transition duration-400 relative top-0.5 mx-1">
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
			@endif
			{{ $bookings->links() }}
		</div>

	</x-app-layout>
@else
	<x-public-layout>

		<x-slot name="meta_title">{{ __('booking') }}</x-slot>
		<x-slot name="meta_desc">{{ __('booking') }}?</x-slot>

		@include('bookings.partials.slot')
		@include('bookings.partials.form')

		@push('slotscript')
			<script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
			<script>
				$(document).ready(function(){

					$('#phone').inputmask('+999 999 999 999');

					$('.activity').change(function(){
						var slotId = $(this).parent().find('.slot-id').val();
						var activityId = $(this).val();
						$('.btn-continue').addClass('hidden');
						$('.activity').val('');
						$('#activity-'+ slotId).val(activityId);
						$('.date').addClass('hidden');
						$(this).parent().find('#'+ slotId +'-date-'+ activityId ).removeClass('hidden');
						booked(slotId, activityId);

						$('#form-slot-id').val(slotId);
						$('#form-activity-id').val(activityId);
						$('.slot-name').text($(this).parent().parent().find('h3').text());
						$('.activity-name').text($('#activity-'+ slotId +' option:selected').text());
						$('.note-content').text($(this).parent().find('.slot-note').val());
					});

					$('.date').change(function(){
						$('.btn-continue').addClass('hidden');
						$(this).parent().find('button').removeClass('hidden')

						$('.duration-time').text($(this).find(':selected').data('process') +' min');
						$('.start-time').text($(this).val());
						$('#form-start-time').val($(this).val());
					});

					$('.btn-continue').click(function(){
						$('#block-slot').addClass('hidden');
						$('#block-form').removeClass('hidden');
					});

					function booked(slot) {
						$.ajax({
							url: "{{ route('booking.index') }}",
							type: 'GET',
							dataType: 'json',
							data: {
								slot: slot,
							},
							success: function(data) {
								if (!$.isEmptyObject(data)) {

									$.each(data, function(index, booking){
										$('#slot-'+ slot).parent().find('.date option').each(function(index2, value) {

											if ($(this).data('date') == booking.start.split(' ')[0]) {

												var bookingMin = parseFloat(booking.start.split(' ')[1].split(':')[0] * 60) + parseFloat(booking.start.split(' ')[1].split(':')[1]);
												var bookingMinBefore = parseFloat(bookingMin) - parseFloat($(this).data('process'));
												var bookingMinAfter = parseFloat(bookingMin) + parseFloat(booking.processing_time) + parseFloat(booking.interval_after);
												var timeMin = parseFloat($(this).data('time').split(':')[0] * 60) + parseFloat($(this).data('time').split(':')[1]);

												if ( timeMin > bookingMinBefore && timeMin < bookingMinAfter ) {
													$(this).prop('disabled', true).text("booked");
												}
											}

										});

									});

								}
							}
						});
					}
				});
			</script>
		@endpush
	</x-public-layout>
@endauth