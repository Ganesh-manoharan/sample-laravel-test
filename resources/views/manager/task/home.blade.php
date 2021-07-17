@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid box-section">
      <!-- info-box section -->
      @include('includes.labels')
      <!-- /. info-box section -->
      <!-- file export section -->
      @php
      $for_dep['filter'] = request()->filter;
      $for_dep['filter_name'] = request()->filter_name;
      $for_dep['status'] = request()->status;
      $for_dep['type']=base64_encode(strtolower('task'));

      $for_filter['department_filter'] = request()->department_filter;
      $for_filter['department'] = request()->department;
      $for_filter['type']=base64_encode(strtolower('task'));
      @endphp
      <div class="task-panel">
        <div class="card">
          <div class="card-body p-0">
            <div class="row align-items-center">
              <div class="col-sm-12 col-md-12">
                <div class="d-flex justify-content-between">
                  <div class="col-md-3">
                    <div class="d-flex">
                      <div class="Task-item--list">
                        <a href="{{route('task',['type'=>base64_encode(strtolower('task'))])}}" class="btn task-link-btn @if(base64_decode(request()->type) == 'task') underline-active @endif" type="button">Task</a>
                      </div>
                      <div class="issues-items">
                        <a href="{{route('issueList',['type'=>base64_encode(strtolower('issue'))])}}" class="btn task-link-btn {{base64_decode(request()->type)}} @if(base64_decode(request()->type) == 'issue') underline-active @endif" type="button">Issues</a>
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
                        @foreach(taskFilterList() as $item)
                        @php
                        $filter = ['status'=>$item['completion_status'],'filter'=>$item['value'],'filter_name'=>$item['name']];
                        $for_filter = array_merge($for_filter,$filter);
                        @endphp
                        <a class="dropdown-item @if(request()->filter == $item['value']) text-primary @endif" href="{{ route('task',$for_filter) }}">{{$item['name']}}</a>
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
      <div class="table-section task-itemtable task-scroll-item">
        <div class="card teams-main-content-scroll">
          <ul class="taskdep-itemtable teams-child-content-scroll">
            @foreach($data as $list)
            <li>
              <div class="d-flex align-items-center">
                <div class="month-report">
                  <p class="semi-bold">{{ task_field_value_text($list->id,'task_name') }}</p>
                </div>
                <div class="dep-profileimg">
                  @foreach($list->assignees as $item)
                  @if($loop->iteration < '4' ) <img src="{{ asset($item->avatar) }}" alt="icon">
                    @endif
                    @endforeach
                </div>
                <div class="client-details">
                  <p>{{__('home_task.tasklist.Client')}}</p>
                  <span>
                    @foreach ($list->clients as $clientsvalue)
                    {{$clientsvalue->client_name}}
                    @endforeach
                  </span>
                </div>
                <div class="assigenitems">
                  <p>{{__('home_task.tasklist.Assigned To')}}</p>
                  <span>
                    @foreach ($list->departments as $departmentsvalue)
                    {{$departmentsvalue->name}}
                    @endforeach
                  </span>
                </div>
                @if($list->document_status == 0)
                <div class="dead-line">
                  <p>{{__('home_task.tasklist.Deadline')}}</p>
                  <span>
                    {{ date(config('common.blade_page.dateformats'),strtotime(task_field_value_text($list->id,'due_date'))) }}</span>
                </div>
                @endif
                @if($list->document_status == 1)
                <div class="dead-line docstatus">
                  <span>Document Changed</span>
                </div>
                @endif

                <div class="due-item {{$list->uiClass}}">
                  <div class="d-flex align-items-center"><span class="mr-2"></span>
                    <p @if($list->task_challenge_status == 1) style="color:#d55742" @endif> {{__('home_manager.Department.'.$list->status_name)}} </p>
                  </div>
                </div>

              <div class="action-btn">
                <div class="dropdown">
                  <button class="btn btn-action" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{__('home_task.tasklist.Action')}} <em class="fas fa-chevron-down pl-2"></em>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach(menuList('tasks-dashboard-action') as $item)
                    @if($item->title == 'Reopen Task' || $item->title == 'Task Edit')
                    @if($list->completion_status != 0 && $item->title == 'Reopen Task')
                    <a class="dropdown-item" id="reopen-task" type="button" data-href="{{route($item->url,['id'=>$list->id])}}" data-toggle="modal" data-target="#actionTaskModal">{{__('home_task.tasklist.'.$item->title)}}</a>@endif
                    @if($list->completion_status == 0 && $item->title == 'Task Edit')
                    <a class="dropdown-item" href="{{route($item->url,['id'=>$list->id])}}">{{__('home_task.tasklist.'.$item->title)}}</a>@endif
                    @else
                    @if($item->title == 'Delete')
                    <a class="dropdown-item" id="delete-task" type="button" data-href="{{route($item->url,['id'=>$list->id,'delete'=>base64_encode(strtolower('delete'))])}}" data-toggle="modal" data-target="#actionTaskModal">{{__('home_task.tasklist.'.$item->title)}}</a>
                    @else
                    <a class="dropdown-item" href="{{route($item->url,['id'=>$list->id])}}">{{__('home_task.tasklist.'.$item->title)}}</a>@endif
                    @endif
                    @endforeach
                  </div>
                </div>
              </div>
        </div>
        </li>

        @endforeach

        </ul>
        <div class="taskadd-btn">
          <a href="{{ url(route('addtask',['type'=>request()->type])) }}" class="btn addtask-btn">
            <em class="fas fa-plus"></em>
          </a>
        </div>
      </div>

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
<div class="modal fade" id="actionTaskModal" tabindex="-1" role="dialog" aria-labelledby="actionTaskModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h3 class="mb-0">Are you sure?<br>Do you want to <span id="task-action-msg"></span> the task?</h3>
        <div class="form-group" id="reopen-description" hidden>
          <label for=""></label>
          <textarea required="requried" class="form-control default-textarea" placeholder="Reason for reopening the task" id="reopen-reason" cols="5" rows="3"></textarea>
          <span class="invalid-feedback" role="alert">
            <strong class="reopen-reason-validation-error" id="reopen-reason-error-message"></strong>
          </span>
        </div>
        <div class="bottom__btn">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('awaiting_approval.Popupmodal.CANCEL')}}</button>
          <a class="btn btn-primary task-action-btn">{{__('awaiting_approval.Popupmodal.CONFIRM')}}</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
