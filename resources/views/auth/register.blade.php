@extends('layouts.auth')

@section('content')

<div class="hold-transition register-page nexus-regiter">
    <div class="register-box">
        <div class="login-logo">
            <a href="{{url('/')}}">
            <img src="{{ asset('img/NEXUS-gov-assurance.png') }}" alt="main-logo" class="img-fluid"/>
            </a>
        </div>
        <div class="card">
            <div class="card-body register-card-body">
                <form action="{{route('register')}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Full Name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email_hash') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Email" autocomplete="email">

                        @error('email_hash')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Password" autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password" autocomplete="new-password">
                    </div>
                    <div class="register-item">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </form>
                <div class="regiter-item">
                    <p>Already you have an account?<a href="{{route('login')}}"> Click here</a></p>
                </div>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

</div>

@endsection