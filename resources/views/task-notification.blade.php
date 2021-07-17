@extends('layouts.mail')
@section('content')
<div class="email-template">
	<div class="email-header">
		<img src="{{ asset('img/logo.png') }}" alt="logo" class="img-fluid"/>
	</div>
	<div class="templated-content">
		<h6>Hi,{{$name}}! You have deadline tasks</h6>
		<p>Please try to complete the tasks before the due date</p>
	</div>
    <ul>
    @foreach($tasks as $item)
    <li style="width:100%;display:inline-flex">
        <div>{{$item->task_name}}</div>
        <div>{{$item->due_date}}</div>
    </li>
    @endforeach
    </ul>
	<div class="textalignment">
    <a href="{{env('DOMAIN_URL')}}" class="btn template-btn" style="text-decoration: none">Check</a>
	</div>
</div>
@endsection