@extends('layouts.mail')
@section('content')
<div class="container email_temp">
    <div class="textbody">
    <div class="col-md-8 border border-primary py-4">
        <div class="textalignment logo-bg">
            <img src="{{ env('App_URL').'/img/image_section.jpg' }}" alt="Nexus" class="brand-image img-circle elevation-3" style="opacity: .8"/>
        </div>
        <div class="textalignment">
            <h1>{{Config::get('settings.email_contents.header_title')}}</h1>
        </div>
        <div class="py-2">
            <h2 class="ml-2 font-weight-bolder">{{Config::get('settings.email_contents.text1')}} {{$nameofuser}}{{"..!!!"}}</h2>
        </div>
        <div class="paragraph_tag">
            <p class="ml-2 font-weight-normal">{{Config::get('settings.email_contents.text2')}} {{Config::get('settings.email_contents.text3')}}</p>
        </div>
        <div class="textalignment">
            <a href="{{url('/password/reset').'/'.$token}}" class="btn btn-primary" style="text-decoration: none">{{Config::get('settings.email_contents.email_button_text')}}</a>
        </div>
        <div class="py-4 paragraph_tag">
            <p class="ml-2">{{Config::get('settings.email_contents.footer_regardstext')}}<br>{{Config::get('settings.email_contents.footer_regardstitle')}}</p>
        </div>
        <div class="paragraph_tag">
        <p class="ml-2 text-muted">If you’re having trouble clicking the  button, copy and paste the URL below into your web browser:
                <a href="{{url('/password/reset').'/'.$token}}">{{url('/password/reset').'/'.$token}}</a>
            </p>
        </div>
        <div class="blockquote-footer textalignment text-white">
            <p class="text-center text-muted">{{Config::get('settings.email_contents.footer_link')}} </p></div>
    </div>
    </div>
</div>
@endsection
