<div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 space-x-0 lg:space-x-4">
	<x-card class="w-full max-w-2xl lg:max-w-sm h-fit space-y-4">
		<x-slot name="content">
			<div>
				<x-input-label for="public" :required="true" :value="__('public')" />
				<x-select name="public" id="public" class="public" required autofocus>
					<option value="0" {{ isset($post) && !old('public', $post->public) ? 'selected' : '' }}>{{ __('no') }}</option>
					<option value="1" {{ isset($post) && old('public', $post->public) ? 'selected' : '' }}>{{ __('yes') }}</option>
				</x-select>
				<x-input-error :messages="$errors->get('public')" />
			</div>
			<div>
				<x-input-label for="slug" :required="true" :value="__('slug')" />
				<x-text-input id="slug" name="slug" type="text" maxlength="255" required :value="isset($post) ? old('slug', $post->slug) : ''" />
				<x-input-error :messages="$errors->get('slug')" />
			</div>
			<div>
				<div class="px-1 block font-medium text-sm uppercase mb-1 text-gray-700 dark:text-gray-300">{{ __('image') }}</div>
				<label
					for="image-{{ $lang->locale }}"
					class="relative flex flex-col justify-center items-center h-full py-8 rounded-md hover:cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/20 border border-gray-300 dark:border-gray-700"
				>
					@if (isset($post) && old('image', $post->image))
						<img src="{{ asset('/storage/posts/'. old('image', $post->image)) }}" class="absolute top-2 right-2 max-w-24 rounded-lg" />
					@endif
					<span class="mb-2">{{ __('drop_image_here') }}</span>{{ __('or') }}
					<input type="file" name="image" id="image-{{ $lang->locale }}" class="mt-4 p-2 w-64 rounded-lg dark:text-gray-500 bg-white dark:bg-gray-900 border border-gray-300 dark:border-slate-700" accept="image/*" />
				</label>
			</div>
		</x-slot>
	</x-card>
	<x-card class="h-fit relative flex-1 pt-8 sm:pt-4">
		<x-slot name="content">
			@foreach ($languages as $lang)
				<div class="space-y-4" x-show="lang == 'tab-{{ $lang->locale }}'">
					<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 sm:shadow rounded-full bg-white dark:bg-black">
						<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
					</div>
					<input type="hidden" name="locale[]" value="{{ $lang->locale }}" />
					<div class="flex items-end justify-start space-x-1 !mt-0">
						<div class="flex-1">
							<x-input-label for="title-{{ $lang->locale }}" :required="$lang->default ? true : false" :value="__('title')" />
							<x-text-input id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" :required="$lang->default ? true : false" />
							<x-input-error :messages="$errors->get('title')" />
						</div>
						<x-primary-button type="button" class="slug-create">{{ __('slug') }}</x-primary-button>
					</div>
					<div>
						<x-input-label for="title-h1-{{ $lang->locale }}" :value="__('title_h1')" />
						<x-text-input id="title-h1-{{ $lang->locale }}" name="title_h1[]" type="text" maxlength="255" placeholder="{{ __('blank_value_from_title') }}" />
						<x-input-error :messages="$errors->get('title_h1')" />
					</div>
					<div>
						<x-input-label for="meta-title-{{ $lang->locale }}" :value="__('meta_title')" />
						<x-text-input id="meta-title-{{ $lang->locale }}" name="meta_title[]" type="text" maxlength="255" placeholder="{{ __('blank_value_from_title') }}" />
						<x-input-error :messages="$errors->get('meta_title')" />
					</div>
					<div>
						<x-input-label for="meta-desc-{{ $lang->locale }}" :value="__('meta_description')" />
						<textarea
							id="meta-desc-{{ $lang->locale }}"
							class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:border-teal-600 dark:focus:ring-teal-600"
							name="meta_desc[]"
							rows="3"
						></textarea>
						<x-input-error :messages="$errors->get('meta_desc')" />
					</div>
				</div>
			@endforeach
		</x-slot>
	</x-card>
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