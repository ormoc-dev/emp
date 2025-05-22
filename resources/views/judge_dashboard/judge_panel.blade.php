@extends('layouts.judge')
@section('content')
<section class="text-gray-600 body-font p-6 md:p-12">
    <div class="container mx-auto flex flex-wrap px-4 md:px-12 lg:px-24 py-4">
        <div class="flex flex-wrap w-full">
            <div class="lg:w-2/5 md:w-1/2 w-full md:pr-10 md:py-6">
                <div class="flex relative pb-12">
                    <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
                        <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
                    </div>
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-700 inline-flex items-center justify-center text-white relative z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                    </div>
                    <div class="flex-grow pl-4">
                        <h2 class="font-medium title-font text-sm lg:text-base text-gray-900 mb-1 tracking-wider">STEP 1</h2>
                        <p class="leading-relaxed text-sm lg:text-base" id="step-text-1">
                            <!-- Text will be inserted here by JavaScript -->
                        </p>
                    </div>
                </div>

                <div class="flex relative pb-12">
                    <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
                        <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
                    </div>
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-700 inline-flex items-center justify-center text-white relative z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="flex-grow pl-4">
                        <h2 class="font-medium title-font text-sm lg:text-base text-gray-900 mb-1 tracking-wider">STEP 2</h2>
                        <p class="leading-relaxed text-sm lg:text-base" id="step-text-2">
                            <!-- Text will be inserted here by JavaScript -->
                        </p>
                    </div>
                </div>
                <div class="flex relative">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-700 inline-flex items-center justify-center text-white relative z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                            <path d="M22 4L12 14.01l-3-3"></path>
                        </svg>
                    </div>
                    <div class="flex-grow pl-4">
                        <h2 class="font-medium title-font text-sm lg:text-base text-gray-900 mb-1 tracking-wider">FINISH</h2>
                        <p class="leading-relaxed text-sm lg:text-base" id="finish-text">
                            <!-- Text will be inserted here by JavaScript -->
                        </p>
                    </div>
                </div>
                <div class="flex w-full justify-center mt-12">
                    <button class="text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('select.event_in_judges') }}">View Events</a>
                    </button>
                </div>
            </div>

            <div class="lg:w-3/5 md:w-1/2 w-full object-cover object-center rounded-lg md:mt-8 flex items-center animate-fadeIn">
                <div id="judge_panel" class="w-full h-64 md:h-96 lg:h-650"></div>
            </div>
        </div>
    </div>
</section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = [
                "Review the competition rules, judging criteria, and scoring guidelines. Ensure you understand all categories and weightings.",
                "Review and finalize your scores and comments. Ensure all assigned entries have been judged before submitting your final evaluations."
            ];
            const finishText =
                "All steps are complete. Thank you for your participation! Review your submission and await further instructions or results.";

            function typeWriter(text, elementId, callback, speed = 10) {
                let index = 0;
                const element = document.getElementById(elementId);

                function type() {
                    if (index < text.length) {
                        element.innerHTML += text.charAt(index);
                        index++;
                        setTimeout(type, speed);
                    } else if (callback) {
                        callback();
                    }
                }
                type();
            }

            function startTyping() {
                typeWriter(steps[0], 'step-text-1', function() {
                    typeWriter(steps[1], 'step-text-2', function() {
                        typeWriter(finishText, 'finish-text');
                    });
                });
            }

            startTyping();
        });
    </script>
@endsection
