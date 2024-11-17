<x-app-layout>

	<x-slot name="meta_title">{{ __('messages.system') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.system') }}</x-slot>
	<x-slot name="title">{{ __('messages.system') }}</x-slot>

    <x-slot name="submit">
		<button form="form-store" type="submit" class="p-2.5 pl-4 rounded-l-full duration-300 bg-teal-600 text-white hover:bg-teal-700 dark:bg-teal-700 dark:hover:bg-teal-600">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
			</svg>
		</button>
	</x-slot>

    <form method="POST" action="{{ route('system.update', $system) }}" id="form-store">
        @csrf
        @method('patch')
        <div class="grid gap-4 grid-cols-1 xl:grid-cols-3">
            @include('system.partials.locale')    
            @include('system.partials.info')
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-app-layout>