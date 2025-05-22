@extends('layouts.app')

@section('content')
    <!-- component -->
    <div class="flex h-screen">
        <!-- Left Pane -->
        <div class="hidden lg:flex items-center justify-center flex-1 bg-white text-black">
            <div class="max-w-md text-center animate-fadeIn">
                <div id="reset"
                  style="width: 400px; height: 500px;" ></div>
            </div>
        </div>
        <!-- Right Pane -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-8 md:p-12 bgs">
            <div class="w-full max-w-md bg-white rounded-lg shadow-2xl p-6 sm:p-8 relative">
                <!-- Logo -->
                <div class="absolute -top-8 -right-8 hidden sm:block">
                    <img class="h-16 w-16 sm:h-20 sm:w-20 object-contain rounded-full"
                        src="{{ asset('img/emp-logo.png') }}" alt="Logo">
                </div>
                <h1 class="text-3xl font-bold mb-2 text-gray-800 text-center animate-grow">Reset Password</h1>
                <p class="text-sm text-gray-600 mb-8 text-center animate-slideIn">Enter your email to receive a password
                    reset link</p>
                <div class="mt-4 flex flex-col lg:flex-row items-center justify-between animate-fadeIn">
                    <div class="w-full lg:w-1/2 mb-2 lg:mb-0">
                        <button
                            class="w-full flex justify-center items-center gap-2 bg-white text-sm text-gray-600 p-2 rounded-md hover:bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors duration-300"
                            type="button">
                            <a href="https://www.facebook.com/antony.capuyan">
                                <i class='bx bxl-facebook-circle text-lg  text-blue-600 '></i>
                                </svg> Contact us on Facebook
                            </a>
                        </button>
                    </div>
                    <div class="w-full lg:w-1/2 ml-0 lg:ml-2">
                        <button
                            class="w-full flex justify-center items-center gap-2 bg-white text-sm text-gray-600 p-2 rounded-md hover:bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors duration-300"
                            type="button">
                            <a href="mailto:tonyocapuyan@gmail.com">
                                <i class='bx bxs-envelope text-blue-600 text-lg'></i>
                                </svg> Contact us on Gmail
                            </a>
                        </button>
                    </div>
                </div>


                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    @if (session('status'))
                    <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                        role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Success!</span> {{ session('status') }}
                        </div>
                    </div>
                @endif
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600"
                            for="email">{{ __('Email Address') }}</label>
                        <input
                            class="form-input mt-1 block w-full p-3 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                            id="email" name="email" type="email" value="{{ old('email') }}" required
                            autocomplete="email" autofocus>

                        @error('email')
                            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium">Alert!</span> {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </div>

                 

                    <div class="mb-0">
                        <button
                            class="w-full flex justify-center items-center bg-red-500 text-white p-2 hover:bg-red-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-800"
                            type="submit">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
