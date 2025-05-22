@extends('layouts.Supper_admin')

@section('content')
    <div class="container mx-auto px-4 py-6 min-h-screen" x-data="{ showTable: false }" x-init="setTimeout(() => showTable = true, 100)">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Dashboard Header -->
            <div class="mb-8 fade-in">
                <h2 class="text-3xl font-bold text-gray-800 leading-tight">
                    PayPal Transactions
                </h2>
                <p class="mt-2 text-gray-600">Manage and monitor all PayPal transactions</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6 transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Transactions</p>
                            <p class="text-lg font-semibold text-gray-700">{{ $transactions->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Completed Transactions</p>
                            <p class="text-lg font-semibold text-gray-700">
                                {{ $transactions->where('status', 'COMPLETED')->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Amount</p>
                            <p class="text-lg font-semibold text-gray-700">
                                ${{ number_format($transactions->sum('amount'), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden" x-show="showTable"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0">

                <!-- Search and Filter Section -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <div class="relative">
                            <input
                                class="pl-10 pr-10 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                id="searchInput" type="text" placeholder="Search transactions...">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <button class="clear-search absolute right-3 top-2.5 text-gray-400 hover:text-gray-600"
                                style="display: none;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>


                        <div class="flex space-x-4">
                            <select
                                class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                id="statusFilter">
                                <option value="">All Status</option>
                                <option value="COMPLETED">Completed</option>
                                <option value="PENDING">Pending</option>
                                <option value="FAILED">Failed</option>
                            </select>
                            <button
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                id="exportCSV">
                                <i class="fas fa-download mr-2"></i>Export CSV
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <!-- Table -->
                    <table class="min-w-full divide-y divide-gray-200" id="transactionsTable">
                        <!-- Table headers -->
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach (['Date', 'Description', 'Name', 'Status', 'Gross', 'Fee', 'Net', 'Actions'] as $header)
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ $header }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <!-- Table body -->
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $transaction->created_at->format('m/d/y, g:i A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Payment from
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800">
                                        {{ $transaction->payer_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $transaction->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ₱{{ number_format($transaction->amount, 2) }} PHP
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">
                                        ₱{{ number_format($transaction->paypal_fee, 2) }} PHP
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                        ₱{{ number_format($transaction->net_amount, 2) }} PHP
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z">
                                                </path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 text-center text-gray-500" colspan="8">
                                        No transactions found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!--Felter-->
    <script>
        $(document).ready(function() {
            const $statusFilter = $("#statusFilter");
            const $table = $("#transactionsTable");
            const $tbody = $table.find("tbody");
            const $noResults = $(`
            <tr id="noResults">
                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>No transactions found</p>
                        <p class="text-sm text-gray-400">Try adjusting your filters</p>
                    </div>
                </td>
            </tr>
        `);

            // Function to filter table
            function filterTable() {
                const statusValue = $statusFilter.val().toLowerCase();
                let visibleRows = 0;

                // Remove existing no results row
                $("#noResults").remove();

                // Show loading state
                $table.addClass('opacity-50');

                setTimeout(() => {
                    $tbody.find("tr").each(function() {
                        const $row = $(this);
                        const statusCell = $row.find("td:nth-child(4)").text().toLowerCase().trim();

                        // If no status is selected (All Status) or status matches
                        const showRow = !statusValue || statusCell.includes(statusValue);

                        $row.toggle(showRow);
                        if (showRow) visibleRows++;
                    });

                    // Show no results message if no matching rows
                    if (visibleRows === 0) {
                        $tbody.append($noResults);
                    }

                    // Remove loading state
                    $table.removeClass('opacity-50');
                }, 200);
            }

            // Filter on status change
            $statusFilter.on("change", filterTable);

            // Add reset functionality
            function resetFilters() {
                $statusFilter.val("");
                filterTable();
            }

            // Optional: Add a reset button
            $(`<button class="ml-2 px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition-colors duration-200">
            <i class="fas fa-undo mr-1"></i>Reset
        </button>`).insertAfter($statusFilter).click(resetFilters);
        });
    </script>
    <!-- Add these styles -->
    <style>
        /* Loading state */
        .opacity-50 {
            opacity: 0.5;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        /* Select styling */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 1em;
            padding-right: 2.5rem;
        }

        /* Transition effects */
        tr {
            transition: all 0.2s ease-in-out;
        }

        /* No results animation */
        #noResults {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fade-in 0.5s ease-out;
        }
    </style>


    <!--Search-
    <script>
        $(document).ready(function() {
            var searchTimer;
            var $searchInput = $("#searchInput");
            var $table = $("#transactionsTable");
            var $tbody = $table.find("tbody");

            $searchInput.on("keyup", function() {
                // Show loading state
                $table.addClass('opacity-50');

                // Clear previous timer
                clearTimeout(searchTimer);

                // Set new timer to delay search
                searchTimer = setTimeout(function() {
                    var searchText = $searchInput.val().toLowerCase();

                    // Search through table rows
                    $tbody.find("tr").each(function() {
                        var $row = $(this);
                        var text = $row.text().toLowerCase();
                        $row.toggle(text.indexOf(searchText) > -1);
                    });

                    // Update "No results" message
                    if ($tbody.find("tr:visible").length === 0) {
                        if ($("#noResults").length === 0) {
                            $tbody.append(`
                        <tr id="noResults">
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p>No matching transactions found</p>
                                    <p class="text-sm text-gray-400">Try adjusting your search</p>
                                </div>
                            </td>
                        </tr>
                    `);
                        }
                    } else {
                        $("#noResults").remove();
                    }

                    // Remove loading state
                    $table.removeClass('opacity-50');
                }, 300); // 300ms delay
            });

            // Clear search
            $(".clear-search").click(function() {
                $searchInput.val('').trigger('keyup');
            });
        });
    </script>

    <!-- Add these scripts at the bottom of your file, before the closing </body> tag -->
    <script>
        $(document).ready(function() {
            $("#exportCSV").on("click", function() {
                // Get the table headers
                let headers = [];
                $('#transactionsTable thead th').each(function() {
                    headers.push($(this).text().trim());
                });

                // Get the table data
                let rows = [];
                $('#transactionsTable tbody tr:visible').each(function() {
                    let row = [];
                    $(this).find('td').each(function() {
                        // Get text content, removing any extra whitespace
                        row.push($(this).text().trim().replace(/,/g, ' '));
                    });
                    rows.push(row);
                });

                // Combine headers and rows
                let csvContent = [headers].concat(rows)
                    .map(row => row.join(','))
                    .join('\n');

                // Create a Blob and download link
                let blob = new Blob([csvContent], {
                    type: 'text/csv;charset=utf-8;'
                });
                let link = document.createElement("a");
                let url = URL.createObjectURL(blob);

                // Set download attributes
                link.setAttribute("href", url);
                link.setAttribute("download", "transactions_" + getFormattedDate() + ".csv");
                link.style.visibility = 'hidden';

                // Append to document, click, and remove
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });

            // Helper function to get formatted date for filename
            function getFormattedDate() {
                let date = new Date();
                return date.getFullYear() + "-" +
                    String(date.getMonth() + 1).padStart(2, '0') + "-" +
                    String(date.getDate()).padStart(2, '0') + "_" +
                    String(date.getHours()).padStart(2, '0') + "-" +
                    String(date.getMinutes()).padStart(2, '0');
            }
        });
    </script>
    <!-- Add loading state styles -->
    <style>
        .button-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .button-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            border: 3px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: button-loading-spinner 1s ease infinite;
        }

        @keyframes button-loading-spinner {
            from {
                transform: rotate(0turn);
            }

            to {
                transform: rotate(1turn);
            }
        }
    </style>
@endsection