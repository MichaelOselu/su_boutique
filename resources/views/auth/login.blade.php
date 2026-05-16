<x-guest-layout>

    <div class="w-full max-w-md mx-auto">

        <!-- Card -->
        <div class="bg-white shadow-lg rounded-2xl p-6 sm:p-8">

            <!-- Header -->
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-gray-800">
                    Welcome Back
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Login to your account
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />

                    <x-text-input
                        id="email"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input
                        id="password"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember + Forgot -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me"
                               type="checkbox"
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                               name="remember">

                        <span class="ms-2 text-sm text-gray-600">
                            {{ __('Remember me') }}
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:text-blue-800 underline"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif

                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2">

                    <a href="{{ route('register') }}"
                       class="text-sm text-gray-600 hover:text-gray-900 text-center sm:text-left">
                        Don’t have an account? Register
                    </a>

                    <x-primary-button class="w-full sm:w-auto justify-center">
                        {{ __('Log in') }}
                    </x-primary-button>

                </div>

            </form>

        </div>

    </div>

</x-guest-layout>
