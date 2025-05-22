@extends('layouts.Supper_admin')

@section('content')





  <!--EVENT HISTORY SECTION-->
  <section class="text-gray-800 body-font">
    <div class="container mx-auto mb-14 px-5">
        <!-- Header -->
        <div class="flex flex-col">
           
            <div class="flex flex-wrap sm:flex-row flex-col py-6 mb-12">
                <h1 class="sm:w-2/5 text-gray-900 font-semibold text-2xl mb-2 sm:mb-0 flex items-center">
                    <span class="mr-2">Event History Highlights</span>
                    <lord-icon src="https://cdn.lordicon.com/vneufqmz.json" style="width:40px;height:40px"
                        trigger="loop" delay="2000"
                        colors="primary:#3a3347,secondary:#ffffff,tertiary:#ffc738,quaternary:#faddd1,quinary:#646e78,senary:#ee6d66">
                    </lord-icon>
                </h1>
               
            </div>
        </div>

        <!-- Event Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-10">
            <!-- First Card -->
            <div class="sm:col-span-6 lg:col-span-5">
                <a href="#">
                    <img class="h-56 w-full object-cover rounded-md" src="{{ asset('/img/mr&ms.jpg') }}"
                        alt="Mr. and Miss Intramurals 2024">
                </a>
                <div class="mt-3">
                    <a class="text-xs text-indigo-600 uppercase font-medium hover:text-gray-900"
                        href="#">Event</a>
                    <a class="block text-gray-900 font-bold text-lg hover:text-indigo-600 transition"
                        href="#">Mr. and Miss Intramurals 2024 in Western Leyte</a>
                    <p class="text-gray-700 text-sm mt-2">Celebrate elegance, charm, and athleticism at this
                        yearÃ¢â‚¬â„¢s much-anticipated Mr. and Miss Intramurals 2024 in Western Leyte. Witness a
                        showcase of talent, style, and passion for excellence!</p>
                </div>
            </div>


            <!-- List of Events -->
            <div class="sm:col-span-6 lg:col-span-4">
                <div class="space-y-5">
                    <!-- Event Item -->
                    <div class="flex items-start">
                        <a class="mr-3 flex-shrink-0" href="#">
                            <img class="w-20 h-20 object-cover rounded-md" src="{{ asset('/img/fday6.jpg') }}"
                                alt="Event Image">
                        </a>
                        <div class="text-sm">
                            <p class="text-gray-600 text-xs">Aug 18</p>
                            <a class="text-gray-900 font-medium hover:text-indigo-600" href="#">Miss OC 2 Brings
                                Excitement and Glamour to Stage</a>
                        </div>
                    </div>
                    <!-- Event Item -->
                    <div class="flex items-start">
                        <a class="mr-3 flex-shrink-0" href="#">
                            <img class="w-20 h-20 object-cover rounded-md" src="{{ asset('img/fday3.jpg') }}"
                                alt="Event Image">
                        </a>
                        <div class="text-sm">
                            <p class="text-gray-600 text-xs">Jan 18</p>
                            <a class="text-gray-900 font-medium hover:text-indigo-600" href="#">Miss Elegance
                                Highlights Beauty and Cultural Heritage</a>
                        </div>
                    </div>
                    <!-- Event Item -->
                    <div class="flex items-start">
                        <a class="mr-3 flex-shrink-0" href="#">
                            <img class="w-20 h-20 object-cover rounded-md" src="{{ asset('img/missOC.jpg') }}"
                                alt="Event Image">
                        </a>
                        <div class="text-sm">
                            <p class="text-gray-600 text-xs">Aug 18</p>
                            <a class="text-gray-900 font-medium hover:text-indigo-600" href="#">Miss WLC 2023
                                Showcases Talent and Charisma Tonight.</a>
                        </div>
                    </div>
                    <!-- Event Item -->
                    <div class="flex items-start">
                        <a class="mr-3 flex-shrink-0" href="#">
                            <img class="w-20 h-20 object-cover rounded-md" src="{{ asset('img/fday.jpg') }}"
                                alt="Event Image">
                        </a>
                        <div class="text-sm">
                            <p class="text-gray-600 text-xs">July 23</p>
                            <a class="text-gray-900 font-medium hover:text-indigo-600" href="#">Miss WLC 2024
                                Celebrates Diversity and Empowerment</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Card -->
            <div class="sm:col-span-12 lg:col-span-3">
                <a href="#">
                    <img class="h-56 w-full object-cover rounded-md" src="{{ asset('img/grid2.png') }}"
                        alt="Fashion Event">
                </a>
                <div class="mt-3">
                    <a class="text-xs text-indigo-600 uppercase font-medium hover:text-gray-900"
                        href="#">Fashion</a>
                    <a class="block text-gray-900 font-bold text-lg hover:text-indigo-600 transition"
                        href="#">The perfect summer sweater that you can wear!</a>
                    <p class="text-gray-700 text-sm mt-2">The Grand Pageant Showcases Beauty and Talent.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection