@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid box-section">
      <!-- info-box section -->

      <!-- /. info-box section -->
      <!-- file export section -->
      @php
      $req = app('request')->request->all();
      unset($req['page']);
      $for_dep = $req;
      unset($for_dep['department_filter']);
      unset($for_dep['department']);
      $for_filter = [];
      if(isset($req['department_filter'])){
      $for_filter['department_filter'] = $req['department_filter'];
      $for_filter['department'] = $req['department'];
      }
      @endphp
      <div class="risk-content-section">
        <div class="risk-index-temp">
          <div class="card">
            <div class="card-body">
              <div class="risk-index-dropdown">
                <div class="d-flex">
                  <div class="dropdown">
                    <button class="filtertask" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 0 !important;background: #fff !important;">
                      <span>{{__('home_task.navigationbar.Department Name')}} : {{$info['department_name']}}<em class="pl-2 fas fa-chevron-down"></em></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item @if(!isset($req['department_filter'])) text-primary @endif" href="{{ route('task',$for_dep) }}">All</a>
                      @foreach(departmentList() as $item)
                      @php
                      $for_dep['department_filter'] = $item->id;
                      $for_dep['department'] = $item->name;
                      $for_dep['type']=base64_encode(strtolower('risk'));
                      @endphp
                      <a class="dropdown-item @if(isset($req['department_filter'])) @if($req['department_filter'] == $item->id) text-primary @endif @endif" href="{{ route('task',$for_dep)}}">{{$item['name']}}</a>
                      @endforeach
                    </div>
                  </div>

                  <div class="dropdown ml-4">
                    <button class="filtertask" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 0 !important;background: #fff !important;">
                      <span>Period : {{$info['data_period']}}<em class="pl-2 fas fa-chevron-down"></em></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item @if($info['data_period'] == 'Quarterly') text-primary @endif" href="{{ route('task',['type'=> base64_encode(strtolower('risk')),'data_period'=>'Quarterly','dates'=>base64_encode(json_encode([date('Y-m-d',strtotime(date('Y-m-d').'-90 days')),date('Y-m-d')]))]) }}">Quarterly</a>
                      <a class="dropdown-item @if($info['data_period'] == 'Halfly' ) text-primary @endif" href="{{ route('task',['type'=> base64_encode(strtolower('risk')),'data_period'=>'Halfly','dates'=>base64_encode(json_encode([date('Y-m-d',strtotime(date('Y-m-d').'-180 days')),date('Y-m-d')]))]) }}">Halfly</a>
                      <a class="dropdown-item @if($info['data_period'] == 'Yearly' ) text-primary @endif" href="{{ route('task',['type'=> base64_encode(strtolower('risk')),'data_period'=>'Yearly','dates'=>base64_encode(json_encode([date('Y-m-d',strtotime(date('Y-m-d').'-365 days')),date('Y-m-d')]))]) }}">Yearly</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="report-header-section">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="d-flex align-items-center">
                  <div class="report-filter-title">
                    <h1>Sort By: Active Risks</h1>
                  </div>
                  <div class="funds-header-searchBox">
                    <input class="form-control search-on-teams search-module" type="text" placeholder="Search" data-search-column="risk" id="search-on-teams" data-table="risk" autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
              @can('manager-only',Auth::user())
                <div class="d-flex align-items-center">
                  <div class="report-add-btn ml-auto">
                    <a href="{{ url(route('addtask',['type'=>request()->type])) }}" class="btn search fund-addnew-btn">ADD NEW RISK</a>
                  </div>
                </div>
                @endcan
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="risk-content--section search-module-append">
          @include('manager.task.risk_list')
      </div>

      <div id="tasks-pagination" class="pagination ml-3 pagination-module-append">
        @include('includes.pagination')
      </div>
      <!-- /. fraud graph section -->
  </section>
  <!-- /.content -->
  <!-- modal -->
</div>
<!-- /.content-wrapper -->

@endsection
