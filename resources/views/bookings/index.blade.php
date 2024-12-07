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

		<div class="flex items-center justify-center space-x-4">
			@foreach ($slots as $slot)
				<x-card class="w-full max-w-md space-y-4">
					<x-slot name="content">
						<h1 class="font-bold text-center my-4">{{ $slot->title }}</h1>
						@if (isset($slot->image))
							<img src="{{ asset('/bookings/'. $slot->image) }}" class="rounded" />
						@endif
						<table class="w-fit mx-auto">
							<tbody>
								@foreach (json_decode($slot->opening_hours, true) as $day => $time)
									<tr>
										<th class="text-right px-2">{{ $day }}:</th>
										<td>
											@if (!empty(explode('|', $time)[0]))
												{{ explode('|', $time)[0] }}
											@endif
											@if (!empty(explode('|', $time)[1]))
												<span class="ms-1">{{ explode('|', $time)[1] }}</span>
											@endif
											@if (empty(explode('|', $time)[0]) && empty(explode('|', $time)[1]))
												<strong class="text-pink-700">{{ __('closed') }}</strong>
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<div class="space-y-2">
							<input type="hidden" id="slot-{{ $slot->id }}" class="slot-id" value="{{ $slot->id }}" />
							<x-select name="activity" id="activity-{{ $slot->id }}" class="activity" required>
								<option value="" selected disabled>{{ __('choose_an_activity') }}</option>
								@foreach ($activities as $activity)
									@if ( isset($slot->activities) && in_array($activity->id, json_decode($slot->activities)) )
										<option value="{{ $activity->id }}" data-time="{{ $activity->processing_time }}" data-interval="{{ $activity->interval_after }}">{{ $activity->title }}</option>
									@endif
								@endforeach
							</x-select>
							@for ($d = 0; $d < $slot->open_days; $d++)
								@php $dateArr[] = date('Y-m-d', strtotime('+'. $d .' day')); @endphp
							@endfor
							@foreach ($activities as $activity)
								@if ( isset($slot->activities) && in_array($activity->id, json_decode($slot->activities)) )
									<x-select name="date" id="{{ $slot->id }}-date-{{ $activity->id }}" class="date hidden" required>
										<option disabled selected>{{ __('choose_a_time') }}</option>
										@foreach ($dateArr as $key => $date)
											@foreach (json_decode($slot->opening_hours, true) as $day => $time)
												@if (date('w', strtotime($date)) == 1 && $day == 'monday')
													<optgroup label="{{ date('l', strtotime($date)) }} {{ date('d/m/y', strtotime($date)) }}">
														@if (!empty(explode('|', $time )[0]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
																<option value="{{ $date .' '. explode('-', explode('|', $time )[0])[0] }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[0])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[0])[1]) - strtotime(explode('-', explode('|', $time )[0])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[0])[0];
																	$endTime = explode('-', explode('|', $time)[0])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime($finalTime)) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date .' '. $finalTime }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
														@if (!empty(explode('|', $time )[1]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) ))
																<option value="{{ $date .' '. explode('-', explode('|', $time )[1])[0] }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[1])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[1])[1]) - strtotime(explode('-', explode('|', $time )[1])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[1])[0];
																	$endTime = explode('-', explode('|', $time)[1])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime($finalTime)) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date .' '. $finalTime }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
													</optgroup>
												@elseif ( date('w', strtotime($date)) == 2 && $day == 'tuesday' )
													<optgroup label="{{ date('l', strtotime($date)) }} {{ date('d/m/y', strtotime($date)) }}">
														@if (!empty(explode('|', $time )[0]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
																<option value="{{ $date .' '. explode('-', explode('|', $time )[0])[0] }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[0])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[0])[1]) - strtotime(explode('-', explode('|', $time )[0])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[0])[0];
																	$endTime = explode('-', explode('|', $time)[0])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime($finalTime)) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date .' '. $finalTime }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
														@if (!empty(explode('|', $time )[1]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) ))
																<option value="{{ $date .' '. explode('-', explode('|', $time )[1])[0] }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[1])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[1])[1]) - strtotime(explode('-', explode('|', $time )[1])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[1])[0];
																	$endTime = explode('-', explode('|', $time)[1])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date .' '. $finalTime }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
													</optgroup>
												@elseif ( date('w', strtotime($date)) == 3 && $day == 'wednesday' )
													<optgroup label="{{ date('l', strtotime($date)) }} {{ date('d/m/y', strtotime($date)) }}">
														@if (!empty(explode('|', $time )[0]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
																<option value="{{ $date }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[0])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[0])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[0])[1]) - strtotime(explode('-', explode('|', $time )[0])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[0])[0];
																	$endTime = explode('-', explode('|', $time)[0])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime($finalTime)) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
														@if (!empty(explode('|', $time )[1]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) ))
																<option value="{{ $date }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[1])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[1])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[1])[1]) - strtotime(explode('-', explode('|', $time )[1])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[1])[0];
																	$endTime = explode('-', explode('|', $time)[1])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime($finalTime)) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
													</optgroup>
												@elseif ( date('w', strtotime($date)) == 4 && $day == 'thursday' )
													<optgroup label="{{ date('l', strtotime($date)) }} {{ date('d/m/y', strtotime($date)) }}">
														@if (!empty(explode('|', $time )[0]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
																<option value="{{ $date .' '. explode('-', explode('|', $time )[0])[0] }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[0])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[0])[1]) - strtotime(explode('-', explode('|', $time )[0])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[0])[0];
																	$endTime = explode('-', explode('|', $time)[0])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime($finalTime)) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date .' '. $finalTime }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
														@if (!empty(explode('|', $time )[1]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
																<option value="{{ $date .' '. explode('-', explode('|', $time )[1])[0] }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[1])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[1])[1]) - strtotime(explode('-', explode('|', $time )[1])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[1])[0];
																	$endTime = explode('-', explode('|', $time)[1])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime($finalTime)) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date .' '. $finalTime }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
													</optgroup>
												@elseif ( date('w', strtotime($date)) == 5 && $day == 'friday' )
													<optgroup label="{{ date('l', strtotime($date)) }} {{ date('d/m/y', strtotime($date)) }}">
														@if (!empty(explode('|', $time )[0]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
																<option value="{{ $date .' '. explode('-', explode('|', $time )[0])[0] }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[0])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[0])[1]) - strtotime(explode('-', explode('|', $time )[0])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[0])[0];
																	$endTime = explode('-', explode('|', $time)[0])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime($finalTime)) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date .' '. $finalTime }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
														@if (!empty(explode('|', $time )[1]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
																<option value="{{ $date .' '. explode('-', explode('|', $time )[1])[0] }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[1])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[1])[1]) - strtotime(explode('-', explode('|', $time )[1])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[1])[0];
																	$endTime = explode('-', explode('|', $time)[1])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime($finalTime)) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date .' '. $finalTime }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
													</optgroup>
												@elseif ( date('w', strtotime($date)) == 6 && $day == 'saturday' )
													<optgroup label="{{ date('l', strtotime($date)) }} {{ date('d/m/y', strtotime($date)) }}">
														@if (!empty(explode('|', $time )[0]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
																<option value="{{ $date .' '. explode('-', explode('|', $time )[0])[0] }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[0])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[0])[1]) - strtotime(explode('-', explode('|', $time )[0])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[0])[0];
																	$endTime = explode('-', explode('|', $time)[0])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime($finalTime)) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date .' '. $finalTime }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
														@if (!empty(explode('|', $time )[1]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
																<option value="{{ $date .' '. explode('-', explode('|', $time )[1])[0] }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[1])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[1])[1]) - strtotime(explode('-', explode('|', $time )[1])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[1])[0];
																	$endTime = explode('-', explode('|', $time)[1])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime($finalTime)) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date .' '. $finalTime }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
													</optgroup>
												@elseif ( date('w', strtotime($date)) == 7 && $day == 'sunday' )
													<optgroup label="{{ date('l', strtotime($date)) }} {{ date('d/m/y', strtotime($date)) }}">
														@if (!empty(explode('|', $time )[0]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
																<option value="{{ $date .' '. explode('-', explode('|', $time )[0])[0] }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[0])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[0])[1]) - strtotime(explode('-', explode('|', $time )[0])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[0])[0];
																	$endTime = explode('-', explode('|', $time)[0])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if ($finalTime <= $timeBefore ))
																	<option value="{{ $date .' '. $finalTime }}">
																		{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																	</option>
																@endif
															@endfor
														@endif
														@if (!empty(explode('|', $time )[1]))
															@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) ))
																<option value="{{ $date .' '. explode('-', explode('|', $time )[1])[0] }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime(explode('-', explode('|', $time )[1])[0])) : date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) }}
																</option>
															@endif
															@for ($t = 1; $t < (strtotime(explode('-', explode('|', $time )[1])[1]) - strtotime(explode('-', explode('|', $time )[1])[0])) / 60 / ($activity->processing_time + $activity->interval_after); $t++ )
																@php
																	$startTime = explode('-', explode('|', $time)[1])[0];
																	$endTime = explode('-', explode('|', $time)[1])[1];
																	$cycleTime = $activity->processing_time + $activity->interval_after;
																	$nextTime = $cycleTime * $t;

																	$newtimestamp = strtotime("$startTime + $nextTime minutes");
																	$beforetimestamp = strtotime("$endTime - $cycleTime minutes");

																	$finalTime = date('H:i', $newtimestamp);
																	$timeBefore = date('H:i', $beforetimestamp);
																@endphp
																@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime($finalTime)) ))
																	@if ($finalTime <= $timeBefore ))
																		<option value="{{ $date .' '. $finalTime }}">
																			{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																		</option>
																	@endif
																@endif
															@endfor
														@endif
													</optgroup>
												@endif
											@endforeach
										@endforeach
									</x-select>
								@endif
							@endforeach
						</div>
					</x-slot>
				</x-card>
			@endforeach
		</div>

		@push('slotscript')
			<script>
				$(document).ready(function(){

					$('.activity').change(function(){
						var slotId = $(this).parent().find('.slot-id').val();
						var activityId = $(this).val();
						$('.activity').val('');
						$('#activity-'+ slotId).val(activityId);
						$('.date').addClass('hidden');
						// $(this).parent().find('.date').removeClass('hidden');
						$(this).parent().find('#'+ slotId +'-date-'+ activityId ).removeClass('hidden');
						booked(slotId, activityId);
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