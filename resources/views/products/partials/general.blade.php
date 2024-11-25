<div class="grid gap-0 xl:gap-4 grid-cols-1 xl:grid-cols-3">
	<x-card class="space-y-4 h-fit mb-4 xl:mb-0">
		<x-slot name="content">
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
				<x-input-label for="slug" :required="true" :value="__('slug')" />
				<x-text-input id="slug" name="slug" type="text" maxlength="255" required :value="isset($page) ? old('slug', $page->slug) : ''" />
				<x-input-error :messages="$errors->get('slug')" />
			</div>
			<div>
				<x-input-label for="manufacturer" :required="true">{{ __('manufacturer') }}</x-input-label>
				<x-select name="manufacturer_id" id="manufacturer" required>
					@foreach ($manufacturers as $manufacturer)
						<option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
					@endforeach
				</x-select>
				<x-input-error :messages="$errors->get('manufacturer')" />
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
		</x-slot>
	</x-card>
	<x-card class="relative col-span-2 h-fit pt-8 sm:pt-4">
		<x-slot name="content">
			@foreach ($languages as $lang)
				<div x-show="lang == 'tab-{{ $lang->locale }}'">
					<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 z-50 rounded-full sm:shadow bg-white dark:bg-black">
						<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
					</div>
					<input type="hidden" name="locale[]" value="{{ $lang->locale }}" />
					<div class="space-y-4">
						<div class="flex items-end justify-start space-x-1 !mt-0">
							<div class="flex-1">
								<x-input-label for="title-{{ $lang->locale }}" :required="$lang->default ? true : false" :value="__('title')" />
								<x-text-input id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" :required="$lang->default ? true : false" />
								<x-input-error :messages="$errors->get('title')" />
							</div>
							<x-primary-button type="button" class="slug-create">{{ __('slug') }}</x-primary-button>
						</div>
						<div>
							<x-input-label for="title-h1-{{ $lang->locale }}">{{ __('messages.title_h1') }}</x-input-label>
							<x-text-input id="title-h1-{{ $lang->locale }}" name="title_h1[]" type="text" maxlength="255" placeholder="blank = value from title" />
							<x-input-error :messages="$errors->get('title_h1')" />
						</div>
						<div class="{{ !$lang->default ? 'col-span-2' : '' }}">
							<x-input-label for="meta-title-{{ $lang->locale }}">{{ __('messages.meta_title') }}</x-input-label>
							<x-text-input id="meta-title-{{ $lang->locale }}" name="meta_title[]" type="text" maxlength="255" placeholder="blank = value from title" />
							<x-input-error :messages="$errors->get('meta_title')" />
						</div>
						<div>
							<x-input-label for="meta-desc-{{ $lang->locale }}">{{ __('messages.meta_description') }}</x-input-label>
							<x-text-input id="meta-desc-{{ $lang->locale }}" name="meta_desc[]" type="text" maxlength="255" />
							<x-input-error :messages="$errors->get('meta_desc')" />
						</div>
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