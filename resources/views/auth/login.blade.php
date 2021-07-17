@extends('layouts.auth')

@section('content')
<div class="hold-transition login-page nexus-login">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{url('/')}}">
            <img src="{{ asset('img/NEXUS-gov-assurance.png') }}" alt="main-logo" class="img-fluid"/>
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <form action="{{route('login')}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Password" autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="login-btn">
                        <button type="submit" class="btn btn-primary btn-block">NEXT</button>
                    </div>
                    <div class="forgot-pass">
                        <a href="{{ route('password.request') }}" type="button" class="btn forgot-btn">Forgot password?</a>
                    </div>
                </form>
                <!-- <div class="regiter-item">
                    <p>Not registered for your account yet?<a href="{{ route('register') }}"> Click here</a></p>
                </div> -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</div>

<!-- /.login-box -->

@endsection