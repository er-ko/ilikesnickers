<x-card class="relative space-y-2">
	<x-slot name="content">
		@foreach ($activities as $activity)
			<div class="block-value flex items-center justify-start space-x-4">
				<input type="checkbox" name="activity[]" value="{{ $activity->id }}" {{ isset($booking->activities) && in_array($activity->id, json_decode($booking->activities)) ? 'checked' : '' }} />
				<x-text-input class="flex-1" type="text" :value="$activity->title" readonly="true" />
			</div>
		@endforeach
	</x-slot>
</x-card>