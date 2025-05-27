@extends('layouts.Supper_admin')
@section('content')
    <div class="container mx-auto px-4 py-6 min-h-screen">
        <div class="bg-white rounded-lg shadow-md h-[calc(100vh-8rem)]">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Tabulators Management</h2>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input
                            class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            id="searchInput" type="text" placeholder="Search...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bx bx-search text-gray-400"></i>
                        </div>
                    </div>
                    <button
                        class=" bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors duration-200"
                        onclick="my_modal_3.showModal()">
                        <i class="bx bx-plus"></i>
                        Add User
                    </button>
                </div>
            </div>
            <div class="overflow-auto h-[calc(100%-4rem)]">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                Profile
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                Name
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                Email
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                Role
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="userTableBody">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($user->profile)
                                        <img class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-200"
                                            src="{{ asset($user->profile) }}" alt="{{ $user->name }}'s Profile">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 text-lg">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 capitalize">{{ $user->level }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <button class="text-green-600 hover:text-green-900 transition-colors duration-200"
                                            title="Edit" onclick="openEditDrawer({{ $user->id }})">
                                            <i class="bx bx-edit text-xl"></i>
                                        </button>
                                        <form style="display:inline;" action="{{ route('Tabulators.destroy', $user->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this user?');">
                                                <i class="bx bx-trash text-xl"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-gray-500" colspan="6">
                                    No tabulators found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <dialog class="modal" id="my_modal_3">
        <div class="modal-box bg-white">
            <form id="addUserForm" method="POST" action="{{ route('audience.store') }}">
                @csrf
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" type="button"
                    onclick="my_modal_3.close()">✕</button>
                <h3 class="text-xl font-bold mb-6">Add User</h3>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="name">Name</label>
                    <input
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        id="name" name="name" type="text" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="email">Email</label>
                    <input
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        id="email" name="email" type="email" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="password">Password</label>
                    <input
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        id="password" name="password" type="password" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="level">Level</label>
                    <select
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        id="level" name="level" required>
                        <option value="">Select Level</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="judge">Judge</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors duration-200"
                        type="submit">
                        <i class="fas fa-plus"></i>
                        <span id="buttonText">Add User</span>
                        <div class="hidden" id="loadingAnimation"></div>
                    </button>
                </div>
            </form>
        </div>
    </dialog>


    <!-- Add a loading spinner or message -->
    <div id="loading" style="display: none;">
        <!-- You can use a spinner or a simple message -->
        <div class="spinner"></div>
        <p>Loading...</p>
    </div>



    <script>
        document.getElementById('addUserForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const buttonText = document.getElementById('buttonText');
            const loadingAnimation = document.getElementById('loadingAnimation');

            buttonText.innerHTML = `
            <span>Adding User</span>
            <div class="inline-block ml-2">
                <div class="animate-spin rounded-full h-4 w-4 border-t-2 border-b-2 border-white"></div>
            </div>
        `;
            loadingAnimation.classList.remove('hidden');

            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Handle success response
                    console.log(data.message);
                    // Close the modal or perform any other necessary actions
                    my_modal_3.close();
                    // Reload the page to reflect the new user
                    location.reload();
                })
                .catch(error => {
                    // Handle error
                    console.error('Error:', error);
                })
                .finally(() => {
                    // Reset the button text and hide the loading animation
                    buttonText.innerHTML = 'Add User';
                    loadingAnimation.classList.add('hidden');
                });
        });
    </script>
    <!-- Add this for custom scrollbar and functionality -->
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

    <script>
        function openEditDrawer(userId) {
            // Fetch user data
            fetch(`/tabulators/${userId}/edit`)
                .then(response => response.json())
                .then(user => {
                    // Populate form fields
                    document.getElementById('edit_name').value = user.name;
                    document.getElementById('edit_email').value = user.email;
                    document.getElementById('edit_level').value = user.level;

                    // Set form action
                    document.getElementById('editUserForm').action = `/tabulators/${userId}`;

                    // Show modal
                    edit_modal.showModal();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load user data');
                });
        }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this tabulator?')) {
                // Add your delete logic here
                console.log('Delete user:', userId);
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#userTableBody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>

    <!-- Edit User Modal -->
    <dialog class="modal" id="edit_modal">
        <div class="modal-box bg-white">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" type="button"
                    onclick="edit_modal.close()">✕</button>
                <h3 class="text-xl font-bold mb-6">Edit Tabulator</h3>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="edit_name">Name</label>
                    <input
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        id="edit_name" name="name" type="text" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="edit_email">Email</label>
                    <input
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        id="edit_email" name="email" type="email" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="edit_password">Password (leave blank to
                        keep current)</label>
                    <input
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        id="edit_password" name="password" type="password">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="edit_level">Level</label>
                    <select
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        id="edit_level" name="level" required>
                        <option value="">Select Level</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="judge">Judge</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors duration-200"
                        type="submit">
                        <i class="fas fa-save"></i>
                        <span id="editButtonText">Update User</span>
                        <div class="hidden" id="editLoadingAnimation"></div>
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        document.getElementById('editUserForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const buttonText = document.getElementById('editButtonText');
            const loadingAnimation = document.getElementById('editLoadingAnimation');

            buttonText.innerHTML = `
            <span>Updating User</span>
            <div class="inline-block ml-2">
                <div class="animate-spin rounded-full h-4 w-4 border-t-2 border-b-2 border-white"></div>
            </div>
        `;
            loadingAnimation.classList.remove('hidden');

            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        edit_modal.close();
                        location.reload();
                    } else {
                        throw new Error(data.error || 'Failed to update user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message);
                })
                .finally(() => {
                    buttonText.innerHTML = 'Update User';
                    loadingAnimation.classList.add('hidden');
                });
        });
    </script>
@endsection
