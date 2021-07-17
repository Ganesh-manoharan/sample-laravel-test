@extends('layouts.dashboard')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">
  <!-- Main content -->
  <section class="content">
    <!-- container-fluid -->
    <div class="container-fluid box-section">
        <!-- Admin header -->
        <div class="admin-header-item">
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="admin-filter-title">
                    <div class="dropdown show">
                      <a class="btn btn-secondary" href="#" role="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort By:<span class="sortby_title">All Companies</span>
                      </a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item sortby-key active" data-type="company" data-parameter-name="company_id" data-sortby="id"  data-sort-order="ASC" >All Companies</a>
                        <a class="dropdown-item sortby-key" data-type="company" data-parameter-name="company_id" data-sortby="created_at"  data-sort-order="DESC" >Newly Added</a>
                        <a class="dropdown-item sortby-key" data-type="company" data-parameter-name="company_id" data-sortby="company_name"  data-sort-order="ASC" >A-Z</a>
                        <a class="dropdown-item sortby-key" data-type="company" data-parameter-name="company_id" data-sortby="company_name"  data-sort-order="DESC" >Z-A</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="d-flex align-items-center">
                    <div class="document-search">
                      <input class="form-control search-on-teams search-module" type="text" placeholder="Search" data-search-column="company_search" id="search-on-teams" data-url="" autocomplete="off"/>
                      <span><img src="{{ asset('img/search-icon.svg') }}" class="img-fluid" alt="search"/> </span>
                    </div>
                    <div class="admin-add-btn ml-auto">
                      <button class="btn add--admin-button" type="button" data-toggle="modal" data-target=".company_details">Add New</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- admin body item -->
        <div class="teams-main-content-scroll admin-teble-section">
           @include('includes.company_list')
        </div>
        <div class="pagination-content pr-4 mt-3 pagination-module-append common-pagination">
          @include('includes.pagination')
        </div>
    </div>
    <div class="modal fade deleteclientModal" id="deleteclientModal" tabindex="-1" role="dialog" aria-labelledby="deleteclientModal" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <form method="GET" action="" class="modal-approveall">
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
  </section>
</div>
<form id="adminform" name="adminform" action="{{ route('create_admin') }}"  method="POST" enctype="multipart/form-data">
{{ csrf_field() }}
<!-- modal company detail -->
    <div class="modal fade addadmin company_details" id="addadmin" tabindex="1" role="dialog" aria-labelledby="addadmin" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" >Company Details</h5>
          </div>
          <div class="modal-body">
            <div class="company-section-item">
                <div class="row">
                  <div class="col-lg-4 col-md-6 col-sm-12 mt-4">
                    <div class="form-group campanyName">
                      <input type="text"  name="company_name" id="company_name" class="form-control company_name-validation-error" aria-describedby="company_name" placeholder="Name">
                      <span class="invalid-feedback" role="alert">
                        <strong id="company_name-validation-error-message"></strong>
                      </span>
                    </div>
                    <div class="form-group company-contact">
                      <input type="text" name="contact_number" id="contact_number" class="form-control contact_number-validation-error" aria-describedby="contact_number" placeholder="Contact Number">
                      <span class="invalid-feedback" role="alert">
                        <strong id="contact_number-validation-error-message"></strong>
                      </span>
                    </div>
                    <div class="form-group company_email">
                      <input type="email" name="contact_email" id="contact_email" class="form-control contact_email-validation-error" aria-describedby="contact_email" placeholder="Contact Email">
                      <span class="invalid-feedback" role="alert">
                        <strong id="contact_email-validation-error-message"></strong>
                      </span>
                    </div>
                    <div class="form-group Regulatorystatus">
                      <textarea class="form-control"  rows="3" name="regulatory_status" id="regulatory_status" placeholder="Regulatory status"></textarea>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12 mt-4">
                    <div class="form-group companyAddress">
                      <input type="text" name="address_line_one" id="address_line_one" class="form-control address_line_one-validation-error" aria-describedby="address_line_one" placeholder="Address Line One">
                      <span class="invalid-feedback" role="alert">
                        <strong id="address_line_one-validation-error-message"></strong>
                      </span>
                    </div>
                    <div class="form-group companyAddress">
                      <input type="text" name="address_line_two" id="address_line_two" class="form-control" aria-describedby="address_line_two" placeholder="Address Line Two">
                    </div>
                    <div class="form-group companyAddress">
                      <input type="text" name="address_line_three" id="address_line_three" class="form-control" aria-describedby="address_line_three" placeholder="Address Line Three">
                    </div>
                    <div class="form-group companyAddress">
                      <input type="text" name="address_line_four" id="address_line_four" class="form-control" aria-describedby="address_line_four" placeholder="Address Line Four">
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="uploadcompany_logo">
                      <label>Company Logo</label>
                      <div class="form-group company-modal-upload-file row">
                          <div class="upload-logo col-md-6" id="hideupload">
                              <img type="button" src="{{ asset('/img/upload-image-icon.png') }}" alt="" for="client-icon">
                              <p>Upload Logo</p>
                          </div>
                          <input type="hidden" name="aws_url" id="aws_url" value="{{env('AWS_URL')}}" />
                          <div class="hover-effect">
                            <div class="col-md-6" id="imagePreview" hidden>
                                <img type="button" src="" alt="" class="imagePreview-icon">
                            </div>
                            <div class="image-hover-eit">
                              <div class="edit-button">
                                <a class="btn btn-secondary edit-btn"><img src="{{ asset('/img/edit-img.png') }}" alt=""></a>
                              </div>
                            </div>
                          </div>
                      </div>
                      <input hidden id="company-icon" class="form-control upload_icon-validation-error client-upload-logo-input" type="file" />
                      <input hidden type="text" name="upload_icon" />
                      <span id="companyimage_status" class="companyimage_status"></span>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                <button type="button" id="company_admin" data-value="companydetails" class="btn btn-primary company_admin_btn">Next</button>
                <button hidden type="button" id="companydetailsbtn"  class="btn btn-primary company_admin_btn" data-dismiss="modal" data-toggle="modal" data-target="#companyAdmin">Next</button>
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
                      <input class="form-control user_name-validation-error" type="text" id="user_name" name="user_name" aria-describedby="user_name" placeholder="Name"/>
                       <span class="invalid-feedback" role="alert">
                        <strong id="user_name-validation-error-message"></strong>
                      </span> 
                    </div>
                    <div class="form-group input-email-field">
                      <input class="form-control user_email-validation-error" type="email" name="user_email" id="user_email" aria-describedby="user_email" placeholder="Email"/>
                       <span class="invalid-feedback" role="alert">
                        <strong id="user_email-validation-error-message"></strong>
                      </span> 
                    </div>
                    <div class="admin-button-item text-center">
                      <button type="button"  data-value="companydetails" class="btn add-admin-btn admin_addnewuser">Add</button>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 displayuserprofile account_admin_user-validation-error">
                  </div>
                  <span class="invalid-feedback" role="alert">
                        <strong id="account_admin_user-validation-error-message"></strong>
                      </span> 
                  <div class="users_list"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
                <button type="button" id="company_admin" data-value="companyadmins" class="btn btn-primary">Next</button>
                <button hidden type="button" id="companyadminbtn"  class="btn btn-primary companyadminsbtn" data-dismiss="modal" data-toggle="modal" data-target=".admin_addnewdepartment">Next</button>
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
                <button hidden type="button" id="companydepartmentbtn"  class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target=".completedAdmin">Next</button>
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
@endsection

@push('scripts')
@include('includes.scripts.teamsscripts')
@endpush