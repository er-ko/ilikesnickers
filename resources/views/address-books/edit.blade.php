<x-app-layout>

    <x-slot name="meta_title">{{ __('edit_contact') }}</x-slot>
	<x-slot name="meta_desc">{{ __('edit_contact') }}</x-slot>
    <x-slot name="title">{{ __('edit_contact') }}</x-slot>

    <x-slot name="submit">
		<button form="form-store" type="submit" class="p-2.5 pl-4 rounded-l-full duration-300 bg-teal-600 text-white hover:bg-teal-700 dark:bg-teal-700 dark:hover:bg-teal-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
			</svg>
		</button>
		<a href="{{ route('address-book.index') }}" class="py-2.5 px-3 duration-300 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-700 dark:hover:bg-pink-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
			</svg>
		</a>
	</x-slot>

    <div x-data="{ group: 'tab-general' }">
		<div class="flex items-center justify-between flex-wrap space-y-4 sm:space-y-0 mb-4">
			<div class="flex items-center justify-center sm:justify-start w-full sm:w-fit dark:text-gray-200">
                <div
					class="w-fit mx-x0.5 py-1 px-3 hover:cursor-pointer rounded-lg" @click.prevent="group = 'tab-general'"
					:class="{ 'bg-black text-white dark:bg-white dark:text-black': group == 'tab-general'}"
				>
					{{ __('general') }}
				</div>
				<div
					class="w-fit mx-x0.5 py-1 px-3 hover:cursor-pointer rounded-lg" @click.prevent="group = 'tab-address'"
					:class="{ 'bg-black text-white dark:bg-white dark:text-black': group == 'tab-address'}"
				>
					{{ __('address') }}
				</div>
			</div>
		</div>
		<div class="relative">
			<form method="POST" action="{{ route('address-book.update', $addressBook) }}" id="form-store">
				@csrf
                @method('patch')
                <div x-show="group == 'tab-general'">
					@include('address-books.partials.general')
				</div>
				<div x-show="group == 'tab-address'">
					@include('address-books.partials.address')
				</div>
			</form>
        </div>
    </div>
    @push('slotscript')
		<script>

            var count       = '';
            var root        = '';
            var block       = '';
            var select      = '';
            var translate   = ''

			$(document).ready(function(){
                loadData('billing');
                loadData('branch');
			});
			function loadData(type) {
					$.ajax({
						url: "{{ route('address-book.edit', $addressBook->id) }}",
						type: 'GET',
						dataType: 'json',
						data: {
                            type: type,
							id: {{ $addressBook->id }},
						},
						success: function(data) {
							if (!$.isEmptyObject(data[0])) {

                                root        = $('.block-'+ type).parent();
                                block       = $('.block-'+ type).first().clone();
                                select      = root.find('.address-select');
                                translate   = root.attr('data-type-lang');

                                $.each(data, function(i, l){

                                    count = parseFloat(i+1);
                                    if (i == 0) {

                                        $('.block-'+ type).first().find('input#'+ type +'-code').val(l['code']);
                                        $('.block-'+ type).first().find('input#'+ type +'-company-name').val(l['company_name']);
                                        $('.block-'+ type).first().find('input#'+ type +'-company-id').val(l['company_id']);
                                        $('.block-'+ type).first().find('input#'+ type +'-vat-id').val(l['vat_id']);
                                        $('.block-'+ type).first().find('input#'+ type +'-first-name').val(l['first_name']);
                                        $('.block-'+ type).first().find('input#'+ type +'-last-name').val(l['last_name']);
                                        $('.block-'+ type).first().find('input#'+ type +'-address').val(l['address']);
                                        $('.block-'+ type).first().find('input#'+ type +'-address-ext').val(l['address_ext']);
                                        $('.block-'+ type).first().find('input#'+ type +'-postcode').val(l['postcode']);
                                        $('.block-'+ type).first().find('input#'+ type +'-city').val(l['city']);
                                        $('.block-'+ type).first().find('input#'+ type +'-phonecode').val(l['phonecode']);
                                        $('.block-'+ type).first().find('input#'+ type +'-phone').val(l['phone']);
                                        $('.block-'+ type).first().find('input#'+ type +'-email').val(l['email']);

                                    } else {

                                        select.append('<option value="'+ count +'">'+ translate +' '+ count +'</option>');
                                        block.addClass('hidden');
                                        block.attr('id', type +'-'+ count);
                                        block.find('h2').text(translate +' '+ count);

                                        $(block).find('label').each(function(){
                                            $(this).attr('for', $(this).attr('for') +'-'+ count);
                                        });
                                        $(block).find('input').each(function(){
                                            $(this).attr('id', $(this).attr('id') +'-'+ count).val('');
                                        });
                                        
                                        block.find('input#'+ type +'-code-'+ count).val(l['code']);
                                        block.find('input#'+ type +'-company-name-'+ count).val(l['company_name']);
                                        block.find('input#'+ type +'-company-id-'+ count).val(l['company_id']);
                                        block.find('input#'+ type +'-vat-id-'+ count).val(l['vat_id']);
                                        block.find('input#'+ type +'-first-name-'+ count).val(l['first_name']);
                                        block.find('input#'+ type +'-last-name-'+ count).val(l['last_name']);
                                        block.find('input#'+ type +'-address-'+ count).val(l['address']);
                                        block.find('input#'+ type +'-address-ext-'+ count).val(l['address_ext']);
                                        block.find('input#'+ type +'-postcode-'+ count).val(l['postcode']);
                                        block.find('input#'+ type +'-city-'+ count).val(l['city']);
                                        block.find('input#'+ type +'-phonecode-'+ count).val(l['phonecode']);
                                        block.find('input#'+ type +'-phone-'+ count).val(l['phone']);
                                        block.find('input#'+ type +'-email-'+ count).val(l['email']);
                                        root.append(block);

                                        $('.code').inputmask('9999');
                                        $('.phonecode').inputmask('+999');
                                        $('.phone').inputmask('999 999 999');
                                    }

                                });
							}
						}
					});
				}
		</script>
    @endpush
</x-app-layout>