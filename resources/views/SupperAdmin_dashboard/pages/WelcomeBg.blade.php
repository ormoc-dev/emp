@extends('layouts.Supper_admin')
@section('content')
    @if (session('error'))
        <div class="text-red-500">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <ul class="text-red-500">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Header Section -->
    <div class="bg-white shadow-sm p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Background Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="space-y-6">
                    <!-- Header Title -->
                    <div class="border-b pb-4">
                        <h2 class="text-2xl font-bold text-gray-900">Welcome Page Background</h2>
                        <p class="text-sm text-gray-500 mt-1">Update the background image of your welcome page. Recommended
                            size: 1920x1080px</p>
                    </div>

                    <!-- Current Background Preview -->
                    <div class="flex flex-col space-y-4">
                        <label class="text-sm font-medium text-gray-700">Current Background</label>
                        <div class="relative group w-full">
                            <div class="w-full h-64 overflow-hidden bg-gray-100 rounded-lg border-2 border-gray-200">
                                <!-- Change this line -->
                                <img class="w-full h-full object-cover" id="preview"
                                    src="{{ isset($background) ? asset($background->background_image) : asset('img/missOC.jpg') }}"
                                    alt="Welcome Background">


                            </div>

                            <!-- Upload Button -->
                            <form action="{{ route('welcome-background.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mt-4 flex items-center space-x-4">
                                    <label
                                        class="flex items-center px-4 py-2 bg-blue-500 text-white rounded-md cursor-pointer hover:bg-blue-600 transition-colors"
                                        for="background_image">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Choose New Image
                                    </label>
                                    <input class="hidden" id="background_image" name="background_image" type="file"
                                        accept="image/*" onchange="previewImage(this)">

                                    <button
                                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors"
                                        type="submit">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Image Requirements -->
                        <div class="bg-blue-50 rounded-md p-4 mt-4">
                            <h3 class="text-sm font-medium text-blue-800">Image Requirements:</h3>
                            <ul class="mt-2 text-sm text-blue-700 list-disc list-inside">
                                <li>Minimum dimensions: 1920x1080 pixels</li>
                                <li>Maximum file size: 2MB</li>
                                <li>Supported formats: JPG, PNG, WebP</li>
                                <li>Aspect ratio: 16:9 recommended</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    

    <!-- Add this script at the bottom of your file -->
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
