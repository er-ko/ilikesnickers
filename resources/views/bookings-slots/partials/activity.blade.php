<x-card class="relative space-y-2">
	<x-slot name="content">
		@foreach ($activities as $activity)
			<div class="block-value flex items-center justify-start space-x-4">
				@if (empty(json_decode($booking->activities)))
					<input type="checkbox" name="activity[]" value="{{ $activity->id }}"s />
				@else
					<input type="checkbox" name="activity[]" value="{{ $activity->id }}" {{ in_array($activity->id, json_decode($booking->activities)) ? 'checked' : '' }} />
				@endif
				<x-text-input class="flex-1" type="text" :value="$activity->title" readonly="true" />
			</div>
		@endforeach
	</x-slot>
</x-card>