<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($meta_title) ? $meta_title .' | '. config('app.name', 'box') : config('app.name', 'box') }}</title>
        <meta name="description" content="{{ isset($meta_desc) ? $meta_desc : '' }}">
        <link rel="icon" type="image/png" href="/favicon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="absolute top-5 right-5 flex items-center justify-center">
                @isset($postClose)
                    {{ $postClose }}
                @else
                    <a href="{{ route('welcome') }}" target="_self" class="p-4 rounded-full shadow duration-300 bg-gray-400 text-white hover:bg-gray-700 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </a>
                @endisset
            </div>
            <div class="mt-16 lg:mt-0">
                <a href="/">
                    <x-application-logo class="w-20" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
            @if (Route::has('login'))
                @if (Route::has('register'))
                    @if (request()->routeIs('login'))
                        <div class="w-full sm:max-w-md mt-2 px-6 py-4 flex justify-end">
                            <span class="mr-2 text-sm text-gray-500 dark:text-gray-500">{{ __('messages.dont_have_an_account') }}?</span>
                            <a
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-teal-600 dark:focus:ring-offset-gray-800"
                                href="{{ route('register') }}">
                                <span>{{ __('messages.register_now') }}!</span>
                            </a>
                    @endif
                @endif
            @endif
        </div>
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
