<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Metro Bondhu </title>

    <!-- style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mdb.min.css') }}">

    <style>
        .bg-full {
            background: url({{ asset('img/MetropolitanUniversitySylhet.jpg') }}) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            min-height: 100%;
            width: 100%;
            height: auto;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>

<body>
    <div class="bg-full">
        <div class="container-sm py-5">
            <div class="d-flex justify-content-start mt-2">
                <div class="col-md-5 col-sm-7 col-xs-9 p-4 text-left white rounded shadow-lg">
                    <div class="mb-4 text-center">
                        <img src="{{ asset('img/mu_logo.png') }}" class="w-75">
                    </div>

                    <h3 class="font-weight-bold text-center mb-4"> Log In </h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                    autofocus>
                                @error('email')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> 
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control" id="password" type="password" name="password" required autocomplete="current-password">
                                @error('password')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                  <input type="checkbox" class="custom-control-input" name="remember" id="remember">
                                  <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md">
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <hr>
                    <p class="text-center">
                        Don't have an account?
                        <br>
                        <a href="{{ route('register') }}">Register Here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>