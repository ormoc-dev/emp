@extends('layouts.admin_layout')
@section('content')
    <!-- Page Title and Breadcrumb -->
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
            <a class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                href="{{ route('events.create') }}" aria-current="page">ADD EVENTS</a>
        </li>
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none dark:bg-gray-700 dark:text-white"
                href="{{ route('register_judge') }}"> <span class="box_hand"> <i
                        class="fa-regular fa-hand-point-right"></i></span>ASSIGN JUDGE</a>
        </li>
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                href="{{ route('select.event') }}">ADD CONTESTANTS</a>
        </li>
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 bg-white border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                href="{{ route('selectS.event') }}">ADD CRITERIA</a>
        </li>
    </ul>


    @if (session('success'))
        <div class="flex items-center p-4 mb-0 mt-3 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            id="alert-3" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
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
            <div class="ms-3 text-sm font-medium">
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

    <div class="flex">
        <!-- Form Section -->
        <div class="w-full p-2 mt-8">
            <form action="{{ route('event_judge.store') }}" method="POST">
                @csrf
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8">
                    <table class="w-full text-sm text-left rtl:text-right bg-gray-50 text-gray-500 dark:text-gray-400"
                        id="myTable-events">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="p-4" scope="col">
                                    <div class="flex items-center">
                                        <input
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                            id="checkbox-all-search" type="checkbox">
                                        <label class="sr-only" for="checkbox-all-search">checkbox</label>
                                    </div>
                                </th>
                                <th class="px-6 py-3" scope="col">Event Name</th>
                                <th class="px-6 py-3" scope="col">Event Venue</th>
                                <th class="px-6 py-3" scope="col">Event Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                id="checkbox-table-search-{{ $event->id }}" name="events[]"
                                                type="checkbox" value="{{ $event->id }}">
                                            <label class="sr-only"
                                                for="checkbox-table-search-{{ $event->id }}">checkbox</label>
                                        </div>
                                    </td>
                                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                        scope="row">
                                        {{ $event->event_name }}
                                    </th>
                                    <td class="px-6 py-4">{{ $event->event_venue }}</td>
                                    <td class="px-6 py-4">{{ $event->event_status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <script>
                    $(document).ready(function() {
                        $('#myTable-events').DataTable({
                            "paging": true,
                            "searching": true,
                            "lengthChange": true,
                            "pageLength": 3,
                            "lengthMenu": [5, 10, 25, 50, 100],
                            "language": {
                                "search": "Search events:"
                            },
                            "columnDefs": [{
                                "orderable": false,
                                "targets": 0
                            }],
                            "order": [
                                [1, 'asc']
                            ]
                        });

                        // Handle "select all" checkbox for events
                        $('#checkbox-all-search').on('change', function() {
                            var isChecked = this.checked;
                            $('#myTable-events tbody input[type="checkbox"]').each(function() {
                                this.checked = isChecked;
                            });
                        });
                    });
                </script>


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-gray-50"
                        id="myTable-judge-assign">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="p-4" scope="col">
                                    <div class="flex items-center">
                                        <input
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                            id="checkbox-all-search-judges" type="checkbox">
                                        <label class="sr-only" for="checkbox-all-search-judges">checkbox</label>
                                    </div>
                                </th>
                                <th class="px-6 py-3" scope="col">Judge Name</th>
                                <th class="px-6 py-3" scope="col">Email</th>
                                <th class="px-6 py-3" scope="col">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($judges as $judge)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                id="checkbox-table-search-{{ $judge->id }}" name="judges[]"
                                                type="checkbox" value="{{ $judge->id }}">
                                            <label class="sr-only"
                                                for="checkbox-table-search-{{ $judge->id }}">checkbox</label>
                                        </div>
                                    </td>
                                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                        scope="row">
                                        {{ $judge->name }}
                                    </th>
                                    <td class="px-6 py-4">{{ $judge->email }}</td>
                                    <td class="px-6 py-4">{{ $judge->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <script>
                    $(document).ready(function() {
                        $('#myTable-judge-assign').DataTable({
                            "paging": true,
                            "searching": true,
                            "lengthChange": true,
                            "pageLength": 3,
                            "lengthMenu": [5, 10, 25, 50, 100],
                            "language": {
                                "search": "Search judges:"
                            },
                            "columnDefs": [{
                                "orderable": false,
                                "targets": 0
                            }],
                            "order": [
                                [1, 'asc']
                            ]
                        });

                        // Handle "select all" checkbox
                        $('#checkbox-all-search-judges').on('change', function() {
                            var isChecked = this.checked;
                            $('#myTable-judge-assign tbody input[type="checkbox"]').each(function() {
                                this.checked = isChecked;
                            });
                        });
                    });
                </script>

                <div class="mt-4">
                    <button
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                        type="submit">
                        <i class="fa-solid fa-person-arrow-down-to-line"></i> Assign Judges to Events
                    </button>
                </div>
            </form>
        </div>



        <!-- Judges Table Section -->
        <div class="flex-1 pt-14 w-full">
           
            <div class="table-data">
              
                <div class="order">
                    <div class="flex flex-col md:flex-grid justify-between  mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Added Judges</h3>
                        <p class="text-sm text-gray-500 mt-1">Manage judge assignments for different events</p>
                    </div>
                   
                    <div class="head">

                        <input class="border-none rounded-lg bg-opacity-10" id="myInput-for-added-judges" name="keyword"
                            type="text" placeholder="Search...">
                        <script>
                            $(document).ready(function() {
                                // Initialize DataTables with pagination and custom length menu
                                $('#myTable-judge').DataTable({
                                    "paging": true,
                                    "searching": false,
                                    "lengthChange": true,
                                    "pageLength": 10,
                                    "lengthMenu": [5, 10, 25, 50, 100],
                                });

                                // Custom search functionality
                                $("#myInput-for-added-judges").on("keyup", function() {
                                    var value = $(this).val().toLowerCase();
                                    $("#myTable-judge tr").filter(function() {
                                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                    });
                                });
                            });
                        </script>
                        <div>

                            <!-- Add Judge Button -->
                            <button
                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-sm transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                data-modal-target="add-judge-modal" data-modal-toggle="add-judge-modal">
                                <i class="fa-solid fa-user-plus text-lg"></i>
                                <span class="font-medium">Add </span>
                            </button>


                            <!-- Main modal -->
                            <div class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
                                id="add-judge-modal" data-modal-backdrop="static" aria-hidden="true" tabindex="-1">
                                <div class="relative p-4 w-full max-w-4xl">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-xl shadow-2xl">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between p-2 border-b rounded-t">
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                Register New Judge
                                            </h3>
                                            <button
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                data-modal-hide="add-judge-modal" type="button">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>

                                        <!-- Modal body with fixed height and scrollable content -->
                                        <div class="p-6 h-[500px] overflow-y-auto">
                                            <form class="space-y-6" method="POST"
                                                action="{{ route('register_judge.store') }}"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <!-- Profile Section -->
                                                <div class="bg-gray-50 rounded-xl p-4 mb-6 border border-gray-100">
                                                    <div class="flex flex-col md:flex-row items-center gap-8">
                                                        <!-- Profile Image Upload -->
                                                        <div class="relative group">
                                                            <div
                                                                class="w-40 h-40 rounded-xl overflow-hidden shadow-lg border-4 border-white bg-gradient-to-br from-gray-100 to-gray-200">
                                                                <!-- Default Background Pattern -->
                                                                <div
                                                                    class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAzNGMwLTIuMjA5IDEuNzkxLTQgNC00czQgMS43OTEgNCA0LTEuNzkxIDQtNCA0LTQtMS43OTEtNC00eiIgZmlsbD0iI2U1ZTdlYiIvPjxwYXRoIGQ9Ik0yNCAyNGMwLTIuMjA5IDEuNzkxLTQgNC00czQgMS43OTEgNCA0LTEuNzkxIDQtNCA0LTQtMS43OTEtNC00eiIgZmlsbD0iI2U1ZTdlYiIvPjxwYXRoIGQ9Ik00OCAyNGMwLTIuMjA5IDEuNzkxLTQgNC00czQgMS43OTEgNCA0LTEuNzkxIDQtNCA0LTQtMS43OTEtNC00eiIgZmlsbD0iI2U1ZTdlYiIvPjxwYXRoIGQ9Ik0zNiAxMmMwLTIuMjA5IDEuNzkxLTQgNC00czQgMS43OTEgNCA0LTEuNzkxIDQtNCA0LTQtMS43OTEtNC00eiIgZmlsbD0iI2U1ZTdlYiIvPjxwYXRoIGQ9Ik0yNCA0OGMwLTIuMjA5IDEuNzkxLTQgNC00czQgMS43OTEgNCA0LTEuNzkxIDQtNCA0LTQtMS43OTEtNC00eiIgZmlsbD0iI2U1ZTdlYiIvPjxwYXRoIGQ9Ik00OCA0OGMwLTIuMjA5IDEuNzkxLTQgNC00czQgMS43OTEgNCA0LTEuNzkxIDQtNCA0LTQtMS43OTEtNC00eiIgZmlsbD0iI2U1ZTdlYiIvPjwvZz48L3N2Zz4=')] opacity-50">
                                                                </div>

                                                                <!-- Profile Image -->
                                                                <img class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110 relative z-10"
                                                                    id="profile-preview"
                                                                    src="{{ asset('images/default-profile.png') }}"
                                                                    alt="Profile Preview"
                                                                    onerror="this.onerror=null; this.src=''; this.classList.add('hidden');">

                                                                <!-- Upload Overlay -->
                                                                <div
                                                                    class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4 z-20">
                                                                    <label
                                                                        class="cursor-pointer flex items-center gap-2 text-white text-sm font-medium hover:text-blue-200 transition-colors"
                                                                        for="profile">
                                                                        <i class="fas fa-camera text-lg"></i>
                                                                        <span>Change Photo</span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <!-- Upload Input -->
                                                            <input class="hidden" id="profile" name="profile"
                                                                type="file" accept="image/*"
                                                                onchange="previewImage(this)">

                                                            <!-- Upload Status -->
                                                            <div class="mt-2 text-center text-xs text-gray-500"
                                                                id="upload-status">
                                                                No file chosen
                                                            </div>
                                                        </div>

                                                        <!-- Profile Information -->
                                                        <div class="flex-1 space-y-4">
                                                            <div>
                                                                <h4 class="text-xl font-semibold text-gray-900 mb-1">
                                                                    Profile Photo (Optional)</h4>
                                                                <p class="text-sm text-gray-600">Add a professional photo
                                                                    of the judge to help with identification.</p>
                                                            </div>

                                                            <!-- Upload Guidelines -->
                                                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                                                <h5 class="text-sm font-medium text-gray-900 mb-2">Upload
                                                                    Guidelines:</h5>
                                                                <ul class="text-xs text-gray-600 space-y-1">
                                                                    <li class="flex items-center gap-2">
                                                                        <i class="fas fa-check-circle text-green-500"></i>
                                                                        <span>Recommended size: 400x400 pixels</span>
                                                                    </li>
                                                                    <li class="flex items-center gap-2">
                                                                        <i class="fas fa-check-circle text-green-500"></i>
                                                                        <span>Maximum file size: 2MB</span>
                                                                    </li>
                                                                    <li class="flex items-center gap-2">
                                                                        <i class="fas fa-check-circle text-green-500"></i>
                                                                        <span>Supported formats: JPG, PNG, GIF</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Basic Information -->
                                                <div class="grid md:grid-cols-2 gap-6">
                                                    <!-- Left Column -->
                                                    <div class="space-y-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1"
                                                                for="name">Full Name</label>
                                                            <input
                                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                id="name" name="name" type="text"
                                                                value="{{ old('name') }}" required
                                                                placeholder="Enter judge's full name">
                                                            @error('name')
                                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                        </div>

                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1"
                                                                for="email">Email Address</label>
                                                            <div class="relative">
                                                                <input
                                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                    id="email" name="email" type="email"
                                                                    value="{{ old('email') }}" required
                                                                    placeholder="username@wlcormoc.edu.ph">

                                                            </div>
                                                            @error('email')
                                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Right Column -->
                                                    <div class="space-y-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1"
                                                                for="password">Password</label>
                                                            <div class="relative">
                                                                <input
                                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                    id="password" name="password" type="password"
                                                                    required placeholder="Enter password">
                                                                <button
                                                                    class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600"
                                                                    type="button" onclick="togglePassword('password')">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </div>
                                                            @error('password')
                                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                        </div>

                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1"
                                                                for="password-confirm">Confirm Password</label>
                                                            <div class="relative">
                                                                <input
                                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                    id="password-confirm" name="password_confirmation"
                                                                    type="password" required
                                                                    placeholder="Confirm password">
                                                                <button
                                                                    class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600"
                                                                    type="button"
                                                                    onclick="togglePassword('password-confirm')">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Biography Section -->
                                                <div class="space-y-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1"
                                                            for="biography-template">Biography Template (Optional)</label>
                                                        <select
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                            id="biography-template" onchange="updateBiography()">
                                                            <option value="">Select a template or write custom
                                                            </option>
                                                            <option
                                                                value="Is a distinguished professional with extensive experience in judging beauty pageants and cultural events. Known for fair evaluation and commitment to identifying authentic talent.">
                                                                Beauty Pageant Expert</option>
                                                            <option
                                                                value="Has served as a judge in numerous talent competitions, bringing years of expertise in performing arts and entertainment industry knowledge.">
                                                                Entertainment Industry Professional</option>
                                                            <option
                                                                value="An accomplished academic with expertise in cultural studies and event management, known for balanced and objective assessment approaches.">
                                                                Academic Professional</option>
                                                            <option
                                                                value="A respected figure in the fashion industry with experience in modeling and talent development, bringing valuable insights to contestant evaluation.">
                                                                Fashion Industry Professional</option>
                                                            <option value="custom">Write Custom Biography</option>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1"
                                                            for="biography">Biography (Optional)</label>
                                                        <textarea
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                            id="biography" name="biography" rows="4"
                                                            placeholder="Enter judge's biography, background, and expertise...">{{ old('biography') }}</textarea>
                                                        @error('biography')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Achievements Section -->
                                                <div class="space-y-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1"
                                                            for="achievements-template">Achievements Template
                                                            (Optional)</label>
                                                        <select
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                            id="achievements-template" onchange="updateAchievements()">
                                                            <option value="">Select a template or write custom
                                                            </option>
                                                            <option
                                                                value="• Best Judge Award (National Beauty Pageant Association)&#10;• Certified International Beauty Pageant Judge&#10;• Member of the Professional Beauty Association&#10;• Featured Judge in Major Regional Competitions">
                                                                Beauty Pageant Awards</option>
                                                            <option
                                                                value="• Excellence in Judging Award&#10;• Certified Event Judge (International Events Association)&#10;• Distinguished Service Award in Cultural Events&#10;• Regional Judge of the Year">
                                                                Event Judge Awards</option>
                                                            <option
                                                                value="• Industry Leadership Award&#10;• Professional Achievement in Entertainment&#10;• Outstanding Contribution to Performing Arts&#10;• Celebrity Judge Recognition">
                                                                Entertainment Industry Awards</option>
                                                            <option
                                                                value="• Fashion Industry Excellence Award&#10;• Style Icon Recognition&#10;• Professional Fashion Judge Certification&#10;• International Fashion Week Judge">
                                                                Fashion Industry Awards</option>
                                                            <option value="custom">Write Custom Achievements</option>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1"
                                                            for="achievements">Achievements & Awards (Optional)</label>
                                                        <textarea
                                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                            id="achievements" name="achievements" rows="4"
                                                            placeholder="Enter judge's achievements, awards, and recognitions...">{{ old('achievements') }}</textarea>
                                                        @error('achievements')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Hidden Level Input -->
                                                <input name="level" type="hidden" value="judge">

                                                <!-- Action Buttons -->
                                                <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                                                    <button
                                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        data-modal-hide="add-judge-modal" type="button">
                                                        Cancel
                                                    </button>
                                                    <button
                                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        type="submit">
                                                        <i class="fas fa-user-check mr-2"></i>Register Judge
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Judges Table -->
                    <div class="overflow-x-auto">
                        <table class="table table-xs" id="myTable-judge">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($judges as $judge)
                                    <tr>
                                        <td>{{ $judge->id }}</td>
                                        <td>{{ $judge->name }}</td>
                                        <td class="flex gap-1">
                                            <form action="{{ route('delete_judge', $judge->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="bg-red-400 hover:bg-red-600 text-white pl-2 pr-2 rounded-sm delete-btn"
                                                    type="submit">
                                                    <i class="fa-solid fa-trash-can-arrow-up"></i>
                                                </button>
                                            </form>
                                            <button class="bg-blue-400 hover:bg-blue-600 text-white pl-2 pr-2 rounded-sm"
                                                data-modal-target="edit-judge-modal" data-modal-toggle="edit-judge-modal"
                                                onclick="openEditModal({{ $judge->id }}, '{{ $judge->name }}', '{{ $judge->email }}')">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Edit Judge Modal -->
                        <div class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
                            id="edit-judge-modal" data-modal-backdrop="static" aria-hidden="true" tabindex="-1">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-xl shadow-2xl">
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900">
                                                Edit Judge Profile
                                            </h3>
                                            <p class="text-sm text-gray-500 mt-1">Update judge information and profile
                                                details</p>
                                        </div>
                                        <button class="text-gray-400 hover:text-gray-500 transition-colors"
                                            data-modal-hide="edit-judge-modal" type="button">
                                            <i class="fas fa-times text-xl"></i>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="p-6">
                                        <form id="edit-judge-form" method="POST" action=""
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <!-- Profile Image Section -->
                                            <div class="mb-6">
                                                <div class="flex items-center gap-6">
                                                    <div class="relative group">
                                                        <div
                                                            class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg bg-gradient-to-br from-gray-100 to-gray-200">
                                                            <img class="w-full h-full object-cover" id="current-profile"
                                                                src="" alt="Current Profile">
                                                        </div>
                                                        <div
                                                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 rounded-full flex items-center justify-center">
                                                            <label
                                                                class="cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                                                                for="edit-profile">
                                                                <i class="fas fa-camera text-white text-xl"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2"
                                                            for="edit-profile">
                                                            Profile Image
                                                        </label>
                                                        <input class="hidden" id="edit-profile" name="profile"
                                                            type="file" accept="image/*">
                                                        <p class="text-sm text-gray-500">Click the camera icon to change
                                                            profile photo</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Basic Information -->
                                            <div class="space-y-6">
                                                <!-- Name Field -->
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2"
                                                        for="edit-name">
                                                        Full Name
                                                    </label>
                                                    <input
                                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                        id="edit-name" name="name" type="text" required
                                                        placeholder="Enter judge's full name">
                                                </div>

                                                <!-- Email Field -->
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2"
                                                        for="edit-email">
                                                        Email Address
                                                    </label>
                                                    <input
                                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                        id="edit-email" name="email" type="email" required
                                                        placeholder="Enter judge's email address">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200">
                                        <button
                                            class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
                                            data-modal-hide="edit-judge-modal" type="button">
                                            <i class="fas fa-times mr-2"></i>
                                            Cancel
                                        </button>
                                        <button
                                            class="px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
                                            form="edit-judge-form" type="submit">
                                            <i class="fas fa-save mr-2"></i>
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="table-data">
        <div class="order">

            <div class="overflow-x-auto">
                <div class=" rounded-xl shadow-lg p-6">
                    <!-- Section Header -->
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Assign Events</h3>
                            <p class="text-sm text-gray-500 mt-1">Manage judge assignments for different events</p>
                        </div>

                        <!-- Search and Filter -->
                        <div class="flex items-center gap-4 mt-4 md:mt-0">
                            <div class="relative">
                                <input
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-64"
                                    id="myInput" name="keyword" type="text" placeholder="Search assignments...">
                                <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                            </div>
                            <button
                                class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class='bx bx-filter'></i>
                            </button>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <form id="multiple-delete-form" action="{{ route('event-judges.multiple-destroy') }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <table class="min-w-full divide-y divide-gray-200" id="myTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3" scope="col">
                                            <div class="flex items-center">
                                                <input
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                                    id="select-all-checkbox" type="checkbox">
                                            </div>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            scope="col">
                                            ID
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            scope="col">
                                            Judge Name
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            scope="col">
                                            Event Name
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            scope="col">
                                            Event Venue
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            scope="col">
                                            Created At
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            scope="col">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($eventJudges as $eventJudge)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <input
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                                        name="selected_items[]" type="checkbox"
                                                        value="{{ $eventJudge->id }}">
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                #{{ $eventJudge->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $eventJudge->judge->name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $eventJudge->event->event_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $eventJudge->event->event_venue }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $eventJudge->judge->created_at }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <button
                                                    class="text-red-600 hover:text-red-900 hover:bg-red-50 p-2 rounded-lg transition-colors"
                                                    type="button" onclick="confirmDelete({{ $eventJudge->id }})">
                                                    <i class="fa-solid fa-trash-can-arrow-up"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>

                    <!-- Bulk Actions -->
                    <div class="mt-4 flex justify-end">
                        <button
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                            type="button" onclick="confirmMultipleDelete()">
                            <i class="fa-solid fa-trash-can-arrow-up mr-2"></i>
                            Delete Selected
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


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

            $('#select-all-checkbox').change(function() {
                $('input[name="selected_items[]"]').prop('checked', this.checked);
            });
        });

        function confirmDelete(id) {
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
                    $.ajax({
                        url: '/event-judges/' + id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(result) {
                            if (result.success) {
                                Swal.fire(
                                    'Deleted!',
                                    result.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    result.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the event judge.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        function confirmMultipleDelete() {
            var selectedItems = $('input[name="selected_items[]"]:checked');
            if (selectedItems.length > 0) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to delete " + selectedItems.length +
                        " items. This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('multiple-delete-form').submit();
                    }
                });
            } else {
                Swal.fire(
                    'No items selected',
                    'Please select at least one item to delete.',
                    'info'
                );
            }
        }
    </script>

    <script>
        document.getElementById('checkbox-all-search').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="events[]"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        document.getElementById('checkbox-all-search-judges').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="judges[]"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    </script>

    <script>
        function openEditModal(id, name, email, profileUrl) {
            const modal = document.getElementById('edit-judge-modal');
            const form = document.getElementById('edit-judge-form');
            const nameInput = document.getElementById('edit-name');
            const emailInput = document.getElementById('edit-email');
            const currentProfileImg = document.getElementById('current-profile');

            form.action = `/judges/${id}`;
            nameInput.value = name;
            emailInput.value = email;

            if (profileUrl) {
                currentProfileImg.src = profileUrl;
                currentProfileImg.classList.remove('hidden');
            } else {
                currentProfileImg.classList.add('hidden');
            }

            // Use Flowbite's modal show method if available, otherwise fallback to showModal
            if (typeof flowbite !== 'undefined' && flowbite.Modal) {
                const modalInstance = new flowbite.Modal(modal);
                modalInstance.show();
            } else {
                modal.showModal();
            }
        }
    </script>

    <script>
        function previewImage(input) {
            const status = document.getElementById('upload-status');
            const preview = document.getElementById('profile-preview');

            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Validate file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    status.innerHTML = '<span class="text-red-500">File size exceeds 2MB limit</span>';
                    input.value = '';
                    return;
                }

                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    status.innerHTML =
                        '<span class="text-red-500">Invalid file type. Please upload JPG, PNG, or GIF</span>';
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    status.innerHTML = `<span class="text-green-500">${file.name}</span>`;
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
                status.innerHTML = 'No file chosen';
            }
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function updateBiography() {
            const template = document.getElementById('biography-template');
            const biography = document.getElementById('biography');

            if (template.value && template.value !== 'custom') {
                biography.value = template.value;
            } else if (template.value === 'custom') {
                biography.value = '';
                biography.focus();
            }
        }

        function updateAchievements() {
            const template = document.getElementById('achievements-template');
            const achievements = document.getElementById('achievements');

            if (template.value && template.value !== 'custom') {
                achievements.value = template.value;
            } else if (template.value === 'custom') {
                achievements.value = '';
                achievements.focus();
            }
        }
    </script>
@endsection
