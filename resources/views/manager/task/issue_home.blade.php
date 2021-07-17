@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid box-section">
      <!-- info-box section -->
     <div class="info-box-item report-header-section">
        <div class="row">
          
              
              <div class="col-md-4">
                <div class="ibox bg-warning">
                  <div class="ibox-content">
                    <p>{{__('stats.CRITICAL_ISSUE')}}</p>
                    <h3><a style="color: #ffffff;" href="{{ route('task.form',['status'=>0,'filter'=>3,'filter_name'=>'In Progress','type'=>base64_encode(strtolower('issue'))]) }}">{{$info['overdue']}}</a></h3>
                  </div>
                 
                </div>
              </div>
             
              <div class="col-md-4">
                <div class="ibox bg-success">
                  <div class="ibox-content">
                    <p>{{__('stats.COMPLETED_ISSUE')}}</p>
                    
                    <h3><a style="color: #ffffff;" href="{{ route('task.form',['status'=>1,'filter'=>4,'filter_name'=>'Resolved','type'=>base64_encode(strtolower('issue'))]) }}">{{$info['completed']}}</a></h3>
                  </div>
                  
                </div>
              </div>
            
          <div class="col-md-4">
            <div class="ibox bg-approval">
              <div class="approval-item">
                <div class="ibox-content">
                  <p>{{__('stats.AWAITING_ISSUE')}}</p>
                  <h3><a style="color: #ffffff;" href="{{ route('task.form',['status'=>2,'filter'=>5,'filter_name'=>'Awaiting Review','type'=>base64_encode(strtolower('issue'))]) }}">{{$info['awaiting_approval']}}</a></h3>
                </div>
               
              </div>
              <div class="approval-item-btn text-right">
                <a href="{{ url(route('awaiting_approval',['type'=>request()->type])) }}"><span class="cricle-dots"><em class="fa fa-play" aria-hidden="true"></em></span></a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- /. info-box section -->
      <!-- file export section -->
      @php
      $for_dep['filter'] = request()->filter;
      $for_dep['filter_name'] = request()->filter_name;
      $for_dep['status'] = request()->status;
      $for_dep['type']=base64_encode(strtolower('issue'));

      $for_filter['department_filter'] = request()->department_filter;
      $for_filter['department'] = request()->department;
      $for_filter['type']=base64_encode(strtolower('issue'));
      @endphp


      <div class="task-panel report-header-section">
        <div class="card">
          <div class="card-body p-0">
            <div class="row align-items-center">
              <div class="col-sm-12 col-md-12">
                <div class="d-flex justify-content-between">
                  <div class="col-md-3">
                    <div class="d-flex">
                      <div class="Task-item--list">
                        <a href="{{route('issueList',['type'=>base64_encode(strtolower('task'))])}}" class="btn task-link-btn" type="button">Task</a>
                      </div>
                      <div class="issues-items">
                        <a href="{{route('issueList',['type'=>base64_encode(strtolower('issue'))])}}" class="btn task-link-btn underline-active" type="button">Issues</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 text-right">
                    <div class="dropdown">
                      <button class="filtertask" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 0 !important;background: #fff !important;">
                        <span>{{__('home_task.navigationbar.Department Name')}} : {{$info['department_name']}}<em class="pl-2 fas fa-chevron-down"></em></span>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item @if(!isset(request()->department_filter)) text-primary @endif" href="{{ route('task',$for_dep) }}">All</a>
                        @foreach(departmentList() as $item)
                        @php
                        $for_dep['department_filter'] = $item->id;
                        $for_dep['department'] = $item->name;
                        @endphp
                        <a class="dropdown-item @if(request()->department_filter == $item->id) text-primary @endif" href="{{ route('task',$for_dep)}}">{{$item['name']}}</a>
                        @endforeach
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 text-right">
                    <div class="dropdown">
                      <button class="filtertask" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 0 !important;background: #fff !important;">
                        <span>{{__('home_task.navigationbar.Filter By')}} : {{$info['filter_name']}}<em class="pl-2 fas fa-chevron-down"></em></span>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item @if(!isset(request()->filter)) text-primary @endif" href="{{ route('task',$for_filter) }}">All</a>
                        @foreach(taskFilterList('issue') as $item)

                        @php
                        $filter = ['status'=>$item['completion_status'],'filter'=>$item['value'],'filter_name'=>$item['name']];
                        $for_filter['type']=base64_encode(strtolower('issue'));
                        $for_filter = array_merge($for_filter,$filter);
                        @endphp
                        <a class="dropdown-item @if(request()->filter == $item['value']) text-primary @endif" href="{{ route('task.form',$for_filter) }}">{{$item['name']}}</a>
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
      <div class="risk-content--section">

        @foreach($data as $item)
        <div class="card {{$item->id}}">
          <div class="card-body">
            <ul class="p-0 m-0">
              <li>
                <div class="risk-table-items">
                  <div class="row align-items-center">
                    <div class="col-lg-2 col-md-2 col-12">
                      <div class="CyberSecurityRisk">
                        <h1>{{ task_field_value_text($item->id,'issue_name') }}</h1>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                      <div class="RiskCategory">
                        <h2>Reponsible Party</h2>
                        <p>{{ task_field_value_text($item->id,'responsible_party') }}</p>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                      <div class="RiskCategory">
                        <h2>Clients</h2>
                        <p> @foreach ($item->clients as $clientsvalue)
                          {{$clientsvalue->client_name}},
                          @endforeach
                        </p>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">  
                    @if($item->completion_status == 1)
                <div class="issue-due-item @if($item->task_challenge_status == 0) circle_success @else circle_danger @endif">
                  <div class="d-flex align-items-center"><span class="mr-2"></span>
                    <p @if($item->task_challenge_status == 1) style="color:#d55742" @endif> @if($item->task_challenge_status == 0) {{__('home_manager.Issues.Completed')}} @else {{__('home_manager.Issues.Completion with Challenge')}} @endif</p>
                  </div>
                </div>
                @else
                @if($item->completion_status == 2)
                <div class="issue-due-item circle_waiting">
                  <div class="d-flex align-items-center"><span class="mr-2"></span>
                    <p> {{__('home_manager.Issues.AWAITING_REVIEW')}}</p>
                  </div>
                </div>
                @else
                    <div class="issue-due-item circle_warning">
                      <div class="d-flex align-items-center"><span class="mr-2"></span>
                        <p> {{__('home_manager.Issues.PROGRESS')}}</p>
                      </div>
              </div>
              @endif
              @endif
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                      <div class="ResidualRisk">
                        <h2>Occured</h2>
                        {{ date(config('common.blade_page.dateformats'),strtotime(task_field_value_text($item->id,'date_issue_occurance'))) }}
                      </div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-12">
                      <div class="d-flex align-items-center">
                        <div class="issue-risk-items issues-impact-items">
                          <div class="IssuesRaised-items">{{ task_field_value_text($item->id,'financial_impact') }}</div>
                          <p>Financial Impact</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-12">
                      <button class="expand-arrow" data-toggle="collapse" data-target='{{ "#demo".$item->id}}'><em class="fas fa-caret-down"></em></button>

                    </div>
                  </div>
                </div>
              </li>
              <div id="{{'demo'.$item->id}}" class="collapse more_view">

          <div class="list-table">
            <table class="table awaitingapproval" aria-describedby="mydesc">
              <thead>
                <th scope="col">Created by</th>
                <th scope="col">Date Identified</th>
                <th scope="col">Issue Type</th>
                <th scope="col">Documents</th>
                <th scope="col">Root Cause</th>
                <th scope="col">Action</th>
              </thead>
              <tbody>
                <td class="issuelogo-list">
                <img src="{{ asset($item->getCreatedUserDetails->avatar) }}" alt="" class="icon-image"/> {{ decryptKMSvalues(Auth::user()->name) }}</td>
                <td>
                {{ date(config('common.blade_page.dateformats'),strtotime(task_field_value_text($item->id,'date_issue_identified'))) }}</td>
                <td>
                  {{task_field_value_text($item->id,'issue_type')}}
                </td>
                <td>
                  <div class="attach-file-documetations">
                    <a target="_blank" href="{{ env('AWS_URL').'/'.task_field_value_text($item->id,'attachments_text') }}">
                    <img src="{{asset('img/doc-list.svg')}}" alt="doc"/>
                    </a>
                    
                  </div>
                </td>
                <td class="taskdetails-comments">
                {{task_field_value_text($item->id,'root_cause')}}
                </td>
                <td>
                <div>
                    <a href="{{route('taskdetail',['id'=>$item->id])}}" type="button" class="btn risk-view-edit-btn">View</a>
                    @can('manager-only',Auth::user())
                    <a href="{{route('taskedit',['id'=>$item->id])}}" type="button" class="btn risk-view-edit-btn">/Edit</a> @endcan()</div>
                    </td>
              </tbody>
            </table>
          </div>
        </div>
            </ul>

            <div class="collapse" id="riskExample">
              <div class="card card-body">
                <div class="row align-items-center h-100">
                  <div class="col-lg-3 col-md-4 col-12">
                    <div class="RiskDescription">
                      <h3>Risk Description</h3>
                      <p>Identify, measure, monitor and manage the valuation risks associated with the valuation process and contracted funds within Hedgeserv</p>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="MitEffectiveness">
                      <p>Mit Effectiveness</p>
                      <h1>Deficient</h1>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="MitEffectiveness">
                      <p>Mit Effectiveness</p>
                      <h1>Deficient</h1>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="InherentRisk">
                      <p>Inherent Risk</p>
                      <h1>Very Low</h1>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="RiskTrend">
                      <p>Risk Trend</p>
                      <h1>Increasing</h1>
                    </div>
                  </div>
                  <div class="col-lg-1">
                    <a href="#" type="button" class="btn risk-view-edit-btn">View/Edit</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        @endforeach
      </div>

      <div class="taskadd-btn">
        <a href="{{ url(route('addtask',['type'=>request()->type])) }}" class="btn addtask-btn">
          <em class="fas fa-plus"></em>
        </a>
      </div>

      <div id="tasks-pagination" class="pagination ml-3">
        @include('includes.pagination')
      </div>
      <!-- /. fraud graph section -->
  </section>
  <!-- /.content -->
  <!-- modal -->
</div>
<!-- /.content-wrapper -->

@endsection
