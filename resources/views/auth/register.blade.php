<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Create an account</h2>
        <p class="mt-2 text-sm text-gray-500">Start your creative journey today.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label class="mb-2" :value="__('I want to join as a...')" />
            <div class="grid grid-cols-2 gap-4">
                <label class="relative flex flex-col items-center p-4 border rounded-2xl cursor-pointer hover:bg-gray-50 has-[:checked]:border-black has-[:checked]:bg-gray-50 has-[:checked]:ring-1 has-[:checked]:ring-black transition">
                    <input type="radio" name="role" value="member" class="absolute opacity-0" checked>
                    <span class="font-bold text-gray-900">Member</span>
                    <span class="text-xs text-gray-500 mt-1">Showcase Art</span>
                </label>
                <label class="relative flex flex-col items-center p-4 border rounded-2xl cursor-pointer hover:bg-gray-50 has-[:checked]:border-black has-[:checked]:bg-gray-50 has-[:checked]:ring-1 has-[:checked]:ring-black transition">
                    <input type="radio" name="role" value="curator" class="absolute opacity-0">
                    <span class="font-bold text-gray-900">Curator</span>
                    <span class="text-xs text-gray-500 mt-1">Host Events</span>
                </label>
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:ring-black focus:border-black" type="text" name="name" :value="old('name')" required autofocus placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:ring-black focus:border-black" type="email" name="email" :value="old('email')" required placeholder="john@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:ring-black focus:border-black" type="password" name="password" required placeholder="Min. 8 characters" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:ring-black focus:border-black" type="password" name="password_confirmation" required placeholder="Repeat password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center py-4 text-base rounded-xl bg-black hover:bg-gray-800 mt-4">
            {{ __('Create Account') }}
        </x-primary-button>

        <p class="text-center text-sm text-gray-500">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-bold text-black hover:underline">Log in</a>
        </p>
    </form>
</x-guest-layout>