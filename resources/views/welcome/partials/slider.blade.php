@foreach ($languages as $lang)
	<div x-show="lang == 'tab-{{ $lang->locale }}'">

		<div class="wrapper-image-block relative p-4 pt-8 sm:pt-4 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
			<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 z-50 rounded-full sm:shadow bg-white dark:bg-black">
				<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
			</div>
			<div class="w-full overflow-y-auto">
				<table id="table-slider-{{ $lang->locale }}" class="w-full">
					<thead>
						<tr>
							<th class="w-64 text-start">{{ __('image') }}</th>
							<th class="text-start">{{ __('description') }}</th>
							<th class="w-24 text-center">{{ __('priority') }}</th>
							<th class="w-16">
								<button type="button" class="image-add p-2 rounded duration-300 bg-teal-600 text-white hover:bg-teal-700">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
										<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
									</svg>
								</button>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<input type="file" name="image_file_{{ $lang->locale }}[]" class="w-64" accept="image/*" />
							</td>
							<td>
								<x-text-input name="image_title_{{ $lang->locale }}[]" type="text" maxlength="255" />
							</td>
							<td>
								<x-text-input name="image_priority_{{ $lang->locale }}[]" class="text-center" type="number" min="0" step="1" max="99" value="1" />
							</td>
							<td class="text-center">
								<button type="button" class="image-del p-2 rounded duration-300 bg-gray-400 text-white hover:bg-gray-500" disabled>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mx-auto">
										<path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
									</svg>
								</button>
							</td>
						</tr>
					</tbody>
					<tfoot></tfoot>
				</table>
			</div>
		</div>
		<p class="mt-4 text-center italic">{{ __('if_the_image_is_not_created_in_the_given_language_version_it_will_be_taken_from_the_default') }}</p>
	</div>
@endforeach

@push('slotscript')
	<script>
		var block = '';
		$(document).ready(function(){

			$('.image-del').on('click', function(){
				$(this).parent().parent().remove();
			});

			$('.image-add').click(function(){
				block = $(this).parent().parent().parent().parent().find('tbody tr').first().clone();
				block.find('input[type=file]').val('');
				block.find('input[type=text]').val('');
				block.find('button').prop('disabled', false).removeClass('bg-gray-400 hover:bg-gray-500').addClass('bg-pink-600 hover:bg-pink-700');
				$(this).parent().parent().parent().parent().find('tbody').append(block);

				$('.image-del').on('click', function(){
					$(this).parent().parent().remove();
				});
			});
		});
	</script>
@endpush