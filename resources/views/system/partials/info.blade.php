<x-card class="xl:col-span-2">
	<x-slot name="content">
		<div class="max-w-xl space-y-4">
			<div>
				<x-input-label for="app-name" :required="true" :value="__('app_name')" />
				<x-text-input id="app-name" name="app_name" type="text" maxlength="128" required :value="old('app_name', $app_name)" />
				<x-input-error :messages="$errors->get('app_name')" />
			</div>
			<div>
				<x-input-label for="meta-suffix" :required="false" :value="__('meta_suffix')" />
				<x-text-input id="meta-suffix" name="meta_suffix" type="text" maxlength="64" :value="old('meta_suffix', $meta_suffix)" />
				<x-input-error :messages="$errors->get('meta_suffix')" />
			</div>
		</div>
	</x-slot>
</x-card>