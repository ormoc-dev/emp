@extends('layouts.admin_layout')

@section('content')
    <ul
        class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400">
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                href="{{ route('events.judge_scores', ['event' => $event->id]) }}" aria-current="page">
                <span class="box_hand"><i class='bx bxs-hand-right'></i></span> MONITOR JUDGE SCORES
            </a>
        </li>
        <li class="w-full focus-within:z-10">
            <a class="inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none "
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
            <a class="inline-block w-full p-4 bg-white border-gray-200 border-s-0 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                href="{{ route('approval', ['event' => $event->id]) }}">
                TIE APPROVAL
            </a>
        </li>
    </ul>

    <div class="container p-4 mx-auto">
        @if ($hasMinorAwards)
            <h3
                class="bg-blue-200 text-blue-800 text-xl font-semibold my-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-blue-400 text-center">
                PRINT MINOR AWARDS SCORES
            </h3>
            <div id="accordion-open" data-accordion="open">
                @foreach ($minorAwards as $index => $minorAward)
                    <h2 id="accordion-open-heading-{{ $index }}">
                        <button
                            class="flex items-center justify-between w-full gap-3 p-5 font-medium text-gray-500 border border-b-0 border-gray-200 rtl:text-right rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                            data-accordion-target="#accordion-open-body-{{ $index }}" type="button"
                            aria-expanded="false" aria-controls="accordion-open-body-{{ $index }}">
                            <span class="flex items-center">
                                {{ $minorAward->minor_awards_description }}
                            </span>
                            <svg class="w-3 h-3 rotate-180 shrink-0" data-accordion-icon aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div class="hidden" id="accordion-open-body-{{ $index }}"
                        aria-labelledby="accordion-open-heading-{{ $index }}">
                        <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <!-- Male Winner Table -->
                           

                            @if (isset($maleMinorAwardScores[$minorAward->id]))
                                @php
                                    $scores = $maleMinorAwardScores[$minorAward->id] ?? [];
                                    $numberOfJudges = $judges->count(); // Assuming $judges is a collection of judges
                                    $sortedScores = collect($scores)->sortByDesc(function ($score) use (
                                        $numberOfJudges,
                                    ) {
                                        return $score ? $score->sum('rate') / $numberOfJudges : 0; // Divide by the number of judges to get average score
                                    });
                                    $topContestantId = $sortedScores->keys()->first();
                                    $topContestantScores = $sortedScores->first();
                                    $topContestant = $contestants->find($topContestantId);
                                    $topScore = $topContestantScores
                                        ? $topContestantScores->sum('rate') / $numberOfJudges
                                        : 0; // Calculate average score
                                @endphp
                                @if ($topContestant)
                                <button
                                class=
                                "float-right focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 "
                                type="button" onclick="printTable(this)"><i class='bx bxs-printer'></i> Print
                            </button>
                            <caption
                                    class="text-lg font-bold text-center border-b border-gray-200 caption-top">
                                    Male  Winner
                                </caption>
                            <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                                <caption
                                    class="hidden text-lg font-bold text-center border-b border-gray-200 caption-top">
                                    Male  Winner
                                </caption>
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2 border-b">Con#</th>
                                                <th class="px-4 py-2 border-b">Contestant</th>
                                                <th class="px-4 py-2 border-b">Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="winner-row">
                                                <td class="px-4 py-2 border-b">{{ $topContestant->number ?? 'N/A' }}</td>
                                                <td class="px-4 py-2 border-b">{{ $topContestant->name ?? 'Unknown' }}</td>
                                                <td
                                                    class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                                    {{ number_format($topScore, 2) }} %
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <p>No male winner for this minor award.</p>
                                @endif
                            @else
                                <p>No male contestants for this minor award.</p>
                            @endif

                            <!-- Male Contestants Table -->
                          
                            @if (isset($maleMinorAwardScores[$minorAward->id]))
                            <button
                            class=
                            "float-right focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 "
                            type="button" onclick="printTable(this)"><i class='bx bxs-printer'></i> Print
                        </button>
                        <caption
                                class="text-lg font-bold text-center border-b border-gray-200 caption-top">
                                Male Contestants
                            </caption>
                        <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                            <caption
                                    class="hidden text-lg font-bold text-center border-b border-gray-200 caption-top">
                                    Male Contestants
                                </caption>
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 border-b">Con#</th>
                                            <th class="px-4 py-2 border-b">Contestant</th>
                                            <th class="px-4 py-2 border-b">Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $winnerData = $minorAwardCriteriaWinners[$minorAward->id] ?? null;
                                            $scores = $maleMinorAwardScores[$minorAward->id] ?? [];
                                            $numberOfJudges = $judges->count(); // Assuming $judges is a collection of judges
                                            $sortedScores = collect($scores)->sortByDesc(function ($score) use (
                                                $numberOfJudges,
                                            ) {
                                                return $score ? $score->sum('rate') / $numberOfJudges : 0; // Divide by the number of judges to get average score
                                            });
                                        @endphp
                                        @foreach ($sortedScores as $contestantId => $contestantScores)
                                            @php
                                                $contestant = $contestants->find($contestantId);
                                                $totalScore = $contestantScores ? $contestantScores->sum('rate') : 0;
                                                $averageScore = $totalScore / $numberOfJudges; // Calculate average score by dividing total score by the number of judges
                                                $isWinner =
                                                    $winnerData && $winnerData['contestant_id'] == $contestantId;
                                            @endphp
                                            @if ($contestant)
                                                <tr class="{{ $isWinner ? 'winner-row' : '' }}">
                                                    <td class="px-4 py-2 border-b">{{ $contestant->number ?? 'N/A' }}</td>
                                                    <td class="px-4 py-2 border-b">{{ $contestant->name ?? 'Unknown' }}
                                                    </td>
                                                    <td
                                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                                        {{ number_format($averageScore, 2) }} %
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No male contestants for this minor award.</p>
                            @endif

                            <!-- Female Winner Table -->

                            @if (isset($femaleMinorAwardScores[$minorAward->id]))
                                @php
                                    $scores = $femaleMinorAwardScores[$minorAward->id] ?? [];
                                    $numberOfJudges = $judges->count(); // Assuming $judges is a collection of judges
                                    $sortedScores = collect($scores)->sortByDesc(function ($score) use (
                                        $numberOfJudges,
                                    ) {
                                        return $score ? $score->sum('rate') / $numberOfJudges : 0; // Divide by the number of judges to get average score
                                    });
                                    $topContestantId = $sortedScores->keys()->first();
                                    $topContestantScores = $sortedScores->first();
                                    $topContestant = $contestants->find($topContestantId);
                                    $topScore = $topContestantScores
                                        ? $topContestantScores->sum('rate') / $numberOfJudges
                                        : 0; // Calculate average score
                                @endphp
                                @if ($topContestant)
                                <button
                                class=
                                "float-right focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 "
                                type="button" onclick="printTable(this)"><i class='bx bxs-printer'></i> Print
                            </button>
                            <caption
                                    class="text-lg font-bold text-center border-b border-gray-200 caption-top">
                                    Female Winner
                                </caption>
                            <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                                <caption
                                        class="hidden text-lg font-bold text-center border-b border-gray-200 caption-top">
                                        Female Winner
                                    </caption>
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2 border-b">Con#</th>
                                                <th class="px-4 py-2 border-b">Contestant</th>
                                                <th class="px-4 py-2 border-b">Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="winner-row">
                                                <td class="px-4 py-2 border-b">{{ $topContestant->number ?? 'N/A' }}</td>
                                                <td class="px-4 py-2 border-b">{{ $topContestant->name ?? 'Unknown' }}</td>
                                                <td
                                                    class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                                    {{ number_format($topScore, 2) }} %
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <p>No female winner for this minor award.</p>
                                @endif
                            @else
                                <p>No female contestants for this minor award.</p>
                            @endif

                            <!-- Female Contestants Table -->
 
                            @if (isset($femaleMinorAwardScores[$minorAward->id]))
                          
                                <button
                                    class=
                                    "float-right focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 "
                                    type="button" onclick="printTable(this)"><i class='bx bxs-printer'></i> Print
                                </button>
                                <caption
                                        class="text-lg font-bold text-center border-b border-gray-200 caption-top">
                                        Female Contestants
                                    </caption>
                                <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                                    <caption
                                        class="hidden text-lg font-bold text-center border-b border-gray-200 caption-top">
                                        Female Contestants
                                    </caption>
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 border-b">Con#</th>
                                            <th class="px-4 py-2 border-b">Contestant</th>
                                            <th class="px-4 py-2 border-b">Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $winnerData = $minorAwardCriteriaWinners[$minorAward->id] ?? null;
                                            $scores = $femaleMinorAwardScores[$minorAward->id] ?? [];
                                            $sortedScores = collect($scores)->sortByDesc(function ($score) use (
                                                $numberOfJudges,
                                            ) {
                                                return $score ? $score->sum('rate') / $numberOfJudges : 0; // Divide by the number of judges to get average score
                                            });
                                        @endphp
                                        @foreach ($sortedScores as $contestantId => $contestantScores)
                                            @php
                                                $contestant = $contestants->find($contestantId);
                                                $score = $contestantScores
                                                    ? $contestantScores->sum('rate') / $numberOfJudges
                                                    : 0; // Calculate average score
                                                $isWinner =
                                                    $winnerData && $winnerData['contestant_id'] == $contestantId;
                                            @endphp
                                            @if ($contestant)
                                                <tr class="{{ $isWinner ? 'winner-row' : '' }}">
                                                    <td class="px-4 py-2 border-b">{{ $contestant->number ?? 'N/A' }}</td>
                                                    <td class="px-4 py-2 border-b">{{ $contestant->name ?? 'Unknown' }}
                                                    </td>
                                                    <td
                                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                                        {{ number_format($score, 2) }} %
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No female contestants for this minor award.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="accordion-arrow-icon" data-accordion="collapse">
                <h2 id="accordion-arrow-icon-heading-1">
                    <button
                        class="flex items-center justify-between w-full gap-3 p-5 font-medium text-gray-900 border border-b-0 border-gray-200 rtl:text-right rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800"
                        data-accordion-target="#accordion-arrow-icon-body-1" type="button" aria-expanded="false"
                        aria-controls="accordion-arrow-icon-body-1">
                        <span>OVER ALL SCORES</span>
                    </button>
                </h2>
                <div id="accordion-arrow-icon-body-1" class="hidden" aria-labelledby="accordion-arrow-icon-heading-1">
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                        <a class="focus:outline-none text-white  bg-[#FF9119] hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900"
                            href="">
                            <i class='text-white bx bxs-cloud-download'></i>
                            <span class="text-white">Download PDF</span>
                        </a>
                        <button
                            class="focus:outline-none text-white  bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 mb-2 "
                            type="button" onclick="printTable(this)"><i class='bx bxs-printer'></i> Print
                        </button>
                        <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b">#</th>
                                    <th class="px-4 py-2 border-b">Con#</th>
                                    <th class="px-4 py-2 border-b">Contestant</th>
                                    <th class="px-4 py-2 border-b">Overall Minor Award Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($overallMinorAwardScores as $contestantId => $overallScores)
                                    @php
                                        $contestant = $contestants->find($contestantId);
                                        $totalScore = $overallScores['totalScore'] ?? 0;
                                        $scoreId = $overallScores['id'] ?? 'N/A';
                                    @endphp
                                    @if ($contestant)
                                        <tr>
                                            <td class="px-4 py-2 border-b">{{ $scoreId }}</td>
                                            <td class="px-4 py-2 border-b">{{ $contestant->number }}</td>
                                            <td class="px-4 py-2 border-b">{{ $contestant->name ?? 'Unknown' }}</td>
                                            <td class="px-4 py-2 border-b">{{ number_format($totalScore, 2) }} %</td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td class="px-4 py-2 border-b" colspan="4">No scores available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TOP CONTESTANTS ACCORDION -->
                <h2 id="accordion-arrow-icon-heading-2">
                    <button
                        class="flex items-center justify-between w-full gap-3 p-5 font-medium text-gray-500 border border-b-0 border-gray-200 rtl:text-right focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                        data-accordion-target="#accordion-arrow-icon-body-2" type="button" aria-expanded="false"
                        aria-controls="accordion-arrow-icon-body-2">
                        <span>TOP CONTESTANTS</span>
                    </button>
                </h2>
                <div class="hidden" id="accordion-arrow-icon-body-2" aria-labelledby="accordion-arrow-icon-heading-2">
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                        <a class="focus:outline-none text-white  bg-[#FF9119] hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900"
                            href="">
                            <i class='text-white bx bxs-cloud-download'></i>
                            <span class="text-white">Download PDF</span>
                        </a>
                        <button
                            class="focus:outline-none text-white  bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 mb-2 "
                            type="button" onclick="printTable(this)"><i class='bx bxs-printer'></i> Print
                        </button>

                        <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b">Con#</th>
                                    <th class="px-4 py-2 border-b">Contestant</th>
                                    <th class="px-4 py-2 border-b">Total Minor Award Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topContestants as $contestantId => $contestantData)
                                    @php
                                        $contestant = $contestants->find($contestantId);
                                        $totalScore = $contestantData['totalScore'] ?? 0;
                                        $scoreId = $contestantData['id'] ?? 'N/A';
                                    @endphp
                                    @if ($contestant)
                                        <tr>
                                            <td class="px-4 py-2 border-b">{{ $contestant->number }}</td>
                                            <td class="px-4 py-2 border-b">{{ $contestant->name ?? 'Unknown' }}</td>
                                            <td
                                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                                {{ number_format($totalScore, 2) }} %
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td class="px-4 py-2 border-b" colspan="3">No top contestants available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <h3
            class="bg-blue-200 text-blue-800 text-xl font-semibold my-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-blue-400 text-center">
            PRINT ROUNDS SCORES
        </h3>
        <div id="accordion-nested-parent" data-accordion="collapse">
            @foreach ($rounds as $round)
                <h2 id="accordion-collapse-heading-{{ $loop->index }}">
                    <button
                        class="flex items-center justify-between w-full gap-3 p-5 font-medium text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                        data-accordion-target="#accordion-collapse-body-{{ $loop->index }}" type="button"
                        aria-expanded="false" aria-controls="accordion-collapse-body-{{ $loop->index }}">
                        <span>{{ $round->round_description }}</span>
                        <svg class="w-3 h-3 rotate-180 shrink-0" data-accordion-icon aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div class="hidden" id="accordion-collapse-body-{{ $loop->index }}"
                    aria-labelledby="accordion-collapse-heading-{{ $loop->index }}">
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                        <!-- Male Contestants Table -->
                        <button
                        class=
                        "float-right focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 "
                        type="button" onclick="printTable(this)"><i class='bx bxs-printer'></i> Print
                    </button>
                    <caption
                            class="text-lg font-bold text-center border-b border-gray-200 caption-top">
                            Male  Winner
                        </caption>
                    <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                        <caption
                            class="hidden text-lg font-bold text-center border-b border-gray-200 caption-top">
                            Male  Winner
                        </caption>
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b">Rank</th>
                                    <th class="px-4 py-2 border-b">Contestant Number</th>
                                    <th class="px-4 py-2 border-b">Contestant</th>
                                    <th class="px-4 py-2 border-b">Total Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php

                                    $maleScores = collect($combinedJudgesScores[$round->id] ?? [])
                                        ->filter(function ($scores, $contestantId) use ($contestants) {
                                            $contestant = $contestants->find($contestantId);
                                            return $contestant && $contestant->category === 'male';
                                        })
                                        ->sortByDesc('total');
                                    $winnerContestantId = $maleScores->keys()->first();
                                    $winnerContestant = $contestants->find($winnerContestantId);
                                    $winnerScore = $maleScores->first()['total'] ?? null;
                                @endphp
                                @if ($winnerContestant && $winnerScore !== null)
                                    <tr>
                                        <td class="px-4 py-2 border-b">1</td>
                                        <td class="px-4 py-2 border-b">{{ $winnerContestant->number }}</td>
                                        <td class="px-4 py-2 border-b">{{ $winnerContestant->name }}</td>
                                        <td
                                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                            {{ number_format($winnerScore, 2) }} %
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="px-4 py-2 border-b" colspan="3">No male winner available.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <!-- Male Contestants Table -->
                        <button
                                class=
                                "float-right focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 "
                                type="button" onclick="printTable(this)"><i class='bx bxs-printer'></i> Print
                            </button>
                            <caption
                                    class="text-lg font-bold text-center border-b border-gray-200 caption-top">
                                    Male  Contestants
                                </caption>
                            <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                                <caption
                                    class="hidden text-lg font-bold text-center border-b border-gray-200 caption-top">
                                    Male  Contestants
                                </caption>
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b">Rank</th>
                                    <th class="px-4 py-2 border-b">Contestant Number</th>
                                    <th class="px-4 py-2 border-b">Contestant</th>
                                    <th class="px-4 py-2 border-b">Total Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($maleScores as $contestantId => $scores)
                                    @php
                                        $contestant = $contestants->find($contestantId);
                                        $rank = $loop->iteration;
                                    @endphp
                                    @if ($contestant)
                                        <tr>
                                            <td class="px-4 py-2 border-b">{{ $rank }}</td>
                                            <td class="px-4 py-2 border-b">{{ $contestant->number }}</td>
                                            <td class="px-4 py-2 border-b">{{ $contestant->name }}</td>
                                            <td
                                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                                {{ number_format($scores['total'], 2) }} %
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Female Contestants Table -->
                        <button
                                class=
                                "float-right focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 "
                                type="button" onclick="printTable(this)"><i class='bx bxs-printer'></i> Print
                            </button>
                            <caption
                                    class="text-lg font-bold text-center border-b border-gray-200 caption-top">
                                    Female  Winner
                                </caption>
                            <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                                <caption
                                    class="hidden text-lg font-bold text-center border-b border-gray-200 caption-top">
                                    Female  Winner
                                </caption>
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b">Rank</th>
                                    <th class="px-4 py-2 border-b">Contestant Number</th>
                                    <th class="px-4 py-2 border-b">Contestant</th>
                                    <th class="px-4 py-2 border-b">Total Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $femaleScores = collect($combinedJudgesScores[$round->id] ?? [])
                                        ->filter(function ($scores, $contestantId) use ($contestants) {
                                            $contestant = $contestants->find($contestantId);
                                            return $contestant && $contestant->category === 'female';
                                        })
                                        ->sortByDesc('total');
                                    $winnerContestantId = $femaleScores->keys()->first();
                                    $winnerContestant = $contestants->find($winnerContestantId);
                                    $winnerScore = $femaleScores->first()['total'] ?? null;
                                @endphp
                                @if ($winnerContestant && $winnerScore !== null)
                                    <tr>
                                        <td class="px-4 py-2 border-b">1</td>
                                        <td class="px-4 py-2 border-b">{{ $winnerContestant->number }}</td>
                                        <td class="px-4 py-2 border-b">{{ $winnerContestant->name }}</td>
                                        <td
                                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                            {{ number_format($winnerScore, 2) }} %
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="px-4 py-2 border-b" colspan="3">No female winner available.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <!-- Female Contestants Table -->
                        <button
                                class=
                                "float-right focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 "
                                type="button" onclick="printTable(this)"><i class='bx bxs-printer'></i> Print
                            </button>
                            <caption
                                    class="text-lg font-bold text-center border-b border-gray-200 caption-top">
                                    Female Contestants
                                </caption>
                            <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                                <caption
                                    class="hidden text-lg font-bold text-center border-b border-gray-200 caption-top">
                                    Female Contestants
                                </caption>
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b">Rank</th>
                                    <th class="px-4 py-2 border-b">Contestant Number</th>

                                    <th class="px-4 py-2 border-b">Contestant</th>
                                    <th class="px-4 py-2 border-b">Total Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($femaleScores as $contestantId => $scores)
                                    @php
                                        $contestant = $contestants->find($contestantId);
                                        $rank = $loop->iteration;
                                    @endphp
                                    @if ($contestant)
                                        <tr>
                                            <td class="px-4 py-2 border-b">{{ $rank }}</td>
                                            <td class="px-4 py-2 border-b">{{ $contestant->number }}</td>

                                            <td class="px-4 py-2 border-b">{{ $contestant->name }}</td>
                                            <td
                                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                                {{ number_format($scores['total'], 2) }} %
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>



                        <!-- No Category/Null Contestants Table -->
                        <button
                                class=
                                "float-right focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 "
                                type="button" onclick="printTable(this)"><i class='bx bxs-printer'></i> Print
                            </button>
                            <caption
                                    class="text-lg font-bold text-center border-b border-gray-200 caption-top">
                                    SINGING/ DANCING CATEGORY
                                </caption>
                            <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                                <caption
                                    class="hidden text-lg font-bold text-center border-b border-gray-200 caption-top">
                                    SINGING/ DANCING CATEGORY
                                </caption>
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b">Rank</th>
                                    <th class="px-4 py-2 border-b">Contestant Number</th>
                                    <th class="px-4 py-2 border-b">Contestant</th>
                                    <th class="px-4 py-2 border-b">Total Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $otherScores = collect($combinedJudgesScores[$round->id] ?? [])
                                        ->filter(function ($scores, $contestantId) use ($contestants) {
                                            $contestant = $contestants->find($contestantId);
                                            return $contestant &&
                                                ($contestant->category === null || $contestant->category === '');
                                        })
                                        ->sortByDesc('total');
                                    $winnerContestantId = $otherScores->keys()->first();
                                    $winnerContestant = $contestants->find($winnerContestantId);
                                    $winnerScore = $otherScores->first()['total'] ?? null;
                                @endphp
                                @if ($winnerContestant && $winnerScore !== null)
                                    <tr>
                                        <td class="px-4 py-2 border-b">1</td>
                                        <td class="px-4 py-2 border-b">{{ $winnerContestant->number }}</td>
                                        <td class="px-4 py-2 border-b">{{ $winnerContestant->name }}</td>
                                        <td
                                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                            {{ number_format($winnerScore, 2) }} %
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="px-4 py-2 border-b" colspan="4">No other contestants available.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <!-- All Other Contestants Table -->
                        <h4 class="mt-4 mb-2 text-lg font-semibold">All Other Contestants</h4>
                        <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b">Rank</th>
                                    <th class="px-4 py-2 border-b">Contestant Number</th>
                                    <th class="px-4 py-2 border-b">Contestant</th>
                                    <th class="px-4 py-2 border-b">Total Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($otherScores as $contestantId => $scores)
                                    @php
                                        $contestant = $contestants->find($contestantId);
                                        $rank = $loop->iteration;
                                    @endphp
                                    @if ($contestant)
                                        <tr>
                                            <td class="px-4 py-2 border-b">{{ $rank }}</td>
                                            <td class="px-4 py-2 border-b">{{ $contestant->number }}</td>
                                            <td class="px-4 py-2 border-b">{{ $contestant->name }}</td>
                                            <td
                                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                                {{ number_format($scores['total'], 2) }} %
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>






    <!-- Overall Combined Scores Section -->
    <h3
        class="bg-blue-200 text-blue-800 text-xl font-semibold my-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-blue-400 text-center">
        OVERALL COMBINED SCORES (ALL ROUNDS)
    </h3>


    <div id="accordion-flush" data-accordion="collapse"
        data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
        data-inactive-classes="text-gray-500 dark:text-gray-400">
        <h2 id="accordion-flush-heading-1">
            <button type="button"
                class="flex items-center justify-between w-full gap-3 py-5 font-medium text-gray-500 border-b border-gray-200 rtl:text-right dark:border-gray-700 dark:text-gray-400"
                data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                aria-controls="accordion-flush-body-1">
                <span>Male over all scores in rounds</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
            <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                <!-- Male Overall Scores -->
                <div class="p-5 mb-4 border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <h4 class="mb-2 text-lg font-semibold">Male Overall Winner</h4>

                    <button
                        class="focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 mb-2"
                        type="button" onclick="printTable(this)">
                        <i class='bx bxs-printer'></i> Print
                    </button>

                    <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Rank</th>
                                <th class="px-4 py-2 border-b">Contestant Number</th>
                                <th class="px-4 py-2 border-b">Contestant</th>
                                @foreach ($rounds as $round)
                                    <th class="px-4 py-2 border-b">{{ $round->round_description }}</th>
                                @endforeach
                                <th class="px-4 py-2 border-b">Overall Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $maleOverallScores = $contestants
                                    ->where('category', 'male')
                                    ->map(function ($contestant) use ($rounds, $combinedJudgesScores) {
                                        $roundScores = [];
                                        $totalScore = 0;
                                        foreach ($rounds as $round) {
                                            $score = $combinedJudgesScores[$round->id][$contestant->id]['total'] ?? 0;
                                            $roundScores[$round->id] = $score;
                                            $totalScore += $score;
                                        }
                                        return [
                                            'contestant' => $contestant,
                                            'roundScores' => $roundScores,
                                            'totalScore' => $totalScore / count($rounds), // Average across rounds
                                        ];
                                    })
                                    ->sortByDesc('totalScore');

                                $topMale = $maleOverallScores->first();
                            @endphp
                            @if ($topMale)
                                <tr>
                                    <td class="px-4 py-2 border-b">1</td>
                                    <td class="px-4 py-2 border-b">{{ $topMale['contestant']->number }}</td>
                                    <td class="px-4 py-2 border-b">{{ $topMale['contestant']->name }}</td>
                                    @foreach ($rounds as $round)
                                        <td class="px-4 py-2 border-b">
                                            {{ number_format($topMale['roundScores'][$round->id] ?? 0, 2) }}%
                                        </td>
                                    @endforeach
                                    <td
                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                        {{ number_format($topMale['totalScore'], 2) }}%
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <h4 class="mb-2 text-lg font-semibold">All Male Contestants Overall Scores</h4>
                    <button
                        class="focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 mb-2"
                        type="button" onclick="printTable(this)">
                        <i class='bx bxs-printer'></i> Print
                    </button>
                    <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Rank</th>
                                <th class="px-4 py-2 border-b">Contestant Number</th>
                                <th class="px-4 py-2 border-b">Contestant</th>
                                @foreach ($rounds as $round)
                                    <th class="px-4 py-2 border-b">{{ $round->round_description }}</th>
                                @endforeach
                                <th class="px-4 py-2 border-b">Overall Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($maleOverallScores as $index => $data)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border-b">{{ $data['contestant']->number }}</td>
                                    <td class="px-4 py-2 border-b">{{ $data['contestant']->name }}</td>
                                    @foreach ($rounds as $round)
                                        <td class="px-4 py-2 border-b">
                                            {{ number_format($data['roundScores'][$round->id] ?? 0, 2) }}%
                                        </td>
                                    @endforeach
                                    <td
                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                        {{ number_format($data['totalScore'], 2) }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <h2 id="accordion-flush-heading-2">
            <button type="button"
                class="flex items-center justify-between w-full gap-3 py-5 font-medium text-gray-500 border-b border-gray-200 rtl:text-right dark:border-gray-700 dark:text-gray-400"
                data-accordion-target="#accordion-flush-body-2" aria-expanded="false"
                aria-controls="accordion-flush-body-2">
                <span>female over all scores in rounds</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
            <div class="py-5 border-b border-gray-200 dark:border-gray-700">


                <!-- Female Overall Scores -->
                <div class="p-5 mb-4 border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <h4 class="mb-2 text-lg font-semibold">Female Overall Winner</h4>
                    @php
                        $femaleOverallScores = $contestants
                            ->where('category', 'female')
                            ->map(function ($contestant) use ($rounds, $combinedJudgesScores) {
                                $roundScores = [];
                                $totalScore = 0;
                                foreach ($rounds as $round) {
                                    $score = $combinedJudgesScores[$round->id][$contestant->id]['total'] ?? 0;
                                    $roundScores[$round->id] = $score;
                                    $totalScore += $score;
                                }
                                return [
                                    'contestant' => $contestant,
                                    'roundScores' => $roundScores,
                                    'totalScore' => $totalScore / count($rounds), // Average across rounds
                                ];
                            })
                            ->sortByDesc('totalScore');

                        $topFemale = $femaleOverallScores->first();
                    @endphp
                    <button
                        class="focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 mb-2"
                        type="button" onclick="printTable(this)">
                        <i class='bx bxs-printer'></i> Print
                    </button>
                    <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Rank</th>
                                <th class="px-4 py-2 border-b">Contestant Number</th>
                                <th class="px-4 py-2 border-b">Contestant</th>
                                @foreach ($rounds as $round)
                                    <th class="px-4 py-2 border-b">{{ $round->round_description }}</th>
                                @endforeach
                                <th class="px-4 py-2 border-b">Overall Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($topFemale)
                                <tr>
                                    <td class="px-4 py-2 border-b">1</td>
                                    <td class="px-4 py-2 border-b">{{ $topFemale['contestant']->number }}</td>
                                    <td class="px-4 py-2 border-b">{{ $topFemale['contestant']->name }}</td>
                                    @foreach ($rounds as $round)
                                        <td class="px-4 py-2 border-b">
                                            {{ number_format($topFemale['roundScores'][$round->id] ?? 0, 2) }}%
                                        </td>
                                    @endforeach
                                    <td
                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                        {{ number_format($topFemale['totalScore'], 2) }}%
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <h4 class="mb-2 text-lg font-semibold">All Female Contestants Overall Scores</h4>
                    <button
                        class="focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 mb-2"
                        type="button" onclick="printTable(this)">
                        <i class='bx bxs-printer'></i> Print
                    </button>
                    <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Rank</th>
                                <th class="px-4 py-2 border-b">Contestant Number</th>
                                <th class="px-4 py-2 border-b">Contestant</th>
                                @foreach ($rounds as $round)
                                    <th class="px-4 py-2 border-b">{{ $round->round_description }}</th>
                                @endforeach
                                <th class="px-4 py-2 border-b">Overall Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($femaleOverallScores as $index => $data)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border-b">{{ $data['contestant']->number }}</td>
                                    <td class="px-4 py-2 border-b">{{ $data['contestant']->name }}</td>
                                    @foreach ($rounds as $round)
                                        <td class="px-4 py-2 border-b">
                                            {{ number_format($data['roundScores'][$round->id] ?? 0, 2) }}%
                                        </td>
                                    @endforeach
                                    <td
                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                        {{ number_format($data['totalScore'], 2) }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <h2 id="accordion-flush-heading-3">
            <button type="button"
                class="flex items-center justify-between w-full gap-3 py-5 font-medium text-gray-500 border-b border-gray-200 rtl:text-right dark:border-gray-700 dark:text-gray-400"
                data-accordion-target="#accordion-flush-body-3" aria-expanded="false"
                aria-controls="accordion-flush-body-3">
                <span>Other Category singing or dancing Overall Winner</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
            <div class="py-5 border-b border-gray-200 dark:border-gray-700">

                <!-- Other Category Overall Scores -->
                <div class="p-5 mb-4 border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <h4 class="mb-2 text-lg font-semibold">Other Category Overall Winner</h4>
                    @php
                        $otherOverallScores = $contestants
                            ->whereIn('category', [null, ''])
                            ->map(function ($contestant) use ($rounds, $combinedJudgesScores) {
                                $roundScores = [];
                                $totalScore = 0;
                                foreach ($rounds as $round) {
                                    $score = $combinedJudgesScores[$round->id][$contestant->id]['total'] ?? 0;
                                    $roundScores[$round->id] = $score;
                                    $totalScore += $score;
                                }
                                return [
                                    'contestant' => $contestant,
                                    'roundScores' => $roundScores,
                                    'totalScore' => $totalScore / count($rounds), // Average across rounds
                                ];
                            })
                            ->sortByDesc('totalScore');

                        $topOther = $otherOverallScores->first();
                    @endphp
                    <button
                        class="focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 mb-2"
                        type="button" onclick="printTable(this)">
                        <i class='bx bxs-printer'></i> Print
                    </button>
                    <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Rank</th>
                                <th class="px-4 py-2 border-b">Contestant Number</th>
                                <th class="px-4 py-2 border-b">Contestant</th>
                                @foreach ($rounds as $round)
                                    <th class="px-4 py-2 border-b">{{ $round->round_description }}</th>
                                @endforeach
                                <th class="px-4 py-2 border-b">Overall Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($topOther)
                                <tr>
                                    <td class="px-4 py-2 border-b">1</td>
                                    <td class="px-4 py-2 border-b">{{ $topOther['contestant']->number }}</td>
                                    <td class="px-4 py-2 border-b">{{ $topOther['contestant']->name }}</td>
                                    @foreach ($rounds as $round)
                                        <td class="px-4 py-2 border-b">
                                            {{ number_format($topOther['roundScores'][$round->id] ?? 0, 2) }}%
                                        </td>
                                    @endforeach
                                    <td
                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                        {{ number_format($topOther['totalScore'], 2) }}%
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <h4 class="mb-2 text-lg font-semibold">All Other Category Contestants Overall Scores</h4>
                    <button
                        class="focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 me-2 mb-2"
                        type="button" onclick="printTable(this)">
                        <i class='bx bxs-printer'></i> Print
                    </button>
                    <table class="table min-w-full mb-4 bg-white border border-gray-200 table-xs">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Rank</th>
                                <th class="px-4 py-2 border-b">Contestant Number</th>
                                <th class="px-4 py-2 border-b">Contestant</th>
                                @foreach ($rounds as $round)
                                    <th class="px-4 py-2 border-b">{{ $round->round_description }}</th>
                                @endforeach
                                <th class="px-4 py-2 border-b">Overall Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $rank = 1;
                            @endphp
                            @foreach ($otherOverallScores as $index => $data)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $rank }}</td>
                                    <td class="px-4 py-2 border-b">{{ $data['contestant']->number }}</td>
                                    <td class="px-4 py-2 border-b">{{ $data['contestant']->name }}</td>
                                    @foreach ($rounds as $round)
                                        <td class="px-4 py-2 border-b">
                                            {{ number_format($data['roundScores'][$round->id] ?? 0, 2) }}%
                                        </td>
                                    @endforeach
                                    <td
                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                        {{ number_format($data['totalScore'], 2) }}%
                                    </td>
                                </tr>
                                @php
                                    $rank++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>






    <script>
        function printTable(button) {
            const table = button.nextElementSibling;
            const printWindow = window.open('', '_blank');

            // Initialize variables
            let title = '';
            let category = '';

            // Get the gender category
            const genderSection = button.closest('.tab-content');
            if (genderSection) {
                const genderTab = document.querySelector(`[aria-controls="${genderSection.id}"]`);
                if (genderTab) {
                    category = genderTab.textContent.trim(); // This will get "Male" or "Female"
                }
            }

            // Check for minor awards section
            const minorAwardsSection = button.closest('[id^="accordion-open-body-"]');
            if (minorAwardsSection) {
                const headingId = minorAwardsSection.getAttribute('aria-labelledby');
                const headingSpan = document.getElementById(headingId)?.querySelector('span');
                if (headingSpan) {
                    title = headingSpan.textContent.trim();
                }
            }

            // Check for rounds section
            const roundsSection = button.closest('[id^="accordion-collapse-body-"]');
            if (roundsSection) {
                const headingId = roundsSection.getAttribute('aria-labelledby');
                const headingSpan = document.getElementById(headingId)?.querySelector('span');
                if (headingSpan) {
                    title = headingSpan.textContent.trim();
                }
            }

            fetch('{{ route('print.table') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        tableContent: table.outerHTML,
                        title: title,
                        category: category
                    })
                })
                .then(response => response.text())
                .then(htmlContent => {
                    printWindow.document.write(htmlContent);
                    printWindow.document.close();
                    printWindow.print();
                })
                .catch(error => console.error('Error loading print content:', error));
        }
    </script>
@endsection
