@extends('layouts.auth')

@section('content')
<div class="hold-transition login-page nexus-login">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{url('/')}}">
                <img src="{{ asset('img/NEXUS-gov-assurance.png') }}" alt="main-logo" class="img-fluid" />
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                <form action="{{ route('twofactor') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="2fa" type="text" class="form-control" name="2fa" placeholder="Enter the OTP" required autofocus>
                        @if ($errors->has('2fa'))
                        <span class="help-block">
                            <strong>{{ $errors->first('2fa') }}</strong>
                        </span>
                        @endif

                    </div>
                    <div class="login-btn">
                        <button type="submit" class="btn btn-primary btn-block">SEND</button>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</div>

@endsection
