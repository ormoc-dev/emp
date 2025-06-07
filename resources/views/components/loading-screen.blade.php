<!-- Loading Screen Component -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-gradient-to-br from-gray-900 to-gray-800"
    id="loading-screen">
    <div class="text-center relative">
        <!-- Logo Container -->
        <div class="relative">
            <img class="w-40 h-40 mx-auto" src="{{ asset('img/emp-logo.png') }}" alt="Logo">
        </div>

        <!-- Loading Text -->
        <h2 class="mt-6 text-2xl font-bold text-white animate-fade-in">Event Master Pro</h2>
        <p class="mt-2 text-gray-400 text-sm animate-fade-in-delay">Your Complete Event Management Solution</p>

        <!-- Loading Bar -->
        <div class="mt-8 w-48 h-1 bg-gray-700 rounded-full overflow-hidden mx-auto">
            <div class="h-full bg-gradient-to-r from-red-500 to-red-600 rounded-full animate-loading-bar"></div>
        </div>
    </div>
</div>

<style>
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

    .animate-loading-bar {
        animation: loading-bar 4s ease-in-out forwards;
    }

    .animate-fade-in {
        animation: fade-in 0.8s ease-out forwards;
    }

    .animate-fade-in-delay {
        animation: fade-in 0.8s ease-out 0.3s forwards;
        opacity: 0;
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
    window.addEventListener('load', function() {
        const loadingScreen = document.getElementById('loading-screen');

        // Ensure the loading screen exists
        if (loadingScreen) {
            // Hide the loading screen after 4 seconds
            setTimeout(function() {
                loadingScreen.classList.add('fade-out');

                // Remove the loading screen from DOM after fade out
                setTimeout(function() {
                    if (loadingScreen && loadingScreen.parentNode) {
                        loadingScreen.parentNode.removeChild(loadingScreen);
                    }
                }, 800);
            }, 4000);
        }
    });
</script>
