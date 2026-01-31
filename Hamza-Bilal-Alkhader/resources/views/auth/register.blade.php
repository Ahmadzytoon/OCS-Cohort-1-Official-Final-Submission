
<x-guest-layout>

    <style>
  /* زر الرجوع للهوم */
  .auth-back{
    display:inline-flex;
    align-items:center;
    gap:.4rem;
    color:#5fcf80;
    font-weight:600;
    text-decoration:none;
    margin-bottom:14px;
  }
  .auth-back:hover{
    color:#4bb96d;
    text-decoration:underline;
  }

  /* فوكس الانبت أخضر */
  .auth-input:focus{
    border-color:#5fcf80 !important;
    box-shadow: 0 0 0 .2rem rgba(95,207,128,.20) !important;
  }

  /* زر الريجيستر أخضر */
  .auth-btn{
    background:#5fcf80 !important;
    border-color:#5fcf80 !important;
  }
  .auth-btn:hover{
    background:#4bb96d !important;
    border-color:#4bb96d !important;
  }

  /* الروابط أخضر */
  .auth-link{
    color:#5fcf80;
    font-weight:600;
    text-decoration:none;
  }
  .auth-link:hover{
    color:#4bb96d;
    text-decoration:underline;
  }
</style>

 <a href="{{ route('pages.home') }}" class="auth-back">
  <i class="bi bi-arrow-left"></i>
  ← Back to Home
</a>


    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="auth-input block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="auth-input block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
<!--Phone-->
        <div class="mt-4">
  <x-input-label for="phone" value="Phone Number" />
  <x-text-input id="phone" class="auth-input block mt-1 w-full"
    type="text" name="phone" :value="old('phone')" required autofocus
    placeholder="07XXXXXXXX" />
  <x-input-error :messages="$errors->get('phone')" class="mt-2" />
</div>

<!-- Role -->
<div class="mt-4">
    <x-input-label for="role" :value="__('Role')" />

    <select
        id="role"
        name="role"
        required
        class="auth-input block mt-1 w-full rounded-md border-gray-300 shadow-sm
               focus:border-indigo-500 focus:ring-indigo-500"
    >
        <option value="" disabled selected>Select role</option>
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
    </select>

    <x-input-error :messages="$errors->get('role')" class="mt-2" />
</div>


        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="auth-input block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="auth-input block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="auth-link underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 auth-btn">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
