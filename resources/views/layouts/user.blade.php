<!doctype html>
<html lang="en">

    <head>
        <!-- Meta tags for character set, viewport, and compatibility -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'E.M.P') }}</title>
        <link type="image/png" href="{{ asset('img/emp-logo.png') }}" rel="icon">
        <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.css" rel="stylesheet">
        <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
        <link href="{{ asset('css/users.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- ⁡⁢⁣⁢Include jQuery⁡ -->
        <link href="{{ asset('css/jquery_length.css') }}" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <!-- ⁡⁢⁣⁢Include Select2 CSS⁡ -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- ⁡⁢⁣⁢Include Select2 JS ⁡-->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        @vite(['resources/css/app.css'])
        <style>
            @keyframes fadeIn {
                0% {
                    opacity: 0;
                    transform: translateY(20px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fadeIn {
                opacity: 0;
                /* Initial state */
            }

            .animate-fadeIn.visible {
                animation: fadeIn 1s ease-out forwards;
            }

            @keyframes slideIn {
                0% {
                    opacity: 0;
                    transform: translateX(-20px);
                }

                100% {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .animate-slideIn {
                opacity: 0;
                /* Initial state */
            }

            .animate-slideIn.visible {
                animation: slideIn 1s ease-out forwards;
            }

            @keyframes grow {
                0% {
                    opacity: 0;
                    transform: scale(0.9);
                }

                100% {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .animate-grow {
                opacity: 0;
                /* Initial state */
            }

            .animate-grow.visible {
                animation: grow 1s ease-out forwards;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    </head>

    <body class=" font-indie bg-white">







        <div class="fixed z-50 w-full max-w-2xl mx-auto transform -translate-x-1/2 bottom-4 left-1/2">
            <div
                class="flex justify-between bg-white border border-gray-200 rounded-full shadow-lg dark:bg-gray-700 dark:border-gray-600">
                <a class="flex flex-col items-center justify-center w-1/5 p-4 rounded-l-full hover:bg-gray-50 dark:hover:bg-gray-800 group"
                    href="{{ route('users_home') }}">
                    <svg class="w-6 h-6 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-500"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    <span class="sr-only">Home</span>
                </a>

                <a class="flex flex-col items-center justify-center w-1/5 p-4 hover:bg-gray-50 dark:hover:bg-gray-800 group"
                    href="{{ route('pricing_vote') }}">
                    <svg class="w-6 h-6 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-500"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M11.074 4 8.442.408A.95.95 0 0 0 7.014.254L2.926 4h8.148ZM9 13v-1a4 4 0 0 1 4-4h6V6a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h17a1 1 0 0 0 1-1v-2h-6a4 4 0 0 1-4-4Z" />
                        <path
                            d="M19 10h-6a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1Zm-4.5 3.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM12.62 4h2.78L12.539.41a1.086 1.086 0 1 0-1.7 1.352L12.62 4Z" />
                    </svg>
                    <span class="sr-only">Pricing</span>
                </a>

                <div class="flex items-center justify-center">
                    <a class="inline-flex items-center justify-center w-10 h-10 font-medium bg-red-600 rounded-full hover:bg-red-700 group focus:ring-4 focus:ring-blue-300 focus:outline-none dark:focus:ring-blue-800"
                        data-tooltip-target="tooltip-new" type="button" href="{{ route('profile') }}">

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

                    </a>
                </div>




                <a class="flex flex-col items-center justify-center w-1/5 p-4 hover:bg-gray-50 dark:hover:bg-gray-800 group"
                    href="{{ route('user.history') }}">
                    <svg class="w-6 h-6 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-500"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V5a1 1 0 0 1 2 0v4.586l3.036 3.036a1 1 0 0 1-.054 1.36Z" />
                    </svg>
                    <span class="sr-only">History</span>
                </a>

                <button
                    class="flex flex-col items-center justify-center w-1/5 p-4 rounded-r-full hover:bg-gray-50 dark:hover:bg-gray-800 group"
                    onclick="confirmLogout();">
                    <svg class="w-6 h-6 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-500"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3" />
                    </svg>
                    <form class="hidden" id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                    <span class="sr-only">Logout</span>
                </button>
            </div>
        </div>

        <main class="py-12">
            @yield('content')
        </main>










        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const elements = document.querySelectorAll('.animate-fadeIn, .animate-slideIn, .animate-grow');

                function checkVisibility() {
                    const windowHeight = window.innerHeight;
                    elements.forEach(el => {
                        const rect = el.getBoundingClientRect();
                        if (rect.top <= windowHeight && rect.bottom >= 0) {
                            el.classList.add('visible');
                        }
                    });
                }

                window.addEventListener('scroll', checkVisibility);
                checkVisibility(); // Trigger initial check
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/judge.js') }}"></script>
        <script src="{{ asset('js/modal.js') }}"></script>
        <script src="{{ asset('js/flowbite/dist/flowbite.min.js') }}"></script>
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
            $(document).ready(function() {
                function filterCards() {
                    var value = $(this).val().toLowerCase();
                    $(".event-card").filter(function() {
                        var title = $(this).find("h1").text().toLowerCase();
                        var subtitle = $(this).find(".event-subtitle").text().toLowerCase();
                        $(this).toggle(title.indexOf(value) > -1 || subtitle.indexOf(value) > -1);
                    });
                }


                $("#search-navbar").on("keyup", filterCards);
            });
        </script>


    </body>

</html>
