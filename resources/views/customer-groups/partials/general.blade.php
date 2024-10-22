<div class="grid gap-0 lg:gap-4 grid-cols-1 lg:grid-cols-3">
	<div class="mb-4 lg:mb-0 p-6 space-y-4 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
		<div>
			<x-input-label for="public" :required="true" :value="__('messages.public')" />
			<x-select name="public" id="public" class="public" required>
				<option value="0" {{ isset($customerGroup) && !old('public', $customerGroup->public) ? 'selected' : '' }}>{{ __('messages.no') }}</option>
				<option value="1" {{ isset($customerGroup) && old('public', $customerGroup->public) ? 'selected' : '' }}>{{ __('messages.yes') }}</option>
			</x-select>
			<x-input-error :messages="$errors->get('public')" />
		</div>
	</div>
	<div class="relative col-span-2 p-6 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
		@foreach ($languages as $lang)
			<div x-show="lang == 'tab-{{ $lang->locale }}'">
				<input type="hidden" name="locale[]" value="{{ $lang->locale }}" />
				<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 rounded-full sm:shadow bg-white dark:bg-black">
					<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
				</div>
				<div>
					<x-input-label for="title-{{ $lang->locale }}" :required="$lang->default ? true : false" :value="__('messages.title')" />
						<x-text-input id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" :required="$lang->default ? true : false" />
						<x-input-error :messages="$errors->get('title')" />
				</div>
			</div>
		@endforeach
	</div>
</div>