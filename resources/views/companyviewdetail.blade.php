@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">
  <!-- Main content -->
  <section class="content">
    <!-- container-fluid -->
    <div class="container-fluid box-section">
        <div class="fund-detail-section">
          <div class="card fund-card">
            <div class="card-body fund-card-body">
              <div class="fund-card-header">
                <h3>Company Detail</h3>
              </div>
              <div class="fund-detail__inner">
                <div class="row">
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Company Name</label>
                      <p>{{isset($data->company_name)?$data->company_name:''}}</p>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Key Contacts</label>
                      <ul class="pl-0">
                      <li class="fund-client__info"></li>
                        <li class="fund-client__email">{{isset($data->contact_email)?$data->contact_email:''}}</li>
                        <li class="fund-client__phone">{{isset($data->contact_number)?$data->contact_number:''}}</li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                    <label>Regulatory Status</label>
                      <div>
                      <p>{{isset($data->regulatory_status)?$data->regulatory_status:''}}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                    <label>Address</label>
                      <div>
                      <p>{{isset($data->address_line_one)?$data->address_line_one:''}}</p>
                      <p>{{isset($data->address_line_two)?$data->address_line_two:''}}</p>
                      <p>{{isset($data->address_line_three)?$data->address_line_three:''}}</p>
                      <p>{{isset($data->address_line_four)?$data->address_line_four:''}}</p>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Departments</label>
                      
                      @foreach($companydepartment as $item)
                     <p>{{$item->name}}</p>
                     @endforeach
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Company Users</label>
                      @foreach($companyusers as $item)
                      <p>{{decryptKMSvalues($item->name)}}</p>
                      @endforeach
                    </div>
                  </div>
                   <div class="col-lg-3 col-md-6 col-sm-12">
                  <div class="logo">
                <img src="@if(isset($data->company_logo)){{ env('AWS_URL').'/'.$data->company_logo }}@else{{ asset('img/user-avatar.png') }} @endif" alt="company_logo" class="funds-imagePreview-icon" />
                </div>
                  </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </section>

</div>
<div class="depart__add-edit">
          <div class="edit_depart-btn mr-3"><button type="button" class="btn depart__editBtn" data-type="company" data-toggle="modal" data-value="{{$data->id}}" data-target=".company_details">{{__('clients.view_details.Edit')}}</button></div>
          <div class="delete_depart-btn"><button type="button" class="btn depart__deleteBtn" data-toggle="modal" data-target="#deleteclientModal">{{__('clients.view_details.Delete')}}</button></div>
        </div>
        <form id="adminform" name="adminform" action="{{ route('create_admin') }}"  method="POST" enctype="multipart/form-data">
{{ csrf_field() }}
<!-- modal company detail -->
    <div class="modal fade addadmin company_details" id="addadmin" tabindex="1" role="dialog" aria-labelledby="addadmin" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" >Edit Company Details</h5>
          </div>
          <input type="hidden" name="editCompanyID" value="{{$data->id}}" />
          <div class="modal-body">
            <div class="company-section-item">
                <div class="row">
                  <div class="col-lg-4 col-md-6 col-sm-12 mt-4">
                    <div class="form-group campanyName">
                      <input type="text" name="company_name" id="company_name" value="{{isset($data->company_name)?$data->company_name:''}}" class="form-control company_name-validation-error" aria-describedby="company_name" placeholder="Name">
                      <span class="invalid-feedback" role="alert">
                        <strong id="company_name-validation-error-message"></strong>
                      </span>
                    </div>
                    <div class="form-group company-contact">
                      <input type="text" name="contact_number" id="contact_number" value="{{isset($data->contact_number)?$data->contact_number:''}}" class="form-control contact_number-validation-error" aria-describedby="contact_number" placeholder="Contact Number">
                      <span class="invalid-feedback" role="alert">
                        <strong id="contact_number-validation-error-message"></strong>
                      </span>
                    </div>
                    <div class="form-group company_email">
                      <input type="email" name="contact_email" id="contact_email" value="{{isset($data->contact_email)?$data->contact_email:''}}" class="form-control contact_email-validation-error" aria-describedby="contact_email" placeholder="Contact Email">
                      <span class="invalid-feedback" role="alert">
                        <strong id="contact_email-validation-error-message"></strong>
                      </span>
                    </div>
                    <div class="form-group Regulatorystatus">
                      <textarea class="form-control"  rows="3" name="regulatory_status" id="regulatory_status" placeholder="Regulatory status">{{isset($data->regulatory_status)?$data->regulatory_status:''}}</textarea>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12 mt-4">
                    <div class="form-group companyAddress">
                      <input type="text" name="address_line_one" id="address_line_one" value="{{isset($data->address_line_one)?$data->address_line_one:''}}" class="form-control address_line_one-validation-error" aria-describedby="address_line_one" placeholder="Address">
                      <span class="invalid-feedback" role="alert">
                        <strong id="address_line_one-validation-error-message"></strong>
                      </span>
                    </div>
                    <div class="form-group companyAddress">
                      <input type="text" name="address_line_two" id="address_line_two" value="{{isset($data->address_line_two)?$data->address_line_two:''}}" class="form-control" aria-describedby="address_line_two" placeholder="Address">
                    </div>
                    <div class="form-group companyAddress">
                      <input type="text" name="address_line_three" id="address_line_three" value="{{isset($data->address_line_three)?$data->address_line_three:''}}" class="form-control" aria-describedby="address_line_three" placeholder="Address">
                    </div>
                    <div class="form-group companyAddress">
                      <input type="text" name="address_line_four" id="address_line_four" value="{{isset($data->address_line_four)?$data->address_line_four:''}}" class="form-control" aria-describedby="address_line_four" placeholder="Address">
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="uploadcompany_logo">
                      <label>Company Logo</label>
                      <div class="form-group funds-modal-upload-file row">
                          <div class="upload-logo col-md-6" id="imagehide">
                              <img type="button" src="{{ asset('/img/upload-image-icon.png') }}" alt="" for="client-icon">
                              <p>Upload Logo</p>
                          </div>
                          <input type="hidden" name="aws_url" id="aws_url" value="{{env('AWS_URL')}}" />
                          <div class="hover-effect">
                            <div class="col-md-6" id="funds_imagePreview">
                            <img type="button" src="{{ isset($data->company_logo)?env('AWS_URL').'/'.$data->company_logo:''}}" alt="" class="imagePreview-icon">
                            </div>
                            <div class="image-hover-eit">
                              <div class="edit-button">
                                <a class="btn btn-secondary edit-btn"><img src="{{ asset('/img/edit-img.png') }}" alt=""></a>
                              </div>
                            </div>
                          </div>
                      </div>
                      <input hidden id="department-icon" class="form-control department_icon-validation-error fund-upload-logo-input" type="file" />
                      <input hidden type="text" name="upload_icon" />
                       <span id="companyimage_status" class="companyimage_status"></span>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                <button type="button" id="company_admin" data-value="companydetails" class="btn btn-primary company_admin_btn">Next</button>
                <button hidden type="button" id="companydetailsbtn" class="btn btn-primary company_admin_btn" data-dismiss="modal" data-toggle="modal" data-target="#companyAdmin">Next</button>
              </div>
            </div>
          </div>
         
        </div>
      </div>
    </div>

    <!-- modal company admin -->
    <div class="modal fade companyAdmin" id="companyAdmin" tabindex="-1" role="dialog" aria-labelledby="companyAdminCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title">Company Admins</h1>
          </div>
          <div class="modal-body">
            <div class="admin-inner-item">
              <h2>At this point you can add one or more Account Admins, they will be the contacts within this new company who will have full access to all features of Nexus.</h2>
              <p>Add Account Admin User</p>
              <div class="admin_inputfeild">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group input-email-field">
                      <input class="form-control" type="text" id="user_name" name="user_name" aria-describedby="user_name" placeholder="Name"/>
                    </div>
                    <div class="form-group input-email-field">
                      <input class="form-control" type="email" name="user_email" id="user_email" aria-describedby="user_email" placeholder="Email"/>
                    </div>
                    <div class="admin-button-item text-center">
                      <button type="button" class="btn add-admin-btn admin_addnewuser">Add</button>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 displayuserprofile account_admin_user-validation-error">
                  @foreach($companyusers as $item)
                  <div class='col-lg-4 col-md-4 col-sm-6'><div class='form-group prev_department select2-close'><div class='d-flex align-items-center'> <p>{{decryptKMSvalues($item->name)}}</p> <button type='button' class='prev-close btn'><input type="hidden" name="account_admin_user" value="{{decryptKMSvalues($item->name)}}" /><em class='fas fa-times'></em></button></div></div></div>
                  @endforeach
                  </div>
                  <span class="invalid-feedback" role="alert">
                        <strong id="account_admin_user-validation-error-message"></strong>
                      </span> 

                  <div class="users_list"></div>
                   <div>
                 
                 
                   </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
                <button type="button" id="company_admin" data-value="companyadmins" class="btn btn-primary">Next</button>
                <button hidden type="button" id="companyadminbtn" class="btn btn-primary companyadminsbtn" data-dismiss="modal" data-toggle="modal" data-target=".admin_addnewdepartment">Next</button>
          </div>
        </div>
      </div>
    </div>
    <!-- modal company admin -->
    <div class="modal fade admin_addnewdepartment" id="department" tabindex="-1" role="dialog" aria-labelledby="departmentCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title">Department</h1>
          </div>
          <div class="modal-body">
            <div class="admin-inner-item">
              <h2>Lets first begin by creating the departments. You can choose from our template departments or by typing your own. The company themselves can further edit this information at a later point.</h2>
              <div class="admin_inputfeild">
                <div class="row">
                  <div class="col-lg-8 col-md-8 col-sm-12 m-auto">
                    <div class="d-flex">
                      <div class="form-group input-email-field">
                        <div class="dropdown show">
                          <input class="form-control" type="text" id="admin_deparments" name="admin_deparments" aria-describedby="admin_deparments" placeholder="Department Name"/>
                        </div>
                      </div>
                      <div class="admin-button-item text-center">
                        <button type="button" class="btn add-admin-btn addnewdepartments">Add</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row newaddeddepartments">
                @foreach($companydepartment as $item)
                <div class='col-lg-4 col-md-4 col-sm-6'><div class='form-group prev_department select2-close'><div class='d-flex align-items-center'> <p>{{$item->name}}</p> <button type='button' class='prev-close btn'><input type='hidden' name='company_departments' value='{{$item->name}}'/><em class='fas fa-times'></em></button></div></div></div>
                @endforeach
                </div>
                <div class="departments_list"></div>
                <input class="form-control company_departments-validation-error" type="text" hidden/>
                  <span class="invalid-feedback" role="alert">
                        <strong id="company_departments-validation-error-message"></strong>
                      </span> 
              </div>
            </div>
          </div>
          <div class="modal-footer">
                <button type="button" id="company_admin" class="btn btn-primary" data-value="companydepartments">Next</button>
                <button hidden type="button" id="companydepartmentbtn" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target=".completedAdmin">Next</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal company admin -->
    <div class="modal fade completedAdmin" id="completedAdmin" tabindex="-1" role="dialog" aria-labelledby="completedAdminCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title">Completed</h1>
          </div>
          <div class="modal-body">
            <div class="admin-inner-item">
              <h2>Ok great, all aspects of the initial account setup has been completed. Click below to confirm this company and activate their account and send registration emails to the admins. </h2>
            </div>
          </div>
          <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Next</button>
          </div>
        </div>
      </div>
    </div>
    </form>

    <div class="modal fade deleteclientModal" id="deleteclientModal" tabindex="-1" role="dialog" aria-labelledby="deleteclientModal" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <form method="GET" action="{{ url(route('clients.deletecompany',['id'=>$data->id])) }}" class="modal-approveall">
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


@endsection