<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c530abb7f2.js" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

    <title>{{ config('app.name') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/dashboard.css'])
  </head>
  <body>

    <main class="py-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col text-center">PROFIL WĘŻA</div>
            </div>
            <div class="row">
                <div class="col-lg">
                    @include('webside.profile.web-profile-photo')
                </div>
                <div class="col-lg-6">
                    @include('webside.profile.web-profile-offer')
                    @include('webside.profile.web-profile-details')
                    @include('webside.profile.web-profile-feedings')
                    
                </div>
                <div class="col-lg">
                    @include('webside.profile.web-profile-info')
                    @include('webside.profile.web-profile-weights')
                    @include('webside.profile.web-profile-molts')
                    {{-- @include('webside.profile.web-profile-genotype') --}}
                    @include('webside.profile.web-profile-parents')
                </div>
            </div>
        </div>

    </main>
    @stack('scripts')
</body>
</html>



