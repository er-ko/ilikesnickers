<x-app-layout>

	<x-slot name="meta_title">{{ __('messages.edit_product_group') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.edit_product_group') }}</x-slot>
	<x-slot name="title">{{ __('messages.edit_product_group') }}</x-slot>

	<x-slot name="submit">
		<button form="form-store" type="submit" class="p-2.5 pl-4 rounded-l-full duration-300 bg-teal-600 text-white hover:bg-teal-700 dark:bg-teal-700 dark:hover:bg-teal-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
			</svg>
		</button>
		<a href="{{ route('product-group.index') }}" class="py-2.5 px-3 duration-300 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-700 dark:hover:bg-pink-600">
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
					{{ __('messages.general') }}
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
			<form method="POST" action="{{ route('product-group.update', $productGroup) }}" id="form-store">
				@csrf
				@method('patch')
				<div x-show="group == 'tab-general'">
					@include('product-groups.partials.general')
				</div>
			</form>
        </div>
    </div>
	@push('slotscript')
	<script>

		var count	= 0;
		var block	= '';
		var attr	= '';
		var label	= '';
		var input	= '';
		var button	= '';
		var locale	= '';

			$(document).ready(function(){

				$('.lang-tab').each(function( index ) {
					locale = $(this).attr('id');
					loadData('title', locale);
					loadData('values', locale);
				});

				$('.btn-add-value').click(function(){
					count++;
					$('.area-value').each(function(i, l){
						block	= $(this).find('.block-value').first().clone();
						attr	= block.find('label').attr('for') +'-'+ count;
						label	= block.find('label').attr('id', attr);
						input	= block.find('input').val('').attr('id', attr);
						button	= block.find('button').removeClass('hidden').attr('data-id-type', count);
						$(this).append(block);
					})
				});
				$('.area-value').on('click', 'button', function(){
					button = $(this).attr('data-id-type');
					$('.area-value').each(function(i, l){
						$(this).find('button[data-id-type="'+ button +'"]').parent().parent().remove();
					});
				});

			});

			function loadData(type, locale) {
				if (type === 'title') {
						$.ajax({
						url: "{{ route('product-group.edit', $productGroup->id) }}",
						type: 'GET',
						dataType: 'json',
						data: {
							type: 'title',
							locale: locale,
						},
						success: function(data) {
							if (!$.isEmptyObject(data[0])) {
								$('#title-'+ locale).val(data[0].title);
							}
						}
					});
				} else if (type === 'values') {
					$.ajax({
						url: "{{ route('product-group.edit', $productGroup->id) }}",
						type: 'GET',
						dataType: 'json',
						data: {
							type: 'values',
							locale: locale,
						},
						success: function(data) {
							if (!$.isEmptyObject(data[0])) {
								$.each(data, function(i, l){
									count = i;
									if (count === 0) {
										$('#value-'+ locale).val(data[count].value);
									} else {
										block = $('#value-'+ locale).parent().parent().first().clone();
										console.log(block.html());
										attr = block.find('label').attr('for') +'-'+ count;
										label = block.find('label').attr('id', attr);
										input = block.find('input').val(data[count].value).attr('id', attr);
										button = block.find('button').removeClass('hidden').attr('data-id-type', count);
										$('#value-'+ locale).parent().parent().parent().append(block);
									}
								});
							}
						}
					});
				}
			}
		</script>
	@endpush
</x-app-layout>