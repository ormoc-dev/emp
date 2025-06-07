@extends('layouts.app')
@section('content')
    <div class="flex min-h-screen bg-gray-100">
        <!-- Left Pane (Hidden on small screens) -->
        <div class="items-center justify-center flex-1 hidden lg:flex ">
            <div class="max-w-md p-8">
                <div id="login" style="width: 400px; height: 500px;">
                </div>
            </div>
        </div>
        <!-- Right Pane -->
        <div class="flex items-center justify-center w-full p-4 lg:w-1/2 sm:p-8 md:p-12 bgs">
            <div class="relative w-full max-w-md p-2 bg-white rounded-lg shadow-2xl sm:p-12">
                <!-- Logo -->
                <div class="absolute hidden -top-8 -right-8 sm:block ">
                    <img class="object-contain w-16 h-16 rounded-full sm:h-20 sm:w-20 " src="{{ asset('img/emp-logo.png') }}"
                        alt="Logo">
                </div>

                <h1 class="flex flex-col items-center mb-2 text-2xl font-bold text-center text-gray-800 sm:text-3xl">
                    <span class="inline-block" id="ai_hi" style="width: 100px; height: 50px;"></span>
                    Welcome!
                </h1>
                <p class="mb-6 text-sm text-center text-gray-600 sm:mb-8">Sign in to access your account</p>

                <form class="space-y-4 sm:space-y-6" method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            for="email">{{ __('Email Address / Username') }}</label>
                        <input
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            id="email" name="email" type="text" value="{{ old('email') }}" required
                            autocomplete="email" autofocus placeholder="Enter Email Address / Username">
                    
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="password">{{ __('Password') }}</label>
                        <input
                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            id="password" name="password" type="password" required autocomplete="current-password" placeholder="Enter Password">

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap items-center justify-between">
                        <label class="flex items-center">
                            <input class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                            <span class="block ml-2 text-sm text-gray-900">{{ __('Remember Me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="mt-2 text-sm font-medium text-indigo-600 hover:text-indigo-500 sm:mt-0"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                    <div>
                        <button
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
                            type="submit" id="loginButton">
                            <div id="loadingSpinner" class="hidden">
                                <svg aria-hidden="true" role="status" class="inline w-5 h-5 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                            </div>
                            {{ __('Sign In') }}
                        </button>
                    </div>

                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 py-2">
                        Don't have an account?
                        <a class="font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('register') }}"  wire:navigate>
                            Register here
                        </a>
                    </p>
                </div>
                
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            // Show the loading spinner
            document.getElementById('loadingSpinner').classList.remove('hidden');
            // Disable the login button to prevent multiple submissions
            document.getElementById('loginButton').disabled = true;
        });
    </script>
@endsection