@extends('layouts.admin_layout')

@section('content')

<div class="navbar rounded-lg p-4 bg-white text-gray-500 mb-6">
    <div class="navbar-start">
        <a class="text-xl font-semibold">SEARCH EVENTS</a>
    </div>
    <div class="navbar-end">
        <div class="flex items-center">
            <input type="text" id="myInput" placeholder="Enter Event" class="border border-gray-300 text-gray-900 md:w-64 mb-2 md:mb-0 md:mr-4 text-sm rounded-lg p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" />
        </div>
    </div>
</div>

<div class="p-4" id="myDIV">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($events as $event)
        <div class="event-card bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden transform transition-all hover:scale-105">
            <a href="#">
                <!-- Carousel with horizontal scroll -->
                <div class="overflow-x-auto flex ">
                    @if($event->contestants->isNotEmpty())
                        @foreach ($event->contestants as $contestant)
                        <div class="flex-none w-1/5 ">
                            <img src="{{ asset($contestant->profile) }}" alt="{{ $contestant->name }} Image"
                             class="object-cover  h-40 w-full ">
                        </div>
                        @endforeach
                    @else
                        <div class="flex items-center justify-center h-40 w-full bg-gray-100">
                            <p class="text-gray-500">No contestants available</p>
                        </div>
                    @endif
                </div>
            </a>
            <div class="p-6">
                <a href="#">
                    <h5 class="text-lg font-semibold text-gray-900 mb-2">{{ $event->event_name }}</h5>
                </a>
                <p class="bg-yellow-100 text-yellow-800 text-xs font-medium inline-block px-2 py-1 rounded mb-2">{{ $event->event_venue }}</p>
                <div class="flex justify-between items-center text-xs text-gray-500">
                    <p class="bg-green-100 text-green-800 px-2 py-1 rounded">Start: {{ $event->date_start }}</p>
                    <p class="bg-red-100 text-red-800 px-2 py-1 rounded">End: {{ $event->date_end }}</p>
                </div>
        
                <div class="mt-4">
                    <a href="{{ route('events.judge_scores', $event->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600  hover:bg-blue-700 focus:ring-4 transition-all">
                        View Results
                        <svg class="w-4 h-4 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".event-card").filter(function() {
                $(this).toggle($(this).find("h5").text().toLowerCase().indexOf(value) > -1 ||
                               $(this).find("p").text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>

@endsection
