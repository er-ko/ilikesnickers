<x-public-layout>

	<x-slot name="meta_title">{{ $page->meta_title }}</x-slot>
	<x-slot name="meta_desc">{{ $page->meta_description }}</x-slot>

	<div>
		<h1 class="mb-4 px-2 font-semibold text-2xl">{{ $page->title_h1 }}</h1>
		<span class="font-mono">{!! $page->content !!}</span>
	</div>

	@push('slotscript')
		<script>
			$(document).ready(function(){
				$('.accordion').find('.accordion-item').first().addClass('sm:rounded-t-lg');
				$('.accordion').find('.accordion-item').last().addClass('sm:rounded-b-lg');
				$('.accordion-header').click(function(){
					if ($(this).parent().find('.accordion-body').hasClass('hidden')) {
						$('.accordion-item').removeClass('bg-white dark:bg-slate-800').addClass('bg-gray-50 dark:bg-slate-800/50')
						$('.accordion-header').find('svg').removeClass('rotate-45 text-pink-700 dark:text-pink-600').addClass('text-gray-500 dark:text-slate-600');
						$('.accordion-body').addClass('hidden').slideUp();
						$(this).find('svg').addClass('rotate-45 text-pink-700 dark:text-pink-600').removeClass('text-gray-500 dark:text-slate-600');
						$(this).parent().removeClass('bg-gray-50 dark:bg-slate-800/50').addClass('bg-white dark:bg-slate-800')
						$(this).parent().find('.accordion-body').slideDown(function(){
							$(this).removeClass('hidden');
						});
					} else {
						$(this).find('svg').removeClass('rotate-45 text-pink-700 dark:text-pink-600').addClass('text-gray-500 dark:text-slate-600');
						$(this).parent().find('.accordion-body').addClass('hidden').slideUp();
						$('.accordion-item').removeClass('bg-gray-50 dark:bg-slate-800/50').addClass('bg-white dark:bg-slate-800');
					}
				});
			});
		</script>
	@endpush

</x-public-layout>