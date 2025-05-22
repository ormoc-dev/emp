@extends('layouts.user')
@section('content')
<div class="container mx-auto px-4 mb-10">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Your Voting History</h1>
        <div class="h-1 w-24 bg-red-500 rounded"></div>
    </div>


<!-- After Vote History section, add Payment History -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100 mt-8">
    <div class="p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment History</h2>
        
        @if($payments->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No payments yet</h3>
                <p class="mt-1 text-sm text-gray-500">Your payment history will appear here.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($payments as $payment)
                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg animate-fadeIn"
                         style="animation-delay: {{ $loop->iteration * 0.1 }}s">
                        <!-- Payment Icon -->
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-blue-100 rounded-full">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Payment Details -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">
                                    Payment to VoteSystem
                                </p>
                                <span class="text-sm text-gray-500">
                                    {{ $payment->created_at->format('M d, Y h:i A') }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500">
                                Transaction ID: {{ $payment->transaction_id }}
                            </p>
                            <div class="mt-1 flex items-center justify-between">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $payment->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $payment->status }}
                                </span>
                                <span class="text-sm font-medium text-gray-900">
                                    ₱{{ number_format($payment->amount, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Add a "Load More" button if needed -->
            @if($payments->count() > 10)
                <div class="mt-6 text-center">
                    <button class="px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-500">
                        Load More
                    </button>
                </div>
            @endif
        @endif
    </div>
</div>



    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Votes</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $votes->sum('vote_count') }}</h3>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Events Participated</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $votes->pluck('event_id')->unique()->count() }}</h3>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Contestants Supported</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $votes->pluck('contestant_id')->unique()->count() }}</h3>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Vote History -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Voting Activity</h2>
            
            @if($votes->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No votes yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Start voting to see your history here.</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($votes as $vote)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg animate-fadeIn" 
                             style="animation-delay: {{ $loop->iteration * 0.1 }}s">
                            <!-- Contestant Image -->
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full object-cover" 
                                     src="{{ asset($vote->contestant->profile) }}" 
                                     alt="{{ $vote->contestant->name }}">
                            </div>
                            
                            <!-- Vote Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">
                                        Voted for {{ $vote->contestant->name }}
                                    </p>
                                    <span class="text-sm text-gray-500">
                                        {{ $vote->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500">
                                    Event: {{ $vote->event->event_name }}
                                </p>
                                <div class="mt-1 flex items-center">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $vote->vote_count }} votes
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination if needed -->
                <div class="mt-6">
                    {{-- Add pagination here if you implement it --}}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out forwards;
    opacity: 0;
}
</style>
@endsection