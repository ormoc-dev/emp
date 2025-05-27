<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E.M.P') }}</title>
        <link type="image/png" href="{{ asset('img/emp-logo.png') }}" rel="icon">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.css" rel="stylesheet">
        <link href="{{ asset('css/boxicon/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('css/loader.css') }}" rel="stylesheet">
        <link href="{{ asset('frameworks/diasyui/dist/full.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Include jQuery -->
        <link href="{{ asset('css/jquery_length.css') }}" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <!-- Include Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- Include Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <style>
            #loading {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.8);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;
            }

            .spinner {
                border: 4px solid rgba(0, 0, 0, 0.1);
                /* Light grey */
                border-left: 4px solid #000;
                /* Black */
                border-radius: 50%;
                width: 40px;
                height: 40px;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>


        @livewireStyles
        @vite(['resources/css/app.css'])
    </head>

    <body>

        <div class="antialiased bg-gray-50 dark:bg-gray-900">
            <nav
                class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="flex items-center justify-start">
                        <button
                            class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                            aria-controls="drawer-navigation">
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <svg class="hidden w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>f
                            <span class="sr-only">Toggle sidebar</span>
                        </button>
                        <a class="flex items-center justify-between mr-4" href="">
                            <img class="h-8 w-8 mr-3" src="{{ asset('img/emp-logo.png') }}" alt="" />
                            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">EVENT
                                MASTER-PRO</span>
                        </a>

                    </div>
                    <div class="flex items-center lg:order-2">
                        <button
                            class="p-2 mr-1 text-gray-500 rounded-lg md:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            data-drawer-toggle="drawer-navigation" type="button" aria-controls="drawer-navigation">
                            <span class="sr-only">Toggle search</span>
                            <svg class="w-6 h-6" aria-hidden="true" aria-hidden="true" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z">
                                </path>
                            </svg>
                        </button>
                        <!-- Notifications -->
                        <button
                            class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            data-dropdown-toggle="notification-dropdown" type="button">
                            <span class="sr-only">View notifications</span>
                            <!-- Bell icon -->
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                                </path>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div class="z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:divide-gray-600 dark:bg-gray-700 rounded-xl"
                            id="notification-dropdown">
                            <div
                                class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-600 dark:text-gray-300">
                                Notifications
                            </div>
                            <div>



                                <a class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600"
                                    href="#">
                                    <div class="flex-shrink-0">

                                    </div>
                                    <div class="w-full pl-3">

                                    </div>
                                </a>

                            </div>
                            <a class="block py-2 font-medium text-center text-gray-900 text-md bg-gray-50 hover:bg-gray-100 dark:bg-gray-600 dark:text-white dark:hover:underline"
                                href="#">
                                <div class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    View all
                                </div>
                            </a>
                        </div>
                        <!-- Apps -->


                        <button class="" id="user-menu-button" data-dropdown-toggle="dropdown" type="button"
                            aria-expanded="false">
                            <span class="sr-only">Open user menu</span>
                            <span>
                                @php
                                    $user = auth()->user();
                                @endphp

                                <div class="relative">
                                    @if ($user->profile && file_exists(public_path($user->profile)))
                                        <img class="h-8 w-8 rounded-full object-cover border-4 border-white shadow-lg"
                                            src="{{ asset($user->profile) }}" alt="User Profile Image"
                                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random';" />
                                    @else
                                        <img class="h-8 w-8 rounded-full object-cover border-4 border-white shadow-lg"
                                            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                            alt="Default Profile Image" />
                                    @endif
                                </div>
                            </span>
                        </button>
                        <!-- Dropdown menu -->
                        <div class="z-50 hidden w-56 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 rounded-xl"
                            id="dropdown">
                            <div class="px-4 py-3">
                                <span
                                    class="block text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                                <span
                                    class="block text-sm text-gray-900 truncate dark:text-white">{{ Auth::user()->email }}</span>
                            </div>
                            <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">

                                <li>
                                    <a class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white"
                                        href="{{ route('MyProfile') }}" wire:navigate>Account
                                        settings</a>
                                </li>
                            </ul>

                            <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
                                <li>
                                    <a class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        href="#" onclick="confirmLogout();">Sign
                                        out</a>

                                    <form class="d-none" id="logout-form" action="{{ route('logout') }}"
                                        method="POST">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Sidebar -->

            <aside
                class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 pt-14 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
                id="drawer-navigation" aria-label="Sidenav">
                <div class="h-full px-3 py-5 overflow-y-auto bg-white dark:bg-gray-800">
                    <form class="mb-2 md:hidden" action="#" method="GET">
                        <label class="sr-only" for="sidebar-search">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z">
                                    </path>
                                </svg>
                            </div>
                            <input
                                class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                id="sidebar-search" name="search" type="text" placeholder="Search" />
                        </div>
                    </form>
                    <ul class="space-y-2">
                        <li>
                            <a class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg ajax-link dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                                href="{{ route('Sadmin_home') }}" wire:navigate>
                                <svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg>
                                <span class="ml-3">Overview</span>
                            </a>
                        </li>
                        <li>
                            <button
                                class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                data-collapse-toggle="dropdown-pages" type="button" aria-controls="dropdown-pages">
                                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                    aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">Pages</span>
                                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <ul class="hidden py-2 space-y-2" id="dropdown-pages">
                                <li>
                                    <a class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg ajax-link pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        href="{{ route('settings') }}" wire:navigate>Welcome Page</a>
                                </li>
                                <li>
                                    <a class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg ajax-link pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        href="{{ route('video-highlights.index') }}" wire:navigate>Video
                                        Highlights</a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <button
                                class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                data-collapse-toggle="dropdown-sales" type="button" aria-controls="dropdown-sales">
                                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                    aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">Sales</span>
                                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <ul class="hidden py-2 space-y-2" id="dropdown-sales">
                                <li>
                                    <a class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        href="{{ route('transactions.index') }}">Payments</a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                                href="{{ route('supper.admin.messages') }}" wire:navigate>
                                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z">
                                    </path>
                                    <path
                                        d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z">
                                    </path>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Messages</span>
                                @if (isset($feedbackCount) && $feedbackCount > 0)
                                    <span
                                        class="inline-flex items-center justify-center w-5 h-5 text-xs font-semibold rounded-full 
                        bg-red-100 text-red-800 dark:bg-primary-200 dark:text-primary-800">
                                        {{ $feedbackCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <button
                                class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                data-collapse-toggle="dropdown-authentication" type="button"
                                aria-controls="dropdown-authentication">
                                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                    aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">Authentication</span>
                                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <ul class="hidden py-2 space-y-2" id="dropdown-authentication">
                                <li>
                                    <a class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        href="{{ route('MyProfile') }}" wire:navigate>My Profile</a>
                                </li>
                                <li>
                                    <a class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        href="{{ route('audience') }}" wire:navigate>Audience</a>
                                </li>
                                <li>
                                    <a class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        href="{{ route('Tabulators') }}" wire:navigate>Tabulators</a>
                                </li>
                                <li>
                                    <a class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        href="{{ route('ForgotPassword') }}" wire:navigate>
                                        Forgot Password
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                    <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
                        <li>
                            <a class="flex items-center p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
                                href="{{ route('docs_index') }}">
                                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-3">Docs</span>
                            </a>
                        </li>


                    </ul>
                </div>
                <div
                    class="absolute bottom-0 left-0 z-20 hidden w-full p-4 space-x-4 bg-white lg:flex dark:bg-gray-800">
                    <a class="inline-flex items-center justify-center p-2 text-red-500 rounded cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600"
                        data-tooltip-target="tooltip-settings" href="#">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i> LOG OUT
                    </a>
                    <div class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip"
                        id="tooltip-settings" role="tooltip">
                        Logout page
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
            </aside>



            <!-- NAVBAR -->






            <main class="h-auto  p-4 pt-20 md:ml-64">
                @yield('content')
            </main>

        </div>





        <!-- Include SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="{{ asset('js/Calendar.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.js"></script>
        <script src="{{ asset('js/graph.js') }}"></script>
        <script src="{{ asset('js/admin.js') }}"></script>
        <script src="{{ asset('js/modal.js') }}"></script>
        <script src="{{ asset('js/search.js') }}"></script>
        <script src="{{ asset('js/delete.js') }}"></script>
        <script src="{{ asset('js/flowbite/dist/flowbite.min.js') }}"></script>
        <script src="{{ asset('frameworks/diasyui/dist/base.js') }}"></script>
        <!-- DataTables CDN and Initialization -->
        <!-- DataTables CDN and Initialization -->
        <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


        <script>
            function confirmLogout() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will be logged out of your account",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444', // Red-500 color
                    cancelButtonColor: '#6B7280', // Gray-500 color
                    confirmButtonText: 'Yes, logout',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    customClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Logging out...',
                            text: 'Please wait',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit the logout form
                        document.getElementById('logout-form').submit();
                    }
                });
            }
        </script>

        <script>
            document.addEventListener('livewire:navigated', () => {

                console.log('livewire:navigated');
                initFlowbite();

            })
        </script>
        @livewireScripts

    </body>

</html>
