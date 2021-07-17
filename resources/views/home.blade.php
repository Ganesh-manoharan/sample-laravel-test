@extends('layouts.dashboard')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid box-section">
      <!-- info-box section -->
      @include('includes.labels')

      <!-- /. info-box section -->
      <!-- file export section -->
      <div class="file-export-item">
        <div class="card">
          <div class="card-body p-0">
            <div class="row align-items-center">
              <div class="col-sm-12 col-md-7">
                <div class="d-flex">
                  <div class="col-sm-4 col-md-4">
                    <div class="dropdown departments">
                      <button class="btn btn-action filtertask" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>{{__('home_manager.Navigationbar.Departments')}} <em class="pl-2 fas fa-chevron-down"></em></span>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{route('home')}}">All</a>
                        @foreach(departmentList() as $item)

                        <a  href="{{route('home',['department_id'=>$item->id])}}" @if(isset(request()->department_id) && request()->department_id == $item['id']) class="dropdown-item active" id="chart-department-id" data-id="{{$item->id}}" @else class="dropdown-item" @endif >{{$item['name']}}</a>
                        @endforeach
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4 col-md-4 ml-3">
                    <div class="dates form-group" hidden>
                      <select class="form-control dates" disabled>
                        <option>{{__('home_manager.Navigationbar.Dates')}}</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /. file export section -->
      <!-- task graph export section -->
      <div class="task-section">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <div class="task-leftitem">
                <h3>
                  <a class="btn" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">{{__('home_manager.Task.Title')}} <em class="fas fa-chevron-down"></em>
                  </a>
                </h3>
              </div>
              <div class="date-rightitem ml-auto">
                <div class="dates form-group" hidden>
                  <select class="form-control" disabled>
                    <option seclected>{{__('home_manager.Task.Dates')}}</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          
          <div id="collapseExample" class="collapse show">
            <div class="card-body">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link chartcalc" id="overall-tab" data-toggle="tab" href="#Overall" role="tab" data-value="overall" aria-controls="overall" aria-selected="true">{{__('home_manager.Task.Overall')}}</a>
                </li>
                <li class="nav-item">
                <select class="form-control chartyear" id="chartyear">
                  @foreach(range(date('Y',strtotime(companyYear()->created_at)),date('Y')) as $year)
                    <option value="{{$year}}">{{$year}}</option>
                    @endforeach
                  </select>
                </li>
                <li class="nav-item">
                  <a class="nav-link chartcalc active" id="quarter-tab" data-toggle="tab" href="#quarter" role="tab" data-value="quarter" aria-controls="quarter" aria-selected="false">{{__('home_manager.Task.This Quarter')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link chartcalc" id="month-tab" data-toggle="tab" href="#month" role="tab" data-value="month" aria-controls="month" aria-selected="false">{{__('home_manager.Task.This Month')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link chartcalc" id="week-tab" data-toggle="tab" href="#week" role="tab" data-value="week" aria-controls="week" aria-selected="false">{{__('home_manager.Task.This Week')}}</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="Overall" role="tabpanel" aria-labelledby="overall-tab">
                  <div class="row align-items-end">
                    <div class="col-md-4">
                      <div class="md4">
                        <canvas id="myChart1" width="500" height="500"></canvas>
                        <div class="overlay"><div>No data available</div></div>
                      </div>
                    </div>
                    <div class="col-md-4 middle-item">
                      <div class="rating-section">
                        <p>{{__('home_manager.Task.Compliance Rating')}}</p>
                        <h2 id="compilance_rating"></h2>
                        <!-- <span><em class="fas fa-caret-up"></em> Up 0% on previous year</span> -->
                      </div>
                      <div class="rating-sectionitem d-flex">
                        <div>
                          <span class="complaints-rating-text pr-4 pl-4">{{__('home_manager.Task.Total Tasks')}}</span>
                          <span id="total_task" class="complaints-rating-number"></span>
                        </div>
                        <div>
                          <span class="complaints-rating-text">{{__('home_manager.Task.Satisfactory Completion')}}</span>
                          <span id="completion_with_satisfactory" class="complaints-rating-number"></span>
                        </div>
                        <div>
                          <span class="complaints-rating-text">{{__('home_manager.Task.Completion with Challenge')}}</span>
                          <span id="completion_with_challenge" class="complaints-rating-number"></span>
                        </div>
                        <div>
                          <span class="complaints-rating-text pr-3 pl-3">{{__('home_manager.Task.Not Completed')}}</span>
                          <span id="not_completed" class="complaints-rating-number"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="md4">
                        <canvas id="myChart3" width="500" height="500"></canvas>
                        <div class="overlay1"><div>No data available</div></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /. task graph section -->
      <!-- fraud graph export section -->
      <div class="fraud-section">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <div class="task-leftitem">
                <h3>
                  <a class="btn" data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="true" aria-controls="collapseExample1">{{__('home_manager.Issues.Title')}} <em class="fas fa-chevron-down"></em></a>
                </h3>
              </div>
            </div>
          </div>
          <div id="collapseExample1" class="collapse show">
            <div class="card-body">
              <canvas id="myChart" width="400" height="400"></canvas>
            </div>
          </div>
        </div>
      </div>
      <!-- /. fraud graph section -->
      <!-- fraud graph export section -->
      <div class="table-section">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <div class="task-leftitem">
                <h3>
                  <a class="btn collapse-section" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="true" aria-controls="collapseExample">{{__('home_manager.Department.Title')}} <em class="fas fa-chevron-down"></em></a>
                </h3>
              </div>
            </div>

          </div>
          <div class="teams-main-content-scroll mt-2">
            <div class="teams-child-content-scroll">
              @include('includes.department_list')
            </div>
          </div>
        </div>
        <div class="mr-3">
          @include('includes.pagination')
        </div>
      </div>


      <!-- /. fraud graph section -->
    </div><!-- /.container-fluid -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
