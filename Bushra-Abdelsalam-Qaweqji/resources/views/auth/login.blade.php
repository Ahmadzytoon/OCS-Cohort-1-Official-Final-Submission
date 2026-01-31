<x-guest-layout>
    <div class="cc-auth-header">
        <h1 class="cc-auth-title">Sign in</h1>
        <p class="cc-auth-subtitle">Welcome back. Please enter your details.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="cc-auth-status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="cc-auth-form">
        @csrf

        <!-- Email Address -->
        <div class="cc-auth-field">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="cc-auth-input" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" placeholder="super-example@gmail.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="cc-auth-field">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="cc-auth-input" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="cc-auth-row">
            <label for="remember_me" class="cc-auth-remember">
                <input id="remember_me" type="checkbox" class="cc-auth-checkbox" name="remember">
                <span>{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="cc-auth-link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="pt-1">
            <x-primary-button class="cc-auth-submit" style="background-color: #0b1f3a; height: 40px">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <p class="cc-auth-footer">
            You don't have an account?
            <a href="{{ route('register.seeker') }}">Register now</a>
        </p>
    </form>
</x-guest-layout>
