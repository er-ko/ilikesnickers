<div id="image-block-{{ $lang->locale }}" class="image-block w-full">
	<div class="px-1 block font-medium text-sm uppercase mb-1 text-gray-700 dark:text-gray-300">{{ __('messages.image') }}</div>
	<label
		for="image-{{ $lang->locale }}"
		class="relative flex flex-col justify-center items-center h-full py-16 rounded-md hover:cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/20 border border-gray-300 dark:border-gray-700"
	>
		<span class="mb-2">{{ __('messages.drop_image_here') }}</span>{{ __('messages.or') }}
		<input type="file" name="image_{{ $lang->locale }}[]" id="image-{{ $lang->locale }}" class="mt-4 p-2 rounded-lg dark:text-gray-500 bg-white dark:bg-gray-900 border border-gray-300 dark:border-slate-700" accept="image/*" @if (!$lang->default) disabled @endif>
	</label>
</div>
<div class="flex items-center justify-end mt-4">
	<x-secondary-button id="add-image-{{ $lang->locale }}">{{ __('messages.add_image') }}</x-secondary-button>
</div>
<p class="mt-4 text-center">pokud obrázek v dané jazykové mutaci nebude vytvořen, bude převzat z výchozí</p>

@push('slotscript')
<script>
	$(document).ready(function(){
		$('#add-image-{{ $lang->locale }}').click(function(){
			$('#image-block-{{ $lang->locale }}').append($('.image-block-{{ $lang->locale }}').text());
		});
	});
</script>
@endpush