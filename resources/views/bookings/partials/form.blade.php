<div id="block-form" class="h-full flex items-center justify-center hidden">
	<form method="POST" action="{{ route('booking.store') }}" id="form-store" class="w-full max-w-md h-full flex flex-col items-center justify-center">
		@csrf
		<x-card class="w-full !p-0 shadow-xl space-y-1">
			<x-slot name="content">
				<div class="px-4 py-10 rounded-t-lg bg-teal-600 text-white dark:bg-teal-600">
					<p>{{ __('slot') }}:<span class="ml-1 font-bold slot-name"></span></p>
					<p>{{ __('activity') }}:<span class="ml-1 font-bold activity-name"></span></p>
					<p>{{ __('duration') }}:<span class="ml-1 font-bold duration-time"></span></p>
					<p>{{ __('start') }}:<span class="ml-1 font-bold start-time"></span></p>
					<p>{{ __('note') }}:<span class="ml-1 font-bold note-content"></span></p>
				</div>
				<input type="hidden" name="slot_id" id="form-slot-id" value="" />
				<input type="hidden" name="activity_id" id="form-activity-id" value="" />
				<input type="hidden" name="start" id="form-start-time" value="" />
				<div class="px-4 py-10 space-y-2">
					<div>
						<x-input-label for="full-name" :required="true" :value="__('full_name')" />
						<x-text-input id="full-name" name="full_name" type="text" maxlength="255" placeholder="{{ __('Jon Smith') }}" :required="true" />
						<x-input-error :messages="$errors->get('full_name')" />
					</div>
					<div>
						<x-input-label for="phone" :required="true" :value="__('phone')" />
						<x-text-input id="phone" name="phone" type="text" maxlength="255" :required="true" />
						<x-input-error :messages="$errors->get('phone')" />
					</div>
					<div>
						<x-input-label for="email" :required="true" :value="__('email')" />
						<x-text-input id="email" name="email" type="text" maxlength="255" placeholder="{{ __('@') }}" value="@" :required="true" />
						<x-input-error :messages="$errors->get('email')" />
					</div>
				</div>
			</x-slot>
		</x-card>
		<div class="flex items-center justify-center">
			<x-primary-button class="mt-4">{{ __('book_now') }}</x-primary-button>
		</div>
	</form>
</div>