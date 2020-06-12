@extends('layouts.app')

@section('content')
<div id="particles-js"></div>

<div class="container-fluid py-4">
    <div class="row px-4">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 offset-sm-1 offset-md-2 offset-lg-3">
            <div class="card">
                <div class="card-header card-header-custom">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body card-body-custom">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-warning text-dark p-2 mx-0 align-baseline">{{ __('click here to request another') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ParticleJS -->
<script type="text/javascript" src={{ asset('js/particles.js') }}></script>
<script type="text/javascript" src={{ asset('js/particles-app.js') }}></script>
@endsection
