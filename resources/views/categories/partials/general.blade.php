<div class="grid gap-0 lg:gap-4 grid-cols-1 lg:grid-cols-3">
	<x-card class="space-y-4">
		<x-slot name="content">
			<div>
				<x-input-label for="public" :required="true" :value="__('messages.public')" />
				<x-select name="public" id="public" class="public" required>
					<option value="0" {{ isset($category) && !old('public', $category->public) ? 'selected' : '' }}>{{ __('messages.no') }}</option>
					<option value="1" {{ isset($category) && old('public', $category->public) ? 'selected' : '' }}>{{ __('messages.yes') }}</option>
				</x-select>
				<x-input-error :messages="$errors->get('public')" />
			</div>
			<div>
				<x-input-label for="parent-id" :required="true" :value="__('messages.parent_category')" />
				<x-select name="parent_id" id="parent-id" required>
					<option value="0" {{ isset($category) && !$category->parent_id ? 'selected' : '' }}>{{ __('messages.root') }}</option>
					@foreach ($parents as $parent)
						<option value="{{ $parent->id }}" {{ isset($category) && $category->parent_id ? 'selected' : '' }}>{{ $parent->title }}</option>
					@endforeach
				</x-select>
				<x-input-error :messages="$errors->get('parent_category')" />
			</div>
			<div>
				<x-input-label for="slug" :required="true" :value="__('messages.slug')" />
				<x-text-input id="slug" name="slug" type="text" maxlength="255" required :value="isset($category) ? old('slug', $category->slug) : ''" />
				<x-input-error :messages="$errors->get('slug')" />
			</div>
			<div>
				<div class="px-1 block font-medium text-sm uppercase mb-1 text-gray-700 dark:text-gray-300">{{ __('messages.image') }}</div>
				<label
					for="image-{{ $lang->locale }}"
					class="relative flex flex-col justify-center items-center h-full py-8 rounded-md hover:cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/20 border border-gray-300 dark:border-gray-700"
				>
					@if (isset($category) && old('image', $category->image))
						<img src="{{ asset('/storage/categories/'. old('image', $category->image)) }}" class="absolute top-2 right-2 max-w-24 sm:rounded-lg" />
					@endif
					<span class="mb-2">{{ __('messages.drop_image_here') }}</span>{{ __('messages.or') }}
					<input type="file" name="image" id="image-{{ $lang->locale }}" class="mt-4 p-2 w-64 rounded-lg dark:text-gray-500 bg-white dark:bg-gray-900 border border-gray-300 dark:border-slate-700" accept="image/*" />
				</label>
			</div>	
		</x-slot>
	</x-card>
	<x-card class="relative col-span-2">
		<x-slot name="content">
			@foreach ($languages as $lang)
				<div class="space-y-4" x-show="lang == 'tab-{{ $lang->locale }}'">
					<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 rounded-full sm:shadow bg-white dark:bg-black">
						<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
					</div>
					<input type="hidden" name="locale[]" value="{{ $lang->locale }}" />
					<div class="flex items-end justify-start space-x-1 !mt-0">
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
							rows="1"
						></textarea>
						<x-input-error :messages="$errors->get('meta_desc')" />
					</div>
					<div>
						<x-input-label for="content-{{ $lang->locale }}" :value="__('messages.content')" />
						<textarea
							id="content-{{ $lang->locale }}"
							class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:border-teal-600 dark:focus:ring-teal-600"
							name="content[]"
							rows="3"
						></textarea>
						<x-input-error :messages="$errors->get('content')" />
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