<x-app-layout>

	<x-slot name="meta_title">{{ __('messages.edit_country') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.edit_country') }}</x-slot>
    <x-slot name="title">{{ __('messages.edit_country') }}</x-slot>

	<x-slot name="submit">
		<button form="form-store" type="submit" class="p-2.5 pl-4 rounded-l-full duration-300 bg-teal-600 text-white hover:bg-teal-700 dark:bg-teal-700 dark:hover:bg-teal-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
			</svg>
		</button>
		<a href="{{ route('country.index') }}" class="py-2.5 px-3 duration-300 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-700 dark:hover:bg-pink-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
			</svg>
		</a>
	</x-slot>

	<x-card class="relative">
		<x-slot name="content">
			<form method="POST" action="{{ route('country.update', $country) }}" id="form-store" class="max-w-4xl grid gap-4 grid-cols-1 lg:grid-cols-2">
				@csrf
				@method('patch')
				<div class="space-y-4">
					<div>
						<x-input-label for="public" :required="true" :value="__('messages.public')" />
						<x-select name="public" id="public" required>
							<option value="0" {{ !$country->public ? 'selected': '' }}>{{ __('messages.no') }}</option>
							<option value="1" {{ $country->public ? 'selected': '' }}>{{ __('messages.yes') }}</option>
						</x-select>
						<x-input-error :messages="$errors->get('public')" />
					</div>
					<div>
						<x-input-label for="default" :required="true" :value="__('messages.default')" />
						<x-select name="default" id="default" required>
							@foreach($countries as $countryDefault)
								<option value="{{ $countryDefault->id }}" {{ $countryDefault->default ? 'selected': '' }}>{{ $countryDefault->name }}</option>
							@endforeach
						</x-select>
						<x-input-error :messages="$errors->get('default')" />
					</div>
					<div>
						<x-input-label for="delivery" :required="true" :value="__('messages.delivery')" />
						<x-select name="delivery" id="delivery" required>
							<option value="0" {{ !$country->delivery ? 'selected': '' }}>{{ __('messages.no') }}</option>
							<option value="1" {{ $country->delivery ? 'selected': '' }}>{{ __('messages.yes') }}</option>
						</x-select>
						<x-input-error :messages="$errors->get('delivery')" />
					</div>
				</div>
				<div class="space-y-4">
					<div>
						<x-input-label for="code" :required="true" :value="__('messages.code')" />
						<x-text-input id="code" name="code" type="text" maxlength="3" :value="old('code', $country->code)" required />
						<x-input-error :messages="$errors->get('localname')" />
					</div>
					<div>
						<x-input-label for="name" :required="true" :value="__('messages.name')" />
						<x-text-input id="name" name="name" type="text" maxlength="64" :value="old('name', $country->name)" required />
						<x-input-error :messages="$errors->get('localname')" />
					</div>
					<div>
						<x-input-label for="localname" :required="true" :value="__('messages.localname')" />
						<x-text-input id="localname" name="localname" type="text" maxlength="64" :value="old('localename', $country->localname)" required />
						<x-input-error :messages="$errors->get('localname')" />
					</div>
				</div>
			</form>
		</x-slot>
	</x-card>

</x-app-layout>