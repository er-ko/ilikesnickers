<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
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
                            <a
                                href="{{ route('booking.index') }}"
                                class="px-8 py-4 border-b border-gray-200 dark:border-gray-600 {{ request()->routeIs(['booking.index']) ? 'font-bold border-teal-500 dark:border-teal-400' : '' }}"
                            >
                                {{ __('messages.booking') }}
                            </a>
                            <a
                                href="{{ route('category.index') }}"
                                class="px-8 py-4 border-b border-gray-200 dark:border-gray-600 {{ request()->routeIs(['category.index', 'category.show']) ? 'font-bold border-teal-500 dark:border-teal-400' : '' }}"
                            >
                                {{ __('messages.shop') }}
                            </a>
                            <a
                                href="{{ route('contact.index') }}"
                                class="px-8 py-4 border-b border-gray-200 dark:border-gray-600 {{ request()->routeIs('contact.index') ? 'font-bold border-teal-500 dark:border-teal-400' : '' }}"
                            >
                                {{ __('messages.contact') }}
                            </a>
                            <a
                                href="{{ route('faq.index') }}"
                                class="px-8 py-4 border-b border-gray-200 dark:border-gray-600 {{ request()->routeIs('faq.index') ? 'font-bold border-teal-500 dark:border-teal-400' : '' }}"
                            >
                                {{ __('messages.faq') }}
                            </a>
                        </nav>
                    </header>
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex flex-1 w-full max-w-7xl mb-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
            <footer class="w-full flex items-center justify-between py-12 bg-white text-black dark:bg-gray-950/25 dark:text-gray-400">
                <div class="w-full max-w-5xl grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 mx-auto px-4">
                    <ul class="font-light leading-8 tracking-widest text-center sm:text-left">
                        <li>
                            <a href="{{ route('welcome') }}" class="hover:font-normal">Blog</a>
                        </li>
                        <li>
                            <a href="{{ route('welcome') }}" class="hover:font-normal">Booking</a>
                        </li>
                        <li>
                            <a href="{{ route('welcome') }}" class="hover:font-normal">Shop</a>
                        </li>
                    </ul>
                    <ul class="font-light leading-8 tracking-widest text-center sm:text-left">
                        <li>
                            <a href="{{ route('welcome') }}" class="hover:font-normal">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('welcome') }}" class="hover:font-normal">Contact</a>
                        </li>
                        <li>
                            <a href="{{ route('welcome') }}" class="hover:font-normal">Gallery</a>
                        </li>
                    </ul>
                    <ul class="font-light leading-8 tracking-widest text-center sm:text-left">
                        <li>
                            <a href="{{ route('welcome') }}" class="hover:font-normal">GDPR</a>
                        </li>
                        <li>
                            <a href="{{ route('welcome') }}" class="hover:font-normal">Services</a>
                        </li>
                        <li>
                            <a href="{{ route('welcome') }}" class="hover:font-normal">FAQ</a>
                        </li>
                    </ul>
                    <ul class="flex items-center justify-center text-sm text-gray-600 dark:text-gray-500">
                        <li class="px-1">
                            <img src="{{ asset('favicon.png') }}" class="w-full max-w-[80px] mb-3" />
                            <a href="{{ route('welcome') }}" class="">&copy; {{ date('Y') }} <span class="text-gray-400 dark:text-gray-500">{{ config('app.name') }}</span></a>
                        </li>
                    </ul>
                </div>
            </footer>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        @stack('slotscript')
        <script src="{{ asset('js/darkMode.js') }}"></script>
    </body>
</html>
