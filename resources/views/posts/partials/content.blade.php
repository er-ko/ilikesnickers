@foreach ($languages as $lang)
	<div
		class="relative p-6 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100"
		x-show="lang == 'tab-{{ $lang->locale }}'"
	>
		<div class="absolute top-1 left-1 sm:-top-4 sm:-left-4 p-0 sm:p-2 rounded-full sm:shadow bg-white dark:bg-black">
			<img src="{{ asset('/storage/flags/'. $lang->flag) }}" />
		</div>
		<div>
			<textarea id="content-{{ $lang->locale }}" class="content" name="content[]" rows="10"></textarea>
			<x-input-error :messages="$errors->get('content')" />
		</div>
	</div>
@endforeach