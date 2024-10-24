<x-app-layout>

	<x-slot name="meta_title">{{ __('messages.edit') .': '. $language->name }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.language') }}</x-slot>
	<x-slot name="title">{{ __('messages.edit_language') }}</x-slot>

	<x-slot name="submit">
		<button form="form-store" type="submit" class="p-2.5 pl-4 rounded-l-full duration-300 bg-teal-600 text-white hover:bg-teal-700 dark:bg-teal-700 dark:hover:bg-teal-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
			</svg>
		</button>
		<a href="{{ route('language.index') }}" class="py-2.5 px-3 duration-300 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-700 dark:hover:bg-pink-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
			</svg>
		</a>
	</x-slot>

	<div>
		<div class="relative pt-7 pb-6 px-2 sm:p-4 shadow-sm sm:rounded-lg text-black bg-white dark:text-gray-200 dark:bg-gray-800">
			<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 rounded-full sm:shadow bg-white dark:bg-black">
				<img src="{{ asset('/storage/flags/'. $language->flag) }}" />
			</div>
			<form method="POST" action="{{ route('language.update', $language) }}" id="form-store">
				@csrf
				@method('patch')
				<div class="grid gap-4 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
					<div class="flex flex-col space-y-4">
						<div>
							<x-input-label for="locale" :required="true">{{ __('messages.locale') }} (ISO 639-1)</x-input-label>
							<x-text-input id="locale" name="locale" type="text" maxlength="2" :value="$language->locale" required />
							<x-input-error :messages="$errors->get('locale')" />
						</div>
						<div>
							<x-input-label for="locale-3" :required="true">{{ __('messages.locale') }} (ISO 639-2)</x-input-label>
							<x-text-input id="locale_3" name="locale_3" type="text" maxlength="3" :value="$language->locale_3" required />
							<x-input-error :messages="$errors->get('locale_3')" />
						</div>
					</div>
					<div class="flex flex-col space-y-4">
						<div>
							<x-input-label for="time-format" :required="true">{{ __('messages.time_format') }}</x-input-label>
							<x-select name="time_format" id="time-format">
								<option value="12" {{ $language->time_format === '12' ? 'selected': '' }}>{{ '12h' }}</option>
								<option value="24" {{ $language->time_format === '24' ? 'selected': '' }}>{{ '24h' }}</option>
							</x-select>
							<x-input-error :messages="$errors->get('time_format')" />
						</div>
						<div>
							<x-input-label for="date-format" :required="true">{{ __('messages.date_format') }}</x-input-label>
							<x-select name="date_format" id="date-format" required>
								<option value="Y-m-d" {{ $language->date_format === 'Y-m-d' ? 'selected': '' }}>{{ 'Y-m-d' }}</option>
								<option value="y-m-d" {{ $language->date_format === 'y-m-d' ? 'selected': '' }}>{{ 'y-m-d' }}</option>
								<option value="d/m/Y" {{ $language->date_format === 'd/m/Y' ? 'selected': '' }}>{{ 'd/m/Y' }}</option>
								<option value="d/m/y" {{ $language->date_format === 'd/m/y' ? 'selected': '' }}>{{ 'd/m/y' }}</option>
								<option value="d.m.Y" {{ $language->date_format === 'd.m.Y' ? 'selected': '' }}>{{ 'd.m.Y' }}</option>
								<option value="d.m.y" {{ $language->date_format === 'd.m.y' ? 'selected': '' }}>{{ 'd.m.y' }}</option>
							</x-select>
							<x-input-error :messages="$errors->get('date_format')" />
						</div>
					</div>
					<div class="flex flex-col space-y-4">
						<div>
							<x-input-label for="decimal-point" :required="true">{{ __('messages.decimal_point') }}</x-input-label>
							<x-select name="decimal_point" id="decimal-point" required>
								<option value="." {{ $language->decimal_point === '.' ? 'selected': '' }}>{{ __('messages.dot') }}</option>
								<option value="," {{ $language->decimal_point === ',' ? 'selected': '' }}>{{ __('messages.comma') }}</option>
							</x-select>
							<x-input-error :messages="$errors->get('decimal_point')" />
						</div>
						<div>
							<x-input-label for="thousand-separator" :required="true">{{ __('messages.thousand_separator') }}</x-input-label>
							<x-select name="thousand_separator" id="thousand-separator" required>
								<option value="n" {{ $language->thousand_separator === 'n' ? 'selected': '' }}>{{ __('messages.none') }}</option>
								<option value="." {{ $language->thousand_separator === '.' ? 'selected': '' }}>{{ __('messages.dot') }}</option>
								<option value="," {{ $language->thousand_separator === ',' ? 'selected': '' }}>{{ __('messages.comma') }}</option>
								<option value="s" {{ $language->thousand_separator === 's' ? 'selected': '' }}>{{ __('messages.space') }}</option>
							</x-select>
							<x-input-error :messages="$errors->get('thousand_separator')" />
						</div>
					</div>
					<div class="flex flex-col space-y-4">
						<div>
							<x-input-label for="default" :required="true">{{ __('messages.default') }}</x-input-label>
							<x-select name="default" id="default" required>
								@foreach ($languages as $lang)
									<option value="{{ $lang->locale }}" {{ $lang->default ? 'selected': '' }}>{{ $lang->name }}</option>
								@endforeach
							</x-select>
							<x-input-error :messages="$errors->get('default')" />
						</div>
						<div>
							<x-input-label for="public" :required="true">{{ __('messages.public') }}</x-input-label>
							<x-select name="public" id="public" required>
								<option value="0" {{ !$language->public ? 'selected' : '' }}>{{ __('messages.no') }}</option>
								<option value="1" {{ $language->public ? 'selected' : '' }}>{{ __('messages.yes') }}</option>
							</x-select>
							<x-input-error :messages="$errors->get('public')" />
						</div>
					</div>
					<div>
						<x-input-label for="localname" :required="true">{{ __('messages.localname') }}</x-input-label>
						<x-text-input id="localname" name="localname" type="text" maxlength="64" :value="$language->localname" required />
						<x-input-error :messages="$errors->get('localname')" />
					</div>
					<div>
						<x-input-label for="priority" :required="true">{{ __('messages.priority') }}</x-input-label>
						<x-text-input id="priority" name="priority" type="number" maxlength="3" min="1" step="1" max="255" :value="$language->priority" required />
						<x-input-error :messages="$errors->get('localname')" />
					</div>
				</div>
			</form>
		</div>
	</div>
</x-app-layout>