<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'E.M.P') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/emp-logo.png') }}" >
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('css/boxicon/boxicons.min.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
   
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
</head>
<body>
 
    <nav class="fixed top-0 left-0 right-0 z-50 ">
        <div class="max-w-screen-xl mx-auto">
            <div class="flex flex-wrap items-center justify-between">
                <a class="flex items-center space-x-3 rtl:space-x-reverse" href="{{ url('/') }}" wire:navigate>
                    <span class="flex items-center py-2 pl-5 font-sans text-xl font-bold text-white lg:text-black ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </a>
               
            </div>
        </div>
    </nav>

    <main class="py-0 ">
        @yield('content')
    </main>
    </div>

  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
    <script>
        // Define the asset paths in a way that works with Laravel's asset helper
        const animationPaths = {
            'login': '{{ asset('json/animate/login.json') }}',
            'ai_hi': '{{ asset('json/animate/ai_hi.json') }}',
            'register': '{{ asset('json/animate/register.json') }}',
            'reset': '{{ asset('json/animate/forget_pass.json') }}'
        };
    
        // Main initialization function
        function initializeAnimations() {
            // Lottie Animations
            function initLottieAnimations() {
                Object.entries(animationPaths).forEach(([id, path]) => {
                    const element = document.getElementById(id);
                    if (element) {
                        bodymovin.loadAnimation({
                            container: element,
                            path: path
                        });
                    }
                });
            }
    
            // Scroll Animations
            function initScrollAnimations() {
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
            }
    
            // Menu Toggle
            function initMenuToggle() {
                const toggleButton = document.getElementById('toggleMenuButton');
                const navbar = document.getElementById('navbar-hamburger');
                
                if (toggleButton && navbar) {
                    toggleButton.addEventListener('click', () => {
                        navbar.classList.toggle('hidden');
                    });
                }
            }
    
            // Initialize all components
            initLottieAnimations();
            initScrollAnimations();
            initMenuToggle();
        }
    
        // Listen for both DOMContentLoaded and Livewire navigation
        document.addEventListener('DOMContentLoaded', initializeAnimations);
    
        // Only add Livewire listener if Livewire is present
        if (typeof window.Livewire !== 'undefined') {
            document.addEventListener('livewire:navigated', initializeAnimations);
        }
    </script>
    <script src="{{ asset('js/lottie.min.js') }}"></script>
</body>
</html>