<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Metro Guide </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mdb.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/modified_app.css') }}">
</head>
<body>
    <div id="app" class="bg-full-color">
        <!--Navbar -->
        <nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #00213a">
          <div class="navbar-brand pl-md-4">Metro Guide</div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto nav-flex-icons">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
              <li class="nav-item avatar dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenu" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-2.jpg" class="w-25 rounded-circle z-depth-0"
                    alt="avatar image">
                </a>
                <div class="dropdown-menu dropdown-menu-lg-right dropdown-info"
                  aria-labelledby="navbarDropdownMenu">
                    <a class="dropdown-item" href="#">{{ Auth::user()->name }}</a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
              </li>
                @endguest
            </ul>
          </div>
        </nav>
        <!--/.Navbar -->

        <main>
            @yield('content')
        </main>
    </div>

    <!-- ParticleJS -->
    <script type="text/javascript" src={{ asset('js/particles.js') }}></script>
    <script type="text/javascript" src={{ asset('js/particles-app.js') }}></script>
</body>
</html>
