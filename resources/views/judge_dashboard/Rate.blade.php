@extends('layouts.judgeRate')

@section('content')
    <style>
        .card-bg {
            background-image: url('{{ asset('img/sh1.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
    <nav class="bg-white border-b-2 border-red-400">
        <form id="rateForm" action="{{ route('submit_rates') }}" method="POST">
            @csrf
            <input name="event_id" type="hidden" value="{{ $event->id }}">
            <input name="user_id" type="hidden" value="{{ auth()->id() }}">

            <div class="flex flex-wrap items-center justify-between max-w-screen-xl p-4 mx-auto space-y-4">
                <!-- Minor Awards Selection -->
                @if ($nextMinorAward)
                    <div class="w-full mb-4 sm:w-auto sm:mb-0">
                        <label class="block mb-1 text-sm font-semibold text-gray-700" for="minor_award_id">Minor
                            Award:</label>
                        <input name="minor_award_id" type="hidden" value="{{ $nextMinorAward->id }}">
                        <div></div>
                    </div>
                @endif

                <!-- Round Selection (only show if no minor awards left) -->
                @if (!$nextMinorAward && $currentRound)
                    <div class="w-full mb-4 sm:w-auto sm:mb-0">
                        <label class="block mb-1 text-sm font-semibold text-gray-700" for="round_id"></label>
                        <input name="round_id" type="hidden" value="{{ $currentRound->id }}">
                        <div></div>
                    </div>
                @endif

                <div class="flex flex-col w-full text-center">
                    <h2 class="mb-2 text-sm font-bold tracking-wide text-red-600 uppercase">Rate Information</h2>
                    <h2 class="mt-1 text-2xl font-medium text-gray-700">
                        @if ($nextMinorAward)
                            Minor Awards
                            <br>
                            <span class="block text-3xl font-extrabold leading-tight text-gray-900">
                                {{ $nextMinorAward->minor_awards_description }} <span
                                    class="block mt-2 text-2xl text-gray-600">
                                    Lowest: {{ $nextMinorAward->low_rate }} Highest: {{ $nextMinorAward->high_rate }}
                                </span>
                            </span>
                        @elseif ($currentRound)
                            {{ $currentRound->round_description }}
                        @else
                            <div class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                id="alert-additional-content-2" role="alert">
                                <div class="flex items-center">
                                    <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <h3 class="text-lg font-medium"><span class="text-red-500">No more ratings left for this
                                            event.</span></h3>
                                </div>
                                <div class="mt-2 mb-4 text-sm">
                                    You have successfully completed voting for this event. Thank you for your participation!
                                    If there are more events or rounds, you can proceed to the next one. If not, please
                                    check the results section for updates or contact the event organizer if you have any
                                    questions.
                                    Your feedback is valuable and helps in the smooth conduct of the event.
                                </div>

                                <div class="flex">
                                    <a href="{{ route('select.event_in_judges') }}">
                                        <button
                                            class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                            type="button">
                                            <i class='bx bx-arrow-back'></i>
                                            Back
                                        </button>

                                    </a>

                                    <button
                                        class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800"
                                        data-dismiss-target="#alert-additional-content-2" type="button" aria-label="Close">
                                        Dismiss
                                    </button>
                                </div>
                            </div>
                        @endif
                    </h2>
                </div>
            </div>
    </nav>

    <section class="p-2 text-gray-600 body-font">
        <div class="container px-5 py-12 mx-auto">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Female Contestants -->
            @if ($contestants->where('category', 'female')->count() > 0)
                <h3 class="text-lg font-bold ">Female Category</h3>
                <div class="h-1 mb-6 overflow-hidden rounded bg-gray-50">
                    <div class="w-[500px] h-full bg-red-500"></div>
                </div>

                <div
                    class="grid grid-cols-1 gap-6 {{ $nextMinorAward ? 'sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5' : 'md:grid-cols-3' }}">
                    @foreach ($contestants->where('category', 'female') as $contestant)
                        @if ($nextMinorAward)
                            <!-- Original card layout for minor awards -->
                            <div
                                class="overflow-hidden transition-all duration-300 rounded-lg shadow-lg card-bg hover:shadow-xl">
                                <div class="relative">
                                    <img class="w-full object-contain aspect-[3/3.8]"
                                        src="{{ asset($contestant->profile) }}" alt="{{ $contestant->name }}">
                                    <div class="absolute top-0 left-0 right-0 p-2 text-white bg-black bg-opacity-50">
                                        <h2 class="text-xl font-semibold">{{ $contestant->name }}</h2>
                                    </div>
                                    <div
                                        class="absolute px-2 py-1 font-bold text-red-800 bg-yellow-200 rounded-full top-2 right-2 text-md">
                                        #{{ $contestant->number }}
                                    </div>
                                </div>
                                <div class="p-4">
                                    <input name="rates[{{ $contestant->id }}][contestant_id]" type="hidden"
                                        value="{{ $contestant->id }}">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-gray-700">
                                                {{ $nextMinorAward->minor_awards_description }}:
                                            </label>
                                            <input
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md rate-input focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                                name="rates[{{ $contestant->id }}][rate]" type="number" step="0.01"
                                                min="{{ $nextMinorAward->low_rate }}"
                                                max="{{ $nextMinorAward->high_rate }}" required
                                                placeholder="Rate ({{ $nextMinorAward->low_rate }}-{{ $nextMinorAward->high_rate }})">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Side-by-side layout for rounds -->
                            <div
                                class="overflow-hidden transition-all duration-300 rounded-lg shadow-lg card-bg hover:shadow-xl">
                                <div class="flex">
                                    <!-- Left side - Contestant Image and Info -->
                                    <div class="relative w-1/2">
                                        <img class="object-cover w-full h-full" src="{{ asset($contestant->profile) }}"
                                            alt="{{ $contestant->name }}">
                                        <div class="absolute top-0 left-0 right-0 p-2 text-white bg-black bg-opacity-50">
                                            <h2 class="text-xl font-semibold">{{ $contestant->name }}</h2>
                                        </div>
                                        <div
                                            class="absolute px-2 py-1 font-bold text-white bg-red-500 rounded-full top-2 right-2 text-md">
                                            #{{ $contestant->number }}
                                        </div>
                                    </div>

                                    <!-- Right side - Inputs -->
                                    <div class="w-1/2 p-4 bg-white bg-opacity-90">
                                        <input name="rates[{{ $contestant->id }}][contestant_id]" type="hidden"
                                            value="{{ $contestant->id }}">
                                        <div class="space-y-3">
                                            @foreach ($currentRound->criteria as $criteria)
                                                @if (
                                                    !$criteria->is_hidden &&
                                                        (!$criteria->relationLoaded('hiddenJudges') || !$criteria->hiddenJudges->contains(auth()->id())))
                                                    <div>
                                                        <label class="block mb-1 text-sm font-medium text-gray-700">
                                                            {{ $criteria->criteria_description }}
                                                        </label>
                                                        <input
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md rate-input focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                                            name="rates[{{ $contestant->id }}][criteria][{{ $criteria->id }}][rate]"
                                                            type="number" step="0.01"
                                                            min="{{ $criteria->lowest_rate }}"
                                                            max="{{ $criteria->highest_rate }}" required
                                                            placeholder="{{ $criteria->lowest_rate }} - {{ $criteria->highest_rate }}">
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            <!-- Separation Line -->
            @if ($contestants->where('category', 'female')->count() > 0 && $contestants->where('category', 'male')->count() > 0)
                <hr class="my-8 border-t-2 ">
            @endif

            <!-- Male Contestants -->
            @if ($contestants->where('category', 'male')->count() > 0)
                <h3 class="text-lg font-bold ">Male Category</h3>
                <div class="h-1 mb-6 overflow-hidden rounded bg-gray-50">
                    <div class="w-[500px] h-full bg-red-500"></div>
                </div>
                <div
                    class="grid grid-cols-1 gap-6 {{ $nextMinorAward ? 'sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5' : 'md:grid-cols-3' }}">
                    @foreach ($contestants->where('category', 'male') as $contestant)
                        @if ($nextMinorAward)
                            <!-- Original card layout for minor awards -->
                            <div
                                class="overflow-hidden transition-all duration-300 rounded-lg shadow-lg card-bg hover:shadow-xl">
                                <div class="relative">
                                    <img class="w-full object-contain aspect-[3/3.8]"
                                        src="{{ asset($contestant->profile) }}" alt="{{ $contestant->name }}">
                                    <div class="absolute top-0 left-0 right-0 p-2 text-white bg-black bg-opacity-50">
                                        <h2 class="text-xl font-semibold">{{ $contestant->name }}</h2>
                                    </div>
                                    <div
                                        class="absolute px-2 py-1 font-bold text-red-800 bg-yellow-200 rounded-full top-2 right-2 text-md">
                                        #{{ $contestant->number }}
                                    </div>
                                </div>
                                <div class="p-4">
                                    <input name="rates[{{ $contestant->id }}][contestant_id]" type="hidden"
                                        value="{{ $contestant->id }}">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-gray-700">
                                                {{ $nextMinorAward->minor_awards_description }}:
                                            </label>
                                            <input
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md rate-input focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                                name="rates[{{ $contestant->id }}][rate]" type="number" step="0.01"
                                                min="{{ $nextMinorAward->low_rate }}"
                                                max="{{ $nextMinorAward->high_rate }}" required
                                                placeholder="Rate ({{ $nextMinorAward->low_rate }}-{{ $nextMinorAward->high_rate }})">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Side-by-side layout for rounds -->
                            <div
                                class="overflow-hidden transition-all duration-300 rounded-lg shadow-lg card-bg hover:shadow-xl">
                                <div class="flex">
                                    <!-- Left side - Contestant Image and Info -->
                                    <div class="relative w-1/2">
                                        <img class="object-cover w-full h-full" src="{{ asset($contestant->profile) }}"
                                            alt="{{ $contestant->name }}">
                                        <div class="absolute top-0 left-0 right-0 p-2 text-white bg-black bg-opacity-50">
                                            <h2 class="text-xl font-semibold">{{ $contestant->name }}</h2>
                                        </div>
                                        <div
                                            class="absolute px-2 py-1 font-bold text-white bg-red-500 rounded-full top-2 right-2 text-md">
                                            #{{ $contestant->number }}
                                        </div>
                                    </div>

                                    <!-- Right side - Inputs -->
                                    <div class="w-1/2 p-4 bg-white bg-opacity-90">
                                        <input name="rates[{{ $contestant->id }}][contestant_id]" type="hidden"
                                            value="{{ $contestant->id }}">
                                        <div class="space-y-3">
                                            @foreach ($currentRound->criteria as $criteria)
                                                @if (
                                                    !$criteria->is_hidden &&
                                                        (!$criteria->relationLoaded('hiddenJudges') || !$criteria->hiddenJudges->contains(auth()->id())))
                                                    <div>
                                                        <label class="block mb-1 text-sm font-medium text-gray-700">
                                                            {{ $criteria->criteria_description }}
                                                        </label>
                                                        <input
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md rate-input focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                                            name="rates[{{ $contestant->id }}][criteria][{{ $criteria->id }}][rate]"
                                                            type="number" step="0.01"
                                                            min="{{ $criteria->lowest_rate }}"
                                                            max="{{ $criteria->highest_rate }}" required
                                                            placeholder="{{ $criteria->lowest_rate }} - {{ $criteria->highest_rate }}">
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            <!-- Contestants Without Category -->
            @if ($contestants->whereNull('category')->count() > 0)
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    @foreach ($contestants->whereNull('category') as $contestant)
                        <div
                            class="overflow-hidden transition-all duration-300 rounded-lg shadow-lg card-bg hover:shadow-xl">
                            <div class="flex">
                                <!-- Left side - Contestant Image and Info -->
                                <div class="relative w-1/2">
                                    <img class="object-cover w-full h-full" src="{{ asset($contestant->profile) }}"
                                        alt="{{ $contestant->name }}">
                                    <div class="absolute top-0 left-0 right-0 p-2 text-white bg-black bg-opacity-50">
                                        <h2 class="text-xl font-semibold">{{ $contestant->name }}</h2>
                                    </div>
                                    <div
                                        class="absolute px-2 py-1 font-bold text-white bg-red-500 rounded-full top-2 right-2 text-md">
                                        #{{ $contestant->number }}
                                    </div>
                                </div>

                                <!-- Right side - Inputs -->
                                <div class="w-1/2 p-4 bg-white bg-opacity-90">
                                    <input name="rates[{{ $contestant->id }}][contestant_id]" type="hidden"
                                        value="{{ $contestant->id }}">
                                    <div class="space-y-3">
                                        @if ($nextMinorAward)
                                            <div>
                                                <label class="block mb-1 text-sm font-medium text-gray-700">
                                                    {{ $nextMinorAward->minor_awards_description }}
                                                </label>
                                                <input
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md rate-input focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                                    name="rates[{{ $contestant->id }}][rate]" type="number"
                                                    step="0.01" min="{{ $nextMinorAward->low_rate }}"
                                                    max="{{ $nextMinorAward->high_rate }}" required
                                                    placeholder="Rate ({{ $nextMinorAward->low_rate }}-{{ $nextMinorAward->high_rate }})">
                                            </div>
                                        @elseif ($currentRound)
                                            @foreach ($currentRound->criteria as $criteria)
                                                @if (
                                                    !$criteria->is_hidden &&
                                                        (!$criteria->relationLoaded('hiddenJudges') || !$criteria->hiddenJudges->contains(auth()->id())))
                                                    <div>
                                                        <label class="block mb-1 text-sm font-medium text-gray-700">
                                                            {{ $criteria->criteria_description }}
                                                        </label>
                                                        <input
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md rate-input focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                                            name="rates[{{ $contestant->id }}][criteria][{{ $criteria->id }}][rate]"
                                                            type="number" step="0.01"
                                                            min="{{ $criteria->lowest_rate }}"
                                                            max="{{ $criteria->highest_rate }}" required
                                                            placeholder="{{ $criteria->lowest_rate }} - {{ $criteria->highest_rate }}">
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="flex justify-center mt-16">
                <button
                    class="flex items-center justify-center px-6 py-3 font-bold text-white transition duration-300 ease-in-out transform bg-red-600 rounded-lg shadow-lg hover:bg-red-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                    id="submitButton" type="submit">
                    <span id="buttonText">Submit Ratings</span>
                    <svg class="hidden w-5 h-5 ml-2 text-white animate-spin" id="loadingIcon"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </button>
            </div>

            <script>
                document.getElementById('rateForm').addEventListener('submit', function() {
                    var button = document.getElementById('submitButton');
                    var buttonText = document.getElementById('buttonText');
                    var loadingIcon = document.getElementById('loadingIcon');

                    button.disabled = true;
                    buttonText.textContent = 'Submitting...';
                    loadingIcon.classList.remove('hidden');
                });
            </script>

        </div>
    </section>

    </form>
@endsection
