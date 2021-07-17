@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">
  <!-- Main content -->
  <section class="content">
    <!-- container-fluid -->
    <div class="container-fluid box-section">
      @include('manager.client.includes.popupmodal')
      <div class="client_detail">
        <div class="d-flex">
          <div class="client_info">
            <div class="row">
              <div class="col-lg-4 col-md-12">
                <div class="client-logo__item">
                  <img src="@if(isset($data->client_logo)){{ env('AWS_URL').'/'.$data->client_logo }}@else{{ asset('img/user-avatar.png') }} @endif" class="img-fluid" alt="client-logo">
                </div>
              </div>
              <div class="col-lg-4 col-md-12 clientdetails">
                <h3>{{$data->client_name}}</h3>
                <p>{{$data->description}}</p>
                <input type="hidden" id="client_id" value="{{ $data->id }}" />
              </div>


              <div class="col-lg-4 col-md-12 clientkeycontacts">
                <h3>Key Contacts</h3>
                @foreach($data->clientkeycontact as $item)
                <span>{{$item->name}}</span>
                <p> {{$item->email}} <br>
                  {{$item->phone_number}}
                </p>
                @endforeach
              </div>
              <div class="col-12 regular-status">
              <label> {{__('clients.view_details.Regulated Status')}}:</label>
              <p>{{$data->regulated_status?$data->regulated_status:" "}}</p>
            </div>
            </div>
          </div>
          <div class="clienttask__item">
            <div class="row">
              <div class="col-lg-6 col-md-12">
                <h3>{{__('clients.view_details.Tasks')}}</h3>
                <p>{{__('clients.view_details.Previous 12 months')}}</p>
                <div class="task__list">
                  <div class="d-flex">
                    <div class="left__item">
                      <p>{{__('clients.view_details.Total')}}</p>
                    </div>
                    <div class="ml-auto right__item">
                      <p id="total_task"></p>
                    </div>
                  </div>
                  <div class="d-flex">
                    <div class="left__item">
                      <p>{{__('clients.view_details.Satisfactory')}}</p>
                    </div>
                    <div class="ml-auto right__item">
                      <p id="completion_with_satisfactory"></p>
                    </div>
                  </div>
                  <div class="d-flex">
                    <div class="left__item">
                      <p>{{__('clients.view_details.With Challenge')}}</p>
                    </div>
                    <div class="ml-auto right__item">
                      <p id="completion_with_challenge"></p>
                    </div>
                  </div>
                  <div class="d-flex">
                    <div class="left__item">
                      <p>{{__('clients.view_details.Not Completed')}}</p>
                    </div>
                    <div class="ml-auto right__item">
                      <p id="not_completed"></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 text-center">
                <div id="chart-message" class="chart-message" hidden></div>
                <canvas id="myChart1"></canvas>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="client_detail">
      <div class="user__assign">
          <div class="row">
            
            <div class="col-lg-6 col-md-12">
              <div class="left_assign__items">
                <div class="user_type restricform">
                  <label>{{__('clients.view_details.Departments Assigned To')}}:</label>
                  <div class="d-flex view-choose-departments">
                    <div class="team__member clients-department">
                      <select class="form-control select2 all_users" id="departments1">
                        <option value="" selected="selected" disabled>{{__('task_creation.Taskcreation_stepone.Departments')}}</option>
                        <option value="0" data-image="{{ asset('/img/select-all.png') }} ">All Departments</option>
                        @foreach($department_listnot_in_selecteditem as $item)
                        <option value="{{$item->id}} " data-image="{{ env('AWS_URL').'/'.$item->dep_icon}}"> {{$item->name}}</option>
                        @endforeach
                      </select>
                      <div class="listDepartment view-dept">
                        <ul>
                          @foreach($department_list as $item)
                          <li data-value="{{$item->id}}"> {{$item->name}}<span data-values="departmentform_1" data-value="{{$item->id}}" data-text="{{$item->name}}" data-select-type="departments1" data-image="{{env('APP_URL').'/'.$item->dep_icon}}" class="close clients-dept-close remove-child"><em class="fas fa-times"></em></span></li>
                          @endforeach

                        </ul>
                      </div>
                      <div class="department_list">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="right_assign__items">
                <div class="clientName fundsassigneddto">
                  <label>Funds Assigned To:</label>
                  <div class="d-flex view-choose-fundgroups">
                    <div class="team__member">
                      <select class="form-control select2 all_users" id="clients_fund_groups">
                        <option value="" selected="selected" disabled>{{__('task_creation.Taskcreation_stepone.Choose Fund Group')}}</option>
                        <option value="0" data-image="{{ asset('/img/select-all.png') }}">All Funds</option>
                        @foreach($fundgroups_listnot_in_selecteditem as $item)
                            <option value="{{$item->id}}">{{$item->fund_group_name}}</option>
                        @endforeach
                      </select>
                      <div class="listDepartment fund_groups1">
                        @foreach($fundgroups_list as $item)
                        <ul class="displaylist team__member">
                            <li data-value="{{$item->action_id}}" class="Fund-item"> {{$item->fund_group_name}}<span data-values="fund_groups_{{$item->action_id}}" data-value="{{$item->action_id}}" data-text="{{$item->fund_group_name}}" data-select-type="clients_fund_groups" data-image="{{env('AWS_URL').'/'.$item->avatar}}" class="close clients-fundgroups-close  remove-child"><em class="fas fa-times"></em></span></li>
                          @foreach($item['getsubfundslist'] as $list)
                          <li data-value="{{$list->id}}" class="subfund-item"> {{$list->sub_fund_name}}<span data-values="sub_fund_groups_{{$list->id}}" data-value="{{$item->id}}" data-select-type="sub_fund_groups" class="close remove-child"></span></li>
                          @endforeach
                        </ul>
                        @endforeach
                      </div>
                      <div class="fund_groups_list">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        @can('manager-only',Auth::user())
        <div class="depart__add-edit">
          <div class="edit_depart-btn mr-3"><button type="button" class="btn depart__editBtn" data-type="clients" data-toggle="modal" data-value="{{$data->id}}" data-target=".add-department">{{__('clients.view_details.Edit')}}</button></div>
          <div class="delete_depart-btn"><button type="button" class="btn depart__deleteBtn" data-toggle="modal" data-target="#deleteclientModal">{{__('clients.view_details.Delete')}}</button></div>
        </div>
        @endcan
        <div class="modal fade" id="deleteclientModal" tabindex="-1" role="dialog" aria-labelledby="deleteclientModal" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="GET" action="{{ url(route('clients.deletethesingleclientrecord',['id'=>$data->id])) }}" class="modal-approveall">
              {{ csrf_field() }}
              <div class="modal-content">
                <div class="modal-body">
                  <h3>{{__('clients.view_details.Do you want to delete the record')}}?</h3>
                  <div class="bottom__btn">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('awaiting_approval.Popupmodal.CANCEL')}}</button>
                    <button type="submit" id="delete-clients-confmbtn" class="btn btn-primary pdfmodal-save">{{__('awaiting_approval.Popupmodal.CONFIRM')}}</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
  </section>
</div>


@endsection