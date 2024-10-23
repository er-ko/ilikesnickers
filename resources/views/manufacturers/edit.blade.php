<x-app-layout>

	<x-slot name="meta_title">{{ __('messages.edit_manufacturer') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.edit_manufacturer') }}</x-slot>
	<x-slot name="title">{{ __('messages.edit_manufacturer') }}</x-slot>

	<div class="flex items-center justify-center mt-2 mb-6 space-x-1">
		<button
			form="form-store"
			type="submit"
			class="px-4 py-1 text-base lowercase sm:rounded-md duration-300 bg-teal-600 text-white hover:bg-teal-700"
		>
			{{ __('messages.save') }}
		</button>
		<a
			href="{{ route('manufacturer.index') }}"
			class="px-4 py-1 text-base lowercase sm:rounded-md duration-300 bg-pink-600 text-white hover:bg-pink-700"
		>
			{{ __('messages.cancel') }}
		</a>
	</div>

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
			<form method="POST" action="{{ route('manufacturer.update', $manufacturer) }}" id="form-store" enctype="multipart/form-data">
				@csrf
				@method('patch')
				<div x-show="group == 'tab-general'">
					@include('manufacturers.partials.general')
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
						url: "{{ route('manufacturer.edit', $manufacturer->id) }}",
						type: 'GET',
						dataType: 'json',
						data: {
							locale: locale,
						},
						success: function(data) {
							if (!$.isEmptyObject(data[0])) {
								$('#content-'+ locale).val(data[0].content);
							}
						}
					});
				}
		</script>
    @endpush
</x-app-layout>