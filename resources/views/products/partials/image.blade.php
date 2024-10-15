<div class="pb-10">
	<div class="px-1 block font-medium text-sm uppercase mb-1 text-gray-700 dark:text-gray-300">{{ __('messages.image') }}</div>
	<label
		for="image-{{ $lang->locale }}"
		class="relative flex flex-col justify-center items-center h-full rounded-md hover:cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/20 border border-gray-300 dark:border-gray-700"
	>
		<span class="mb-2">{{ __('messages.drop_image_here') }}</span>{{ __('messages.or') }}
		<input type="file" name="image" id="image-{{ $lang->locale }}" class="mt-4 p-2 rounded-lg dark:text-gray-500 bg-white dark:bg-gray-900 border border-gray-300 dark:border-slate-700" accept="image/*" @if (!$lang->default) disabled @endif>
	</label>
</div>