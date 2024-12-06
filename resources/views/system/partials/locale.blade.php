<x-card class="xl:col-span-2">
	<x-slot name="content">
		<div class="max-w-xl space-y-4">
			<div>
				<x-input-label for="country" :required="true" :value="__('default_country')" />
				<x-select name="country_id" id="country" required>
					@foreach ($countries as $country)
						<option value="{{ $country->id }}" {{ $country->id == $default_country ? 'selected' : '' }}>{{ $country->name }}</option>
					@endforeach
				</x-select>
				<x-input-error :messages="$errors->get('country')" />
			</div>
			<div>
				<x-input-label for="language" :required="true" :value="__('default_language')" />
				<x-select name="language_id" id="language" required>
					@foreach ($languages as $language)
						<option value="{{ $language->id }}" {{ $language->id == $default_language ? 'selected' : '' }}>{{ $language->name }}</option>
					@endforeach
				</x-select>
				<x-input-error :messages="$errors->get('language')" />
			</div>
			<div>
				<x-input-label for="currency" :required="true" :value="__('default_currency')" />
				<x-select name="currency_id" id="currency" required>
					@foreach ($currencies as $currency)
						<option value="{{ $currency->id }}" {{ $currency->id == $default_currency ? 'selected' : '' }}>{{ $currency->name }}</option>
					@endforeach
				</x-select>
				<x-input-error :messages="$errors->get('currency')" />
			</div>
		</div>
	</x-slot>
</x-card>