<div id="block-slot" class="h-full grid gap-4 grid-cols-1 lg:grid-cols-2 xl:grid-cols-3">
	@if ($slots->isEmpty())
		{{ __('no_booking') }}
	@else
		@foreach ($slots as $slot)
			<x-card class="w-full max-w-md h-fit mx-auto my-auto space-y-4 hover:shadow-xl duration-300">
				<x-slot name="content">
					<h3 class="font-bold text-center my-4">{{ $slot->title }}</h3>
					@if (isset($slot->image))
						<div class="w-full h-full max-h-[250px] overflow-hidden flex items-center justify-center">
							<img src="{{ asset('/bookings/'. $slot->image) }}" class="rounded w-full" />
						</div>
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
						<input type="hidden" class="slot-note" value="{{ $slot->note }}" />
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
															<option value="{{ $date .' '. explode('-', explode('|', $time )[0])[0] }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[0])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
																	<option value="{{ $date .' '. $finalTime }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
																		{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																	</option>
																@endif
															@endif
														@endfor
													@endif
													@if (!empty(explode('|', $time )[1]))
														@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) ))
															<option value="{{ $date .' '. explode('-', explode('|', $time )[1])[0] }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[1])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
																	<option value="{{ $date .' '. $finalTime }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
															<option value="{{ $date .' '. explode('-', explode('|', $time )[0])[0] }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[0])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
																	<option value="{{ $date .' '. $finalTime }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
																		{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																	</option>
																@endif
															@endif
														@endfor
													@endif
													@if (!empty(explode('|', $time )[1]))
														@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) ))
															<option value="{{ $date .' '. explode('-', explode('|', $time )[1])[0] }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[1])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
																	<option value="{{ $date .' '. $finalTime }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
															<option value="{{ $date .' '. explode('-', explode('|', $time )[0])[0] }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[0])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
																	<option value="{{ $date .' '. $finalTime }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
																		{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																	</option>
																@endif
															@endif
														@endfor
													@endif
													@if (!empty(explode('|', $time )[1]))
														@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
															<option value="{{ $date .' '. explode('-', explode('|', $time )[1])[0] }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[1])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
																	<option value="{{ $date .' '. $finalTime }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
															<option value="{{ $date .' '. explode('-', explode('|', $time )[0])[0] }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[0])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
																	<option value="{{ $date .' '. $finalTime }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
																		{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																	</option>
																@endif
															@endif
														@endfor
													@endif
													@if (!empty(explode('|', $time )[1]))
														@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
															<option value="{{ $date .' '. explode('-', explode('|', $time )[1])[0] }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[1])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
																	<option value="{{ $date .' '. $finalTime }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
															<option value="{{ $date .' '. explode('-', explode('|', $time )[0])[0] }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[0])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
																	<option value="{{ $date .' '. $finalTime }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
																		{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																	</option>
																@endif
															@endif
														@endfor
													@endif
													@if (!empty(explode('|', $time )[1]))
														@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[0])[0])) ))
															<option value="{{ $date .' '. explode('-', explode('|', $time )[1])[0] }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[1])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
																	<option value="{{ $date .' '. $finalTime }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
															<option value="{{ $date .' '. explode('-', explode('|', $time )[0])[0] }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[0])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
																<option value="{{ $date .' '. $finalTime }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
																	{{ date('d/m/y', strtotime($date)) }} {{ app()->getLocale() == 'en' ? date('h:i a', strtotime($finalTime)) : date('H:i', strtotime($finalTime)) }}
																</option>
															@endif
														@endfor
													@endif
													@if (!empty(explode('|', $time )[1]))
														@if (!( date('y-m-d', strtotime(now())) == date('y-m-d', strtotime($date)) && date('H:i', strtotime(now())) > date('H:i', strtotime(explode('-', explode('|', $time )[1])[0])) ))
															<option value="{{ $date .' '. explode('-', explode('|', $time )[1])[0] }}" data-date="{{ $date }}" data-time="{{ explode('-', explode('|', $time )[1])[0] }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
																	<option value="{{ $date .' '. $finalTime }}" data-date="{{ $date }}" data-time="{{ $finalTime }}" data-process="{{ $activity->processing_time + $activity->interval_after }}">
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
						<x-primary-button type="button" class="w-full btn-continue hidden">{{ __('continue') }}</x-primary-button>
					</div>
				</x-slot>
			</x-card>
		@endforeach
	@endif
</div>