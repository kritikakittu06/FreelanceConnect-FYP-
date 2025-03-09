<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: url('https://example.com/your-background-image.jpg');">
        <div class="bg-black bg-opacity-70 rounded-lg shadow-lg p-8 w-[600px]">

            <!-- Login Form Header -->
            <h2 class="text-3xl font-bold text-center text-white mb-6">{{ __('LOGIN') }}</h2>
            <h3 class="text-lg text-center text-gray-300 mb-4">{{ __('Welcome User!') }}</h3>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors Popup -->
            @if ($errors->any())
                <div class="bg-red-500 text-white text-center p-3 rounded-md mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input id="email" class="block mt-1 w-full border border-gray-300 rounded-md p-2"
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" class="text-white" />
                    <x-text-input id="password" class="block mt-1 w-full border border-gray-300 rounded-md p-2"
                        type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('password.request') }}" class="text-white hover:underline">Forgot Password?</a>
                    <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-md ml-3">
                        {{ __('Sign In') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Sign Up Link -->
            <div class="mt-6 text-center">
                <p class="text-white">Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Sign Up</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
