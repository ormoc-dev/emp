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
            <a class="inline-block w-full p-4 bg-white border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                href="{{route('events.create')}}" aria-current="page"> ADD EVENT</a>
        </li>
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                href="{{route('register_judge')}}">ASSIGN JUDGES</a>
        </li>
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                href="{{route('select.event')}}">ADD CONTESTANT</a>
        </li>
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none dark:bg-gray-700 dark:text-white"
                href="{{route('selectS.event')}}"><span class="box_hand"> <i class="fa-regular fa-hand-point-right"></i></span> ADD
                CRITERIA</a>
        </li>
    </ul>



    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3><i class="fa-solid fa-database"></i> ADD CRITERIA</h3>
                <input class=" border-none rounded-lg bg-opacity-10 ml-24" id="myInput" name="keyword" type="text"
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
            <table class="table table-xs" id="myTable">
                <thead>
                    <tr>
                        <th>Events</th>
                        <th>Venue</th>
                        <th>Rounds</th>
                        <th>Contestants</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>
                                <p>{{ $event->event_name }}</p>
                            </td>
                            <td>
                                <p>{{ $event->event_venue }}</p>
                            </td>
                            <td>{{ $event->event_rounds }}</td>
                            <td>{{ $event->contestants->count() }}</td>
                            <td>{{ $event->created_at }}</td>
                            <td >
                                <a href="{{ route('rounds.create', $event->id) }}" >
                                    <i class="fa-solid fa-file-circle-plus text-green-500 hover:text-green-700 text-lg pl-6"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
