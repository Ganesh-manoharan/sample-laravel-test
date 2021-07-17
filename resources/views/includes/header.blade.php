 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
     
      <li class="nav-item d-none d-sm-inline-block">
         @if(isset($awaitingapproval_form_backurl))
         <a href="{{ url(route('task.form',['type'=>request()->type])) }}" class="nav-link top-navitem">{{$awaitingapproval_form_backurl ?? ''}}</a>
         @else
        <a href="{{$page_url ?? '#'}}" class="nav-link top-navitem"><em class="{{$back_button ?? ''}}"></em>{{$page ?? ''}}</a>
        @endif

      </li>
      
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto top-notifi-menu">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item language-dropdown">
        
     
        <select id="language" name="language" class="language form-control">
        <option value="en" @if( Cookie::get('locale') == "en"){{"selected"}} @endif>English</option>
        <option value="es" @if( Cookie::get('locale') == "es"){{"selected"}} @endif>Spanish</option>
        </select>
        
        </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
           <img class="short-image" src="{{ asset(Auth::user()->avatar) }}" alt="profile">
          <!-- <span class="badge badge-warning navbar-badge">{{count(userNotifications())}}</span> -->
        </a>
      
        <!-- <div class="dropdown-menu dropdown-menu-lg notification-menu dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{__('header.Notifications')}}</span>
          @foreach(userNotifications() as $notification_list)
          <a href="#" class="dropdown-item active">
            <img src="{{ asset($notification_list['image']) }}" alt="user"><p>{{$notification_list['text']}}</p>
          </a>
          @endforeach
          
        </div> -->
      </li>
     
      <li class="nav-item dropdown">
        <a class="nav-link profile" data-toggle="dropdown" href="#">
        {{ decryptKMSvalues(Auth::user()->name) }} <em class="nav-icon fas fa-chevron-down"></em>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="left: inherit; right: 0px;">
                 <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                         {{ __('Logout') }}
                 </a> 

                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->