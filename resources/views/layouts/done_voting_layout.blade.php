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
        @vite(['resources/css/app.css'])
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <!-- Tailwind CSS via CDN -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
       
    </head>
    <body class="bg-green-500">
        <main class="py-2 bg">
            @yield('content')
        </main>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script src="{{ asset('js/flowbite/dist/flowbite.min.js') }}"></script>

        <footer class="p-6 bg-gray-100 rounded-lg shadow-md ">
            <h1 class="mb-4 text-3xl font-bold text-center text-green-600">Voting Completed!</h1>
            <p class="mb-6 text-lg text-center">Thank you for completing the voting process. There are no more rounds left.</p>
            
            <div class="flex justify-center">
                <p class="text-center text-gray-600">You have successfully finished all the voting rounds. <a class="text-blue-500" href="{{ route('select.event_in_judges') }}">>>> Back to events</a></p>
            </div>
        </footer>


        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
        <script>
            bodymovin.loadAnimation({
                container: document.getElementById('done_vote_success'),
                path: '{{asset('json/animate/done_vote_success.json')}}'
            })
        </script>
    </body>
    <script src="{{ asset('js/lottie.min.js') }}"></script>
</html>
