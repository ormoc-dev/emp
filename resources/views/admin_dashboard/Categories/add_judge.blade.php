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
                        <i class='bx bx-filter'></i> <i class="fa-solid fa-sort-down"></i>
                        <div>

                            <a class="inline-block" data-modal-target="add-judge-modal"
                                data-modal-toggle="add-judge-modal">
                                <i class="fa-solid text-green-500 fa-user-plus hover:text-green-500"></i>
                            </a>


                            <!-- Main modal -->
                            <div class="hidden  overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0
                             justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full   "
                                id="add-judge-modal" data-modal-backdrop="static" aria-hidden="true" tabindex="-1"
                                style="z-index: 9999;">
                                <!-- Increased max-width for better content fit -->
                                <div class="relative p-4 w-full max-w-4xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow ">
                                        <!-- Modal header -->

                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5">
                                            <form method="POST" action="{{ route('register_judge.store') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <!-- Two-column layout for basic info -->
                                                <div class="grid md:grid-cols-2 gap-4 mb-5">
                                                    <div>
                                                        <!-- Judge Name Input -->
                                                        <div class="relative z-0 w-full mb-5 group">
                                                            <input
                                                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                                id="name" name="name" type="text"
                                                                value="{{ old('name') }}" required autocomplete="name"
                                                                autofocus />
                                                            <label
                                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                                                for="name">Judge Name</label>
                                                            @error('name')
                                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <!-- Email Input -->
                                                        <div class="relative z-0 w-full mb-5 group">
                                                            <input
                                                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                                id="email" name="email" type="email"
                                                                value="{{ old('email') }}" required />
                                                            <label
                                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                                                for="email">Email (@wlcormoc.edu.ph)</label>
                                                            @error('email')
                                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <!-- Password Input -->
                                                        <div class="relative z-0 w-full mb-5 group">
                                                            <input
                                                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                                id="password" name="password" type="password"
                                                                required />
                                                            <label
                                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                                                for="password">Password</label>
                                                            @error('password')
                                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                        <!-- Confirm Password Input -->
                                                        <div class="relative z-0 w-full mb-5 group">
                                                            <input
                                                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                                id="password-confirm" name="password_confirmation"
                                                                type="password" required />
                                                            <label
                                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                                                for="password-confirm">Confirm Password</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Hidden Level Select -->
                                                <input name="level" type="hidden" value="judge">
                                                <!-- Profile Upload -->
                                                <div class="mb-5">
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                        for="profile">Profile Image (Optional)</label>
                                                    <input
                                                        class="file-input file-input-bordered file-input-sm w-full max-w-xs"
                                                        id="profile" name="profile" type="file" accept="image/*" />
                                                    @error('profile')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <!-- Biography Input -->
                                                <div class="mb-5">
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                        for="biography">Biography</label>
                                                    <select
                                                        class="mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        id="biography-template" onchange="updateBiography()">
                                                        <option value="">Select a template or write custom</option>
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

                                                    <textarea
                                                        class="block w-full text-sm text-gray-900 bg-transparent border-2 border-gray-300 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                        id="biography" name="biography" rows="4"
                                                        placeholder="Enter judge's biography, background, and expertise...">{{ old('biography') }}</textarea>
                                                    @error('biography')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <!-- Achievements Input -->
                                                <div class="mb-5">
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                        for="achievements">Achievements & Awards</label>
                                                    <select
                                                        class="mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                        id="achievements-template" onchange="updateAchievements()">
                                                        <option value="">Select a template or write custom</option>
                                                        <option
                                                            value="• Best Judge Award (National Beauty Pageant Association)
• Certified International Beauty Pageant Judge
• Member of the Professional Beauty Association
• Featured Judge in Major Regional Competitions">
                                                            Beauty Pageant Awards</option>
                                                        <option
                                                            value="• Excellence in Judging Award
• Certified Event Judge (International Events Association)
• Distinguished Service Award in Cultural Events
• Regional Judge of the Year">
                                                            Event Judge Awards</option>
                                                        <option
                                                            value="• Industry Leadership Award
• Professional Achievement in Entertainment
• Outstanding Contribution to Performing Arts
• Celebrity Judge Recognition">
                                                            Entertainment Industry Awards</option>
                                                        <option
                                                            value="• Fashion Industry Excellence Award
• Style Icon Recognition
• Professional Fashion Judge Certification
• International Fashion Week Judge">
                                                            Fashion Industry Awards</option>
                                                        <option value="custom">Write Custom Achievements</option>
                                                    </select>

                                                    <textarea
                                                        class="block w-full text-sm text-gray-900 bg-transparent border-2 border-gray-300 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                        id="achievements" name="achievements" rows="4"
                                                        placeholder="Enter judge's achievements, awards, and recognitions...">{{ old('achievements') }}</textarea>
                                                    @error('achievements')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <script>
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
                                                <!-- Submit Button -->
                                                <div>
                                                    <button
                                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                        data-modal-hide="add-judge-modal" type="button">
                                                        close
                                                    </button>
                                                    <button
                                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                        type="submit">
                                                        <i
                                                            class="fa-solid fa-user-check mr-2"></i>{{ __('Register Judge') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Edit Judge
                                        </h3>
                                        <button
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="edit-judge-modal" type="button">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5 space-y-4">
                                        <form id="edit-judge-form" method="POST" action=""
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="relative z-0 w-full mb-5 group">
                                                <input
                                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                    id="edit-name" name="name" type="text" required />
                                                <label
                                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                                    for="edit-name">Judge Name</label>
                                            </div>
                                            <div class="relative z-0 w-full mb-5 group">
                                                <input
                                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                    id="edit-email" name="email" type="email" required />
                                                <label
                                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                                    for="edit-email">Email</label>
                                            </div>
                                            <div class="relative z-0 w-full mb-5 group">
                                                <label
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    for="edit-profile">Profile Image</label>
                                                <input
                                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                    id="edit-profile" name="profile" type="file" accept="image/*">
                                                <img class="mt-2 w-20 h-20 object-cover rounded-full hidden"
                                                    id="current-profile" src="" alt="Current Profile">
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal footer -->
                                    <div
                                        class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                        <button
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            form="edit-judge-form" type="submit"><i class="fa-solid fa-file-pen"></i>
                                            Update Judge</button>
                                        <button
                                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                            data-modal-hide="edit-judge-modal" type="button"><i
                                                class="fa-solid fa-xmark"></i> Cancel</button>
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
            <div class="head">
                <h3>Assign Events</h3>
                <input class="border-none rounded-lg bg-opacity-10" id="myInput" name="keyword" type="text"
                    placeholder="Search...">
                <i class='bx bx-filter'></i>
            </div>
            <div class="overflow-x-auto">
                <form id="multiple-delete-form" action="{{ route('event-judges.multiple-destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <table class="table table-xs" id="myTable">
                        <thead>
                            <tr>
                                <th>
                                    <input
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                        id="select-all-checkbox" type="checkbox">
                                </th>
                                <th>ID</th>
                                <th>Judge Name</th>
                                <th>Event Name</th>
                                <th>Event Venue</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eventJudges as $eventJudge)
                                <tr>
                                    <td>
                                        <input
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                            name="selected_items[]" type="checkbox" value="{{ $eventJudge->id }}">
                                    </td>
                                    <td>{{ $eventJudge->id }}</td>
                                    <td>{{ $eventJudge->judge->name }}</td>
                                    <td>{{ $eventJudge->event->event_name }}</td>
                                    <td>{{ $eventJudge->event->event_venue }}</td>
                                    <td>{{ $eventJudge->judge->created_at }}</td>
                                    <td class="flex gap-2">
                                        <button
                                            class="bg-red-400 hover:bg-red-600 text-white pl-2 pr-2 rounded-sm delete-btn"
                                            type="button" onclick="confirmDelete({{ $eventJudge->id }})">
                                            <i class="fa-solid fa-trash-can-arrow-up"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="button"
                            onclick="confirmMultipleDelete()">
                            <i class="fa-solid fa-trash-can-arrow-up"></i> Delete Selected
                        </button>
                    </div>
                </form>
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
@endsection
