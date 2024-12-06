<x-card class="space-y-4">
	<x-slot name="content">
		<div>
			<x-input-label for="public" :required="true">{{ __('public') }}</x-input-label>
			<x-select name="public" id="public" required>
				<option value="0" {{ !$currency->public ? 'selected' : '' }}>{{ __('no') }}</option>
				<option value="1" {{ $currency->public ? 'selected' : '' }}>{{ __('yes') }}</option>
			</x-select>
			<x-input-error :messages="$errors->get('public')" />
		</div>
		<div>
			<x-input-label for="priority" :required="true">{{ __('priority') }}</x-input-label>
			<x-text-input id="priority" name="priority" type="number" maxlength="3" min="1" step="1" max="255" :value="$currency->priority" required />
			<x-input-error :messages="$errors->get('localname')" />
		</div>
		<div>
			<x-input-label for="code" :required="true">{{ __('code') }}</x-input-label>
			<x-text-input id="code" name="code" type="text" maxlength="3" :value="$currency->code" required readonly />
			<x-input-error :messages="$errors->get('code')" />
		</div>
		<input type="hidden" name="default" value="{{ isset($default) ? $default : '' }}" />
		<div>
			<x-input-label for="symbol" :required="false">{{ __('symbol') }}</x-input-label>
			<x-text-input id="symbol" name="symbol" type="text" maxlength="3" :value="isset($currency->symbol) ? $currency->symbol : ''" />
			<x-input-error :messages="$errors->get('symbol')" />
		</div>
		<div>
			<x-input-label for="symbol-place" :required="false">{{ __('symbol_place') }}</x-input-label>
			<x-select name="symbol_place" id="symbol-place" class="lowercase">
				<option value="prefix" {{ $currency->symbol_place == 'prefix' ? 'selected': '' }}>{{ __('prefix') }}</option>
				<option value="suffix" {{ $currency->symbol_place == 'suffix' ? 'selected': '' }}>{{ __('suffix') }}</option>
			</x-select>
			<x-input-error :messages="$errors->get('symbol_place')" />
		</div>
		<div>
			<x-input-label for="name" :required="true">{{ __('name') }}</x-input-label>
			<x-text-input id="name" name="name" type="text" maxlength="64" :value="$currency->name" required />
			<x-input-error :messages="$errors->get('name')" />
		</div>
		<div>
			<x-input-label for="localname" :required="true">{{ __('localname') }}</x-input-label>
			<x-text-input id="localname" name="localname" type="text" maxlength="64" :value="$currency->localname" required />
			<x-input-error :messages="$errors->get('localname')" />
		</div>
	</x-slot>
</x-card>