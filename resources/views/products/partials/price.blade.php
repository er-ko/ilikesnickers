<div class="grid gap-4 grid-cols-1 lg:grid-cols-2">

	<x-card class="h-fit space-y-4">
		<x-slot name="content">
			<h3 class="font-semibold text-xl mb-6">{{ __('regular_price') }}</h3>
			<input type="hidden" id="vat-payer" value="{{ $vat_payer }}" />
			<div>
				<x-input-label for="vat" :required="$vat_payer ? true : false" >{{ __('vat') }}</x-input-label>
				<x-select name="vat" id="vat" :required="$vat_payer ? true : false" >
					<option value="6">6</option>
					<option value="13">13</option>
					<option value="23">23</option>
				</x-select>
				<x-input-error :messages="$errors->get('vat')" />
			</div>
			<div>
				<x-input-label for="regular-price-without-vat" :required="false" :value="__('price_without_vat')" />
				<x-text-input id="regular-price-without-vat" name="regular_price_without_vat" type="number" min="0.00" step="0.01" placeholder="0.01" :readonly="!$vat_payer ? true : false" />
				<x-input-error :messages="$errors->get('regular_price_without_vat')" />
			</div>
			<div>
				<x-input-label for="regular-price-with-vat" :required="true" :value="__('price_with_vat')" />
				<x-text-input id="regular-price-with-vat" name="regular_price_with_vat" type="number" min="0.00" step="0.01" placeholder="0.01" required />
				<x-input-error :messages="$errors->get('regular_price_with_vat')" />
			</div>
		</x-slot>
	</x-card>

	<x-card class="space-y-4">
		<x-slot name="content">
			<h3 class="font-semibold text-xl mb-6">{{ __('promotion_price') }}</h3>
			<div class="mb-4">
				<x-input-label for="promotion-price-type" :required="false">{{ __('promotion_price_type') }}</x-input-label>
				<x-select name="promotion_price_type" id="promotion-price-type">
					<option value="false">no</option>
					<option value="%">%</option>
					<option value="abs">{{ __('absolute_value') }}</option>
				</x-select>
				<x-input-error :messages="$errors->get('promotion_price_type')" />
			</div>
			<div>
				<x-input-label for="promotion-discount" :required="false" :value="__('discount')" />
				<x-text-input id="promotion-discount" name="promotion_discount" type="number" min="0" step="1" max="100" placeholder="0" readonly />
				<x-input-error :messages="$errors->get('promotion_discount')" />
			</div>
			<div>
				<x-input-label for="promotion-price-without-vat" :required="false" :value="__('price_without_vat')" />
				<x-text-input id="promotion-price-without-vat" name="promotion_price_without_vat" type="number" min="0.00" step="0.01" placeholder="0.01" readonly />
				<x-input-error :messages="$errors->get('promotion_price_without_vat')" />
			</div>
			<div>
				<x-input-label for="promotion-price-with-vat" :required="false" :value="__('price_with_vat')" />
				<x-text-input id="promotion-price-with-vat" name="promotion_price_with_vat" type="number" min="0.00" step="0.01" placeholder="0.01" readonly />
				<x-input-error :messages="$errors->get('promotion_price_with_vat')" />
			</div>
		</x-slot>
	</x-card>

</div>

@push('slotscript')
	<script>

		var vat_payer = 0;
		$(document).ready(function(){

			vat_payer = $('#vat-payer').val();
			$('#regular-price-with-vat').keyup(function(){
				if (vat_payer == 1) {
					$('#regular-price-without-vat').val( parseFloat( $(this).val() * ((100 - $('#vat').val()) / 100) ).toFixed(2) );
				}
			});
			$('#regular-price-without-vat').keyup(function(){
				if (vat_payer == 1) {
					$('#regular-price-with-vat').val( parseFloat( $(this).val() * ($('#vat').val() / 100 +1) ).toFixed(2) );
				}
			});

			$('#promotion-price-type').change(function(){
				if ($(this).val() === 'false') {
					$('#promotion-discount').attr('readonly', true).val('');
					$('#promotion-price-without-vat').attr('readonly', true).val('');
					$('#promotion-price-with-vat').attr('readonly', true).val('');
				} else if ($(this).val() === '%') {
					$('#promotion-discount').attr('readonly', false);
					$('#promotion-price-without-vat').attr('readonly', true).val('');
					$('#promotion-price-with-vat').attr('readonly', true).val('');
				} else if ($(this).val() === 'abs') {
					$('#promotion-discount').attr('readonly', true).val('');
					$('#promotion-price-without-vat').attr('readonly', false).val('');
					$('#promotion-price-with-vat').attr('readonly', false).val('');
				}
			});

			$('#promotion-discount').keyup(function(){
				if ($('#promotion-price-type').val() == '%') {
					$('#promotion-price-with-vat').val( parseFloat( $('#regular-price-with-vat').val() * ((100 - $(this).val()) / 100) ).toFixed(2) );
					if (vat_payer == 1) {
						$('#promotion-price-without-vat').val( parseFloat( $('#regular-price-without-vat').val() * ((100 - $(this).val()) / 100) ).toFixed(2) );
					}
				}
			});
			if ($('#promotion-price-type').val() === 'abs') {
				$('#promotion-price-with-vat').keyup(function(){
					if (vat_payer == 1) {
						$('#promotion-price-without-vat').val($(this).val() * ((100 - $('#vat').val()) / 100));
					}
				});
				$('#promotion-price-without-vat').keyup(function(){
					if (vat_payer == 1) {
						$('#promotion-price-with-vat').val($(this).val() * ($('#vat').val() / 100 +1));
					}
				});
			}

		});
	</script>
@endpush