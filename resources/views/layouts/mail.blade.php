<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Nexus</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    .col-md-8.border.border-primary.py-4 {
         margin: auto;
    }
    .textalignment{
      text-align: center;
    }
    .textalignment a{
      background-color: #4a4a4a !important;
      border: 1px solid #4a4a4a !important;
      color:#fff;
      border-radius: 5px;
      padding: 10px;
    }
    .textbody {
        width: 800px;
        margin: auto;
        border: 2px solid #4a4a4a !important;
        padding: 10px;
      }    
    .textbody h2 {
      font-weight: 700;
      font-size: 18px;
      color: #333;
    }
    p {
        font-weight: 400 !important;        
        color: #444 !important;
    }
    p span{
        color: #6c757d !important;
    }
    .textalignment p{
        color: #6c757d !important;
    }
    .col-md-8.border.border-primary.py-4 div{
        padding: 5px;
    }
    .textbody h1{
        color:#0b4e83 !important;
        font-size:24px;
    }
    .textbody button{
        background-color:#0b4e83 !important;
        color:#fff !important;
    }
    .logo-bg{
      background-color:#0b4e83;
    }

    /*add new user*/
    body{
	margin:0;
}
.email-header {
    width: 100%;
    height: 117px;
    background:url('{{ asset("img/image_section.jpg") }}');
    opacity: 0.96;
    background-repeat: no-repeat;
    background-position: center;
}
.email-template {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 25px;
    padding-top: 0;
}
.email-header .img-fluid{
	max-width:100%;
	height:auto;	
        width: 130px;
	padding:30px;
}
.btn.template-btn {
    width: 173px;
    height: 41px;
    box-shadow: 0 4px 8px rgb(0 0 0 / 20%);
    border-radius: 2px;
    background-color: #d55742;
    border: 0;
    color: #ffffff;
    font-family: "Avenir Medium";
    font-size: 12px;
    font-weight: 500;
    font-style: normal;
    letter-spacing: normal;
    line-height: normal;
    text-align: center;
    text-transform: uppercase;
	margin:0 auto;
}
.template-footer {
    text-align: center;
    margin-top: 100px;
	padding: 25px;
}
.templated-content h6 {
    color: #4a4a4a;
    font-family: "Montserrat Medium";
    font-size: 13px;
    font-weight: 500;
    font-style: normal;
    letter-spacing: -0.26px;
    line-height: normal;
    text-align: left;
}
.templated-content p {
    color: #9b9b9b;
    font-family: "Montserrat Medium";
    font-size: 13px;
    font-weight: 500;
    font-style: normal;
    letter-spacing: -0.32px;
    line-height: normal;
    text-align: left;
}
.templated-content {
    padding: 75px 25px;
}
  </style>
</head>

<body>

  <main>
    <div class="hold-transition login-page">
      @yield('content')
    </div>
  </main>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <!-- ReCaptcha -->

</body>

</html>