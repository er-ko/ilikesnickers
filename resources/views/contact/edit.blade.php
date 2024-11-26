<x-app-layout>

	<x-slot name="meta_title">{{ __('contact') }}</x-slot>
	<x-slot name="meta_desc">{{ __('contact') }}</x-slot>
    <x-slot name="title">{{ __('contact') }}</x-slot>

	<x-slot name="submit">
		<button form="form-store" type="submit" class="p-2.5 pl-4 rounded-l-full duration-300 bg-teal-600 text-white hover:bg-teal-700 dark:bg-teal-700 dark:hover:bg-teal-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
			</svg>
		</button>
	</x-slot>

	<form method="POST" action="{{ route('contact.update', $contact) }}" id="form-store" enctype="multipart/form-data">
		@csrf
		@method('patch')
		<div class="flex items-start justify-start flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4">
			<div class="flex-1 w-full space-y-4">
				@include('contact.partials.general')
				@include('contact.partials.social')
			</div>
			<div class="opening-hours flex flex-col items-center justify-center space-y-4">
				@include('contact.partials.image')
				@include('contact.partials.opening_hours')
			</div>
		</div>
	</form>

	@push('slotscript')
		<script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
		<script>
			$(document).ready(function(){
				$('#phone').inputmask('+999 999 999 999');
				$('#whatsapp').inputmask('+999 999 999 999');
				$('.opening-hours input').inputmask('99:99 - 99:99');
			});
		</script>
    @endpush

</x-app-layout>