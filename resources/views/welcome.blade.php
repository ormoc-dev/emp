@extends('layouts.welcome_layout')
<style>
    html {
        scroll-behavior: smooth;
    }
</style>
@section('content')
    <!--HEAD CONTENT SECTION-->
    <div class="headers relative max-w-full ">
        <!-- Content before waves -->
        <div class="flexs flex flex-col items-center justify-center text-center text-white py-[70px] relative z-10">
            <h1
                class="mb-18 mt-12 py12 sm:mt-12 md:mt-32 lg:mt-12 font-serif text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold">
                W e l c o m e To
                <button class="button" data-text="Awesome">
                    <span class="actual-text">&nbsp;Tabulate's&nbsp;</span>
                    <span class="hover-text" aria-hidden="true">&nbsp;Tabulate's&nbsp;</span>
                </button>
                Judging <br> Platform
            </h1>
            <p class="mb-12 sm:mb-2 md:mb-10 text-base sm:text-lg md:text-xl lg:text-2xl font-light animate-slideIn">
                Your One-Stop Destination <br class="sm:hidden" />
                for Organized Information!
            </p>
            <div class="typewriter mb-8 sm:mb-8 md:mb-10 lg:mb-12">
                <div class="slide"><i></i></div>
                <div class="paper"></div>
                <div class="keyboard"></div>
            </div>

            <!-- Buttons Container -->
            <div class="flex flex-row flex-nowrap gap-4 justify-center w-full px-4 sm:px-0">
                @if (Auth::check())
                    @php
                        $route = match (Auth::user()->level) {
                            'admin' => 'admin_home',
                            'judge' => 'judges_home',
                            'Sadmin' => 'Sadmin_home',
                            default => 'users_home',
                        };
                    @endphp
                    <a class="inline-flex items-center justify-center px-6 py-2 text-sm sm:text-base font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300"
                        href="{{ route($route) }}">
                        <span>Go to Dashboard</span>
                        <svg class="w-4 sm:w-5 h-4 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                @else
                    <!-- Get Started Button -->
                    <a class="inline-flex items-center justify-center px-6 py-2 text-sm sm:text-base font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300"
                        href="{{ route('login') }}" wire:navigate>
                        <span>Get Started</span>
                        <svg class="w-4 sm:w-5 h-4 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>

                    <!-- Learn More Button -->
                    <a class="inline-flex items-center justify-center px-6 py-2 text-sm sm:text-base font-medium text-gray-100 border-2 border-gray-300 rounded-lg hover:bg-white hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-300"
                        onclick="document.getElementById('learn').scrollIntoView({behavior: 'smooth'})">
                        <span>Learn More</span>
                        <svg class="w-4 sm:w-5 h-4 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>




        <div class="absolute inset-0 z-0 overflow-hidden">
            <img class="w-full h-full object-cover object-center opacity-50"
                src="{{ isset($background) ? asset($background->background_image) : asset('img/missOC.jpg') }}"
                alt="gallery">
        </div>

        <!-- Waves Container -->
        <div class="relative z-10">
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.6)" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="rgba(255,255,255,0.2)" />
                </g>
            </svg>
        </div>
        <!-- Waves end -->

        <div class="fixed bottom-4 right-4 z-20 transition-opacity duration-300" id="rateUsCard">
            <div class="bg-white rounded-lg shadow-lg p-3 sm:p-4 w-64 sm:w-80 max-w-[90vw] text-center relative">
                <!-- Countdown Timer -->
                <div class="absolute top-2 left-2 text-gray-600 rounded-full flex items-center justify-center w-6 sm:w-8 h-6 sm:h-8 text-xs sm:text-sm font-bold"
                    id="countdownTimer">
                    10
                </div>

                <!-- Close Button -->
                <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" id="closeRateUsCard">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- Title -->
                <h3 class="text-base sm:text-lg font-semibold text-gray-800 mt-2">Enjoying our platform?</h3>
                <p class="text-xs sm:text-sm text-gray-600">We'd love to hear your feedback!</p>

                <!-- Carousel -->
                <div class="relative overflow-hidden rounded-lg my-3 sm:mb-4">
                    <div class="flex transition-transform duration-500" id="carouselImages">
                        <img class="w-full h-20 sm:h-28 md:h-40 object-cover" src="{{ asset('img/grid1.png') }}"
                            alt="Image 1">
                        <img class="w-full h-20 sm:h-28 md:h-40 object-cover hidden" src="{{ asset('img/MR.jpg') }}"
                            alt="Image 2">
                        <img class="w-full h-20 sm:h-28 md:h-40 object-cover hidden" src="{{ asset('img/fday2.jpg') }}"
                            alt="Image 3">
                    </div>
                </div>

                <!-- Button -->
                <button
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 sm:py-2 px-3 sm:px-4 rounded text-sm sm:text-base transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-md w-full flex items-center justify-center"
                    id="rateUsButton">
                    <span>Message Us</span>
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!--RATINGS SECTION-->
    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-0 mx-auto mt-[-50px]">
            <div class="flex flex-wrap lg:w-5/5 mx-auto">
                <div class="w-full md:w-1/2" id="RATINGS" style="height: 420px;">
                </div>

                <div class="w-full lg:w-1/2 lg:pl-10 lg:py-6 mt-6 lg:mt-24 text-center md:text-left" id="videoHighlights">
                    <h2 class="text-sm title-font text-red-500 tracking-widest font-semibold">EVENT MASTER PRO</h2>
                    <h1 class="text-gray-900 text-3xl title-font font-bold mb-4">Your Complete <span
                            class="text-red-500">EVENT</span> Management Solution</h1>

                    <!-- Rating Display -->
                    <div class="flex mb-4 justify-center md:justify-start">
                        <span class="flex items-center">
                            {!! str_repeat(
                                '<svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>',
                                5,
                            ) !!}
                            <span class="text-gray-600 ml-3">Trusted by Industry Leaders</span>
                        </span>
                    </div>

                    <p class="leading-relaxed animate-slideIn">
                    <div class="space-y-4 mb-6">
                        <!-- Feature Items -->
                        <div class="flex items-center justify-center md:justify-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-gray-700">Real-time Scoring & Results</span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-gray-700">Custom Judging Criteria</span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-gray-700">Participant Management</span>
                        </div>
                    </div>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!--VIDEO HIGHLIGHTS-->
    <section class="text-gray-600 body-font" id="ratings">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col">
                <div class="h-1 bg-gray-200 rounded overflow-hidden">
                    <div class="w-24 h-full bg-red-500"></div>
                </div>
                <div class="flex flex-wrap sm:flex-row flex-col py-6 mb-12">
                    <h1
                        class="sm:w-2/5 text-gray-900 font-medium title-font text-2xl mb-2 sm:mb-0 animate-grow flex items-center">
                        <span class="mr-2">Event Video Highlights</span>
                        <lord-icon src="https://cdn.lordicon.com/pjwsjrxf.json" style="width:50px;height:50px"
                            trigger="loop" delay="2000" colors="primary:#3a3347,secondary:#e86830">
                        </lord-icon>
                    </h1>
                    <p class="sm:w-3/5 leading-relaxed text-base sm:pl-10 pl-0 animate-slideIn">
                        Relive the magic of our past events through these captivating video highlights.
                        Each clip showcases the talent, beauty, and excitement that define our pageants and competitions.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap sm:-m-4 -mx-4 -mb-10 -mt-4">
                @forelse($videos as $video)
                    <div class="p-4 md:w-1/3 sm:mb-0 mb-6">
                        <div class="rounded-lg h-64 overflow-hidden">
                            <div class="relative" style="padding-top: 56.25%;">
                                <iframe class="absolute inset-0 w-full h-full rounded-lg shadow-xl"
                                    src="{{ $video->video_url }}" title="{{ $video->title }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                        <h2 class="text-xl font-medium title-font text-gray-900 mt-5 animate-fadeIn">
                            {{ $video->title }}
                        </h2>
                        <p class="text-base leading-relaxed mt-2 animate-slideIn">
                            {{ $video->description }}
                        </p>
                        <a class="text-red-500 inline-flex items-center mt-3" href="{{ $video->video_url }}"
                            target="_blank">
                            Watch Video
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    @empty
                    <div class="w-full py-16">
                        <div class="max-w-2xl mx-auto  rounded-lg shadow-sm border  p-8">
                            <div class="flex flex-col items-center justify-center text-center">
                                <!-- Animated Icon -->
                                <lord-icon
                                    src="https://cdn.lordicon.com/nocovwne.json"
                                    trigger="loop"
                                    delay="2000"
                                    colors="primary:#666666,secondary:#e83a3a"
                                    style="width:85px;height:85px">
                                </lord-icon>
                
                                <!-- Title -->
                                <h2 class="mt-6 text-2xl font-bold text-gray-900">No Video Highlights Yet</h2>
                                
                                <!-- Description -->
                                <div class="mt-3 space-y-2">
                                    <p class="text-gray-600">We're currently preparing amazing content for you.</p>
                                    <p class="text-gray-500 text-sm">Our team is working on capturing the best moments from our events.</p>
                                </div>
                
                                <!-- Divider -->
                                <div class="w-16 h-1 bg-red-500 mx-auto my-6"></div>
                
                                <!-- Call to Action -->
                                <div class="mt-2">
                                    <button onclick="window.location.reload()" 
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Refresh Page
                                    </button>
                                </div>
                
                                <!-- Additional Info -->
                                <p class="mt-6 text-sm text-gray-500">
                                    Want to stay updated? 
                                    <a href="#" class="text-red-600 hover:text-red-700 font-medium">
                                        Subscribe to our newsletter
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!--UPCOMING EVENTS SECTION-->
    <section class=" py-20" id="learn" id="events-section">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-16">
                <h2 class="sm:text-3xl text-2xl font-bold mb-4 animate-fadeIn text-gray-900">
                    Upcoming <span class="text-red-600">Events</span> 2024
                </h2>
                <div class="w-24 h-1 bg-red-600 mx-auto mb-8"></div>
                <p class="text-gray-600 max-w-2xl mx-auto animate-slideIn">
                    Join us for a spectacular showcase of talent, beauty, and artistry. Experience the magic of live
                    performances and unforgettable moments.
                </p>
            </div>

            <!-- Featured Events Grid -->
            <!-- Table Container -->
            <div class="mt-4 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="">
                                    <tr>
                                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            scope="col">Event Name</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            scope="col">Date</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            scope="col">Time</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            scope="col">Venue</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            scope="col">Status</th>
                                        <th class="relative py-3.5 pl-3 pr-4 sm:pr-6" scope="col">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($events as $event)
                                        <tr class="hover:bg-gray-50">
                                            <td class=" py-4 pl-4 pr-3 text-sm sm:pl-6">
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $event->event_name }}</div>
                                                    <div class="text-gray-500">{{ $event->event_subtitle }}</div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <div class="font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($event->date_start)->format('M d, Y') }}
                                                </div>
                                                @if ($event->date_end)
                                                    <div class="text-gray-500">
                                                        to {{ \Carbon\Carbon::parse($event->date_end)->format('M d, Y') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $event->timeSchedule ? \Carbon\Carbon::parse($event->timeSchedule->start_time)->format('g:i A') : 'TBA' }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $event->event_venue }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                                <span
                                                    class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                                    {{ $event->event_status === 'FEATURED'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : ($event->event_status === 'NEW'
                                                            ? 'bg-green-100 text-green-800'
                                                            : 'bg-blue-100 text-blue-800') }}">
                                                    {{ $event->event_status }}
                                                </span>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-3 py-8 text-center text-sm text-gray-500" colspan="6">
                                                <div class="flex flex-col items-center justify-center">
                                                    <svg class="h-12 w-12 text-gray-400" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No events</h3>
                                                    <p class="mt-1 text-sm text-gray-500">No upcoming events at this time.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="max-w-4xl mx-auto">
            <h3 class="text-2xl font-bold text-center mb-8">Event Process Flow</h3>
            <div class="relative">
                <!-- Timeline Line -->
                <div
                    class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-pink-500 via-blue-500 to-purple-500">
                </div>

                <!-- Timeline Items -->
                <div class="space-y-12">
                    <!-- Timeline Item -->
                    <div class="flex items-center justify-between">
                        <div class="w-5/12 text-right pr-8">
                            <h4 class="text-lg font-semibold text-pink-400">Registration Phase</h4>
                            <p class="text-sm text-gray-400">Step 1</p>
                        </div>
                        <div class="w-2/12 flex justify-center">
                            <div class="w-4 h-4 bg-pink-500 rounded-full"></div>
                        </div>
                        <div class="w-5/12 pl-8">
                            <p class="text-sm text-gray-500">Submit application forms and requirements for event
                                participation.</p>
                        </div>
                    </div>

                    <!-- Timeline Item -->
                    <div class="flex items-center justify-between">
                        <div class="w-5/12 text-right pr-8">
                            <p class="text-sm text-gray-500">Evaluation of applications and selection of qualified
                                participants.</p>
                        </div>
                        <div class="w-2/12 flex justify-center">
                            <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                        </div>
                        <div class="w-5/12 pl-8">
                            <h4 class="text-lg font-semibold text-blue-400">Screening Process</h4>
                            <p class="text-sm text-gray-400">Step 2</p>
                        </div>
                    </div>

                    <!-- Timeline Item -->
                    <div class="flex items-center justify-between">
                        <div class="w-5/12 text-right pr-8">
                            <h4 class="text-lg font-semibold text-purple-400">Competition Day</h4>
                            <p class="text-sm text-gray-400">Final Step</p>
                        </div>
                        <div class="w-2/12 flex justify-center">
                            <div class="w-4 h-4 bg-purple-500 rounded-full"></div>
                        </div>
                        <div class="w-5/12 pl-8">
                            <p class="text-sm text-gray-500">Main event competition and awarding ceremony.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


    <!--EVENT HISTORY SECTION-->
    <section class="text-gray-800 body-font">
        <div class="container mx-auto py-20 px-5">
            <!-- Header -->
            <div class="flex flex-col">
                <div class="h-1 bg-gray-200 rounded overflow-hidden">
                    <div class="w-24 h-full bg-red-500"></div>
                </div>
                <div class="flex flex-wrap sm:flex-row flex-col py-6 mb-12">
                    <h1 class="sm:w-2/5 text-gray-900 font-semibold text-2xl mb-2 sm:mb-0 flex items-center">
                        <span class="mr-2">Event History Highlights</span>
                        <lord-icon src="https://cdn.lordicon.com/vneufqmz.json" style="width:40px;height:40px"
                            trigger="loop" delay="2000"
                            colors="primary:#3a3347,secondary:#ffffff,tertiary:#ffc738,quaternary:#faddd1,quinary:#646e78,senary:#ee6d66">
                        </lord-icon>
                    </h1>
                    <p class="sm:w-3/5 leading-relaxed text-base sm:pl-10">Over the years, our platform has been proud to
                        support a wide variety of events. Here's a glimpse into some of the memorable competitions we've
                        helped bring to life. Each event represents a unique celebration of talent, creativity, and human
                        achievement. We're honored to have played a part in these incredible journeys.
                    </p>
                </div>
            </div>

            <!-- Event Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-10">
                <!-- First Card -->
                <div class="sm:col-span-6 lg:col-span-5">
                    <a href="#">
                        <img class="h-56 w-full object-cover rounded-md" src="{{ asset('/img/mr&ms.jpg') }}"
                            alt="Mr. and Miss Intramurals 2024">
                    </a>
                    <div class="mt-3">
                        <a class="text-xs text-indigo-600 uppercase font-medium hover:text-gray-900"
                            href="#">Event</a>
                        <a class="block text-gray-900 font-bold text-lg hover:text-indigo-600 transition"
                            href="#">Mr. and Miss Intramurals 2024 in Western Leyte</a>
                        <p class="text-gray-700 text-sm mt-2">Celebrate elegance, charm, and athleticism at this
                            yearÃ¢â‚¬â„¢s much-anticipated Mr. and Miss Intramurals 2024 in Western Leyte. Witness a
                            showcase of talent, style, and passion for excellence!</p>
                    </div>
                </div>


                <!-- List of Events -->
                <div class="sm:col-span-6 lg:col-span-4">
                    <div class="space-y-5">
                        <!-- Event Item -->
                        <div class="flex items-start">
                            <a class="mr-3 flex-shrink-0" href="#">
                                <img class="w-20 h-20 object-cover rounded-md" src="{{ asset('/img/fday6.jpg') }}"
                                    alt="Event Image">
                            </a>
                            <div class="text-sm">
                                <p class="text-gray-600 text-xs">Aug 18</p>
                                <a class="text-gray-900 font-medium hover:text-indigo-600" href="#">Miss OC 2 Brings
                                    Excitement and Glamour to Stage</a>
                            </div>
                        </div>
                        <!-- Event Item -->
                        <div class="flex items-start">
                            <a class="mr-3 flex-shrink-0" href="#">
                                <img class="w-20 h-20 object-cover rounded-md" src="{{ asset('img/fday3.jpg') }}"
                                    alt="Event Image">
                            </a>
                            <div class="text-sm">
                                <p class="text-gray-600 text-xs">Jan 18</p>
                                <a class="text-gray-900 font-medium hover:text-indigo-600" href="#">Miss Elegance
                                    Highlights Beauty and Cultural Heritage</a>
                            </div>
                        </div>
                        <!-- Event Item -->
                        <div class="flex items-start">
                            <a class="mr-3 flex-shrink-0" href="#">
                                <img class="w-20 h-20 object-cover rounded-md" src="{{ asset('img/missOC.jpg') }}"
                                    alt="Event Image">
                            </a>
                            <div class="text-sm">
                                <p class="text-gray-600 text-xs">Aug 18</p>
                                <a class="text-gray-900 font-medium hover:text-indigo-600" href="#">Miss WLC 2023
                                    Showcases Talent and Charisma Tonight.</a>
                            </div>
                        </div>
                        <!-- Event Item -->
                        <div class="flex items-start">
                            <a class="mr-3 flex-shrink-0" href="#">
                                <img class="w-20 h-20 object-cover rounded-md" src="{{ asset('img/fday.jpg') }}"
                                    alt="Event Image">
                            </a>
                            <div class="text-sm">
                                <p class="text-gray-600 text-xs">July 23</p>
                                <a class="text-gray-900 font-medium hover:text-indigo-600" href="#">Miss WLC 2024
                                    Celebrates Diversity and Empowerment</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Final Card -->
                <div class="sm:col-span-12 lg:col-span-3">
                    <a href="#">
                        <img class="h-56 w-full object-cover rounded-md" src="{{ asset('img/grid2.png') }}"
                            alt="Fashion Event">
                    </a>
                    <div class="mt-3">
                        <a class="text-xs text-indigo-600 uppercase font-medium hover:text-gray-900"
                            href="#">Fashion</a>
                        <a class="block text-gray-900 font-bold text-lg hover:text-indigo-600 transition"
                            href="#">The perfect summer sweater that you can wear!</a>
                        <p class="text-gray-700 text-sm mt-2">The Grand Pageant Showcases Beauty and Talent.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--TESTIMONIAL SECTION-->
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-8 mx-auto">
            <div class="text-center mb-20">
                <h1 class="sm:text-3xl text-2xl flex justify-center  font-medium title-font text-gray-900 mb-4">
                    TESTIMONIALS

                </h1>
                <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto text-gray-500s">Meet the talented individuals
                    behind our success. Each member brings unique skills and expertise to our team.</p>
                <div class="flex mt-6 justify-center">
                    <div class="w-16 h-1 rounded-full bg-red-500 inline-flex"></div>
                </div>
            </div>

            <div class="flex flex-wrap -m-4">
                <div class="p-4 md:w-1/2 w-full">
                    <div class="h-full bg-gray-100 p-8 rounded">
                        <svg class="block w-5 h-5 text-gray-400 mb-4 move" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 975.036 975.036">
                            <path
                                d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z">
                            </path>
                        </svg>
                        <p class="leading-relaxed mb-6 animate-slideIn">Western Leyte College is at the forefront of
                            innovation with its advanced event tabulation system. The BSIT students at CICTE have done an
                            incredible job developing this system for the school. It not only streamlines the scoring
                            process but also introduces dynamic features that enhance overall event management. It's a
                            game-changer for institutions looking to modernize their events!</p>
                        <a class="inline-flex items-center">
                            <img class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center"
                                src="{{ asset('img/wlc.jpg') }}" alt="testimonial">
                            <span class="flex-grow flex flex-col pl-4">
                                <span class="title-font font-medium text-gray-900 animate-fadeIn">Western Leyte
                                    College</span>
                                <span class="text-gray-500 text-sm animate-fadeIn">Ormoc City</span>
                            </span>

                        </a>
                    </div>
                </div>
                <div class="p-4 md:w-1/2 w-full">
                    <div class="h-full bg-gray-100 p-8 rounded">
                        <svg class="block w-5 h-5 text-gray-400 mb-4 move" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 975.036 975.036">
                            <path
                                d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z">
                            </path>
                        </svg>
                        <p class="leading-relaxed mb-6 animate-slideIn">CICTE has provided the tools and knowledge to build
                            a sophisticated tabulation system for major events at Western Leyte College. The system's
                            integration of advanced features allows for seamless management of scores, contestants, and
                            rounds. This project has been an exciting challenge, pushing our students to apply their
                            technical skills to a real-world solution.</p>
                        <a class="inline-flex items-center">
                            <img class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center"
                                src="{{ asset('img/cicte-logo.png') }}" alt="testimonial">
                            <span class="flex-grow flex flex-col pl-4">
                                <span class="title-font font-medium text-gray-900 animate-fadeIn">CICTE Department</span>
                                <span class="text-gray-500 text-sm animate-fadeIn">Western Leyte College</span>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Third Testimonial (Mr. Archi Gableno) -->
                <div class="p-4 md:w-1/2 w-full">
                    <div class="h-full  p-8 rounded">
                        <svg class="block w-5 h-5 text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 975.036 975.036">
                            <path d="M925.036 57.197h-304c..."></path>
                        </svg>
                        <p class="leading-relaxed mb-6">Event master pro is impressive! It has transformed the way we
                            manage and organize events. The smooth user interface and accurate scoring functionality made
                            our recent events a huge success.</p>
                        <a class="inline-flex items-center">
                            <img class="w-12 h-12 rounded-full object-cover object-center"
                                src="{{ asset('img/CHEBANG.jpg') }}" alt="Mr. Archi Gableno">
                            <span class="flex-grow flex flex-col pl-4">
                                <span class="title-font font-medium text-gray-900">Mr. CHEBANG REMO GABLINO</span>
                                <span class="text-gray-500 text-sm">Western Leyte College</span>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Fourth Testimonial (Mr. Jojo Cantero) -->
                <div class="p-4 md:w-1/2 w-full">
                    <div class="h-full  p-8 rounded">
                        <svg class="block w-5 h-5 text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 975.036 975.036">
                            <path d="M925.036 57.197h-304c..."></path>
                        </svg>
                        <p class="leading-relaxed mb-6">The system exceeded my expectations. The way it handles real-time
                            scoring and updates is phenomenal. It was a pleasure to use during our events, and I look
                            forward to implementing it in future occasions.</p>
                        <a class="inline-flex items-center">
                            <img class="w-12 h-12 rounded-full object-cover object-center"
                                src="{{ asset('img/cantero.jpg') }}" alt="Mr. Jojo Cantero">
                            <span class="flex-grow flex flex-col pl-4">
                                <span class="title-font font-medium text-gray-900">Mr. JOJO ENTIA CANTERO</span>
                                <span class="text-gray-500 text-sm">CICTE Department</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--FEEDBACK SECTION-->
    <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap">
            <div class="lg:w-2/3 w-full  md:w-1/2 bg-gray-300 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative"
                style="min-height: 300px; ">
                <iframe class="absolute inset-0"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3933.2458214880396!2d124.60323431479!3d11.006389992163927!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3307e9d8a0b3e7e7%3A0x8c4c3a1d9b1f2e3a!2sWestern%20Leyte%20College!5e0!3m2!1sen!2sph!4v1650000000000!5m2!1sen!2sph&maptype=satellite"
                    title="map" style="filter: none;" width="100%" height="100%" frameborder="0"
                    marginheight="0" marginwidth="0" scrolling="no">
                </iframe>
            </div>
            <div class="lg:w-1/3 md:w-1/2 flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0  bg-white rounded-lg overflow-hidden p-4"
                id="feedbackSection">
                <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Feedback:
                    <span class="text-sm sm:text-base md:text-lg lg:text-xl" id="feedbackMessage"></span>
                </h2>
                <p class="leading-relaxed mb-5 text-gray-600">We value your input! Please share your thoughts on our
                    services.</p>
                <form id="feedbackForm">
                    @csrf

                    <div class="relative mb-4">
                        <label class="leading-7 text-sm text-gray-600" for="email">Email</label>
                        <input
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            id="email" name="email" type="email">
                    </div>

                    <div class="relative mb-4">
                        <label class="leading-7 text-sm text-gray-600" for="message">Message</label>
                        <textarea
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                            id="message" name="message"></textarea>
                    </div>
                    <button
                        class="text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded text-lg w-full transition duration-300 ease-in-out flex items-center justify-center"
                        id="submitButton" type="submit">
                        <span id="buttonText">Submit Feedback</span>
                        <svg class="w-6 h-6 ml-2 hidden" id="spin" viewBox="25 25 50 50">
                            <circle r="20" cy="50" cx="50"></circle>
                        </svg>
                    </button>
                </form>
                <p class="text-xs text-gray-500 mt-3">Your feedback helps us improve our services for you and future
                    users..</p>
            </div>
        </div>
    </section>


    <!--APP DOWNLOAD SECTION-->
    <section class="text-gray-600 body-font p-10">
        <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
            <div
                class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900 animate-grow">Introducing EVENT
                    MASTER PRO</h1>
                <p class="mb-8 leading-relaxed animate-fadeIn">Elevate your events with EVENT MASTER PRO. Our app allows
                    users to vote effortlessly and stay engaged with real-time updates. Join the revolution in event
                    management and make your events unforgettable.</p>
                <div class="flex w-full md:justify-start justify-center items-end">
                    <div class="relative mr-4 md:w-full lg:w-full xl:w-1/2 w-2/4">
                        <label class="leading-7 text-sm text-gray-600" for="hero-field">Enter your email to get
                            started</label>
                        <input
                            class="w-full bg-gray-100 rounded border bg-opacity-50 border-gray-300 focus:ring-2 focus:ring-red-200 focus:bg-transparent focus:border-red-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            id="hero-field" name="hero-field" type="email" placeholder="Your Email">
                    </div>
                    <button
                        class="inline-flex text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded text-lg">Subscribe</button>
                </div>
                <p class="text-sm mt-2 text-gray-500 mb-8 w-full animate-slideIn">Get exclusive updates and features
                    straight to your inbox.</p>
                <div class="flex lg:flex-row md:flex-col">
                    <a class="bg-gray-100 inline-flex py-3 px-5 rounded-lg items-center hover:bg-gray-200 focus:outline-none"
                        href="https://drive.google.com/file/d/1elXad49JB7C1YxwPHiPMg9tZuh6yLe2z/view?usp=drive_link">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 87.3 78">
                            <path
                                d="M6.6 66.85l3.85 6.65c.8 1.4 1.95 2.5 3.3 3.3l13.75-23.8H0c0 1.55.4 3.1 1.2 4.5l5.4 9.35z"
                                fill="#0066da" />
                            <path
                                d="M43.65 25l-13.75-23.8c-1.35.8-2.5 1.9-3.3 3.3L1.2 59.5c-.8 1.4-1.2 2.95-1.2 4.5h27.5l16.15-28c1.35-2.35-.2-5.25-2.85-6.5l2.85-4.5z"
                                fill="#00ac47" />
                            <path
                                d="M73.55 76.8c1.35-.8 2.5-1.9 3.3-3.3l1.6-2.75 7.65-13.25c.8-1.4 1.2-2.95 1.2-4.5H59.8L73.55 76.8z"
                                fill="#ea4335" />
                            <path d="M43.65 25l13.75-23.8c-1.35-.8-2.9-1.2-4.5-1.2h-18.5c-1.6 0-3.15.45-4.5 1.2l13.75 23.8z"
                                fill="#00832d" />
                            <path
                                d="M59.8 53l13.75 23.8c1.6-.8 2.9-1.95 3.85-3.35l9.2-15.9c.8-1.4 1.2-2.95 1.2-4.5H59.8v-.05z"
                                fill="#2684fc" />
                            <path d="M73.55 25h-29.9L29.9 53h29.9l13.75-23.8c1.35-2.35-.2-5.25-2.85-6.5L73.55 25z"
                                fill="#ffba00" />
                        </svg>
                        <span class="ml-4 flex items-start flex-col leading-none">
                            <span class="text-xs text-gray-600 mb-1">DOWNLOAD FROM</span>
                            <span class="title-font font-medium">Google Drive</span>
                        </span>
                    </a>
                </div>
            </div>
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-full px-4 sm:px-6 lg:px-8">
                <div class="relative" style="padding-top: 56.25%;">
                    <iframe class="absolute inset-0 w-full h-full rounded-lg shadow-xl"
                        src="https://www.youtube.com/embed/nkvokuvvmoA" title="Western Leyte College Video"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
                <p class="mt-2 text-sm text-gray-500 text-center italic flex items-center justify-center">
                    Video credit: EMP team 2024
                    <lord-icon class="ml-2" src="https://cdn.lordicon.com/rtmibavj.json" style="width:24px;height:24px"
                        trigger="loop" delay="2000" colors="primary:#faddd1,secondary:#3a3347">
                    </lord-icon>
                </p>
            </div>
        </div>
    </section>
@endsection
