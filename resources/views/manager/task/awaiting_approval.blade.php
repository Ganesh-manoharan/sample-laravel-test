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
      unset($for_dep['department_filter']);
      unset($for_dep['department']);
      $for_filter = [];
      if(isset($req['department_filter'])){
      $for_filter['department_filter'] = $req['department_filter'];
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
                        <span>{{__('home_task.navigationbar.Department Name')}} :{{$info['department_name']}}<em class="pl-2 fas fa-chevron-down"></em></span>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item @if(!isset($req['department_filter'])) text-primary @endif" href="{{ route('awaiting_approval',$for_dep) }}">All</a>
                        @foreach(departmentList() as $item)
                        @php
                        $for_dep['department_filter'] = $item->id;
                        $for_dep['department'] = $item->name;
                        @endphp
                        <a class="dropdown-item @if(isset($req['department_filter'])) @if($req['department_filter'] == $item->id) text-primary @endif @endif" href="{{ route('awaiting_approval',$for_dep)}}">{{$item['name']}}</a>
                        @endforeach
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 text-right">
                  <button class="btn approvebtn" type="button" data-toggle="modal" data-target="#awaitingapproveModal">Approve All</button></div>
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
            <?php $i = 0; ?>
            @foreach($taskdetails as $list)
            <li>
              <div class="d-flex align-items-center">
                <div class="month-report">
                  <p class="semi-bold">{{ task_field_value_text($list->id,$fieldName) }}</p>
                </div>
                <div class="dep-profileimg">
                  @foreach($list->assignees as $item)
                  @if($loop->iteration < '4' ) <img src="{{ asset($item->avatar) }}" alt="icon">
                    @endif
                    @endforeach
                </div>

                <div class="assigenitems">
                  <p>{{__('home_task.tasklist.Assigned To')}}</p>
                  <span>{{ Str::limit($list->departments['0']->name,20) }}</span>
                </div>
                <div class="dead-line">
                  <p>{{__('home_task.tasklist.Deadline')}}</p>
                  <span>{{ date(config('common.blade_page.dateformats'),strtotime($list->due_date)) }}</span>
                </div>
                <div class="due-item circle_approvetask">
                  <div class="d-flex align-items-center justify-content-center radio_awaitingapproval">
                   
                    <p>{{__('awaiting_approval.Popupmodal.Approve')}} {{ ucfirst($formType) }}</p>
                    <input class="form-check-input awaiting_approval" type="radio" name="flexRadioDefault" id="flexRadioDefault1" data-toggle="modal" data-target="#awaitingApprovalPopup" value="{{$list->id}}" />
                  </div>
                </div>

                <div class="expand-waitinglist">
                  <button class="expand-arrow" data-toggle="collapse" data-target='{{ "#demo".$i}}'><em class="fas fa-caret-down"></em></button>
                </div>
              </div>
            </li>

            <div id="{{'demo'.$i}}" class="collapse more_view">
              <div class="list-table">
                <table class="table awaitingapproval" aria-describedby="mydesc">
                  <thead>
                    <th scope="col">Completed by</th>
                    <th scope="col">Date Completed</th>
                    <th scope="col">MIS</th>
                    <th scope="col">Satisfactory</th>
                    <th scope="col">Documents</th>
                    <th scope="col">Comments</th>
                  </thead>
                  <tbody>
                    <td><img src="{{ asset(Auth()->user()->avatar) }}" alt="" class="icon-image" /> {{ decryptKMSvalues(Auth::user()->name) }}</td>
                    <td>{{ date(config('common.blade_page.dateformats'),strtotime($list->due_date)) }}</td>
                    <td>

                      @foreach($list->mis_fields as $item)
                      <div class="attach-file-documetations">{{ $item->label_title }}
                        <div>
                          @endforeach
                    </td>

                    @if($list->task_challenge_status==0)
                    <td class="stale_price task-challenge-status"><img src="{{asset('img/tick.svg')}}" alt="tick" /></td>
                    @else
                    <td class="stale_price task-challenge-status"><img src="{{asset('img/cancel.png')}}" alt="tick" /></td>
                    @endif

                    <td>
                      @foreach($list->attachdocumentation as $item)
                      <div class="attach-file-documetations"><img src="{{asset('img/doc-list.svg')}}" alt="doc" />{{ str_replace("uploads/","",$item->file_path) }}</div>
                      @endforeach
                    </td>
                    <td class="taskdetails-comments">{{$list->comments}}</td>
                  </tbody>
                </table>
              </div>
            </div>
            <?php $i++; ?>
            @endforeach
          </ul>
          <div id="tasks-pagination" class="pagination">
            <div class="d-flex justify-content-start mt-5 default-pagination">
              {{ $taskdetails->appends(request()->query())->links() }}
              <div class="ml-3 mt-2">Viewing @if(count($taskdetails) > 0) {{ $taskdetails->firstItem() }} - {{ $taskdetails->lastItem() }} of @endif {{ $taskdetails->total() }} entries</div>
            </div>
          </div>
        </div>

      </div>
      <!-- /. fraud graph section -->
  </section>
  <!-- /.content -->


  <!-- Modal task Detail -->
  <form method="POST" action="{{ route('approvetask') }}">
    {{ csrf_field() }}
      
    <div class="modal fade " id="awaitingApprovalPopup" tabindex="-1" role="dialog" aria-labelledby="awaitingApprovalPopup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body awaiting-model-append">
            
          </div>
          <div class="modal-footer">
            <div class="row">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('awaiting_approval.Popupmodal.CANCEL')}}</button>
              <button type="submit" id="awaiting-approval-confmbtn" class="btn btn-primary pdfmodal-save" data-toggle="modal" data-target="#approvedModal">{{__('awaiting_approval.Popupmodal.CONFIRM')}}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- approved Modal -->
  <button type="button" id="modal-trigger-confirmation-text" data-toggle="modal" data-target="#approvedModal" hidden></button>
  <div class="modal fade" id="approvedModal" tabindex="-1" role="dialog" aria-labelledby="approvedModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h3>{{__('task_creation.Taskdetails_popup.This task has been approved')}}</h3>
          <img src="{{ asset('img/tickmark.svg') }}" alt="tickmark">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Awaiting Approval Confirmation -->
<button type="button" id="modal-trigger-confirmation-text" data-toggle="modal" data-target="#awaitingapproveModal" hidden></button>
<div class="modal fade" id="awaitingapproveModal" tabindex="-1" role="dialog" aria-labelledby="awaitingapproveModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <form method="post" action="{{ route('approveall') }}" class="modal-approveall">
      {{ csrf_field() }}
      <input type="hidden" id="departmentfilter" name="departmentfilter" value="{{ isset($req['department_filter'])?$req['department_filter']:'' }}" />
      <input type="text" hidden name="all_ids" value="{{$info['approveAllID']}}">
      <div class="modal-content">
        <div class="modal-body">
          <h3>{{__('awaiting_approval.Popupmodal.APPROVE_CONFIRMATION')}} {{ $formType }}?</h3>
          <div class="bottom__btn">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('awaiting_approval.Popupmodal.CANCEL')}}</button>
            <button type="submit"  id="awaiting-approval-confmbtn" class="btn btn-primary pdfmodal-save">{{__('awaiting_approval.Popupmodal.CONFIRM')}}</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
</div>


<!-- /.content-wrapper -->

@endsection
