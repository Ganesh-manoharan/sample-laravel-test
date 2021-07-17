@extends('layouts.dashboard')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">
  <!-- Main content -->
  <section class="content">
    <!-- container-fluid -->
    <div class="container-fluid box-section">
      @include('manager.team.includes.teams_header_element')
      @if(Route::currentRouteName()=='teams.allusers')
      <div class="teams-header">
        <div class="teams-header-wrap">
          <div class="row align-items-center w-100">
            <div class="col-md-4 d-flex teams-header-wrap-user-filter px-4">
              <div class="dropdown sort-userbtn">
                <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{__('teams.dashboard.Sort By')}}: <span class="sortby_title">{{__('teams.dashboard.All Users')}}</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item sortby-key active" data-type="user" data-sortby="id" data-sort-order="ASC" href="#">{{__('teams.dashboard.All Users')}}</a>
                  <a class="dropdown-item sortby-key" data-type="user" data-sortby="created_at" data-sort-order="ASC" href="#">{{__('teams.dashboard.Newly Added')}}</a>
                  <a class="dropdown-item sortby-key" data-type="user" data-sortby="name" data-sort-order="ASC" href="#">A-Z</a>
                  <a class="dropdown-item sortby-key" data-type="user" data-sortby="name" data-sort-order="DESC" href="#">Z-A</a>
                  <a class="dropdown-item sortby-key" data-type="user" data-sortby="" data-sort-order="ASC" href="#">{{__('teams.User.User Type')}}</a>
                </div>
              </div>
            </div>
            <div class="col-md-8 extra-pagination pagination-module-append all-userPagination">
              @include('includes.pagination')
            </div>
          </div>
        </div>
      </div>
      @endif
      <div class="table-section">
        <div class="teams-main-content-scroll">
          <div class="teams-child-content-scroll search-module-append">
            @if(Route::currentRouteName() == 'teams')
            @include('includes.department_list')
            @endif
            @if(Route::currentRouteName() == 'teams.allusers')
            @include('includes.user_list')
            @endif
          </div>
        </div>
        @if(Route::currentRouteName() == 'teams')
        <div class="pagination-content pr-4 pagination-module-append common-pagination">
          @include('includes.pagination')
        </div>
        @endif
      </div>
    </div>
  </section>
  @if(Route::currentRouteName() == 'teams')
  @include('manager.team.includes.add_new_department')
  @endif
  @if(Route::currentRouteName() == 'teams.allusers')
  @include('manager.team.includes.add_new_user')
  @endif
</div>

@endsection

@push('scripts')
@include('includes.scripts.teamsscripts')
@endpush