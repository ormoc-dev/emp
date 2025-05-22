@extends('layouts.app')

@section('content')
    <!-- component -->
    <div class="flex h-screen ">
        <!-- Left Pane -->
        <div class="hidden lg:flex items-center justify-center flex-1 bg-white text-black">
            <div class="max-w-md text-center animate-fadeIn">
                <div id="register"
                  style="width: 500px; height: 600px;" ></div>

            </div>

        </div>
        <!-- Right Pane -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-8 md:p-12 bgs">
            <div class="w-full max-w-md bg-white rounded-lg shadow-2xl p-2 sm:p-12 relative">
                <!-- Logo -->
                <div class="absolute -top-8 -right-8 hidden sm:block ">
                    <img class="h-16 w-16 sm:h-20 sm:w-20 object-contain rounded-full  "
                        src="{{ asset('img/emp-logo.png') }}" alt="Logo">
                </div>

                <h1 class="text-3xl font-bold mb-2 text-gray-800 text-center animate-grow">Create Account</h1>
                <p class="text-sm text-gray-600 mb-8 text-center animate-slideIn">Join our community for free and get full
                    access</p>
                    @if (session('success'))
                    <div class="flex justify-center w-full">
                        <div class="flex items-center w-full max-w-xs  text-gray-500  "
                            id="toast-success" role="alert">
                            <div
                                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                </svg>
                                <span class="sr-only">Check icon</span>
                            </div>
                            <div class="ms-3 text-sm font-normal">{{ session('success') }} <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500">Login</a></div>         
                        </div>
                    </div>
                @endif
                <form class="space-y-6 " method="POST" action="{{ route('register') }}">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 animate-slideIn"
                            for="name">{{ __('Name') }}</label>
                        <input
                            class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            id="name" name="name" type="text" value="{{ old('name') }}" required
                            autocomplete="name" autofocus placeholder="Enter Full Name">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 animate-slideIn"
                            for="email">{{ __('Email Address') }}</label>
                        <input
                            class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            id="email" name="email" type="email" value="{{ old('email') }}" required
                            autocomplete="email" placeholder="Enter Email Address">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 animate-slideIn"
                            for="password">{{ __('Password') }}</label>
                        <input
                            class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            id="password" name="password" type="password" required autocomplete="new-password" placeholder="Enter Password">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 animate-slideIn"
                            for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input
                            class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            id="password-confirm" name="password_confirmation" type="password" required
                            autocomplete="new-password" placeholder="Confirm Password">
                    </div>

                    <div>
                        <button
                            class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            type="submit">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                            </svg>
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 animate-slideIn">
                        Already have an account?
                        <a class="font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('login') }}">
                            Login here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
  
@endsection
