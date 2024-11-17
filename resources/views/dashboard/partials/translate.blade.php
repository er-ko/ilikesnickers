<x-card class="w-full max-w-md lg:p-8">
	<x-slot name="content">
		<h3 class="mb-4 text-2xl font-semibold uppercase flex items-center justify-start">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 me-2">
				<path stroke-linecap="round" stroke-linejoin="round" d="m10.5 21 5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 0 1 6-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 0 1-3.827-5.802" />
			</svg>
			{{ __('translate') }}
		</h3>
		<div class="flex flex-col items-start justify-start">
			@foreach ($translates as $translate)
				<div class="w-full flex items-center justify-between">
					<div class="flex items-center">
						<img src="{{ asset('/storage/flags/'. $translate['flag']) }}" class="w-4 me-2" />
						<span class="font-bold">{{ $translate['name'] }}</span>
					</div>
					<div>
						<span class="text-xs me-1">{{ $translate['all'] - $translate['empty'] .'/'. $translate['all'] }}</span>
						<span class="font-bold">{{ round(-($translate['empty'] / $translate['all'] - 1) * 100) }}%</span>
					</div>
				</div>
				<div class="w-full mt-2 mb-4 rounded-full bg-gray-200 dark:bg-gray-600">
					<div class="block h-2 text-center font-bold rounded-full bg-emerald-500/50 dark:bg-emerald-500 text-white" style="width:{{ round(-($translate['empty'] / $translate['all'] - 1) * 100) }}%"></div>
				</div>
			@endforeach
		</div>
	</x-slot>
</x-card>