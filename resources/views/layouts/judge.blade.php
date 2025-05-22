<!doctype html>
<html lang="en">

    <head>
        <!-- Meta tags for character set, viewport, and compatibility -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name', 'E.M.P') }}</title>
        <link type="image/png" href="{{ asset('img/emp-logo.png') }}" rel="icon">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <link href="{{ asset('css/boxicon/boxicons.min.css') }}" rel="stylesheet">
        <!-- Flowbite CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css" rel="stylesheet">
        <link href="{{ asset('css/swiper.css') }}" rel="stylesheet">
        <!-- Tailwind CSS via CDN ⁡⁢⁣⁢FOR ONLINE PURPOSE⁡-->
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        @vite(['resources/css/app.css'])
        <style>
            .table {
                border-spacing: 0 20px;
            }

            i {
                font-size: 1rem !important;
            }



            tr td:nth-child(n+5),
            tr th:nth-child(n+5) {
                border-radius: 0 .625rem .625rem 0;
                padding: 20px;
            }

            tr td:nth-child(1),
            tr th:nth-child(1) {
                border-radius: .625rem 0 0 .625rem;

            }

            .glass {
                background: linear-gradient(135deg, rgba(30, 29, 29, 0.714), rgba(33, 32, 32, 0.615));
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border-radius: 20px;
                border: 1px solid rgba(255, 255, 255, 0.18);
                box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);

            }



            .bg-gradient-to-r {
                background: linear-gradient(to right, rgb(243, 34, 34), rgb(22, 1, 1));
            }

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

    </head>


    <body class="flex flex-col min-h-screen judgebody">

        <nav class="fixed top-0 left-0 z-50 w-full bg-white border-b-4 border-red-600">
            <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto ">
                <a class="flex items-center space-x-3 rtl:space-x-reverse" href="{{ url('/judge/home')}}">
                    @php
                        $user = auth()->user();
                    @endphp
                    @if ($user)
                        @if ($user->profile)
                            <div class="relative me-4">
                                <img class="w-8 h-8 mr-3 rounded-full" src="{{ asset($user->profile) }}"
                                    alt="User Profile Image">
                                <span
                                    class="top-0 start-7 absolute w-3.5 h-3.5 {{ $user->is_online ? 'bg-green-500' : 'bg-red-500' }} border-2 border-white dark:border-gray-800 rounded-full"></span>
                            </div>
                        @else
                            <!-- Randomly select a default avatar from multiple options -->
                            @php
                                $defaultAvatars = [
                                    'avatar/bear.png',
                                    'avatar/cat.png',
                                    'avatar/dog.png',
                                    'avatar/giraffe.png',
                                    'avatar/gorilla.png',
                                    'avatar/meerkat.png',
                                    'avatar/panda.png',
                                ];
                                $randomAvatar = $defaultAvatars[array_rand($defaultAvatars)];
                            @endphp
                            <img class="w-8 h-8 rounded-full" src="{{ asset($randomAvatar) }}"
                                alt="Random Default Profile Image" />
                        @endif
                    @endif
                     <span
                    class="self-center text-2xl font-semibold text-red-800 whitespace-nowrap">{{ Auth::user()->name }} 👨‍⚖️</span>
                </a>

                <!-- Button for toggling the menu -->
                <button
                    class="inline-flex items-center justify-center w-10 h-10 p-2 text-sm text-red-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200"
                    id="toggleMenuButton" data-collapse-toggle="navbar-hamburger" type="button"
                    aria-controls="navbar-hamburger" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>

                <!-- Menu content -->
                <div class="hidden w-full" id="navbar-hamburger">
                    <ul
                        class="flex flex-col mt-4 font-medium rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                        <li>
                            <a class="block px-3 py-2 text-gray-900 bg-gray-400 rounded logout" href="#"
                                onclick="confirmLogout();">
                                <span class="text">Logout</span>
                                <i class='text-red-500 bx bx-log-out-circle'></i>
                            </a>
                            <form class="d-none" id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </li>
                        <li>
                            <a class="block px-3 py-2 text-gray-900 rounded logout hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                href="{{ route('select.event_in_judges') }}">
                                <span class="text">Home</span>
                                <i class='text-blue-500 bx bx-home-alt'></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Add this script at the bottom of your page or in your custom JS file -->
                <script>
                    document.getElementById('toggleMenuButton').addEventListener('click', function() {
                        const navbarHamburger = document.getElementById('navbar-hamburger');
                        navbarHamburger.classList.toggle('hidden');
                    });
                </script>


            </div>
        </nav>




        
    <main class="flex-grow bg">
            @yield('content')

        </main>



        <footer class="text-gray-600 body-font">
            <div class="bg-gray-100 animate-slideIn">
                <div class="container flex flex-col flex-wrap px-5 py-4 mx-auto sm:flex-row">
                    <p class="text-sm text-center text-gray-500 sm:text-left">© 2024 Event Master-pro —
                        <a class="ml-1 text-blue-600" href="https://web.facebook.com/WLCCICTE"
                            rel="noopener noreferrer" target="_blank">@WLC-CICTEORMOC.COM</a>
                    </p>
                    <span
                        class="w-full mt-2 text-sm text-center text-gray-500 sm:ml-auto sm:mt-0 sm:w-auto sm:text-left">Hosted
                        by WLC-CICTE</span>
                </div>
            </div>
        </footer>



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
        <script src="{{ asset('js/swiper.js') }}"></script>
        <script>
            function confirmLogout() {
                if (confirm('Are you sure you want to logout?')) {
                    document.getElementById('logout-form').submit();
                }
            }
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Login animation
                if (document.getElementById('judge_panel')) {
                    bodymovin.loadAnimation({
                        container: document.getElementById('judge_panel'),

                        path: '{{ asset('json/animate/judge_panel.json') }}'
                    });
                }

                // Register animation
                if (document.getElementById('judge_search')) {
                    bodymovin.loadAnimation({
                        container: document.getElementById('judge_search'),

                        path: '{{ asset('json/animate/judge_search.json') }}'
                    });
                }

            });
        </script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const judgeButtons = document.querySelectorAll('.judge-now-btn');

        judgeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const buttonText = this.querySelector('.button-text');
                const buttonIcon = this.querySelector('.button-icon');
                const buttonWaitText = this.querySelector('.button-wait-text');
                const buttonSpinner = this.querySelector('.button-spinner');

                // Hide original text and icon, show "Please wait..." and spinner
                buttonText.classList.add('hidden');
                buttonIcon.classList.add('hidden');
                buttonWaitText.classList.remove('hidden');
                buttonSpinner.classList.remove('hidden');

                // Adjust button width to fit new content
                this.style.width = 'auto';
                this.style.minWidth = this.offsetWidth + 'px';

                // Disable the button and change its appearance
                this.classList.add('opacity-70', 'cursor-not-allowed');
                this.setAttribute('disabled', 'disabled');

                // Redirect after a short delay (for demo purposes)
                setTimeout(() => {
                    window.location.href = this.href;
                },); // Adjust this delay as needed
            });
        });
    });
</script>

<script>
    // Custom JavaScript for handling the multi-image carousel
    const prevButtons = document.querySelectorAll('[data-carousel-prev]');
    const nextButtons = document.querySelectorAll('[data-carousel-next]');

    prevButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            const carousel = button.closest('[data-carousel="slide"]').querySelector('div');
            carousel.style.transform = 'translateX(0)';
        });
    });

    nextButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            const carousel = button.closest('[data-carousel="slide"]').querySelector('div');
            carousel.style.transform = 'translateX(-50%)';
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const text =
            "Discover and judge the best talent in the industry. Dive into the events and give your expert opinions to help determine the winners. 🏆 ";
        const typingTextElement = document.getElementById('typing-text');
        let index = 0;

        function typeWriter() {
            if (index < text.length) {
                typingTextElement.innerHTML += text.charAt(index);
                index++;
                setTimeout(typeWriter, 20);
            }
        }

        typeWriter();
    });
</script>
<script src="{{ asset('js/lottie.min.js') }}"></script>
    </body>
</html>
