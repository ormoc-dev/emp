<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'E.M.P') }}</title>
        <link type="image/png" href="{{ asset('img/emp-logo.png') }}" rel="icon">
        <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.css" rel="stylesheet">

        <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('css/loader.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- ⁡⁢⁣⁢Include jQuery⁡ -->
        <link href="{{ asset('css/jquery_length.css') }}" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <!-- ⁡⁢⁣⁢Include Select2 CSS⁡ -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- ⁡⁢⁣⁢Include Select2 JS ⁡-->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        @livewireStyles
        @vite(['resources/css/app.css'])
    </head>

    <body>
        <!-- SIDEBAR -->
        <section id="sidebar">
            <!--TITILE-->
            <a class="gap-4 brand" href="#">
                <i class="mt-2 ml-4">

                    <lord-icon src="https://cdn.lordicon.com/skxnurvz.json" style="width:30px;height:30px"
                        trigger="loop" delay="1000" colors="primary:#109121,secondary:#109173">
                    </lord-icon>
                </i>
                <span class="text"> EVENTPRO</span>
            </a>
            <!--TITILE ANIMATION-->
            <div class="spinnerContainer" id="loading-animation">
                <div class="spinners"></div>
                <div class="loaders">
                    <p>loading</p>
                    <div class="words">
                        <span class="word">events</span>
                        <span class="word">criteria</span>
                        <span class="word">Scores</span>
                        <span class="word">Judges</span>
                    </div>
                </div>
            </div>
            <!--SIDEBAR MENU-->
            <ul class="side-menu top" id="sidebar-menu">
                <li>
                    <a id="dashboard-link" href="{{ route('admin_home') }}">
                        <i class="fa-solid fa-house bx"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a id="management-link" href="{{ route('events.create') }}">
                        <i class="fa-solid fa-list-check bx"></i>
                        <span class="text">Management</span>
                    </a>
                </li>
                <li>
                    <a id="start_event-link" href="{{ route('events.Start') }}">
                        <i class="fa-solid fa-power-off bx"></i>
                        <span class="text">Start Events</span>
                    </a>
                </li>
                <li>
                    <a id="result-link" href="{{ route('events.showResultsAdmin') }}">
                        <i class="fa-solid fa-square-poll-vertical bx"></i>
                        <span class="text">Results</span>
                    </a>
                </li>

            </ul>




            <style>
                @keyframes rotate {
                    from {
                        transform: rotate(0deg);
                    }

                    to {
                        transform: rotate(360deg);
                    }
                }

                .rotate-icon {
                    animation: rotate 2s linear infinite;
                }
            </style>
            <ul class="side-menu">
                <li>
                    <a id="users-link" href="{{ route('showUsersTable') }}">
                        <i class="fa-solid fa-users bx"></i>
                        Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile_settings') }}">
                        <i class="fa-solid fa-gear bx rotate-icon"></i>
                        <span class="text">Settings</span>
                    </a>
                </li>
                <li>
                    <a class="logout" href="#" onclick="confirmLogout();">
                        <i class="fa-solid fa-right-from-bracket bx"></i>
                        <span class="text">Logout</span>
                    </a>
                    <form class="d-none" id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </li>
            </ul>



        </section>

        <!-- CONTENT -->
        <section id="content">
            <!-- NAVBAR -->
            <nav>
                <i class="fa-solid fa-bars bx bx-menu "></i>
                <a class="nav-link" href="#">Categories</a>
                <form action="#">
                </form>

                <input class="hidden" id="switch-mode" type="checkbox">
                <label class="switch-mode" for="switch-mode"></label>

                <button id="user-menu-button" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom"
                    type="button" aria-expanded="false">
                    <span class="sr-only">Open user menu</span>
                    @php
                        $user = auth()->user();
                    @endphp

                    @if ($user->profile && file_exists(public_path($user->profile)))
                        <img class="h-8 w-8 rounded-full object-cover border-4 border-white shadow-lg"
                            src="{{ asset($user->profile) }}" alt="User Profile Image"
                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random';" />
                    @else
                        <img class="h-8 w-8 rounded-full object-cover border-4 border-white shadow-lg"
                            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                            alt="Default Profile Image" />
                    @endif
                </button>
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                        <span
                            class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                href="/admin/home">Dashboard</a>
                        </li>
                        <li>
                            <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                href="{{ route('profile_settings') }}">Profile Settings</a>

                        </li>
                        <li>
                            <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                href="#" onclick="confirmLogout();">Sign
                                out</a>
                        </li>
                    </ul>

                </div>
            </nav>




            <!-- MAIN CONTENT -->
            <main class="py-4">

                @yield('content')

            </main>




            <script src="https://cdn.lordicon.com/lordicon.js"></script>
            <!-- Include SweetAlert2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            <script src="{{ asset('js/Calendar.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.js"></script>
            <script src="{{ asset('js/graph.js') }}"></script>
            <script src="{{ asset('js/admin.js') }}"></script>
            <script src="{{ asset('js/flowbite/dist/flowbite.min.js') }}"></script>
            <!-- DataTables CDN and Initialization -->
            <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const setActiveClassFromStorage = () => {
                        const activePath = localStorage.getItem('activePath');
                        if (activePath) {
                            document.querySelectorAll('#sidebar-menu li').forEach(item => {
                                const link = item.querySelector('a');
                                if (link && link.getAttribute('href') === activePath) {
                                    item.classList.add('active');
                                } else {
                                    item.classList.remove('active');
                                }
                            });
                        }
                    };

                    setActiveClassFromStorage();

                    document.getElementById('sidebar-menu').addEventListener('click', event => {
                        if (event.target.tagName === 'A' || event.target.closest('a')) {
                            const clickedLink = event.target.tagName === 'A' ? event.target : event.target.closest(
                                'a');
                            const clickedPath = clickedLink.getAttribute('href');
                            localStorage.setItem('activePath', clickedPath);
                            document.querySelectorAll('#sidebar-menu li').forEach(item => item.classList.remove(
                                'active'));
                            clickedLink.parentElement.classList.add('active');
                        }
                    });
                });
            </script>
            <script>
                function confirmLogout() {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You will be logged out of your account",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444', // Red-500 color
                        cancelButtonColor: '#6B7280', // Gray-500 color
                        confirmButtonText: 'Yes, logout',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        customClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            Swal.fire({
                                title: 'Logging out...',
                                text: 'Please wait',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Submit the logout form
                            document.getElementById('logout-form').submit();
                        }
                    });
                }
            </script>

            <script src="{{ asset('js/lottie.min.js') }}"></script>
            <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            </script>

            <!-- Livewire Scripts -->
            @livewireScripts
            <script>
                // Initialize Flowbite and other components after Livewire navigation
                document.addEventListener('livewire:init', () => {
                    // Initial initialization
                    if (typeof initFlowbite === 'function') {
                        initFlowbite();
                    }
                });

                document.addEventListener('livewire:navigated', () => {
                    // Re-initialize after navigation
                    if (typeof initFlowbite === 'function') {
                        initFlowbite();
                    }
                });
            </script>
    </body>

</html>
