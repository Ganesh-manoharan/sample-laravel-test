<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('app.name')}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Styles -->
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" alt="{{config('app.name')}}" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">
  @yield('css')
</head>

<body>
  <div class="wrapper">
    @include('includes.header')
    @include('includes.sidebar')
    @if(session('login'))
    @include('includes.splash')
    @endif
    @yield('content')
    <div id="overlay">
      <div class="cv-spinner">
        <span class="spinner"></span>
      </div>
    </div>
  </div>
  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <!-- Bootstrap Date-Picker Plugin -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
  <script src="{{ asset('js/dashboard.js') }}"></script>
  <link rel="stylesheet" type="text/css" href="https://frontbackend.com/storage/resources/jquery-amsify-suggestags/amsify.suggestags.css">
<script type="text/javascript" src="https://frontbackend.com/storage/resources/jquery-amsify-suggestags/jquery.amsify.suggestags.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      Custom.initCommonPageJS();
    });
  </script>

  @include('includes.scripts.taskslider')

  @include('includes.scripts.ajax')

  @include('includes.scripts.taskactions')

  @include('includes.scripts.chart')

  @include('includes.scripts.document_scripts')

  @include('includes.scripts.search-module')

  @if(Route::currentRouteName() == 'taskdetail' || Route::currentRouteName() == 'taskedit')
  @include('includes.scripts.task_details_doc')
  @endif
  @if(Route::currentRouteName() == 'addtask')
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script type="text/javascript">
    $(document).ready(function() {
      Custom.addTaskType();
    });
  </script>
  @endif
  @stack('scripts')
</body>

</html>