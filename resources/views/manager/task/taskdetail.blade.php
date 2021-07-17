@extends('layouts.dashboard')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <form id="taskForm" name="taskForm" action="{{ route('completion') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- container-fluid -->
            <input type="hidden" name="taskid" id="taskid" value="{{$task->id}}" />
            <input type="text" hidden id="completion-status-value" value="{{$task->completion_status}}">
            <div class="container-fluid taskdetail-section">
                <div class="detail-headerItem">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="leftItemDetail">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>{{$taskFieldDetails['task_name']}}</h3>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="option-item">
                                            <div class="dropdown">
                                                <button id="openDrop" class="dropdown-select open-drop" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{__('task_details.Open')}}
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" id="open-drop" aria-labelledby="openDrop">
                                                    <li>{{__('task_details.Open')}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="option-item">
                                            <div class="dropdown">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="status-button"><button type="button" class="btn ststus-btn {{$task->status['status_background']}}">{{__('task_details.Status')}}: {{$task->status['task_status']}}</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="rightItemDetail">
                                <div class="row align-items-center">
                                    <div class="col-md-5 ml-5">
                                        <div class="dueDate"><img src="{{ asset('img/calendar.svg') }}" alt="calendar-icon" /> {{__('task_details.Deadline Due')}}: <span>{{date('m/d/y',strtotime($taskFieldDetails['due_date']))}}</span></div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="dueDate"><img src="{{ asset('img/clock.svg') }}" alt="clock-icon" /> {{__('task_details.Frequency')}}: <span>{{task_field_value_text($task->id,'frequency')}}</span></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <span>{{__('task_details.Created By')}}: <img src="{{ asset($task->created_by_avatar) }}" class="p-1" alt="user-img" /> {{decryptKMSvalues($task->created_by_name)}}</span>
                    </div>

                    <div class="card-body">
                        <div class="taskLeftDetail">
                            <div class="taskItemInner">
                                <h4>{{__('task_details.Task Details')}}</h4>
                                <div class="d-flex">
                                    <div class="clientItem">
                                        <h5>{{__('task_details.Client')}}</h5>

                                        <div style="display: grid;">
                                            @foreach($task->clients as $item)
                                            @if($loop->iteration < 4) <span class="mb-1"><img class="inline-image-content" src="{{ env('AWS_URL').'/'.$item->client_logo }}" alt="client-logo" />{{ Str::limit($item->client_name, 10) }}</span>
                                                @endif
                                                @endforeach
                                        </div>
                                    </div>

                                    <div class="fundItem">
                                        <h5>{{__('task_details.Fund Group')}}</h5>
                                        <div style="display: grid;">
                                            @foreach($task->funds as $item)
                                            @if($loop->iteration < 4) <span class="mb-1"> {{ Str::limit($item->fund_group_name, 10) }}</span>
                                                @endif
                                                @endforeach
                                        </div>
                                    </div>
                                    <div class="subItem">
                                        <h5>{{__('task_details.Sub Fund')}}</h5>
                                        <div style="display: grid;">
                                            @foreach($task->subfunds as $item)
                                            @if($loop->iteration < 4) <span class="mb-1"> {{ Str::limit($item->sub_fund_name, 10) }}</span>
                                                @endif
                                                @endforeach
                                        </div>
                                    </div>

                                </div>
                                <p>{{$taskFieldDetails['task_description']}}</p>
                                <div class="w-100 text-right bottomItembtn task-detail-popup" data-type="client" type="button" data-toggle="modal" data-target="#taskDetailPopup"><span>{{__('task_details.See More')}}</span></div>
                            </div>
                        </div>

                        <div class="taskRightDetail">
                            <div class="taskItemInner">
                                <h4>{{__('task_details.Assigned To')}}:</h4>
                                <div class="d-flex">
                                    <div class="depUser">
                                        <h5>{{__('task_details.Department')}}: {{$task->departments['0']->name}}</h5>
                                        <span class="depUser1">
                                            @foreach($task->assignees as $user)
                                            @if($loop->iteration
                                            < 4 ) <img src="{{ asset($user->avatar) }}" alt="assignedUser" />
                                            @endif
                                            @if($loop->iteration == 4)
                                            <span class="addUserBtn">+</span>
                                            @endif
                                            @endforeach
                                        </span>
                                    </div>
                                    <div class="reviewUser">
                                        <h5>{{__('task_details.Review Users')}}</h5>
                                        <span class="depUser1">
                                            @foreach($task->reviewers as $user)
                                            @if($loop->iteration
                                            < 4 ) <img src="{{ asset($user->avatar) }}" alt="assignedUser" />
                                            @endif
                                            @if($loop->iteration == 4)
                                            <span class="addUserBtn">+</span>
                                            @endif
                                            @endforeach
                                        </span>
                                    </div>
                                    <div class="reviewUser">
                                        <h5>Dependencies</h5>
                                        <span class="depUser1">
                                        @foreach($task->task_schedule_dependencies as $dependencies)
                                        <a href="{{route('taskdetail',['id'=>$dependencies->getDependencias->id])}}">
                                            {{task_field_value_text($dependencies->getDependencias->id,'task_name')}}
                                        </a>
                                        @endforeach
                                        </span>
                                    </div>
                                    <input type="text" hidden name="completion_status" value="@if(count($task->reviewers) > 0) 2 @else 1 @endif">
                                </div>
                                <div class="w-100 text-right bottomItembtn task-detail-popup" data-type="assigned" type="button" data-toggle="modal" data-target="#UserDetailPopup"><span>{{__('task_details.View All')}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="docItems-section">
                    <div class="row">
                        <div class="col-md-7">
                            <h3>{{__('task_details.Regulatory Documentation')}}</h3>
                            <div class="prev-show-doc mt-4 row prevalignment" id="prev-show-doc">

                            </div>
                        </div>
                        <div class="col-md-5">
                            <h3 class="addition-documentation-value" data-condition="{{$task->additional_attachment_requirement}}">{{__('task_details.Additional Documentation')}} - {{ $task->additional_requirement_status }}</h3>
                            <div class="addtional_document">
                                @if(!is_null($task->comments))
                                <span><img src="{{ asset($task->created_by_avatar) }}" alt="user-img" />{{ $task->comments }}</span>
                                @endif
                                @if($task->completion_status == 0)
                                <div class="option-item">
                                    <div class="dropdown">
                                        <button id="attachDrop" class="dropdown-select attach_drop" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{__('task_details.Attach a File')}}
                                        </button>
                                        <input type="file" name="file[]" id="attach_file" multiple hidden />
                                    </div>
                                    <span class="invalid-feedback attach-doc-validation text-danger" role="alert">
                                        <strong>Please attach the required document!</strong>
                                    </span>
                                </div>
                                @endif
                                <div class="listDepartment fileupload">
                                    <ul>
                                        @foreach($task->attached_docs as $item)
                                        <li class='attached-file-list-page'><img src="{{env('APP_URL')}}/img/document.svg" alt=""><span class='docfile-attach'>{{$item}}</span><span class='close select2-close'></span></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="fileupload_list">

                                </div>
                                <p class="uploaddocformats docformats">({{__('documents.popup.Supported formats')}}:<br>{{__('documents.popup.task_documents')}})</p>
                                <div id="taskuploaddoc_status" class="taskuploaddoc_status"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="misItemSection">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="misItemLeft">
                                <h3>{{__('task_details.MIS')}}</h3>
                                <div class="mis-inner-item">
                                    <div class="row">
                                @foreach($task->mis as $item)
                                    @if($item->field_type_id == 1)
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <h4 class="mis-title">Text</h4>
                                            <h6 class="sub-title">{{$item->description}}</h6>
                                            <p>{{$item->label_title}}</p>
                                            <textarea class="mis-text-area mis-enter-value" placeholder="Type here" id="mis-field-{{$item->id}}" data-mis-id="{{$item->id}}"  data-mis-type="text" ></textarea>
                                        </div>
                                        @endif
                                        @if($item->field_type_id == 2)
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <h4 class="mis-title">Number</h4>
                                            <h6 class="sub-title">{{$item->description}}</h6>
                                            <p>{{$item->label_title}}</p>
                                            <textarea class="mis-text-area mis-enter-value" placeholder="Enter value here" id="mis-field-{{$item->id}}" data-mis-id="{{$item->id}}" data-mis-type="number"></textarea>
                                        </div>
                                        @endif
                                        @if($item->field_type_id == 3)
                                        <div class="col-lg-6 col-md-6 col-12 mis-dropdown">
                                            <h4 class="mis-title">Dropdown</h4>
                                            <h6 class="sub-title">{{$item->description}}</h6>
                                            <p>{{$item->label_title}}</p>
                                            <div class="row mis-checkbox-item">
                                            @foreach($item->mis_field_contents as $option)
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group custom-radio-box ">
                                                        <div class="d-flex">
                                                            <label>{{$option->options}}</label>
                                                            <input class="custom-control-input ml-auto mis-enter-value" type="radio" name="customRadio1" value="{{$option->id}}" data-mis-id="{{$item->id}}" data-mis-type="dropdown">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach    
                                            </div>
                                        </div>
                                        @endif
                                @endforeach
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="completionSection">
                    <div class="row justify-content-end">
                        <div class="col-sm-12 col-md-6">
                            <div class="compItems">
                                <h3>{{__('task_details.Completion')}}</h3>
                                <div class="mis form-group">
                                    <div class="custom-radio-box ">
                                        <div class="custom-control custom-radio d-flex">
                                            <label>{{__('task_details.Satisfactory')}}</label>
                                            <input class="custom-control-input ml-auto completion" type="radio" name="completion" value="0" @if(!is_null($task->task_challenge_status)) disabled @endif {{ ($task->task_challenge_status=="0")? "checked" : "" }}>
                                        </div>
                                    </div>
                                    <div class="custom-radio-box ">
                                        <div class="custom-control custom-radio d-flex">
                                            <label>{{__('task_details.With Challenge')}}</label>
                                            <input class="custom-control-input ml-auto completion" type="radio" name="completion" value="1" @if(!is_null($task->task_challenge_status)) disabled @endif {{ ($task->task_challenge_status=="1")? "checked" : "" }}>
                                        </div>
                                    </div>
                                </div>
                                <span class="invalid-feedback completion-check-validation" role="alert">
                                    <strong>Please check the completion status</strong>
                                </span>
                                <div class="endTask">
                                    @if($task->completion_status != (1 || 2))
                                    <button type="button" data-href="{{ url(route('issue.task.form',['task_id'=>request()->id,'type'=>base64_encode(strtolower('issue'))])) }}" id="nextBtn-stepone" class="btn next-btn create-issue" data-toggle="modal" data-target="#confirmation_createissueModal">CREATE ISSUE</button>
                                    <button type="button" class="btn completeTask-btn" id="check-mis-validation">{{__('task_details.Complete')}}</button>@endif
                                    <button type="button" hidden id="completeTask" name="completeTask" class="btn completeTask-btn" data-toggle="modal" data-dismiss="modal" data-target="#detailsComplete"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/. container-fluid -->
    </section>
    <!--/. Main content -->
    <!-- Modal complete -->
    <div class="modal fade" id="detailsComplete" tabindex="-1" role="dialog" aria-labelledby="detailsComplete" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body taskCompletedPopup">
                    <h3>{{__('task_details.Confirm Task Completion')}}</h3>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <ul>
                                <li>{{__('task_details.Task Name')}}: <span>{{$taskFieldDetails['task_name']}}</span></li>
                                <li class="d-flex mb-5">
                                    <div>{{__('task_details.Task Information')}}:</div>
                                    <div class="ml-2">
                                        @foreach($task->mis as $item)
                                        <div class="mis-on-popup">
                                            <div class="mis-label mr-1">{{$item->label_title}} </div> : <div class="mis-value" id="mis-value-{{$item->id}}"></div>
                                        </div>
                                        @endforeach
                                    </div>
                                </li>
                                <div class="attach-file-head">{{__('task_details.Attached')}}:
                                    <div class="attach-file-contents" id="fileattached">
                                        <ul></ul>
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <ul>
                                <li style="line-height: 30px;margin-bottom: 15px;">{{__('task_details.Client Name')}}: <span>{{$task->clients['0']->client_name}}</span> <span class="client_and_more">And {{count($task->clients)-1}} more </span></li>
                                <li>{{__('task_details.Completed By')}}: <span><img src="{{ asset(Auth()->user()->avatar) }}" alt="userimg" />{{ decryptKMSvalues(Auth::user()->name) }}</span></li>
                                <li>{{__('task_details.Time of Completion')}}: <span>{{$task->created_at}}</span></li>
                                <li>{{__('task_details.Overall Outcome')}}: <span id="outcome"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="task-complete-cancel" data-dismiss="modal">{{__('task_details.Cancel')}}</button>
                    <button type="Submit" id="completebtn" name="completebtn" class="btn btn-primary">{{__('task_details.Complete')}}</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    <!-- /. modal end -->
    <!-- Modal confirm -->
    <button hidden id="modal-trigger-confirmation-text" data-toggle="modal" data-target="#comfirmepopup"></button>
    <div class="modal fade" id="comfirmepopup" tabindex="-1" role="dialog" aria-labelledby="comfirmepopup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body taskConfirmePopup">
                    <h3>{{__('task_details.Confirmed')}}</h3>
                    <p>@if(count($task->reviewers) > 0) {{__('task_details.Confirmed_Status')}} @else This task has been completed @endif</P>
                </div>
            </div>
        </div>
    </div>
    <!-- /. modal end -->
    <button hidden id="modal-trigger-error-text" data-toggle="modal" data-target="#errorpopup"></button>
    <div class="modal fade" id="errorpopup" tabindex="-1" role="dialog" aria-labelledby="errorpopup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body taskConfirmePopup">
                    <h3>Warning</h3>
                    <p id="error_message"></P>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="taskDetailPopup" tabindex="-1" role="dialog" aria-labelledby="taskDetailPopup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body taskDetailPopup">
                <div class="d-flex">
                    <h3>{{__('task_details.Task Details')}}</h3>
                    <span class="create_author">{{__('task_details.Created By')}}: <img src="{{ asset($task->created_by_avatar) }}" class="p-1" alt="user-img" /> {{decryptKMSvalues($task->created_by_name)}}</span>
                </div>

                <div class="clientFundDetails">
                    <h4>{{__('task_details.Clients and Fund Groups')}}</h4>
                    <div class="d-flex">
                        <div class="task_detail-clientPopup-append client-popup-taskdetail">
                        </div>
                        <div class="task_detail-fundGroup-append client-popup-taskdetail">
                        </div>
                        <div class="task_detail-subFund-append client-popup-taskdetail">
                        </div>
                    </div>
                </div>
                <div class="instructionContent">
                    <h4>{{__('task_details.Instructions')}}</h4>
                    <p>{{$taskFieldDetails['task_description']}}</p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="popupClose text-right">
                    <button type="button" class="btn popupSaveBtn close" data-dismiss="modal">{{__('task_details.Close')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="section-itemleft">
                            <div class="leftmodal-content">
                                <h2>Document Name: <span id="doc-name-modal"></span></h2>
                                <h4>Document Type: <span id="doc-type-modal"></span></h4>
                            </div>
                            <div class="delete-item" id="modal-selected-content-html" style="min-height:200px">
                                <div class="row">
                                    <div class="col-md-2">
                                        Pages :
                                    </div>
                                    <div class="col-md-10 row" id="selected-page-list">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        Text :
                                    </div>
                                    <div class="col-md-10 row" id="selected-text-list"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="view-history-Qer">
                                    <h4 class="history-title">Version History :</h4>
                                    <div class="view-card-sec"></div>
                                </div>    
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary document-viewer-close" data-dismiss="modal">Close</button>
                                <button hidden type="button" class="btn btn-primary document-page-select" id="document-page-select">{{__('task_creation.Taskdetails_popup.Complete')}}</button>
                                <button hidden type="button" class="btn btn-primary document-confirm" id="document-confirm">{{__('task_creation.Taskdetails_popup.Complete')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="iframe-wrapper">
                        <div id='viewer' style='width: 100%; height: 100%;'> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="UserDetailPopup" tabindex="-1" role="dialog" aria-labelledby="userDetailPopup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body userDetailPopup">
                <h3>{{__('task_details.Users')}}</h3>
                <div class="d-flex">
                    <div class="depPopup scroll-outer">
                        <button id="depDrop" type="button">{{__('task_details.Departments')}}</button>
                        <div class="listDepartment">
                            <ul class="task_detail-departments-append">
                            </ul>
                        </div>
                    </div>
                    <div class="assignePopup ">
                        <button id="assigneUserItem" type="button">{{__('task_details.Assigned Users')}}</button>
                        <div class="listDepartment teams-main-content-scroll">
                            <ul class="task_detail-assignees-append teams-child-content-scroll">
                            </ul>
                        </div>
                    </div>
                    <div class="reviewPopup scroll-outer">
                        <button id="reviewUserItem" type="button">{{__('task_details.Review Users')}}</button>
                        <div class="listDepartment">
                            <ul class="task_detail-reviewers-append">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="popupClose text-right">
                    <button type="button" class="btn popupSaveBtn close" data-dismiss="modal"> {{__('task_details.Close')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>

@endsection