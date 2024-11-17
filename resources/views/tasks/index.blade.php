<x-app-layout>

	<x-slot name="meta_title">{{ __('tasks') }}</x-slot>
	<x-slot name="meta_desc">{{ __('tasks') }}</x-slot>
	<x-slot name="title">{{ __('task') }}</x-slot>

	<x-slot name="header">
		<x-text-input
			id="new-todo"
			type="text"
			class="lg:px-4 dark:text-teal-500"
			maxlength="255"
			placeholder="{{ __('put_the_task_and_press_enter') }}.."
			autofocus
		/>
	</x-slot>

	<div id="tasks" class="grid gap-4 grid-cols-1 lg:grid-cols-3 sm:mt-4 lg:mt-6">
		<div id="opened" class="w-full h-full max-h-[325px] lg:max-h-[680px] sm:col-span-2 overflow-y-auto p-4 xl:p-8 sm:rounded-lg shadow-sm bg-orange-50 dark:bg-gray-800/50"></div>
		<div id="closed" class="w-full h-fit max-h-[325px] lg:max-h-[680px] overflow-y-auto p-4 xl:p-8 sm:rounded-lg shadow-sm bg-emerald-50 dark:bg-gray-950/25"></div>
	</div>

	@push('slotscript')
		<script>
			$(document).ready(function(){
				var type	= '';
				var todo	= '';
				var status	= '';
				
				ajax('read', todo, status);
				$('#new-todo').keydown(function(e){
					if (e.keyCode == 13) {
						e.preventDefault();
						todo = $(this).val();
						ajax('create', todo, status);
						$(this).val('');
					}
				});
			});
			function ajax(type, todo, status) {
				$.ajax({
					url: "{{ route('task.index') }}",
					type: 'GET',
					dataType: 'json',
					data: {
						type: type,
						todo: todo,
						status: status,
					},
					success: function(data) {
						if (!$.isEmptyObject(data[0])) {
							$('#tasks #opened').text('');
							$('#tasks #closed').text('');
							$.each(data, function (i) {
								if (data[i]['status'] === 0) {
									var output = '<div class="relative flex items-center justify-start mb-3 px-4 xl:px-8 py-4 duration-300 rounded-md shadow hover:shadow-md bg-white text-gray-800 dark:bg-gray-800 dark:text-gray-100">';
										output += '<div class="absolute -top-1.5 -left-1.5 w-6 h-6 flex items-center justify-center rounded-full bg-orange-600 text-white dark:bg-orange-500">?</div>';
										output +='<input type="checkbox" id="'+ data[i]['id'] +'" class="checkbox me-3" value="1" />';
										output += '<label for="'+ data[i]['id'] +'">' + data[i]['title'] +'</label>';
										output +='</div>';
									$('#tasks #opened').append(output);
								} else {
									var output = '<div class="relative flex items-center justify-start mb-3 px-4 xl:px-8 py-4 duration-300 rounded-md shadow hover:shadow-md bg-white text-teal-700 dark:text-gray-400 dark:bg-teal-950/50">';
										output += '<div class="absolute -top-1.5 -left-1.5 p-1 rounded-full bg-teal-600 text-white dark:bg-teal-500">';
										output += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">';
										output += '<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />';
										output += '</svg>';
										output += '</div>';
										output +='<input type="checkbox" id="'+ data[i]['id'] +'" class="checkbox me-3" value="0" checked />';
										output += '<label for="'+ data[i]['id'] +'">' + data[i]['title'] +'</label>';
										output += '<button type="button" data="'+ data[i]['id'] +'" class="absolute -top-1 -right-1 p-1 rounded bg-pink-600 text-white">';
										output += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">';
										output += '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />';
										output += '</svg>';
										output += '</button>';
										output += '</div>';
									$('#tasks #closed').append(output);
								}
							});
							$('#tasks .checkbox').on('click', function(){
								ajax('update', $(this).attr('id'), $(this).val());
								location.reload();
							});
							$('#tasks #closed button').on('click', function(){
								ajax('delete', $(this).attr('data'), status);
								location.reload();
							});
						}
					}
				});
			}
		</script>
	@endpush
</x-app-layout>
