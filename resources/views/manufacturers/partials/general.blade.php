<div class="grid gap-0 lg:gap-4 grid-cols-1 lg:grid-cols-3">
	<div class="mb-4 lg:mb-0 p-6 space-y-4 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
		<div>
			<x-input-label for="name" :required="true" :value="__('messages.name')" />
			<x-text-input id="name" name="name" type="text" maxlength="255" required :value="isset($manufacturer) ? old('name', $manufacturer->name) : ''" />
			<x-input-error :messages="$errors->get('slug')" />
		</div>
		<div>
			<x-input-label for="slug" :required="true" :value="__('messages.slug')" />
			<x-text-input id="slug" name="slug" type="text" maxlength="255" required :value="isset($manufacturer) ? old('slug', $manufacturer->slug) : ''" />
			<x-input-error :messages="$errors->get('slug')" />
		</div>
		<div>
			<div class="px-1 block font-medium text-sm uppercase mb-1 text-gray-700 dark:text-gray-300">{{ __('messages.image') }}</div>
			<label
				for="image-{{ $lang->locale }}"
				class="relative flex flex-col justify-center items-center h-full py-8 rounded-md hover:cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/20 border border-gray-300 dark:border-gray-700"
			>
				@if (isset($manufacturer) && old('image', $manufacturer->image))
					<img src="{{ asset('/storage/manufacturers/'. old('image', $manufacturer->image)) }}" class="absolute top-2 right-2 max-w-24 sm:rounded-lg" />
				@endif
				<span class="mb-2">{{ __('messages.drop_image_here') }}</span>{{ __('messages.or') }}
				<input type="file" name="image" id="image-{{ $lang->locale }}" class="mt-4 p-2 w-64 rounded-lg dark:text-gray-500 bg-white dark:bg-gray-900 border border-gray-300 dark:border-slate-700" accept="image/*" />
			</label>
		</div>
	</div>
	<div class="relative col-span-2 p-6 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
		@foreach ($languages as $lang)
			<div x-show="lang == 'tab-{{ $lang->locale }}'">
				<input type="hidden" name="locale[]" value="{{ $lang->locale }}" />
				<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 rounded-full sm:shadow bg-white dark:bg-black">
					<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
				</div>
				<div>
					<x-input-label for="content-{{ $lang->locale }}" class="mb-1" :required="false" :value="__('messages.content')" />
					<textarea id="content-{{ $lang->locale }}" class="content" name="content[]" rows="10"></textarea>
					<x-input-error :messages="$errors->get('content')" />
				</div>
			</div>
		@endforeach
		</div>
</div>
@push('slotscript')
	<script src="{{ asset('js/slugify.js') }}"></script>
	<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
	<script>
		$(document).ready(function(){
			$('#name').keyup(function(){
				var slug = $(this).val();
				$('#slug').val(slug.slugify());
			});
		});

		var skin = 'light';
		if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
			skin = 'dark';
		}
		tinymce.init({
			selector: '.content',
			skin: skin == 'dark' ? "oxide-dark" : "oxide",
			content_css: skin == 'dark' ? "dark" : "default",
			plugins: 'searchreplace autolink directionality visualblocks visualchars image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap emoticons autosave',
			toolbar: 'undo redo print spellcheckdialog formatpainter | locks fontfamily fontsize | bold italic underline forecolor backcolor | link image | alignleft aligncenter alignright alignjustify lineheight | checklist bullist numlist indent outdent | removeformat',
			height: '700px',
		});
	</script>
@endpush