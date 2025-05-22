@extends('layouts.Supper_admin')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script src="https://cdn.lordicon.com/lordicon.js"></script>
@section('content')
    <section class="text-gray-600 body-font" id="ratings">
        <div class="container px-5 mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col">
            
                <div class="flex flex-wrap sm:flex-row flex-col py-6 mb-12">
                    <h1
                        class="sm:w-2/5 text-gray-900 font-medium title-font text-2xl mb-2 sm:mb-0 animate-grow flex items-center">
                        <span class="mr-2">Event Video Highlights</span>
                        <lord-icon src="https://cdn.lordicon.com/pjwsjrxf.json" style="width:50px;height:50px"
                            trigger="loop" delay="2000" colors="primary:#3a3347,secondary:#e86830">
                        </lord-icon>
                    </h1>
                    <p class="sm:w-3/5 leading-relaxed text-base sm:pl-10 pl-0 animate-slideIn">
                        Relive the magic of our past events through these captivating video highlights. Each clip showcases
                        the talent, beauty, and excitement that define our pageants and competitions.
                    </p>
                </div>
            </div>

            <!-- Add New Video Button -->
            <div class="flex justify-end mb-6">
                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center gap-2"
                    onclick="openCreateModal()">
                    <i class="bx bx-plus"></i>
                    Add New Video
                </button>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Videos Grid -->
            <div class="flex flex-wrap sm:-m-4 -mx-4 -mb-10 -mt-4">
                @forelse($videos as $video)
                    <div class="p-4 md:w-1/3 sm:mb-0 mb-20">
                        <div class="rounded-lg h-64 overflow-hidden relative group">
                            <div class="relative" style="padding-top: 56.25%;">
                                <iframe class="absolute inset-0 w-full h-full rounded-lg shadow-xl"
                                    src="{{ $video->video_url }}" title="{{ $video->title }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                            <!-- Admin Controls Overlay -->
                            <div
                                class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full"
                                    onclick="openEditModal('{{ $video->id }}')">
                                    <i class="bx bx-edit text-lg"></i>
                                </button>
                                <form class="inline" action="{{ route('video-highlights.destroy', $video->id) }}"
                                    method="POST" onsubmit="return confirm('Are you sure you want to delete this video?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full" type="submit">
                                        <i class="bx bx-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <h2 class="text-xl font-medium title-font text-gray-900 mt-5 animate-fadeIn">
                            {{ $video->title }}
                        </h2>
                        <p class="text-base leading-relaxed mt-2 animate-slideIn">
                            {{ $video->description }}
                        </p>
                        <a class="text-red-500 inline-flex items-center mt-3" href="{{ $video->video_url }}"
                            target="_blank">
                            Watch Video
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                @empty
                    <div class="w-full text-center py-12">
                        <i class="bx bx-video-off text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No video highlights available yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Create Modal -->
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50" id="createModal">
            <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg overflow-y-auto">
                <div class="modal-content py-4 text-left px-6">
                    <div class="flex justify-between items-center pb-3">
                        <p class="text-2xl font-bold">Add New Video</p>
                        <button class="modal-close" onclick="closeCreateModal()">
                            <i class="bx bx-x text-2xl"></i>
                        </button>
                    </div>
                    <form action="{{ route('video-highlights.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                name="title" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Video URL</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                name="video_url" type="url" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                name="description" required rows="4"></textarea>
                        </div>
                        <div class="flex justify-end pt-2">
                            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" type="submit">
                                Add Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50" id="editModal">
            <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg overflow-y-auto">
                <div class="modal-content py-4 text-left px-6">
                    <div class="flex justify-between items-center pb-3">
                        <p class="text-2xl font-bold">Edit Video Highlight</p>
                        <button class="modal-close" onclick="closeEditModal()">
                            <i class="bx bx-x text-2xl"></i>
                        </button>
                    </div>
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="editTitle" name="title" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Video URL</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="editUrl" name="video_url" type="url" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="editDescription" name="description" required rows="4"></textarea>
                        </div>
                        <div class="flex justify-end pt-2">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" type="submit">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <script>
        function openEditModal(videoId) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');

            fetch(`/video_highlights/${videoId}/edit`) // Note the underscore instead of hyphen
                .then(handleErrors)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editTitle').value = data.title;
                    document.getElementById('editUrl').value = data.video_url;
                    document.getElementById('editDescription').value = data.description;
                    form.action = `/video_highlights/${videoId}`; // Note the underscore instead of hyphen
                    modal.classList.remove('hidden');
                })
                .catch(error => {
                    alert('Error fetching video data');
                    console.error('Error:', error);
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        function handleErrors(response) {
            if (!response.ok) {
                throw Error(response.statusText);
            }
            return response;
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const createModal = document.getElementById('createModal');
            const editModal = document.getElementById('editModal');

            if (event.target === createModal) {
                createModal.classList.add('hidden');
            }
            if (event.target === editModal) {
                editModal.classList.add('hidden');
            }
        }
    </script>

    <style>
        .animate-grow {
            animation: grow 0.3s ease-in-out;
        }

        .animate-slideIn {
            animation: slideIn 0.5s ease-in-out;
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes grow {
            from {
                transform: scale(0.95);
            }

            to {
                transform: scale(1);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-container {
            transform: translate(-50%, -50%);
            position: fixed;
            top: 50%;
            left: 50%;
        }
    </style>
@endsection
