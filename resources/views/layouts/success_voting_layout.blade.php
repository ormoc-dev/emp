<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name', 'E.M.P') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('img/emp-logo.png') }}" >
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <link href="{{ asset('css/boxicon/boxicons.min.css') }}" rel="stylesheet">
        @vite(['resources/css/app.css'])
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <!-- Tailwind CSS via CDN -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
       
    </head>
    <body class="flex flex-col min-h-screen bg-green-500">
        <main class="flex-grow bg-green-500">
            @yield('content')
        </main>
    
        <footer class="p-6 mt-auto bg-gray-200 rounded-lg shadow-md">
            <h1 class="mb-4 text-3xl font-bold text-center text-green-600">Voting Success!</h1>
            <p class="mb-4 text-center">You will now be redirected to the next round, if available.</p>
            <div class="flex justify-center mb-4">
                <a href="{{ route('nextRound', ['eventId' => $event->id]) }}" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" >GO TO NEXT ROUND</a>
            </div>
            <div class="flex items-center justify-between">
                <a href="" class="text-lg text-blue-500"><<< Back</a>
                <p class="text-sm text-right text-gray-500">This Back link is optional only if the tabulator forgets to add other criteria :)</p>
            </div>
        </footer>
        
             
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/flowbite/dist/flowbite.min.js') }}"></script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
        <script>
            bodymovin.loadAnimation({
                container: document.getElementById('judge_success'),
                path: '{{asset('json/animate/judge_success.json')}}'
            })
        </script>
          <script src="{{ asset('js/lottie.min.js') }}"></script>
    </body>
    
</html>
