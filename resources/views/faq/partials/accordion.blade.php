@if (!$faqs->isEmpty())
	<div class="accordion w-full h-fit sm:rounded-xl shadow dark:text-gray-300">
		@foreach($faqs as $faq)
			<div class="accordion-item bg-white border-b border-gray-100 dark:bg-slate-800 dark:border-slate-700/50">
				<div class="accordion-header flex items-center justify-between p-8 hover:cursor-pointer">
					<h3 class="lg:text-lg font-semibold lowercase"># {{ $faq->question }}</h3>
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 duration-200 text-gray-500 dark:text-slate-600">
						<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
					</svg>
				</div>
				<div class="accordion-body hidden px-8 dark:text-gray-200">
					<div class="content py-6 border-t border-gray-100 dark:border-gray-900">
						<p>{{ $faq->answer }}</p>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@else
	<div class="my-8 text-center">{{ __('no_faqs') }}</div>
@endif
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