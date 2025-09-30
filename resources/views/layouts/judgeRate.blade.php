<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name', 'E.M.P') }}</title>
        <link type="image/png" href="{{ asset('img/emp-logo.png') }}" rel="icon">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <link href="{{ asset('css/boxicon/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/judge.css') }}" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <!-- Tailwind CSS via CDN -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
        <style>
            .card-bg {
                background-image: url('{{ asset(' img/sh1.jpg') }}');
                background-size: cover;
                background-position: center;

            }

            .error-message {
                color: red;
                font-size: 0.875rem;
                display: none;
            }

            .success-message {
                color: green;
                font-size: 0.875rem;
                display: none;
            }

            .success-input {
                background-color: #f0fdf4;
                border-color: #22c55e;
                color: #14532d;
            }

            .error-input {
                background-color: #fef2f2;
                border-color: #ef4444;
                color: #991b1b;
            }

            .button {
                height: 50px;
                width: 150px;
                border: none;
                border-radius: 10px;
                cursor: pointer;
                position: relative;
                overflow: hidden;
                transition: all 0.5s ease-in-out;
            }

            .button:hover {
                box-shadow: .5px .5px 150px #252525;
            }

            .type1::after {
                content: "Thanks";
                height: 50px;
                width: 150px;
                background-color: #058822;
                color: #fff;
                position: absolute;
                top: 0%;
                left: 0%;
                transform: translateY(50px);
                font-size: 1.2rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.5s ease-in-out;
            }

            .type1::before {
                content: "Submit";
                height: 50px;
                width: 150px;
                background-color: #0c69ec;
                color: #fafafa;
                position: absolute;
                top: 0%;
                left: 0%;
                transform: translateY(0px) scale(1.2);
                font-size: 1.2rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.5s ease-in-out;
            }

            .type1:hover::after {
                transform: translateY(0) scale(1.2);
            }

            .type1:hover::before {
                transform: translateY(-50px) scale(0) rotate(120deg);
            }



            /* cover will scale the image to cover the entire background */
        </style>
        @vite(['resources/css/app.css'])
    </head>

    <body>

        @if (session('success'))
            <style>
                .swal2-confirm.swal2-styled {
                    background-color: green !important;
                    color: white !important;
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: "{{ session('error') }}",
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                });
            </script>
        @endif

        <nav class="fixed top-0 left-0 z-50 w-full bg-white border-red-600 ">
            <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto ">
                <a class="flex items-center space-x-3 rtl:space-x-reverse" href="{{ url('/judge/home')}}">
                   

                    <span
                    class="self-center text-2xl font-semibold text-red-800 whitespace-nowrap">{{ Auth::user()->name }} 👨‍⚖️</span>
                </a>

                <button
                    class="inline-flex items-center justify-center w-10 h-10 p-2 text-sm text-red-800 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    data-collapse-toggle="navbar-solid-bg" type="button" aria-controls="navbar-solid-bg"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
                <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
                    <ul
                        class="flex flex-col mt-4 font-medium rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">

                        <li>
                            <a class="block px-3 py-2 text-red-800 md:p-0 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                                href="{{ route('select.event_in_judges') }}"><i class='bx bx-notepad'></i> Events</a>
                        </li>
                        <li>
                            <a class="block px-3 py-2 text-red-800 md:p-0 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                                data-modal-target="static-modal" data-modal-toggle="static-modal">
                                <i class='bx bx-bell'></i> approval
                            </a>
                            <!-- Main modal -->
                            <div class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
                                id="static-modal" data-modal-backdrop="static" aria-hidden="true" tabindex="-1">
                                <div class="relative w-full max-h-full p-4" style="max-width: 80rem;">
                                    <!-- Changed max-w-2xl to max-w-4xl -->
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                📝 Approval Form
                                            </h3>
                                            <button
                                                class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="static-modal" type="button">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-6 space-y-6">
                                            <h2
                                                class="mb-6 text-2xl font-bold text-center text-gray-900 dark:text-white">
                                                Your Approvals for This Event</h2>
                                            @if (($judgeApprovals ?? collect())->isEmpty())
                                                <p class="text-center text-gray-500">No approvals found for this event.
                                                </p>
                                            @else
                                                <div class="overflow-x-auto shadow-md sm:rounded-lg">
                                                    <table
                                                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                        <thead
                                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                            <tr>
                                                                <th class="px-6 py-3" scope="col">Select</th>
                                                                <th class="px-6 py-3" scope="col">Type</th>
                                                                <th class="px-6 py-3" scope="col">Contestant</th>
                                                                <th class="px-6 py-3" scope="col">Award/Round</th>
                                                                <th class="px-6 py-3" scope="col">Created</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($judgeApprovals as $approval)
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <td class="px-6 py-4">
                                                                        <input
                                                                            class="w-5 h-5 text-blue-600 rounded form-checkbox focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                                            type="checkbox">
                                                                    </td>
                                                                    <td
                                                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                                        {{ ucfirst($approval->approval_type) }}
                                                                    </td>
                                                                    <td class="px-6 py-4">
                                                                        {{ $approval->contestant->name }}
                                                                    </td>
                                                                    <td class="px-6 py-4">
                                                                        @if ($approval->award_id)
                                                                            @if ($approval->approval_type == 'minor_awards')
                                                                                Minor Award ID:
                                                                                {{ $approval->award_id }}
                                                                            @elseif($approval->approval_type == 'round_scores')
                                                                                Round ID: {{ $approval->award_id }}
                                                                            @endif
                                                                        @else
                                                                            N/A
                                                                        @endif
                                                                    </td>
                                                                    <td class="px-6 py-4">
                                                                        {{ $approval->created_at->diffForHumans() }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="pt-6 mt-8 border-t border-gray-200 dark:border-gray-600">
                                                    <h3
                                                        class="mb-4 text-lg font-semibold text-center text-gray-900 dark:text-white">
                                                        Judge Signature</h3>
                                                    <div class="flex flex-col items-center justify-between">
                                                        <div class="w-full max-w-md mb-4">
                                                            <div
                                                                class="overflow-hidden border-2 border-gray-300 rounded-lg dark:border-gray-600">
                                                                <canvas class="w-full h-40 bg-gray-200"
                                                                    id="signature-pad"></canvas>
                                                            </div>
                                                           
                                                        </div>
                                                        <div class="text-center">
                                                            <p class="font-semibold text-gray-900 dark:text-white">
                                                                {{ auth()->user()->name }}</p>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">Judge
                                                            </p>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">Date:
                                                                {{ now()->format('F d, Y') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif





                                        </div>

                                        <!-- Modal footer -->
                                        <div class="flex items-center justify-center p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
                                            <div class="flex space-x-4">
                                                <button
                                                    class="px-4 py-2 text-white transition-colors duration-200 bg-red-500 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                                                    id="clear-signature">Clear Signature</button>
                                                <button
                                                    class="px-4 py-2 text-white transition-colors duration-200 bg-green-500 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                                    id="save-signature">Submit Form</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-2 bg">
            @yield('content')
        </main>

        <footer class="text-gray-600 body-font">
            <div class="bg-gray-100">
                <div class="container flex flex-col flex-wrap px-5 py-4 mx-auto sm:flex-row">
                    <p class="text-sm text-center text-gray-500 sm:text-left">© 2024 Event Master-pro —
                        <a class="ml-1 text-gray-600" href="https://twitter.com/knyttneve" rel="noopener noreferrer"
                            target="_blank">@WLCORMOC.COM</a>
                    </p>
                    <span
                        class="w-full mt-2 text-sm text-center text-gray-500 sm:ml-auto sm:mt-0 sm:w-auto sm:text-left">Hosted
                        by WLC-CICTE</span>
                </div>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var canvas = document.getElementById('signature-pad');
                var signaturePad = new SignaturePad(canvas);

                document.getElementById('clear-signature').addEventListener('click', function() {
                    signaturePad.clear();
                });

                document.getElementById('save-signature').addEventListener('click', function() {
                    if (signaturePad.isEmpty()) {
                        alert('Please provide a signature first.');
                    } else {
                        var dataURL = signaturePad.toDataURL();
                        // Here you would typically send this dataURL to your server
                        console.log(dataURL);
                        alert('Signature saved!');
                    }
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/judge.js') }}"></script>
        <script src="{{ asset('js/inputvalidata.js') }}"></script>
        <script src="{{ asset('js/flowbite/dist/flowbite.min.js') }}"></script>

        <script src="{{ asset('js/lottie.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    
    </body>
</html>
