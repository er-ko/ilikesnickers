<x-card class="lg:p-8 space-y-4">
	<x-slot name="content">
		<h2 class="text-lg uppercase tracking-widest mb-4 lg:mb-6">{{ __('general') }}</h2>
		<div>
			<x-input-label for="company-name" :required="false" :value="__('company_name')" />
			<x-text-input id="company-name" name="contact_company_name" type="text" maxlength="255" :value="old('contact_company_name', $contact->contact_company_name)" />
			<x-input-error :messages="$errors->get('company_name')" />
		</div>
		<div>
			<x-input-label for="address" :required="false" :value="__('address')" />
			<textarea
				id="address"
				class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:border-teal-600 dark:focus:ring-teal-600"
				name="contact_address"
				rows="3"
				maxlenth="255"
			>{{ old('contact_address', $contact->contact_address) }}</textarea>
			<x-input-error :messages="$errors->get('address')" />
		</div>
		<div>
			<x-input-label for="phone" :required="false" :value="__('phone')" />
			<x-text-input id="phone" name="contact_phone" type="text" maxlength="16" :value="old('contact_phone', $contact->contact_phone)" />
			<x-input-error :messages="$errors->get('phone')" />
		</div>
		<div>
			<x-input-label for="email" :required="false" :value="__('email')" />
			<x-text-input id="email" name="contact_email" type="email" maxlength="255" placeholder="@" :value="old('contact_email', $contact->contact_email)" />
			<x-input-error :messages="$errors->get('email')" />
		</div>
		<div>
			<x-input-label for="web" :required="false" :value="__('web')" />
			<x-text-input id="web" name="contact_web" type="text" maxlength="255" :value="old('contact_web', $contact->contact_web)" />
			<x-input-error :messages="$errors->get('web')" />
		</div>
		<div>
			<x-input-label for="map" :required="false" :value="__('map')" />
			<x-text-input id="map" name="contact_map" type="text" maxlength="255" :value="old('contact_map', $contact->contact_map)" />
			<x-input-error :messages="$errors->get('map')" />
		</div>
		<div>
			<x-input-label for="whatsapp" :required="false" :value="__('whatsapp')" />
			<x-text-input id="whatsapp" name="contact_whatsapp" type="text" maxlength="16" :value="old('contact_whatsapp', $contact->contact_whatsapp)" />
			<x-input-error :messages="$errors->get('whatsapp')" />
		</div>
	</x-slot>
</x-card>