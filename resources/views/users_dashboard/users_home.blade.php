@extends('layouts.user')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- ⁡⁢⁣⁢ANIMATION FOR RANKINGS⁡ -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
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

    @keyframes gradient-x {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }

    .animate-gradient-x {
        animation: gradient-x 15s ease infinite;
        background-size: 200% 200%;
    }
</style>

<style>
    .event-subtitle {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 4;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .event-subtitle.show {
        -webkit-line-clamp: unset;
    }

    /* Add these to your existing styles */
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }

    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s ease;
    }

    .delete-comment-form button {
        transition: all 0.2s ease;
    }

    .delete-comment-form button:hover {
        transform: scale(1.1);
    }

    .delete-comment-form button:active {
        transform: scale(0.95);
    }
</style>
@section('content')
    <section class="text-gray-600 body-font  mb-10">
        <div class="container px-5 mx-auto">
            <!-- Search Bar -->
            <div class="flex justify-end mb-4">
                <div class="relative w-full md:w-1/3">
                    <input
                        class="w-full py-2 pl-10 pr-3 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        id="search-navbar" type="text" placeholder="Search Events...">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                </div>
            </div>


            <!-- Welcome Section -->
            <div class="flex flex-col md:flex-row items-center mb-12 p-8 bg-white rounded-lg shadow-md" id="mobile-hide">
                <div class="md:w-1/2 mb-6 md:mb-0">

                    <h1 class="text-3xl font-semibold text-gray-900 mb-2"> <span class="inline-block" id="ai_hi"
                            style="width: 90px; height: 50px;"></span>{{ auth()->user()->name }} </h1>
                    <div class="h-1 w-24 bg-red-500 rounded"></div>
                </div>
                <div class="md:w-1/2 space-y-4">


                    <!-- Voting Information Box -->
                    <div class="bg-gradient-to-r from-red-50 to-white p-4 rounded-lg border border-red-100 shadow-sm">
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-red-100 rounded-full">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Free Voting Privilege</h3>
                                <p class="text-sm text-gray-600">
                                    Each registered account receives <span class="font-medium text-red-500">ONE FREE VOTE
                                        PER CONTESTANT</span> for each event. Make your vote count and support your favorite
                                    participant!
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Message -->
                    <p class="text-gray-600 italic">
                        With our expertise, your event is guaranteed to be a success. Trust us to make your occasion truly
                        special.
                    </p>
                </div>
            </div>

            <!-- ⁡⁢⁣⁢EVENT CARDS⁡ -->
            <div class="container mx-auto ">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 ">
                    @foreach ($events as $event)
                        <div class="event-card shadow-lg rounded-lg overflow-hidden bg-white">

                            <header class="bg-gradient-to-r from-red-600 to-red-500 text-white p-2 rounded-t-lg shadow-md">
                                <div class="flex items-center justify-between">
                                    <!-- User Profile Section -->
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <img class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md transition-transform hover:scale-105"
                                                src="{{ asset($event->user->profile) }}" alt="{{ $event->user->name }}"
                                                onerror="this.src='https:ui-avatars.com/api/?name={{ urlencode($event->user->name) }}&background=random'">
                                            <span
                                                class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                                        </div>
                                        <div>
                                            <h2 class="text-xl font-bold tracking-tight">{{ $event->user->name }}</h2>
                                            <p class="text-sm text-white/80">Event Organizer</p>
                                        </div>
                                    </div>
                                </div>
                            </header>

                            <div class="relative">
                                <div class="flex overflow-x-auto">
                                    @foreach ($event->contestants as $contestant)
                                        <img class="h-44 w-16 object-cover object-center   transition-transform transform hover:scale-105"
                                            src="{{ asset($contestant->profile) }}" alt="{{ $contestant->name }}">
                                    @endforeach
                                </div>
                            </div>
                            <div class="p-6">

                                <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">
                                    EVENT CATEGORIES:
                                    @forelse($event->votingCategories as $category)
                                        <span
                                            class="inline-flex items-center bg-blue-50 text-blue-600 text-xs px-2 py-1 rounded-full ml-2">
                                            Win for {{ $category->category_icon }} {{ $category->category_name }}
                                        </span>

                                    @empty
                                        <span class="text-gray-500">No categories set</span>
                                    @endforelse

                                    @if ($event->liveLink && $event->liveLink->fb_embed_link)
                                        <button
                                            class="relative bg-red-500 hover:bg-red-600 text-white 
            px-3 py-2 rounded-lg shadow-md 
            transition-all duration-300 ease-in-out 
            hover:shadow-red-500/50 hover:shadow-lg 
            group"
                                            onclick="showLiveStream({{ $event->id }})">

                                            <i
                                                class="fa-solid fa-video
            transform group-hover:scale-110 
            transition-transform duration-300 
            animate-pulse"></i>
                                            <span
                                                class="absolute -bottom-1 left-0 w-full h-[2px] 
            bg-white transform scale-x-0 
            group-hover:scale-x-100 
            transition-transform duration-300 
            origin-left"></span>
                                        </button>
                                    @else
                                        <button
                                            class="relative bg-gray-400 text-white 
            px-3 py-2 rounded-lg shadow-md 
            transition-all duration-300 ease-in-out 
            group cursor-not-allowed"
                                            onclick="showStreamReminder()">
                                            <i class="fa-solid fa-video-slash opacity-75"></i>

                                        </button>

                                        <script>
                                            function showStreamReminder() {
                                                Swal.fire({
                                                    title: 'Live Stream Not Available',
                                                    text: 'No live stream has been set up for this event yet.',
                                                    icon: 'info',
                                                    confirmButtonColor: '#EF4444',
                                                    confirmButtonText: 'OK',
                                                    customClass: {
                                                        popup: 'animate__animated animate__fadeInDown'
                                                    }
                                                });
                                            }
                                        </script>
                                    @endif

                                </h2>


                                <h1 class="title-font text-lg font-medium text-gray-900 mb-3 ">
                                    {{ $event->event_name }}

                                    <div class="flex flex-wrap mt-1">
                                        @forelse($event->judges as $judge)
                                            <span
                                                class="inline-flex items-center px-1.5  rounded-full text-xs font-medium 
                                                         bg-blue-100 text-blue-800 hover:bg-blue-200 cursor-pointer transition-all 
                                                         transform hover:scale-105 duration-200  mb-2"
                                                onclick="showJudgeDetails({{ json_encode($judge) }})">
                                                <img class="w-8 h-8 rounded-full object-cover mr-1"
                                                    src="{{ asset($judge->profile) }}" alt="{{ $judge->name }}"
                                                    onerror="this.src='https:ui-avatars.com/api/?name={{ urlencode($judge->name) }}&background=random'">
                                                {{ $judge->name }}
                                            </span>
                                        @empty
                                            <span class="text-sm text-gray-500 italic">No judges assigned</span>
                                        @endforelse
                                    </div>

                                    <script>
                                        function showJudgeDetails(judge) {
                                            // Create profile URL with fallback
                                            const profileUrl = judge.profile ?
                                                `{{ asset('') }}${judge.profile}` :
                                                `https://ui-avatars.com/api/?name=${encodeURIComponent(judge.name)}&background=random`;

                                            Swal.fire({
                                                html: `
                                                <div class="flex flex-col items-center p-4">
                                                    <!-- Profile Image Section -->
                                                    <div class="relative mb-4">
                                                        <img src="${profileUrl}" 
                                                             alt="${judge.name}"
                                                             class="w-24 h-24 rounded-full object-cover border-4 border-blue-100 shadow-lg
                                                                    transform transition-transform duration-300 hover:scale-105"
                                                             onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(judge.name)}&background=random'">
                                                        <div class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2 shadow-lg">
                                                            <i class="fas fa-gavel text-white"></i>
                                                        </div>
                                                    </div>
                                    
                                                    <!-- Judge Information -->
                                                    <div class="text-center space-y-2 mb-4">
                                                        <h3 class="text-xl font-bold text-gray-800">${judge.name}</h3>
                                                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800">
                                                            <i class="fas fa-star-of-life mr-2"></i>
                                                            Event Judge
                                                        </div>
                                                    </div>
                                    
                                                    <!-- Contact Information -->
                                                    <div class="w-full space-y-3 border-t border-gray-100 pt-4">
                                                        <div class="flex items-center justify-center space-x-2 text-gray-600">
                                                            <i class="far fa-envelope"></i>
                                                            <span>${judge.email}</span>
                                                        </div>
                                                        
                                                        <div class="flex items-center justify-center space-x-2 text-gray-600">
                                                            <i class="fas fa-circle text-xs ${judge.is_online ? 'text-green-500' : 'text-gray-400'}"></i>
                                                            <span>${judge.is_online ? 'Online' : 'Offline'}</span>
                                                        </div>
                                                    </div>
                                    
                                                    <!-- Biography and Achievements Section -->
<div class="grid grid-cols-1 gap-4 w-full mt-4 border-t border-gray-100 pt-4">
    <!-- Biography -->
    <div class="p-4 bg-gray-50 rounded-lg">
        <div class="flex items-center mb-2">
            <i class="fas fa-book-open text-blue-600 mr-2"></i>
            <h4 class="font-semibold text-gray-700">Biography</h4>
        </div>
        <p class="text-sm text-gray-600 leading-relaxed">
            ${judge.biography || 'No biography available'}
        </p>
    </div>

    <!-- Achievements & Awards -->
    <div class="p-4 bg-gray-50 rounded-lg">
        <div class="flex items-center mb-2">
            <i class="fas fa-trophy text-blue-600 mr-2"></i>
            <h4 class="font-semibold text-gray-700">Achievements & Awards</h4>
        </div>
        <div class="text-sm text-gray-600">
            ${judge.achievements ? 
                judge.achievements.split('\n').map(achievement => 
                    `<div class="flex items-start mb-1">
                                                                                                                                                                                                            <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                                                                                                                                                                                                            <span>${achievement}</span>
                                                                                                                                                                                                         </div>`
                ).join('') 
                : 'No achievements listed'}
        </div>
    </div>
</div>
                                                </div>
                                            `,
                                                showCloseButton: true,
                                                showConfirmButton: false,
                                                width: '32rem',
                                                customClass: {
                                                    popup: 'animate__animated animate__fadeInDown animate__faster rounded-lg',
                                                    closeButton: 'focus:outline-none hover:text-red-500 transition-colors'
                                                },
                                                showClass: {
                                                    popup: 'animate__animated animate__fadeInDown animate__faster'
                                                },
                                                hideClass: {
                                                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                                                }
                                            });
                                        }
                                    </script>
                                </h1>





                                <p class="leading-relaxed mb-3  font-indie event-subtitle">
                                    {{ $event->event_subtitle }}</p>
                                <a class="see-more text-red-500" href="javascript:void(0);" style="display: none;">See
                                    more</a>

                                <div class="flex flex-col space-y-4">
                                    <!-- Event Status/Voting Section -->
                                    <div class="flex flex-wrap items-center justify-between gap-4">
                                        @if ($event->event_status !== 'started')
                                            <div
                                                class="flex items-center w-full sm:w-auto p-3 text-sm text-red-800 bg-red-50 border border-red-200 rounded-lg dark:bg-gray-800 dark:text-red-400 dark:border-red-800">
                                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                                </svg>
                                                <span class="font-medium">Voting not yet available</span>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2">
                                                <!-- Vote Now Button -->
                                                <a class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 transition-colors"
                                                    href="{{ route('event.contestants', $event->id) }}">
                                                    Vote
                                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                    </svg>
                                                </a>

                                                <!-- View Rankings Button -->
                                                <button
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-yellow-100 rounded-lg hover:bg-yellow-200"
                                                    onclick="showRankings({{ $event->id }})">
                                                    <i class="fas fa-trophy mr-2"></i> Rank
                                                </button>

                                            </div>
                                        @endif

                                        <!-- Vote Counter -->
                                        <div class="flex items-center space-x-2 text-gray-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span
                                                class="font-medium">{{ number_format($voteCounts[$event->id] ?? 0) }}</span>
                                        </div>
                                    </div>

                                    <!-- Comments Section -->
                                    <div class="mt-6">
                                        <!-- Comment Toggle Button -->
                                        <button
                                            class="comment-toggle flex items-center space-x-2 text-gray-600 hover:text-gray-800 transition-colors">
                                            <i class="fa-regular fa-comment-dots text-lg"></i>
                                            <span class="text-sm font-medium">Add Comment</span>
                                        </button>

                                        <!-- Comment Form -->
                                        <form class="hidden comment-form mt-4" id="commentForm-{{ $event->id }}"
                                            onsubmit="submitComment(event, {{ $event->id }})">
                                            @csrf
                                            <input name="event_id" type="hidden" value="{{ $event->id }}">
                                            <div class="flex flex-col gap-2">
                                                <!-- Textarea -->
                                                <div class="relative">
                                                    <textarea
                                                        class="w-full min-h-[80px] p-3 text-sm border border-gray-200 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all resize-none"
                                                        name="content" placeholder="Share your thoughts..." required onkeyup="validateComment(this)"></textarea>
                                                    <!-- Warning message will appear here -->
                                                    <div
                                                        class="warning-message hidden absolute -bottom-6 left-0 text-yellow-500 text-xs">
                                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                                        Your message contains inappropriate language
                                                    </div>
                                                </div>

                                                <!-- Button -->
                                                <div class="flex justify-end">
                                                    <button
                                                        class="inline-flex items-center justify-center px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 transition-colors"
                                                        type="submit">
                                                        <i class='bx bx-comment-check mr-2'></i>
                                                        Post Comment
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        <!-- Comments List -->
                                        <div
                                            class="mt-6 space-y-4 h-20 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                            @forelse ($event->comments as $comment)
                                                <div
                                                    class="rounded-lg border border-gray-100 shadow-sm p-2 
                                                            transform transition-all duration-300 hover:shadow-md hover:border-gray-200">
                                                    <div class="flex items-start space-x-3">
                                                        <!-- User Avatar -->
                                                        <div class="relative flex-shrink-0">
                                                            @if ($comment->user->profile && file_exists(public_path($comment->user->profile)))
                                                                <img class="w-10 h-10 rounded-full object-cover transition-transform hover:scale-105"
                                                                    src="{{ asset($comment->user->profile) }}"
                                                                    alt="{{ $comment->user->name }}"
                                                                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random';" />
                                                            @else
                                                                <img class="w-10 h-10 rounded-full object-cover transition-transform hover:scale-105"
                                                                    src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random"
                                                                    alt="{{ $comment->user->name }}" />
                                                            @endif
                                                            <span
                                                                class="absolute bottom-0 right-0 w-3 h-3 
                                                                       {{ $comment->user->is_online ? 'bg-green-500' : 'bg-gray-300' }} 
                                                                       border-2 border-white rounded-full">
                                                            </span>
                                                        </div>

                                                        <!-- Comment Content -->
                                                        <div class="flex-1 min-w-0">
                                                            <div class="flex items-center justify-between mb-1">
                                                                <div class="flex items-center">
                                                                    <h4 class="text-sm font-medium text-gray-900">
                                                                        {{ $comment->user->name }}
                                                                    </h4>
                                                                    <span class="mx-2 text-gray-300">•</span>
                                                                    <span class="text-xs text-gray-500">
                                                                        {{ $comment->created_at->diffForHumans() }}
                                                                    </span>
                                                                </div>

                                                                <!-- Delete Button -->
                                                                <form class="delete-comment-form"
                                                                    id="deleteForm-{{ $comment->id }}"
                                                                    onsubmit="return deleteComment(event, {{ $comment->id }})">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button
                                                                        class="text-gray-400 hover:text-red-500 transition-colors"
                                                                        type="submit">
                                                                        <i class='bx bx-trash'></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                            <p class="text-sm text-gray-600 break-words">
                                                                {{ $comment->content }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <!-- No Comments State -->
                                                <div
                                                    class="flex flex-col items-center justify-center h-full py-4 
                                                            bg-gray-50 rounded-lg border border-dashed border-gray-200">
                                                    <!-- Icon -->
                                                    <div
                                                        class="w-12 h-12 mb-3 rounded-full bg-gray-100 flex items-center justify-center">
                                                        <i class='bx bx-message-rounded-dots text-2xl text-gray-400'></i>
                                                    </div>

                                                    <!-- Message -->
                                                    <p class="text-sm text-gray-500 font-medium">No comments yet</p>
                                                    <p class="text-xs text-gray-400 mt-1">Be the first to share your
                                                        thoughts!</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


        </div>

        <!-- ⁡⁢⁣⁢MODAL FOR RANKINGS⁡ -->
        <dialog class="modal" id="my_modal_5">
            <div
                class="modal-box w-11/12 max-w-5xl bg-white p-0 rounded-lg overflow-hidden transform transition-all animate-fadeIn">
                <!-- Header with animated gradient -->
                <div class="bg-red-500 p-4 text-white relative overflow-hidden">
                    <div
                        class="animate-gradient-x absolute inset-0 bg-gradient-to-r from-red-500 via-pink-500 to-red-500 opacity-75">
                    </div>
                    <div class="relative z-10 flex items-center">
                        <i class="fas fa-trophy text-yellow-300 text-3xl mr-3 animate-bounce"></i>
                        <h3 class="text-2xl font-bold">Live Rankings </h3>

                    </div>
                </div>

                <!-- Content -->
                <div class="p-4 h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    <div class="space-y-4" id="rankings-list">
                        <!-- Rankings will be dynamically inserted here -->
                    </div>
                </div>


                <!-- Footer with stats -->
                <div class="border-t p-4 bg-gray-50">
                    <div
                        class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                        <!-- Left Section -->
                        <div
                            class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <!-- Total Votes -->
                            <div class="flex items-center">
                                <i class="fas fa-chart-bar text-red-500 mr-2"></i>
                                <p class="text-sm text-gray-600">
                                    Total Votes:
                                    <span class="font-bold text-red-500 animate-pulse" id="total-votes">0</span>
                                </p>
                            </div>
                            <!-- Live Updates -->
                            <div class="text-sm text-gray-400 flex items-center">
                                <i class="fas fa-clock mr-1"></i>
                                Live Updates
                            </div>
                        </div>

                        <!-- Button Section -->
                        <form class="w-full sm:w-auto" method="dialog">
                            <button
                                class="w-full sm:w-auto px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                                <i class="fas fa-times mr-2"></i> close
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </dialog>


        <!-- Live Stream Modal -->
        <dialog class="modal" id="my_modal_4">
            <div class="modal-box w-12/12 max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header with gradient background -->
                <div class="bg-gradient-to-r from-red-500 via-red-600 to-red-700 p-2 -mx-6 -mt-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white/10 p-3 rounded-lg">
                                <lord-icon src="https://cdn.lordicon.com/pjwsjrxf.json" style="width:32px;height:32px"
                                    trigger="loop" delay="2000" colors="primary:#ffffff">
                                </lord-icon>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">Live Stream</h3>
                                <p class="text-white/80 text-sm flex items-center mt-1">
                                    <i class="fab fa-facebook mr-2"></i>
                                    Facebook Live
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="flex h-3 w-3">
                                <span
                                    class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                            </span>
                            <span class="text-white/90 text-sm">LIVE</span>
                        </div>
                    </div>
                </div>

                <!-- Content Container -->
                <div class="min-h-[500px] relative bg-gray-50 rounded-lg m-6 overflow-hidden">
                    <!-- Loading State -->
                    <div class="absolute inset-0 flex items-center justify-center bg-white" id="loadingState">
                        <div class="text-center">
                            <div
                                class="w-16 h-16 border-4 border-red-500 border-t-transparent rounded-full animate-spin mb-4">
                            </div>
                            <p class="text-gray-600 font-medium">Connecting to live stream...</p>
                            <p class="text-gray-400 text-sm mt-2">Please wait a moment</p>
                        </div>
                    </div>

                    <!-- Error State -->
                    <div class="absolute inset-0 flex items-center justify-center bg-white hidden" id="errorState">
                        <div class="text-center px-6">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
                            </div>
                            <h4 class="text-gray-900 font-semibold mb-2">Unable to Load Stream</h4>
                            <p class="text-gray-500 text-sm mb-4" id="errorMessage"></p>
                            <button
                                class="inline-flex items-center px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors"
                                onclick="reloadStream()">
                                <i class="fas fa-redo-alt mr-2"></i>
                                Try Again
                            </button>
                        </div>
                    </div>

                    <!-- Facebook Video Container -->
                    <div class="hidden  flex justify-center" id="fbVideoContainer">
                        <div id="fb-root"></div>
                        <div class="fb-video" id="fbVideo" data-width="900" data-height="400" data-show-text="false"
                            style="min-height: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="border-t bg-white border-gray-100 mt-6 pt-4 flex items-center justify-between ">
                    <div class="flex items-center space-x-4">
                        <button
                            class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors"
                            onclick="reloadStream()">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Refresh Stream
                        </button>
                        <div class="h-6 w-px bg-gray-200"></div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-signal mr-1"></i>
                            Stream Quality: Auto
                        </div>
                    </div>

                    <form method="dialog">
                        <button
                            class="mr-8 inline-flex items-center px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg 
                             hover:bg-gray-200 transition-colors duration-200 font-medium text-sm
                             focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                            <i class="fas fa-times "></i>
                            Close Stream
                        </button>
                    </form>
                </div>
            </div>
        </dialog>
        <script>
            let currentEventId = null;

            function showLiveStream(eventId) {
                currentEventId = eventId;
                const modal = document.getElementById('my_modal_4');
                const loadingState = document.getElementById('loadingState');
                const errorState = document.getElementById('errorState');
                const fbVideoContainer = document.getElementById('fbVideoContainer');
                const errorMessage = document.getElementById('errorMessage');

                // Reset states
                loadingState.classList.remove('hidden');
                errorState.classList.add('hidden');
                fbVideoContainer.classList.add('hidden');

                // Show modal
                modal.showModal();

                // Fetch live link
                fetch(`/events/${eventId}/live-link`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Live stream response:', data); // Debug log

                        if (data.success && data.fb_embed_link) {
                            const fbVideo = document.getElementById('fbVideo');
                            fbVideo.setAttribute('data-href', data.fb_embed_link);

                            loadingState.classList.add('hidden');
                            fbVideoContainer.classList.remove('hidden');

                            // Initialize Facebook SDK
                            if (typeof FB !== 'undefined') {
                                FB.XFBML.parse(document.getElementById('fbVideoContainer'));
                            } else {
                                throw new Error('Facebook SDK not loaded');
                            }
                        } else {
                            throw new Error(data.message || 'No live stream available');
                        }
                    })
                    .catch(error => {
                        console.error('Live stream error:', error);
                        loadingState.classList.add('hidden');
                        errorState.classList.remove('hidden');
                        errorMessage.textContent = error.message || 'Failed to load live stream';
                    });
            }

            function reloadStream() {
                if (currentEventId) {
                    showLiveStream(currentEventId);
                }
            }

            // Initialize Facebook SDK
            window.fbAsyncInit = function() {
                FB.init({
                    xfbml: true,
                    version: 'v17.0'
                });
            };

            // Load Facebook SDK
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>


    </section>




    <script>
        $(document).ready(function() {
            // Check if the screen width is below 768px
            if ($(window).width() < 768) {
                setTimeout(function() {
                    $('#mobile-hide').fadeOut('slow');
                }, 5000); // 5000 milliseconds = 5 seconds
            }

            // Existing code for comment toggle
            const commentToggleButtons = document.querySelectorAll('.comment-toggle');

            commentToggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const commentForm = button.nextElementSibling;
                    commentForm.classList.toggle('hidden');
                });
            });
        });
    </script>

    <script>
        function deleteComment(event, commentId) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    popup: 'animate__animated animate__fadeInDown'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Find the specific comment container
                    const form = document.getElementById(`deleteForm-${commentId}`);
                    // Use a more specific selector to get only the comment element
                    const commentElement = form.closest('.rounded-lg.border.border-gray-100.shadow-sm.p-4');
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Add fade-out animation
                    commentElement.style.transition = 'opacity 0.3s ease';
                    commentElement.style.opacity = '0';

                    fetch(`/comments/${commentId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove only the comment element after fade out
                                setTimeout(() => {
                                    commentElement.remove();
                                }, 300);

                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Your comment has been deleted.',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'animate__animated animate__fadeInUp'
                                    }
                                });
                            } else {
                                commentElement.style.opacity = '1';
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message || 'Failed to delete comment',
                                    icon: 'error',
                                    customClass: {
                                        popup: 'animate__animated animate__fadeInUp'
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            commentElement.style.opacity = '1';
                            Swal.fire({
                                title: 'Error!',
                                text: 'There was an error deleting the comment',
                                icon: 'error',
                                customClass: {
                                    popup: 'animate__animated animate__fadeInUp'
                                }
                            });
                        });
                }
            });

            return false;
        }
    </script>
    <!-- ⁡⁢⁣⁢SCRIPT FOR RANKINGS⁡ -->
    <script>
        function showRankings(eventId) {
            const modal = document.getElementById('my_modal_5');
            const rankingsList = document.getElementById('rankings-list');

            // Show loading state with animation
            rankingsList.innerHTML = `
         <div class="flex flex-col items-center justify-center py-8 animate-fadeIn">
            <div class="w-16 h-16 border-4 border-red-500 border-t-transparent rounded-full animate-spin"></div>
            <p class="mt-4 text-gray-600">Loading rankings...</p>
         </div>
         `;
            modal.showModal();

            fetch(`/api/events/${eventId}/rankings`)
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    if (data.error) throw new Error(data.message || 'Failed to load rankings');

                    // Update total votes with animation
                    const totalVotesElement = document.getElementById('total-votes');
                    animateNumber(0, data.totalVotes, 1000, value => {
                        totalVotesElement.textContent = Math.floor(value).toLocaleString();
                    });

                    if (!data.contestants || data.contestants.length === 0) {
                        rankingsList.innerHTML = `
                    <div class="text-center py-8 animate-fadeIn">
                        <i class="fas fa-user-friends text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-600">No contestants found</p>
                    </div>`;
                        return;
                    }

                    // Generate rankings HTML with staggered animation
                    const rankingsHTML = data.contestants.map((contestant, index) => `
               <div class="flex items-center bg-white p-4 rounded-lg border border-gray-200 hover:shadow-lg transition-all duration-300 transform hover:scale-105"
         style="animation: slideIn 0.3s ease-out ${index * 0.1}s both">
        
        <!-- Rank with dynamic color -->
        <div class="flex-none w-12 h-12 ${index < 3 ? getRankColor(index) : 'bg-gray-100'} rounded-full flex items-center justify-center mr-4 transition-transform transform hover:scale-110 duration-300">
            <span class="text-lg font-bold ${index < 3 ? 'text-white' : 'text-gray-700'}">#${index + 1}</span>
        </div>
        
        <!-- Contestant Info -->
        <div class="flex-none mr-4 relative">
            <img src="${contestant.profile}" 
                 class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 transition-transform transform hover:scale-110 duration-300"
                 onerror="this.src='/path/to/default-image.jpg'">
            ${index < 3 ? `<i class="fas fa-crown text-yellow-400 absolute -top-2 -right-2"></i>` : ''}
        </div>
        
        <!-- Contestant Details -->
        <div class="flex-grow">
            <h4 class="font-semibold text-gray-800">${contestant.name}</h4>
            
            <!-- Progress Bar -->
            <div class="mt-2">
                <div class="flex items-center">
                    <div class="flex-grow h-2.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-red-500 rounded-full transition-all duration-1000 ease-out"
                             style="width: 0%" 
                             data-final-width="${contestant.percentage}%">
                        </div>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-600 w-16">
                        ${contestant.percentage}%
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    <span class="font-medium">${contestant.votes_count.toLocaleString()}</span> votes
                </p>
            </div>
        </div>
      </div>
            `).join('');

                    rankingsList.innerHTML = rankingsHTML;

                    // Animate progress bars
                    setTimeout(() => {
                        document.querySelectorAll('[data-final-width]').forEach(bar => {
                            bar.style.width = bar.dataset.finalWidth;
                        });
                    }, 100);
                })
                .catch(error => {
                    console.error('Rankings Error:', error);
                    rankingsList.innerHTML = `
                <div class="text-center py-8 animate-fadeIn">
                    <i class="fas fa-exclamation-circle text-red-500 text-5xl mb-4"></i>
                    <div class="text-red-500 font-medium mb-2">Error loading rankings</div>
                    <div class="text-sm text-gray-500">${error.message}</div>
                </div>`;
                });
        }

        // Utility functions
        function getRankColor(index) {
            const colors = ['bg-yellow-500', 'bg-gray-400', 'bg-yellow-700'];
            return colors[index] || 'bg-gray-100';
        }

        function animateNumber(start, end, duration, callback) {
            const startTime = performance.now();
            const updateNumber = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);

                const value = start + (end - start) * easeOutQuart(progress);
                callback(value);

                if (progress < 1) {
                    requestAnimationFrame(updateNumber);
                }
            };
            requestAnimationFrame(updateNumber);
        }

        function easeOutQuart(x) {
            return 1 - Math.pow(1 - x, 4);
        }
    </script>
    <!-- ⁡⁢⁣⁢SCRIPT FOR SEE MORE⁡ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subtitles = document.querySelectorAll('.event-subtitle');
            subtitles.forEach(subtitle => {
                const seeMore = subtitle.nextElementSibling;
                if (subtitle.scrollHeight > subtitle.clientHeight) {
                    seeMore.style.display = 'inline';
                }

                seeMore.addEventListener('click', function() {
                    subtitle.classList.toggle('show');
                    if (subtitle.classList.contains('show')) {
                        this.textContent = 'See less';
                    } else {
                        this.textContent = 'See more';
                    }
                });
            });
        });
    </script>
    <!-- ⁡⁢⁣⁢SCRIPT FOR COMMENT⁡ -->
    <script>
        function submitComment(event, eventId) {
            event.preventDefault();

            const form = document.getElementById(`commentForm-${eventId}`);
            const textarea = form.querySelector('textarea');
            const content = textarea.value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Check for bad words before submitting
            const badWords = [
                'fuck', 'shit', 'ass', 'bitch', 'bastard', 'dick', 'pussy', 'ugly',
                'puta', 'gago', 'tangina', 'bobo', 'tanga', 'amat', 'kagiron', 'itom', 'yawa', 'pangit'
                // Add more bad words here
            ];

            const containsBadWord = badWords.some(word =>
                content.toLowerCase().includes(word.toLowerCase())
            );

            if (containsBadWord) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Your comment contains inappropriate language. Please revise it.',
                    icon: 'warning',
                    confirmButtonColor: '#ef4444',
                });
                return;
            }

            // Show loading state
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i>Posting...';
            submitButton.disabled = true;

            fetch('{{ route('comments.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        content: content,
                        event_id: eventId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Clear the textarea
                        textarea.value = '';

                        // Create and insert the new comment
                        const commentsContainer = form.closest('.mt-6').querySelector('.space-y-4');
                        const newComment = createCommentElement(data.comment);
                        commentsContainer.insertBefore(newComment, commentsContainer.firstChild);

                        // Add fade-in animation
                        newComment.style.opacity = '0';
                        setTimeout(() => {
                            newComment.style.opacity = '1';
                        }, 50);

                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your comment has been posted.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'animate__animated animate__fadeInUp'
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error posting your comment. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#ef4444',
                    });
                })
                .finally(() => {
                    // Restore button state
                    submitButton.innerHTML = originalButtonText;
                    submitButton.disabled = false;
                });
        }

        // Add real-time validation
        function validateComment(textarea) {
            const badWords = [
                'fuck', 'shit', 'ass', 'bitch', 'bastard', 'dick', 'pussy', 'ugly',
                'puta', 'gago', 'tangina', 'bobo', 'tanga', 'amat', 'kagiron', 'itom', 'yawa', 'pangit'
                // Add more bad words here
            ];

            const content = textarea.value.toLowerCase();
            const warningDiv = textarea.closest('form').querySelector('.warning-message');

            const containsBadWord = badWords.some(word => content.includes(word.toLowerCase()));

            if (containsBadWord) {
                if (!warningDiv) {
                    const warning = document.createElement('div');
                    warning.className = 'text-yellow-500 text-sm mt-2 warning-message';
                    warning.innerHTML =
                        '<i class="fas fa-exclamation-circle mr-1"></i>Your message contains inappropriate language';
                    textarea.parentNode.insertBefore(warning, textarea.nextSibling);
                }
                textarea.classList.add('border-yellow-400');
            } else {
                if (warningDiv) {
                    warningDiv.remove();
                }
                textarea.classList.remove('border-yellow-400');
            }
        }

        function createCommentElement(comment) {
            const div = document.createElement('div');
            div.className = 'bg-white rounded-lg border border-gray-100 shadow-sm p-4';
            div.style.transition = 'opacity 0.3s ease';

            const profileImage = comment.user.profile && comment.user.profile !== '' ?
                `{{ asset('${comment.user.profile}') }}` :
                `https://ui-avatars.com/api/?name=${encodeURIComponent(comment.user.name)}&background=random`;

            div.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="relative flex-shrink-0">
                        <img src="${profileImage}" 
                             alt="${comment.user.name}" 
                             class="w-8 h-8 rounded-full object-cover"
                             onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(comment.user.name)}&background=random'">
                        <span class="absolute bottom-0 right-0 w-3 h-3 ${comment.user.is_online ? 'bg-green-500' : 'bg-gray-300'} border-2 border-white rounded-full"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <div class="flex items-center">
                                <h4 class="text-sm font-medium text-gray-900">${comment.user.name}</h4>
                                <span class="mx-2 text-gray-300">•</span>
                                <span class="text-xs text-gray-500">Just now</span>
                            </div>
                            <form id="deleteForm-${comment.id}" 
                                  action="/comments/${comment.id}" 
                                  method="POST"
                                  onsubmit="return deleteComment(event, ${comment.id})">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </div>
                        <p class="text-sm text-gray-600 break-words">${comment.content}</p>
                    </div>
                </div>
            `;

            return div;
        }
    </script>
    <!-- ⁡⁢⁣⁢SCRIPT FOR ANIMATION⁡ LOTTIE-->
    <script>
        const animationPaths = {

            'ai_hi': '{{ asset('json/animate/ai_hi.json') }}',

        };


        function initializeAnimations() {

            function initLottieAnimations() {
                Object.entries(animationPaths).forEach(([id, path]) => {
                    const element = document.getElementById(id);
                    if (element) {
                        bodymovin.loadAnimation({
                            container: element,
                            path: path
                        });
                    }
                });
            }

            initLottieAnimations();

        }


        document.addEventListener('DOMContentLoaded', initializeAnimations);


        if (typeof window.Livewire !== 'undefined') {
            document.addEventListener('livewire:navigated', initializeAnimations);
        }
    </script>
    <script src="{{ asset('js/lottie.min.js') }}"></script>
@endsection
