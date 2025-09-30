@extends('layouts.admin_layout')

@section('content')
    <ul
        class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400">
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none "
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

    <div class="container mx-auto p-4">



        <div class="container mx-auto p-4">
            <h3
                class="bg-blue-200 text-center text-blue-800 text-xl font-semibold my-2 me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-blue-400">
                Rounds Scores</h3>
            <div id="accordion-parent" data-accordion="collapse">
                @foreach ($rounds as $round)
                    <h2 id="accordion-heading-{{ $loop->index }}">
                        <button
                            class="flex items-center justify-between w-full p-5 font-medium text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                            data-accordion-target="#accordion-body-{{ $loop->index }}" type="button" aria-expanded="false"
                            aria-controls="accordion-body-{{ $loop->index }}">
                            <span><i class='bx bx-receipt'></i> {{ $round->round_description }}</span>
                            <svg class="w-3 h-3 rotate-180 shrink-0" data-accordion-icon aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div class="hidden" id="accordion-body-{{ $loop->index }}"
                        aria-labelledby="accordion-heading-{{ $loop->index }}">
                        <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <div id="accordion-nested-collapse-{{ $loop->index }}" data-accordion="collapse">
                                @foreach ($allJudges as $judge)
                                    <h2
                                        id="accordion-nested-collapse-heading-{{ $loop->parent->index }}-{{ $loop->index }}">
                                        <button
                                            class="flex items-center justify-between w-full p-5 rounded-t-xl font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                            data-accordion-target="#accordion-nested-collapse-body-{{ $loop->parent->index }}-{{ $loop->index }}"
                                            type="button" aria-expanded="false"
                                            aria-controls="accordion-nested-collapse-body-{{ $loop->parent->index }}-{{ $loop->index }}">
                                            <span class="flex items-center">

                                                <span class="truncate">{{ $judge->name }}</span>
                                            </span>
                                            <svg class="w-3 h-3 rotate-180 shrink-0" data-accordion-icon aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M9 5 5 1 1 5" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div class="hidden"
                                        id="accordion-nested-collapse-body-{{ $loop->parent->index }}-{{ $loop->index }}"
                                        aria-labelledby="accordion-nested-collapse-heading-{{ $loop->parent->index }}-{{ $loop->index }}">
                                        <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                                            <p class="text-gray-500 dark:text-gray-400">Table for results</p>
                                            <div id="table-round-{{ $round->id }}-judge-{{ $judge->id }}">
                                                <div class="w-full overflow-x-auto">
                                                    <table
                                                        class="table table-xs min-w-full bg-white border border-gray-200 mb-4">
                                                        <thead>
                                                            <tr>
                                                                <th class="px-4 py-2 border-b">Category</th>
                                                                <th class="px-4 py-2 border-b">Contestant</th>
                                                                @php
                                                                    $hiddenForJudge =
                                                                        $hiddenCriteriaByJudge[$judge->id] ?? [];
                                                                @endphp
                                                                @foreach ($round->criteria as $criteria)
                                                                    @if (!in_array($criteria->id, $hiddenForJudge))
                                                                        <th class="px-6 py-3 border-b">
                                                                            {{ $criteria->criteria_description }}</th>
                                                                    @endif
                                                                @endforeach
                                                                <th class="px-4 py-2 border-b">Total Score</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($scores[$round->id] ?? [] as $contestantId => $contestantScores)
                                                                @php
                                                                    $contestant = $contestantScores->first()
                                                                        ->contestant;
                                                                    $judgeScores = $contestantScores->where(
                                                                        'user_id',
                                                                        $judge->id,
                                                                    );
                                                                    $totalScore = 0;
                                                                @endphp
                                                                <tr>
                                                                    <td class="px-4 py-2 border-b">
                                                                        {{ $contestant->category ?? 'N/A' }}
                                                                    </td>
                                                                    <td class="px-4 py-2 border-b">
                                                                        {{ $contestant->number }}
                                                                        {{ $contestant->name }}</td>
                                                                    @foreach ($round->criteria as $criteria)
                                                                        @if (!in_array($criteria->id, $hiddenForJudge))
                                                                            @php
                                                                                $criteriaScore = $judgeScores->firstWhere(
                                                                                    'criteria_id',
                                                                                    $criteria->id,
                                                                                );
                                                                                $rate = $criteriaScore
                                                                                    ? $criteriaScore->rate
                                                                                    : 'N/A';
                                                                                if ($rate !== 'N/A') {
                                                                                    $totalScore += $rate;
                                                                                }
                                                                            @endphp
                                                                            <td class="px-4 py-2 border-b">
                                                                                @if ($rate === 'N/A')
                                                                                    <span
                                                                                        class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">{{ $rate }}</span>
                                                                                @else
                                                                                    {{ $rate }}
                                                                                @endif
                                                                            </td>
                                                                        @endif
                                                                    @endforeach
                                                                    <td
                                                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                                                        {{ $totalScore }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <form class="mt-2" method="POST" action="{{ route('print.table') }}"
                                                target="_blank">
                                                @csrf
                                                <input name="tableContent" type="hidden" value="">
                                                <input name="title" type="hidden" value="">
                                                <button
                                                    class="px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700"
                                                    type="button"
                                                    onclick="submitPrint('table-round-{{ $round->id }}-judge-{{ $judge->id }}', 'Round: {{ $round->round_description }} - Judge: {{ $judge->name }}')">
                                                    Print this table
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                                @if (!isset($scores[$round->id]))
                                    <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                        role="alert">
                                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                        </svg>
                                        <span class="sr-only">Info</span>
                                        <div>
                                            <span class="font-medium">Danger alert!</span> No scores available for this
                                            round.
                                        </div>

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($minorAwards->isNotEmpty())
                    <h3
                        class="bg-yellow-200 text-center text-yellow-800 text-xl font-semibold my-2 me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400">
                        Minor Awards Scores</h3>

                    @foreach ($minorAwards as $minorAward)
                        <h2 id="accordion-heading-minor-{{ $loop->index }}">
                            <button
                                class="flex items-center justify-between w-full p-5 font-medium text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                data-accordion-target="#accordion-body-minor-{{ $loop->index }}" type="button"
                                aria-expanded="false" aria-controls="accordion-body-minor-{{ $loop->index }}">
                                <span><i class='bx bx-award'></i> {{ $minorAward->minor_awards_description }}</span>
                                <svg class="w-3 h-3 rotate-180 shrink-0" data-accordion-icon aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                            </button>
                        </h2>
                        <div class="hidden" id="accordion-body-minor-{{ $loop->index }}"
                            aria-labelledby="accordion-heading-minor-{{ $loop->index }}">
                            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                @foreach ($allJudges as $judge)
                                    <div class="flex items-center">

                                        <span class="truncate">{{ $judge->name }}</span>
                                    </div>
                                    <div id="table-minor-{{ $minorAward->id }}-judge-{{ $judge->id }}">
                                        <div class="w-full overflow-x-auto">
                                            <table class="table table-xs min-w-full bg-white border border-gray-200 mb-4">
                                                <thead>
                                                    <tr>

                                                        <th class="px-4 py-2 border-b">Category</th>
                                                        <th class="px-4 py-2 border-b">Contestant</th>
                                                        <th class="px-4 py-2 border-b">Score</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($minorAwardScores[$minorAward->id][$judge->id] ?? [] as $contestantScores)
                                                        @foreach ($contestantScores as $minorAwardScore)
                                                            @php
                                                                $contestant = $minorAwardScore->contestant; // Ensure contestant is correctly set
                                                            @endphp
                                                            <tr>
                                                                <td class="px-4 py-2 border-b">
                                                                    {{ $contestant->category ?? 'N/A' }}
                                                                </td>
                                                                <td class="px-4 py-2 border-b">
                                                                    {{ $minorAwardScore->contestant->number }}
                                                                    {{ $minorAwardScore->contestant->name }}</td>
                                                                <td
                                                                    class="px-4 py-2 border-b  bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                                                    @if ($minorAwardScore)
                                                                        {{ $minorAwardScore->rate }}
                                                                    @else
                                                                        <span
                                                                            class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">N/A</span>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <form class="mt-2 mb-6" method="POST" action="{{ route('print.table') }}"
                                        target="_blank">
                                        @csrf
                                        <input name="tableContent" type="hidden" value="">
                                        <input name="title" type="hidden" value="">
                                        <button
                                            class="px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700"
                                            type="button"
                                            onclick="submitPrint('table-minor-{{ $minorAward->id }}-judge-{{ $judge->id }}', 'Minor Award: {{ $minorAward->minor_awards_description }} - Judge: {{ $judge->name }}')">
                                            Print this table
                                        </button>
                                    </form>
                                    @if (empty($minorAwardScores[$minorAward->id][$judge->id]))
                                        <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                            role="alert">
                                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                            </svg>
                                            <span class="sr-only">Info</span>
                                            <div>
                                                <span class="font-medium">Danger alert!</span>No scores available for this
                                                judge.
                                            </div>

                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>


        <script>
            function submitPrint(containerId, title) {
                const container = document.getElementById(containerId);
                if (!container) return;
                const tableHtml = container.innerHTML;
                const form = event.target.closest('form');
                form.querySelector('input[name="tableContent"]').value = tableHtml;
                form.querySelector('input[name="title"]').value = title;
                form.submit();
            }
        </script>
    @endsection

    @push('scripts')
    @endpush
