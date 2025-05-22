@extends('layouts.welcome_layout')

@section('content')
    <!--UPCOMING EVENTS SECTION-->
    <section class=" py-20" id="events-section">
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

            <div class="container mx-auto px-4 py-8">

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
                                                        <div class="font-medium text-gray-900">{{ $event->event_name }}
                                                        </div>
                                                        <div class="text-gray-500">{{ $event->event_subtitle }}</div>
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    <div class="font-medium text-gray-900">
                                                        {{ \Carbon\Carbon::parse($event->date_start)->format('M d, Y') }}
                                                    </div>
                                                    @if ($event->date_end)
                                                        <div class="text-gray-500">
                                                            to
                                                            {{ \Carbon\Carbon::parse($event->date_end)->format('M d, Y') }}
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
                                                        <p class="mt-1 text-sm text-gray-500">No upcoming events at this
                                                            time.</p>
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
@endsection
