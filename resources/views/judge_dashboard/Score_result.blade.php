@extends('layouts.judgeRate')

@section('content')



    <div class="container mx-auto p-4 mt-12">
        <h1
            class="text-2xl font-bold mb-2 bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
            {{ $event->event_name }} - Judge Scores
        </h1>
         
          
            <div class="flex flex-wrap gap-4 mb-8 ">
            <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span
                    class="flex w-2.5 h-2.5 bg-pink-600 rounded-full me-1.5 flex-shrink-0"></span> Lowest</span>
            <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span
                    class="flex w-2.5 h-2.5 bg-green-500 rounded-full me-1.5 flex-shrink-0"></span> Highest</span>
            <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span
                    class="flex w-2.5 h-2.5 bg-blue-500 rounded-full me-1.5 flex-shrink-0"></span> Results</span>
        </div>
        <span class=" bg-green-100 text-green-800 text-xs font-medium me-2 px-0.5 py-2.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400"><i class='bx bx-info-circle'></i> Please remember that these scores are based on the scores you assigned to the contestants.</span>
        </BR>
        @foreach ($rounds as $round)
            <h2 class="text-lg font-bold mb-2">{{ $round->round_description }}</h2>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-4">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3" scope="col">Contestant Number</th>
                            <th class="px-6 py-3" scope="col">Name</th>
                            @foreach ($round->criteria as $criteria)
                                <th class="px-6 py-3" scope="col">{{ $criteria->criteria_description }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $roundScores = collect($finalScores)->filter(function ($score) use ($round) {
                                return isset($score['round_scores'][$round->id]) &&
                                    is_array($score['round_scores'][$round->id]);
                            });

                            $roundScoresArray = $roundScores->toArray();

                            $maxScore = $roundScores
                                ->map(function ($score) use ($round) {
                                    return array_sum($score['round_scores'][$round->id]);
                                })
                                ->max();

                            $minScore = $roundScores
                                ->map(function ($score) use ($round) {
                                    return array_sum($score['round_scores'][$round->id]);
                                })
                                ->min();
                        @endphp

                        @foreach ($roundScores as $score)
                            @php
                                $totalScore = array_sum($score['round_scores'][$round->id]);
                                $rowClass = '';

                                if ($totalScore == $maxScore) {
                                    $rowClass = 'bg-green-100 text-green-800';
                                } elseif ($totalScore == $minScore) {
                                    $rowClass = 'bg-pink-100 text-pink-800';
                                }
                            @endphp
                            <tr class="{{ $rowClass }} bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#{{ $score['number'] }}</td>
                                <td class="px-6 py-4">{{ $score['name'] }}</td>
                                @foreach ($round->criteria as $criteria)
                                    <td class="px-6 py-4">{{ $score['round_scores'][$round->id][$criteria->id] ?? '-' }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @php
                usort($roundScoresArray, function ($a, $b) use ($round) {
                    $aScore = array_sum($a['round_scores'][$round->id]);
                    $bScore = array_sum($b['round_scores'][$round->id]);
                    return $bScore <=> $aScore;
                });

                $roundWinner = reset($roundScoresArray);
            @endphp

            @if ($roundWinner)
                <p
                    class="font-semibold mt-4 mb-8 bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                    Winner for {{ $round->round_description }}: {{ $roundWinner['name'] }} with a score of
                    {{ number_format(array_sum($roundWinner['round_scores'][$round->id]), 2) }}
                </p>
            @else
                <p
                    class="font-semibold mt-4 mb-8 bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-pink-900 dark:text-pink-300">
                    No winner for {{ $round->round_description }}
                </p>
            @endif
        @endforeach

        <h2 class="text-xl font-bold my-4">Overall Winners</h2>

        @php
            $overallWinners = $finalScores->sortByDesc('final_score')->take(3);
        @endphp
        <ul>
            @foreach ($overallWinners as $index => $winner)
                <li>{{ $index + 1 }}. {{ $winner['name'] }} - Final Score:
                    {{ number_format($winner['final_score'], 2) }}</li>
            @endforeach
        </ul>
    </div>
@endsection
