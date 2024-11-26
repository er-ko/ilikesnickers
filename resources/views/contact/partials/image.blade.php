<x-card class="lg:p-8 w-full">
	<x-slot name="content">
		<h2 class="text-lg uppercase tracking-widest mb-4 lg:mb-6">{{ __('image') }}</h2>
		<label
			for="image"
			class="relative flex flex-col justify-center items-center h-full py-8 rounded-md hover:cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/20 border border-gray-300 dark:border-gray-700"
		>
			@if (isset($contact['image']) && old('image', $contact['image']))
				<img src="{{ asset('/storage/contacts/'. old('image', $contact['image'])) }}" class="absolute top-2 right-2 max-w-24 sm:rounded-lg" />
			@endif
			<span class="mb-2">{{ __('drop_image_here') }}</span>{{ __('or') }}
			<input type="file" name="image" id="image" class="mt-4 p-2 w-64 rounded-lg dark:text-gray-500 bg-white dark:bg-gray-900 border border-gray-300 dark:border-slate-700" accept="image/*" />
		</label>
	</x-slot>
</x-card>