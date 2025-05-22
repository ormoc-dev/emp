@extends('layouts.admin_layout')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
@section('content')
    <div class="flex justify-end mb-4">
        <!-- Add User button positioned to the right -->
        <button
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            data-modal-target="addUserModal" data-modal-toggle="addUserModal" type="button">
            <i class="fa-solid fa-user-plus"></i>
        </button>
    </div>
    <!-- Add User Modal -->
    <div class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full mt-8"
        id="addUserModal" data-modal-backdrop="static" aria-hidden="true" tabindex="-1">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-0 md:p-2 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add New User
                    </h3>
                    <button
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="addUserModal" type="button">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="addUserForm" enctype="multipart/form-data">
                    @csrf
                    <div class="p-4 md:p-5 space-y-4">
                        <div class="hidden  mb-4 text-sm text-green-800  text-center" id="successMessage" role="alert">
                            <i class='bx bxs-check-circle'></i> User added successfully!
                        </div>

                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="name">Name</label>
                                <input
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    id="name" name="name" type="text" placeholder="Type user name"
                                    required="">
                            </div>
                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="email">Email</label>
                                <input
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    id="email" name="email" type="email" placeholder="gmail@.com" required="">
                            </div>
                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="password">Password</label>
                                <input
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    id="password" name="password" type="password" placeholder="••••••••" required="">
                            </div>
                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="level">User Level</label>
                                <select
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    id="level" name="level">
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="profile">Profile Image</label>
                                <input
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    id="profile" name="profile" type="file" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="submit"><i class="fa-solid fa-user-plus"></i> Add new user</button>
                        <button
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                            data-modal-hide="addUserModal" type="button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#addUserForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('users.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#successMessage').removeClass('hidden');
                        $('#addUserForm')[0].reset();
                        // Optionally, you can close the modal after a delay
                        // setTimeout(function() {
                        //     $('#addUserModal').modal('hide');
                        // }, 2000);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        // Handle errors here
                    }
                });
            });
        });
    </script>
  
  <div class="tabs tabs-lifted" role="tablist">
    <input class="tab" id="tab-users" name="my_tabs_2" type="radio" role="tab" aria-label="Users" checked />
    <div class="tab-content bg-white shadow-lg rounded-lg p-6" role="tabpanel">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">User Management</h2>
            <p class="text-gray-600">Manage and monitor all system users</p>
        </div>

        <div class="overflow-hidden rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Details</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        @if ($user->level == 'user' || $user->level == '')
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    #{{ $user->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex-shrink-0">
                                        <div class="h-12 w-12 rounded-full overflow-hidden border-2 border-gray-200">
                                            @if ($user->profile)
                                                <img class="h-full w-full object-cover" 
                                                     src="{{ asset($user->profile) }}" 
                                                     alt="{{ $user->name }}'s Profile" />
                                            @else
                                                @php
                                                    $defaultAvatars = [
                                                        'avatar/cat.png',
                                                        'avatar/giraffe.png',
                                                        'avatar/gorilla.png',
                                                        'avatar/man.png',
                                                        'avatar/women.png',
                                                    ];
                                                    $randomAvatar = $defaultAvatars[array_rand($defaultAvatars)];
                                                @endphp
                                                <img class="h-full w-full object-cover" 
                                                     src="{{ asset($randomAvatar) }}" 
                                                     alt="Default Profile" />
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-sm rounded-full 
                                        {{ $user->level == 'user' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $user->level ?: 'Regular User' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($user->is_online)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <div class="w-2 h-2 mr-2 bg-green-400 rounded-full"></div>
                                            Online
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <div class="w-2 h-2 mr-2 bg-gray-400 rounded-full"></div>
                                            Offline
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                                                data-user="{{ json_encode($user) }}"
                                                data-drawer-target="drawer-right-example"
                                                data-drawer-show="drawer-right-example"
                                                data-drawer-placement="right"
                                                type="button">
                                            <i class="fa-solid fa-user-pen mr-1.5"></i>
                                            Edit
                                        </button>
                                        <form class="inline-block" action="{{ route('user.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                                    type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="fa-solid fa-trash-can mr-1.5"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add any necessary CSS -->
<style>
    .tab-content {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Custom scrollbar for the table container */
    .overflow-x-auto {
        scrollbar-width: thin;
        scrollbar-color: #CBD5E0 #EDF2F7;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #EDF2F7;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background-color: #CBD5E0;
        border-radius: 4px;
    }
</style>

       

    



    <!-- Drawer component -->
    <div class="fixed top-12 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-96 dark:bg-gray-800"
        id="drawer-right-example" aria-labelledby="drawer-right-label" tabindex="-1">
        <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400"
            id="drawer-right-label">
            <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            Edit User
        </h5>
        <button
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-drawer-hide="drawer-right-example" type="button" aria-controls="drawer-right-example">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
        <!-- Update the drawer form section -->
        <form id="drawer-form" action="{{ url('users') }}/0" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="relative z-0 w-full mb-5 group">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="profile">
                    Profile Image (Optional)
                </label>
                <input
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    id="profile" name="profile" type="file" accept="image/*" />
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="drawer-name">
                    User name
                </label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    id="drawer-name" name="name" type="text" required />
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="drawer-email">
                    User Email
                </label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    id="drawer-email" name="email" type="email" required />
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="drawer-level">
                    User Level
                </label>
                <select
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    id="drawer-level" name="level" required>
                    <option value="user">User</option>
                    <option value="judge">Judge</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button
                class="text-white justify-center flex items-center bg-blue-700 hover:bg-blue-800 w-full focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2"
                type="submit">
                Update User
            </button>
        </form>

        <!-- Update the JavaScript section -->

        <script>
            $(document).ready(function() {
                $('.edit-btn').on('click', function() {
                    const user = $(this).data('user');

                    // Just replace the ID at the end of the existing URL
                    const baseUrl = "{{ url('users') }}/";
                    $('#drawer-form').attr('action', baseUrl + user.id);

                    // Populate form fields
                    $('#drawer-name').val(user.name);
                    $('#drawer-email').val(user.email);
                    $('#drawer-level').val(user.level);
                });
            });
        </script>
    </div>

    <script>
        // Handle delete button click with AJAX
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    form.closest('tr').remove(); // Remove row from table
                },
                error: function(response) {
                    alert('Error: Unable to delete the user.');
                }
            });
        });

        // Initialize DataTable
        $('.table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true
        });
    </script>
@endsection
