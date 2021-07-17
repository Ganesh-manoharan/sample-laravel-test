@extends('layouts.dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->

  <section class="content">
    <!-- container-fluid -->
    <div class="container-fluid addtask-section">
      <!-- tab  -->
      <div class="tab wizard-tab">
        <div class="task-title">
        <h3>Risk Detail</h3>
        </div>
        <div class="create-task-form riskviewDetails">
          <div class="row">
            
              @foreach($formFields['one'] as $fieldGroup => $fieldDetails)
              @foreach($fieldDetails as $fieldGroupKey => $field)
              <div class="{{ $field['groupDetails']->group_slug}}">
              @if (isset($field['groupDetails']))
          
            
              <h3>{{$field['groupDetails']->group_title}}</h3>
              @endif

              @foreach($field['details'] as $details)
              <div class="form-group {{$details->code}}">
                <label for="{{ $details->label }}">{{ucfirst(str_replace("_"," ",$details->code))}}</label>

                @if($details->code=='clients')
                @foreach($task->clients as $item)
                @if($loop->iteration < 4) <span class="mb-1">
                  <img class="inline-image-content" src="{{ env('AWS_URL').'/'.$item->client_logo }}" alt="client-logo" />
                  {{ Str::limit($item->client_name, 10) }}</span>
                  @endif
                  @endforeach
                  @elseif($details->code=='departments')
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
                  @elseif($details->code=='associate_activity')
                    @foreach($task->task_schedule_dependencies as $dependencies)
                      {{task_field_value_text($dependencies->getDependencias->id,'task_name')}}
                    @endforeach
                @elseif(in_array($details->code,array('risk_category','risk_subcategory')))
                <span>{{ task_field_value_text($task->id,$details->code) }}</span>
                  @else
                  <span>{{ isset($taskFieldDetails[$details->code])?$taskFieldDetails[$details->code]:'' }}</span>
                  @endif
              </div>
                  @endforeach
              </div>
              @endforeach
              @endforeach
            </div>
          </div>

        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
  </section>

  @endsection