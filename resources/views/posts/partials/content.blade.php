@foreach ($languages as $lang)
	<div
		class="relative pt-8 pb-6 px-2 sm:p-4 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100"
		x-show="lang == 'tab-{{ $lang->locale }}'"
	>
		<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 z-50 rounded-full sm:shadow bg-white dark:bg-black">
			<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
		</div>
		<div>
			<textarea id="content-{{ $lang->locale }}" class="content" name="content[]" rows="10"></textarea>
			<x-input-error :messages="$errors->get('content')" />
		</div>
	</div>
@endforeach

@push('slotscript')
	<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
	<script>
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