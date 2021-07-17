<div class="modal fade add-department add-new-department" id="add_new_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('teams.User.Add New User')}}</h5>
      </div>
      <form action="{{ route('teams.user_save') }}" method="post" id="add-new-user-form">
        @csrf
        <input type="hidden" id="editUserID" name="editUserID" value="" />
        <input type="hidden" id="CompUserId" name="CompUserId" value="" />

        <div class="modal-body">
          <div class="user__details">
            <div class="form-row row addnewuser">
              <div class="col-lg-6 col-md-12">
                <div class="form-group inputField">
                  <input type="text" class="form-control name-validation-error" placeholder="{{__('teams.User.Name')}}" name="name" />
                  <span class="invalid-feedback" role="alert">
                              <strong id="name-validation-error-message"></strong>
                        </span>
                </div>
                <div class="form-group inputField">
                  <input type="email" class="form-control email-validation-error" placeholder="{{__('teams.User.Email')}}"  name="email" />
                  <span class="invalid-feedback" role="alert">
                              <strong id="email-validation-error-message"></strong>
                        </span>
                </div>
                <div class="form-group inputField">
                  <input type="text" class="form-control company_role-validation-error" placeholder="{{__('teams.User.Company Role')}}"  name="company_role" />
                  <span class="invalid-feedback" role="alert">
                              <strong id="company_role-validation-error-message"></strong>
                        </span>
                </div>
                <div class="form-group inputField">
                  <div class="dropdown">
                    <button class="form-control usertype" type="text" id="user-type-add" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      <span id="user-type">{{__('teams.User.User Type')}} </span> <em class="fas fa-chevron-down pl-2"></em></button>
                    <div class="dropdown-menu" aria-labelledby="frequency" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -256px, 0px);">
                      @foreach(roletypeList() as $item)
                      <a class="dropdown-item user-type-add" data-value="{{$item->id}}">{{$item->name}}</a>
                      @endforeach
                    </div>
                  </div>
                  <input type="text" name="role_id" class="role_id-validation-error" hidden>
                  <span class="invalid-feedback" role="alert">
                              <strong id="role_id-validation-error-message"></strong>
                        </span>
                </div>
              </div>
              <div class="col-lg-6 col-md-12">
                <div class="form-group inputField">
                  <div class="dropdown">
                    <input type="text" class="form-control dropdown-item" placeholder="{{__('teams.User.Location')}}" value="{{ isset($data->location)?$data->location:'' }}" name="location" />
                  </div>
                </div>
                @if(Route::currentRouteName() == 'teams.allusers')
                <div class="form-group inputField">
                  <div class="modal-departments-input" hidden></div>
                  <div class="departmentsDisplay">
                    <div class="memeberaddingList modal-departments-display">
                    </div>
                  </div>
                  <div class="modal-addnewuser-departments-input"></div>
                </div>
                @else
                <input hidden type="text" name="department_addnewuser_departments[]" value="{{$data['department_detail']->id}}">
                @endif

                <div class="form-group inputField">
                  <div class="choose-client form-group">
                    <select class="form-control select2 modal-select2 company-validation-error" id="modal-clients-users" data-user-type="clients">
                    </select>
                    <div class="modal-clients-input" hidden></div>
                  </div>
                  <div class="clientsDisplay">
                    <div class="memeberaddingList modal-clients-display department_clients_input-validation-error">
                    
                    </div>
                    <span class="invalid-feedback" role="alert">
                                    <strong id="department_clients_input-validation-error-message"></strong>
                                </span>
                  </div>
                  <div class="modal-addnewuser-clients-input"></div>
                </div>
                
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                         <div class="uploadclient_logo">
                                <label>{{__('teams.User.User Logo')}}</label>
                                <div class="form-group user-modal-upload-file row">
                                    <div class="upload-logo col-md-6" id="imagehide">
                                        <img type="button" src="{{ asset('/img/upload-image-icon.png') }}" alt="" for="fund-icon">
                                        <p>{{__('teams.User.Upload Logo')}}</p>
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
                                <input hidden id="department-icon" name="department-icon" class="form-control department_icon-validation-error user-upload-logo-input" type="file" />
                                <input hidden type="text" name="upload_icon" />
                                <span id="companyimage_status" class="companyimage_status"></span>
                              </div> 
                              <p class="fileformats">({{__('teams.User.Supported formats')}}:jpg,jpeg,png,gif)</p>
                  </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('teams.User.Cancel')}}</button>
          <button type="button" data-value="userdetails"  class="btn btn-primary FormsubmitBtn">{{__('teams.User.Confirm')}}</button>
          <button hidden type="submit"  class="btn btn-primary" id="add-new-user-confirm">{{__('teams.User.Confirm')}}</button>
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