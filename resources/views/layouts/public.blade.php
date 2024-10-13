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
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col items-center justify-start bg-gray-100 dark:bg-gray-900">

            <div class="lg:absolute lg:top-6 lg:right-6 flex items-center justify-center mt-8 lg:mt-0">
                @isset($postClose)
                    {{ $postClose }}
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" target="_self" class="py-3 pr-3.5 pl-5 rounded-l-full shadow duration-300 bg-white hover:bg-gray-200 dark:bg-black dark:hover:bg-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 dark:text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                    @endif
                @endisset
                @include('components.lang-switch')
                @include('components.dark-mode')
            </div>

            @if (!request()->routeIs(['post.show']))
                <div class="w-full max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                    <header class="py-2 px-8">
                        <nav class="-mx-3 flex items-center justify-center dark:text-white">
                            <a
                                href="{{ route('welcome') }}"
                                class="px-8 py-4 border-b border-gray-200 dark:border-gray-600 {{ request()->routeIs(['welcome']) ? 'font-bold border-teal-500 dark:border-teal-400' : '' }}"
                            >
                                {{ __('messages.home') }}
                            </a>
                            <a
                                href="{{ route('post.index') }}"
                                class="px-8 py-4 border-b border-gray-200 dark:border-gray-600 {{ request()->routeIs(['post.index']) ? 'font-bold border-teal-500 dark:border-teal-400' : '' }}"
                            >
                                {{ __('messages.blog') }}
                            </a>
                        </nav>
                    </header>
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex flex-1 w-full max-w-7xl mb-auto py-6 px-4 sm:px-6 lg:px-8 lg:px-8">
                {{ $slot }}
            </main>
            <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="border-t border-dashed border-gray-200 dark:border-gray-800"></div>
            </div>
            <footer class="w-full max-w-7xl flex items-center justify-center mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <ul class="flex items-center justify-center text-sm text-gray-600 dark:text-gray-500">
                    <li class="px-1">
                        <a href="{{ route('welcome') }}" class="">&copy; {{ date('Y') }} <span class="text-gray-400 dark:text-gray-500">{{ config('app.name') }}</span></a>
                    </li>
                </ul>
            </footer>
        </div>

        @stack('slotscript')
        <script src="{{ asset('js/darkMode.js') }}"></script>
    </body>
</html>
