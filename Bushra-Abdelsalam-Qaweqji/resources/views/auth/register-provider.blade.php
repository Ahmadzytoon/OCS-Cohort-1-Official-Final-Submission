<x-guest-layout>
    <div class="mb-6">
        <div class="flex rounded-lg bg-gray-100 p-1 text-sm font-medium">
            <a href="{{ route('register.seeker') }}"
                class="flex-1 rounded-md px-4 py-2 text-center {{ request()->routeIs('register.seeker') ? 'bg-white text-gray-900 shadow' : 'text-gray-600 hover:text-gray-800' }}">
                Seeker
            </a>
            <a href="{{ route('register.provider.onboarding') }}"
                class="flex-1 rounded-md px-4 py-2 text-center {{ request()->routeIs('register.provider.onboarding') ? 'bg-white text-gray-900 shadow' : 'text-gray-600 hover:text-gray-800' }}">
                Provider
            </a>
        </div>
    </div>
    <form method="POST" action="{{ route('register.provider.store') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Name" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                value="{{ old('name') }}" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                value="{{ old('email') }}" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="phone" value="Phone" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                value="{{ old('phone') }}" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="zip_code" value="Zip Code" />
            <x-text-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code"
                value="{{ old('zip_code') }}" />
            <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm" href="{{ route('login') }}">Already registered?</a>
            <x-primary-button style="background-color: #0b1f3a; height: 40px">Register as Provider</x-primary-button>
        </div>
    </form>
</x-guest-layout>
