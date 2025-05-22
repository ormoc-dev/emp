@extends('layouts.admin_layout')

@section('content')
    <ul
        class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400">
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none"
                href="{{ route('events.judge_scores', ['event' => $event->id]) }}" aria-current="page">
                <span class="box_hand"><i class='bx bxs-hand-right'></i></span> MONITOR JUDGE SCORES
            </a>
        </li>
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                href="{{ route('events.overall_scores', ['event' => $event->id]) }}">
                PRINT SCORES
            </a>
        </li>
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                href="{{ route('events.user_vote', ['event' => $event->id]) }}">
                USERS VOTE
            </a>
        </li>
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 bg-white border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                href="{{ route('approval', ['event' => $event->id]) }}">
                TIE APPROVAL
            </a>
        </li>
    </ul>
    @if (session('success'))
        <style>
            .swal2-confirm.swal2-styled {
                background-color: green !important;
                color: white !important;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Your work has been saved",
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
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            });
        </script>
    @endif

    
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3 class="text-xl font-semibold mb-4">Judges for this event:</h3>
                <input class="border-none rounded-lg bg-opacity-10 ml-24" id="myInput" name="keyword" type="text"
                    placeholder="Search...">
                <i class='bx bx-filter'></i>
            </div>
            <table class="table table-xs order-column w-full" id="myTable">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Name</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @if ($judges->count() > 0)
                        @foreach ($judges as $judge)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{ $judge->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <span>{{ $judge->email }}</span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <button
                                            class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-3 py-2 rounded-lg shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150 flex items-center"
                                            data-modal-target="judge-modal-{{ $judge->id }}"
                                            data-modal-toggle="judge-modal-{{ $judge->id }}" type="button">
                                            <i class='bx bx-message-square-dots mr-1'></i>
                                            <span>Send approval</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="py-3 px-6 text-center" colspan="3">No judges assigned to this event.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>



    @foreach ($judges as $judge)
        <!-- Modal for each judge -->
        <div class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden" id="judge-modal-{{ $judge->id }}"
            aria-hidden="true" tabindex="-1">
            <div class="relative w-full h-full max-w-4xl mx-auto flex items-center justify-center p-4">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 w-full max-h-[80vh] overflow-hidden">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Send to: {{ $judge->name }}
                        </h3>
                        <button
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="judge-modal-{{ $judge->id }}" type="button">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body with forms -->
                    <div class="p-4 space-y-4 overflow-y-auto" style="max-height: calc(90vh - 130px);">
                        <!-- Minor Awards Section -->
                        <div class="mb-4">
                            <h3 class="text-md font-semibold mb-2">Minor Awards</h3>
                            <form action="{{ route('judge-approvals.store') }}" method="POST">
                                @csrf
                                <input name="judge_id" type="hidden" value="{{ $judge->id }}">
                                <input name="event_id" type="hidden" value="{{ $event->id }}">
                                <input name="approval_type" type="hidden" value="minor_awards">
                                
                                @foreach ($minorAwards as $minorAward)
                                    <div class="mb-4">
                                        <h4 class="font-medium mt-3 mb-1 text-sm">{{ $minorAward->minor_awards_description }}</h4>
                                        <input name="minor_award_id" type="hidden" value="{{ $minorAward->id }}">
                                        <table class="w-full text-sm border-collapse">
                                            <thead>
                                                <tr>
                                                    <th class="px-2 py-1 border">Select</th>
                                                    <th class="px-2 py-1 border">Contestant</th>
                                                    <th class="px-2 py-1 border">Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $maleScores = $maleMinorAwardScores[$minorAward->id] ?? [];
                                                    $femaleScores = $femaleMinorAwardScores[$minorAward->id] ?? [];
                                                    $allScores = collect($maleScores)->merge($femaleScores)->sortByDesc('total');
                                                    $prevScore = null;
                                                @endphp
                                                @foreach ($allScores as $contestantId => $data)
                                                    @php
                                                        $isTied = ($prevScore !== null && $prevScore === $data['total']);
                                                        $prevScore = $data['total'];
                                                    @endphp
                                                    <tr class="{{ $isTied ? 'bg-red-100' : '' }}">
                                                        <td class="px-2 py-1 border">
                                                            <input name="minor_awards[{{ $minorAward->id }}][{{ $contestantId }}]" type="checkbox" value="1">
                                                        </td>
                                                        <td class="px-2 py-1 border">
                                                            {{ $data['contestant']->name }}
                                                        </td>
                                                        <td class="px-2 py-1 border">
                                                            {{ number_format($data['total'], 2) }}%
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                                
                                <button class="bg-blue-500 text-white px-4 py-2 rounded mt-2" type="submit">
                                    Send Minor Awards Approval
                                </button>
                            </form>
       
        
                        </div>

                        <!-- Overall Scores Section -->
                        <div class="mb-4">
                            <h3 class="text-md font-semibold mb-2">Overall Scores</h3>
                            <form action="{{ route('judge-approvals.store') }}" method="POST">
                                @csrf
                                <input name="judge_id" type="hidden" value="{{ $judge->id }}">
                                <input name="event_id" type="hidden" value="{{ $event->id }}">
                                <input name="approval_type" type="hidden" value="overall_scores">
                                <table class="w-full text-sm border-collapse">
                                    <!-- ... (keep the existing table header) ... -->
                                     <thead>
                                                <tr>
                                                    <th class="px-2 py-1 border">Select</th>
                                                    <th class="px-2 py-1 border">Contestant</th>
                                                    <th class="px-2 py-1 border">Score</th>
                                                </tr>
                                            </thead>
                                    <tbody>
                                        @php
                                            $prevScore = null;
                                            $tiedScore = null;
                                        @endphp
                                        @foreach ($overallMinorAwardScores as $contestantId => $data)
                                            @php
                                                if ($prevScore === $data['totalScore']) {
                                                    $tiedScore = $data['totalScore'];
                                                } elseif ($data['totalScore'] !== $tiedScore) {
                                                    $tiedScore = null;
                                                }
                                                $prevScore = $data['totalScore'];
                                            @endphp
                                            <tr class="{{ $tiedScore !== null ? 'bg-red-100' : '' }}">
                                                <td class="px-2 py-1 border">
                                                    <input name="overall_scores[]" type="checkbox"
                                                        value="{{ $contestantId }}">
                                                </td>
                                                <td class="px-2 py-1 border">
                                                    {{ $data['contestant'] }}
                                                </td>
                                                <td class="px-2 py-1 border">
                                                    {{ number_format($data['totalScore'], 2) }}%
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button class="bg-blue-500 text-white px-4 py-2 rounded mt-2" type="submit">Send Overall
                                    Scores Approval</button>
                            </form>
                        </div>

                        <!-- Rounds Section -->
                        <div class="mb-4">
                            <h3 class="text-md font-semibold mb-2">Round Scores</h3>
                            @foreach ($rounds as $round)
                                <h4 class="font-medium mt-3 mb-1 text-sm">{{ $round->round_description }}</h4>
                                <form action="{{ route('judge-approvals.store') }}" method="POST">
                                    @csrf
                                    <input name="judge_id" type="hidden" value="{{ $judge->id }}">
                                    <input name="event_id" type="hidden" value="{{ $event->id }}">
                                    <input name="approval_type" type="hidden" value="round_scores">
                                    <input name="round_id" type="hidden" value="{{ $round->id }}">
                                    <table class="w-full text-sm border-collapse">
                                        <!-- ... (keep the existing table header) ... -->
                                         <thead>
                                                <tr>
                                                    <th class="px-2 py-1 border">Select</th>
                                                    <th class="px-2 py-1 border">Contestant</th>
                                                    <th class="px-2 py-1 border">Score</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            @php
                                                $prevScore = null;
                                                $tiedScore = null;
                                                $roundScores = collect(
                                                    $combinedJudgesScores[$round->id] ?? [],
                                                )->sortByDesc('total');
                                            @endphp
                                            @foreach ($roundScores as $contestantId => $data)
                                                @php
                                                    if ($prevScore === $data['total']) {
                                                        $tiedScore = $data['total'];
                                                    } elseif ($data['total'] !== $tiedScore) {
                                                        $tiedScore = null;
                                                    }
                                                    $prevScore = $data['total'];
                                                @endphp
                                                <tr class="{{ $tiedScore !== null ? 'bg-red-100' : '' }}">
                                                    <td class="px-2 py-1 border">
                                                        <input name="round_scores[]" type="checkbox"
                                                            value="{{ $contestantId }}">
                                                    </td>
                                                    <td class="px-2 py-1 border">
                                                        {{ $data['contestant_name'] }}
                                                    </td>
                                                    <td class="px-2 py-1 border">
                                                        {{ number_format($data['total'], 2) }}%
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded mt-2" type="submit">Send
                                        {{ $round->round_description }} Approval</button>
                                </form>
                            @endforeach
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button class="bg-gray-500 text-white px-4 py-2 rounded"
                            data-modal-hide="judge-modal-{{ $judge->id }}" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
