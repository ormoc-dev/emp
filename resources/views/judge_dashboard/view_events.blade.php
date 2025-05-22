@extends('layouts.judge')
@section('content')
<style>
    @media (min-width: 1024px) {
        .bg-j {
            background-size: 100% 170px;
        }
    }

    @media (max-width: 1023px) {
        .bg-j {
            background-size: cover;
        }
    }

    .slideshow-bg {
        animation: slideshow 15s linear infinite;
    }

    @keyframes slideshow {
        0%, 100% { background-image: url('{{ asset('img/JD-BG.jpg') }}'); }
        33.33% { background-image: url('{{ asset('img/JD-BG-DANCE.jpg') }}'); }
        66.66% { background-image: url('{{ asset('img/JD-BG-SING.jpg') }}'); }
    }
</style>
    <section class="text-gray-600 body-font">
        <nav
            class="container flex flex-wrap items-center px-4 py-8 mx-auto bg-white border-b-2 border-red-500 rounded-lg shadow-md">
            <div class="flex flex-col items-center w-full p-6 mt-8 bg-center bg-no-repeat bg-cover rounded-lg shadow-md md:flex-row md:justify-between from-blue-50 to-indigo-50 bg-j slideshow-bg">
                <div class="mb-6 text-center md:text-left md:mb-0 animate-fadeIn">
                    <h1 class="text-2xl font-bold text-gray-100 md:text-3xl lg:text-4xl animate-fadeIn">
                        Welcome, Esteemed Judge <span class="text-indigo-600">🎭</span>
                    </h1>
                    <p class="max-w-xl mt-3 text-base text-gray-200 md:text-lg animate-fadeIn">
                        Your expertise is invaluable. Select an event to begin your judging journey and shape the future of
                        talent.
                    </p>
                </div>
                <div class="w-full mt-4 md:w-1/2 md:mt-0">
                    <div class="h-24 p-4 overflow-hidden bg-gray-100 rounded-lg shadow-inner bg-opacity-20 md:h-32"
                        id="typing-text-container">
                        <p class="text-sm leading-relaxed text-gray-100 md:text-base lg:text-lg" id="typing-text">
                            <!-- Typing text will appear here -->
                        </p>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container px-4 py-8 mx-auto mb-12">
            @if ($events->isEmpty())
                <!-- ... existing code ... -->
                <div class="flex flex-col items-center justify-center text-sm text-red-700 rounded-lg">
                    <div class="relative" style="width: 300px; height: 300px;">
                        <div class="w-full h-full" id="judge_search"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-2 text-center ">
                            No events available to judge at the moment.
                        </div>
                    </div>
                </div>
                <!-- ... existing code  ... -->
            @else
                <div class="flex justify-center">
                    <div class="grid grid-cols-1 gap-4 mt-8 sm:grid-cols-2 lg:grid-cols-3 ">
                        @foreach ($events as $event)
                            <div
                                class="overflow-hidden transition-all duration-300 bg-gray-100 rounded-lg shadow-md hover:shadow-lg">
                                <div class="flex h-full">
                                    <div class="w-1/3 relative h-[250px] overflow-hidden">
                                        <div class="h-full swiper-container" id="swiper-{{ $event->id }}">
                                            <div class="swiper-wrapper">
                                                @if ($event->contestants->isEmpty())
                                                    <div class="swiper-slide" id="judge_search">
                                                        
                                                    </div>
                                                @else
                                                    @foreach ($event->contestants as $contestant)
                                                        <div class="swiper-slide">
                                                            @if (isset($contestant['profile']) && $contestant['profile'])
                                                                <img class="object-cover w-full h-full"
                                                                    src="{{ asset($contestant['profile']) }}"
                                                                    alt="{{ $contestant['name'] ?? 'Contestant' }} Image">
                                                            @else
                                                                <svg class="w-full h-full text-gray-300" viewBox="0 0 100 100" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect width="100" height="100" fill="#E5E7EB"/>
                                                                    <path d="M65 35L80 55V80H20V55L35 35L50 55L65 35Z" fill="white"/>
                                                                    <circle cx="35" cy="25" r="10" fill="white"/>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="swiper-pagination"></div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col justify-between w-2/3 p-4">
                                        <div class="space-y-3">
                                            <h3 class="mb-2 text-xl font-bold text-gray-800">{{ $event->event_name }}</h3>
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $event->event_venue }}
                                            </div>
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                Scheduled for {{ \Carbon\Carbon::parse($event->date_start)->format('F Y') }}
                                            </div>
                                            @if ($event->date_end)
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Ends on {{ \Carbon\Carbon::parse($event->date_end)->format('F d, Y') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <a class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300 judge-now-btn min-w-[120px]"
                                                data-event-id="{{ $event->id }}"
                                                href="{{ route('view_contestants.event', ['eventId' => $event->id, 'roundId' => $currentRound->id ?? 0]) }}">
                                                <span class="button-text">Judge now!</span>
                                                <svg class="w-4 h-4 ml-2 button-icon" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7" />
                                                </svg>
                                                <span class="hidden button-wait-text">Please wait...</span>
                                                <svg class="hidden w-4 h-4 ml-2 animate-spin button-spinner"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link href="https://unpkg.com/swiper/swiper-bundle.min.css" rel="stylesheet" />
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($events as $event)
                new Swiper('#swiper-{{ $event->id }}', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                    },
                    autoplay: {
                        delay: 5000,
                    },
                });
            @endforeach
        });
    </script>
     <script src="{{ asset('js/lottie.min.js') }}"></script>
@endsection
