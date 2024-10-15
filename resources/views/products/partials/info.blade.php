<div class="grid gap-4 grid-cols-1 sm:grid-cols-2 mb-4">
	<div>
		<x-input-label for="title-{{ $lang->locale }}" :required="true">{{ __('messages.title') }}</x-input-label>
		@if ($lang->default)
			<x-text-input x-model="title" id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" required autofocus />
		@else
			<x-text-input id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" />
		@endif
		<x-input-error :messages="$errors->get('title')" />
	</div>
	@if ($lang->default)
		<div>
			<x-input-label for="slug-{{ $lang->locale }}" :required="true">{{ __('messages.slug') }}</x-input-label>
			<x-text-input x-slug="title" id="slug-{{ $lang->locale }}" name="slug" type="text" class="slug" maxlength="255" required />
			<x-input-error :messages="$errors->get('slug')" />
		</div>
	@endif
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
</div>
<div class="mb-4">
	<x-input-label for="meta-desc-{{ $lang->locale }}">{{ __('messages.meta_description') }}</x-input-label>
	<x-text-input id="meta-desc-{{ $lang->locale }}" name="meta_desc[]" type="text" maxlength="255" />
	<x-input-error :messages="$errors->get('meta_desc')" />
</div>
<x-input-label for="content-{{ $lang->locale }}" class="mb-0.5">{{ __('messages.content') }}</x-input-label>
<textarea id="content-{{ $lang->locale }}" class="content" name="content[]" rows="10"></textarea>
<x-input-error :messages="$errors->get('content')" />