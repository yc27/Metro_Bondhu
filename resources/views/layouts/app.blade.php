<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Metro Guide </title>

    <!-- JQuery -->
    <script type="text/javascript" src={{ asset('jQuery-3.3.1/jquery-3.3.1.min.js') }}></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Mapbox Script -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.js'></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js'></script>

    <!-- Data Table Script -->
    <script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>

    <!-- Pubnub Script -->
    <script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.27.3.js"></script>

    <!-- Tiny MCE Editor -->
    <script src="https://cdn.tiny.cloud/1/{{ config('services.tiny_mce.key') }}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Masonry Script -->
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Nunito">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:100,600">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:400,700">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600">

    <!-- fontawesome icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Style -->
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css' type='text/css'/>
    <link rel='stylesheet' type="text/css" href='https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.css'/>
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mdb.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <!-- Icon -->
    <link rel="icon" href="{{ asset('/img/favicon.png') }}" type="image/x-icon"/>
</head>
<body>
    <div class="loader"></div>

    <div id="app">
        <!-- Navbar -->
        <nav id="top-navbar" class="navbar navbar-dark navbar-expand-lg fixed-top" style="background-color: #001C57">
            <div class="navbar-brand pl-md-2">
                <img src="{{ asset('img/brand-logo.png') }}" alt="brand-logo" style="height: 32px">
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @isset($user)
                            <img src="{{ asset('img/admins/' . $user->photo) }}" class="rounded-circle z-depth-0 mr-2" alt="avatar image" style="width: 32px">
                            @else
                            <img src="{{ asset('img/admins/default.png') }}" class="rounded-circle z-depth-0 mr-2" alt="avatar image" style="width: 32px">
                            @endisset                            
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="navbarDropdownMenu">
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
        <!-- /Navbar -->

        <main id="main" class="bg-full">
            @yield('content')
        </main>
    </div>

    <script>
        // function to adjust top position of main section
        function adjustMainTop() {
            var navbarHight = document.getElementById("top-navbar").scrollHeight;
            $("#main").css("top", navbarHight);
            $("#Side-Navbar").css("top", navbarHight);

            $("#main").css("min-height", Math.max($(window).height() - navbarHight - 3, 0));
        };
        adjustMainTop();
        $(window).resize(function() {
            adjustMainTop();
        });
    </script>
    <script type="text/javascript" src="{{ asset('js/common.js') }}"></script>
    @yield('script')
</body>
</html>
