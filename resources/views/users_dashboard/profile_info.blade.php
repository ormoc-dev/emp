@extends('layouts.user')
@section('content')
    <span>
        @php
            $user = auth()->user();
        @endphp

        @if ($user)
            @if ($user->profile)
                <!-- Use asset() to generate the correct URL -->
            @endif
        @endif
    </span>
    <div class="min-h-screen ">


        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl p-4">
                <div class="max-w-4xl">
                    <h1 class="text-white text-3xl font-bold">Profile Settings <i class="fa-solid fa-database"></i></h1>
                    <p class="text-red-100 mt-2">Manage your personal information and preferences</p>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="   p-8 relative ">
                <!-- Success Message -->
                <div class="hidden" id="successMessage">
                    <div class="flex items-center p-4 mb-6 text-green-700 bg-green-100 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium"></span>
                    </div>
                </div>

                <!-- Profile Form -->
                <form id="profileForm" action="{{ route('user.update', ['id' => $user->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Profile Picture Section -->
                    <div class="flex items-center space-x-6 mb-8">
                        <div class="flex items-center space-x-6 mb-8 bg-red-500">
                        </div>
                        <div class="relative">
                            @if ($user->profile && file_exists(public_path($user->profile)))
                                <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg"
                                    id="profileImage" src="{{ asset($user->profile) }}" alt="User Profile Image" />
                            @else
                                <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg"
                                    id="profileImage"
                                    src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                    alt="Default Profile Image" />
                            @endif
                            <label
                                class="absolute bottom-0 right-0 bg-red-500 rounded-full p-2 cursor-pointer hover:bg-red-600 transition-colors shadow-lg"
                                for="profile">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                            <input class="hidden" id="profile" name="profile" type="file" accept="image/*"
                                onchange="previewImage(event)">
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                            <p class="text-sm text-gray-500 mt-1">Update your photo and personal details</p>
                        </div>
                    </div>
                  <!--TO see the selected profile ni-->
                    <script>
                        function previewImage(event) {
                            const file = event.target.files[0];
                            const reader = new FileReader();

                            reader.onload = function(e) {
                                document.getElementById('profileImage').src = e.target.result;
                            }

                            if (file) {
                                reader.readAsDataURL(file);
                            }
                        }
                    </script>

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Name Field -->
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-medium text-gray-700" for="name">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Full Name
                            </label>
                            <input
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                                id="name" name="name" type="text" value="{{ $user->name }}">
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-medium text-gray-700" for="email">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Email Address
                            </label>
                            <input
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                                id="email" name="email" type="email" value="{{ $user->email }}">
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <button
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 border border-transparent rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300 shadow-lg"
                            id="submitButton" type="submit">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5 mr-2 hidden" id="loadingIcon" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                </svg>
                                <span id="buttonText">Save Changes</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Last Updated Info -->
            <div class="text-center mt-6 text-sm text-gray-500">
                Last updated: {{ auth()->user()->updated_at->diffForHumans() }}
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .button-loading {
            background-color: rgb(185, 28, 28) !important;
            cursor: not-allowed;
            opacity: 0.7;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#profileForm').on('submit', function(e) {
                e.preventDefault();

                const button = $('#submitButton');
                const loadingIcon = $('#loadingIcon');
                const buttonText = $('#buttonText');

                // Disable button and show loading state
                button.prop('disabled', true)
                    .addClass('button-loading');
                loadingIcon.removeClass('hidden')
                    .addClass('animate-spin');
                buttonText.text('Saving...');

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Show success message
                        $('#successMessage').removeClass('hidden').text(response.message);

                        // Update profile image if a new one was uploaded
                        if (response.profile) {
                            $('.rounded-full').attr('src', response.profile);
                        }

                        // Hide success message after 3 seconds
                        setTimeout(function() {
                            $('#successMessage').addClass('hidden');
                        }, 3000);
                    },
                    error: function(xhr) {
                        alert('Error updating profile. Please try again.');
                        console.log(xhr.responseText);
                    },
                    complete: function() {
                        // Reset button state
                        button.prop('disabled', false)
                            .removeClass('button-loading');
                        loadingIcon.addClass('hidden')
                            .removeClass('animate-spin');
                        buttonText.text('Save Changes');
                    }
                });
            });
        });
    </script>

@endsection
