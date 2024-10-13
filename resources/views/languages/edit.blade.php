<x-app-layout>

	<x-slot name="meta_title">{{ __('messages.edit') .': '. $language->name }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.language') }}</x-slot>

	<x-slot name="header">
		<div class="flex items-center justify-between">
			<h2 class="font-semibold text-xl leading-tight text-gray-800 dark:text-gray-200">
				{{ __('messages.edit_language') }}
			</h2>
			<div class="flex justify-center items-center px-2">
				<button form="form-store" type="submit" class="mr-2 text-teal-600 hover:text-teal-700">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
					</svg>
				</button>
				<a href="{{ route('language.index') }}" class="text-pink-600 hover:text-pink-700">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
					</svg>
				</a>
			</div>
		</div>
    </x-slot>

	<div class="max-w-7xl mx-auto my-12 sm:px-6 lg:px-8">
		<div class="flex items-center justify-center mb-8 font-semibold text-xl text-black dark:text-white">
			<img src="{{ asset('/storage/flags/'. $language->flag) }}" class="w-6 me-3" />
			<span>{{ $language->name }}</span>
		</div>
		<div class="p-4 sm:p-6 lg:p-8 shadow-sm sm:rounded-lg text-black bg-white dark:text-gray-200 dark:bg-gray-800">
			<form method="POST" action="{{ route('language.update', $language) }}" id="form-store">
				@csrf
				@method('patch')
				<div class="grid gap-x-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
					<div>
						<div class="mb-4">
							<x-input-label for="locale" :required="true">{{ __('messages.locale') }} (ISO 639-1)</x-input-label>
							<x-text-input id="locale" name="locale" type="text" maxlength="2" :value="$language->locale" required />
							<x-input-error :messages="$errors->get('locale')" />
						</div>
						<div class="mb-4">
							<x-input-label for="locale-3" :required="true">{{ __('messages.locale') }} (ISO 639-2)</x-input-label>
							<x-text-input id="locale_3" name="locale_3" type="text" maxlength="3" :value="$language->locale_3" required />
							<x-input-error :messages="$errors->get('locale_3')" />
						</div>
					</div>
					<div>
						<div class="mb-4">
							<x-input-label for="time-format" :required="true">{{ __('messages.time_format') }}</x-input-label>
							<x-select name="time_format" id="time-format">
								<option value="12" {{ $language->time_format === '12' ? 'selected': '' }}>{{ '12h' }}</option>
								<option value="24" {{ $language->time_format === '24' ? 'selected': '' }}>{{ '24h' }}</option>
							</x-select>
							<x-input-error :messages="$errors->get('time_format')" />
						</div>
						<div class="mb-4">
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
					<div>
						<div class="mb-4">
							<x-input-label for="decimal-point" :required="true">{{ __('messages.decimal_point') }}</x-input-label>
							<x-select name="decimal_point" id="decimal-point" required>
								<option value="." {{ $language->decimal_point === '.' ? 'selected': '' }}>{{ __('messages.dot') }}</option>
								<option value="," {{ $language->decimal_point === ',' ? 'selected': '' }}>{{ __('messages.comma') }}</option>
							</x-select>
							<x-input-error :messages="$errors->get('decimal_point')" />
						</div>
						<div class="mb-4">
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
					<div>
						<div class="mb-4">
							<x-input-label for="default" :required="true">{{ __('messages.default') }}</x-input-label>
							<x-select name="default" id="default" required>
								@foreach ($languages as $lang)
									<option value="{{ $lang->locale }}" {{ $lang->default ? 'selected': '' }}>{{ $lang->name }}</option>
								@endforeach
							</x-select>
							<x-input-error :messages="$errors->get('default')" />
						</div>
						<div class="mb-4">
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