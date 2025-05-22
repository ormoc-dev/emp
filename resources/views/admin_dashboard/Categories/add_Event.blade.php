@extends('layouts.admin_layout')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@section('content')
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
<div class="sm:hidden">
    <label class="sr-only" for="tabs">Select your country</label>
    <select
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        id="tabs">
        <option>Profile</option>
        <option>Dashboard</option>
        <option>setting</option>
        <option>Invoioce</option>
    </select>
</div>
<ul
    class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400">
    <li class="w-full focus-within:z-10">
        <a class="inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none dark:bg-gray-700 dark:text-white"
            href="{{route('events.create')}}" aria-current="page">
            <span class="box_hand"> <i class="fa-regular fa-hand-point-right"></i></span>
            ADD EVENTS
        </a>
    </li>
    <li class="w-full focus-within:z-10">
        <a class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            href="{{route('register_judge')}}">ASSIGN JUDGE</a>
    </li>
    <li class="w-full focus-within:z-10">
        <a class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            href="{{route('select.event')}}">ADD CONTESTANTS</a>
    </li>
    <li class="w-full focus-within:z-10">
        <a class="inline-block w-full p-4 bg-white border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            href="{{route('selectS.event')}}">ADD CRITERIA</a>
    </li>
</ul>

@if (session('success'))
<div id="alert-3"
    class="flex items-center p-4 mb-0 mt-3 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
    role="alert">
    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <span class="sr-only">Info</span>
    <div class="ms-3 text-sm font-medium">
        Success alert! {{ session('success') }}.
    </div>
    <button type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
        data-dismiss-target="#alert-3" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>
@endif
@if (session('error'))
<div id="alert-2"
    class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
    role="alert">
    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <span class="sr-only">Info</span>
    <div class="ms-3 text-sm font-medium">
        Error alert! <a href="#" class="font-semibold underline hover:no-underline">example link</a>.
        {{ session('error') }}.
    </div>
    <button type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
        data-dismiss-target="#alert-2" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>
@endif



<div class="flex">
    <div class="w-1/2 mt-12 pr-12">
        <form class="max-w-lg mx-auto" id="addEvent" method="POST" action="{{ url('/events/create/store') }}">
            @csrf
            <!-- Event Name -->
            <div class="relative z-0 w-full mb-5 group">
                <input
                    class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer focus:placeholder-gray-500 focus-within:text-gray-500"
                    id="event_name" name="event_name" type="text" placeholder=" " required />
                <label
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    for="event_name">Event
                    Name</label>
            </div>
            <!-- Event Subtitle -->
            <div class="relative z-0 w-full mb-5 group">
                <textarea
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer focus:placeholder-gray-500 focus-within:text-gray-900"
                    id="event_subtitle" name="event_subtitle" placeholder=" " required></textarea>
                <label
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    for="event_subtitle">Event Subtitle</label>
            </div>


            <!-- Event Rounds -->
            <div class="relative z-0 w-full mb-5 group">
                <input
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer focus:placeholder-gray-500 focus-within:text-gray-900"
                    id="event_rounds" name="event_rounds" type="number" placeholder=" " required />
                <label
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    for="event_rounds">Event
                    Rounds</label>
            </div>
            <!-- Event Year -->
            <div class="relative z-0 w-full mb-5 group">
                <input
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer focus:placeholder-gray-500 focus-within:text-gray-900"
                    id="event_year" name="event_year" type="number" placeholder=" " required />
                <label
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    for="event_year">Event
                    Year</label>
            </div>
            <!-- Date Start -->
            <div class="relative z-0 w-full mb-5 group">
                <input
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer focus:placeholder-gray-500 focus-within:text-gray-900"
                    id="date_start" name="date_start" type="date" placeholder=" " required />
                <label
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    for="date_start">Date
                    Start</label>
            </div>
            <!-- Date End -->
            <div class="relative z-0 w-full mb-5 group">
                <input
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer focus:placeholder-gray-500 focus-within:text-gray-900"
                    id="date_end" name="date_end" type="date" placeholder=" " required />
                <label
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    for="date_end">Date
                    End</label>
            </div>
            <!-- Event Venue -->
            <div class="relative z-0 w-full mb-5 group">
                <input
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer focus:placeholder-gray-500 focus-within:text-gray-900"
                    id="event_venue" name="event_venue" type="text" placeholder=" " required />
                <label
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    for="event_venue">Event
                    Venue</label>
            </div>

            <!-- Submit Button -->
            <button
                class="text-white bg-blue-500 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium  text-sm w-full sm:w-auto px-5 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="submit">Submit
                <i class="fa-regular fa-circle-check"></i></button>

        </form>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
                $('#addEvent').on('submit', function(event) {
                    event.preventDefault();
                    jQuery.ajax({
                        url: "{{ url('/events/create/store') }}",
                        data: jQuery('#addEvent').serialize(),
                        type: 'post',
                        success: function(result) {
                            jQuery('#addEvent')[0].reset();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Your work has been saved",
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Append the new event to the table without reloading
                            let newEvent = result.event;
                            let eventRow = `
                                <tr>
                                    <td>${newEvent.id}</td>
                                    <td>${newEvent.event_name}</td>
                                    <td>${newEvent.event_venue}</td>
                                    <td class="flex gap-1">
                                        <form id="delete-form-${newEvent.id}"
                                            action="/events/${newEvent.id}"
                                            method="POST">
                                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="bg-red-400 hover:bg-red-600 text-white pl-2 pr-2 rounded-sm delete-btn py-2"
                                                type="button" onclick="confirmDelete(${newEvent.id})">
                                                <i class="fa-solid fa-trash-can-arrow-up"></i>
                                            </button>
                                        </form>
                                        <button class="bg-blue-400 hover:bg-blue-600 text-white pl-2 pr-2 rounded-sm delete-btn py-2"
                                            data-drawer-target="drawer-right-example"
                                            data-drawer-show="drawer-right-example" data-drawer-placement="right"
                                            type="button" aria-controls="drawer-right-example">
                                           <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                    </td>
                                </tr>`;
                            document.querySelector('.table tbody').insertAdjacentHTML('beforeend',
                                eventRow);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'There was an error adding the event.',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                            console.error(error);
                        }
                    });
                });

                window.confirmDelete = function(eventId) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + eventId).submit();
                        }
                    });
                };
            });
    </script>










    <!--Tables-->

    <div class="flex-1 pt-14" id="events-container">
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Added Events</h3>
                    <input id="myInput" class=" border-none rounded-lg bg-opacity-10 " type="text" name="keyword"
                        placeholder="Search...">
                    <script>
                        $(document).ready(function() {
                              $('#myTable').DataTable({
                                  "paging": true,
                                  "searching": false,
                                  "lengthChange": true,
                                  "pageLength": 10,
                                  "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
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
                <div class="overflow-x-auto">
                    <table class="table table-xs" id="myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Event & Venue</th>
                               
                                <th class="pr-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div>
                                        <span class="block text-sm font-semibold">{{ $event->event_name }}</span>
                                        <span class="block text-xs text-gray-400">{{ $event->event_venue }}</span>
                                    </div>
                                </td>
                                <td class="flex gap-1 ">
                                    <form id="delete-form-{{ $event->id }}"
                                        action="{{ route('events.destroy', $event->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="bg-red-400 hover:bg-red-600 text-white pl-2 pr-2 rounded-sm delete-btn py-2"
                                            type="button" onclick="confirmDelete({{ $event->id }})">
                                            <i class="fa-solid fa-trash-can-arrow-up"></i>
                                        </button>
                                    </form>
                                    <button
                                        class="bg-blue-400 hover:bg-blue-600 text-white pl-2 pr-2 rounded-sm delete-btn py-2"
                                        data-drawer-target="drawer-right-example"
                                        data-drawer-show="drawer-right-example" data-drawer-placement="right"
                                        type="button" aria-controls="drawer-right-example">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>



    <script>
        function confirmDelete(eventId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + eventId).submit();
                    }
                });
            }
    </script>

</div>



<!-- drawer component -->
<div class="fixed top-4 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-96 dark:bg-gray-800"
    id="drawer-right-example" aria-labelledby="drawer-right-label" tabindex="-1">
    <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400"
        id="drawer-right-label">
        Edit Event
    </h5>
    <button
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
        data-drawer-hide="drawer-right-example" type="button" aria-controls="drawer-right-example">
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
        <span class="sr-only">Close menu</span>
    </button>
    <form id="editEventForm" class="mb-6">
        @csrf
        <input type="hidden" id="event_id" name="event_id">
        <div class="mb-6">
            <label for="edit_event_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event
                Name</label>
            <input type="text" id="edit_event_name" name="event_name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter Event name" required>
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <textarea
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer focus:placeholder-gray-500 focus-within:text-gray-900"
                id="edit_event_subtitle" name="event_subtitle" placeholder=" " required></textarea>
            <label
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                for="event_subtitle">Event Subtitle</label>
        </div>
        <div class="mb-6">
            <label for="edit_event_venue" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event
                Venue</label>
            <input type="text" id="edit_event_venue" name="event_venue"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter Event venue" required>
        </div>
        <div class="mb-6">
            <label for="edit_event_rounds"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rounds</label>
            <input type="number" id="edit_event_rounds" name="event_rounds"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter rounds" required>
        </div>
        <div class="mb-6">
            <label for="edit_event_year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event
                Year</label>
            <input type="number" id="edit_event_year" name="event_year"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter Year" required>
        </div>
        <div class="mb-6">
            <label for="edit_date_start" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date
                Start</label>
            <input type="date" id="edit_date_start" name="date_start"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter Start Date" required>
        </div>
        <div class="mb-6">
            <label for="edit_date_end" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date
                End</label>
            <input type="date" id="edit_date_end" name="date_end"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter End Date" required>
        </div>
        <button type="submit"
            class="text-white justify-center flex items-center bg-blue-700 hover:bg-blue-800 w-full focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            <i class="fa-solid fa-file-pen"></i>
            Update Event
        </button>
    </form>
</div>
<script>
    $(document).ready(function () {
    // Handle Edit Button Click
    $('button[data-drawer-show="drawer-right-example"]').on('click', function () {
        var eventId = $(this).closest('tr').find('form').attr('id').split('-')[2];
        $.ajax({
            url: '/events/' + eventId + '/edit',
            type: 'GET',
            success: function (data) {
                // Populate the form fields with the event data
                $('#event_id').val(data.id);
                $('#edit_event_name').val(data.event_name);
                $('#edit_event_subtitle').val(data.event_subtitle);
                $('#edit_event_venue').val(data.event_venue);
                $('#edit_event_rounds').val(data.event_rounds);
                $('#edit_event_year').val(data.event_year);
                $('#edit_date_start').val(data.date_start);
                $('#edit_date_end').val(data.date_end);
            },
            error: function () {
                Swal.fire({
                    title: 'Error!',
                    text: 'Unable to fetch event data.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        });
    });

    // Handle Form Submission for Update
    $('#editEventForm').on('submit', function (e) {
        e.preventDefault();
        var eventId = $('#event_id').val();
        $.ajax({
            url: '/events/' + eventId,
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });

                // Update the event row in the table
                var updatedRow = `
                    <td>${response.event.id}</td>
                    <td>${response.event.event_name}</td>
                    <td>${response.event.event_venue}</td>
                    <td class="flex gap-1">
                        <form id="delete-form-${response.event.id}" action="/events/${response.event.id}" method="POST">
                            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="bg-red-400 hover:bg-red-600 text-white pl-2 pr-2 rounded-sm delete-btn" type="button" onclick="confirmDelete(${response.event.id})">
                                <i class='bx bx-trash'></i>
                            </button>
                        </form>
                        <button class="bg-blue-400 hover:bg-blue-600 text-white pl-2 pr-2 rounded-sm delete-btn" data-drawer-show="drawer-right-example" type="button">
                            <i class='bx bx-edit'></i>
                        </button>
                    </td>`;
                $('#myTable tr').filter(function() {
                    return $(this).find('form').attr('id') === 'delete-form-' + eventId;
                }).html(updatedRow);
            },
            error: function () {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error updating the event.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        });
    });
});

</script>
@endsection