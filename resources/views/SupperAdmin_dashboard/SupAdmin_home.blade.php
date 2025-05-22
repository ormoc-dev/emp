@extends('layouts.Supper_admin')
@section('content')
    <!-- Welcome Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Welcome Back, {{ Auth::user()->name }}</h1>
                <p class="text-gray-600">Here's what's happening with your platform today.</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600">Today's Date</p>
                <p class="text-lg font-semibold">{{ now()->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <div class="rounded-lg border-gray-300 dark:border-gray-600 h-32 md:h-24">
            <div class="bg-slate-50 p-5 m-2 rounded-md flex justify-between items-center shadow">
                <div>
                    <h3 class="font-bold">Total Users</h3>
                    <p class="text-gray-500">{{ $usersCount }}</p>

                </div>
                <i class="bx bxs-user-account p-4 bg-gray-200 rounded-md"></i>

            </div>
        </div>
        <div class="rounded-lg border-gray-300 dark:border-gray-600 h-32 md:h-24">
            <div class="bg-slate-50 p-5 m-2 flex justify-between items-center shadow">
                <div>
                    <h3 class="font-bold">Total Contestants</h3>
                    <p class="text-gray-500">{{ $ContestantCount }}</p>
                </div>

                <i class="bx bx-male p-4 bg-green-200  rounded-md"></i>
            </div>
        </div>
        <div class="rounded-lg border-gray-300 dark:border-gray-600 h-32 md:h-24">
            <div class="bg-slate-50 p-5 m-2 flex justify-between items-center shadow">
                <div>
                    <h3 class="font-bold">Total Judges</h3>
                    <p class="text-gray-500">{{ $judgeCount }}</p>

                </div>

                <i class="bx bx-group p-4 bg-yellow-200  rounded-md"></i>
            </div>
        </div>
        <div class="rounded-lg border-gray-300 dark:border-gray-600 h-32 md:h-24">
            <div class="bg-slate-50 p-5 m-2 flex justify-between items-center shadow">
                <div>
                    <h3 class="font-bold">Total Tabulators</h3>
                    <p class="text-gray-500">{{ $TabulatorCount }}</p>
                </div>

                <i class='bx bxs-user-badge bg-red-200 rounded-md p-4'></i>
            </div>
        </div>
    </div>
    <div class=" border-gray-300 dark:border-gray-600 h-[50%] mb-4">

        <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
            <!-- chart  -->

            <!-- Analytics Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Event Analytics Chart -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4 border-b">
                        <h2 class="text-xl font-semibold text-gray-800">Event Analytics</h2>
                        <p class="text-sm text-gray-500">Yearly overview of events and engagement</p>
                    </div>
                    <div class="p-4">
                        <div class="w-full min-h-[350px]" id="eventChart"></div>
                    </div>
                </div>

                <!-- Event Status Chart -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4 border-b">
                        <h2 class="text-xl font-semibold text-gray-800">Event Status Distribution</h2>
                        <p class="text-sm text-gray-500">Overview of event completion status</p>
                    </div>
                    <div class="p-4">
                        <div class="w-full min-h-[350px]" id="statusChart"></div>
                    </div>
                </div>
            </div>

            <!-- Add necessary scripts -->
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Event Analytics Chart
                    const eventChartOptions = {
                        chart: {
                            height: 350,
                            type: 'line',
                            stacked: false,
                            toolbar: {
                                show: true
                            },
                            zoom: {
                                enabled: true
                            }
                        },
                        stroke: {
                            width: [0, 4],
                            curve: 'smooth'
                        },
                        dataLabels: {
                            enabled: false
                        },
                        colors: ['#4F46E5', '#10B981'],
                        series: [{
                                name: 'Total Events',
                                type: 'column',
                                data: @json($eventCounts)
                            },
                            {
                                name: 'Total Views',
                                type: 'line',
                                data: @json($eventViews)
                            }
                        ],
                        xaxis: {
                            categories: @json($eventYears),
                            title: {
                                text: 'Years'
                            }
                        },
                        yaxis: [{
                                title: {
                                    text: 'Total Events',
                                    style: {
                                        color: '#4F46E5'
                                    }
                                },
                                labels: {
                                    style: {
                                        colors: '#4F46E5'
                                    }
                                }
                            },
                            {
                                opposite: true,
                                title: {
                                    text: 'Total Views',
                                    style: {
                                        color: '#10B981'
                                    }
                                },
                                labels: {
                                    style: {
                                        colors: '#10B981'
                                    }
                                }
                            }
                        ],
                        tooltip: {
                            shared: true,
                            intersect: false,
                            theme: 'dark'
                        }
                    };

                    // Status Distribution Chart
                    const statusChartOptions = {
                        chart: {
                            height: 350,
                            type: 'bar',
                            stacked: true,
                            toolbar: {
                                show: true
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                borderRadius: 5,
                            },
                        },
                        colors: ['#FCD34D', '#34D399'],
                        series: [{
                                name: 'Pending Events',
                                data: @json($pendingEvents)
                            },
                            {
                                name: 'Completed Events',
                                data: @json($completedEvents)
                            }
                        ],
                        xaxis: {
                            categories: @json($eventYears),
                            title: {
                                text: 'Years'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Number of Events'
                            }
                        },
                        tooltip: {
                            theme: 'dark'
                        },
                        legend: {
                            position: 'top'
                        }
                    };

                    try {
                        const eventChart = new ApexCharts(document.querySelector("#eventChart"), eventChartOptions);
                        const statusChart = new ApexCharts(document.querySelector("#statusChart"), statusChartOptions);

                        eventChart.render();
                        statusChart.render();
                    } catch (error) {
                        console.error('Error rendering charts:', error);
                        const errorMessage = `
                  <div class="text-center p-4 text-red-500">
                      <p>Failed to load analytics.</p>
                       <p class="text-sm">Please refresh the page.</p>
                                  </div>
                                   `;
                        document.querySelector("#eventChart").innerHTML = errorMessage;
                        document.querySelector("#statusChart").innerHTML = errorMessage;
                    }
                });
            </script>

            <!-- Custom Styles -->
            <style>
                .apexcharts-tooltip {
                    @apply shadow-lg;
                }

                .apexcharts-toolbar {
                    @apply z-10;
                }

                @keyframes chartFadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(10px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                #eventChart,
                #statusChart {
                    animation: chartFadeIn 0.5s ease-out;
                }
            </style>

            <!-- //user list -->
            <div class="overflow-x-auto m-2 shadow-md">
                <table class="w-full">
                    <thead class="bg-gray-100 rounded-sm">
                        <tr>
                            <th class="text-left">Avatar</th>
                            <th class="text-left">User Name</th>
                            <th class="text-left">Email</th>
                            <th class="text-left">level</th>
                            <th class="text-left">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admin as $admins)
                            <tr>
                                <td>
                                    @if ($admins->profile)
                                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
                                            src="{{ asset($admins->profile) }}" alt="User Profile Image" />
                                    @endif
                                </td>
                                <td>{{ $admins->name }}</td>
                                <td>{{ $admins->email }}</td>
                                <td>{{ $admins->level }}</td>
                                <td>
                                    <span
                                        class="bg-green-50 text-green-700 px-3 py-1 ring-1 ring-green-200 text-xs rounded-md">Active</span>
                                </td>
                                <td>
                                    <div class="flex justify-between gap-1">
                                        <i class="bx bx-edit p-1 text-green-500 rounded-full cursor-pointer"
                                            title="Edit"></i>
                                        <i class="bx bx-street-view p-1 text-violet-500 rounded-full cursor-pointer"
                                            title="View"></i>
                                        <i class="bx bxs-trash p-1 text-red-500 rounded-full cursor-pointer"
                                            title="Delete"></i>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    

    </div>
    </div>
@endsection
