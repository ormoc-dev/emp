@extends('layouts.Supper_admin')
@section('content')
    <div class="container mx-auto px-4 py-6 min-h-screen">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Tabs -->
        <div class="mb-4 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 text-blue-600 border-blue-600"
                        id="tabulators-tab" type="button" role="tab" aria-controls="tabulators" aria-selected="true">
                        Tabulators
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="audience-tab" type="button" role="tab" aria-controls="audience" aria-selected="false">
                        Audience
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tabulators Table -->
        <div class="bg-white rounded-lg shadow-md mb-6" id="tabulators" role="tabpanel">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Tabulators Password Management</h2>
                <!-- Search Input -->
                <input class="border rounded-lg px-4 py-2" id="searchInput" type="text"
                    placeholder="Search by name or email" />
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Profile</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="tabulatorTableBody">
                        @forelse($tabulators as $tabulator)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($tabulator->profile)
                                        <img class="w-10 h-10 rounded-full object-cover"
                                            src="{{ asset($tabulator->profile) }}" alt="{{ $tabulator->name }}'s Profile">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 text-lg">{{ substr($tabulator->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tabulator->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $tabulator->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- For Tabulators -->
                                    <button
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200 flex items-center justify-center min-w-[120px]"
                                        id="reset-btn-{{ $tabulator->id }}"
                                        onclick="resetPassword({{ $tabulator->id }}, 'tabulator')">
                                        <span class="btn-text">Reset Password</span>
                                        <svg class="animate-spin ml-2 h-4 w-4 text-white hidden"
                                            id="spinner-{{ $tabulator->id }}" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 text-center text-gray-500" colspan="4">No tabulators found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>



        <!-- Audience Table -->
        <div class="bg-white rounded-lg shadow-md hidden" id="audience" role="tabpanel">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Audience Password Management</h2>
                <!-- Search Input -->
                <input class="border rounded-lg px-4 py-2" id="audienceSearchInput" type="text"
                    placeholder="Search by name or email" />
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Profile</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="audienceTableBody">
                        @forelse($audience as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($user->profile)
                                        <img class="w-10 h-10 rounded-full object-cover" src="{{ asset($user->profile) }}"
                                            alt="{{ $user->name }}'s Profile">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 text-lg">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- For Audience -->
                                    <button
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200 flex items-center justify-center min-w-[120px]"
                                        id="reset-btn-{{ $user->id }}"
                                        onclick="resetPassword({{ $user->id }}, 'audience')">
                                        <span class="btn-text">Reset Password</span>
                                        <svg class="animate-spin ml-2 h-4 w-4 text-white hidden"
                                            id="spinner-{{ $user->id }}" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 text-center text-gray-500" colspan="4">No audience members found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>



        <!-- Password Reset Modal -->
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50"
            id="password-modal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Password Reset Successful</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">The new password is:</p>
                        <p class="mt-2 p-2 bg-gray-100 rounded font-mono text-lg" id="new-password"></p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button
                            class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300"
                            id="close-modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add a loading spinner or message -->
        <div id="loading" style="display: none;">
            <!-- You can use a spinner or a simple message -->
            <div class="spinner"></div>
            <p>Loading...</p>
        </div>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#searchInput').on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    $('#tabulatorTableBody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#audienceSearchInput').on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    $('#audienceTableBody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });
            });
        </script>
        <script>
            // Tab switching functionality
            document.addEventListener('livewire:navigated', () => {
                const tabs = document.querySelectorAll('[role="tab"]');
                const panels = document.querySelectorAll('[role="tabpanel"]');

                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        // Deactivate all tabs
                        tabs.forEach(t => {
                            t.classList.remove('text-blue-600', 'border-blue-600');
                            t.setAttribute('aria-selected', 'false');
                        });

                        // Hide all panels
                        panels.forEach(p => p.classList.add('hidden'));

                        // Activate clicked tab
                        this.classList.add('text-blue-600', 'border-blue-600');
                        this.setAttribute('aria-selected', 'true');

                        // Show corresponding panel
                        const panelId = this.getAttribute('aria-controls');
                        document.getElementById(panelId).classList.remove('hidden');
                    });
                });
            });



            // Modal close functionality
            document.getElementById('close-modal')?.addEventListener('click', function() {
                document.getElementById('password-modal').classList.add('hidden');
            });

            // Close modal when clicking outside
            document.getElementById('password-modal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        </script>
        <script>
            function resetPassword(userId, userType) {
                if (confirm('Are you sure you want to reset this user\'s password?')) {
                    // Get button elements
                    const button = document.getElementById(`reset-btn-${userId}`);
                    const buttonText = button.querySelector('.btn-text');
                    const spinner = document.getElementById(`spinner-${userId}`);

                    // Disable button and show loading state
                    button.disabled = true;
                    button.classList.add('opacity-75', 'cursor-not-allowed');
                    buttonText.textContent = 'Resetting...';
                    spinner.classList.remove('hidden');

                    fetch(`{{ route('reset.password.action', ['userId' => ':userId', 'userType' => ':userType']) }}`
                            .replace(':userId', userId)
                            .replace(':userType', userType), {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('password-modal').classList.remove('hidden');
                                document.getElementById('new-password').textContent = data.new_password;
                            } else {
                                alert('Failed to reset password: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while resetting the password.');
                        })
                        .finally(() => {
                            // Reset button state
                            button.disabled = false;
                            button.classList.remove('opacity-75', 'cursor-not-allowed');
                            buttonText.textContent = 'Reset Password';
                            spinner.classList.add('hidden');
                        });
                }
            }
        </script>


        <style>
            /* Custom scrollbar styles */
            .overflow-auto::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }

            .overflow-auto::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }

            .overflow-auto::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 3px;
            }

            .overflow-auto::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
        </style>
    @endsection
