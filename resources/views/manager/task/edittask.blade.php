@extends('layouts.dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->

  <section class="content">
    <!-- container-fluid -->
    <form id="regForm" name="regForm" action="{{ route('update_task',['id'=>request()->id]) }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="hidden" value="{{$formType}}" name="formType">
      <input type="hidden" value="edit" id="mode">
      <input type="hidden" id="taskid" value="{{request()->id}}" />
      <div class="container-fluid addtask-section">
        <!-- tab  -->
        <div class="tab wizard-tab">
          <div class="task-title">
            <h3>{{ucfirst($formType)}} Edit @if(isset($formFields['two']))- Step One @endif</h3>
          </div>
          <div class="create-task-form">
            <div class="row align-items-start">
              
                @foreach($formFields['one'] as $fieldGroup => $fieldDetails)
                @foreach($fieldDetails as $fieldGroupKey => $field)
                @if (isset($field['groupDetails']))
              
              <div class="{{ $field['groupDetails']->group_slug}}">
                <h3>{{$field['groupDetails']->group_title}}</h3>
                @endif

                @foreach($field['details'] as $details)
                <div class="form-group {{$details->code}}">
                  <label for="{{ $details->label }}">{{$details->label}}</label>

              @if($details->fieldType=='number')
                <input @if($details->is_requried) required="requried" @endif class="form-control number" type="number" id="task_{{$details->code}}" placeholder="{{$details->placeholder}}" name="formField[{{$details->id}}]" autocomplete="off" value="{{ $taskFieldDetails[$details->code]}}" />
                  @elseif($details->fieldType=='long_text')
                  <textarea @if($details->is_requried) required="requried" @endif class="form-control" placeholder="{{$details->placeholder}}" id="task_{{$details->code}}" name="formField[{{$details->id}}]">{{ $taskFieldDetails[$details->code] }}</textarea>
                  @elseif($details->fieldType=='date')
                  <input @if($details->is_requried) required="requried" @endif type="text" name="formField[{{$details->id}}]" class="form-control datePicker" id="task_{{$details->code}}" data-value="task-{{$details->code}}" placeholder="{{$details->placeholder}}" autocomplete="off" value="{{date('M d, Y',strtotime($taskFieldDetails[$details->code])) }}">
                  @elseif(in_array($details->fieldType,array('dropdown_value','select2')))

                  @if(isset($taskFieldDetails[$details->code]))
                  @php $selectedOption=$taskFieldDetails[$details->code]; @endphp

                  @else
                  @php $selectedOption=''; @endphp
                  @endif
                  @php
                  if(is_array($selectedOption))
                  {
                  $selectedText=implode(',',$selectedOption);
                  }
                  else
                  {
                  $selectedText=$selectedOption;
                  }
                  @endphp

                  <select @if($details->is_requried) required="requried" @endif class="form-control select2" data-selectedID="{{$selectedText}}" id="task_{{$details->code}}" id="task_{{$details->code}}" @if($details->fieldType=='select2') multiple="multiple" name="formField[{{$details->id}}][]" @else name="formField[{{$details->id}}]" @endif >
                    <option value="">{{$details->placeholder}}</option>
                    @foreach($details->option as $option)
                    <option @if(is_array($selectedOption)) @if(in_array($option->optionID,$selectedOption))
                      selected="selected"
                      @endif
                      @else
                      @if($selectedOption==$option->optionID) selected="selected"
                      @endif
                      @endif
                      value="{{ $option->optionID}}">
                      {{$option->dropdown_name}}
                    </option>
                    @endforeach
                  </select>
                  @elseif(in_array($details->fieldType,array('radio_button')))
                  <div class="d-flex">
                    @foreach($details->option as $option)
                    <div class="custom-radio-box ">
                      <div class="custom-control custom-radio d-flex">
                        <label for="{{ $option->fieldcode }}id-formField[{{$details->id}}]">{{$option->dropdown_name}}</label>
                            <input class="custom-control-input ml-auto" id="{{ $option->fieldcode }}id-formField[{{$details->id}}]" type="radio" name="formField[{{$details->id}}]" value="{{ $option->id }}" data-optionText={{$option->fieldcode}}
                            @if($selectedOption==$option->id) selected="selected" 
                                    @endif 
                            >
                      </div>
                    </div>
                    @endforeach
                  </div>
              @else
              <input @if($details->is_requried) required="requried" @endif class="form-control" type="text" id="task_{{$details->code}}" placeholder="{{$details->placeholder}}" name="formField[{{$details->id}}]" autocomplete="off" value="{{ $taskFieldDetails[$details->code]}}" />
                  @endif
                  <span class="invalid-feedback" role="alert">
                    <strong class="task_{{$details->code}}-validation-error" id="task_{{$details->code}}-error-message"></strong>
                  </span>
                  <div class="listDepartment {{$details->code}}-display">
                    <ul class="displaylist"></ul>
                  </div>
                  <div class="{{$details->code}}-input">
                  </div>
                </div>
                  @endforeach

                </div>
                @endforeach
                @endforeach
              </div>
            </div>



          </div>
                         
        <!-- /.tab -->
        @if(isset($formFields['two']))
        <!-- tab  -->
        @if($formType=='task')
        <div class="tab wizard-tab second-page-tab">
          <div class="task-title">
            <h3>{{__('task_creation.Taskcreation_steptwo.Attach Documentation')}}</h3>
          </div>
          <div class="row document-section">
            <div class="col-sm-12 col-md-6">
              <div class="assign-client form-group">
                <select class="form-control document_type-validation-error select2" style="width: 100%;" id="document_type" name="document_type">
                  <option value="" disabled>{{__('task_creation.Taskcreation_steptwo.Choose Doc Type')}}</option>
                  <option value="" selected="selected">All Documents</option>
                  @foreach(regulatoryDocType() as $list)
                  <option value="{{$list->id}}">{{$list->name}}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" role="alert">
                  <strong id="document_type-validation-error-message"></strong>
                </span>
              </div>
            </div>
            <div class="col-sm-12 col-md-6">
              <div class="key-search form-group">
                <input class="form-control" type="text" placeholder="{{__('task_creation.Taskcreation_steptwo.Keyword Search')}}" id="keywords" autocomplete="off" />
                <div class="search-result-body">
                  <div class="search-result-content">
                    <ul class="doc-search-append"></ul>
                    <div class="show-more-suggest" hidden>
                      <button type="button" data-toggle="modal" data-target="#searchsuggest">Show All results</button>
                    </div>
                    <div class="no-data-found" hidden>
                      <p>No data found!!!</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="table-report">
            <div class="table">
              <table class="table_layout" aria-describedby="doucment_list">
                <tr>
                  <th scope="col"></th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                </tr>
                <tbody class="doc-list">

                </tbody>
                <div class="search-count text-right">
                </div>
              </table>
            </div>
          </div>
          <div class="prev-show-doc mt-4 row" id="prev-show-doc">

          </div>
          <div class="selected-docs-id" hidden>

          </div>
          <div class="row document-items">
            <div class="col-sm-12 col-md-7">
              <div class="addi-attach">
                <h3>{{__('task_creation.Taskcreation_steptwo.Attach Documentation')}}</h3>
                <div class="d-flex">
                  <div class="custom-radio-box ">
                    <div class="custom-control custom-radio d-flex">
                      <label>{{__('task_creation.Taskcreation_steptwo.Required')}}</label>
                      <input class="custom-control-input ml-auto" type="radio" name="customRadio1" value="1">
                    </div>
                  </div>
                  <div class="custom-radio-box ">
                    <div class="custom-control custom-radio d-flex">
                      <label>{{__('task_creation.Taskcreation_steptwo.Optional')}}</label>
                      <input class="custom-control-input ml-auto" type="radio" name="customRadio1" value="2">
                    </div>
                  </div>
                  <div class="custom-radio-box ">
                    <div class="custom-control custom-radio d-flex">
                      <label>{{__('task_creation.Taskcreation_steptwo.Not Required')}}</label>
                      <input class="custom-control-input ml-auto" type="radio" name="customRadio1" value="0" checked>
                    </div>
                  </div>
                </div>
                <div class="comment-item" id="comments" hidden>
                  <h3>{{__('task_creation.Taskcreation_steptwo.Add Comments')}}</h3>
                  <textarea class="form-control comments-validation-error" type="text" placeholder="{{__('task_creation.Taskcreation_steptwo.Add comment here')}}" name="comments"></textarea>
                  <span class="invalid-feedback" role="alert">
                    <strong id="comments-validation-error-message"></strong>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="mis-content">
            <h3>{{__('task_creation.Taskcreation_steptwo.MIS')}}</h3>
            <div class="row">
              <div class="col-md-3 pr-0"><button type="button" class="btn btn-primary btn-mis-select mis-field-add" data-field-type="text" data-append-content="new-field">{{__('task_creation.Taskcreation_steptwo.Text')}} <span>+</span></button></div>
              <div class="col-md-3 pr-0"><button type="button" class="btn btn-primary btn-mis-select mis-field-add" data-field-type="number" data-append-content="new-field">{{__('task_creation.Taskcreation_steptwo.Number')}} <span>+</span></button></div>
              <div class="col-md-3 pr-0"><button type="button" class="btn btn-primary btn-mis-select mis-field-add" data-field-type="dropdown" data-append-content="new-field" data-count="0">{{__('task_creation.Taskcreation_steptwo.Dropdown')}} <span>+</span></button></div>
            </div>
            <div class="row mis-field-append-new-field mt-5">
                  @foreach($taskFieldDetails['mis'] as $mis)
                    @php $i = 1; @endphp
                    @if($mis->field_type_id == 1)
                      @include('includes.misFields.mis-field-text',['mis'=>$mis])
                    @endif
                    @if($mis->field_type_id == 2)
                      @include('includes.misFields.mis-field-number',['mis'=>$mis])
                    @endif
                    @if($mis->field_type_id == 3)
                      @include('includes.misFields.mis-field-dropdown',['mis'=>$mis,'list_no'=>$i])
                    @endif
                    @php $i++; @endphp
                  @endforeach
            </div>
          </div>
        </div>
        @else
        <div class="tab wizard-tab second-page-tab">
          <div class="task-title">
            <h3>{{ucfirst($formType)}} Edit @if(isset($formFields['two']))- Step Two @endif</h3>
          </div>
          <div class="create-task-form">
            <div class="row">

              @foreach($formFields['two'] as $fieldGroup => $fieldDetails)
              @foreach($fieldDetails as $fieldGroupKey => $field)
              @if (isset($field['groupDetails']))
              <div class="{{ $field['groupDetails']->group_slug}}">
                <h3>{{$field['groupDetails']->group_title}}</h3>
                @endif
                @foreach($field['details'] as $details)
                <div class="form-group">
                  <label for="{{ $details->label }}">{{$details->label}}</label>
                  @if($details->fieldType=='number')
                <input @if($details->is_requried) required="requried" @endif class="form-control number" type="number" id="task_{{$details->code}}" placeholder="{{$details->placeholder}}" name="formField[{{$details->id}}]" autocomplete="off" value="{{ $taskFieldDetails[$details->code]??'' }}" />
                  @elseif($details->fieldType=='long_text')
              
              <textarea @if($details->is_requried) required="requried" @endif class="form-control" placeholder="{{$details->placeholder}}" id="task_{{$details->code}}" name="formField[{{$details->id}}]">{{ $taskFieldDetails[$details->code]??'' }}</textarea>
                  @elseif($details->fieldType=='date')
                  <input @if($details->is_requried) required="requried" @endif type="text" name="formField[{{$details->id}}]" class="form-control issuedatePicker" id="task_{{$details->code}}" data-value="task-{{$details->code}}" placeholder="{{$details->placeholder}}" autocomplete="off" value="{{ $taskFieldDetails[$details->code]}}">
                  @elseif(in_array($details->fieldType,array('dropdown_value','select2')))
                  @if(isset($taskFieldDetails[$details->code]))
                  @php $selectedOption=$taskFieldDetails[$details->code]; @endphp
                  @else
                  @php $selectedOption=''; @endphp
                  @endif
                  @php
                  if(is_array($selectedOption))
                  {
                  $selectedText=implode(',',$selectedOption);
                  }
                  else
                  {
                  $selectedText=$selectedOption;
                  }
                  @endphp
                  <select @if($details->is_requried) required="requried" @endif class="form-control select2" data-selectedID="{{$selectedText}}" id="task_{{$details->code}}" id="task_{{$details->code}}" @if($details->fieldType=='select2') multiple="multiple" name="formField[{{$details->id}}][]" @else name="formField[{{$details->id}}]" @endif >
                    <option value="">{{$details->placeholder}}</option>
                    @foreach($details->option as $option)
                            <option 
                                  @if(is_array($selectedOption))
                                    @if(in_array($option->optionID,$selectedOption))
                      selected="selected"
                      @endif
                      @else
                      @if($selectedOption==$option->optionID) selected="selected"
                      @endif
                      @endif
                      value="{{ $option->optionID}}">
                      {{$option->dropdown_name}}
                    </option>
                    @endforeach
                  </select>
                  @elseif(in_array($details->fieldType,array('radio_button')))
                  <div class="d-flex">
                    @foreach($details->option as $option)
                    <div class="custom-radio-box ">
                      <div class="custom-control custom-radio d-flex">
                        <label for="{{ $option->fieldcode }}id-formField[{{$details->id}}]">{{$option->dropdown_name}}</label>

                        @if(isset($taskFieldDetails[$details->code]))
                  @php $selectedOption=$taskFieldDetails[$details->code]; @endphp
                  @else
                  @php $selectedOption=''; @endphp
                  @endif

                            <input class="custom-control-input ml-auto {{ $option->code }}" id="{{ $option->fieldcode }}id-formField[{{$details->id}}]" type="radio" name="formField[{{$details->id}}]" value="{{ $option->optionID }}" data-optionText={{$option->fieldcode}} @if($selectedOption==$option->optionID) checked="checked" @endif>
                      </div>
                    </div>
                    @endforeach
                  </div>
              @elseif($details->fieldType=='file')
              <input type="file" class="form-control file_formField"  id="task_{{$details->code}}" name="file_formField">
                  <input type="hidden" class="file_formFieldValue" name="formField[{{$details->id}}]" class="documents">
                  @if(isset($taskFieldDetails[$details->code]))
                <a target="_blank" href="{{ env('AWS_URL').'/'.$taskFieldDetails[$details->code] }}">
                    <img src="{{asset('img/doc-list.svg')}}" alt="doc"/> Issue Attachement
                    </a>
                  @endif
              @else
              <input @if($details->is_requried) required="requried" @endif class="form-control" type="text" id="task_{{$details->code}}" placeholder="{{$details->placeholder}}" name="formField[{{$details->id}}]" autocomplete="off" value="{{ $taskFieldDetails[$details->code]??''}}" />

                  @endif
                  <span class="listDepartment {{$details->code}}-display">
                    <ul class="displaylist"></ul>
                  </span>
                </div>
                @endforeach

              </div>
              @endforeach
              @endforeach
            </div>

          </div>
        </div>
        @endif
        @endif
        <div class="task-creation-footer">
          @if(isset($formFields['two']))
          <!-- Circles which indicates the steps of the form: -->
            <div class="page-slider-dot">
              <span class="step"></span>
              <span class="step"></span>
            </div>
          </div>
          @endif
          <div class="text-right">
            <button type="button" id="prevBtn" onclick="nextPrevSlider(-1)" class="btn next-btn">{{__('task_creation.Taskcreation_steptwo.Previous')}}</button>
            <button type="button" id="nextBtn-stepone" class="btn next-btn">{{__('task_creation.Taskcreation_steptwo.Next')}}</button>
            <button hidden type="button" id="nextBtn" onclick="nextPrevSlider(1)" class="btn next-btn">{{__('task_creation.Taskcreation_steptwo.Next')}}</button>
            <button @if($formType=='task' ) type="button" id="submitBtn" @else type="submit" @endif class="btn next-btn">{{__('task_creation.Taskcreation_steptwo.Submit')}}</button>
            <button type="button" style="display: none;" data-toggle="modal" data-target="#taskDetail"></button>
          </div>
        <!-- /.container-fluid -->
      </div>
      <div class="modal fade" id="taskDetail" tabindex="-1" role="dialog" aria-labelledby="taskDetail" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <h3>{{__('task_creation.Taskdetails_popup.Title')}}</h3>
              <div class="row">
                <div class="col-md-7">
                  <div class="taskDetailView">
                    <p>{{__('task_creation.Taskdetails_popup.Created By')}}: <span>{{ decryptKMSvalues(Auth::user()->name) }}</span> <img src="{{ asset(Auth::user()->avatar) }}" alt="user-img"></p>
                    <p>{{__('task_creation.Taskcreation_stepone.Task Name')}}: <span class="taskName" id="modal_taskname"></span></p>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="taskDetailView">
                    <p>{{__('task_creation.Taskdetails_popup.Assigned to')}}: <span id="assigned_to"></span></p>
                    <ul>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-7">
                  <div class="taskDetailView">
                    <p>{{__('task_creation.Taskdetails_popup.Client Name')}}: <span class="client_name" id="modal_clientname"></span></p>
                    <p>{{__('task_creation.Taskdetails_popup.Fund Group')}}: <span id="modal_fundgroup"></span></p>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="taskDetailView">
                    <p>{{__('task_creation.Taskdetails_popup.Created')}}: <span id="created_date"></span></p>
                    <p>{{__('task_creation.Taskdetails_popup.Deadline')}}: <span id="modal_deadline"></span></p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-7">
                  <div class="taskDetailView">
                    <div class="d-flex">
                      <p>{{__('task_creation.Taskdetails_popup.Attached')}}:</p>
                      <div class="review-doc-section d-flex">

                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="taskDetailView">
                    <p>{{__('task_creation.Taskdetails_popup.Frequency')}}: <span id="modal_frequency"></span></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <div class="row">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('task_creation.Taskdetails_popup.Cancel')}}</button>
                <button type="submit" id="submit-confirm" class="btn btn-primary pdfmodal-save">{{__('task_creation.Taskdetails_popup.Save')}}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
  <!-- modal start -->
  <!-- Button trigger modal -->


  <!-- Document Modal -->
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
                  <p>Please select what pages you would like to attach by highlighting to the right. When you are finished press complete.</p>
                </div>
                <div class="delete-item" id="modal-selected-content-html" style="min-height:200px">
                  <div class="row">
                    <div class="col-md-2 selection-section">
                      Pages :
                    </div>
                    <div class="col-md-10 row selected-page-content" id="selected-page-list">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 selection-section">
                      Text :
                    </div>
                    <div class="col-md-10 row selected-text-content" id="selected-text-list"></div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary document-viewer-close" data-dismiss="modal">Close</button>
                  <button hidden type="button" class="btn btn-primary document-page-select" id="document-page-select">{{__('task_creation.Taskdetails_popup.Complete')}}</button>
                  <button type="button" class="btn btn-primary document-confirm" id="document-confirm">{{__('task_creation.Taskdetails_popup.Complete')}}</button>
                </div>
              </div>
            </div>
            <div class="col-md-6" id="iframe-wrapper">
              <div id='viewer'> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ./Document modal end -->
  <div id="copying" data-status="copying" hidden>
    <input name="selected_text" id="selected-text-content-copying">
    <input name="selected_text_page" id="selected-text-page-copying">
  </div>
  <!-- approved Modal -->
  <button type="button" id="modal-trigger-confirmation-text" data-toggle="modal" data-target="#approvedModal" hidden></button>
  <div class="modal fade" id="approvedModal" tabindex="-1" role="dialog" aria-labelledby="approvedModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h3>{{"This ".$formType." has been edited"}}</h3>
          <img src="{{ asset('img/tickmark.svg') }}" alt="tickmark">
        </div>
      </div>
    </div>
  </div>
  <!-- ./approved modal end -->

  <!-- TaskDetail Modal -->

  <!-- ./TaskDetail modal end -->
  <button type="button" class="btn btn-danger swalDefaultError" hidden>
    Launch Error Toast
  </button>
</div>
<!-- /.content-wrapper -->
<!-- searchsuggest modal -->
<div class="modal fade" id="searchsuggest" tabindex="-1" aria-labelledby="searchsuggestLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close btn-no-border close-btn-custom float-right" data-dismiss="modal" aria-label="Close"><em class="fas fa-times"></em></button>
        <div class="suggest-tables">
          <input class="form-control modal-search-docs" type="text" placeholder="search">
          <div class="tableSection">
            <table class="table" aria-describedby="suggestions">
              <thead>
                <th scope="col">Suggestions</th>
                <th scope="col"></th>
                <th scope="col">File Name</th>
                <th scope="col">Ref.Id</th>
                <th scope="col">Date</th>
              </thead>
              <tbody class="modal-suggest-list">
              </tbody>
            </table>
          </div>
          <div class="suggest-pagination row">
            <div class="suggest-report-count col-md-4">
              Viewing <span class="suggest-start"></span> - <span class="suggest-end"></span> of <span class="suggest-total"></span> entries
            </div>
            <div class="suggest-report-pagination col-md-8 text-right" hidden>
              <button class="btn suggest-page-previous suggest-page-click" type="button" data-page=""><span><em class="fas fa-chevron-left mr-2"></em> Previous</span></button>
              <ul>
              </ul>
              <button class="btn suggest-page-next suggest-page-click" type="button" data-page=""><span>Next <em class="fas fa-chevron-right ml-2"></em></span></button>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
<!--/ searchsuggest modal -->
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
@endsection
