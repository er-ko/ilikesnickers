<div class="grid gap-0 lg:gap-4 grid-cols-1 lg:grid-cols-3">
	<div class="relative mb-4 lg:mb-0 p-6 space-y-4 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
		<div>
			<x-input-label for="public" :required="true" :value="__('messages.public')" />
			<x-select name="public" id="public" class="public" required>
				<option value="0" {{ isset($productGroup) && !old('public', $productGroup->public) ? 'selected' : '' }}>{{ __('messages.no') }}</option>
				<option value="1" {{ isset($productGroup) && old('public', $productGroup->public) ? 'selected' : '' }}>{{ __('messages.yes') }}</option>
			</x-select>
			<x-input-error :messages="$errors->get('public')" />
		</div>
		<div>
			<x-input-label for="priority" :value="__('messages.priority')" />
			<x-text-input id="priority" name="priority" type="number" maxlength="3" min="0" step="1" max="999" :value="isset($productGroup) ? old('priority', $productGroup->priority) : 1" />
			<x-input-error :messages="$errors->get('title_h1')" />
		</div>
		@foreach ($languages as $lang)
			<div x-show="lang == 'tab-{{ $lang->locale }}'">
				<x-input-label for="title-{{ $lang->locale }}" :required="true" :value="__('messages.title')" />
				@if ($lang->default)
					<x-text-input id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" required autofocus />
				@else
					<x-text-input id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" />
				@endif
				<x-input-error :messages="$errors->get('title')" />
			</div>
		@endforeach
	</div>
	<div class="relative col-span-2 px-6 pt-2 pb-6 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
		@foreach ($languages as $lang)
			<div class="area-value space-y-4" data-locale-type={{ $lang->locale }} x-show="lang == 'tab-{{ $lang->locale }}'">
				<div class="locale-active absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 rounded-full sm:shadow bg-white dark:bg-black">
					<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
				</div>
				<input type="hidden" name="locale[]" value="{{ $lang->locale }}" />
				<div class="block-value">
					<x-input-label for="value-{{ $lang->locale }}" :required="$lang->default ? true : false" :value="__('messages.value')" />
					<div class="flex items-center justify-start">
						<x-text-input id="value-{{ $lang->locale }}" class="flex-1" name="value[]" type="text" maxlength="255" :required="$lang->default ? true : false" />
						<button type="button" data-id-type="" class="hidden relative top-0.5 ml-1 flex items-center justify-center w-[42px] h-[42px] rounded bg-pink-600 text-white dark:bg-pink-700">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
							</svg>
						</button>
					</div>
					<x-input-error :messages="$errors->get('value')" />
				</div>
			</div>
		@endforeach
		<div class="flex items-center justify-end mt-6">
			<x-secondary-button class="btn-add-value">{{ __('messages.add_value') }}</x-secondary-button>
		</div>
	</div>
</div>	