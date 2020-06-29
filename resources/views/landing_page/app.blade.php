<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> MU-Guide </title>

    <!-- JQuery -->
    <script type="text/javascript" src={{ asset('jQuery-3.3.1/jquery-3.3.1.min.js') }}></script>

    <!-- Data Table Script -->
    <script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>

    <!-- Tiny MCE Editor -->
    <script src="https://cdn.tiny.cloud/1/{{ config('services.tiny_mce.key') }}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Mapbox Script -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.js'></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js'></script>

    <!-- fontawesome icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:100,600">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:400,700">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto">

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
	<div class=".loader"></div>

    @include('landing_page.navbar')
    @include('landing_page.jumborton')
    @include('landing_page.notices')
    @include('landing_page.routines')
    @include('landing_page.schedules')
    @include('landing_page.routes')
    @include('landing_page.footer')

    <!-- Scroll Top Button -->
    <button class="btn btn-circle btn-deep-purple btn-scroll-top">
        <i class="fas fa-angle-up"></i>
    </button>
    <!-- /Scroll Top Button -->

    <!-- Tost -->
    <div style="position: fixed; top: 0; right: 0; z-index: 1050">
        <div style="position: absolute; top: 10px; right: 10px;">
            <div id="Toasts"></div>
        </div>
    </div>
    <!-- /Tost -->
    
    <script>
        //changing style of top navbar
        $(window).scroll(function() {
            var scrolled = window.scrollY || window.pageYOffset;
            var jumbortonHeight = $(".jumbotron.card").innerHeight();

            var opacity1 = Math.min(0.16, scrolled / jumbortonHeight);
            var opacity2 = Math.min(0.12, scrolled / jumbortonHeight);

            $("nav.navbar").css({'box-shadow':'0 2px 5px 0 rgba(0,0,0,' + opacity1 +'), 0 2px 10px 0 rgba(0,0,0,' + opacity2 +')'});

            if(scrolled >= 30) {
                $("nav.navbar").css({'background':'radial-gradient(circle, rgb(0,118,191) 22%, rgb(0,74,160) 100%)'});
            } else {
                $("nav.navbar").css({'background':'transparent'});
            }

            // Toggle Scroll Top Button
            if(scrolled >= 150) {
                $(".btn-scroll-top").fadeIn("slow");
            } else {
                $(".btn-scroll-top").fadeOut("slow");
            }
        });

        // mapbox initiate
        mapboxgl.accessToken = "{{ config('services.mapbox.token') }}";

        var mapRoutes = new mapboxgl.Map({
            container: 'map-canvas',
            style: 'mapbox://styles/yeamin/ckbxg69ca0fpt1is0u3hwl1yn',
            center: [91.86880624578957, 24.894808641185534],
            zoom: 13
        });

        var navRoutes = new mapboxgl.NavigationControl({
            showCompass: false
        });
        mapRoutes.addControl(navRoutes, 'top-right');
    </script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
</body>
</html>