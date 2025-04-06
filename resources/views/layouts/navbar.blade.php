@auth


<nav class="navbar navbar-expand-xl navbar-dark bg-dark" aria-label="navbar">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ url('home') }}">{{ config('app.name') }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#offcanvas" aria-controls="offcanvas" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="offcanvas">
        <ul class="navbar-nav me-auto mb-2 mb-xl-0">

          <li class="nav-item">
            <a class="nav-link {{ (request()->segment(1) == 'home') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->segment(1) == 'animals') ? 'active' : '' }}" href="{{route('animals.index')}}" >Weze</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->segment(1) == 'feeds') ? 'active' : '' }}" href="{{route('feeds.index')}}" >Karma</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->segment(1) == 'finances') ? 'active' : '' }}" href="{{route('finances.index')}}" >Finanse</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link {{ (request()->segment(1) == 'litters' || request()->segment(1) == 'forsale' || request()->segment(1) == 'sold') ? 'active' : '' }} dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Hodowla
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('litters.index') }}">Mioty</a></li>
                <li><a class="dropdown-item" href="{{ route('litters-planning') }}">Mioty - planowane</a></li>
                <li><a class="dropdown-item" href="{{ route('forsale') }}">Maluchy</a></li>
                <li><a class="dropdown-item" href="{{ route('sold') }}">Sprzedane</a></li>
                <li><a class="dropdown-item" href="{{ route('deleted') }}">Usunięte</a></li>
                <li><a class="dropdown-item" href="{{ route('winterings') }}">Zimowania</a></li>
            </ul>
        </li>
        
        

          <li class="nav-item dropdown">
            <a class="nav-link {{ (request()->segment(1) == 'availableconnections' || request()->segment(1) == 'possibleoffspring') ? 'active' : '' }} dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Planowanie</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('availableconnections.index') }}">Dostępne łączenia</a></li>
              <li><a class="dropdown-item" href="{{ route('possibleoffspring')}}">Możliwe młode</a></li>
              <li><a class="dropdown-item" href="{{ route('possoffspring')}}">Możliwe młode NOWE</a></li>
              <li><a class="dropdown-item" href="{{ route('not-for-sale.index')}}">Do zatrzymania</a></li>
              {{-- <li><a class="dropdown-item" href="#">Planowane NFS</a></li> --}}
              <li><a class="dropdown-item" href="{{ route('projects.index') }}">Projekty</a></li>
            </ul>
          </li>

          {{-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Lokalizacje</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Regały</a></li>
              <li><a class="dropdown-item" href="#">Inkubator</a></li>
              <li><a class="dropdown-item" href="#">Zimowanie</a></li>
            </ul>
          </li> --}}

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Inne</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('labels') }}">Etykiety</a></li>
              <li><a class="dropdown-item" href="{{ route('massdata') }}">Masowe dane</a></li>
              </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->segment(1) == 'offers') ? 'active' : '' }}" href="{{route('offers.index')}}" >Oferty</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('webpage') }}">Web</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('presentation') }}">Tryb Prezentacji</a>
          </li>
        </ul>
        <div style="float: right;" class="me-3">
             @livewire('core.search-bar')
        </div>
            <ul class="navbar-nav ms-3">
                    @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-gear"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end " aria-labelledby="navbarDropdown" id="offcanvas">
                                    <span class="dropdown-item">Witaj <b>{{ Auth::user()->name }}</b></span>
                                    <a class="dropdown-item" href="{{ route('settings.index')}}" >Ustawienia panelu</a>
                                    <a class="dropdown-item" href="{{ route('settings.web')}}" >Ustawienia strony</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                    @endguest
            </ul>
      </div>
    </div>
  </nav>
  @endauth
