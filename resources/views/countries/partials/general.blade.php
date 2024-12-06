<x-card class="space-y-4">
	<x-slot name="content">

		<div>
			<x-input-label for="public" :required="true" :value="__('public')" />
			<x-select name="public" id="public" required>
				<option value="0" {{ !$country->public ? 'selected': '' }}>{{ __('no') }}</option>
				<option value="1" {{ $country->public ? 'selected': '' }}>{{ __('yes') }}</option>
			</x-select>
			<x-input-error :messages="$errors->get('public')" />
		</div>
		<input type="hidden" name="default" value="{{ isset($default) ? $default : '' }}" />
		<div>
			<x-input-label for="delivery" :required="true" :value="__('delivery')" />
			<x-select name="delivery" id="delivery" required>
				<option value="0" {{ !$country->delivery ? 'selected': '' }}>{{ __('no') }}</option>
				<option value="1" {{ $country->delivery ? 'selected': '' }}>{{ __('yes') }}</option>
			</x-select>
			<x-input-error :messages="$errors->get('delivery')" />
		</div>
		<div>
			<x-input-label for="code" :required="true" :value="__('code')" />
			<x-text-input id="code" name="code" type="text" maxlength="3" :value="old('code', $country->code)" required />
			<x-input-error :messages="$errors->get('localname')" />
		</div>
		<div>
			<x-input-label for="name" :required="true" :value="__('name')" />
			<x-text-input id="name" name="name" type="text" maxlength="64" :value="old('name', $country->name)" required />
			<x-input-error :messages="$errors->get('localname')" />
		</div>
		<div>
			<x-input-label for="localname" :required="true" :value="__('localname')" />
			<x-text-input id="localname" name="localname" type="text" maxlength="64" :value="old('localename', $country->localname)" required />
			<x-input-error :messages="$errors->get('localname')" />
		</div>

	</x-slot>
</x-card>