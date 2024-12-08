<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
		<div id="wrapper" class="w-full min-h-screen flex flex-col sm:flex-row">
            <aside class="flex sm:fixed h-full">
                @include('layouts.navigation')
            </aside>

            <!-- Page Content -->
			<main class="flex flex-1 sm:ml-64 lg:ml-72 py-4 xl:py-8 text-gray-900 dark:text-gray-200">
                <div class="w-full max-w-7xl mx-auto sm:px-2 lg:px-4">
                    {{ $slot }}
                </div>
            </main>
            
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
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        @stack('slotscript')
        <script src="{{ asset('js/darkMode.js') }}"></script>
    </body>
</html>
