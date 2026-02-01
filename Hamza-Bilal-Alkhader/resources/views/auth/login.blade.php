<x-guest-layout>

    <style>
  /* زر رجوع للهوم */
  .auth-back{
    display:inline-block;
    margin-bottom:16px;
    color:#5fcf80;
    font-weight:600;
    text-decoration:none;
  }
  .auth-back:hover{ color:#4bb96d; text-decoration:underline; }

  /* فوكس الانبت أخضر */
  .auth-input:focus{
    border-color:#5fcf80 !important;
    box-shadow: 0 0 0 .2rem rgba(95,207,128,.20) !important;
  }

  /* زر الدخول أخضر */
  .auth-btn{
    background:#5fcf80 !important;
    border-color:#5fcf80 !important;
  }
  .auth-btn:hover{
    background:#4bb96d !important;
    border-color:#4bb96d !important;
  }

  /* الرابط تحت أخضر */
  .auth-link{
    color:#5fcf80;
    font-weight:600;
    text-decoration:none;
  }
  .auth-link:hover{ color:#4bb96d; text-decoration:underline; }
</style>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <a href="{{ route('pages.home') }}" class="auth-back">← Back to Home</a>


    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class=" auth-input block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="auth-input block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
           {{--   @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif --}}

            <a href="{{ route('register') }}" class="auth-link">
  Don’t have an account?
</a>


            <x-primary-button class="ms-3 auth-btn">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
