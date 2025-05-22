<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'E.M.P') }}</title>
        <link type="image/png" href="{{ asset('img/emp-logo.png') }}" rel="icon">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <link href="{{ asset('css/boxicon/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <script src="{{ asset('js/flowbite/dist/flowbite.js') }}" rel="stylesheet"></script>
        <!-- Tailwind CSS via CDN -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <!-- Add Font Awesome CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
        @livewireStyles
        @vite(['resources/css/app.css'])
        <style>
            nav {
                transition: opacity 0.5s ease-in-out;
            }

            .hide-navbar {
                opacity: 0;
                pointer-events: none;
            }

            @keyframes move {
                0% {
                    transform: translateX(0);
                }

                50% {
                    transform: translateX(50px);
                }

                100% {
                    transform: translateX(0);
                }
            }

            .move {
                animation: move 5s ease-in-out infinite;
            }


            .bg-gradient-to-r {

                background: linear-gradient(rgba(196, 20, 20, 0.542) 0%,
                        rgba(105, 1, 1, 0.256) 100%);

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

    <body class="wlecomebody">



        <nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-blue-500 to-blue-700">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto ">
                <!-- Logo -->
                <a class="flex items-center space-x-3 rtl:space-x-reverse" href="{{ url('/') }}">
                    <span class="flex items-center py-2 pl-5 font-sans text-xl font-bold text-white">
                        <img class="w-8 h-8 mr-2 rounded-full" src="{{ asset('img/emp-logo.png') }}" alt="Logo">
                        <span class="uppercase">{{ config('app.name', 'E.M.P') }}</span>
                    </span>
                </a>

                <!-- Navigation and Register Button Container -->
                <div class="flex items-center space-x-8">
                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <ul class="flex space-x-8">
                            <li class=" text-white rounded-lg whitespace-nowrap">
                                <a class="flex items-center gap-2" href="{{ route('welcome') }}" wire:navigate>
                                    <i class="fa-solid fa-house-laptop"></i>
                                    <span
                                        class="hover:underline underline-offset-4 decoration-2 decoration-white">Home</span>
                                </a>
                            </li>



                            <li class=" text-white rounded-lg whitespace-nowrap">
                                <a class="flex items-center gap-2" href="{{ route('events') }}" wire:navigate>
                                    <i class="fa-regular fa-calendar-check"></i>
                                    <span
                                        class="hover:underline underline-offset-4 decoration-2 decoration-white">Events</span>
                                </a>
                            </li>
                            <li class=" text-white rounded-lg whitespace-nowrap">
                                <a class="flex items-center gap-2" href="{{ route('contact_us.admin') }}"
                                    wire:navigate>
                                    <i class="fa-solid fa-user-graduate"></i>
                                    <span class="hover:underline underline-offset-4 decoration-2 decoration-white">About
                                        Us</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Register Button -->
                    <a class="relative inline-flex items-center justify-center px-4 py-2 text-sm text-white transition duration-300 ease-out bg-gradient-to-r from-blue-500 to-blue-700 rounded-full group hover:from-blue-600 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 focus:outline-none"
                        href="{{ route('register') }}" wire:navigate>
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="8.5" cy="7" r="4" />
                                <line x1="20" y1="8" x2="20" y2="14" />
                                <line x1="23" y1="11" x2="17" y2="11" />
                            </svg>
                            Register
                        </span>
                    </a>

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden inline-flex items-center p-2 text-sm text-gray-50 rounded-lg"
                        data-collapse-toggle="navbar-sticky" type="button" aria-controls="navbar-sticky"
                        aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1h15M1 7h15M1 13h15" />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div class="md:hidden hidden w-full justify-center " id="navbar-sticky">
                    <ul class="flex space-x-8">
                        <li class="px-3 py-2 text-white rounded-lg whitespace-nowrap">
                            <a class="flex items-center gap-2" href="{{ route('welcome') }}" wire:navigate>
                                <i class="fa-solid fa-house-laptop"></i>
                                <span
                                    class="hover:underline underline-offset-4 decoration-2 decoration-white">Home</span>
                            </a>
                        </li>



                        <li class="px-3 py-2 text-white rounded-lg whitespace-nowrap">
                            <a class="flex items-center gap-2" href="{{ route('events') }}" wire:navigate>
                                <i class="fa-regular fa-calendar-check"></i>
                                <span
                                    class="hover:underline underline-offset-4 decoration-2 decoration-white">Events</span>
                            </a>
                        </li>
                        <li class="px-3 py-2 text-white rounded-lg whitespace-nowrap">
                            <a class="flex items-center gap-2" href="{{ route('contact_us.admin') }}" wire:navigate>
                                <i class="fa-solid fa-user-graduate"></i>
                                <span class="hover:underline underline-offset-4 decoration-2 decoration-white">About
                                    Us</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <main class="">
            @yield('content')
        </main>

        <footer class="text-gray-600 body-font">
            <div class="bg-gray-100">
                <div class="container flex flex-col flex-wrap px-5 py-4 mx-auto sm:flex-row">
                    <p class="text-sm text-center text-gray-500 sm:text-left animate-slideIn">© 2024 Event Master-pro —
                        <a class="ml-1 text-blue-600 " href="https://web.facebook.com/WLCCICTE"
                            rel="noopener noreferrer" target="_blank">@WLC-CICTEORMOC.COM</a>
                    </p>


                    <span class="inline-flex justify-center mt-2 sm:ml-auto sm:mt-0 sm:justify-start">
                        <a class="text-gray-500">
                            <svg class="w-5 h-5" fill="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                            </svg>
                        </a>
                        <a class="ml-3 text-gray-500">
                            <svg class="w-5 h-5" fill="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                                </path>
                            </svg>
                        </a>
                        <a class="ml-3 text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5">
                                </rect>
                                <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                            </svg>
                        </a>
                        <a class="ml-3 text-gray-500">
                            <svg class="w-5 h-5" fill="currentColor" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="0" viewBox="0 0 24 24">
                                <path stroke="none"
                                    d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z">
                                </path>
                                <circle cx="4" cy="4" r="2" stroke="none"></circle>
                            </svg>
                        </a>
                    </span>
                </div>
            </div>
        </footer>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
        <script>
            bodymovin.loadAnimation({
                container: document.getElementById('RATINGS'),
                path: '{{ asset('json/animate/welc.json') }}'
            })
        </script>
        <!-- ... welcom js ... -->
        <script src="https://cdn.lordicon.com/lordicon.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('js/flowbite/dist/flowbite.min.js') }}"></script>
        <script src="https://use.fontawesome.com/03f8a0ebd4.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!--FEEDBACK JS JQUERY -->
        <script>
            $(document).ready(function() {
                $('#feedbackForm').on('submit', function(e) {
                    e.preventDefault();

                    // Show spinner and change button text
                    $('#spin').removeClass('hidden');
                    $('#buttonText').text('Submitting...');
                    $('#submitButton').prop('disabled', true);

                    $.ajax({
                        url: "{{ route('feedback.store') }}",
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            // Hide spinner and restore button text
                            $('#spin').addClass('hidden');
                            $('#buttonText').text('Submit Feedback');
                            $('#submitButton').prop('disabled', false);

                            // Show success message
                            $('#feedbackMessage').removeClass('hidden text-red-500').addClass(
                                'text-green-500').html(
                                '<i class="mr-2 fas fa-check-circle"></i>Feedback submitted successfully'
                            );

                            // Reset the form
                            $('#feedbackForm')[0].reset();

                            // Set a timeout to hide the message after 5 seconds
                            setTimeout(function() {
                                $('#feedbackMessage').addClass('hidden');
                            }, 5000);
                        },
                        error: function(xhr) {
                            // Hide spinner and restore button text
                            $('#spin').addClass('hidden');
                            $('#buttonText').text('Submit Feedback');
                            $('#submitButton').prop('disabled', false);

                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '<i class="mr-2 fas fa-exclamation-circle"></i>';
                            for (let field in errors) {
                                errorMessage += errors[field][0] + '<br>';
                            }
                            $('#feedbackMessage').removeClass('hidden text-green-500').addClass(
                                'text-red-500').html(errorMessage);
                        }
                    });
                });
            });
        </script>

        <!-- ... nav desaper ... -->
        <script>
            document.addEventListener('livewire:navigated', () => {
                const navbar = document.querySelector('nav');
                const ratingsSection = document.querySelector('#ratings');

                function handleScroll() {
                    const ratingsPosition = ratingsSection.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 2;

                    if (ratingsPosition < screenPosition) {
                        navbar.classList.add('hide-navbar');
                    } else {
                        navbar.classList.remove('hide-navbar');
                    }
                }

                window.addEventListener('scroll', handleScroll);
            });
        </script>
        <!--FEEDBACK JS -->
        <script>
            document.addEventListener('livewire:navigated', () => {
                const rateUsCard = document.getElementById('rateUsCard');
                const videoHighlights = document.getElementById('videoHighlights');
                const rateUsButton = document.getElementById('rateUsButton');
                const feedbackSection = document.getElementById('feedbackSection');
                const closeRateUsCard = document.getElementById('closeRateUsCard');

                function checkScroll() {
                    const videoHighlightsPosition = videoHighlights.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 2;

                    if (videoHighlightsPosition < screenPosition) {
                        rateUsCard.style.opacity = '0';
                        rateUsCard.style.pointerEvents = 'none';
                    } else {
                        rateUsCard.style.opacity = '1';
                        rateUsCard.style.pointerEvents = 'auto';
                    }
                }

                window.addEventListener('scroll', checkScroll);
                checkScroll(); // Check on initial load

                // Smooth scroll to feedback section when Rate Us button is clicked
                rateUsButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    feedbackSection.scrollIntoView({
                        behavior: 'smooth'
                    });
                });

                // Close the Rate Us card when the close button is clicked
                closeRateUsCard.addEventListener('click', function() {
                    rateUsCard.style.display = 'none';
                });
            });
        </script>
        <!--ANIMATION JS-->
        <script>
            function initializeAnimations() {
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
                checkVisibility();


                if (typeof initFlowbite === 'function') {
                    initFlowbite();
                }
            }

            document.addEventListener('DOMContentLoaded', initializeAnimations);


            if (typeof window.Livewire !== 'undefined') {
                document.addEventListener('livewire:navigated', initializeAnimations);
            }
        </script>
        <!--RATE US CARD JS-->
        <script>
            function initializeRateUsCard() {
                let currentSlide = 0;
                const countdownTimer = document.getElementById('countdownTimer');
                const rateUsCard = document.getElementById('rateUsCard');

                // Only proceed if elements exist
                if (!countdownTimer || !rateUsCard) return;

                function changeSlide(direction) {
                    const slides = document.querySelectorAll('#carouselImages img');
                    if (!slides.length) return; // Guard clause if no slides exist

                    slides[currentSlide].classList.add('hidden'); // Hide current slide
                    currentSlide = (currentSlide + direction + slides.length) % slides.length; // Update current slide index
                    slides[currentSlide].classList.remove('hidden'); // Show new slide
                }

                // Auto slide every 3 seconds
                const slideInterval = setInterval(() => {
                    changeSlide(1);
                }, 3000);

                // Countdown logic
                let timer = 10;
                const countdownInterval = setInterval(() => {
                    timer--;
                    countdownTimer.textContent = timer;

                    // Hide the card after 10 seconds on small screens
                    if (timer === 0) {
                        clearInterval(countdownInterval);
                        if (window.innerWidth <= 640) { // Tailwind sm: breakpoint
                            rateUsCard.classList.add('opacity-0');
                            setTimeout(() => {
                                rateUsCard.style.display = 'none';
                            }, 300);
                        }
                    }
                }, 1000);

                // Close Rate Us Card
                const closeButton = document.getElementById('closeRateUsCard');
                if (closeButton) {
                    closeButton.addEventListener('click', () => {
                        clearInterval(countdownInterval); // Stop countdown
                        clearInterval(slideInterval); // Stop slide show
                        rateUsCard.classList.add('opacity-0');
                        setTimeout(() => {
                            rateUsCard.style.display = 'none';
                        }, 300);
                    });
                }
            }

            // Listen for both DOMContentLoaded and Livewire navigation
            document.addEventListener('DOMContentLoaded', initializeRateUsCard);

            // Only add Livewire listener if Livewire is present
            if (typeof window.Livewire !== 'undefined') {
                document.addEventListener('livewire:navigated', initializeRateUsCard);
            }
        </script>



        @livewireScripts
    </body>

</html>
