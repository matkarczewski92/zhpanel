<nav class="navbar navbar-expand-xl navbar-dark bg-dark" aria-label="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">MAKS SNAKE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#gallery">Galeria</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#plans">Plany hodowlane</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#offer">Oferta</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#profile">Profil węża</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#about-us">O nas</a>
        </li>
        </ul>
        <span class="navbar-text">
        @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
                <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">ZH</a>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">ZH</a>

                {{-- @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                @endif --}}
            @endauth
        </div>
        @endif
        </span>
    </div>
</div>
</nav>
