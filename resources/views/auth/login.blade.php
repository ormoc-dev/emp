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

                <form class="space-y-4 sm:space-y-6" method="POST" action="{{ route('login') }}">
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
                            class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            type="submit">
                            {{ __('Sign In') }}
                            <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 py-2">
                        Don't have an account?
                        <a class="font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('register') }}">
                            Register here
                        </a>
                    </p>
                    
                </div>



            </div>

        </div>
    </div>
@endsection
