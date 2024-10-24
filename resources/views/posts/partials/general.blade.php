<div class="grid gap-0 xl:gap-4 grid-cols-1 xl:grid-cols-3">
	<div class="mb-4 xl:mb-0 py-6 px-2 sm:p-4 space-y-4 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
		<div>
			<x-input-label for="public" :required="true" :value="__('messages.public')" />
			<x-select name="public" id="public" class="public" required>
				<option value="0" {{ isset($post) && !old('public', $post->public) ? 'selected' : '' }}>{{ __('messages.no') }}</option>
				<option value="1" {{ isset($post) && old('public', $post->public) ? 'selected' : '' }}>{{ __('messages.yes') }}</option>
			</x-select>
			<x-input-error :messages="$errors->get('public')" />
		</div>
		<div>
			<x-input-label for="slug" :required="true" :value="__('messages.slug')" />
			<x-text-input id="slug" name="slug" type="text" maxlength="255" required :value="isset($post) ? old('slug', $post->slug) : ''" />
			<x-input-error :messages="$errors->get('slug')" />
		</div>
		<div>
			<div class="px-1 block font-medium text-sm uppercase mb-1 text-gray-700 dark:text-gray-300">{{ __('messages.image') }}</div>
			<label
				for="image-{{ $lang->locale }}"
				class="relative flex flex-col justify-center items-center h-full py-8 rounded-md hover:cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/20 border border-gray-300 dark:border-gray-700"
			>
				@if (isset($post) && old('image', $post->image))
					<img src="{{ asset('/storage/posts/'. old('image', $post->image)) }}" class="absolute top-2 right-2 max-w-24 sm:rounded-lg" />
				@endif
				<span class="mb-2">{{ __('messages.drop_image_here') }}</span>{{ __('messages.or') }}
				<input type="file" name="image" id="image-{{ $lang->locale }}" class="mt-4 p-2 w-64 rounded-lg dark:text-gray-500 bg-white dark:bg-gray-900 border border-gray-300 dark:border-slate-700" accept="image/*" />
			</label>
		</div>
	</div>
	<div class="relative col-span-2 pt-3 pb-6 px-2 sm:px-4 sm:pt-0 sm:pb-4 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
		@foreach ($languages as $lang)
			<div class="space-y-4" x-show="lang == 'tab-{{ $lang->locale }}'">
				<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 sm:shadow rounded-full bg-white dark:bg-black">
					<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
				</div>
				<input type="hidden" name="locale[]" value="{{ $lang->locale }}" />
				<div class="flex items-end justify-start space-x-1">
					<div class="flex-1">
						<x-input-label for="title-{{ $lang->locale }}" :required="true" :value="__('messages.title')" />
						@if ($lang->default)
							<x-text-input id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" required autofocus />
						@else
							<x-text-input id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" />
						@endif
						<x-input-error :messages="$errors->get('title')" />
					</div>
					<x-primary-button type="button" class="slug-create">{{ __('messages.slug') }}</x-primary-button>
				</div>
				<div>
					<x-input-label for="title-h1-{{ $lang->locale }}" :value="__('messages.title_h1')" />
					<x-text-input id="title-h1-{{ $lang->locale }}" name="title_h1[]" type="text" maxlength="255" placeholder="blank = value from title" />
					<x-input-error :messages="$errors->get('title_h1')" />
				</div>
				<div>
					<x-input-label for="meta-title-{{ $lang->locale }}" :value="__('messages.meta_title')" />
					<x-text-input id="meta-title-{{ $lang->locale }}" name="meta_title[]" type="text" maxlength="255" placeholder="blank = value from title" />
					<x-input-error :messages="$errors->get('meta_title')" />
				</div>
				<div>
					<x-input-label for="meta-desc-{{ $lang->locale }}" :value="__('messages.meta_description')" />
					<textarea
						id="meta-desc-{{ $lang->locale }}"
						class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:border-teal-600 dark:focus:ring-teal-600"
						name="meta_desc[]"
						rows="3"
					></textarea>
					{{-- <x-text-input id="meta-desc-{{ $lang->locale }}" name="meta_desc[]" type="text" maxlength="255" /> --}}
					<x-input-error :messages="$errors->get('meta_desc')" />
				</div>
			</div>
		@endforeach
	</div>
</div>
@push('slotscript')
	<script src="{{ asset('js/slugify.js') }}"></script>
	<script>
		$(document).ready(function(){
			$('.slug-create').click(function(){
				var slug = $(this).parent().find('input').val();
				$('#slug').val(slug.slugify());
			});
		});
	</script>
@endpush