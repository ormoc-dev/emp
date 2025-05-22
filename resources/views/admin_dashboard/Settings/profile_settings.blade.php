@extends('layouts.admin_layout')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>

@section('content')
<h1 class="text-3xl font-bold mb-6">Profile Settings</h1>

<div class="bg-white shadow-md rounded-lg">
    <!-- Tabs -->
    <!-- Tabs -->
<div class="border-b border-gray-300">
    <div class="flex">
        <a href="#profile-tab" 
           class="tab-link active w-1/2 py-4 text-center font-semibold text-blue-600 border-b-4 border-blue-600 transition duration-300 ease-in-out hover:text-blue-800"
           data-target="profile-tab">
            Update Profile
        </a>
        <a href="#password-tab" 
           class="tab-link w-1/2 py-4 text-center font-semibold text-gray-600 border-b-4 border-transparent transition duration-300 ease-in-out hover:text-blue-600 hover:border-blue-600"
           data-target="password-tab">
            Change Password
        </a>
    </div>
</div>

    <!-- Profile Tab Content -->
    <div id="profile-tab" class="tab-content p-6 block">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="flex items-center">
                <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-300 flex items-center justify-center mr-4">
                    @php
                    $user = auth()->user();
                    @endphp

                    @if ($user && $user->profile)
                        <div class="relative">
                            <img src="{{ asset($user->profile) }}" alt="User Profile Image" class="w-full h-full object-cover" />
                            <span class="top-0 left-7 absolute w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
                        </div>
                    @else
                        <span class="text-gray-500">No Image</span>
                    @endif
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="imageUpload">
                        Profile Image
                    </label>
                    <input type="file" id="imageUpload" name="image" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="previewImage(event)" />
                </div>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="name">
                    Name
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter your name" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required />
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                    Email
                </label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter your email" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required />
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Profile
                </button>
            </div>
        </form>
    </div>

    <!-- Password Tab Content -->
    <div id="password-tab" class="tab-content p-6 hidden">
        @if (session('success_change_password'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 mb-4" role="alert">
                <p>{{ session('success_change_password') }}</p>
            </div>
        @endif
        @if (session('error_change_password'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 mb-4" role="alert">
                <p>{{ session('error_change_password') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.profile.change_password') }}" method="POST" id="change_password_form" class="space-y-6">
            @csrf
            
            <div>
                <label for="current_password" class="block text-gray-700 text-sm font-semibold mb-2">Current Password</label>
                <input type="password" id="current_password" name="old_password" placeholder="Enter your current password" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 focus:outline-none" required>
                @if($errors->has('old_password'))
                    <span class="text-red-500">{{ $errors->first('old_password') }}</span>
                @endif
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="new_password">
                    New Password
                </label>
                <input type="password" id="new_password" name="new_password" placeholder="Enter your new password" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                @if($errors->has('new_password'))
                    <span class="text-red-500">{{ $errors->first('new_password') }}</span>
                @endif
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="new_password_confirmation">
                    Confirm New Password
                </label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm your new password" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                @if($errors->has('confirm_password'))
                    <span class="text-red-500">{{ $errors->first('confirm_password') }}</span>
                @endif
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Change password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const image = document.getElementById('profileImage');
        image.src = URL.createObjectURL(event.target.files[0]);
    }

</script>
<script>
    // Tab switching logic with localStorage
    document.addEventListener('DOMContentLoaded', function() {
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');
        
        // Function to switch tabs
        function switchTab(targetTab) {
            // Remove active classes from all tabs
            tabLinks.forEach(l => {
                l.classList.remove('active', 'text-blue-600', 'border-blue-600');
                l.classList.add('text-gray-500', 'border-transparent');
            });

            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('block');
            });

            // Activate target tab
            const activeLink = document.querySelector(`[data-target="${targetTab}"]`);
            const activeContent = document.getElementById(targetTab);

            if (activeLink && activeContent) {
                activeLink.classList.add('active', 'text-blue-600', 'border-blue-600');
                activeLink.classList.remove('text-gray-500', 'border-transparent');
                activeContent.classList.remove('hidden');
                activeContent.classList.add('block');
            }
        }

        // Add click event to tab links
        tabLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetTab = this.getAttribute('data-target');
                
                // Save active tab to localStorage
                localStorage.setItem('activeProfileTab', targetTab);
                
                // Switch to the clicked tab
                switchTab(targetTab);
            });
        });

        // Check localStorage on page load
        const savedActiveTab = localStorage.getItem('activeProfileTab') || 'profile-tab';
        switchTab(savedActiveTab);

        // Clear localStorage if success message is for profile update
        @if(session('success'))
            localStorage.setItem('activeProfileTab', 'profile-tab');
        @endif

        // Clear localStorage if success message is for password change
        @if(session('success_change_password'))
            localStorage.setItem('activeProfileTab', 'password-tab');
        @endif
    });
</script>
<script>
    $(document).ready(function() {
       $('#change_password_form').validate({
           rules: {
               old_password: {
                   required: true,
                   minlength: 3
               },
               new_password: {
                   required: true,
                   minlength: 3
               },
               new_password_confirmation: {
                   required: true,
                   equalTo: "#new_password"
               }
           },
           messages: {
               old_password: "Please enter your current password",
               new_password: "Please enter your new password",
               new_password_confirmation: "Passwords do not match"
           },
           submitHandler: function(form) {
               form.submit();
           }
       });
   });
</script>

@endsection