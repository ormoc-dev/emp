@extends('layouts.welcome_layout')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
@section('content')
   
    <!-- Add the background to the body -->
    <div class="relative min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
        <!-- Decorative elements -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-red-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-40 h-40 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000">
            </div>
        </div>

        <!-- Content wrapper -->
        <div class="relative">
            <!--OUR TEAM SECTION-->
            <section class="text-gray-600 body-font py-24">
                <div class="container px-5 mx-auto">
                    <div class="text-center mb-20">
                        <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900 mb-4">Our Team</h1>
                        <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto text-gray-500s">Meet the talented
                            individuals
                            behind our success. Each member brings unique skills and expertise to our team.</p>
                        <div class="flex mt-6 justify-center">
                            <div class="w-16 h-1 rounded-full bg-red-500 inline-flex"></div>
                        </div>
                    </div>
                    <div class="flex flex-wrap -m-4">

                        <div class="p-4 lg:w-1/2">
                            <div
                                class="h-full flex sm:flex-row flex-col items-center sm:justify-start justify-center text-center sm:text-left">
                                <img class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4 shadow-lg"
                                    src="{{ asset('img/ton.jpg') }}" alt="team">
                                <div class="flex-grow sm:pl-8">
                                    <h2 class="title-font font-medium text-lg text-gray-900">Anthony Capuyan</h2>
                                    <h3 class="text-gray-500 mb-3">Developer</h3>
                                    <p class="mb-4">Anthony Capuyan is a skilled programmer and mobile application
                                        developer with
                                        expertise in developing software solutions. He specializes in writing code and
                                        developing
                                        applications to meet specific requirements.</p>
                                    <span class="inline-flex">
                                        <a class="text-gray-500 hover:text-gray-700"
                                            href="https://web.facebook.com/antony.capuyan/">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a class="ml-2 text-gray-500 hover:text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                                <path
                                                    d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a class="ml-2 text-gray-500 hover:text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                                <path
                                                    d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z">
                                                </path>
                                            </svg>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 lg:w-1/2">
                            <div
                                class="h-full flex sm:flex-row flex-col items-center sm:justify-start justify-center text-center sm:text-left">
                                <img class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4 shadow-lg"
                                    src="{{ asset('img/myreen.jpg') }}" alt="team">
                                <div class="flex-grow sm:pl-8">
                                    <h2 class="title-font font-medium text-lg text-gray-900">Myreen Barro</h2>
                                    <h3 class="text-gray-500 mb-3">Documentaries</h3>
                                    <p class="mb-4">Myreen Barro is responsible for documenting project processes and
                                        outcomes. As
                                        a documentarist, she captures key moments, milestones, and learnings to create
                                        comprehensive
                                        records.</p>
                                    <span class="inline-flex">
                                        <a class="text-gray-500 hover:text-gray-700"
                                            href="https://web.facebook.com/myreen.barro">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a class="ml-2 text-gray-500 hover:text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                                <path
                                                    d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a class="ml-2 text-gray-500 hover:text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                                <path
                                                    d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z">
                                                </path>
                                            </svg>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 lg:w-1/2">
                            <div
                                class="h-full flex sm:flex-row flex-col items-center sm:justify-start justify-center text-center sm:text-left">
                                <img class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4 shadow-lg"
                                    src="{{ asset('img/ange.jpg') }}" alt="team">
                                <div class="flex-grow sm:pl-8">
                                    <h2 class="title-font font-medium text-lg text-gray-900">Angelo Conos</h2>
                                    <h3 class="text-gray-500 mb-3">Documentaries</h3>
                                    <p class="mb-4">Angelo Conos is responsible for documenting project processes and
                                        outcomes.
                                        As a documentarist, he captures key moments, milestones, and learnings to create
                                        comprehensive records.</p>
                                    <span class="inline-flex">
                                        <a class="text-gray-500 hover:text-gray-700"
                                            href="https://web.facebook.com/angelo.trinidad.338658">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a class="ml-2 text-gray-500 hover:text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a class="ml-2 text-gray-500 hover:text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z">
                                                </path>
                                            </svg>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="p-4 lg:w-1/2">
                            <div
                                class="h-full flex sm:flex-row flex-col items-center sm:justify-start justify-center text-center sm:text-left">
                                <img class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4 shadow-lg"
                                    src="{{ asset('img/cantero.jpg') }}" alt="team">
                                <div class="flex-grow sm:pl-8">
                                    <h2 class="title-font font-medium text-lg text-gray-900">Jojo Cantero</h2>
                                    <h3 class="text-gray-500 mb-3">Adviser</h3>
                                    <p class="mb-4">Jojo Cantero serves as an adviser, providing valuable insights and
                                        guidance to
                                        the team. With years of experience in the industry, Jojo offers strategic advice and
                                        direction to help navigate complex challenges.</p>
                                    <span class="inline-flex">
                                        <a class="text-gray-500 hover:text-gray-700"
                                            href="https://web.facebook.com/jojo.e.cantero">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a class="ml-2 text-gray-500 hover:text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a class="ml-2 text-gray-500 hover:text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z">
                                                </path>
                                            </svg>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--FRAMEWORKS $ TEC SECTION-->
            <section class="text-gray-600 body-font">
                <div class="container px-5 py-24 mx-auto">
                    <div class="flex flex-col text-center w-full mb-20">
                        <h1 class="text-2xl font-medium title-font mb-4 text-gray-900 animate-grow">FRAMEWORKS &
                            TECHNOLOGIES</h1>
                        <p class="lg:w-2/3 mx-auto leading-relaxed text-base animate-slideIn ">Our project leverages a
                            powerful
                            stack of modern frameworks and technologies to deliver a robust and efficient solution.</p>
                    </div>
                    <div class="flex flex-wrap -m-4">
                        <!-- Laravel -->
                        <div class="p-4 lg:w-1/4 md:w-1/2">
                            <div class="h-full flex flex-col items-center text-center">
                                <img class="flex-shrink-0 rounded-lg w-32 h-32 object-contain object-center mb-4"
                                    src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"
                                    alt="Laravel">
                                <div class="w-full">
                                    <h2 class="title-font font-medium text-lg text-gray-900">Laravel</h2>
                                    <p class="mb-4 animate-slideIn">A powerful PHP framework for web application
                                        development,
                                        offering elegant syntax and a rich set of features.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Tailwind CSS -->
                        <div class="p-4 lg:w-1/4 md:w-1/2">
                            <div class="h-full flex flex-col items-center text-center">
                                <img class="flex-shrink-0 rounded-lg w-32 h-32 object-contain object-center mb-4"
                                    src="https://upload.wikimedia.org/wikipedia/commons/d/d5/Tailwind_CSS_Logo.svg"
                                    alt="Tailwind CSS">
                                <div class="w-full">
                                    <h2 class="title-font font-medium text-lg text-gray-900">Tailwind CSS</h2>
                                    <p class="mb-4 animate-slideIn">A utility-first CSS framework for rapidly building
                                        custom user
                                        interfaces with minimal CSS.</p>
                                </div>
                            </div>
                        </div>
                        <!-- MySQL -->
                        <div class="p-4 lg:w-1/4 md:w-1/2">
                            <div class="h-full flex flex-col items-center text-center">
                                <img class="flex-shrink-0 rounded-lg w-32 h-32 object-contain object-center mb-4"
                                    src="https://labs.mysql.com/common/logos/mysql-logo.svg" alt="MySQL">
                                <div class="w-full">
                                    <h2 class="title-font font-medium text-lg text-gray-900">MySQL</h2>
                                    <p class="mb-4 animate-slideIn">An open-source relational database management system
                                        known for
                                        its reliability and performance.</p>
                                </div>
                            </div>
                        </div>
                        <!-- JavaScript -->
                        <div class="p-4 lg:w-1/4 md:w-1/2">
                            <div class="h-full flex flex-col items-center text-center">
                                <img class="flex-shrink-0 rounded-lg w-32 h-32 object-contain object-center mb-4"
                                    src="https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg"
                                    alt="JavaScript">
                                <div class="w-full">
                                    <h2 class="title-font font-medium text-lg text-gray-900">JavaScript</h2>
                                    <p class="mb-4 animate-slideIn">A versatile programming language that enables
                                        interactive and
                                        dynamic web experiences.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Flutter -->
                        <div class="p-4 lg:w-1/4 md:w-1/2">
                            <div class="h-full flex flex-col items-center text-center">
                                <img class="flex-shrink-0 rounded-lg w-32 h-32 object-contain object-center mb-4"
                                    src="https://storage.googleapis.com/cms-storage-bucket/6a07d8a62f4308d2b854.svg"
                                    alt="Flutter">
                                <div class="w-full">
                                    <h2 class="title-font font-medium text-lg text-gray-900">Flutter</h2>
                                    <p class="mb-4 animate-slideIn">Google's UI toolkit for building natively compiled
                                        applications
                                        for mobile, web, and desktop from a single codebase.</p>
                                </div>
                            </div>
                        </div>
                        <!-- HTML & CSS -->
                        <div class="p-4 lg:w-1/4 md:w-1/2">
                            <div class="h-full flex flex-col items-center text-center">
                                <div class="flex justify-center items-center w-32 h-32 mb-4">
                                    <img class="flex-shrink-0 rounded-lg w-16 h-16 object-contain object-center"
                                        src="https://www.w3.org/html/logo/badge/html5-badge-h-solo.png" alt="HTML">
                                    <img class="flex-shrink-0 rounded-lg w-16 h-16 object-contain object-center ml-2"
                                        src="https://upload.wikimedia.org/wikipedia/commons/d/d5/CSS3_logo_and_wordmark.svg"
                                        alt="CSS">
                                </div>
                                <div class="w-full">
                                    <h2 class="title-font font-medium text-lg text-gray-900">HTML & CSS</h2>
                                    <p class="mb-4 animate-slideIn">The fundamental languages for structuring and styling
                                        web
                                        content, creating the foundation for web development.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Docker -->
                        <div class="p-4 lg:w-1/4 md:w-1/2">
                            <div class="h-full flex flex-col items-center text-center">
                                <img class="flex-shrink-0 rounded-lg w-32 h-32 object-contain object-center mb-4"
                                    src="https://www.docker.com/wp-content/uploads/2022/03/vertical-logo-monochromatic.png"
                                    alt="Docker">
                                <div class="w-full">
                                    <h2 class="title-font font-medium text-lg text-gray-900">Docker</h2>
                                    <p class="mb-4 animate-slideIn">A platform for developing, shipping, and running
                                        applications
                                        in containers, ensuring consistency across different environments.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Vite -->
                        <div class="p-4 lg:w-1/4 md:w-1/2">
                            <div class="h-full flex flex-col items-center text-center">
                                <img class="flex-shrink-0 rounded-lg w-32 h-32 object-contain object-center mb-4"
                                    src="https://vitejs.dev/logo.svg" alt="Vite">
                                <div class="w-full">
                                    <h2 class="title-font font-medium text-lg text-gray-900">Vite</h2>
                                    <p class="mb-4 animate-slideIn">A next-generation frontend build tool that
                                        significantly
                                        improves the frontend development experience.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    </section>
@endsection
