@extends('layouts.admin_layout')

@section('content')
    @if (session('success'))
        <div class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            id="alert-3" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="text-sm font-medium ms-3">
                Success alert! {{ session('success') }}.
            </div>
            <button
                class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-3" type="button" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            id="alert-2" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="text-sm font-medium ms-3">
                Error alert! <a class="font-semibold underline hover:no-underline" href="#">example link</a>.
                {{ session('error') }}.
            </div>
            <button
                class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-2" type="button" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif

    <!--Tables-->


    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Started or Not-started</h3>
                <input class="ml-24 border-none rounded-lg  bg-opacity-10" id="myInput" name="keyword" type="text"
                    placeholder="Search...">
                <script>
                    $(document).ready(function() {
                        $('#myTable').DataTable({
                            "paging": true,
                            "searching": false,
                            "lengthChange": true,
                            "pageLength": 10,
                            "lengthMenu": [
                                [5, 10, 25, 50, -1],
                                [5, 10, 25, 50, "All"]
                            ],
                        });
                        $("#myInput").on("keyup", function() {
                            var value = $(this).val().toLowerCase();
                            $("#myTable tr").filter(function() {
                                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                            });
                        });
                    });
                </script>
                <i class='bx bx-filter'></i>

            </div>
            <table class="table table-xs order-column" id="myTable">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Venue</th>
                        <th>Date</th>
                        <th>Action</th>
                    
                    </tr>
                </thead>
                <tbody>
                    <style>
                        
                    </style>
                    @foreach ($events as $event)
                        <tr>
                            <td>
                                <p>{{ $event->event_name }}</p>
                            </td>
                            <td>
                                <p>{{ $event->event_venue }}</p>
                            </td>
                            <td>{{ $event->date_start }}</td>
                            <td class="flex gap-1">
                                <form action="{{ route('events.toggle', ['id' => $event->id]) }}" method="POST">
                                    @csrf
                                    <button
                                    class="bg-{{ $event->event_status == 'started' ? 'green' : 'red' }}-400 hover:bg-{{ $event->event_status == 'started' ? 'green' : 'red' }}-600 text-white text-center rounded-full w-10 text-lg toggle-status-btn"
                                    type="submit">
                                    <i class="fa-solid fa-power-off"></i>
                                </button>
                                </form>
                            </td>
                          
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    </div>
@endsection
