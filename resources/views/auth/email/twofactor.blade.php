<!-- authenticaion page layout -->
@extends('layouts.mail')

<!-- admin login form -->
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;1,600&display=swap" rel="stylesheet">
<div style="max-width: 600px;margin: 0 auto;background-color: #fafafa;padding: 25px;padding-top: 0;">
	<div style="width: 100%;height: 117px; opacity: 0.96;background-repeat: no-repeat;background-position:center;background-image: url(https://staging.nexusassurance.com/img/image_section.jpg)">
		<img src="https://staging.nexusassurance.com/img/logo.png" alt="logo" style="max-width:100%;height:auto; width: 130px;padding:30px;"/>
	</div>
	<div style="padding: 75px 25px;">
		<h6 style="color: #4a4a4a;font-family: 'Open Sans', sans-serif;font-size: 13px;font-weight: 500; font-style: normal; letter-spacing: -0.26px; line-height: normal;text-align: left;">Hello {{$name}}!</h6>
		<p style="color: #9b9b9b;font-family: 'Open Sans', sans-serif;font-size: 13px; font-weight: 500; font-style: normal; letter-spacing: -0.32px; line-height: normal; text-align: left;">You are in two factor authentication. Use below code to login.</p>
	</div>
	<div style="padding-top:50px;text-align: center;">
     <a style="width: 173px;height: 41px;border-radius: 2px;background-color: #d55742 !important;border: 0;color: #ffffff;font-size: 12px;font-weight: 500;font-style: normal;text-align: center;text-transform: uppercase;display:block;display: block;line-height: 40px;text-decoration: none;margin: 0 auto;">{{$token}}</a>
	</div>
</div>
@endsection