@extends('layouts.admin_layout')
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scoreCount {
        from {
            opacity: 0;
            transform: scale(0.8);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes highlightRow {
        0% {
            background-color: rgba(59, 130, 246, 0.1);
        }

        50% {
            background-color: rgba(59, 130, 246, 0.2);
        }

        100% {
            background-color: transparent;
        }
    }

    .score-table tr {
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }

    .score-table tr:nth-child(1) {
        animation-delay: 0.1s;
    }

    .score-table tr:nth-child(2) {
        animation-delay: 0.2s;
    }

    .score-table tr:nth-child(3) {
        animation-delay: 0.3s;
    }

    /* Add more if needed */

    .score-value {
        animation: scoreCount 0.8s ease-out forwards;
    }

    .contestant-row:hover {
        animation: highlightRow 1s ease-in-out;
        transition: transform 0.2s ease;
        transform: scale(1.01);
    }

    .profile-image {
        transition: transform 0.3s ease;
    }

    .profile-image:hover {
        transform: scale(1.1);
    }
</style>
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


    <div class="container mx-auto px-4 py-8">
        <div class="flex gap-4 mb-8">
            <div class="w-1/2">
                <h1
                    class="bg-blue-200 text-center text-blue-800 text-xl font-semibold my-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-blue-400">
                    Users Vote Percentage%</h1>
                <div class="overflow-x-auto">
                  
                    <button
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 mb-4 rounded-lg transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2"
                        id="printScores" disabled>
                        <i class='bx bx-printer'></i>
                        Print Scores
                    </button>
                        <table class="min-w-full score-table">
                            <thead>
                                <tr class="bg-blue-500 from-blue-500 to-blue-600">
                                    <th class="py-3 px-4 text-white font-semibold">Profile</th>
                                    <th class="py-3 px-4 text-white font-semibold">Name</th>

                                    <th class="py-3 px-4 text-white font-semibold">Vote Score</th>
                                    <th class="py-3 px-4 text-white font-semibold">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contestants as $contestant)
                                    @php
                                        $contestantVotes = $userVotes[$contestant->id] ?? 0;
                                        $votePercentage = $totalVotes > 0 ? ($contestantVotes / $totalVotes) * 100 : 0;
                                        $judgeScore = $contestant->judge_score ?? 0;
                                        $totalScore = $judgeScore + $votePercentage;
                                    @endphp
                                    <tr class="contestant-row hover:bg-blue-50 transition-all duration-300">
                                        <td class="py-3 px-4 border-b border-gray-100">
                                            <div class="flex items-center space-x-3">
                                                <div class="relative">
                                                    <img class="w-12 h-12 object-cover rounded-full profile-image shadow-md"
                                                        src="{{ asset($contestant->profile) }}"
                                                        alt="{{ $contestant->name }}">
                                                    <span
                                                        class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                                                        {{ $contestant->number }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 border-b border-gray-100 font-medium">
                                            {{ $contestant->name }}
                                        </td>

                                        <td class="py-3 px-4 border-b border-gray-100">
                                            <div class="score-value text-green-600 font-semibold">
                                                {{ number_format($votePercentage, 2) }}%
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 border-b border-gray-100">
                                            <div
                                                class="bg-blue-500 from-blue-500 to-green-500 text-white px-4 py-1 rounded-full font-bold text-center score-value">
                                                {{ number_format($totalScore, 2) }}%
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </table>
                </div>
            </div>

            <div class="w-1/2">
                <h1
                    class="bg-blue-200 text-center text-blue-800 text-xl font-semibold my-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-blue-400">
                    Combined Scores</h1>

                <!-- Scoring Options Section -->

                <div class="bg-white rounded-lg shadow-lg p-4 mb-4" data-event-id="{{ $event->id }}">
                    <div class="flex flex-col space-y-4">
                        <!-- Scoring Type Selector -->
                        <div class="flex items-center justify-between p-2 border-b">
                            <span class="text-gray-700 font-medium">Select Scoring Type:</span>
                            <div class="relative">
                                <select
                                    class="appearance-none bg-blue-50 border border-blue-200 text-blue-800 py-2 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all duration-300"
                                    id="scoringType">
                                    <option value="userVote">User Vote Only</option>

                                    <!-- Minor Awards Section -->
                                    <optgroup label="Minor Awards">
                                        @foreach ($event->minorAwards as $award)
                                            <option value="minorAward_{{ $award->id }}">
                                                {{ $award->minor_awards_description }}
                                                ({{ $award->low_rate }}% - {{ $award->high_rate }}%)
                                            </option>
                                        @endforeach
                                    </optgroup>

                                    <!-- Combined Options -->
                                    <optgroup label="Combined Scoring">
                                        <option value="combined_all">All Combined</option>
                                        @foreach ($event->minorAwards as $award)
                                            <option value="combined_{{ $award->id }}">
                                                User Vote + {{ $award->minor_awards_description }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Weighting Controls -->
                        <div class="grid grid-cols-2 gap-4 p-2">
                            <div class="scoring-weight-card bg-blue-50 p-3 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700 mb-2">User Vote Weight (%)</label>
                                <input
                                    class="w-full px-3 py-2 border border-blue-200 rounded-md focus:ring-2 focus:ring-blue-300 focus:border-blue-400"
                                    id="userVoteWeight" type="number" value="50" min="0" max="100"
                                    step="1">
                            </div>
                            <div class="scoring-weight-card bg-blue-50 p-3 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Minor Awards Weight (%)</label>
                                <input
                                    class="w-full px-3 py-2 border border-blue-200 rounded-md focus:ring-2 focus:ring-blue-300 focus:border-blue-400"
                                    id="minorAwardsWeight" type="number" value="50" min="0" max="100"
                                    step="1">
                            </div>
                        </div>

                        <!-- Quick Presets -->
                        <div class="flex flex-wrap gap-2 p-2">
                            <button
                                class="preset-btn px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-full text-sm font-medium transition-all duration-300">
                                50/50 Split
                            </button>
                            <button
                                class="preset-btn px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-full text-sm font-medium transition-all duration-300">
                                70/30 Vote Priority
                            </button>
                            <button
                                class="preset-btn px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-full text-sm font-medium transition-all duration-300">
                                30/70 Awards Priority
                            </button>
                        </div>

                        <!-- Apply Button -->
                        <button
                            class="w-full bg-blue-500 from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]"
                            id="applyScoring">
                            Apply Scoring
                        </button>
                    </div>
                </div>

                <!-- Results Table -->
                <div class="flex gap-2 mt-4 mb-4">
                   
                    <button
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2"
                        id="printScores" disabled>
                        <i class='bx bx-printer'></i>
                        Print Scores
                    </button>
                </div>
                <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-blue-500 from-blue-500 to-blue-600 text-white">
                                <th class="py-3 px-4 text-left">Contestant</th>
                                <th class="py-3 px-4 text-center">User Vote</th>
                                <th class="py-3 px-4 text-center">Minor Awards</th>
                                <th class="py-3 px-4 text-center">Total Score</th>
                            </tr>
                        </thead>
                        <tbody id="combinedScoresBody">
                            <!-- Scores will be populated via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <script>
                // Add this to your existing JavaScript
                document.addEventListener('DOMContentLoaded', function() {
                    const printButton = document.getElementById('printScores');

                    // Enable print button after scores are calculated
                    function enablePrintButton() {
                        printButton.disabled = false;
                    }

                    // Print functionality
                    // Update the print functionality with better styling
                    // In your user_vote.blade.php
                    printButton.addEventListener('click', function() {
                        const eventId = document.querySelector('[data-event-id]').dataset.eventId;
                        const scoringType = document.getElementById('scoringType').value;
                        const userVoteWeight = document.getElementById('userVoteWeight').value;
                        const minorAwardsWeight = document.getElementById('minorAwardsWeight').value;

                        // Open print view in new window
                        const printWindow = window.open(`/admin/events/${eventId}/print-scores?` +
                            new URLSearchParams({
                                scoringType,
                                userVoteWeight,
                                minorAwardsWeight
                            }), '_blank');
                    });
                    // Update your existing updateScoresTable function to enable print button
                    const originalUpdateScoresTable = updateScoresTable;
                    updateScoresTable = function(scores) {
                        originalUpdateScoresTable(scores);
                        enablePrintButton();
                    };
                });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const scoringType = document.getElementById('scoringType');
                    const userVoteWeight = document.getElementById('userVoteWeight');
                    const minorAwardsContainer = document.getElementById('minorAwardsContainer');
                    const applyButton = document.getElementById('applyScoring');

                    // Handle scoring type changes
                    scoringType.addEventListener('change', function() {
                        const selectedValue = this.value;

                        if (selectedValue.startsWith('minorAward_')) {
                            // Show only specific minor award weight
                            const awardId = selectedValue.split('_')[1];
                            document.querySelectorAll('.minor-award-weight').forEach(input => {
                                const container = input.closest('.scoring-weight-card');
                                if (input.dataset.awardId === awardId) {
                                    container.style.display = 'block';
                                    input.value = '100';
                                } else {
                                    container.style.display = 'none';
                                    input.value = '0';
                                }
                            });
                            userVoteWeight.closest('.scoring-weight-card').style.display = 'none';
                            userVoteWeight.value = '0';
                        } else if (selectedValue === 'combined_all') {
                            // Show all weights
                            const totalAwards = document.querySelectorAll('.minor-award-weight').length;
                            const equalWeight = Math.floor(100 / (totalAwards + 1));

                            document.querySelectorAll('.minor-award-weight').forEach(input => {
                                input.closest('.scoring-weight-card').style.display = 'block';
                                input.value = equalWeight;
                            });
                            userVoteWeight.closest('.scoring-weight-card').style.display = 'block';
                            userVoteWeight.value = equalWeight;
                        } else if (selectedValue.startsWith('combined_')) {
                            // Show user vote and specific minor award
                            const awardId = selectedValue.split('_')[1];
                            document.querySelectorAll('.minor-award-weight').forEach(input => {
                                const container = input.closest('.scoring-weight-card');
                                if (input.dataset.awardId === awardId) {
                                    container.style.display = 'block';
                                    input.value = '50';
                                } else {
                                    container.style.display = 'none';
                                    input.value = '0';
                                }
                            });
                            userVoteWeight.closest('.scoring-weight-card').style.display = 'block';
                            userVoteWeight.value = '50';
                        } else if (selectedValue === 'userVote') {
                            // Show only user vote weight
                            document.querySelectorAll('.minor-award-weight').forEach(input => {
                                input.closest('.scoring-weight-card').style.display = 'none';
                                input.value = '0';
                            });
                            userVoteWeight.closest('.scoring-weight-card').style.display = 'block';
                            userVoteWeight.value = '100';
                        }
                    });

                    // Handle preset buttons
                    document.querySelectorAll('.preset-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const selectedValue = scoringType.value;

                            switch (this.textContent.trim()) {
                                case '50/50 Split':
                                    if (selectedValue.startsWith('combined_')) {
                                        userVoteWeight.value = '50';
                                        document.querySelectorAll(
                                                '.minor-award-weight:not([style*="display: none"])')
                                            .forEach(input => {
                                                input.value = '50';
                                            });
                                    }
                                    break;
                                case '70/30 Vote Priority':
                                    if (selectedValue.startsWith('combined_')) {
                                        userVoteWeight.value = '70';
                                        document.querySelectorAll(
                                                '.minor-award-weight:not([style*="display: none"])')
                                            .forEach(input => {
                                                input.value = '30';
                                            });
                                    }
                                    break;
                                case '70/30 Awards Priority':
                                    if (selectedValue.startsWith('combined_')) {
                                        userVoteWeight.value = '30';
                                        document.querySelectorAll(
                                                '.minor-award-weight:not([style*="display: none"])')
                                            .forEach(input => {
                                                input.value = '70';
                                            });
                                    }
                                    break;
                            }
                        });
                    });

                    // Update the validateWeights function
                    function validateWeights() {
                        const scoringType = document.getElementById('scoringType').value;
                        const userVoteWeight = parseFloat(document.getElementById('userVoteWeight').value) || 0;
                        const minorAwardsWeight = parseFloat(document.getElementById('minorAwardsWeight').value) || 0;

                        // Different validation based on scoring type
                        if (scoringType === 'userVote') {
                            if (userVoteWeight !== 100) {
                                showAlert('error', 'For User Vote Only, the User Vote Weight must be 100%');
                                return false;
                            }
                            return true;
                        }

                        if (scoringType.startsWith('minorAward_')) {
                            if (minorAwardsWeight !== 100) {
                                showAlert('error', 'For Minor Award Only, the Minor Awards Weight must be 100%');
                                return false;
                            }
                            return true;
                        }

                        // For combined scoring types
                        if (scoringType.startsWith('combined_')) {
                            const total = userVoteWeight + minorAwardsWeight;
                            if (total !== 100) {
                                showAlert('error', `Total weights must equal 100%. Current total: ${total}%`);
                                return false;
                            }
                            return true;
                        }

                        return true;
                    }

                    // Add a helper function to show alerts
                    function showAlert(type, message) {
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'fixed top-24 right-2 z-50';

                        alertDiv.innerHTML = `
                                      <div role="alert" class="alert ${type === 'error' ? 'alert-error' : 'alert-success'}">
                       <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                class="stroke-current h-6 w-6 shrink-0">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
                                          </svg>
                                    <span>${message}</span>
                            </div>
                                   `;

                        document.body.appendChild(alertDiv);

                        // Remove alert after 3 seconds
                        setTimeout(() => alertDiv.remove(), 3000);
                    }

                    // Update the weight input event listeners
                    document.addEventListener('DOMContentLoaded', function() {
                        const scoringType = document.getElementById('scoringType');
                        const userVoteWeight = document.getElementById('userVoteWeight');
                        const minorAwardsWeight = document.getElementById('minorAwardsWeight');

                        // Auto-adjust weights based on scoring type
                        scoringType.addEventListener('change', function() {
                            const selectedValue = this.value;

                            if (selectedValue === 'userVote') {
                                userVoteWeight.value = '100';
                                minorAwardsWeight.value = '0';
                                minorAwardsWeight.disabled = true;
                            } else if (selectedValue.startsWith('minorAward_')) {
                                userVoteWeight.value = '0';
                                minorAwardsWeight.value = '100';
                                userVoteWeight.disabled = true;
                            } else if (selectedValue.startsWith('combined_')) {
                                userVoteWeight.value = '50';
                                minorAwardsWeight.value = '50';
                                userVoteWeight.disabled = false;
                                minorAwardsWeight.disabled = false;
                            }
                        });

                        // Sync weights to always total 100% for combined scoring
                        userVoteWeight.addEventListener('input', function() {
                            if (scoringType.value.startsWith('combined_')) {
                                const value = parseFloat(this.value) || 0;
                                minorAwardsWeight.value = Math.max(0, 100 - value);
                            }
                        });

                        minorAwardsWeight.addEventListener('input', function() {
                            if (scoringType.value.startsWith('combined_')) {
                                const value = parseFloat(this.value) || 0;
                                userVoteWeight.value = Math.max(0, 100 - value);
                            }
                        });

                        // Update preset buttons
                        document.querySelectorAll('.preset-btn').forEach(btn => {
                            btn.addEventListener('click', function() {
                                if (!scoringType.value.startsWith('combined_')) {
                                    showAlert('error',
                                        'Presets are only available for combined scoring');
                                    return;
                                }

                                switch (this.textContent.trim()) {
                                    case '50/50 Split':
                                        userVoteWeight.value = '50';
                                        minorAwardsWeight.value = '50';
                                        break;
                                    case '70/30 Vote Priority':
                                        userVoteWeight.value = '70';
                                        minorAwardsWeight.value = '30';
                                        break;
                                    case '70/30 Awards Priority':
                                        userVoteWeight.value = '30';
                                        minorAwardsWeight.value = '70';
                                        break;
                                }
                            });
                        });
                    });
                    // Apply scoring button
                    applyButton.addEventListener('click', function() {
                        if (!validateWeights()) return;

                        this.classList.add('scale-95');
                        setTimeout(() => this.classList.remove('scale-95'), 150);

                        // Collect weights for calculation
                        const weights = {
                            userVote: parseFloat(userVoteWeight.value || 0),
                            minorAwards: Array.from(document.querySelectorAll(
                                    '.minor-award-weight:not([style*="display: none"])'))
                                .map(input => ({
                                    id: input.dataset.awardId,
                                    weight: parseFloat(input.value || 0)
                                }))
                        };

                        // Call your calculation function here
                        calculateCombinedScores(weights);
                    });
                });

                function calculateCombinedScores(weights) {
                    const eventId = document.querySelector('[data-event-id]').dataset.eventId;
                    const scoringType = document.getElementById('scoringType').value;

                    // Show loading state
                    const applyButton = document.getElementById('applyScoring');
                    applyButton.disabled = true;
                    applyButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Calculating...';

                    // Prepare request data
                    const requestData = {
                        ...weights,
                        scoringType: scoringType,
                        userVoteWeight: parseFloat(document.getElementById('userVoteWeight').value),
                        minorAwardsWeight: parseFloat(document.getElementById('minorAwardsWeight').value)
                    };

                    // Make API call
                    fetch(`/events/${eventId}/calculate-combined-scores`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(requestData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateScoresTable(data.scores);
                                document.getElementById('printScores').disabled = false; // Enable print button
                                showAlert('success', 'Scores calculated successfully!');
                            } else {
                                throw new Error(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('error', 'Error calculating scores: ' + error.message);
                        })
                        .finally(() => {
                            // Reset button state
                            applyButton.disabled = false;
                            applyButton.innerHTML = 'Apply Scoring';
                        });
                }

                function updateScoresTable(scores) {
                    const tbody = document.getElementById('combinedScoresBody');
                    tbody.innerHTML = '';

                    scores.forEach((score, index) => {
                        const row = document.createElement('tr');
                        row.className = 'hover:bg-blue-50 transition-all duration-300';
                        row.style.animation = `fadeIn 0.3s ease-out ${index * 0.1}s`;

                        row.innerHTML = `
                  <td class="py-3 px-4 border-b border-gray-200">
                   <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="${score.contestant.profile}" 
                             alt="${score.contestant.name}" 
                             class="w-12 h-12 object-cover rounded-full shadow-sm"
                        >
                        <span class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                            ${score.contestant.number}
                        </span>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">${score.contestant.name}</div>
                        <div class="text-sm text-gray-500">Contestant #${score.contestant.number}</div>
                    </div>
                  </div>
                   </td>
                             <td class="py-3 px-4 border-b border-gray-200 text-center">
                     <div class="text-blue-600 font-semibold">${score.vote_percentage.toFixed(2)}%</div>
                  <div class="text-xs text-gray-500">${score.vote_count} votes</div>
                     </td>
                   <td class="py-3 px-4 border-b border-gray-200 text-center">
                   <div class="text-green-600 font-semibold">${score.minor_awards_score.toFixed(2)}%</div>
                   <div class="text-xs text-gray-500">${Object.keys(score.minor_awards).length} awards</div>
                   </td>
                    <td class="py-3 px-4 border-b border-gray-200 text-center">
                   <div class="bg-blue-500 from-blue-500 to-green-500 text-white px-4 py-1 rounded-full font-bold">
                    ${score.total_score.toFixed(2)}%
                   </div>
                    </td>
                   `;

                        tbody.appendChild(row);
                    });
                }
         
         </script>

            <style>
                .scoring-weight-card {
                    transition: all 0.3s ease;
                }

                .scoring-weight-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                }

                .preset-btn {
                    transition: all 0.3s ease;
                }

                .preset-btn:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1);
                }

                #applyScoring {
                    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
                }
            </style>
        </div>
        @if ($contestants->isEmpty())
            <div class="text-center text-gray-500">
                <p>No contestants found.</p>
            </div>
        @endif
    </div>
@endsection
