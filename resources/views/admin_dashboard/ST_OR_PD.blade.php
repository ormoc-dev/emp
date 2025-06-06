@extends('layouts.admin_layout')

@section('content')
@if (session('success'))
<x-alert type="success" :message="session('success')" />
@endif

@if (session('error'))
<x-alert type="error" :message="session('error')" />
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
                            <td>{{ $event->created_at }}</td>
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
