@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid box-section">
    @php 
      $req = app('request')->request->all();
      unset($req['page']);
      $for_dep = $req;
      unset($for_dep['issues_filter']);
      unset($for_dep['issues']);
      $for_filter = [];
      if(isset($req['issues_filter'])){
        $for_filter['issues_filter'] = $req['issues_filter'];
      }
      @endphp
      <div class="task-panel">
        <div class="card">
          <div class="card-body p-0">
            <div class="row align-items-center">
              <div class="col-sm-12 col-md-12">
                <div class="d-flex justify-content-between">
                  <div class="col-md-9 pl-3">
                    <div class="dropdown">
                      <button class="filtertask" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 0 !important;background: #fff !important;">
                        <span>{{__('issues.filter.Issues')}} :{{$info['issues_name']}}<em class="pl-2 fas fa-chevron-down"></em></span>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                       <a class="dropdown-item @if(!isset($req['issues_filter'])) text-primary @endif" href="{{ route('issues_index',$for_dep) }}">All</a>
                        @foreach(issuetypeList() as $item)
                        @php
                        $for_dep['issues_filter'] = $item->id;
                        $for_dep['issues'] = $item->issue_types;
                        @endphp
                        <a class="dropdown-item @if(isset($req['issues_filter'])) @if($req['issues_filter'] == $item->id) text-primary @endif @endif" href="{{ route('issues_index',$for_dep)}}">{{$item['issue_types']}}</a>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 text-right">
                <div class="d-flex align-items-center">
                  <div class="col-md-4">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /. file export section -->
        <!-- fraud graph export section -->
        <div class="table-section task-itemtable awaiting-itemtable">
        <div class="card">
          <ul class="awaiting-approval">

           @foreach($data as $list)
          <li>
              <div class="d-flex align-items-center">
                <div class="issue-month-report">
                  <p class="semi-bold">{{$list->issue_types}}</p>
                </div>
                <div class="departments">
                  <p>{{__('Issues.form.Department')}}</p>
                  <span>{{$list->name}}</span>
                </div>
                <div class="client">
                <p>{{__('Issues.form.Client')}}</p>
                <p>{{$list->client_name}}</p>
                </div>
                <div class="responsible-party">
                <p>{{__('Issues.form.Responsible Party')}}</p>
                <p>IFSC Fund Admin</p>
                </div>
                <div class="occured">
                <p>{{__('Issues.form.Occured')}}</p>
                <p>{{ $list->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="issue-notification">
                <div><img src="{{ asset('img/issue_financialstatus_yes.png') }} " alt=""/></div>
                <div><span>Financial Impact</span></div>
                </div>
          </div>
          </li>
          @endforeach

        </ul>
    </div>
    <div id="tasks-pagination" class="pagination ml-3">
        @include('includes.pagination')
    </div>
    <!-- /. fraud graph section -->
  </section>
  <!-- /.content -->

@endsection
