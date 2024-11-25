<x-card class="relative pt-8 lg:pt-4">
	<x-slot name="content">
		@foreach ($languages as $lang)
			<div x-show="lang == 'tab-{{ $lang->locale }}'">
				<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 z-50 rounded-full sm:shadow bg-white dark:bg-black">
					<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
				</div>
				<div>
					<textarea id="content-{{ $lang->locale }}" class="content" name="content[]"></textarea>
					<x-input-error :messages="$errors->get('content')" />
				</div>
			</div>
		@endforeach
	</x-slot>
</x-card>

@push('slotscript')
	<script type="text/javascript">
		$(document).ready(function() {
			setTimeout(function() {
				$('.content').trumbowyg();
			}, 500);
		});
	</script>
@endpush