<x-card class="space-y-4">
	<x-slot name="content">
		<div>
			<x-input-label for="public" :required="true">{{ __('public') }}</x-input-label>
			<x-select name="public" id="public" required>
				<option value="0" {{ !$language->public ? 'selected' : '' }}>{{ __('no') }}</option>
				<option value="1" {{ $language->public ? 'selected' : '' }}>{{ __('yes') }}</option>
			</x-select>
			<x-input-error :messages="$errors->get('public')" />
		</div>
		<div>
			<x-input-label for="priority" :required="true">{{ __('priority') }}</x-input-label>
			<x-text-input id="priority" name="priority" type="number" maxlength="3" min="1" step="1" max="255" :value="$language->priority" required />
			<x-input-error :messages="$errors->get('localname')" />
		</div>
		<div>
			<x-input-label for="locale" :required="true">{{ __('locale') }} (ISO 639-1)</x-input-label>
			<x-text-input id="locale" name="locale" type="text" maxlength="2" :value="$language->locale" required readonly />
			<x-input-error :messages="$errors->get('locale')" />
		</div>
		<input type="hidden" name="default" value="{{ isset($default) ? $default : '' }}" />
		<div>
			<x-input-label for="locale-3" :required="true">{{ __('locale') }} (ISO 639-2)</x-input-label>
			<x-text-input id="locale_3" name="locale_3" type="text" maxlength="3" :value="$language->locale_3" required />
			<x-input-error :messages="$errors->get('locale_3')" />
		</div>
		<div>
			<x-input-label for="localname" :required="true">{{ __('localname') }}</x-input-label>
			<x-text-input id="localname" name="localname" type="text" maxlength="64" :value="$language->localname" required />
			<x-input-error :messages="$errors->get('localname')" />
		</div>
		<div>
			<x-input-label for="time-format" :required="true">{{ __('time_format') }}</x-input-label>
			<x-select name="time_format" id="time-format">
				<option value="12" {{ $language->time_format === '12' ? 'selected': '' }}>{{ '12h' }}</option>
				<option value="24" {{ $language->time_format === '24' ? 'selected': '' }}>{{ '24h' }}</option>
			</x-select>
			<x-input-error :messages="$errors->get('time_format')" />
		</div>
		<div>
			<x-input-label for="date-format" :required="true">{{ __('date_format') }}</x-input-label>
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
		<div>
			<x-input-label for="decimal-point" :required="true">{{ __('decimal_point') }}</x-input-label>
			<x-select name="decimal_point" id="decimal-point" required>
				<option value="." {{ $language->decimal_point === '.' ? 'selected': '' }}>{{ __('dot') }}</option>
				<option value="," {{ $language->decimal_point === ',' ? 'selected': '' }}>{{ __('comma') }}</option>
			</x-select>
			<x-input-error :messages="$errors->get('decimal_point')" />
		</div>
		<div>
			<x-input-label for="thousand-separator" :required="true">{{ __('thousand_separator') }}</x-input-label>
			<x-select name="thousand_separator" id="thousand-separator" required>
				<option value="n" {{ $language->thousand_separator === 'n' ? 'selected': '' }}>{{ __('none') }}</option>
				<option value="." {{ $language->thousand_separator === '.' ? 'selected': '' }}>{{ __('dot') }}</option>
				<option value="," {{ $language->thousand_separator === ',' ? 'selected': '' }}>{{ __('comma') }}</option>
				<option value="s" {{ $language->thousand_separator === 's' ? 'selected': '' }}>{{ __('space') }}</option>
			</x-select>
			<x-input-error :messages="$errors->get('thousand_separator')" />
		</div>
	</x-slot>
</x-card>