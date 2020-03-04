@extends('layouts.app')

@section('content')
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
@endsection