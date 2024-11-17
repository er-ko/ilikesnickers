<x-card>
	<x-slot name="content">
		@foreach ($translates as $key => $value)
			<div class="mb-3">
				<x-input-label for="{{ $key }}" :required="false" :value="$key" class="lowercase" />
				<x-text-input id="{{ $key }}" name="translate_val[]" type="text" max="512" :value="$value" />
				<x-input-error :messages="$errors->get($key)" />
				<input type="hidden" name="translate_key[]" value="{{ $key }}" />
			</div>
		@endforeach
	</x-slot>
</x-card>