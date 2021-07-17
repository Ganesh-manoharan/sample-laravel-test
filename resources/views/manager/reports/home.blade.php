@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid box-section">
      <div class="report-header-section">
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="d-flex align-items-center">
                        <div class="report-filter-title">
                            <h1>Report</h1>
                        </div>
                        <div class="funds-header-searchBox">
                            <input class="form-control search-on-teams search-module" type="text" placeholder="Search" data-search-column="fund_search" id="search-on-teams" data-url="http://127.0.0.1:8000/manager/funds/fund_search" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="d-flex align-items-center">
                    <div class="report-add-btn ml-auto">
                    <button class="btn search fund-addnew-btn" type="button" data-toggle="modal" data-target="#addReport"> ADD NEW</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="teams-main-content-scroll report-list-item">
        <ul class="teams-child-content-scroll p-0 search-module-append">
            @include('manager.reports.reports_list')
        </ul>
      </div>

      <div class="pagination-content pr-4 mt-3 pagination-module-append report-pagination">
        @include('includes.pagination')
      </div>

    <div class="modal fade deletereportModal" id="deletereportModal"  tabindex="-1" role="dialog" aria-labelledby="deletereportModal" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
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
      
    </div>
    
   
    <!-- /. fraud graph section -->
  </section>
  <!-- /.content -->

</div>
<!-- Button trigger modal -->
<!-- Modal -->


<div class="modal fade addReportModal commonmodal" id="addReport" tabindex="-1" role="dialog" aria-labelledby="addReportTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form name="create_reports" id="create_reports" action="{{ url(route('create_reports')) }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="company_id" id="company_id" value="{{$companylist->company_id}}" />
          <div class="add-report-item">
            <h1>Create Report</h1>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group report-type-item">
                  <label>Report Type</label>
                  <select class="form-control select2 reportsdrpdwn report_type-validation-error" style="width: 100%;" id="report_type" name="report_type">
                    <option value="" selected disabled>Choose Report Type</option>
                      @foreach($report_type as $list)
                        <option value="{{$list->id}}">{{$list->name}}</option>
                      @endforeach
                  </select>
                  <span class="invalid-feedback" role="alert">
                               <strong id="report_type-validation-error-message"></strong>
                             </span> 
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group report-type-item">
                  <label>Frequency</label>
                  <select class="form-control select2 reportsdrpdwn frequency-validation-error" style="width: 100%;" id="frequency" name="frequency">
                    <option value="" selected="selected">Choose Frequency</option>
                    @foreach($frequency_list as $list)
                    <option value="{{$list->name}}">{{$list->name}}</option>
                    @endforeach
                  </select>
                  <span class="invalid-feedback" role="alert">
                               <strong id="frequency-validation-error-message"></strong>
                             </span> 
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group report-type-item">
                  <label>Report Name</label>
                  <input class="form-control report_name-validation-error" id="report_name" name="report_name" type="text" placeholder="Report name"/>
                  <span class="invalid-feedback" role="alert">
                               <strong id="report_name-validation-error-message"></strong>
                             </span> 
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 filter auditfilter">
                <div class="form-group report-type-item">
                  <label>Select Document</label>
                  <select class="form-control select2 reportsdrpdwn" style="width: 100%;" id="document" name="document">
                    <option value="" selected="selected">Choose Documents</option>
                     @foreach($document_list as $list)
                     <option value="{{$list->id}}" data-document-id="{{$list->id}}">{{$list->document_name}}</option>
                     @endforeach
                  </select>
                  <div class="listDepartment listDocument report_documents-validation-error">
                            <ul></ul>
                          </div>
                         
                          <div class="document_list">
                          </div>
                          <span class="invalid-feedback" role="alert">
                               <strong id="report_documents-validation-error-message"></strong>
                             </span> 
                </div>
              </div>
            </div>
            <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 filter auditfilter issuefilter">
                <div class="form-group report-type-item">
                  <label>Select Client</label>
                  <select class="form-control select2 reportsdrpdwn clients-validation-error" style="width: 100%;" id="clients" name="clients">
                    <option value="" selected disabled>Choose Client</option>
                     @foreach($client_list as $list)
                     <option value="{{$list->id}}">{{$list->client_name}}</option>
                     @endforeach
                  </select>
                  <span class="invalid-feedback" role="alert">
                               <strong id="clients-validation-error-message"></strong>
                             </span> 
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group report-type-item filter auditfilter issuefilter">
                  <label>Select Department</label>
                  <select class="form-control select2" style="width: 100%;" id="departments" name="departments">
                    <option value="" selected="selected" disabled>Choose Departments</option>
                  </select>
                  <div class="listDepartment departments-display report_departments-validation-error">
                      <ul></ul>
                    </div>
                    <span class="invalid-feedback" role="alert">
                               <strong id="report_departments-validation-error-message"></strong>
                             </span>
                    <div class="departments-input">
                    </div>
                </div>
                <div class="form-group report-type-item filter riskfilter">
                  <label>Select Department</label>
                  <select class="form-control select2 reportsdrpdwn" style="width: 100%;" id="risk_departments" name="risk_departments">
                    <option value="" selected disabled>Choose Departments</option>
                     @foreach($department_list as $item)
                   <option value="{{$item->id}}">{{$item->name}}</option>
                   @endforeach
                  </select>

                  <div class="listDepartment departments-display-risk departments-validation-error">
                      <ul></ul>
                    </div>
                    <span class="invalid-feedback" role="alert">
                               <strong id="departments-validation-error-message"></strong>
                             </span>
                    <div class="departments-input-risk">
                    </div>
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12 filter auditfilter issuefilter">
                <div class="form-group report-type-item">
                <div class="d-flex">
                          <div class="team__member">
                  <label>Fund Group</label>
                  <select class="form-control modal-select3  all_users" style="width: 100%;" id="clientpopup-fund_groups">
                    <option value="" selected="selected">Choose FundGroups</option>
                    @foreach($fundgroups_list as $list)
                    <option value="{{$list->id}}">{{$list->fund_group_name}}</option>
                     @endforeach
                  </select>
                  <div class="listDepartment fund_groups dep-list clients_fundgroups-validation-error">
                              <ul class="displaylist"></ul>
                            </div>
                            <span class="invalid-feedback" role="alert">
                               <strong id="clients_fundgroups-validation-error-message"></strong>
                             </span>
                            <div class="fund_groups_list">
                            </div>
                </div>
              </div>
              </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 filter auditfilter issuefilter">
                <div class="form-group report-type-item">
                  <label>Sub-Fund Group</label>
                  <select class="form-control select2" style="width: 100%;" id="subfunds">
                  <option value="">Choose Sub Fund Group</option>
                  </select>
                  <div class="listDepartment subfunds subfunds-validation-error">
                            <ul></ul>
                          </div>
                          <span class="invalid-feedback" role="alert">
                               <strong id="subfunds-validation-error-message"></strong>
                             </span>
                          <div class="subfunds_list">
                          </div>
              </div>
              </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 filter riskfilter">
                  <div class="form-group report-type-item">
                    <label>Risk Category</label>
                    <select class="form-control select2 reportsdrpdwn risk_category-validation-error" style="width: 100%;" id="risk_category" name="risk_category">
                      <option value="" selected="selected">Choose Risk Category</option>
                      @foreach($riskcategory_list as $item)
                      <option value={{$item->id}}>{{$item->title}}</option>
                      @endforeach
                    </select>
                    <span class="invalid-feedback" role="alert">
                               <strong id="risk_category-validation-error-message"></strong>
                             </span>
                </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 filter riskfilter">
                    <div class="form-group report-type-item">
                      <label>SubCategory</label>
                      <select class="form-control select2 reportsdrpdwn subcategory-validation-error" style="width: 100%;" id="subcategory" name="subcategory">
                        <option value="" selected disabled>Choose SubCategory</option>
                      </select>
                      <span class="invalid-feedback" role="alert">
                               <strong id="subcategory-validation-error-message"></strong>
                             </span>
                    </div>
                  </div>
              </div>
          </div>
          <label>Tags</label>
          <input type="text" class="form-control" name="tags"/>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button  name="submit" type="button" data-value="reportdetails" class="btn btn-primary FormsubmitBtn">Save changes</button>
        <button hidden name="submit" id="reportsubmitbtn" type="submit" class="btn btn-primary" >Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- /.content-wrapper -->

@endsection
