<x-app-layout>

	<x-slot name="meta_title">{{ __('welcome') }}</x-slot>
	<x-slot name="meta_desc">{{ __('welcome') }}</x-slot>
	<x-slot name="title">{{ __('welcome') }}</x-slot>

    <x-slot name="submit">
		<button form="form-store" type="submit" class="p-2.5 pl-4 rounded-l-full duration-300 bg-teal-600 text-white hover:bg-teal-700 dark:bg-teal-700 dark:hover:bg-teal-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
			</svg>
		</button>
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
				<div
					class="w-fit mx-0.5 py-1 px-3 hover:cursor-pointer rounded-lg" @click.prevent="group = 'tab-content'"
					:class="{ 'bg-black text-white dark:bg-white dark:text-black': group == 'tab-content'}"
				>
					{{ __('content') }}
				</div>
				<div
					class="w-fit mx-0.5 py-1 px-3 hover:cursor-pointer rounded-lg" @click.prevent="group = 'tab-slider'"
					:class="{ 'bg-black text-white dark:bg-white dark:text-black': group == 'tab-slider'}"
				>
					{{ __('slider') }}
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
			<form method="POST" action="{{ route('welcome.update') }}" id="form-store" enctype="multipart/form-data">
				@csrf
				@method('patch')
				<div x-show="group == 'tab-general'">
					@include('welcome.partials.general')
				</div>
				<div x-show="group == 'tab-content'">
					@include('welcome.partials.content')
				</div>
				<div x-show="group == 'tab-slider'">
					@include('welcome.partials.slider')
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
					loadImage(locale);
				});
			});
			function loadData(locale) {
				$.ajax({
					url: "{{ route('welcome.edit') }}",
					type: 'GET',
					dataType: 'json',
					data: {
						locale: locale,
						type: 'data',
					},
					success: function(data) {
						if (!$.isEmptyObject(data[0])) {
							$('#title-'+ locale).val(data[0].title);
							$('#meta-title-'+ locale).val(data[0].meta_title);
							$('#meta-desc-'+ locale).val(data[0].meta_description);
							$('#content-'+ locale).val(data[0].content);
						}
					}
				});
			}
			function loadImage(locale) {
				$.ajax({
					url: "{{ route('welcome.edit') }}",
					type: 'GET',
					dataType: 'json',
					data: {
						locale: locale,
						type: 'slider',
					},
					success: function(data) {
						if (!$.isEmptyObject(data[0])) {
							$.each(data, function( index, value ) {
								var img = '<img src="/storage/welcomes/'+ value.file +'" class="h-[40px] float-right me-4 mt-1" /><input type="hidden" name="image_file_upl_'+ locale +'[]" value="'+ value.file +'" />';
								var block = $('#table-slider-'+ locale +' tbody tr').first().clone();
								block.find('input[type=file]').parent().html(img).addClass('!text-right');
								block.find('input[type=text]').prop('name', 'image_title_upl_'+ locale +'[]').val(value.title);
								block.find('input[type=number]').prop('name', 'image_priority_upl_'+ locale +'[]').val(value.priority);
								block.find('button').prop('disabled', false).removeClass('bg-gray-400 hover:bg-gray-500').addClass('bg-pink-600 hover:bg-pink-700');
								$('#table-slider-'+ locale +' tfoot').append(block);
							});
							$('.image-del').on('click', function(){
								$(this).parent().parent().remove();
							});
						}
					}
				});
			}
		</script>
    @endpush

</x-app-layout>