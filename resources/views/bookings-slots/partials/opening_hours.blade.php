<div class="opening-hours h-full flex items-center justify-center">
	<x-card class="lg:p-8">
		<x-slot name="content">
			<div class="flex items-center justify-end space-x-4">
				<h3 class="text-sm lg:text-base font-light uppercase">{{ __('monday') }}</h3>
				<x-text-input id="monday-morning" class="text-center max-w-[125px]" name="opening_hours_monday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['monday'])[0] : ''" />
				<x-text-input id="monday-afternoon" class="text-center max-w-[125px]" name="opening_hours_monday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['monday'])[1] : ''" />
			</div>
			<div class="flex items-center justify-end space-x-4">
				<h3 class="text-sm lg:text-base font-light uppercase">{{ __('tuesday') }}</h3>
				<x-text-input id="tuesday-morning" class="text-center max-w-[125px]" name="opening_hours_tuesday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['tuesday'])[0] : ''" />
				<x-text-input id="tuesday-afternoon" class="text-center max-w-[125px]" name="opening_hours_tuesday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['tuesday'])[1] : ''" />
			</div>
			<div class="flex items-center justify-end space-x-4">
				<h3 class="text-sm lg:text-base font-light uppercase">{{ __('wednesday') }}</h3>
				<x-text-input id="wednesday-morning" class="text-center max-w-[125px]" name="opening_hours_wednesday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['wednesday'])[0] : ''" />
				<x-text-input id="wednesday-afternoon" class="text-center max-w-[125px]" name="opening_hours_wednesday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['wednesday'])[1] : ''" />
			</div>
			<div class="flex items-center justify-end space-x-4">
				<h3 class="text-sm lg:text-base font-light uppercase">{{ __('thursday') }}</h3>
				<x-text-input id="thursday-morning" class="text-center max-w-[125px]" name="opening_hours_thursday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['thursday'])[0] : ''" />
				<x-text-input id="thursday-afternoon" class="text-center max-w-[125px]" name="opening_hours_thursday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['thursday'])[1] : ''" />
			</div>
			<div class="flex items-center justify-end space-x-4">
				<h3 class="text-sm lg:text-base font-light uppercase">{{ __('friday') }}</h3>
				<x-text-input id="friday-morning" class="text-center max-w-[125px]" name="opening_hours_friday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['friday'])[0] : ''" />
				<x-text-input id="friday-afternoon" class="text-center max-w-[125px]" name="opening_hours_friday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['friday'])[1] : ''" />
			</div>
			<div class="flex items-center justify-end space-x-4">
				<h3 class="text-sm lg:text-base font-light uppercase">{{ __('saturday') }}</h3>
				<x-text-input id="saturday-morning" class="text-center max-w-[125px]" name="opening_hours_saturday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['saturday'])[0] : ''" />
				<x-text-input id="saturday-afternoon" class="text-center max-w-[125px]" name="opening_hours_saturday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['saturday'])[1] : ''" />
			</div>
			<div class="flex items-center justify-end space-x-4">
				<h3 class="text-sm lg:text-base font-light uppercase">{{ __('sunday') }}</h3>
				<x-text-input id="sunday-morning" class="text-center max-w-[125px]" name="opening_hours_sunday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['sunday'])[0] : ''" />
				<x-text-input id="sunday-afternoon" class="text-center max-w-[125px]" name="opening_hours_sunday[]" type="text" :value="isset($booking) ? explode('|', json_decode($booking->opening_hours, true)['sunday'])[1] : ''" />
			</div>
		</x-slot>
	</x-card>
</div>