<div class="grid gap-0 lg:gap-4 grid-cols-1 lg:grid-cols-3">
	<x-card>
		<x-slot name="content">
			<div>
				<x-input-label for="public" :required="true" :value="__('messages.public')" />
				<x-select name="public" id="public" class="public" required>
					<option value="0" {{ isset($customerGroup) && !old('public', $customerGroup->public) ? 'selected' : '' }}>{{ __('messages.no') }}</option>
					<option value="1" {{ isset($customerGroup) && old('public', $customerGroup->public) ? 'selected' : '' }}>{{ __('messages.yes') }}</option>
				</x-select>
				<x-input-error :messages="$errors->get('public')" />
			</div>
		</x-slot>
	</x-card>
	<x-card class="relative col-span-2">
		<x-slot name="content">
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
		</x-slot>
	</x-card>
</div>