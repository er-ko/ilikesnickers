<div class="space-y-4">
	<div>
		<x-input-label for="country" :required="true" :value="__('messages.default_country')" />
		<x-select name="country_id" id="country" required>
			@foreach ($countries as $country)
				<option value="{{ $country->id }}" {{ $country->id === $system->country_id ? 'selected' : '' }}>{{ $country->name }}</option>
			@endforeach
		</x-select>
		<x-input-error :messages="$errors->get('country')" />
	</div>
	<div>
		<x-input-label for="language" :required="true" :value="__('messages.default_language')" />
		<x-select name="language_id" id="language" required>
			@foreach ($languages as $language)
				<option value="{{ $language->id }}" {{ $language->id === $system->language_id ? 'selected' : '' }}>{{ $language->name }}</option>
			@endforeach
		</x-select>
		<x-input-error :messages="$errors->get('language')" />
	</div>
</div>