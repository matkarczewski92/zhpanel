<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c530abb7f2.js" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

    <title>{{ config('app.name') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/dashboard.css'])
  </head>
<body style="background-color: black;background-image: url('/public/src/5.jpg');background-attachment: fixed;background-position: center;background-position-y: -100px;">
<div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);padding: 10px;">
    <p><h1 class="text-center">404 <br/> Niestety ta strona nie istnieje</h1></p>
</div>
</body>
</html>
