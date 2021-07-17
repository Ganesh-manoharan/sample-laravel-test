@extends('layouts.auth')

@section('content')
<div class="landingpage">
    <div class="header-menu">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light landingnav">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{url('/')}}"><img src="{{ asset('img/NEXUS-gov-assurance.png') }}" alt="" class="img-fluid"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- header navbar links -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link">About</a>
                        </li>
                        <li class="nav-item ">
                            <a href="#" class="nav-link">How We Help</a>
                        </li>
                        <li class="nav-item ">
                            <a href="#" class="nav-link">Client</a>
                        </li>
                        <li class="nav-item ">
                            <a href="#" class="nav-link">News</a>
                        </li>
                        <li class="nav-item ">
                            @guest
                            <a href="{{route('login')}}" class="nav-link">Login</a>
                            @endguest
                            @auth
                            <a href="{{route('home')}}" class="nav-link">Home</a>
                            @endauth
                        </li>
                        <li class="nav-item linkedin-icon">
                            <a href="#" class="nav-link"><em class="fab fa-linkedin-in"></em></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="banner-section">
        <div class="banner-content">
            <h5>Nexus Assurance</h5>
            <p>Providing organisations with efficient and effective governance solutions</p>
            <div class="login-button">
                @guest
                <a href="{{route('login')}}" type="button" class="btn login-btn">Login</a>
                @endguest
                @auth
                <a href="{{route('home')}}" type="button" class="btn login-btn">Home</a>
                @endauth

            </div>
        </div>
    </div>
</div>
@endsection
