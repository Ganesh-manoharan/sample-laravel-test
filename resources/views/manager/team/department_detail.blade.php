@extends('layouts.dashboard')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">
  <!-- Main content -->
  <section class="content">
    <!-- container-fluid -->
    <div class="container-fluid box-section">
      <div class="department_detail">
        <div class="d-flex m-0">
          <input type="text" id="chart-department-id" data-id="{{$data['department_detail']->id}}" hidden>
          <div class="invest_managementItem">
            <h3 id="department-name">{{$data['department_detail']->name}}</h3>
            <p>{{$data['department_detail']->description}}</p>
            <div class="footer-into-div">
             <h4>{{__('teams.User.Department Admin')}}:</h4>
              <ul>
                <li>
                  <img src="@if($data['department_detail']->dep_manager!=''){{ env('AWS_URL').'/'.$data['department_detail']->dep_manager->avatar }}@else{{ asset('img/user-avatar.png') }} @endif" class="usericon" alt="userimg" /> <span>@if($data['department_detail']->dep_manager!=''){{decryptKMSvalues($data['department_detail']->dep_manager->name)}}@endif</span>
                </li>
              </ul>
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
          <div class="issue__item">
           <h3>{{__('teams.User.Issues')}}</h3>
            <p>{{__('teams.User.Previous 12 months')}}</p>
            <div class="issues_sec">
              <div class="d-flex">
                <div class="left__item">
                  <p>Total</p>
                </div>
                <div class="ml-auto right__item">
                  <p>{{$data['issues']['total']}}</p>
                </div>
              </div>
              <div class="d-flex">
                <div class="left__item">
                  <p>{{__('teams.User.Resolved')}}</p>
                </div>
                <div class="ml-auto right__item">
                  <p>{{$data['issues']['resolved']}}</p>
                </div>
              </div>
            </div>
            <div class="issue__progress">
              <P>{{__('teams.User.Completion Rating')}}</p>
              <div class="d-flex align-items-center">
                <div class="progress">
                  <div class="progress-bar bg-success" role="progressbar" style="width: {{$data['issues']['completion_percentage']}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress__value ml-auto">
                  <p>{{$data['issues']['completion_percentage']}}%</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="teams-header departDetail">
        <div class="teams-header-wrap">
          <div class="teams-header-left-wrap px-4">
            <div class="dropdown sort-userbtn">
              <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{__('teams.dashboard.Sort By')}}: <span class="sortby_title">{{__('teams.dashboard.All Users')}}</span>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item sortby-key active" data-type="user" data-sortby="id" data-parameter-name="department_id" data-add-parameter="{{$data['department_detail']->id}}" data-sort-order="ASC" href="#">{{__('teams.dashboard.All Users')}}</a>
                <a class="dropdown-item sortby-key" data-type="user" data-sortby="created_at" data-parameter-name="department_id" data-add-parameter="{{$data['department_detail']->id}}" data-sort-order="ASC" href="#">{{__('teams.dashboard.Newly Added')}}</a>
                <a class="dropdown-item sortby-key" data-type="user" data-sortby="name" data-parameter-name="department_id" data-add-parameter="{{$data['department_detail']->id}}" data-sort-order="ASC" href="#">A-Z</a>
                <a class="dropdown-item sortby-key" data-type="user" data-sortby="name" data-parameter-name="department_id" data-add-parameter="{{$data['department_detail']->id}}" data-sort-order="DESC" href="#">Z-A</a>
                <a class="dropdown-item sortby-key" data-type="user" data-sortby="" data-parameter-name="department_id" data-add-parameter="{{$data['department_detail']->id}}" data-sort-order="ASC" href="#">{{__('teams.User.User Type')}}</a>
              </div>
            </div>
          </div>
          <div class="teams-header-right-wrap">
            <div class="teams-header-element">
              <input class="form-control search-module" type="text" placeholder="Search" id="search-on-teams" data-url="{{route('teams.user_search')}}" data-add-parameter="{{$data['department_detail']->id}}" data-parameter-name="department_id" autocomplete="off">
            </div>
            <div class="teams-header-element pr-4">
              @can('manager-only',Auth::user())
              <div class="search-btn">
                <button class="btn search get-data-for-adding" type="button" data-toggle="modal" data-type="user" data-target="#add_new_user">{{__('teams.dashboard.ADD NEW')}}</button>
              </div>
              @endcan
            </div>
          </div>
        </div>
      </div>
      <div class="table-section">
        <div class="built-in-scroll">
          <div class="built-in-scroll-child data-append search-module-append">
            @include('includes.user_list',['data'=>$data['department_members']])
          </div>
        </div>
      </div>
      <div class="pagination-content mt-3 pr-4 pagination-module-append">
        @include('includes.pagination',['data'=>$data['department_members']])
      </div>

      @can('manager-only',Auth::user())
      <div class="depart__add-edit">
        <div class="edit_depart-btn mr-3"><button type="button" class="btn depart__editBtn get-data-for-adding" data-type="department" data-value="{{$data['department_detail']->id}}" data-toggle="modal" data-target="#addDepartmentModal">{{__('teams.User.Edit')}}</button></div>
        <div class="delete_depart-btn"><button type="button" class="btn depart__deleteBtn" data-toggle="modal" data-target="#deletedepartmentModal">{{__('teams.User.Delete')}}</button></div>
      </div>
      @endcan
      <div class="modal fade" id="deletedepartmentModal" tabindex="-1" role="dialog" aria-labelledby="deletedepartmentModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <form method="GET" action="{{ url(route('teams.deletethesingledepartmentrecord',['id'=>$data['department_detail']->id])) }}" class="modal-approveall">
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

  <!-- @include('manager.team.includes.add_new_user') -->
  
@include('manager.team.includes.add_new_user')

</div>

<div class="modal fade add-department add-new-department" id="addDepartmentModal" role="dialog" aria-labelledby="departModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="departModalLabel">{{__('teams.User.Create New Department')}}</h5>
      </div>
      <form action="{{ route('teams.department_save') }}" id="add_new_department" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="editdepartmentID" id="editdepartmentID" />
          <div class="create__department">
            <div class="form-group row">
              <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="departmentName">
                  <label>{{__('teams.User.Department Details')}}</label>
                  <input type="text" class="form-control department_name-validation-error" aria-describedby="departmentName" placeholder="Name" name="department_name" id="department_name">
                  <span class="invalid-feedback" role="alert">
                    <strong id="department_name-validation-error-message"></strong>
                        </span>
                </div>
                <div class="departDescribe">
                  <textarea class="form-control" rows="3" placeholder="Short Client Description" name="department_description" id="department_description"></textarea>
                </div>
              </div>
              <div class="col-lg-7 col-md-7 col-sm-12">
                <div class="departmentName">
                   <label>{{__('teams.User.Department Admin')}}</label>
                  <div class="d-flex">
                    <div class="team__member">
                      <select class="form-control select2 all_users modal-select2" id="modal-admin-users" data-user-type="admin">
                      </select>
                    </div>
                  </div>
                  <div class="memeberaddingList modal-admin-display">

                  </div>
                 
                </div>
                <div class="modal-admin-input department_admin_input-validation-error"></div>
                <span class="invalid-feedback" role="alert">
                <strong id="department_admin_input-validation-error-message"></strong>
                      </span>
              </div>

            </div>

            <div class="form-group row">
            
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="departmentName">
                 <label>{{__('teams.User.Team Members')}}</label>
                  <div class="d-flex">
                    <div class="team__member form-group">
                      <select class="form-control select2 all_users modal-select2" id="modal-all-users" data-user-type="all">
                      </select>
                    </div>
                  </div>
                  <div class="memeberaddingList modal-all-display">

                  </div>
                </div>
                <div class="modal-all-input department_all_input-validation-error"></div>
                <span class="invalid-feedback" role="alert">
                <strong id="department_all_input-validation-error-message"></strong>
                      </span>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('teams.User.Cancel')}}</button>
            <button type="button" data-value="deptdetails" class="btn btn-primary FormsubmitBtn">{{__('teams.User.Confirm')}}</button>
            <button hidden type="submit" class="btn btn-primary" id="deptsubmitbtn">{{__('teams.User.Confirm')}}</button>
          </div>
        </div>
    
  </form></div>
  </div>
</div>
@endsection

@push('scripts')
@include('includes.scripts.teamsscripts')
@endpush