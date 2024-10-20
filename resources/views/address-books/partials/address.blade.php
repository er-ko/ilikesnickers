<div class="grid gap-0 lg:gap-4 grid-cols-1 lg:grid-cols-2">
	<!-- billing -->
	<div data-type="billing">
		<div class="flex items-center justify-between mb-4">
			<x-select id="billing-select" class="address-select flex-1">
				<option value="1">{{ __('messages.billing') }} 1</option>
			</x-select>
			<div class="flex items-center justify-center px-4">
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
		<div id="billing-1" class="block-billing mb-4 lg:mb-0 p-6 space-y-4 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
			<h2 class="mb-4 font-semibold text-xl">{{ __('messages.billing') }} 1</h2>
			<div class="flex items-center justify-start space-x-4">
				<div class="w-full sm:max-w-[120px]">
					<x-input-label for="billing-code" :required="true" :value="__('messages.code')" />
					<x-text-input id="billing-code" class="code" name="billing_code[]" type="text" maxlength="4" required autofocus />
					<x-input-error :messages="$errors->get('code')" />
				</div>
				<div class="flex-1">
					<x-input-label for="company-name" :required="false" :value="__('messages.company_name')" />
					<x-text-input id="company-name" name="company_name" type="text" maxlength="128" :value="isset($addressBooks) ? old('company_name', $addressBooks->company_name) : ''" />
					<x-input-error :messages="$errors->get('company_name')" />
				</div>
			</div>
			<div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
				<div>
					<x-input-label for="company-id" :required="false" :value="__('messages.company_id')" />
					<x-text-input id="company-id" name="company_id" type="text" maxlength="8" :value="isset($addressBooks) ? old('company_id', $addressBooks->company_id) : ''" />
					<x-input-error :messages="$errors->get('company_id')" />
				</div>
				<div>
					<x-input-label for="vat-id" :required="false" :value="__('messages.vat_id')" />
					<x-text-input id="vat-id" name="vat_id" type="text" maxlength="4" :value="isset($addressBooks) ? old('vat_id', $addressBooks->vat_id) : ''" />
					<x-input-error :messages="$errors->get('vat_id')" />
				</div>
			</div>
			<div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
				<div>
					<x-input-label for="first-name" :required="true" :value="__('messages.first_name')" />
					<x-text-input id="first-name" name="first_name" type="text" maxlength="128" :value="isset($addressBooks) ? old('first_name', $addressBooks->first_name) : ''" />
					<x-input-error :messages="$errors->get('first_name')" />
				</div>
				<div>
					<x-input-label for="last-name" :required="true" :value="__('messages.last_name')" />
					<x-text-input id="last-name" name="last_name" type="text" maxlength="128" :value="isset($addressBooks) ? old('last_name', $addressBooks->last_name) : ''" />
					<x-input-error :messages="$errors->get('last_name')" />
				</div>
			</div>
			<div>
				<x-input-label for="address" :required="true" :value="__('messages.address')" />
				<x-text-input id="address" name="address" type="text" maxlength="128" :value="isset($addressBooks) ? old('address', $addressBooks->address) : ''" />
				<x-input-error :messages="$errors->get('address')" />
			</div>
			<div>
				<x-input-label for="address-2" :required="false" :value="__('messages.address_2')" />
				<x-text-input id="address-2" name="address_2" type="text" maxlength="128" :value="isset($addressBooks) ? old('address_2', $addressBooks->address_2) : ''" />
				<x-input-error :messages="$errors->get('address_2')" />
			</div>
			<div class="flex items-center justify-start space-x-4">
				<div class="w-full sm:max-w-[120px]">
					<x-input-label for="postcode" :required="true" :value="__('messages.postcode')" />
					<x-text-input id="postcode" class="postcode" name="postcode" type="text" maxlength="12" required :value="isset($addressBooks) ? old('postcode', $addressBooks->postcode) : ''" />
					<x-input-error :messages="$errors->get('postcode')" />
				</div>
				<div class="flex-1">
					<x-input-label for="city" :required="true" :value="__('messages.city')" />
					<x-text-input id="city" name="city" type="text" maxlength="128" :value="isset($addressBooks) ? old('city', $addressBooks->city) : ''" />
					<x-input-error :messages="$errors->get('city')" />
				</div>
			</div>
			<div class="flex items-center justify-start space-x-4">
				<div class="w-full sm:max-w-[120px]">
					<x-input-label for="phonecode" :required="true" :value="__('messages.phonecode')" />
					<x-text-input id="phonecode" class="phonecode" name="phonecode" type="text" required :value="isset($addressBooks) ? old('phonecode', $addressBooks->phonecode) : ''" />
					<x-input-error :messages="$errors->get('phonecode')" />
				</div>
				<div class="flex-1">
					<x-input-label for="phone" :required="true" :value="__('messages.phone')" />
					<x-text-input id="phone" class="phone" name="phone" type="text" :value="isset($addressBooks) ? old('phone', $addressBooks->phone) : ''" />
					<x-input-error :messages="$errors->get('phone')" />
				</div>
			</div>
			<div>
				<x-input-label for="email" :required="true" :value="__('messages.email')" />
				<x-text-input id="email" name="email" type="email" maxlength="128" placeholder=@ :value="isset($addressBooks) ? old('email', $addressBooks->email) : ''" />
				<x-input-error :messages="$errors->get('email')" />
			</div>
		</div>
	</div>
	<!-- branch -->
	<div>
		<div class="flex items-center justify-between mb-4">
			<x-select id="branch-select" class="address-select" data-type="branch" class="flex-1">
				<option value="0">{{ __('branch 1') }}</option>
			</x-select>
			<div class="flex items-center justify-center px-4">
				<button type="button" id="branch-remove" class="hidden px-1 text-pink-600 hover:text-pink-700">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
					</svg>
				</button>
				<button type="button" id="branch-add" class="px-1 text-teal-600 hover:text-teal-700">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
					</svg>
				</button>
			</div>
		</div>
		<div class="mb-4 lg:mb-0 p-6 space-y-4 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
			<h2 class="mb-4 font-semibold text-xl">{{ __('messages.branch') }}</h2>
			<div class="flex items-center justify-start space-x-4">
				<div class="w-full sm:max-w-[120px]">
					<x-input-label for="code" :required="true" :value="__('messages.code')" />
					<x-text-input id="code" name="code" type="text" maxlength="4" required autofocus :value="isset($addressBooks) ? old('code', $addressBooks->code) : ''" />
					<x-input-error :messages="$errors->get('code')" />
				</div>
				<div class="flex-1">
					<x-input-label for="company-name" :required="false" :value="__('messages.company_name')" />
					<x-text-input id="company-name" name="company_name" type="text" maxlength="128" :value="isset($addressBooks) ? old('company_name', $addressBooks->company_name) : ''" />
					<x-input-error :messages="$errors->get('company_name')" />
				</div>
			</div>
			<div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
				<div>
					<x-input-label for="company-id" :required="false" :value="__('messages.company_id')" />
					<x-text-input id="company-id" name="company_id" type="text" maxlength="8" :value="isset($addressBooks) ? old('company_id', $addressBooks->company_id) : ''" />
					<x-input-error :messages="$errors->get('company_id')" />
				</div>
				<div>
					<x-input-label for="vat-id" :required="false" :value="__('messages.vat_id')" />
					<x-text-input id="vat-id" name="vat_id" type="text" maxlength="4" :value="isset($addressBooks) ? old('vat_id', $addressBooks->vat_id) : ''" />
					<x-input-error :messages="$errors->get('vat_id')" />
				</div>
			</div>
			<div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
				<div>
					<x-input-label for="first-name" :required="true" :value="__('messages.first_name')" />
					<x-text-input id="first-name" name="first_name" type="text" maxlength="128" :value="isset($addressBooks) ? old('first_name', $addressBooks->first_name) : ''" />
					<x-input-error :messages="$errors->get('first_name')" />
				</div>
				<div>
					<x-input-label for="last-name" :required="true" :value="__('messages.last_name')" />
					<x-text-input id="last-name" name="last_name" type="text" maxlength="128" :value="isset($addressBooks) ? old('last_name', $addressBooks->last_name) : ''" />
					<x-input-error :messages="$errors->get('last_name')" />
				</div>
			</div>
			<div>
				<x-input-label for="address" :required="true" :value="__('messages.address')" />
				<x-text-input id="address" name="address" type="text" maxlength="128" :value="isset($addressBooks) ? old('address', $addressBooks->address) : ''" />
				<x-input-error :messages="$errors->get('address')" />
			</div>
			<div>
				<x-input-label for="address-2" :required="false" :value="__('messages.address_2')" />
				<x-text-input id="address-2" name="address_2" type="text" maxlength="128" :value="isset($addressBooks) ? old('address_2', $addressBooks->address_2) : ''" />
				<x-input-error :messages="$errors->get('address_2')" />
			</div>
			<div class="flex items-center justify-start space-x-4">
				<div class="w-full sm:max-w-[120px]">
					<x-input-label for="postcode" :required="true" :value="__('messages.postcode')" />
					<x-text-input id="postcode" name="postcode" type="text" maxlength="12" required :value="isset($addressBooks) ? old('postcode', $addressBooks->postcode) : ''" />
					<x-input-error :messages="$errors->get('postcode')" />
				</div>
				<div class="flex-1">
					<x-input-label for="city" :required="true" :value="__('messages.city')" />
					<x-text-input id="city" name="city" type="text" maxlength="128" :value="isset($addressBooks) ? old('city', $addressBooks->city) : ''" />
					<x-input-error :messages="$errors->get('city')" />
				</div>
			</div>
			<div class="flex items-center justify-start space-x-4">
				<div class="w-full sm:max-w-[120px]">
					<x-input-label for="phonecode" :required="true" :value="__('messages.phonecode')" />
					<x-text-input id="phonecode" name="phonecode" type="text" required :value="isset($addressBooks) ? old('phonecode', $addressBooks->phonecode) : ''" />
					<x-input-error :messages="$errors->get('phonecode')" />
				</div>
				<div class="flex-1">
					<x-input-label for="phone" :required="true" :value="__('messages.phone')" />
					<x-text-input id="phone" name="phone" type="text" :value="isset($addressBooks) ? old('phone', $addressBooks->phone) : ''" />
					<x-input-error :messages="$errors->get('phone')" />
				</div>
			</div>
			<div>
				<x-input-label for="email" :required="true" :value="__('messages.email')" />
				<x-text-input id="email" name="email" type="email" maxlength="128" placeholder=@ :value="isset($addressBooks) ? old('email', $addressBooks->email) : ''" />
				<x-input-error :messages="$errors->get('email')" />
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

		$(document).ready(function(){

			$('.code').inputmask('9999');
			$('.phonecode').inputmask('+999');
			$('.phone').inputmask('999 999 999');

			$('.address-select').change(function(){
				select = $(this).val();
				type = $(this).parent().parent().attr('data-type');
				if (select == 1) {
					$('#'+ type +'-remove').addClass('hidden');
				} else {
					$('#'+ type +'-remove').removeClass('hidden');
				}
				$('.block-'+ type).addClass('hidden');
				$('.block-'+ type).each(function(i, l){
					if (type +'-'+ select == $(this).attr('id')) {
						$(this).removeClass('hidden');
					}
				});
			});

			$('.address-add').click(function(){
				count++;
				root = $(this).parent().parent().parent();
				type = root.attr('data-type');
				$(root).find('.address-remove').removeClass('hidden');

				block = $('.block-'+ type +'').first().clone();
				block.find('h2').text('{{ __('messages.billing') }} '+ count);
				block.find('label#'+ type +'-code').attr('for', type +'-code-'+ count);
				block.find('input#'+ type +'-code').attr('id', type +'-code-'+ count);
				block.find('label#'+ type +'-company-name').attr('for', type +'-code-'+ count);
				block.find('input#'+ type +'-company-name').attr('id', type +'-code-'+ count);
				
				
				$('#'+ type +'-select').append('<option value="'+ count +'">{{ __('messages.billing') }} '+ count +'</option>').val(count);
				$('.block-'+ type).addClass('hidden');
				$(this).parent().parent().parent().append(block.attr('id', type +'-'+ count).removeClass('hidden'));
			});

			$('.address-remove').click(function(){
				type = $(this).parent().parent().parent().attr('data-type');
				select = $(this).parent().parent().find('select')
				alert($(this).parent().parent().parent().find('#'+ type +'-'+ select.val()).html());
				$(this).parent().parent().parent().find('#'+ type +'-'+ select.val()).html().remove();
				
				$(this).parent().parent().find('select option:selected').remove();
				addressNo = $(this).parent().parent().find('select option:last').val();
				$(select).val(addressNo);
				$(this).parent().parent().parent().append(block.attr('id', type +'-'+ count).removeClass('hidden'));
				if ($(this).parent().parent().find('select option:selected').val() == 1) {
					$(this).addClass('hidden');
				}
			});
		});
	</script>
@endpush