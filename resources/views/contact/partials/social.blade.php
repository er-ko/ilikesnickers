<x-card class="lg:p-8 space-y-4">
	<x-slot name="content">
		<h2 class="text-lg uppercase tracking-widest mb-4 lg:mb-6">{{ __('social') }}</h2>
		<div>
			<x-input-label for="facebook" :required="false" :value="__('facebook')" />
			<x-text-input id="facebook" name="contact_facebook" type="text" maxlength="255" :value="old('contact_facebook', $contact['facebook'])" />
			<x-input-error :messages="$errors->get('facebook')" />
		</div>
		<div>
			<x-input-label for="instagram" :required="false" :value="__('instagram')" />
			<x-text-input id="instagram" name="contact_instagram" type="text" maxlength="255" :value="old('contact_instagram', $contact['instagram'])" />
			<x-input-error :messages="$errors->get('instagram')" />
		</div>
		<div>
			<x-input-label for="tiktok" :required="false" :value="__('tiktok')" />
			<x-text-input id="tiktok" name="contact_tiktok" type="text" maxlength="255" :value="old('contact_tiktok', $contact['tiktok'])" />
			<x-input-error :messages="$errors->get('tiktok')" />
		</div>
		<div>
			<x-input-label for="google" :required="false" :value="__('google')" />
			<x-text-input id="google" name="contact_google" type="text" maxlength="255" :value="old('contact_google', $contact['google'])" />
			<x-input-error :messages="$errors->get('google')" />
		</div>
	</x-slot>
</x-card>