@props([
    'logo' => 'img/emp-logo1.png',
    'subtitle1' => 'Your Complete Event Management Solution',
    'subtitle2' => 'Vote your favorite contestants',
    'subtitle3' => 'Track real-time results',
    'subtitle4' => 'Experience seamless voting',
    'subtitle5' => 'Join the excitement',
    'duration' => 4000,
    'fadeOutDuration' => 800,
])

<!-- Loading Screen -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900"
    id="loading-screen">
    <div class="text-center relative">
        <!-- Logo Container with Glow Effect -->
        <div class="relative">
            <img class="w-[400px] h-[auto] mx-auto relative z-10" src="{{ asset($logo) }}" alt="Logo">
        </div>

        <!-- Enhanced Subtitle with Slider -->
        <div class="mt-6 h-20 overflow-hidden">
            <div class="subtitle-slider">
                <p class="text-gray-300 text-lg tracking-wide font-small">{{ $subtitle1 }}</p>
                <p class="text-gray-300 text-lg tracking-wide font-small">{{ $subtitle2 }}</p>
                <p class="text-gray-300 text-lg tracking-wide font-small">{{ $subtitle3 }}</p>
                <p class="text-gray-300 text-lg tracking-wide font-small">{{ $subtitle4 }}</p>
                <p class="text-gray-300 text-lg tracking-wide font-small">{{ $subtitle5 }}</p>
            </div>
        </div>

        <!-- Enhanced Loading Bar -->
        <div class=" w-80 h-2.5 bg-gray-800/50 overflow-hidden mx-auto relative rounded-full backdrop-blur-sm">
            <div class="absolute inset-0 bg-gray-500 animate-pulse"></div>
            <div class="h-full bg-gradient-to-reload rounded-full animate-loading-bar relative">
                <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent"></div>
            </div>
            <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
                <span class="text-white text-xs font-medium transform -translate-y-0.5 tracking-wider"
                    id="loading-percentage">0%</span>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-to-reload{
        background-image: linear-gradient(120deg,rgb(191, 7, 105),rgb(225, 22, 130), rgb(215, 12, 171))
    }
    /* Loading Screen Animations */
    @keyframes loading-bar {
        0% {
            width: 0%;
        }

        100% {
            width: 100%;
        }
    }

    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slide-up {
        0% {
            transform: translateY(100%);
            opacity: 0;
            visibility: hidden;
        }

        5% {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        20% {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        25% {
            transform: translateY(-100%);
            opacity: 0;
            visibility: hidden;
        }

        100% {
            transform: translateY(-100%);
            opacity: 0;
            visibility: hidden;
        }
    }

    .animate-loading-bar {
        animation: loading-bar 4s linear forwards;
    }

    .animate-fade-in {
        animation: fade-in 0.8s ease-out forwards;
    }

    .animate-fade-in-delay {
        animation: fade-in 0.8s ease-out 0.3s forwards;
        opacity: 0;
    }

    .subtitle-slider {
        position: relative;
        height: 100%;
    }

    .subtitle-slider p {
        position: absolute;
        width: 100%;
        left: 0;
        top: 0;
        animation: slide-up 10s infinite;
        opacity: 0;
        visibility: hidden;
    }

    .subtitle-slider p:nth-child(2) {
        animation-delay: 2s;
    }

    .subtitle-slider p:nth-child(3) {
        animation-delay: 4s;
    }

    .subtitle-slider p:nth-child(4) {
        animation-delay: 6s;
    }

    .subtitle-slider p:nth-child(5) {
        animation-delay: 8s;
    }

    #loading-screen {
        transition: opacity 0.8s ease-out, visibility 0.8s ease-out;
    }

    #loading-screen.fade-out {
        opacity: 0;
        visibility: hidden;
    }
</style>

<script>
    // Check if this is the first visit to welcome page
    if (!sessionStorage.getItem('hasSeenWelcome')) {
        // Show loading screen
        const loadingScreen = document.getElementById('loading-screen');
        const percentageElement = document.getElementById('loading-percentage');
        const duration = 4000; // Match the animation duration
        const interval = 40; // Update more frequently for smoother animation
        const steps = duration / interval;
        let currentStep = 0;
        let isLoadingComplete = false;

        // Function to check if page is fully loaded
        const checkPageLoad = () => {
            if (document.readyState === 'complete') {
                isLoadingComplete = true;
            }
        };

        // Listen for page load events
        window.addEventListener('load', checkPageLoad);
        document.addEventListener('DOMContentLoaded', checkPageLoad);

        // Update percentage
        const updatePercentage = () => {
            currentStep++;
            const percentage = Math.min(Math.round((currentStep / steps) * 100), 100);
            percentageElement.textContent = `${percentage}%`;

            // Only proceed if both percentage is 100% and page is loaded
            if (percentage === 100 && isLoadingComplete) {
                clearInterval(percentageInterval);
                loadingScreen.classList.add('fade-out');

                // Remove after fade out
                setTimeout(function() {
                    loadingScreen.remove();
                }, {{ $fadeOutDuration }});

                // Mark as seen
                sessionStorage.setItem('hasSeenWelcome', 'true');
            }
        };

        // Start percentage updates
        const percentageInterval = setInterval(updatePercentage, interval);

        // Fallback timer in case loading takes too long
        setTimeout(function() {
            if (!isLoadingComplete) {
                isLoadingComplete = true;
            }
        }, duration + 2000); // Add 2 seconds buffer to the original duration

    } else {
        // If already seen, remove immediately
        const loadingScreen = document.getElementById('loading-screen');
        if (loadingScreen) {
            loadingScreen.remove();
        }
    }
</script>
