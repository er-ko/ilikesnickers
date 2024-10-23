<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
    </head>
	<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
		<div id="wrapper" class="w-full min-h-screen flex py-4 pr-4 space-x-4 border-4 border-green-500">
			<div id="sidebar-wrapper" class="w-full max-w-[300px] flex duration-500">
				@include('layouts.sidebar')
			</div>
			<div class="flex flex-1 flex-col items-start justify-start space-y-8">
				@isset($header)
					<header class="w-full min-h-[80px] flex items-center justify-start px-4 lg:px-8 shadow rounded-lg font-bold text-xl leading-tight bg-white dark:bg-gray-800">
						{{ $header }}
					</header>
				@endisset

				<main class="w-full">
					{{ $slot }}
				</main>
			</div>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
			@stack('slotscript')
			<script>
				if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
					document.documentElement.classList.add('dark');
				} else {
					document.documentElement.classList.remove('dark')
				}
			</script>
			<script src="{{ asset('js/darkMode.js') }}"></script>
		</div>
	</body>
</html>