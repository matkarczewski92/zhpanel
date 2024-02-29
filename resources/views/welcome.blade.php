<!doctype html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=0.7">
        <meta name="description" content="Hodowla węży zbożowych">
        <meta name="keywords" content="węże zbożowe, hodowla węży, scaleless, palmetto, corn snake, hodowla węży zbożowych">
        <meta name="author" content="Mateusz Karczewski">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="_token" content="{{ csrf_token() }}">
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <script src="https://kit.fontawesome.com/c530abb7f2.js" crossorigin="anonymous"></script>
        <script src="//code.jquery.com/jquery-1.12.3.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>



        <title>Hodowla węży zbożowych Maks Snake</title>

        @vite(['resources/sass/app.scss', 'resources/js/app.js',  'resources/css/webpage.css'])
        <style>
            .container {
            position: relative;
            }
        </style>
    </head>
    <body>
        @include('webside.navbar')
        <main>
            <div id="parallax-world-of-ugg">
                @include('webside.top')

                @include('webside.gallery')

                @include('webside.for-sale')

                @include('webside.animal-profile')

                @include('webside.about-us')

                @include('webside.bottom')
            </div>
        </main>
        @stack('scripts')
        @vite(['resources/js/app.js'])

    </body>
</html>












