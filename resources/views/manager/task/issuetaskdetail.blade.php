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
                                        <h3>{{$taskFieldDetails['issue_name']}}</h3>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="status-button"><button type="button" class="btn ststus-btn {{$task->status['status_background']}}">{{__('task_details.Status')}}: {{$task->status['task_status']}}</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="rightItemDetail">
                                <div class="row align-items-center">
                                    <div class="col-md-5 ml-5">
                                        <div class="dueDate"><img src="{{ asset('img/calendar.svg') }}" alt="calendar-icon" />Logged Date: <span>{{date('m/d/y',strtotime($taskFieldDetails['date_issue_occurance']))}}</span></div>
                                    </div>
                                    <div class="col-md-5">

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
                                <p>{{$taskFieldDetails['issue_description']}}</p>
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
                                    <input type="text" hidden name="completion_status" value="@if(count($task->reviewers) > 0) 2 @else 1 @endif">
                                </div>
                                <div class="w-100 text-right bottomItembtn task-detail-popup" data-type="assigned" type="button" data-toggle="modal" data-target="#UserDetailPopup"><span>{{__('task_details.View All')}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="docItems-section">
                    <div class="row">
                        <div class="col-md-4">
                            <h3>Issue Type</h3>
                            <div class="show-details mt-4" id="show-details">
                            <span class="taskInfo">{{ $taskFieldDetails['issue_type'] }}</span>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <h3>Responsible Party - Internal</h3>
                            <div class="show-details mt-4" id="show-details">
                            
                            </div>

                        </div>
                        <div class="col-md-4">
                            <h3 class="addition-documentation-value" data-condition="{{$task->additional_attachment_requirement}}">{{__('task_details.Additional Documentation')}} - {{ $task->additional_requirement_status }}</h3>
                            <div class="addtional_document">
                               
                                
                                
                                <div class="fileupload_list">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="misItemSection">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="misItemLeft">

                                <div class="mis-inner-item issuedisplay">
                                    <div class="row mis_Qer-item">
                                    <div class="col-md-4">
                            <h3>Date Issue Identified</h3>
                            <div class="show-details mt-4" id="show-details">
                            
                            <span class="taskInfo">{{ $taskFieldDetails['date_issue_identified'] }}</span>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <h3>Date of Issue occurance</h3>
                            <div class="show-details mt-4" id="show-details">
                         
                            <span class="taskInfo">{{ $taskFieldDetails['date_issue_occurance'] }}</span>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <h3>Date of Issue Resolution</h3>
                            <div class="show-details mt-4" id="show-details">
                           
                            <span class="taskInfo">{{ $taskFieldDetails['date_issue_resolution'] }}</span>
                            </div>

                        </div>

                                    </div>
                                    <div class="row mis_Qer-item">
                                    <div class="col-md-4">
                            <h3>Root cause</h3>
                            <div class="show-details mt-4" id="show-details">
                            <span class="taskInfo">{{ $taskFieldDetails['root_cause'] }}</span>

                            </div>

                        </div>
                        <div class="col-md-8">
                            <h3>Further Detail</h3>
                            <div class="show-details mt-4" id="show-details">
                            <span class="taskInfo">{{ $taskFieldDetails['furthr_detail'] }}</span>
                            </div>

                        </div>


                                    </div>

                                    <div class="row mis_Qer-item">
                                    <div class="col-md-4">
                            <h3>Financial Impact</h3>
                            <div class="show-details mt-4" id="show-details">
                            <span class="taskInfo">{{ $taskFieldDetails['financial_impact'] }}</span>

                            </div>

                        </div>
                        <div class="col-md-4">
                        @if(strtolower($taskFieldDetails['financial_impact'])=='yes')
                            <h3>Value</h3>
                            <div class="show-details mt-4" id="show-details">
                            <span class="taskInfo"></span>
                            </div>
                        @endif
                        </div>

                        <div class="col-md-4">
                        @if(strtolower($taskFieldDetails['financial_impact'])=='yes')
                            <h3>Resolution</h3>
                            <div class="show-details mt-4" id="show-details">
                            <span class="taskInfo"></span>
                            </div>
                        @endif
                        </div>


                                    </div>
                                    <div class="row mis_Qer-item">
                                    <div class="col-md-4">
                            <h3>Impact Rating</h3>
                            <div class="show-details mt-4" id="show-details">
                            <span class="taskInfo">{{ $taskFieldDetails['impact_rating'] }}</span>

                            </div>

                        </div>
                        <div class="col-md-4">
                            <h3>Risk Register Impact</h3>
                            <div class="show-details mt-4" id="show-details">
                            <span class="taskInfo"></span>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <h3>Sub Task</h3>
                            <div class="show-details mt-4" id="show-details">
                            <span class="taskInfo"></span>
                            </div>

                        </div>


                                    </div>
                                </div>
                                


                <div class="completionSection">
                    <div class="row justify-content-end">
                        <div class="col-sm-12 col-md-6">
                            <div class="compItems">
                                
                                <div class="endTask">
                                    @if($task->completion_status != (1 || 2))
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
                                <li>{{__('task_details.Task Name')}}: <span>{{$task->task_name}}</span></li>
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
                    <p>{{$task->task_desc}}</p>
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
