<x-app-layout>

	<x-slot name="meta_title">{{ __('messages.new_post') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.new_post') }}</x-slot>

	<x-slot name="header">
		<div class="flex items-center justify-between">
			<h2 class="font-semibold text-xl leading-tight text-gray-800 dark:text-gray-200">
				{{ __('messages.new_post') }}
			</h2>
			<div class="flex justify-center items-center px-2">
				<button form="form-store" type="submit" class="mr-2 text-teal-600 hover:text-teal-700">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
					</svg>
				</button>
				<a href="{{ route('post.index') }}" class="text-pink-600 hover:text-pink-700">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
					</svg>
				</a>
			</div>
		</div>
    </x-slot>

	<div class="max-w-7xl mx-auto mt-6 mb-12 sm:px-6 lg:px-8" x-data="{ tab: 'tab-{{ app()->getLocale() }}' }">
		<div class="flex items-center justify-center flex-wrap mx-2 mb-4">
			@foreach ($languages as $lang)
				<div
					class="lang-tab-{{ $lang->locale }} w-fit mx-0.5 mb-2 p-3 rounded-full hover:cursor-pointer opacity-100 hover:bg-gray-50 dark:hover:bg-gray-950" @click.prevent="tab = 'tab-{{ $lang->locale }}'"
					:class="{ 'bg-white dark:bg-black': tab == 'tab-{{ $lang->locale }}'}"
				>
					<img src="{{ asset('/storage/flags/'. $lang->flag) }}" class="w-6" />
				</div>
			@endforeach
		</div>
		<div class="p-6 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
			<form method="POST" action="{{ route('post.store') }}" id="form-store" enctype="multipart/form-data" x-data="{ title : '' }">
				@csrf
				@foreach ($languages as $lang)
					<div x-show="tab == 'tab-{{ $lang->locale }}'">
						<div class="grid gap-4 grid-cols-1 lg:grid-cols-2">
							<div>
								<div class="grid gap-4 grid-cols-1 sm:grid-cols-2 mb-4">
									<div class="{{ !$lang->default ? 'col-span-2' : '' }}">
										<x-input-label for="locale-{{ $lang->locale }}">{{ __('messages.language') }}</x-input-label>
										<x-text-input id="locale-{{ $lang->locale }}" type="text" maxlength="255" :value="$lang->name" disabled />
										<input type="hidden" name="locale[]" value="{{ $lang->locale }}" />
										<x-input-error :messages="$errors->get('locale')" />
									</div>
									@if ($lang->default)
										<div>
											<x-input-label for="public-{{ $lang->locale }}" :required="$lang->default ? true : false">{{ __('messages.public') }}</x-input-label>
											<x-select name="public" id="public-{{ $lang->locale }}" class="public" required>
												<option value="0">{{ __('messages.no') }}</option>
												<option value="1">{{ __('messages.yes') }}</option>
											</x-select>
											<x-input-error :messages="$errors->get('public')" />
										</div>
									@endif
								</div>
								<div class="mb-4">
									<x-input-label for="title-{{ $lang->locale }}" :required="true">{{ __('messages.title') }}</x-input-label>
									@if ($lang->default)
										<x-text-input x-model="title" id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" required autofocus />
									@else
										<x-text-input id="title-{{ $lang->locale }}" name="title[]" type="text" maxlength="255" />
									@endif
									<x-input-error :messages="$errors->get('title')" />
								</div>
								@if ($lang->default)
									<div class="mb-4">
										<x-input-label for="slug-{{ $lang->locale }}" :required="true">{{ __('messages.slug') }}</x-input-label>
										<x-text-input x-slug="title" id="slug-{{ $lang->locale }}" name="slug" type="text" class="slug" maxlength="255" required />
										<x-input-error :messages="$errors->get('slug')" />
									</div>
								@endif
								<div class="mb-4">
									<x-input-label for="title-h1-{{ $lang->locale }}">{{ __('messages.title_h1') }}</x-input-label>
									<x-text-input id="title-h1-{{ $lang->locale }}" name="title_h1[]" type="text" maxlength="255" placeholder="blank = value from title" />
									<x-input-error :messages="$errors->get('title_h1')" />
								</div>
								<div class="mb-4">
									<x-input-label for="meta-title-{{ $lang->locale }}">{{ __('messages.meta_title') }}</x-input-label>
									<x-text-input id="meta-title-{{ $lang->locale }}" name="meta_title[]" type="text" maxlength="255" placeholder="blank = value from title" />
									<x-input-error :messages="$errors->get('meta_title')" />
								</div>
								<div class="mb-4">
									<x-input-label for="meta-desc-{{ $lang->locale }}">{{ __('messages.meta_description') }}</x-input-label>
									<x-text-input id="meta-desc-{{ $lang->locale }}" name="meta_desc[]" type="text" maxlength="255" />
									<x-input-error :messages="$errors->get('meta_desc')" />
								</div>
							</div>
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
						</div>

						<x-input-label for="content-{{ $lang->locale }}" class="mb-0.5">{{ __('messages.content') }}</x-input-label>
						<textarea id="content-{{ $lang->locale }}" class="content" name="content[]" rows="10"></textarea>
						<x-input-error :messages="$errors->get('content')" />
					</div>
				@endforeach
			</form>
        </div>
    </div>
	@push('slotscript')
		<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
		<script>
			var skin = 'light';
			if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
				skin = 'dark';
			}
			tinymce.init({
				selector: 'textarea',
				skin: skin == 'dark' ? "oxide-dark" : "oxide",
				content_css: skin == 'dark' ? "dark" : "default",
				plugins: 'powerpaste casechange searchreplace autolink directionality advcode visualblocks visualchars image link media mediaembed codesample table charmap pagebreak nonbreaking anchor tableofcontents insertdatetime advlist lists checklist wordcount tinymcespellchecker editimage help formatpainter permanentpen charmap linkchecker emoticons advtable export autosave',
				toolbar: 'undo redo print spellcheckdialog formatpainter | blocks fontfamily fontsize | bold italic underline forecolor backcolor | link image | alignleft aligncenter alignright alignjustify lineheight | checklist bullist numlist indent outdent | removeformat',
				height: '700px',
			});
		</script>
    @endpush
</x-app-layout>