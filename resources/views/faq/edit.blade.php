<x-app-layout>

	<x-slot name="meta_title">{{ __('edit_faq') }}</x-slot>
	<x-slot name="meta_desc">{{ __('edit_faq') }}</x-slot>
	<x-slot name="title">{{ __('edit_faq') }}</x-slot>

	<x-slot name="submit">
		<button form="form-store" type="submit" class="p-2.5 pl-4 rounded-l-full duration-300 bg-teal-600 text-white hover:bg-teal-700 dark:bg-teal-700 dark:hover:bg-teal-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
			</svg>
		</button>
		<a href="{{ route('faq.index') }}" class="py-2.5 px-3 duration-300 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-700 dark:hover:bg-pink-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
			</svg>
		</a>
	</x-slot>

	<div x-data="{ group: 'tab-general', lang: 'tab-{{ app()->getLocale() }}' }">
		<div class="flex items-center justify-between flex-wrap space-y-4 sm:space-y-0 mb-4">
			<div class="flex items-center justify-center sm:justify-start w-full sm:w-fit dark:text-gray-200">
				<div
					class="w-fit mx-x0.5 py-1 px-3 hover:cursor-pointer rounded-lg" @click.prevent="group = 'tab-general'"
					:class="{ 'bg-black text-white dark:bg-white dark:text-black': group == 'tab-general'}"
				>
					{{ __('general') }}
				</div>
			</div>
			<div class="flex items-center justify-center sm:justify-start flex-nowrap w-full sm:w-fit overflow-auto">
				<div class="flex items-center justify-center flex-nowrap p-2 rounded-lg bg-white dark:bg-gray-800">
					@foreach ($languages as $lang)
						<div
							id="{{ $lang->locale }}"
							class="lang-tab mx-1 duration-300 hover:cursor-pointer opacity-50 hover:opacity-75" @click.prevent="lang = 'tab-{{ $lang->locale }}'"
							:class="{ '!opacity-100': lang == 'tab-{{ $lang->locale }}'}"
						>
							<img src="{{ asset('/storage/flags/'. $lang->flag) }}" class="min-w-[22px]" />
						</div>
					@endforeach
				</div>
			</div>
		</div>
		<div class="relative">
			<form method="POST" action="{{ route('faq.update', $faq) }}" id="form-store">
				@csrf
				@method('patch')
				<div x-show="group == 'tab-general'">
					@include('faq.partials.general')
				</div>
			</form>
        </div>
    </div>
	@push('slotscript')
		<script>
			$(document).ready(function(){
				var locale = "";
				$('.lang-tab').each(function( index ) {
					locale = $(this).attr('id');
					loadData(locale);
				});
			});
			function loadData(locale) {
					$.ajax({
						url: "{{ route('faq.edit', $faq->id) }}",
						type: 'GET',
						dataType: 'json',
						data: {
							locale: locale,
						},
						success: function(data) {
							if (!$.isEmptyObject(data[0])) {
								$('#question-'+ locale).val(data[0].question);
								$('#answer-'+ locale).val(data[0].answer);
							}
						}
					});
				}
		</script>
    @endpush
</x-app-layout>