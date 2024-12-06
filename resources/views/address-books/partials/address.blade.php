<div class="grid gap-0 lg:gap-4 grid-cols-1 lg:grid-cols-2">
	<!-- billing -->
	<div data-type="billing" data-type-lang="{{ __('billing') }}">
		<div class="flex items-center justify-between space-x-2 mb-4 px-2 sm:px-0">
			<x-select id="billing-select" class="address-select flex-1 capitalize">
				<option value="1">{{ __('billing') }} 1</option>
			</x-select>
			<div class="flex items-center justify-center">
				<button type="button" id="billing-remove" class="address-remove hidden px-1 text-pink-600 hover:text-pink-700">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
					</svg>
				</button>
				<button type="button" id="billing-add" class="address-add px-1 text-teal-600 hover:text-teal-700">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
					</svg>
				</button>
			</div>
		</div>
		<div id="billing-1" class="block-billing mb-4 lg:mb-0 py-6 px-2 sm:p-4 space-y-4 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
			<h2 class="mb-4 font-semibold text-xl capitalize">{{ __('billing') }} 1</h2>
			<div class="flex items-center justify-start space-x-2">
				<div class="w-full max-w-[110px]">
					<x-input-label for="billing-code" :required="true" :value="__('code')" />
					<x-text-input id="billing-code" class="code" name="billing_code[]" type="text" maxlength="4" required autofocus />
					<x-input-error :messages="$errors->get('billing_code')" />
				</div>
				<div class="flex-1">
					<x-input-label for="billing-company-name" :required="false" :value="__('company_name')" />
					<x-text-input id="billing-company-name" name="billing_company_name[]" type="text" maxlength="128" />
					<x-input-error :messages="$errors->get('billing_company_name')" />
				</div>
			</div>
			<div class="grid gap-4 sm:gap-2 grid-cols-1 sm:grid-cols-2">
				<div>
					<x-input-label for="billing-company-id" :required="false" :value="__('company_id')" />
					<x-text-input id="billing-company-id" name="billing_company_id[]" type="text" maxlength="8" />
					<x-input-error :messages="$errors->get('billing_company_id')" />
				</div>
				<div>
					<x-input-label for="billing-vat-id" :required="false" :value="__('vat_id')" />
					<x-text-input id="billing-vat-id" name="billing_vat_id[]" type="text" maxlength="12" />
					<x-input-error :messages="$errors->get('billing_vat_id')" />
				</div>
			</div>
			<div class="grid gap-4 sm:gap-2 grid-cols-1 sm:grid-cols-2">
				<div>
					<x-input-label for="billing-first-name" :required="true" :value="__('first_name')" />
					<x-text-input id="billing-first-name" name="billing_first_name[]" type="text" maxlength="128" />
					<x-input-error :messages="$errors->get('billing_first_name')" />
				</div>
				<div>
					<x-input-label for="billing-last-name" :required="true" :value="__('last_name')" />
					<x-text-input id="billing-last-name" name="billing_last_name[]" type="text" maxlength="128" />
					<x-input-error :messages="$errors->get('billing_last_name')" />
				</div>
			</div>
			<div>
				<x-input-label for="billing-address" :required="true" :value="__('address')" />
				<x-text-input id="billing-address" name="billing_address[]" type="text" maxlength="128" />
				<x-input-error :messages="$errors->get('billing_address')" />
			</div>
			<div>
				<x-input-label for="billing-address-ext" :required="false" :value="__('address_ext')" />
				<x-text-input id="billing-address-ext" name="billing_address_ext[]" type="text" maxlength="128" />
				<x-input-error :messages="$errors->get('billing_address_ext')" />
			</div>
			<div class="flex items-center justify-start space-x-2">
				<div class="w-full max-w-[110px]">
					<x-input-label for="billing-postcode" :required="true" :value="__('postcode')" />
					<x-text-input id="billing-postcode" name="billing_postcode[]" type="text" maxlength="12" required />
					<x-input-error :messages="$errors->get('billing_postcode')" />
				</div>
				<div class="flex-1">
					<x-input-label for="billing-city" :required="true" :value="__('city')" />
					<x-text-input id="billing-city" name="billing_city[]" type="text" maxlength="128" />
					<x-input-error :messages="$errors->get('billing_city')" />
				</div>
			</div>
			<div class="flex items-center justify-start space-x-2">
				<div class="w-full max-w-[110px]">
					<x-input-label for="billing-phonecode" :required="true" :value="__('phonecode')" />
					<x-text-input id="billing-phonecode" class="phonecode" name="billing_phonecode[]" type="text" required />
					<x-input-error :messages="$errors->get('billing_phonecode')" />
				</div>
				<div class="flex-1">
					<x-input-label for="billing-phone" :required="true" :value="__('phone')" />
					<x-text-input id="billing-phone" class="phone" name="billing_phone[]" type="text" />
					<x-input-error :messages="$errors->get('billing-phone')" />
				</div>
			</div>
			<div>
				<x-input-label for="billing-email" :required="true" :value="__('email')" />
				<x-text-input id="billing-email" name="billing_email[]" type="email" maxlength="128" placeholder="@" />
				<x-input-error :messages="$errors->get('billing_email')" />
			</div>
		</div>
	</div>
	<!-- branch -->
	<div data-type="branch" data-type-lang="{{ __('branch') }}">
		<div class="flex items-center justify-between space-x-2 mb-4 px-2 sm:px-0">
			<x-select id="branch-select" data-type="branch" class="address-select flex-1 capitalize">
				<option value="1">{{ __('branch') }} 1</option>
			</x-select>
			<div class="flex items-center justify-center">
				<button type="button" id="branch-remove" class="address-remove hidden px-1 text-pink-600 hover:text-pink-700">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
					</svg>
				</button>
				<button type="button" id="branch-add" class="address-add px-1 text-teal-600 hover:text-teal-700">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
					</svg>
				</button>
			</div>
		</div>
		<div id="branch-1" class="block-branch mb-4 lg:mb-0 py-6 px-2 sm:p-4 space-y-4 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
			<h2 class="mb-4 font-semibold text-xl capitalize">{{ __('branch') }} 1</h2>
			<div class="flex items-center justify-start space-x-2">
				<div class="w-full max-w-[110px]">
					<x-input-label for="branch-code" :required="false" :value="__('code')" />
					<x-text-input id="branch-code" class="code" name="branch_code[]" type="text" maxlength="4" />
					<x-input-error :messages="$errors->get('branch_code')" />
				</div>
				<div class="flex-1">
					<x-input-label for="branch-company-name" :required="false" :value="__('company_name')" />
					<x-text-input id="branch-company-name" name="branch_company_name[]" type="text" maxlength="128" />
					<x-input-error :messages="$errors->get('branch_company_name')" />
				</div>
			</div>
			<div class="grid gap-4 sm:gap-2 grid-cols-1 sm:grid-cols-2">
				<div>
					<x-input-label for="branch-company-id" :required="false" :value="__('company_id')" />
					<x-text-input id="branch-company-id" name="branch_company_id[]" type="text" maxlength="8" />
					<x-input-error :messages="$errors->get('branch_company_id')" />
				</div>
				<div>
					<x-input-label for="branch-vat-id" :required="false" :value="__('vat_id')" />
					<x-text-input id="branch-vat-id" name="branch_vat_id[]" type="text" maxlength="12" />
					<x-input-error :messages="$errors->get('branch_vat_id')" />
				</div>
			</div>
			<div class="grid gap-4 sm:gap-2 grid-cols-1 sm:grid-cols-2">
				<div>
					<x-input-label for="branch-first-name" :required="false" :value="__('first_name')" />
					<x-text-input id="branch-first-name" name="branch_first_name[]" type="text" maxlength="128" />
					<x-input-error :messages="$errors->get('branch_first_name')" />
				</div>
				<div>
					<x-input-label for="branch-last-name" :required="false" :value="__('last_name')" />
					<x-text-input id="branch-last-name" name="branch_last_name[]" type="text" maxlength="128" />
					<x-input-error :messages="$errors->get('branch_last_name')" />
				</div>
			</div>
			<div>
				<x-input-label for="branch-address" :required="false" :value="__('address')" />
				<x-text-input id="branch-address" name="branch_address[]" type="text" maxlength="128" />
				<x-input-error :messages="$errors->get('branch_address')" />
			</div>
			<div>
				<x-input-label for="branch-address-ext" :required="false" :value="__('address_ext')" />
				<x-text-input id="branch-address-ext" name="branch_address_ext[]" type="text" maxlength="128" />
				<x-input-error :messages="$errors->get('branch_address_ext')" />
			</div>
			<div class="flex items-center justify-start space-x-2">
				<div class="w-full max-w-[110px]">
					<x-input-label for="branch-postcode" :required="false" :value="__('postcode')" />
					<x-text-input id="branch-postcode" name="branch_postcode[]" type="text" maxlength="12" />
					<x-input-error :messages="$errors->get('branch_postcode')" />
				</div>
				<div class="flex-1">
					<x-input-label for="branch-city" :required="false" :value="__('city')" />
					<x-text-input id="branch-city" name="branch_city[]" type="text" maxlength="128" />
					<x-input-error :messages="$errors->get('branch_city')" />
				</div>
			</div>
			<div class="flex items-center justify-start space-x-2">
				<div class="w-full max-w-[110px]">
					<x-input-label for="branch-phonecode" :required="false" :value="__('phonecode')" />
					<x-text-input id="branch-phonecode" class="phonecode" name="branch_phonecode[]" type="text" />
					<x-input-error :messages="$errors->get('branch_phonecode')" />
				</div>
				<div class="flex-1">
					<x-input-label for="branch-phone" :required="false" :value="__('phone')" />
					<x-text-input id="branch-phone" class="phone" name="branch_phone[]" type="text" />
					<x-input-error :messages="$errors->get('branch_phone')" />
				</div>
			</div>
			<div>
				<x-input-label for="branch-email" :required="false" :value="__('email')" />
				<x-text-input id="branch-email" name="branch_email[]" type="email" maxlength="128" placeholder="@" />
				<x-input-error :messages="$errors->get('branch_email')" />
			</div>
		</div>
	</div>
</div>
@push('slotscript')
	<script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
	<script>

		var count			= 1;
		var root			= '';
		var type			= '';
		var addressNo		= '';
		var select			= '';
		var block			= '';
		var translate 		= '';

		$(document).ready(function(){

			$('.code').inputmask('9999');
			$('.phonecode').inputmask('+999');
			$('.phone').inputmask('999 999 999');

			$('.address-select').change(function(){
				select = $(this).val();
				root = $(this).parent().parent();
				type = root.attr('data-type');
				block = root.find('.block-'+ type);
				if (select == 1) {
					$(root).find('.address-remove').addClass('hidden');
				} else {
					$(root).find('.address-remove').removeClass('hidden');
				}
				$(block).addClass('hidden');
				$('#'+ type +'-'+ select).removeClass('hidden');
			});

			$('.address-add').click(function(){
				root = $(this).parent().parent().parent();
				count = root.find('.address-select option:last').val();
				count++;
				type = root.attr('data-type');
				translate = root.attr('data-type-lang');
				$(root).find('.address-remove').removeClass('hidden');
				block = $('.block-'+ type +'').first().clone();
				$('.block-'+ type).addClass('hidden');
				$('#'+ type +'-select').append('<option value="'+ count +'">'+ translate +' '+ count +'</option>').val(count);
				block.find('h2').text(translate +' '+ count);
				$(block).find('label').each(function(){
					$(this).attr('for', $(this).attr('for') +'-'+ count);
				});
				$(block).find('input').each(function(){
					$(this).attr('id', $(this).attr('id') +'-'+ count).val('');
				});
				$(this).parent().parent().parent().append(block.attr('id', type +'-'+ count).removeClass('hidden'));

				$('.code').inputmask('9999');
				$('.phonecode').inputmask('+999');
				$('.phone').inputmask('999 999 999');
			});

			$('.address-remove').click(function(){
				root = $(this).parent().parent().parent();
				type = root.attr('data-type');
				select = $(root).find('select').val();
				$(this).parent().parent().find('select option:selected').remove();
				addressNo = $(this).parent().parent().find('select option:last').val();
				$(root).find('select').val(addressNo);
				$('.block-'+ type).addClass('hidden');
				$('#'+ type +'-'+ addressNo).removeClass('hidden');
				$('#'+ type +'-'+ select).remove();
				if ($(this).parent().parent().find('select option:selected').val() == 1) {
					$(this).addClass('hidden');
				}
			});
		});
	</script>
@endpush