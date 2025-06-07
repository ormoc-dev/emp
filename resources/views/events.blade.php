@extends('layouts.welcome_layout')

@section('content')
    <!--UPCOMING EVENTS SECTION-->
    <section class="py-20" id="events-section">
        <style>
            @keyframes calendarPulse {
                0% {
                    transform: scale(1) rotate(0deg);
                    opacity: 0.8;
                }

                50% {
                    transform: scale(1.15) rotate(8deg);
                    opacity: 1;
                }

                100% {
                    transform: scale(1) rotate(0deg);
                    opacity: 0.8;
                }
            }

            @keyframes shimmer {
                0% {
                    background-position: -200% 0;
                }

                100% {
                    background-position: 200% 0;
                }
            }

            .animate-calendar {
                animation: calendarPulse 3s ease-in-out infinite;
            }

            .calendar-container {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                background: linear-gradient(45deg, #f3f4f6, #e5e7eb, #f3f4f6);
                background-size: 200% 200%;
                animation: shimmer 3s infinite linear;
            }

            .calendar-container:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            .calendar-container:hover .animate-calendar {
                animation-duration: 1.5s;
            }

            .empty-state-text {
                opacity: 0;
                transform: translateY(20px);
                animation: fadeInUp 0.5s ease-out forwards;
                animation-delay: 0.3s;
            }

            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .table-container {
                max-height: 400px;
                overflow-y: auto;
                scrollbar-width: thin;
                scrollbar-color: #CBD5E0 #EDF2F7;
            }

            .table-container::-webkit-scrollbar {
                width: 8px;
            }

            .table-container::-webkit-scrollbar-track {
                background: #EDF2F7;
                border-radius: 4px;
            }

            .table-container::-webkit-scrollbar-thumb {
                background-color: #CBD5E0;
                border-radius: 4px;
            }

            .search-container {
                position: relative;
                margin-bottom: 1rem;
            }

            .search-input {
                padding-left: 2.5rem;
                transition: all 0.3s ease;
            }

            .search-input:focus {
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            .search-icon {
                position: absolute;
                left: 0.75rem;
                top: 50%;
                transform: translateY(-50%);
                color: #6B7280;
            }
        </style>
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-16">
                <h2 class="sm:text-4xl text-3xl font-bold mb-4 animate-fadeIn text-gray-900">
                    Upcoming <span class="text-red-600">Events</span> 2024
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-red-600 to-blue-600 mx-auto mb-8"></div>
                <p class="text-gray-600 max-w-2xl mx-auto animate-slideIn text-lg">
                    Join us for a spectacular showcase of talent, beauty, and artistry. Experience the magic of live
                    performances and unforgettable moments.
                </p>
            </div>

            <div class="container mx-auto px-4 py-8">
                <!-- Search Bar -->
                <div class="search-container max-w-md mx-auto mb-8">
                    <div class="relative">
                        <i class="fas fa-search search-icon"></i>
                        <input
                            class="search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            id="eventSearch" type="text" placeholder="Search events...">
                    </div>
                </div>

                <!-- Table Container -->
                <div class="mt-4 flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow-lg ring-1 ring-black ring-opacity-5 rounded-xl bg-white">
                                <div class="table-container">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50 sticky top-0">
                                            <tr>
                                                <th class="py-4 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                    scope="col">Event Name</th>
                                                <th class="px-3 py-4 text-left text-sm font-semibold text-gray-900"
                                                    scope="col">Date</th>
                                                <th class="px-3 py-4 text-left text-sm font-semibold text-gray-900"
                                                    scope="col">Time</th>
                                                <th class="px-3 py-4 text-left text-sm font-semibold text-gray-900"
                                                    scope="col">Venue</th>
                                                <th class="px-3 py-4 text-left text-sm font-semibold text-gray-900"
                                                    scope="col">Status</th>
                                                <th class="relative py-4 pl-3 pr-6" scope="col">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @forelse($events as $event)
                                                <tr class="hover:bg-gray-50 transition-colors duration-200 event-row">
                                                    <td class="py-5 pl-6 pr-3 text-sm sm:pl-6">
                                                        <div class="flex items-center space-x-4">
                                                            <div class="flex-shrink-0">
                                                                <div
                                                                    class="w-10 h-10 rounded-full bg-gradient-to-r from-red-600 to-blue-600 flex items-center justify-center">
                                                                    <i class="fas fa-calendar-alt text-white"></i>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="font-medium text-gray-900 event-name">
                                                                    {{ $event->event_name }}</div>
                                                                <div class="text-gray-500 event-subtitle">
                                                                    {{ $event->event_subtitle }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-5 text-sm">
                                                        <div class="font-medium text-gray-900">
                                                            @if ($event->timeSchedule)
                                                                {{ \Carbon\Carbon::parse($event->timeSchedule->time_start)->format('M d, Y') }}
                                                            @else
                                                                {{ \Carbon\Carbon::parse($event->date_start)->format('M d, Y') }}
                                                            @endif
                                                        </div>
                                                        @if ($event->timeSchedule && $event->timeSchedule->time_end)
                                                            <div class="text-gray-500">
                                                                to
                                                                {{ \Carbon\Carbon::parse($event->timeSchedule->time_end)->format('M d, Y') }}
                                                            </div>
                                                        @elseif($event->date_end)
                                                            <div class="text-gray-500">
                                                                to
                                                                {{ \Carbon\Carbon::parse($event->date_end)->format('M d, Y') }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-5 text-sm">
                                                        <div class="flex items-center text-gray-900">
                                                            <i class="fas fa-clock text-blue-600 mr-2"></i>
                                                            @if ($event->timeSchedule)
                                                                {{ \Carbon\Carbon::parse($event->timeSchedule->time_start)->format('g:i A') }}
                                                                @if ($event->timeSchedule->time_end)
                                                                    <span class="text-gray-500 mx-1">to</span>
                                                                    {{ \Carbon\Carbon::parse($event->timeSchedule->time_end)->format('g:i A') }}
                                                                @endif
                                                            @else
                                                                TBA
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-5 text-sm">
                                                        <div class="flex items-center text-gray-900">
                                                            <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>
                                                            {{ $event->event_venue }}
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-5 text-sm">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                            {{ $event->event_status === 'completed'
                                                                ? 'bg-green-100 text-green-800'
                                                                : ($event->event_status === 'started'
                                                                    ? 'bg-blue-100 text-blue-800'
                                                                    : 'bg-red-100 text-red-800') }}">
                                                            {{ $event->event_status }}
                                                        </span>
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="px-3 py-16 text-center text-sm text-gray-500" colspan="6">
                                                        <div class="flex flex-col items-center justify-center">
                                                            <div
                                                                class="calendar-container w-20 h-20 rounded-full flex items-center justify-center mb-6">
                                                                <i
                                                                    class="fas fa-calendar-times text-gray-500 text-3xl animate-calendar"></i>
                                                            </div>
                                                            <div class="empty-state-text">
                                                                <h3 class="text-xl font-semibold text-gray-900 mb-2">No
                                                                    Events Available</h3>
                                                                <p class="text-gray-500 max-w-md mx-auto">We're currently
                                                                    preparing our next exciting events. Check back soon for
                                                                    updates and upcoming opportunities to showcase your
                                                                    talent.</p>
                                                            </div>
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
            </div>

            <!-- Timeline -->
            <div class="max-w-4xl mx-auto mt-20">
                <h3 class="text-2xl font-bold text-center mb-12">Event Process Flow</h3>
                <div class="relative">
                    <!-- Timeline Line -->
                    <div
                        class="absolute -z-50  left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-red-600 via-blue-600 to-red-600">
                    </div>

                    <!-- Timeline Items -->
                    <div class="space-y-12">
                        <!-- Timeline Item -->
                        <div class="flex items-center justify-between">
                            <div class="w-5/12 text-right pr-8">
                                <div
                                    class="bg-white p-6 rounded-xl shadow-lg transform transition duration-300 hover:scale-105">
                                    <h4 class="text-lg font-semibold text-red-600">Registration Phase</h4>
                                    <p class="text-sm text-gray-500">Step 1</p>
                                </div>
                            </div>
                            <div class="w-2/12 flex justify-center">
                                <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-plus text-white "></i>
                                </div>
                            </div>
                            <div class="w-5/12 pl-8">
                                <p class="text-sm text-gray-600">Submit application forms and requirements for event
                                    participation.</p>
                            </div>
                        </div>

                        <!-- Timeline Item -->
                        <div class="flex items-center justify-between">
                            <div class="w-5/12 text-right pr-8">
                                <p class="text-sm text-gray-600">Evaluation of applications and selection of qualified
                                    participants.</p>
                            </div>
                            <div class="w-2/12 flex justify-center">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clipboard-check text-white"></i>
                                </div>
                            </div>
                            <div class="w-5/12 pl-8">
                                <div
                                    class="bg-white p-6 rounded-xl shadow-lg transform transition duration-300 hover:scale-105">
                                    <h4 class="text-lg font-semibold text-blue-600">Screening Process</h4>
                                    <p class="text-sm text-gray-500">Step 2</p>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Item -->
                        <div class="flex items-center justify-between">
                            <div class="w-5/12 text-right pr-8">
                                <div
                                    class="bg-white p-6 rounded-xl shadow-lg transform transition duration-300 hover:scale-105">
                                    <h4 class="text-lg font-semibold text-red-600">Competition Day</h4>
                                    <p class="text-sm text-gray-500">Final Step</p>
                                </div>
                            </div>
                            <div class="w-2/12 flex justify-center">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-trophy text-white"></i>
                                </div>
                            </div>
                            <div class="w-5/12 pl-8">
                                <p class="text-sm text-gray-600">Main event competition and awarding ceremony.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('eventSearch');
            const eventRows = document.querySelectorAll('.event-row');

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();

                eventRows.forEach(row => {
                    const eventName = row.querySelector('.event-name').textContent.toLowerCase();
                    const eventSubtitle = row.querySelector('.event-subtitle').textContent
                        .toLowerCase();
                    const eventVenue = row.querySelector('.fa-map-marker-alt').parentElement
                        .textContent.toLowerCase();

                    if (eventName.includes(searchTerm) ||
                        eventSubtitle.includes(searchTerm) ||
                        eventVenue.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
