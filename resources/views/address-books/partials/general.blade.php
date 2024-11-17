<div class="grid gap-4 grid-cols-1 md:grid-cols-3">

	<x-card class="space-y-4">
		<x-slot name="content">
			<div class="flex items-start justify-center flex-col space-y-4">
				<div>
					<label for="customer" class="inline-flex items-center cursor-pointer">
						<input type="checkbox" id="customer" name="customer" value="1" class="sr-only peer" {{ isset($addressBook) && $addressBook->customer ? 'checked' : '' }}>
						<div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-teal-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-teal-600"></div>
						<span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('messages.customer') }}</span>
					</label>
				</div>
				<div>
					<label for="supplier" class="inline-flex items-center cursor-pointer">
						<input type="checkbox" id="supplier" name="supplier" value="1" class="sr-only peer" {{ isset($addressBook) && $addressBook->supplier ? 'checked' : '' }}>
						<div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-teal-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-teal-600"></div>
						<span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('messages.supplier') }}</span>
					</label>
				</div>
				<div>
					<label for="vat-payer" class="inline-flex items-center cursor-pointer">
						<input type="checkbox" id="vat-payer" name="vat_payer" value="1" class="sr-only peer" {{ isset($addressBook) && $addressBook->vat_payer ? 'checked' : '' }}>
						<div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-teal-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-teal-600"></div>
						<span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('messages.vat_payer') }}</span>
					</label>
				</div>
			</div>
			<div>
				<x-input-label for="due-date" :required="true" :value="__('messages.due_date')" />
				<x-text-input id="due-date" class="text-center" name="due_date" type="number" maxlength="3" required :value="isset($addressBook) ? old('due_date', $addressBook->due_date) : 7" />
				<x-input-error :messages="$errors->get('due_date')" />
			</div>
		</x-slot>
	</x-card>
	<x-card class="md:col-span-2 space-y-4">
		<x-slot name="content">
			<div>
				<x-input-label for="preferred-payment-method" :required="true" :value="__('messages.preferred_payment_method')" />
				<x-select name="preferred_payment_method" id="preferred-payment-method" required>
					<option value="cash" {{ isset($addressBook) && !old('preferred_payment_method', $addressBook->preferred_payment_method) ? 'selected' : '' }}>{{ __('messages.cash') }}</option>
					<option value="transfer" {{ isset($addressBook) && old('preferred_payment_method', $addressBook->preferred_payment_method) ? 'selected' : '' }}>{{ __('messages.bank_transfer') }}</option>
					<option value="cod" {{ isset($addressBook) && !old('preferred_payment_method', $addressBook->preferred_payment_method) ? 'selected' : '' }}>{{ __('messages.cod') }}</option>
				</x-select>
				<x-input-error :messages="$errors->get('preferred_payment_method')" />
			</div>
			<div>
				<x-input-label for="income-bank-account" :required="false" :value="__('messages.income_bank_account')" />
				<x-text-input id="income-bank-account" name="income_bank_account" type="text" maxlength="64"  placeholder="______________ / _____" :value="isset($addressBook) ? old('income_bank_account', $addressBook->income_bank_account) : ''" />
				<x-input-error :messages="$errors->get('income_bank_account')" />
			</div>
			<div>
				<x-input-label for="outcome-bank-account" :required="false" :value="__('messages.outcome_bank_account')" />
				<x-text-input id="outcome-bank-account" name="outcome_bank_account" type="text" maxlength="64" placeholder="______________ / _____" :value="isset($addressBook) ? old('outcome_bank_account', $addressBook->outcome_bank_account) : ''" />
				<x-input-error :messages="$errors->get('outcome_bank_account')" />
			</div>
		</x-slot>
	</x-card>

</div>