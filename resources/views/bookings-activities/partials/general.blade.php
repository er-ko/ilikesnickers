<div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 space-x-0 lg:space-x-4">
	<x-card class="w-full max-w-2xl lg:max-w-sm h-fit space-y-4">
		<x-slot name="content">
			<div>
				<x-input-label for="active" :required="true" :value="__('active')" />
				<x-select name="active" id="active" required autofocus>
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
				<x-input-label for="processing-time" :required="true" :value="__('processing_time') .' ('. __('minutes') .')'" />
				<x-text-input id="processing-time" class="text-center" name="processing_time" type="number" min="1" step="1" :value="isset($booking) ? old('processing_time', $booking->processing_time) : 60" :required="true" />
				<x-input-error :messages="$errors->get('processing_time')" />
			</div>
			<div>
				<x-input-label for="interval-after" :required="true" :value="__('interval_after') .' ('. __('minutes') .')'" />
				<x-text-input id="interval-after" class="text-center" name="interval_after" type="number" min="1" step="1" :value="isset($booking) ? old('interval_after', $booking->interval_after) : 15" :required="true" />
				<x-input-error :messages="$errors->get('interval_after')" />
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
						<x-input-label for="title-{{ $lang->locale }}" :required="$default == $lang->id ? true : false" :value="__('title')" />
						<x-text-input id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" :required="$default == $lang->id ? true : false" />
						<x-input-error :messages="$errors->get('title')" />
					</div>
				</div>
			@endforeach
		</x-slot>
	</x-card>
</div>