@extends('layouts.user')
<!-- Bootstrap CSS -->

@section('content')

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500
        });
    });
</script>
@endif
<div class="container mx-auto  px-4 sm:px-12 lg:px-8   md:mb-[200px]">
    @if(auth()->check())
    <div class="relative overflow-hidden  bg-gradient-to-r from-gray-50 to-white">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 z-0">
            <div class="absolute -left-4 -top-4 w-24 h-24 bg-red-50 rounded-full opacity-50"></div>
            <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-blue-50 rounded-full opacity-50"></div>
        </div>
    
        <!-- Votes Counter Section -->
        <div class="relative z-10 text-center max-w-4xl mx-auto px-4">
            <div class="mb-8">
                <span class="inline-block px-4 py-1 rounded-full text-sm font-semibold text-red-500 bg-red-50 mb-4">
                    PRICING DASHBOARD
                </span>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6 animate-grow">
                    Your Voting Power
                </h3>
                
                <!-- Votes Display -->
                <div class="bg-white rounded-2xl shadow-lg p-8 transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center mb-4">
                            <span class="text-3xl font-bold text-white">{{ auth()->user()->remaining_votes }}</span>
                        </div>
                        <h4 class="text-xl font-semibold text-gray-700 mb-2">Remaining Votes</h4>
                        <p class="text-gray-500">Use them wisely to support your favorite contestants!</p>
                    </div>
    
                    <!-- Vote Statistics -->
                    <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-100">
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-800">1</span>
                            <span class="text-sm text-gray-500">Vote per Account</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-800">24h</span>
                            <span class="text-sm text-gray-500">Vote Reset</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Pricing Section Header -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-red-500 tracking-wide uppercase">PRICING PLANS</h2>
                <p class="mt-2 text-4xl font-extrabold text-gray-800 tracking-tight animate-grow">
                    Choose Your Voting Power
                </p>
                <div class="mt-4 max-w-2xl mx-auto">
                    <p class="text-xl text-gray-500 animate-slideIn">
                        Choose the plan that suits your needs and budget. We offer flexible options to cater to your specific requirements.
                    </p>
                </div>
    
                <!-- Features List -->
                <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="w-12 h-12 mx-auto bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Instant Activation</h3>
                        <p class="mt-2 text-sm text-gray-500">Your votes are instantly added to your account upon purchase</p>
                    </div>
    
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="w-12 h-12 mx-auto bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Secure Voting</h3>
                        <p class="mt-2 text-sm text-gray-500">Your votes are securely processed and cannot be tampered with</p>
                    </div>
    
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="w-12 h-12 mx-auto bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Fast Processing</h3>
                        <p class="mt-2 text-sm text-gray-500">Quick and easy voting process with minimal waiting time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .animate-grow {
        animation: grow 0.5s ease-out;
    }
    
    .animate-slideIn {
        animation: slideIn 0.5s ease-out;
    }
    
    @keyframes grow {
        from {
            transform: scale(0.95);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
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
    </style>
    
    <div class="flex flex-wrap justify-center space-y-6 sm:space-y-0 sm:space-x-6 mt-6">
               <!-- Free Plan -->
               <div class="max-w-sm w-full sm:w-1/3 shadow-md rounded-lg p-8 relative overflow-hidden " style="background-image: url('{{ asset('img/bgss.jpeg') }}'); background-color: rgba(0, 0, 0, 0.5); 
                background-size: cover; background-position: center;">
                <!-- Background Image -->
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-300 ease-in-out hover:scale-105 " style="background-image: url('{{ asset('img/free.png') }}'); background-color: rgba(0, 0, 0, 0.5); 
                background-size: cover; background-position: center;"></div>
                
                <!-- Content Layer -->
                <div class="relative z-10"> <!-- Added z-10 to ensure content is above the background -->
                    <h3 class="text-xl font-semibold text-white ">Free Plan</h3>
                    <p class="text-white "> <i class="fa-regular fa-circle-check text-green-500"></i> free 1 vote </p>
                    <p class="text-white  "><i class="fa-regular fa-circle-check text-green-500"></i> Registered user</p>
               
                </div>
            </div>

       <!-- Basic Plan -->
<div class="max-w-sm w-full sm:w-1/3 shadow-md rounded-lg p-6 relative overflow-hidden">
    
    <!-- Test Beta Badge -->
    <span class="absolute top-2 left-2 bg-gold-500 text-white text-xs font-bold py-1 px-2 rounded-full bg-yellow-500 z-50">Test Beta not available</span> <!-- Added badge -->

    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-300 ease-in-out hover:scale-105" style="background-image: url('{{ asset('img/paymogoo.jpg') }}');"></div>
    
    <div class="relative z-10"> 
        
        <h3 class="text-xl font-semibold text-white">Basic Plan</h3>
        <p class="text-white mb-12">100 PHP / 20 votes</p>
        <a href="{{ route('pricing_vote_pay') }}">
            <button class="w-full inline-flex gap-2 items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium
            text-white bg-green-500 hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
            disabled style="cursor: not-allowed; opacity: 0.6;">
                <i class="fa-solid fa-money-check-dollar text-2xl text-white"></i> Choose Basic
            </button>
        </a>
    </div>
</div>
       <!-- Paypal -->
             <!-- Paypal -->
             <div class="max-w-sm w-full sm:w-1/3 shadow-md rounded-lg p-6 relative overflow-hidden">
           
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-300 ease-in-out hover:scale-105" style="background-image: url('{{ asset('img/paypaal.jpg') }}'); background-color: rgba(0, 0, 0, 0.5);"></div>
                
                
                <div class="relative z-10"> 
                    <form action="{{ route('paypal_integration') }}" method="post">
                        @csrf 
                        <h3 class="text-xl font-semibold text-white mb-4">Pay with <i class="fa-brands fa-cc-paypal text-3xl text-yellow-500"></i></h3>
                        <p class="text-white mb-8">50 PHP / 10 vote</p>
                        
                        <button type="submit" class="w-full inline-flex gap-2 items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium
                        text-white bg-yellow-300 hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                         <i class="fa-brands fa-paypal text-2xl text-blue-500"></i> Choose Basic
                        </button>
                    </form>
                </div>
            </div>
    </div>
</div>










   
@endsection