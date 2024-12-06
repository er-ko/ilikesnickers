<x-card class="relative space-y-2">
	<x-slot name="content">
		@foreach ($activities as $activity)
			<div class="block-value flex items-center justify-start space-x-4">
				<input type="checkbox" name="activity[]" value="{{ $activity->id }}" />
				<x-text-input class="flex-1" type="text" :value="$activity->title" readonly="true" />
			</div>
		@endforeach
	</x-slot>

	@push('slotscript')
	<script>

		var count	= 0;
		var block	= '';
		var attr	= '';
		var label	= '';
		var input	= '';
		var button	= '';
		var locale	= '';

			$(document).ready(function(){

				// $('.lang-tab').each(function( index ) {
				// 	locale = $(this).attr('id');
				// 	loadData('title', locale);
				// 	loadData('values', locale);
				// });

				$('.btn-add-value').click(function(){
					count++;
					$('.area-value').each(function(i, l){
						block	= $(this).find('.block-value').first().clone();
						attr	= block.find('label').attr('for') +'-'+ count;
						label	= block.find('label').attr('id', attr);
						input	= block.find('input').val('').attr('id', attr);
						button	= block.find('button').removeClass('hidden').attr('data-id-type', count);
						$(this).append(block);
					})
				});
				$('.area-value').on('click', 'button', function(){
					button = $(this).attr('data-id-type');
					$('.area-value').each(function(i, l){
						$(this).find('button[data-id-type="'+ button +'"]').parent().parent().remove();
					});
				});

			});
		</script>
	@endpush
</x-card>