@extends('layouts.user')

@section('content')
    <section class="text-gray-600 body-font ">
        <div class="container   mx-auto">




            @if ($event->timeSchedule)
            @php
                $timezone = config('app.timezone');
                $now = \Carbon\Carbon::now($timezone);
                $start = \Carbon\Carbon::parse($event->timeSchedule->time_start)->setTimezone($timezone);
                $end = \Carbon\Carbon::parse($event->timeSchedule->time_end)->setTimezone($timezone);
                $isVotingTime = $now->between($start, $end);
                $totalDuration = $end->diffInSeconds($start);
                $elapsed = $now->diffInSeconds($start);
                $percentage = min(100, max(0, ($elapsed / $totalDuration) * 100));
            @endphp
        
            <div class="">
                <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Voting Schedule</h3>
                        <p class="text-gray-600">{{ $event->event_name }}</p>
                    </div>
        
                    <!-- Countdown Timer -->
                    <div class="flex justify-center gap-4 mb-8">
                        <div class="countdown-box">
                            <div class="time-segment" id="days">00</div>
                            <div class="time-label">Days</div>
                        </div>
                        <div class="time-separator">:</div>
                        <div class="countdown-box">
                            <div class="time-segment" id="hours">00</div>
                            <div class="time-label">Hours</div>
                        </div>
                        <div class="time-separator">:</div>
                        <div class="countdown-box">
                            <div class="time-segment" id="minutes">00</div>
                            <div class="time-label">Minutes</div>
                        </div>
                        <div class="time-separator">:</div>
                        <div class="countdown-box">
                            <div class="time-segment" id="seconds">00</div>
                            <div class="time-label">Seconds</div>
                        </div>
                    </div>
        
                    <!-- Progress Bar -->
                    <div class="mb-8">
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" 
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="text-sm text-gray-500 text-center mt-2">
                            {{ round($percentage) }}% of voting period completed
                        </div>
                    </div>
        
                    <!-- Status and Times -->
                    <div class="grid grid-cols-3 gap-6 text-center">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Start Time</p>
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $start->format('M d, Y') }}<br>
                                {{ $start->format('g:i A') }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Status</p>
                            <p class="text-lg font-semibold {{ $isVotingTime ? 'text-green-600' : 'text-red-600' }}"
                                id="voting-status">
                                {{ $isVotingTime ? 'Voting Open' : 'Voting Closed' }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1" id="countdown-label"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">End Time</p>
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $end->format('M d, Y') }}<br>
                                {{ $end->format('g:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="mt-4">
                <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto">
                    <div class="text-center">
                        <div class="mb-4">
                            <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100">
                                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Voting Schedule Not Set</h3>
        
                        @if (auth()->user()->role === 'admin')
                            <p class="text-gray-600 mb-4">The voting schedule for this event hasn't been set yet.</p>
                            <a class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                                href="{{ route('admin.event.schedule', $event->id) }}">
                                <i class="fas fa-plus mr-2"></i>
                                Set Voting Schedule
                            </a>
                        @else
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-600">Voting schedule will be announced soon.</p>
                                <p class="text-sm text-gray-500 mt-2">Please check back later.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        <style>
            .countdown-box {
                @apply flex flex-col items-center;
            }
        
            .time-segment {
                @apply bg-gradient-to-b from-gray-800 to-gray-900 text-white text-4xl font-bold py-3 px-4 rounded-lg min-w-[80px] shadow-lg border-b-4 border-gray-700;
            }
        
            .time-label {
                @apply text-sm font-medium text-gray-500 mt-2;
            }
        
            .time-separator {
                @apply text-4xl font-bold text-gray-400 self-start mt-3;
            }
        
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.5; }
            }
        
            .time-separator {
                animation: pulse 1s infinite;
            }
        </style>
        
        <script>
         document.addEventListener('DOMContentLoaded', function() {
            @if ($event->timeSchedule)
                const daysElement = document.getElementById('days');
                const hoursElement = document.getElementById('hours');
                const minutesElement = document.getElementById('minutes');
                const secondsElement = document.getElementById('seconds');
                const statusElement = document.getElementById('voting-status');
                const countdownLabel = document.getElementById('countdown-label');
        
                function updateCountdown() {
                    const now = new Date();
                    const start = new Date('{{ $start->format('Y-m-d H:i:s') }}');
                    const end = new Date('{{ $end->format('Y-m-d H:i:s') }}');
        
                    let timeLeft;
                    let isVotingOpen = false;
        
                    if (now < start) {
                        timeLeft = start - now;
                        countdownLabel.textContent = 'Time Until Voting Begins';
                    } else if (now >= start && now <= end) {
                        timeLeft = end - now;
                        countdownLabel.textContent = 'Time Until Voting Ends';
                        isVotingOpen = true;
                    } else {
                        timeLeft = 0;
                        countdownLabel.textContent = 'Voting Period Has Ended';
                    }
        
                    if (statusElement) {
                        if (isVotingOpen) {
                            statusElement.textContent = 'Voting Open';
                            statusElement.classList.remove('text-red-600');
                            statusElement.classList.add('text-green-600');
                        } else {
                            statusElement.textContent = 'Voting Closed';
                            statusElement.classList.remove('text-green-600');
                            statusElement.classList.add('text-red-600');
                        }
                    }
        
                    if (timeLeft > 0) {
                        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
        
                        daysElement.textContent = String(days).padStart(2, '0');
                        hoursElement.textContent = String(hours).padStart(2, '0');
                        minutesElement.textContent = String(minutes).padStart(2, '0');
                        secondsElement.textContent = String(seconds).padStart(2, '0');
                    } else {
                        daysElement.textContent = '00';
                        hoursElement.textContent = '00';
                        minutesElement.textContent = '00';
                        secondsElement.textContent = '00';
                    }
                }
        
                setInterval(updateCountdown, 1000);
                updateCountdown();
            @endif
        });
        </script>
       


            <div class="container mx-auto px-4 py-8">

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach ($event->contestants as $contestant)
                        <div class="w-full sm:w-auto">
                            <div
                                class="bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700">
                                <div class="flex justify-end px-4 pt-4">
                                    <!-- Dropdown button -->

                                    <!-- Dropdown menu -->
                                    <div class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700"
                                        id="dropdown{{ $contestant->id }}">
                                        <ul class="py-2" aria-labelledby="dropdownButton{{ $contestant->id }}">
                                            <li>
                                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                    href="#">Edit</a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                    href="#">Export Data</a>
                                            </li>
                                            <li>
                                                <form
                                                    class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                                    method="POST"
                                                    action="{{ route('contestants.destroy', $contestant->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center pb-6 pt-4">
                                    <h5 class="mb-1 text-lg font-medium text-gray-900 dark:text-white animate-grow">
                                        #{{ $contestant->number }}</h5>
                                    <img class="w-32 h-32 mb-3 rounded-full shadow-lg"
                                        src="{{ asset($contestant->profile) }}" alt="{{ $contestant->name }}">
                                    <h5 class="mb-1 text-lg font-medium text-gray-900 dark:text-white animate-slideIn">
                                        {{ $contestant->name }}</h5>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Contestant</span>
                                    <div class="flex mt-4">
                                        <form class="ml-2" method="POST" action="{{ route('vote', $contestant->id) }}">
                                            @csrf
                                            <input name="event_id" type="hidden" value="{{ $event->id }}">
                                            <button
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 gap-1"
                                                type="submit"><i class="fa-regular fa-thumbs-up"></i> Vote</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection



@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "{{ session('error') }}",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Pay",
                denyButtonText: `Don't Pay`
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('pricing_vote') }}";
                } else if (result.isDenied) {
                    Swal.fire("You can still view contestants but cannot vote.", "", "info");
                }
            });
        });
    </script>
@endif

@if (session('time_error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '<span class="text-xl font-bold">Voting Time Notice</span>',
                html: `
                    <div class="mb-4">
                        <i class="fas fa-clock text-yellow-500 text-4xl mb-3"></i>
                        <p class="text-gray-700 mt-3 font-medium">${"{{ session('time_error') }}"}</p>
                    </div>
                `,
                icon: false,
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-shopping-cart mr-2"></i>Purchase Votes',
                denyButtonText: `<i class="fas fa-eye mr-2"></i>View Only`,
                cancelButtonText: '<i class="fas fa-arrow-left mr-2"></i>Back',
                confirmButtonColor: '#10B981', // Green
                denyButtonColor: '#6B7280', // Gray
                cancelButtonColor: '#EF4444', // Red
                customClass: {
                    popup: 'rounded-xl shadow-2xl',
                    title: 'border-b pb-3 text-gray-800',
                    htmlContainer: 'text-center py-4',
                    actions: 'gap-2',
                    confirmButton: 'rounded-lg px-4 py-2 font-semibold transition-all hover:scale-105',
                    denyButton: 'rounded-lg px-4 py-2 font-semibold transition-all hover:scale-105',
                    cancelButton: 'rounded-lg px-4 py-2 font-semibold transition-all hover:scale-105'
                },
                backdrop: `
                    rgba(0,0,0,0.4)
                    left top
                    no-repeat
                `
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading animation
                    Swal.fire({
                        title: 'Redirecting to Payment',
                        html: 'Please wait...',
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    }).then(() => {
                        window.location.href = "{{ route('pricing_vote') }}";
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'View Only Mode',
                        html: `
                            <div class="text-center">
                                <i class="fas fa-eye text-blue-500 text-3xl mb-3"></i>
                                <p class="text-gray-600">You can still view contestants but cannot vote at this time.</p>
                                <p class="text-sm text-gray-500 mt-2">Come back during voting hours!</p>
                            </div>
                        `,
                        icon: false,
                        confirmButtonText: 'Understood',
                        confirmButtonColor: '#3B82F6',
                        customClass: {
                            popup: 'rounded-xl',
                            title: 'text-xl font-bold text-gray-800'
                        }
                    });
                }
            });
        });
    </script>

    <style>
        .swal2-popup {
            padding: 1.5rem;
        }

        .swal2-title {
            margin-bottom: 0.5rem !important;
        }

        .swal2-html-container {
            margin: 1rem 0 !important;
        }

        .swal2-actions {
            margin-top: 1rem !important;
        }

        .swal2-confirm,
        .swal2-deny,
        .swal2-cancel {
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
        }

        .swal2-confirm:focus,
        .swal2-deny:focus,
        .swal2-cancel:focus {
            box-shadow: none !important;
        }

        /* Animation for the popup */
        .swal2-show {
            animation: sweetalert-show 0.3s;
        }

        @keyframes sweetalert-show {
            0% {
                transform: scale(0.9);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Animation for icons */
        .fa-clock {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endif
