@extends('layouts.admin_layout')
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Tailwind CSS (Optional for styling) -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    .tab-link.active {
        background-color: #1D4ED8;
        /* Tailwind's blue-700 */
        color: white;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .table-container {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    .action-button {
        transition: all 0.2s ease-in-out;
    }

    .action-button:hover {
        transform: scale(1.1);
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    <!-- Alert Messages -->
    <x-admin-nav-menu-manage />

    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if (session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    <!-- Selected Event Section -->
    <div class="mb-6 mt-2">
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2">
                <i class="fas fa-calendar-check text-blue-600"></i>
                <span class="text-sm font-medium text-gray-700">Selected Event:</span>
            </div>
            <div class="inline-flex items-center px-3 py-1.5 bg-blue-50 border border-blue-100 rounded-lg">
                <span class="text-sm font-semibold text-blue-700">{{ $event->event_name }}</span>
                <span class="ml-2 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                    Active
                </span>
            </div>
        </div>
        <p class="mt-2 text-sm text-gray-500">You are currently managing criteria for this event</p>
    </div>

    <!-- Scrollable Content Container -->
    <div class="overflow-y-auto max-h-[calc(100vh-200px)] pr-4 custom-scrollbar">
        <div class="md:flex space-x-4">
            <ul
                class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 md:me-4 mb-4 md:mb-0">
                <li>
                    <a class="inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white tab-link"
                        data-tab="awards" href="#" aria-current="page">
                        <i class="fa-solid fa-trophy"></i>
                        <span class="ml-2">AWARDS</span>
                    </a>
                </li>
                <li>
                    <a class="inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white tab-link"
                        data-tab="rounds" href="#">
                        <i class="fa-brands fa-dropbox"></i>
                        <span class="ml-2">ROUNDS</span>
                    </a>
                </li>
                <li>
                    <a class="inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white tab-link"
                        data-tab="criteria" href="#">
                        <i class="fa-solid fa-cash-register"></i>
                        <span class="ml-2">CRITERIA</span>
                    </a>
                </li>
                <li>
                    <a class="inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white tab-link"
                        data-tab="committee" href="#">
                        <i class="fa-solid fa-users"></i>
                        <span class="ml-2">COMMITTEE</span>
                    </a>
                </li>
                <li>
                    <a class="inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white tab-link"
                        data-tab="limit" href="#">
                        <i class="fa-solid fa-hourglass-half"></i>
                        <span class="ml-2">LIMIT</span>
                    </a>
                </li>
                <li>
                    <a class="inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white tab-link"
                        data-tab="view">
                        <i class="fa-solid fa-database"></i>
                        <span class="ml-2">DATA</span>

                    </a>
                </li>
            </ul>

            <div
                class="flex-1 p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">


                <!-- Awards Content (flex layout for form and table) -->
                <div class="tab-content" id="awards-content">


                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Set Minor Awards</h3>
                    <p class="mb-4">The section below is optional and intended for pageant events.</p>

                    <div class="md:flex md:space-x-6">
                        <!-- Form section on the left -->
                        <div class="md:w-1/3">
                            <form class="space-y-4" id="minor-award-form" method="POST">
                                @csrf
                                <div class="relative z-0 w-full mb-5 group">
                                    <label class="block mb-2 text-sm font-medium text-gray-500"
                                        for="minor_awards_description">
                                        Criteria Description
                                    </label>
                                    <select
                                        class="js-example-basic-single block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        id="minor_awards_description" name="minor_awards_description" required>
                                        <option value="">Select or type to add new</option>
                                        <option value="Production Number">Production Number</option>
                                        <option value="Swimwear/Fun Wear">Swimwear/Fun Wear</option>
                                        <option value="Formal Wear">Formal Wear</option>
                                        <option value="Best in Evening Gown">Best in Evening Gown</option>
                                        <option value="Miss Photogenic">Miss Photogenic</option>
                                        <!-- Add more predefined options as needed -->
                                    </select>
                                </div>

                                <div class="relative z-0 w-full mb-5 group" id="custom_description_group"
                                    style="display: none;">
                                    <input
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        id="custom_minor_awards_description" name="custom_minor_awards_description"
                                        type="text" placeholder="Enter custom criteria description" />
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        // Initialize Select2
                                        $('.js-example-basic-single').select2({
                                            tags: true,
                                            createTag: function(params) {
                                                return {
                                                    id: params.term,
                                                    text: params.term,
                                                    newOption: true
                                                }
                                            }
                                        });

                                        // Handle change event
                                        $('#minor_awards_description').on('change', function() {
                                            var selectedOption = $(this).find(':selected');
                                            if (selectedOption.is('[data-select2-tag="true"]')) {
                                                // This is a custom option
                                                $('#custom_description_group').show();
                                                $('#custom_minor_awards_description').val(selectedOption.val()).focus();
                                            } else {
                                                $('#custom_description_group').hide();
                                                $('#custom_minor_awards_description').val('');
                                            }
                                        });
                                    });
                                </script>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        id="high_rate" name="high_rate" type="number" min="0" max="100"
                                        required />
                                    <label
                                        class="absolute text-sm text-gray-500 peer-focus:text-blue-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                        for="high_rate">
                                        Highest Rate (%)
                                    </label>
                                </div>

                                <div class="relative z-0 w-full mb-5 group">
                                    <input
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        id="low_rate" name="low_rate" type="number" min="0" max="100"
                                        required />
                                    <label
                                        class="absolute text-sm text-gray-500 peer-focus:text-blue-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                        for="low_rate">
                                        Lowest Rate (%)
                                    </label>
                                </div>

                                <button
                                    class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm w-full sm:w-auto px-5 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    type="submit">
                                    Submit <i class="fa-regular fa-circle-check"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Table section on the right -->
                        <div class="md:w-2/3 overflow-x-auto mt-6 md:mt-0">
                            <table class="table-auto w-full text-left text-sm border border-gray-300 rounded-lg shadow-md">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="px-4 py-2">Criteria</th>
                                        <th class="px-4 py-2">Highest Rate</th>
                                        <th class="px-4 py-2">Lowest Rate</th>
                                        <th class="px-4 py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($minorAwards as $minorAward)
                                        <tr class="border-b hover:bg-gray-100">
                                            <td class="px-4 py-2">{{ $minorAward->minor_awards_description }}</td>
                                            <td class="px-4 py-2">{{ $minorAward->high_rate }}</td>
                                            <td class="px-4 py-2">{{ $minorAward->low_rate }}</td>
                                            <td class="px-4 py-2">
                                                <button class="text-red-600 hover:text-red-800"
                                                    data-id="{{ $minorAward->id }}" onclick="deleteMinorAward(this)">
                                                    <i class="fa-solid fa-trash-can-arrow-up"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Limit Form -->
                    <form class="flex items-center justify-end mt-6 space-x-4" id="updateTopContestantsForm"
                        action="{{ route('minor_awards.update_top_contestants', $event->id) }}" method="POST">
                        @csrf
                        <label class="text-lg font-semibold" for="top_contestant_limit">Top Contestant Limit:</label>
                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="top_contestant_limit" name="top_contestant_limit" type="number"
                            value="{{ $event->setting->top_contestant_limit ?? 0 }}" placeholder="0" required />
                        <button
                            class="p-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="submit">
                            <i class="fa-solid fa-check-double"></i>
                            <span class="sr-only">Update</span>
                        </button>
                    </form>



                    <!-- Voting Categories Section -->
                    <div class="mt-8 bg-white p-6 rounded-xl shadow-lg">
                        <!-- Header -->
                        <div class="border-b pb-4 mb-6">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-vote-yea text-blue-500 mr-3"></i>
                                Set Voting Categories
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Configure categories that viewers can vote for</p>
                        </div>

                        <div class="grid md:grid-cols-3 gap-8">
                            <!-- Category Form - Takes up 1/3 of the space -->
                            <div class="md:col-span-1">
                                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                    <form class="space-y-6" method="POST"
                                        action="{{ route('voting-categories.store', ['event' => $event->id]) }}">
                                        @csrf
                                        <input name="event_id" type="hidden" value="{{ $event->id }}">

                                        <!-- Category Name -->
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2"
                                                for="category_name">
                                                Category Name
                                            </label>
                                            <input
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category_name') border-red-500 @enderror"
                                                id="category_name" name="category_name" type="text"
                                                value="{{ old('category_name') }}" placeholder="e.g., Best in Talent"
                                                required>
                                            @error('category_name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Points per Vote -->
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2"
                                                for="points_per_vote">
                                                Points per Vote
                                            </label>
                                            <input
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('points_per_vote') border-red-500 @enderror"
                                                id="points_per_vote" name="points_per_vote" type="number"
                                                value="{{ old('points_per_vote', 1) }}" min="1"
                                                placeholder="Enter points value" required>
                                            @error('points_per_vote')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Category Icon -->
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2"
                                                for="category_icon">
                                                Category Icon
                                            </label>
                                            <select
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category_icon') border-red-500 @enderror"
                                                id="category_icon" name="category_icon">
                                                <option value="🏆">🏆 Trophy</option>
                                                <option value="⭐">⭐ Star</option>
                                                <option value="❤️">❤️ Heart</option>
                                                <option value="👑">👑 Crown</option>
                                                <option value="🎭">🎭 Mask</option>
                                                <option value="🎨">🎨 Art</option>
                                            </select>
                                            @error('category_icon')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button
                                            class="w-full bg-blue-600 text-white rounded-lg px-4 py-2.5 hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center space-x-2"
                                            type="submit">
                                            <i class="fas fa-plus"></i>
                                            <span>Add Category</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Categories List - Takes up 2/3 of the space -->
                            <div class="md:col-span-2">
                                <div class="bg-white rounded-lg border border-gray-200 h-full">
                                    <div class="p-4 border-b bg-gray-50 flex items-center justify-between">
                                        <h4 class="font-semibold text-gray-800">Active Categories</h4>
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            {{ $votingCategories->count() }} Categories
                                        </span>
                                    </div>
                                    <div class="divide-y" id="categories-list">
                                        @forelse ($votingCategories as $category)
                                            <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors duration-150"
                                                data-category-id="{{ $category->id }}">
                                                <div class="flex items-center space-x-4">
                                                    <span class="text-2xl">{{ $category->category_icon }}</span>
                                                    <div>
                                                        <h5 class="font-medium text-gray-800">
                                                            {{ $category->category_name }}
                                                        </h5>
                                                        <p class="text-sm text-gray-500">{{ $category->points_per_vote }}
                                                            points per vote</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-3">
                                                    <form class="inline-block" method="POST"
                                                        action="{{ route('voting-categories.toggle-status', ['event' => $event->id, 'category' => $category->id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button
                                                            class="p-2 text-blue-600 hover:text-blue-800 transition-colors duration-150"
                                                            type="submit"
                                                            title="{{ $category->is_active ? 'Deactivate' : 'Activate' }} category">
                                                            <i
                                                                class="fas fa-toggle-{{ $category->is_active ? 'on' : 'off' }} text-lg"></i>
                                                        </button>
                                                    </form>

                                                    <form class="inline-block" method="POST"
                                                        action="{{ route('voting-categories.destroy', ['event' => $event->id, 'category' => $category->id]) }}"
                                                        onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="p-2 text-red-600 hover:text-red-800 transition-colors duration-150"
                                                            type="submit" title="Delete category">
                                                            <i class="fas fa-trash text-lg"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="p-8 text-center text-gray-500" id="empty-state">
                                                <i class="fas fa-ballot text-4xl mb-3 block"></i>
                                                <p>No voting categories added yet</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Card -->
                        <div class="mt-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800">Voting Settings</h4>
                                    <p class="text-sm text-gray-600">Configure general voting parameters</p>
                                </div>
                                <button class="text-blue-600 hover:text-blue-800 transition-colors duration-150"
                                    type="button" onclick="my_modal_3.showModal()">
                                    <i class="fas fa-cog text-xl"></i>
                                </button>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm font-medium text-gray-600">Max Votes/User</p>
                                    <p class="text-xl font-semibold text-gray-800 mt-1">
                                        {{ $votingSettings->max_votes_per_user ?? 100 }}
                                    </p>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm font-medium text-gray-600">Vote Cost</p>
                                    <p class="text-xl font-semibold text-gray-800 mt-1">
                                        {{ $votingSettings->vote_cost ?? 5 }} credits
                                    </p>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm font-medium text-gray-600">Active Categories</p>
                                    <p class="text-xl font-semibold text-gray-800 mt-1">
                                        {{ $votingCategories->where('is_active', true)->count() }}
                                    </p>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm font-medium text-gray-600">Total Votes</p>
                                    <p class="text-xl font-semibold text-gray-800 mt-1">
                                        {{ $totalVotes ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Voting Settings Modal -->
                    <dialog class="modal" id="my_modal_3">
                        <div class="modal-box max-w-md mx-auto bg-white rounded-xl shadow-2xl p-6">
                            <!-- Header -->
                            <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                <h3 class="text-xl font-bold text-gray-900">
                                    <i class="fas fa-cog text-blue-500 mr-2"></i>
                                    Edit Voting Settings
                                </h3>
                                <form method="dialog">
                                    <button class="text-gray-400 hover:text-gray-600 transition-colors duration-150">
                                        <i class="fas fa-times text-lg"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Form Content -->
                            <div class="py-6">
                                <form class="space-y-6" id="voting-settings-form">
                                    @csrf

                                    <!-- Maximum Votes per User -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700" for="max_votes_per_user">
                                            Maximum Votes per User
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-users text-gray-400"></i>
                                            </div>
                                            <input
                                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-150"
                                                id="max_votes_per_user" name="max_votes_per_user" type="number"
                                                value="{{ $votingSettings->max_votes_per_user ?? 100 }}" min="1">
                                        </div>
                                        <p class="text-xs text-gray-500">Set the maximum number of votes allowed per user
                                        </p>
                                    </div>

                                    <!-- Vote Cost -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700" for="vote_cost">
                                            Vote Cost (credits)
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-coins text-gray-400"></i>
                                            </div>
                                            <input
                                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-150"
                                                id="vote_cost" name="vote_cost" type="number"
                                                value="{{ $votingSettings->vote_cost ?? 5 }}" min="0">
                                        </div>
                                        <p class="text-xs text-gray-500">Define how many credits each vote will cost</p>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">

                                        <button
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 flex items-center"
                                            type="submit">
                                            <i class="fas fa-save mr-2"></i>
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </dialog>

                </div>

                <!-- Rounds Content -->
                <div class="tab-content" id="rounds-content" style="display: none;">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Rounds Configuration</h3>
                    <p class="mb-4">Use the form below to configure the rounds for the selected event.</p>

                    <div class="w-full">
                        <form class="max-w-full mx-auto" method="POST"
                            action="{{ route('rounds.updateDescription') }}">
                            @csrf
                            <div class="relative z-0 w-full mb-5">

                                <label class="block mb-2 text-sm font-medium text-gray-800 dark:text-white">
                                    Event Rounds:
                                    <span
                                        class="bg-yellow-100 text-yellow-800 text-sm font-medium ms-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                        {{ $event->event_rounds }}
                                    </span>
                                </label>
                                <input name="event_id" type="hidden" value="{{ $event->id }}">
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <label class="block mb-2 text-sm font-medium text-gray-500" for="inputrounds">Select
                                    Round</label>
                                <select
                                    class="js-example-basic-single block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    id="inputrounds" name="round_number" data-popover-target="select-round">
                                    @foreach ($rounds as $round)
                                        <option value="{{ $round->round_number }}">{{ $round->round_number }} -
                                            {{ $round->round_description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <label class="block mb-2 text-sm font-medium text-gray-800 dark:text-white"
                                    for="top_contestants">
                                    Top Contestants Limit for Each Round
                                </label>
                                <input
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    id="top_contestants" name="top_contestants" type="number" placeholder="Enter limit"
                                    required />
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <label class="block mb-2 text-sm font-medium text-gray-800 dark:text-white"
                                    for="round_description">
                                    Round Description
                                </label>
                                <input
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    id="round_description" name="round_description" type="text"
                                    placeholder="Enter round description" required />
                            </div>

                            <button
                                class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm w-full sm:w-auto px-5 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="submit">
                                Submit <i class="fa-regular fa-circle-check"></i>
                            </button>
                        </form>
                    </div>
                </div>



                <!-- Criteria Content -->
                <div class="tab-content" id="criteria-content" style="display: none;">

                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Criteria Configuration</h3>
                    <p class="mb-4">Use the form below to configure criteria for the competition rounds.</p>

                    <div class="w-full mt-8">
                        <form class="max-w-full mx-auto" method="POST" action="{{ route('rounds.add-criteria') }}">
                            @csrf
                            <!-- Select Competition Round -->
                            <div class="relative z-0 w-full mb-5 group">
                                <label class="block mb-2 text-sm font-medium text-gray-500" for="round_id">Competition
                                    Round</label>
                                <select
                                    class="js-example-basic-single block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    id="round_id" name="round_id" required>
                                    @foreach ($rounds as $round)
                                        <option value="{{ $round->id }}"
                                            {{ old('round_id', session('round_id')) == $round->id ? 'selected' : '' }}>
                                            {{ $round->round_number }} - {{ $round->round_description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Criteria Description -->
                            <div class="relative z-0 w-full mb-5 group">
                                <label class="block mb-2 text-sm font-medium text-gray-500" for="criteria_description">
                                    Criteria Description
                                </label>
                                <input
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    id="criteria_description" name="criteria_description" type="text"
                                    placeholder="Enter criteria description" required />
                            </div>

                            <!-- Highest Rate -->
                            <div class="relative z-0 w-full mb-5 group">
                                <label class="block mb-2 text-sm font-medium text-gray-500" for="highest_rate">
                                    Highest Rate (%)
                                </label>
                                <input
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    id="highest_rate" name="highest_rate" type="number" min="0" max="100"
                                    placeholder="Enter highest rate (%)" required />
                            </div>

                            <!-- Lowest Rate -->
                            <div class="relative z-0 w-full mb-5 group">
                                <label class="block mb-2 text-sm font-medium text-gray-500" for="lowest_rate">
                                    Lowest Rate (%)
                                </label>
                                <input
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    id="lowest_rate" name="lowest_rate" type="number" min="0" max="100"
                                    placeholder="Enter lowest rate (%)" required />
                            </div>

                            <!-- Submit Button -->
                            <button
                                class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm w-full sm:w-auto px-5 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="submit">
                                Submit <i class="fa-regular fa-circle-check"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Committee Content -->
                <div class="tab-content" id="committee-content" style="display: none;">
                    <div class="">
                        <!-- Header Section -->
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                    <i class="fas fa-users text-blue-500 mr-3"></i>
                                    Committee Scoring
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Input scores for contestants</p>
                            </div>
                        </div>

                        <!-- Round and Criteria Selection -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Round</label>
                                <select
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    id="round_id" name="round_id">
                                    @foreach ($rounds as $round)
                                        <option value="{{ $round->id }}">{{ $round->round_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Criteria</label>
                                <select
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    id="criteria_id" name="criteria_id">
                                    @foreach ($criteria as $criterion)
                                        <option value="{{ $criterion->id }}">{{ $criterion->criteria_description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Scoring Form -->
                        <form class="space-y-6" id="scoringForm" action="{{ route('committee.scores.store') }}"
                            method="POST">
                            @csrf
                            <input name="event_id" type="hidden" value="{{ $event->id }}">
                            <input id="form_round_id" name="round_id" type="hidden">
                            <input id="form_criteria_id" name="criteria_id" type="hidden">

                            <!-- Contestants Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Contestant
                                            </th>
                                            @foreach ($judges as $judge)
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Judge {{ $judge->name }}
                                                </th>
                                            @endforeach
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Average Score
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($contestants as $contestant)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if ($contestant->image)
                                                                <img class="h-10 w-10 rounded-full"
                                                                    src="{{ asset('storage/' . $contestant->image) }}"
                                                                    alt="">
                                                            @else
                                                                <div
                                                                    class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                                    <i class="fas fa-user text-gray-400"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $contestant->name }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                #{{ $contestant->contestant_number }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                @foreach ($judges as $judge)
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <input
                                                            class="score-input rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                            name="scores[{{ $contestant->id }}][{{ $judge->id }}]"
                                                            type="number" min="1" max="10" required>
                                                    </td>
                                                @endforeach
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="average-score text-sm font-medium text-gray-900">-</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end mt-6">
                                <button
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    type="submit">
                                    <i class="fas fa-save mr-2"></i>
                                    Save Scores
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- TIME Limit Content -->
                <div class="tab-content" id="limit-content" style="display: none;">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Set Time Schedule</h3>
                    <form class="space-y-4" action="{{ route('schedule.store', $event->id) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="time_start">
                                    Start Time
                                </label>
                                <input
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    id="time_start" name="time_start" type="datetime-local"
                                    value="{{ $event->timeSchedule ? $event->timeSchedule->time_start->format('Y-m-d\TH:i') : '' }}"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="time_end">
                                    End Time
                                </label>
                                <input
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    id="time_end" name="time_end" type="datetime-local"
                                    value="{{ $event->timeSchedule ? $event->timeSchedule->time_end->format('Y-m-d\TH:i') : '' }}"
                                    required>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700" type="submit">
                                Save Schedule
                            </button>
                        </div>
                    </form>

                    @if ($event->timeSchedule)
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900">Current Schedule</h4>
                            <p class="text-gray-600">
                                Start: {{ $event->timeSchedule->time_start->format('M d, Y g:i A') }}
                            </p>
                            <p class="text-gray-600">
                                End: {{ $event->timeSchedule->time_end->format('M d, Y g:i A') }}
                            </p>

                            <!-- Duration display -->
                            <p class="text-gray-600 mt-2">
                                Duration:
                                {{ $event->timeSchedule->time_start->diffForHumans($event->timeSchedule->time_end, true) }}
                            </p>

                            <form class="mt-2" action="{{ route('schedule.destroy', $event->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 text-sm" type="submit">
                                    Remove Schedule
                                </button>
                            </form>
                        </div>
                    @endif


                    <!-- Live Stream Link Section -->
                    <div class="mt-8 border-t pt-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-broadcast-tower text-red-500 mr-2"></i>
                            Live Stream Link
                        </h4>

                        <form class="space-y-4" action="{{ route('live-link.store', $event->id) }}" method="POST">
                            @csrf
                            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="fb_embed_link">
                                    Facebook Live Stream URL
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fab fa-facebook text-blue-600"></i>
                                    </div>
                                    <input
                                        class="pl-10 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200"
                                        id="fb_embed_link" name="fb_embed_link" type="url"
                                        value="{{ $event->liveLink->fb_embed_link ?? '' }}"
                                        placeholder="https://www.facebook.com/plugins/video.php?href=...">
                                </div>
                                <p class="mt-2 text-xs text-gray-500 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Paste the Facebook video or post embed URL for live streaming
                                </p>

                                <div class="mt-4 flex items-center justify-end space-x-3">
                                    @if ($event->liveLink && $event->liveLink->fb_embed_link)
                                        <button
                                            class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200"
                                            type="button" onclick="confirmLiveLinkDelete({{ $event->id }})">
                                            <i class="fas fa-trash-alt text-red-500 mr-2"></i>
                                            Remove Link
                                        </button>
                                    @endif
                                    <button
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200"
                                        type="submit">
                                        <i class="fas fa-save mr-2"></i>
                                        Save Live Stream
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if ($event->liveLink && $event->liveLink->fb_embed_link)
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <h5 class="text-sm font-medium text-gray-700 mb-2">Current Live Stream</h5>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="flex h-3 w-3">
                                            <span
                                                class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                        </span>
                                        <a class="text-blue-600 hover:text-blue-800 text-sm truncate max-w-md"
                                            href="{{ $event->liveLink->fb_embed_link }}" target="_blank">
                                            {{ $event->liveLink->fb_embed_link }}
                                        </a>
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        Added {{ $event->liveLink->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>


                <!-- Update the delete form -->
                <form id="delete-live-link-form-{{ $event->id }}" style="display: none;"
                    action="{{ route('live-link.destroy', $event->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>


                <!-- View Content data -->
                <div class="tab-content" id="view-content">
                    <!-- Header Section -->
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Criteria Management</h3>
                        <p class="mt-2 text-sm text-gray-600">View and manage all criteria for the competition rounds</p>
                    </div>

                    <!-- Success Alert -->
                    @if (session('successDelete'))
                        <div class="flex items-center p-4 mb-6 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Success!</span> {{ session('successDelete') }}
                            </div>
                        </div>
                    @endif

                    <!-- Main Content Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Table Header with Stats -->
                        <div class="p-4 bg-gray-50 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-list-check text-blue-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">Total Criteria:
                                            {{ $criteria->count() }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-eye-slash text-gray-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">Hidden:
                                            {{ $criteria->where('is_hidden', true)->count() }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button
                                        class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-download mr-1"></i> Export
                                    </button>
                                    <button
                                        class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-plus mr-1"></i> Add New
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" id="myTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            scope="col">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            scope="col">Round</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            scope="col">Criteria</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            scope="col">Rating Range</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            scope="col">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($criteria as $criterion)
                                        <tr
                                            data-criteria-id="{{ $criterion->id }}"
                                            class="hover:bg-gray-50 transition-colors duration-200 {{ $criterion->is_hidden ? 'opacity-50' : '' }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                #{{ $criterion->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $criterion->round->round_description }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $criterion->criteria_description }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                                                        {{ $criterion->highest_rate }} - {{ $criterion->lowest_rate }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 py-1 text-xs font-medium rounded-full {{ $criterion->is_hidden ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $criterion->is_hidden ? 'Hidden' : 'Visible' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-3">
                                                    <button class="text-blue-600 hover:text-blue-900" title="Edit" onclick="openEditCriteriaModal({{ $criterion->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="text-red-600 hover:text-red-900" title="Delete"
                                                        onclick="confirmDelete({{ $criterion->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="text-gray-600 hover:text-gray-900"
                                                        data-criteria-id="{{ $criterion->id }}"
                                                        title="Hide from selected judges"
                                                        onclick="openHideForJudgesModal({{ $criterion->id }})">
                                                        <i class="fas fa-user-slash"></i>
                                                    </button>
                                                    <button class="text-gray-600 hover:text-gray-900"
                                                        data-criteria-id="{{ $criterion->id }}"
                                                        title="{{ $criterion->is_hidden ? 'Show to everyone' : 'Hide to everyone' }}"
                                                        onclick="toggleCriteriaVisibility({{ $criterion->id }})">
                                                        <i
                                                            class="fas {{ $criterion->is_hidden ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Table Footer with Summary -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div class="text-sm text-gray-600" id="roundTotals"></div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
    </div>

    <!-- Hide for Judges Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" id="hideForJudgesModal">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Select judges to hide this criteria</h3>
            <div class="max-h-60 overflow-y-auto space-y-2">
                @foreach ($judges as $judge)
                    <label class="flex items-center space-x-2">
                        <input class="form-checkbox h-4 w-4 text-indigo-600" type="checkbox"
                            value="{{ $judge->id }}">
                        <span>{{ $judge->name }}</span>
                    </label>
                @endforeach
            </div>
            <div class="mt-6 flex justify-end space-x-2">
                <button class="px-4 py-2 bg-gray-200 rounded" onclick="closeHideForJudgesModal()">Cancel</button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded" onclick="submitHideForJudges()">Save</button>
            </div>
        </div>
    </div>

    <!-- Edit Criteria Modal -->
    <div class="fixed inset-0  hidden items-center justify-center z-100 p-4" id="editCriteriaModal">
        <div class="bg-white overflow-y-auto flex-1 rounded-xl shadow-2xl w-full max-w-5xl max-h-[600px] flex flex-col">
            <!-- Modal Header -->
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Edit Criteria</h3>
                <button class="text-gray-400 hover:text-gray-700" onclick="closeEditCriteriaModal()">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Scrollable Body -->
            <div class="overflow-y-auto flex-1 p-6 h-[500px]">
                <form id="editCriteriaForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_criteria_id" name="id">
                <input type="hidden" id="edit_event_id">

                <!-- TOP ROW: Criteria Fields | Production Scores -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- LEFT: Criteria Fields -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">Criteria Settings</h4>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="edit_round_id">Round</label>
                            <select
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                id="edit_round_id" name="round_id" required>
                                @foreach ($rounds as $round)
                                    <option value="{{ $round->id }}">{{ $round->round_number }} - {{ $round->round_description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="edit_criteria_description">Criteria Description</label>
                            <input
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                id="edit_criteria_description" name="criteria_description" type="text" required />
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="edit_highest_rate">Highest Rate (%)</label>
                                <input
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    id="edit_highest_rate" name="highest_rate" type="number" min="0" max="100" required />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="edit_lowest_rate">Lowest Rate (%)</label>
                                <input
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    id="edit_lowest_rate" name="lowest_rate" type="number" min="0" max="100" required />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="scoring_judge_id">Judge Selection (for scoring)</label>
                            <select
                                id="scoring_judge_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Judge</option>
                                @foreach($judges as $judge)
                                    <option value="{{ $judge->id }}">{{ $judge->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- RIGHT: Production Number Scores -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Production Number Scores</h4>
                            <span id="productionRateHint" class="text-xs text-blue-600 font-medium"></span>
                        </div>
                        <p class="text-xs text-gray-500 mb-3">Enter the production score for each contestant within the allowed rate range.</p>
                        <div class="overflow-x-auto max-h-56 overflow-y-auto rounded border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 sticky top-0">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Contestant</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                                    </tr>
                                </thead>
                                <tbody id="productionScoresBody" class="bg-white divide-y divide-gray-200">
                                    <!-- Populated by JS -->
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <button type="button" id="saveProductionScoresBtn"
                                class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <i class="fas fa-save mr-1"></i> Save Production Scores
                            </button>
                            <span id="productionSaveStatus" class="text-xs text-gray-500"></span>
                        </div>
                    </div>
                </div>

                <!-- BOTTOM: Minor Award Scores Reference -->
                <div class="mt-6" id="minorAwardScoresSection">
                    <div class="flex items-center gap-2 mb-2">
                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Minor Award Scores <span class="normal-case font-normal text-gray-400">(reference)</span></h4>
                        <span id="minorAwardLoadStatus" class="text-xs text-gray-400 ml-1"></span>
                    </div>
                    <p class="text-xs text-gray-500 mb-3">Average scores per contestant across all judges for each minor award. Use these as reference when combining with round scores.</p>
                    <div id="minorAwardTablesWrapper" class="space-y-4">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="mt-6 flex justify-end space-x-2 border-t border-gray-100 pt-4">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300" onclick="closeEditCriteriaModal()">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Criteria</button>
                </div>

            </form>
            </div><!-- end scrollable body -->
        </div>
    </div>


    <!-- Script for calculating round totals -->
    <script>
        function confirmLiveLinkDelete(eventId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will remove the live stream link. This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, remove it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-live-link-form-${eventId}`).submit();
                }
            });
        }
    </script>
    <script>
        function calculateRoundTotals() {
            const table = document.getElementById('myTable');
            const rows = table.getElementsByTagName('tr');
            const roundTotals = {};

            // Skip the header row
            for (let i = 1; i < rows.length - 1; i++) { // Exclude the last row (footer)
                const cells = rows[i].getElementsByTagName('td');
                if (cells.length > 0) {
                    const roundDescription = cells[1].textContent.trim();
                    // Get the highest rate from the rating range cell
                    const ratingRange = cells[3].textContent.trim();
                    const highestRate = parseFloat(ratingRange.split('-')[0].trim());

                    if (!roundTotals[roundDescription]) {
                        roundTotals[roundDescription] = 0;
                    }
                    roundTotals[roundDescription] += highestRate;
                }
            }

            // Display the totals
            const roundTotalsDiv = document.getElementById('roundTotals');
            roundTotalsDiv.innerHTML = ''; // Clear previous totals

            for (const [round, total] of Object.entries(roundTotals)) {
                const roundTotalP = document.createElement('p');
                roundTotalP.innerHTML = `
                    <span class="font-semibold text-blue-600 dark:text-blue-400">
                        ${round}: 
                    </span>
                    <span class="text-gray-700 dark:text-gray-300">
                        Total Highest Rate = ${total.toFixed(2)}%
                    </span>
                `;
                roundTotalsDiv.appendChild(roundTotalP);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            calculateRoundTotals();

            // If you're using DataTables, recalculate after each draw event
            if ($.fn.dataTable.isDataTable('#myTable')) {
                $('#myTable').on('draw.dt', calculateRoundTotals);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#updateTopContestantsForm').on('submit', function(event) {
                event.preventDefault();

                let formData = {
                    _token: $('input[name="_token"]').val(),
                    top_contestant_limit: $('#top_contestant_limit').val(),
                };

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Update the UI with the new value
                            $('#currentTopContestantLimit').html(`
                    Limit: 
                    <kbd class="px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">
                        ${response.top_contestant_limit}
                    </kbd>
                `);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while updating the settings.');
                    }
                });
            });
        });
    </script>
    <script>
        // Function to delete a minor award
        function deleteMinorAward(button) {
            let id = button.getAttribute('data-id');

            fetch(`/minor-awards/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the deleted row from the table
                        button.closest('tr').remove();
                    } else {
                        // Handle errors if the minor award was not found or couldn't be deleted
                        console.log(data.message);
                    }
                })
                .catch(error => console.log('Error:', error));
        }

        // Submit form via AJAX
        document.getElementById('minor-award-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            let formData = new FormData(this);
            fetch('{{ route('store_minor_awards', $event->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Append new row to the table
                        let table = document.querySelector('table tbody');
                        let newRow = table.insertRow();

                        newRow.innerHTML = `
                            <tr>
                                <td class="px-4 py-2">${data.minor_award.minor_awards_description}</td>
                                <td class="px-4 py-2">${data.minor_award.high_rate}</td>
                                <td class="px-4 py-2">${data.minor_award.low_rate}</td>
                                <td class="px-4 py-2">
                                    <button class="text-red-600 hover:text-red-900" data-id="${data.minor_award.id}" onclick="deleteMinorAward(this)">
                                       <i class="fa-solid fa-trash-can-arrow-up"></i>
                                    </button>
                                </td>
                            </tr>
                        `;

                        // Clear the form fields
                        document.getElementById('minor-award-form').reset();
                    } else {
                        // Handle validation errors
                        console.log(data.errors);
                    }
                })
                .catch(error => console.log('Error:', error));
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "paging": true,
                "searching": true,
                "lengthChange": true,
                "pageLength": 10,
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
            });
        }
    </script>
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this criterion?')) {
                document.getElementById('deleteForm-' + id).submit();
            }
        }
    </script>
    <script>
        // Base URL for API calls — uses Laravel url() helper to handle subdirectory installs
        const appBaseUrl = '{{ rtrim(url('/'), '/') }}';

        // Edit criteria functionality
        function openEditCriteriaModal(criteriaId) {
            // Validate the criteriaId before making the request
            if (!criteriaId || isNaN(criteriaId)) {
                alert('Invalid criteria ID');
                return;
            }
                    
            fetch(`${appBaseUrl}/criteria/${criteriaId}/edit`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 401) {
                            window.location.href = '/login'; // Redirect to login if unauthorized
                            return;
                        }
                        if (response.status === 404) {
                            alert('Criteria not found. It may have been deleted.');
                            return;
                        }
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById('edit_criteria_id').value = data.criterion.id;
                        document.getElementById('edit_round_id').value = data.criterion.round_id;
                        document.getElementById('edit_criteria_description').value = data.criterion.criteria_description;
                        document.getElementById('edit_highest_rate').value = data.criterion.highest_rate;
                        document.getElementById('edit_lowest_rate').value = data.criterion.lowest_rate;
                        document.getElementById('edit_event_id').value = data.criterion.event_id ?? '';

                        // Reset judge selector
                        const judgeSelect = document.getElementById('scoring_judge_id');
                        if (judgeSelect) judgeSelect.value = '';

                        // Always show production scores section and load scores
                        loadProductionScores(criteriaId, data.criterion.highest_rate, data.criterion.lowest_rate);

                        // Load minor award scores as reference
                        loadMinorAwardScores(data.criterion.event_id);
                                
                        document.getElementById('editCriteriaModal').classList.remove('hidden');
                        document.getElementById('editCriteriaModal').classList.add('flex');
                    } else {
                        alert(data.message || 'Error loading criteria data');
                    }
                })
                .catch(error => {
                    console.error('Error fetching criteria data:', error);
                    if (error.message.includes('401')) {
                        alert('Session expired. Please log in again.');
                        window.location.href = '/login';
                    } else if (error.message.includes('404')) {
                        alert('Criteria not found. It may have been deleted.');
                    } else {
                        alert('Error loading criteria data');
                    }
                });
        }
        
        // Stores current criteriaId for the save button handler
        let _currentProductionCriteriaId = null;

        function loadProductionScores(criteriaId, highestRate, lowestRate, judgeId = '') {
            _currentProductionCriteriaId = criteriaId;

            // Update the rate range hint
            const hint = document.getElementById('productionRateHint');
            if (hint) {
                hint.textContent = `Score range: ${lowestRate}% – ${highestRate}%`;
            }

            // Fetch production scores for this criteria and populate the table
            let url = `${appBaseUrl}/criteria/${criteriaId}/production-scores`;
            if (judgeId) {
                url += `?judge_id=${judgeId}`;
            }

            fetch(url, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 401) {
                            window.location.href = '/login';
                            return;
                        }
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const tbody = document.getElementById('productionScoresBody');
                        tbody.innerHTML = ''; // Clear existing rows

                        const lo = data.lowest_rate;
                        const hi = data.highest_rate;

                        data.scores.forEach(score => {
                            const tr = document.createElement('tr');
                            tr.dataset.contestantId = score.contestant_id;
                            tr.innerHTML =
                                `<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${score.contestant_number ?? ''}</td>` +
                                `<td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">${score.contestant_name}</td>` +
                                `<td class="px-4 py-2 whitespace-nowrap">
                                    <input type="number"
                                        class="production-score-input w-24 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                        data-contestant-id="${score.contestant_id}"
                                        value="${score.score !== null ? score.score : ''}"
                                        min="${lo}" max="${hi}"
                                        placeholder="${lo}–${hi}">
                                </td>`;
                            tbody.appendChild(tr);
                        });

                        // Reset save status
                        const status = document.getElementById('productionSaveStatus');
                        if (status) status.textContent = '';
                    } else {
                        console.error('Error loading production scores:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading production scores:', error);
                    if (error.message.includes('401')) {
                        alert('Session expired. Please log in again.');
                        window.location.href = '/login';
                    }
                });
        }

        // Load minor award scores for reference panel
        function loadMinorAwardScores(eventId) {
            if (!eventId) return;
            const wrapper = document.getElementById('minorAwardTablesWrapper');
            const status = document.getElementById('minorAwardLoadStatus');
            wrapper.innerHTML = '<p class="text-xs text-gray-400">Loading...</p>';

            fetch(`${appBaseUrl}/events/${eventId}/minor-award-scores`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(r => r.json())
            .then(data => {
                wrapper.innerHTML = '';
                if (!data.success || !data.minor_awards || data.minor_awards.length === 0) {
                    wrapper.innerHTML = '<p class="text-xs text-gray-400 italic">No minor award scores yet.</p>';
                    return;
                }

                data.minor_awards.forEach(award => {
                    const hasScores = award.contestants.some(c => c.avg_score !== null);
                    const card = document.createElement('div');
                    card.className = 'border border-gray-200 rounded-lg overflow-hidden';

                    // Header
                    const header = document.createElement('div');
                    header.className = 'flex items-center justify-between px-4 py-2 bg-gray-50 cursor-pointer select-none';
                    header.innerHTML =
                        `<span class="text-sm font-semibold text-gray-700">${award.name}</span>` +
                        `<span class="text-xs text-gray-500">Range: ${award.low_rate}% – ${award.high_rate}%` +
                        (hasScores ? '' : ' <em class="text-gray-400">(no scores yet)</em>') + '</span>';

                    // Table body
                    const tableWrap = document.createElement('div');
                    tableWrap.className = 'overflow-x-auto max-h-48 overflow-y-auto';

                    const table = document.createElement('table');
                    table.className = 'min-w-full divide-y divide-gray-200 text-sm';
                    table.innerHTML =
                        '<thead class="bg-gray-50 sticky top-0"><tr>' +
                        '<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>' +
                        '<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Contestant</th>' +
                        '<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Avg Score</th>' +
                        '</tr></thead>';

                    const tbody = document.createElement('tbody');
                    tbody.className = 'bg-white divide-y divide-gray-200';
                    award.contestants.forEach(c => {
                        const tr = document.createElement('tr');
                        const scoreDisplay = c.avg_score !== null
                            ? `<span class="font-semibold text-blue-700">${c.avg_score}</span>`
                            : '<span class="text-gray-300">—</span>';
                        tr.innerHTML =
                            `<td class="px-4 py-2 text-gray-500">${c.contestant_number ?? ''}</td>` +
                            `<td class="px-4 py-2 font-medium text-gray-800">${c.contestant_name}</td>` +
                            `<td class="px-4 py-2">${scoreDisplay}</td>`;
                        tbody.appendChild(tr);
                    });
                    table.appendChild(tbody);
                    tableWrap.appendChild(table);

                    // Toggle collapse
                    let collapsed = false;
                    header.addEventListener('click', () => {
                        collapsed = !collapsed;
                        tableWrap.style.display = collapsed ? 'none' : '';
                    });

                    card.appendChild(header);
                    card.appendChild(tableWrap);
                    wrapper.appendChild(card);
                });

                if (status) status.textContent = '';
            })
            .catch(err => {
                console.error('Error loading minor award scores:', err);
                wrapper.innerHTML = '<p class="text-xs text-red-400">Failed to load minor award scores.</p>';
            });
        }

        // Judge selector change handler
        document.getElementById('scoring_judge_id').addEventListener('change', function() {
            const criteriaId = _currentProductionCriteriaId;
            if (!criteriaId) return;
            
            const highestRate = parseFloat(document.getElementById('edit_highest_rate').value);
            const lowestRate = parseFloat(document.getElementById('edit_lowest_rate').value);
            const judgeId = this.value;
            
            loadProductionScores(criteriaId, highestRate, lowestRate, judgeId);
        });

        document.getElementById('saveProductionScoresBtn').addEventListener('click', function() {
            const criteriaId = _currentProductionCriteriaId;
            if (!criteriaId) return;

            const inputs = document.querySelectorAll('.production-score-input');
            const saveStatus = document.getElementById('productionSaveStatus');
            saveStatus.textContent = 'Saving...';

            const judgeId = document.getElementById('scoring_judge_id').value;

            // Read highest/lowest from the current edit modal inputs
            const highestRate = parseFloat(document.getElementById('edit_highest_rate').value);
            const lowestRate = parseFloat(document.getElementById('edit_lowest_rate').value);

            // Validate all inputs first
            let hasError = false;
            inputs.forEach(input => {
                const val = input.value.trim();
                if (val === '') return; // allow empty (skip contestant)
                const num = parseFloat(val);
                if (isNaN(num) || num < lowestRate || num > highestRate) {
                    input.classList.add('border-red-500');
                    hasError = true;
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            if (hasError) {
                saveStatus.textContent = `⚠ Some scores are out of range (${lowestRate}–${highestRate}).`;
                saveStatus.className = 'text-xs text-red-600';
                return;
            }

            // Build promise array for each non-empty score
            const promises = [];
            inputs.forEach(input => {
                const val = input.value.trim();
                if (val === '') return;
                const contestantId = input.dataset.contestantId;
                promises.push(
                    fetch(`${appBaseUrl}/criteria/${criteriaId}/production-scores/${contestantId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ 
                            score: parseFloat(val),
                            user_id: judgeId || null
                        })
                    }).then(r => r.json())
                );
            });

            if (promises.length === 0) {
                saveStatus.textContent = 'No scores to save.';
                saveStatus.className = 'text-xs text-gray-500';
                return;
            }

            Promise.all(promises)
                .then(results => {
                    const allOk = results.every(r => r.success);
                    if (allOk) {
                        saveStatus.textContent = '✓ Scores saved successfully!';
                        saveStatus.className = 'text-xs text-green-600';
                    } else {
                        saveStatus.textContent = '⚠ Some scores could not be saved.';
                        saveStatus.className = 'text-xs text-red-600';
                    }
                })
                .catch(err => {
                    console.error('Error saving production scores:', err);
                    saveStatus.textContent = '✗ Error saving scores.';
                    saveStatus.className = 'text-xs text-red-600';
                });
        });
        
        function closeEditCriteriaModal() {
            document.getElementById('editCriteriaModal').classList.add('hidden');
            document.getElementById('editCriteriaModal').classList.remove('flex');
        }
    
        document.getElementById('editCriteriaForm').addEventListener('submit', function(e) {
            e.preventDefault();
                    
            const formData = new FormData(this);
            const criteriaId = document.getElementById('edit_criteria_id').value;
                    
            fetch(`${appBaseUrl}/criteria/${criteriaId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 401) {
                        window.location.href = '/login'; // Redirect to login if unauthorized
                        return;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update the row in the table
                    const row = document.querySelector(`tr[data-criteria-id="${criteriaId}"]`);
                    if (row) {
                        // Update round description
                        const roundCell = row.querySelector('td:nth-child(2) div.text-sm.font-medium');
                        if (roundCell) {
                            roundCell.textContent = document.getElementById('edit_round_id').selectedOptions[0].text;
                        }
                        // Update criteria description
                        const criteriaCell = row.querySelector('td:nth-child(3) div.text-sm.text-gray-900');
                        if (criteriaCell) {
                            criteriaCell.textContent = document.getElementById('edit_criteria_description').value;
                        }
                        // Update rating range
                        const ratingCell = row.querySelector('td:nth-child(4) span');
                        if (ratingCell) {
                            ratingCell.innerHTML = `${document.getElementById('edit_highest_rate').value} - ${document.getElementById('edit_lowest_rate').value}`;
                            ratingCell.className = "px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full";
                        }
                    }
                            
                    closeEditCriteriaModal();
                    alert('Criteria updated successfully!');
                    location.reload(); // Refresh the page to show updated data
                } else {
                    alert(data.message || 'Error updating criteria');
                }
            })
            .catch(error => {
                console.error('Error updating criteria:', error);
                if (error.message.includes('401')) {
                    alert('Session expired. Please log in again.');
                    window.location.href = '/login';
                } else {
                    alert('Error updating criteria');
                }
            });
        });
    </script>
    <script>
        // JavaScript code to handle tab switching
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');
        let activeTab = localStorage.getItem('activeTab') || 'awards'; // Default active tab

        function updateActiveTab() {
            // Remove active class from all tab links
            tabLinks.forEach(link => link.classList.remove('active'));

            // Add active class to the currently active tab link
            const activeLink = document.querySelector(`[data-tab="${activeTab}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }

            // Hide all tab contents
            tabContents.forEach(content => content.style.display = 'none');

            // Show the corresponding tab content
            const activeContent = document.getElementById(`${activeTab}-content`);
            if (activeContent) {
                activeContent.style.display = 'block';
            }
        }

        tabLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                activeTab = this.getAttribute('data-tab'); // Get the tab ID from data attribute
                localStorage.setItem('activeTab', activeTab); // Store active tab in local storage
                updateActiveTab(); // Update the active tab state
            });
        });

        // Call updateActiveTab on page load to set the correct tab
        document.addEventListener('DOMContentLoaded', updateActiveTab);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks = document.querySelectorAll('.tab-link');

            tabLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabLinks.forEach(link => link.classList.remove('active'));

                    // Add active class to the clicked tab
                    this.classList.add('active');
                });
            });
        });
    </script>

    <script>
        function openHideForJudgesModal(criteriaId) {
            const modal = document.getElementById('hideForJudgesModal');
            modal.dataset.criteriaId = criteriaId;
            
            // Clear all checkboxes first
            document.querySelectorAll('#hideForJudgesModal input[type="checkbox"]').forEach(cb => cb.checked = false);

            // Fetch criteria data to get currently hidden judges
            fetch(`${appBaseUrl}/criteria/${criteriaId}/edit`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.criterion.hidden_judge_ids) {
                    const hiddenIds = data.criterion.hidden_judge_ids;
                    // Pre-check the checkboxes for hidden judges
                    document.querySelectorAll('#hideForJudgesModal input[type="checkbox"]').forEach(cb => {
                        if (hiddenIds.includes(parseInt(cb.value))) {
                            cb.checked = true;
                        }
                    });
                }
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            })
            .catch(error => {
                console.error('Error fetching criteria data:', error);
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        }

        function closeHideForJudgesModal() {
            const modal = document.getElementById('hideForJudgesModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        async function submitHideForJudges() {
            const modal = document.getElementById('hideForJudgesModal');
            const criteriaId = modal.dataset.criteriaId;
            const selected = Array.from(document.querySelectorAll('#hideForJudgesModal input[type="checkbox"]:checked'))
                .map(cb => cb.value);

            try {
                const response = await fetch(`{{ url('/criteria') }}/${criteriaId}/hidden-judges`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        judge_ids: selected
                    })
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(errorText || 'Request failed');
                }

                const data = await response.json();
                if (data && data.success) {
                    closeHideForJudgesModal();
                    Swal.fire('Updated', 'Hidden judges updated for this criteria', 'success');
                } else {
                    throw new Error((data && data.message) || 'Failed to update');
                }
            } catch (e) {
                console.error('Hidden judges update error:', e);
                Swal.fire('Error', 'Unable to update hidden judges', 'error');
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roundSelect = document.getElementById('round_id');
            const criteriaSelect = document.getElementById('criteria_id');
            const formRoundId = document.getElementById('form_round_id');
            const formCriteriaId = document.getElementById('form_criteria_id');

            // Update hidden form fields when selections change
            roundSelect.addEventListener('change', function() {
                formRoundId.value = this.value;
                loadExistingScores();
            });

            criteriaSelect.addEventListener('change', function() {
                formCriteriaId.value = this.value;
                loadExistingScores();
            });

            // Function to load existing scores
            function loadExistingScores() {
                const eventId = '{{ $event->id }}';
                const roundId = roundSelect.value;
                const criteriaId = criteriaSelect.value;
            
                fetch(`/committee/scores?event_id=${eventId}&round_id=${roundId}&criteria_id=${criteriaId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(scores => {
                        scores.forEach(score => {
                            // Look for input with score data - using a more flexible selector
                            const inputs = document.querySelectorAll(`input[name*="[${score.contestant_id}]"]`);
                            
                            inputs.forEach(input => {
                                if(input.name.includes(`[${score.contestant_id}]`)) {
                                    input.value = score.rate;
                                    const previousScoreSpan = input.closest('tr')?.querySelector('.previous-score');
                                    if(previousScoreSpan) {
                                        previousScoreSpan.textContent = score.rate;
                                    }
                                }
                            });
                        });
                    })
                    .catch(error => {
                        console.error('Error loading scores:', error);
                    });
            }

            // Set initial values
            formRoundId.value = roundSelect.value;
            formCriteriaId.value = criteriaSelect.value;

            // Load scores on page load
            loadExistingScores();
        });
    </script>

    <script>
        function toggleCriteriaVisibility(criteriaId) {
            $.ajax({
                url: `/criteria/${criteriaId}/toggle-visibility`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Get the button and its row
                        const button = $(`button[data-criteria-id="${criteriaId}"]`);
                        const row = button.closest('tr');
                        const icon = button.find('i');
                        const statusSpan = row.find('td:nth-child(5) span');

                        if (response.is_hidden) {
                            // Update icon
                            icon.removeClass('fa-eye-slash').addClass('fa-eye');
                            // Update row opacity
                            row.addClass('opacity-50');
                            // Update status text and style
                            statusSpan.text('Hidden')
                                .removeClass('bg-green-100 text-green-800')
                                .addClass('bg-gray-100 text-gray-800');
                            // Update button title
                            button.attr('title', 'Show');
                        } else {
                            // Update icon
                            icon.removeClass('fa-eye').addClass('fa-eye-slash');
                            // Update row opacity
                            row.removeClass('opacity-50');
                            // Update status text and style
                            statusSpan.text('Visible')
                                .removeClass('bg-gray-100 text-gray-800')
                                .addClass('bg-green-100 text-green-800');
                            // Update button title
                            button.attr('title', 'Hide');
                        }

                        // Update the hidden count in the header
                        const hiddenCount = $('tr.opacity-50').length;
                        $('.fa-eye-slash').closest('.flex').find('span').text(`Hidden: ${hiddenCount}`);
                    }
                },
                error: function(xhr) {
                    console.error('Error toggling visibility:', xhr);
                    alert('Failed to update visibility. Please try again.');
                }
            });
        }
    </script>

    <!-- Add this script section at the bottom of your committee-content div -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('scoringForm');
            const roundSelect = document.getElementById('round_id');
            const criteriaSelect = document.getElementById('criteria_id');
            const formRoundId = document.getElementById('form_round_id');
            const formCriteriaId = document.getElementById('form_criteria_id');

            // Update hidden form fields when selections change
            roundSelect.addEventListener('change', function() {
                formRoundId.value = this.value;
            });

            criteriaSelect.addEventListener('change', function() {
                formCriteriaId.value = this.value;
            });

            // Set initial values
            formRoundId.value = roundSelect.value;
            formCriteriaId.value = criteriaSelect.value;

            // Calculate average scores
            function calculateAverage(row) {
                const inputs = row.querySelectorAll('.score-input');
                const values = Array.from(inputs).map(input => parseFloat(input.value) || 0);
                const average = values.reduce((a, b) => a + b, 0) / values.length;
                return average.toFixed(2);
            }

            // Update average when scores change
            document.querySelectorAll('.score-input').forEach(input => {
                input.addEventListener('input', function() {
                    const row = this.closest('tr');
                    const averageScore = row.querySelector('.average-score');
                    averageScore.textContent = calculateAverage(row);
                });
            });
        });
    </script>
@endsection
