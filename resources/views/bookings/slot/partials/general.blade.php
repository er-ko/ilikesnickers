<div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 space-x-0 lg:space-x-4">
	<x-card class="w-full max-w-2xl lg:max-w-sm h-fit space-y-4 !pt-0">
		<x-slot name="content">
			<input type="hidden" name="id" value="{{ isset($booking) ? $booking->id : '' }}" />
			<div>
				<x-input-label for="active" :required="true" :value="__('active')" />
				<x-select name="active" id="active" class="active" required autofocus>
					<option value="0" {{ isset($booking) && !old('active', $booking->active) ? 'selected' : '' }}>{{ __('no') }}</option>
					<option value="1" {{ isset($booking) && old('active', $booking->active) ? 'selected' : '' }}>{{ __('yes') }}</option>
				</x-select>
				<x-input-error :messages="$errors->get('active')" />
			</div>
			<div>
				<x-input-label for="priority" :required="true" :value="__('priority')" />
				<x-text-input id="priority" class="text-center" name="priority" type="number" min="1" step="1" :value="isset($booking) ? old('priority', $booking->priority) : 1" :required="true" />
				<x-input-error :messages="$errors->get('priority')" />
			</div>
			<div>
				<x-input-label for="open-days" :required="true" :value="__('open_days')" />
				<x-text-input id="open-days" class="text-center" name="open_days" type="number" min="1" step="1" :value="isset($booking) ? old('open_days', $booking->open_days) : 30" :required="true" />
				<x-input-error :messages="$errors->get('open_days')" />
			</div>
			<div>
				<div class="px-1 block font-medium text-sm uppercase mb-1 text-gray-700 dark:text-gray-300">{{ __('image') }}</div>
				<label
					for="image-{{ $lang->locale }}"
					class="relative flex flex-col justify-center items-center h-full py-8 rounded-md hover:cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/20 border border-gray-300 dark:border-gray-700"
				>
					@if (isset($booking) && old('image', $booking->image))
						<img src="{{ asset('/storage/bookings/'. old('image', $booking->image)) }}" class="absolute top-2 right-2 max-w-24 rounded-lg" />
					@endif
					<span class="mb-2">{{ __('drop_image_here') }}</span>{{ __('or') }}
					<input type="file" name="image" id="image-{{ $lang->locale }}" class="mt-4 p-2 w-64 rounded-lg dark:text-gray-500 bg-white dark:bg-gray-900 border border-gray-300 dark:border-slate-700" accept="image/*" />
				</label>
			</div>
		</x-slot>
	</x-card>
	<x-card class="h-fit relative flex-1 pt-8 sm:pt-4">
		<x-slot name="content">
			@foreach ($languages as $lang)
				<div class="space-y-4" x-show="lang == 'tab-{{ $lang->locale }}'">
					<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 sm:shadow rounded-full bg-white dark:bg-black">
						<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
					</div>
					<input type="hidden" name="locale[]" value="{{ $lang->locale }}" />
					<div class="flex-1 !mt-0">
						<x-input-label for="title-{{ $lang->locale }}" :required="$lang->default ? true : false" :value="__('title')" />
						<x-text-input id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" :required="$lang->default ? true : false" />
						<x-input-error :messages="$errors->get('title')" />
					</div>
				</div>
			@endforeach
		</x-slot>
	</x-card>
</div>
@push('slotscript')
	<script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
	<script>
		$(document).ready(function(){
			$('.opening-hours input').inputmask('99:99 - 99:99');
		});
	</script>
@endpush