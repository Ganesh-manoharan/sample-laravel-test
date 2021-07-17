<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-primary sidebar-border">
  <!-- Brand Logo -->
  <a href="#" class="brand-link img-center">
    <img src="{{ asset('img/logo.png') }}" alt="main-logo" class="img-fluid" />
  </a>

  <!-- Sidebar -->
  <div class="sidebar leftside-navigation" id="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              
        <li>
          <a href="#" class="nav-link">
            <p class="menu-header ml-3 mt-3">{{__('menu.MENU')}}</p>
          </a>
        </li>
        @foreach(menuList('sidebar-menu') as $item)
        <li class="nav-item inactive-menu">
          <a href="{{ url(route($item->url,['type'=>base64_encode(strtolower($item->title))])) }}" data-keyword="{{$item->url}}" class="nav-link">
            <span class="nav-icon general-span"><img src="{{ asset($item->icon_general) }}" alt="icon"></span>
            <span class="nav-icon active-span" hidden><img src="{{ asset($item->icon_active) }}" alt="icon"></span>
            <p>{{__('menu.'.$item->title)}}</p>
          </a>
        </li>
        @endforeach
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>