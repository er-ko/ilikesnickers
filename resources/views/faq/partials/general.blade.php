<div class="flex flex-col items-end space-y-4">
	<x-card class="relative w-full pt-8 sm:pt-4">
		<x-slot name="content">
			@foreach ($languages as $lang)
				<div x-show="lang == 'tab-{{ $lang->locale }}'">
					<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 sm:shadow rounded-full bg-white dark:bg-black">
						<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
					</div>
					<input type="hidden" name="locale[]" value="{{ $lang->locale }}" />
					<div class="mb-4">
						<x-input-label for="question-{{ $lang->locale }}" :required="$default == $lang->id ? true : false" :value="__('question')" />
						<x-text-input id="question-{{ $lang->locale }}" name="question[]" type="text" maxlength="255" :required="$default == $lang->id ? true : false" />
						<x-input-error :messages="$errors->get('question')" />
					</div>
					<div>
						<x-input-label for="answer-{{ $lang->locale }}" :required="$default == $lang->id ? true : false" :value="__('answer')" />
						<x-text-input id="answer-{{ $lang->locale }}" name="answer[]" type="text" maxlength="255" :required="$default == $lang->id ? true : false" />
						<x-input-error :messages="$errors->get('answer')" />
					</div>
				</div>
			@endforeach
		</x-slot>
	</x-card>
	<x-card class="h-fit w-full max-w-xs">
		<x-slot name="content">
			<x-input-label for="priority" :required="true" :value="__('priority')" />
			<x-text-input id="priority" class="text-center" name="priority" type="number" min="1" step="1" required :value="isset($faq) ? old('priority', $faq->priority) : 1" />
			<x-input-error :messages="$errors->get('priority')" />
		</x-slot>
	</x-card>
</div>