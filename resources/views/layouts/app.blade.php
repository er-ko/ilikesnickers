<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
		<link rel="stylesheet" href="{{ asset('trumbowyg/ui/trumbowyg.min.css') }}">
    </head>
	<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

		<div id="wrapper" class="w-full min-h-screen flex flex-col sm:flex-row mb-4 sm:mb-0">
			<aside class="flex">
				@include('layouts.sidebar')
			</aside>
			<main class="flex flex-1 flex-col pt-4 text-gray-900 dark:text-gray-200 max-h-screen overflow-y-auto">
				@isset($header)
					<header class="w-full flex items-center px-8 sm:px-4 pb-4 sm:pb-0">
						{{ $header }}
					</header>
				@endisset

				<div class="mb-auto p-0 sm:px-4">
					{{ $slot }}
				</div>

				<div class="flex items-center justify-center py-12 bg-gray-100 dark:bg-gray-900">
					@isset($submit)
						{{ $submit }}
					@endisset
					@include('components.app-dark-mode')
				</div>
			</main>
		</div>

		@session('message')
			<div
				x-data="{ show: true }"
				x-show="show"
				x-transition
				x-init="setTimeout(() => show = false, 3000)"
				class="absolute bottom-2 right-2 lg:bottom-4 lg:right-4 w-fit py-3 px-4 lg:py-6 lg:px-8 text-sm lg:text-base shadow-sm sm:rounded-lg bg-gray-800 text-white dark:bg-white dark:text-black"
			>
				{{ session('message') }}
			</div>
			{{ request()->session()->forget('message') }}
		@endsession

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="{{ asset('trumbowyg/trumbowyg.min.js') }}"></script>
		@stack('slotscript')
		<script>
			if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
				document.documentElement.classList.add('dark');
			} else {
				document.documentElement.classList.remove('dark')
			}
		</script>
		<script src="{{ asset('js/darkMode.js') }}"></script>
	</body>
</html>