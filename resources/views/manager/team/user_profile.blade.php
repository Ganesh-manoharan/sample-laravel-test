@extends('layouts.dashboard')

@section('content')

<!-- Content Wrapper. Contains page content -->
<input type="hidden" id="user_profile_id" data-value="{{$data->id}}">
<div class="content-wrapper dashboard">
  <!-- Main content -->
  <section class="content">
    <!-- container-fluid -->
    <div class="container-fluid box-section">
      <div class="user_detail">
        <div class="d-flex m-0">
          <div class="user_detailSection">
            <div class="row align-items-center">
              <div class="col-lg-6 col-md-12">
                <div class="userImg"><img src="{{ env('AWS_URL').'/'.$data->avatar }}" class="img-fluid" alt="userimg" style="width: 138px;height: 138px;" /></div>
              </div>
              <div class="col-lg-6 col-md-12">
                <div class="info_item">
                  <h3>{{decryptKMSvalues($data->name)}}</h3>
                  <p>{{$data->user_roles->name}}</p>
                  <p>{{$data->company_role}}</p>
                  <p>{{$data->location}}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="task__item">
            <div class="row">
              <div class="col-lg-6 col-md-12">
                <h3>{{__('teams.User.Tasks')}}</h3>
                <p>{{__('teams.User.Previous 12 months')}}</p>
                <div class="task__list">
                  <div class="d-flex">
                    <div class="left__item">
                      <p>Total</p>
                    </div>
                    <div class="ml-auto right__item">
                      <p id="total_task"></p>
                    </div>
                  </div>
                  <div class="d-flex">
                    <div class="left__item">
                      <p>{{__('teams.User.Satisfactory')}}</p>
                    </div>
                    <div class="ml-auto right__item">
                      <p id="completion_with_satisfactory"></p>
                    </div>
                  </div>
                  <div class="d-flex">
                    <div class="left__item">
                      <p>{{__('teams.User.With Challenge')}}</p>
                    </div>
                    <div class="ml-auto right__item">
                      <p id="completion_with_challenge"></p>
                    </div>
                  </div>
                  <div class="d-flex">
                    <div class="left__item">
                      <p>{{__('teams.User.Not Completed')}}</p>
                    </div>
                    <div class="ml-auto right__item">
                      <p id="not_completed"></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-12">
                <div class="md4">
                  <canvas id="myChart1" width="300" height="180"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!--div class="issue__item">
            <h3>Issues</h3>
            <p>Previous 12 months</p>
            <div class="issues_sec">
              <div class="d-flex">
                <div class="left__item">
                  <p>Total</p>
                </div>
                <div class="ml-auto right__item">
                  <p>48</p>
                </div>
              </div>
              <div class="d-flex">
                <div class="left__item">
                  <p>Resolved</p>
                </div>
                <div class="ml-auto right__item">
                  <p>36</p>
                </div>
              </div>
            </div>
            <div class="issue__progress">
              <P>Completion Rating</p>
              <div class="d-flex align-items-center">
                <div class="progress">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress__value ml-auto">
                  <p>75%</p>
                </div>
              </div>
            </div>
          </div-->
        </div>
      </div>
      <div class="user_detail">
        <div class="user_fillinfo">
          <form>
            <div class="user_type">
              <label>{{__('teams.User.User Type')}}</label>
              <div class="dropdown review_user">
                <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{isset($data->user_roles->name)?$data->user_roles->name:''}} <em class="nav-icon fas fa-chevron-down"></em></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  @foreach(roletypeList() as $item)
                  <a class="dropdown-item" href="#">{{$item->name}}</a>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="user_type restricform pt-5">
              <label>Associated Departments</label>
              <div class="d-flex">
                <div class="form-group inputField">
                  <select class="form-control select2 departments-validation-error new_item-add_to_user" id="user-profile-departments" data-item-type="departments" name="departments">
                    <option value="" selected="selected" disabled>Department Name</option>
                    @foreach($departments as $list)
                    <option value="{{$list->id}}" data-image="{{ env('AWS_URL').'/'. $list->dep_icon }}"> {{$list->name}}</option>
                    @endforeach
                  </select>
                  <span class="invalid-feedback" role="alert">
                    <strong id="departments-validation-error-message"></strong>
                  </span>
                </div>
              </div>
              <div class="restricuserList user-new-departments-added row">
                @foreach($data->departments as $item)
                <div class="userrestricitem departments-user-{{$item->list_id}}">
                  <div class="d-flex">
                    <div class="left__item">
                      <p>{{$item->name}}</p>
                    </div>
                    <div class="ml-auto right__item">
                      <a href="{{route('teams.delete_department_member',['id'=>$item->list_id])}}" data-method="delete" data-type="departments" data-id="{{$item->id}}" data-text="{{$item->name}}" data-image="{{env('APP_URL').'/'.$item->dep_icon}}" data-delete-id="{{$item->list_id}}" class="delete-from-user-profile"><em class="fas fa-times"></em></a>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <div class="user_type restricform pt-5">
              <label>Associated Clients</label>
              <div class="d-flex">
                <div class="form-group inputField">
                  <select class="form-control select2 company-validation-error new_item-add_to_user" id="user-profile-clients" data-item-type="clients" name="company">
                    <option value="" selected="selected" disabled>{{__('task_creation.Taskcreation_stepone.Choose Clients')}}</option>
                    @foreach($clients as $list)
                    <option value="{{$list->id}}" data-image="{{ env('AWS_URL').'/'.$list->client_logo }}">{{$list->client_name}}</option>
                    @endforeach
                  </select>
                  <span class="invalid-feedback" role="alert">
                    <strong id="company-validation-error-message"></strong>
                  </span>
                </div>
              </div>
              <div class="restricuserList user-new-clients-added row">
                @foreach($data->company as $item)
                <div class="userrestricitem clients-user-{{$item->list_id}}">
                  <div class="d-flex">
                    <div class="left__item">
                      <p>{{$item->client_name}}</p>
                    </div>
                    <div class="ml-auto right__item">
                      <a href="{{ route('teams.delete_client_user',['id'=>$item->list_id]) }}" data-method="delete" data-type="clients" data-id="{{$item->id}}" data-text="{{$item->client_name}}" data-image="{{env('AWS_URL').'/'.$item->client_logo}}" data-delete-id="{{$item->list_id}}" class="delete-from-user-profile"><em class="fas fa-times"></em></a>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </form>
        </div>
        @can('manager-only',Auth::user())
        <div class="depart__add-edit">
          <div class="edit_depart-btn mr-3"><button type="button" class="btn depart__editBtn fund__editBtn" data-toggle="modal" data-value="{{$data->id}}" data-target="#add_new_user">{{__('clients.view_details.Edit')}}</button></div>

          <div class="delete_depart-btn"><button type="button" data-toggle="modal" data-value="{{$data->id}}" data-target="#deleteuserModal" class="btn depart__deleteBtn">{{__('clients.view_details.Delete')}}</button></div>
        </div>
        @endcan
        <div class="modal fade" id="deleteuserModal" tabindex="-1" role="dialog" aria-labelledby="deleteuserModal" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="GET" action="{{ url(route('teams.delete_company_user',['id'=>$data->id]))}}" class="modal-approveall">
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
    </div>
  </section>
</div>

<div class="modal fade add-department add-new-department" id="add_new_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
      </div>
      <form action="{{ route('teams.user_save') }}" method="post" id="add-new-user-form">
        @csrf
      
        <div class="modal-body">
          <div class="user__details">
            <div class="form-row row addnewuser">
              <div class="col-lg-6 col-md-12">
                <div class="form-group inputField">
                <input type="hidden" id="editUserID" name="editUserID" value="{{$data->id}}"/>
                  <input type="hidden" id="CompUserId" name="CompUserId" value="{{$users->id}}"/>
                  <input type="text" class="form-control name-validation-error" placeholder="Name"  name="name" value="{{decryptKMSvalues($data->name)}}" />
                  <span class="invalid-feedback" role="alert">
                        <strong id="name-validation-error-message"></strong>
                   </span>
                </div>
                <div class="form-group inputField">
                  <input type="email" class="form-control email-validation-error" placeholder="Email" name="email" value="{{decryptKMSvalues($data->email)}}" />
                  <span class="invalid-feedback" role="alert">
                              <strong id="email-validation-error-message"></strong>
                        </span>
                </div>
                <div class="form-group inputField">
                  <input type="text" class="form-control company_role-validation-error" placeholder="Company Role" name="company_role" value="{{$data->company_role}}" />
                  <span class="invalid-feedback" role="alert">
                              <strong id="company_role-validation-error-message"></strong>
                        </span>
                </div>
                <div class="form-group inputField">
                  <div class="dropdown">
                    <button class="form-control usertype" type="text" id="user-type-add" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" value="{{ isset($data['user_roles']->role_id)?$data['user_roles']->role_id:'' }}">
                      <span id="user-type">{{isset($data->user_roles->name)?$data->user_roles->name:''}} </span> <em class="fas fa-chevron-down pl-2"></em></button>
                    <div class="dropdown-menu" aria-labelledby="frequency" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -256px, 0px);">
                      @foreach(roletypeList() as $item)
                      <a class="dropdown-item user-type-add" data-value="{{$item->id}}">{{$item->name}}</a>
                      @endforeach
                    </div>
                  </div>
                  <input type="text" name="role_id" class="role_id-validation-error" value="{{ isset($data['user_roles']->role_id)?$data['user_roles']->role_id:'' }}" hidden>
                  <span class="invalid-feedback" role="alert">
                              <strong id="role_id-validation-error-message"></strong>
                        </span>
                </div>
              </div>
              <div class="col-lg-6 col-md-12">
                <div class="form-group inputField">
                  <div class="dropdown">
                    <input type="text" class="form-control dropdown-item" placeholder="Location" value="{{ isset($data->location)?$data->location:'' }}" name="location" />
                  </div>
                </div>
               
                 <div class="form-group inputField">
                  <select class="form-control select2 modal-select2 departments-validation-error" id="modal-departments-users" data-user-type="departments">
                  <option value="" selected="selected" disabled>Departments Restrictions</option>
                  @foreach($departments as $list)
                    <option value="{{$list->id}}" data-image="{{ env('AWS_URL').'/'. $list->dep_icon }}"> {{$list->name}}</option>
                    @endforeach
                  </select>
                  <div class="modal-departments-input" hidden></div>
                  <div class="departmentsDisplay">
                    <div class="memeberaddingList modal-departments-display">
                    @foreach($data['departments'] as $item)
                    <div class="member-item">
                      <div class="d-flex">
                        <div class="member-img">
                          <img src="{{ env('AWS_URL').'/'.$item->dep_icon }}" alt="userimg" style="width:30px"/></div>
                          <div class="member-name common-avoid-text-overflow">{{$item->name}}</div>
                          <em class="fas fa-times memberClosedbtn remove-selected-user" data-option-id="{{$item->id}}" data-type="departments" style="cursor:pointer"></em>
                         
                        </div></div>
                        @endforeach
                    </div>
                  </div>
                  <div class="modal-addnewuser-departments-input"></div>
                </div> 
            
                <div class="form-group inputField">
                  <div class="choose-client form-group">
                    <select class="form-control select2 modal-select2 company-validation-error" id="modal-clients-users" data-user-type="clients" name="company">
                    <option value="" selected="selected" disabled>Clients Restrictions</option>
                    @foreach($clients as $list)
                    <option value="{{$list->id}}" data-image="{{ env('AWS_URL').'/'.$list->client_logo }}">{{$list->client_name}}</option>
                    @endforeach
                    </select>
                    <div class="modal-clients-input" hidden></div>
                  </div>
                  <div class="clientsDisplay">
                    <div class="memeberaddingList modal-clients-display department_clients_input-validation-error">
                    @foreach($data->company as $item)
                    <div class="member-item">
                      <div class="d-flex">
                        <div class="member-img">
                          <img src="{{ env('AWS_URL').'/'.$item->client_logo }}" alt="userimg" style="width:30px"/></div>
                          <div class="member-name common-avoid-text-overflow">{{$item->client_name}}</div>
                          <em class="fas fa-times memberClosedbtn remove-selected-user" data-option-id="{{$item->id}}" data-type="departments" style="cursor:pointer"></em>
                          <input type="hidden" name="department_clients_input" value="{{$item->id}}"/>
                        </div></div>
                        @endforeach
                    </div>
                    <span class="invalid-feedback" role="alert">
                                    <strong id="department_clients_input-validation-error-message"></strong>
                                </span>
                  </div>
                  <div class="modal-addnewuser-clients-input"></div>
                </div>
              </div>
              <div class="uploaduser_logo">
                                <label>User Logo</label>
                                <div class="form-group user-modal-upload-file row">
                                    <div class="upload-logo col-md-6" id="imagehide">
                                        <img type="button" src="{{ asset('/img/upload-image-icon.png') }}" alt="" for="fund-icon">
                                        <p>Upload Logo</p>
                                    </div>
                                    <div class="hover-effect">
                                      <div class="col-md-6" id="user_imagePreview">
                                          <img type="button" src="{{ isset($data->avatar)?env('AWS_URL').'/'.$data->avatar:''}}" alt="" class="imagePreview-icon">
                                      </div>
                                      <div class="image-hover-eit">
                                          <div class="edit-button">
                                            <a class="btn btn-secondary edit-btn"><img src="{{ asset('/img/edit-img.png') }}" alt=""></a>
                                          </div>
                                      </div>
                                    </div>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="department_icon-validation-error-message"></strong>
                                    </span>
                                </div>
                                <input hidden id="department-icon" class="form-control department_icon-validation-error user-upload-logo-input" type="file" />
                                <input hidden type="text" name="upload_icon" />
                                <span id="companyimage_status" class="companyimage_status"></span>
                              </div> 
                              <p class="fileformats">(Supported formats:jpg,jpeg,png,gif,bmp)</p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" data-value="userdetails"  class="btn btn-primary FormsubmitBtn">Confirm</button>
          <button hidden type="submit" class="btn btn-primary" id="add-new-user-confirm">Confirm</button>
        </div>
      </form>
    </div>
  </div>
</div>

<button type="button" hidden data-toggle="modal" data-target="#addUserConfirmationMSG"></button>
  <div class="modal fade" id="addUserConfirmationMSG" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header justify-content-center border-0">
          <img src="{{ asset('/img/logo.png') }}" alt="main-logo" class="img-fluid">
        </div>
        <div class="modal-body border-0">
          <div class="add-user-confirmation-text">
            <p>{{__('teams.dashboard.email_send_message')}}</p>
          </div>
        </div>
        <div class="modal-footer border-0 justify-content-center">
          <button type="button" class="btn btn-primay user-added-confirm-close" data-dismiss="modal"><span>Close</span></button>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
@include('includes.scripts.teamsscripts')
@endpush