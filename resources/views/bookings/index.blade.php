@auth
	<x-app-layout>
		<x-slot name="meta_title">{{ __('messages.booking') }}</x-slot>
		<x-slot name="meta_desc">{{ __('messages.booking') }}</x-slot>
		<x-slot name="title">{{ __('messages.booking') }}</x-slot>

		<x-slot name="submit">
			<a href="{{ route('booking.create') }}" class="p-2.5 pl-4 duration-300 shadow rounded-l-full bg-teal-600 text-white hover:bg-teal-700">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
					<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
				</svg>
			</a>
		</x-slot>

		booking settings

		<ol class="list-decimal">
			<li>booking start</li>
			<li>booking end</li>
			<li>days in week</li>
			<li>open during holiday</li>
			<li>days will be close like christmas time etc..</li>
			<li>time before</li>
			<li>time after depends on service</li>
			<li>type of service</li>
			<li>price of service</li>
			<li>time of service</li>
			<li>slot</li>
			<li>firstname and surename</li>
			<li>phone</li>
			<li>email</li>
			<li>email notification</li>
			<li>email notofication before service</li>
			<li>review after service (facebook, google, page)</li>
		</ol>

	</x-app-layout>
@else
	<x-public-layout>
		book me!
	</x-public-layout>
@endauth