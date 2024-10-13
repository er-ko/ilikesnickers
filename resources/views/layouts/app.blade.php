<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($meta_title) ? $meta_title .' | '. config('app.name', 'box') : config('app.name', 'box') }}</title>
        <meta name="description" content="{{ isset($meta_desc) ? $meta_desc : '' }}">
        <link rel="icon" type="image/png" href="{{ asset('/favicon.png') }}">

        <!-- Scripts -->
        <script defer src="https://unpkg.com/alpinejs-slug@latest/dist/slug.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" x-data="{ 'isModalOpen': false }" x-on:keydown.escape="isModalOpen = false">
        <div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">
            <div class="absolute top-3 right-3 flex items-center justify-center">
                @include('components.dark-mode')
            </div>
            @include('layouts.navigation')
            @isset($header)
                <!-- Page Heading -->
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
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
    </body>
</html>
