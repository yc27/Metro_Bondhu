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
     <link rel="stylesheet" type="text/css" href="{{ asset('css/modified_app.css') }}">

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

                    <h3 class="font-weight-bold text-center mb-4"> Register </h3>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="name">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> 
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="invitation_token">{{ __('Invitation Code') }}</label>
                                <input id="invitation_token" type="text" class="form-control {{ $errors->has('invitation_token') ? 'is-invalid' : '' }}" name="invitation_token" required>

                                @error('invitation_token')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="password">{{ __('Password (minimum 8 character)') }}</label>
                                <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" required autocomplete="new-password">

                                @error('password')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr>
                    <p class="text-center">
                        Already have an account?
                        <br>
                        <a href="{{ route('login') }}">Login Here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>