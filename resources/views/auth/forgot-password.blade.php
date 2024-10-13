<x-guest-layout>

    <x-slot name="meta_title">{{ __('messages.forgot_password') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.forgot_your_password') }}?</x-slot>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('messages.forgot_your_password_text') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('messages.email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center justify-end">
            <x-primary-button>
                {{ __('messages.password_reset_link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
