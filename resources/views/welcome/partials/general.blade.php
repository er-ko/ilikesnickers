<div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 space-x-0 sm:space-x-4">
	<x-card class="w-full max-w-xs h-fit flex flex-col space-y-4">
		<x-slot name="content">
			<div>
				<label for="slider-status" class="inline-flex items-center cursor-pointer">
					<input type="checkbox" id="slider-status" name="slider_status" value="1" class="sr-only peer" {{ $slider_status == 1 ? 'checked' : '' }}>
					<div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-teal-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-teal-600"></div>
					<span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('slider') }}</span>
				</label>
				<div>
					<x-input-label for="slider-priority" :required="false" :value="__('priority')" />
					<x-text-input id="slider-priority" class="text-center" name="slider_priority" type="number" min="1" step="1" max="3" :value="$slider_priority" />
					<x-input-error :messages="$errors->get('slider_priority')" />
				</div>
			</div>
			<div>
				<label for="content-status" class="inline-flex items-center cursor-pointer">
					<input type="checkbox" id="content-status" name="content_status" value="1" class="sr-only peer" {{ $content_status == 1 ? 'checked' : '' }}>
					<div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-teal-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-teal-600"></div>
					<span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('content') }}</span>
				</label>
				<div>
					<x-input-label for="content-priority" :required="false" :value="__('priority')" />
					<x-text-input id="content-priority" class="text-center" name="content_priority" type="number" min="1" step="1" max="3" :value="$content_priority" />
					<x-input-error :messages="$errors->get('content_priority')" />
				</div>
			</div>
		</x-slot>
	</x-card>
	<x-card class="h-fit flex-1 relative col-span-2 pt-8 sm:pt-4">
		<x-slot name="content">
			@foreach ($languages as $lang)
				<div x-show="lang == 'tab-{{ $lang->locale }}'">
					<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 z-50 rounded-full sm:shadow bg-white dark:bg-black">
						<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
					</div>
					<input type="hidden" name="locale[]" value="{{ $lang->locale }}" />
					<div class="space-y-4">
						<div>
							<x-input-label for="title-{{ $lang->locale }}" :required="false" :value="__('title')" />
							<x-text-input id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" />
							<x-input-error :messages="$errors->get('title')" />
						</div>
						<div class="{{ !$lang->default ? 'col-span-2' : '' }}">
							<x-input-label for="meta-title-{{ $lang->locale }}">{{ __('meta_title') }}</x-input-label>
							<x-text-input id="meta-title-{{ $lang->locale }}" name="meta_title[]" type="text" maxlength="255" />
							<x-input-error :messages="$errors->get('meta_title')" />
						</div>
						<div>
							<x-input-label for="meta-desc-{{ $lang->locale }}">{{ __('meta_description') }}</x-input-label>
							<x-text-input id="meta-desc-{{ $lang->locale }}" name="meta_desc[]" type="text" maxlength="255" />
							<x-input-error :messages="$errors->get('meta_desc')" />
						</div>
					</div>
				</div>
			@endforeach
		</x-slot>
	</x-card>
</div>