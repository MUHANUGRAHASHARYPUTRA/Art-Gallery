<x-guest-layout>
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Welcome back</h2>
        <p class="mt-2 text-sm text-gray-500">Please enter your details to sign in.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:ring-black focus:border-black" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:ring-black focus:border-black" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-black shadow-sm focus:ring-black" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-indigo-600 hover:text-indigo-800" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <x-primary-button class="w-full justify-center py-4 text-base rounded-xl bg-black hover:bg-gray-800">
            {{ __('Sign in') }}
        </x-primary-button>

        <p class="text-center text-sm text-gray-500">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-bold text-black hover:underline">Sign up for free</a>
        </p>
    </form>
</x-guest-layout>