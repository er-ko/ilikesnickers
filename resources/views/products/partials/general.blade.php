<div class="grid gap-4 grid-cols-1 sm:grid-cols-4 md:grid-cols-2 lg:grid-cols-4 mb-4">
	<div>
		<x-input-label for="public" :required="true">{{ __('messages.public') }}</x-input-label>
		<x-select name="public" id="public" class="public" required>
			<option value="0">{{ __('messages.no') }}</option>
			<option value="1">{{ __('messages.yes') }}</option>
		</x-select>
		<x-input-error :messages="$errors->get('public')" />
	</div>
	<div>
		<x-input-label for="virtual" :required="true">{{ __('messages.virtual') }}</x-input-label>
		<x-select name="virtual" id="virtual" class="virtual" required>
			<option value="0">{{ __('messages.no') }}</option>
			<option value="1">{{ __('messages.yes') }}</option>
		</x-select>
		<x-input-error :messages="$errors->get('virtual')" />
	</div>
	<div>
		<x-input-label for="code" :required="true">{{ __('messages.code') }}</x-input-label>
		<x-text-input id="code" name="code" type="text" maxlength="6" placeholder="ABC001" required autofocus />
		<x-input-error :messages="$errors->get('code')" />
	</div>
	<div>
		<x-input-label for="sku" :required="false">{{ __('messages.sku') }}</x-input-label>
		<x-text-input id="sku" name="sku" type="text" maxlength="8" placeholder="SKU001" />
		<x-input-error :messages="$errors->get('sku')" />
	</div>
</div>