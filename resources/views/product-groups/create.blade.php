<x-app-layout>

	<x-slot name="meta_title">{{ __('messages.new_product_group') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.new_product_group') }}</x-slot>

	<x-slot name="header">
		<div class="flex items-center justify-between">
			<h2 class="font-semibold text-xl leading-tight text-gray-800 dark:text-gray-200">
				{{ __('messages.new_product_group') }}
			</h2>
			<div class="flex justify-center items-center px-2">
				<button form="form-store" type="submit" class="mr-2 text-teal-600 hover:text-teal-700">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
					</svg>
				</button>
				<a href="{{ route('product-group.index') }}" class="text-pink-600 hover:text-pink-700">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
					</svg>
				</a>
			</div>
		</div>
    </x-slot>

	<div class="max-w-7xl mx-auto mt-6 mb-12 sm:px-6 lg:px-8" x-data="{ group: 'tab-general', lang: 'tab-{{ app()->getLocale() }}' }">
		<div class="flex items-center justify-between flex-wrap mx-2 space-y-4 sm:space-y-0 mb-4">
			<div class="flex items-center justify-center sm:justify-start w-full sm:w-fit dark:text-gray-200">
				<div
					class="w-fit mx-x0.5 py-1 px-3 hover:cursor-pointer rounded-lg" @click.prevent="group = 'tab-general'"
					:class="{ 'bg-black text-white dark:bg-white dark:text-black': group == 'tab-general'}"
				>
					{{ __('messages.general') }}
				</div>
			</div>
			<div class="flex items-center justify-center sm:justify-start flex-nowrap mx-1 w-full sm:w-fit overflow-auto">
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
			<form method="POST" action="{{ route('product-group.store') }}" id="form-store">
				@csrf
				<div x-show="group == 'tab-general'">
					@include('product-groups.partials.general')
				</div>
			</form>
        </div>
    </div>
	@push('slotscript')
		<script>

			var count 	= 0;
			var block 	= '';
			var attr	= '';
			var label	= '';
			var input	= '';
			var button  = '';

			$(document).ready(function(){

				$('.btn-add-value').click(function(){
					$('.area-value').each(function(i, l){
						block = $(this).find('.block-value').first().clone();
						attr = block.find('label').attr('for') +'-'+ count;
						label = block.find('label').attr('id', attr);
						input = block.find('input').val('').attr('id', attr);
						button = block.find('button').removeClass('hidden').attr('data-id-type', count);
						$(this).append(block);
					})
					count++;
				});
				$('.area-value').on('click', 'button', function(){
					button = $(this).attr('data-id-type');
					$('.area-value').each(function(i, l){
						$(this).find('button[data-id-type="'+ button +'"]').parent().parent().remove();
					});
				});

			});
		</script>
	@endpush
</x-app-layout>