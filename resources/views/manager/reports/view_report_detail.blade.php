@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">
  <!--view content-->
  <section class="content">
    <!-- container-fluid -->
    <div class="container-fluid box-section">
        <div class="report-detail-section">
          <div class="card fund-card">
            <div class="card-body fund-card-body">
              <div class="fund-card-header">
                <h3>Reports</h3>
              </div>
              <div class="fund-detail__inner">
                <div class="row mb-5">
                  <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="fund-content">
                      <label>Report Type</label>
                      <select class="form-control select2 reportsdrpdwn" style="width: 100%;" id="report_type" name="report_type" disabled>
                    <option value="" selected disabled>Choose Report Type</option>
                    @foreach($report_type as $list)
                        <option value="{{$list->id}}" @if($data_report->report_type_id==$list->id)selected="selected"@endif>{{$list->name}}</option>
                      @endforeach
                  </select>
                    </div> 
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="fund-content">
                      <label>Frequency</label>
                      <p>{{$data_report->frequency}}</p>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="fund-content">
                    <label>Report Name</label>
                      <div>
                      <p>{{$data_report->name}}</p>
                      </div>
                    </div>
                  </div>
                  @if($data_report->report_type_id==1)
                  <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="fund-content">
                    <label>Document</label>
                      <div>
                      @foreach($data_report['Documentlist'] as $item)
                      <p>{{$item->document_name}}</p>
                      @endforeach
                      </div>
                    </div>
                  </div>
                  @endif
                  @if($data_report->report_type_id==3)
                  <!-- <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="fund-content">
                    <label>Impact Rating</label>
                      <div>
                      @foreach($impactrating_list as $item)
                      <p>{{$item->dropdown_name}}</p>
                      @endforeach
                      </div>
                    </div>
                  </div> -->
                  @endif
                </div>
               @if($data_report->report_type_id==1 || $data_report->report_type_id==3)
                <div class="row mb-5">
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Client</label>
                      @foreach($data_report['clientlist'] as $item)
                      <p>{{$item->client_name}}</p>
                      @endforeach
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Department</label>
                      @foreach($data_report['Departmentlist'] as $item)
                      <p>{{$item->name}}</p>
                      @endforeach
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                    <label>Fund Group</label>
                      <div>
                      @foreach($data_report['fundgrouplist'] as $item)
                      <p>{{$item->fund_group_name}}</p>
                      @endforeach
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                    <label>Sub-Fund Group</label>
                      <div>
                      @foreach($data_report['subfundlist'] as $item)
                      <p>{{$item->sub_fund_name}}</p>
                      @endforeach
                      </div>
                    </div>
                  </div>
                </div>
                @elseif($data_report->report_type_id==2)
                <div class="row mb-5">
                <!-- <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Risk Score</label>
                      @foreach($riskscore_list as $item)
                      <p>{{$item->dropdown_name}}</p>
                      @endforeach
                    </div>
                  </div> -->
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Department</label>
                      @foreach($data_report['Departmentlist'] as $item)
                      <p>{{$item->name}}</p>
                      @endforeach
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Risk Category</label>
                      @foreach($riskcategorylist as $item)
                       <p>{{$item->title}}</p>
                      @endforeach
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>SubCategory</label>
                      @foreach($risksubcategorylist as $item)
                      <p>{{$item->title}}</p>
                      @endforeach
                    </div>
                  </div>
                 
                  
                </div>

                @endif
              </div>

              <div class="depart__add-edit">
                 <div class="delete_depart-btn"><button type="button" data-toggle="modal"  data-target="#deletereportModal" class="btn depart__deleteBtn">Delete</button></div>
              </div>
              <div class="modal fade deletereportModal" id="deletereportModal" tabindex="-1" role="dialog" aria-labelledby="deletereportModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <form method="GET" action="{{ url(route('deletereports',['id'=>$data_report->id])) }}" class="modal-approveall">
                        {{ csrf_field() }}
                        <div class="modal-content">
                          <div class="modal-body">
                            <h3>{{__('clients.view_details.Do you want to delete the record')}}?</h3>
                            <div class="bottom__btn">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                              <button type="submit" id="delete-clients-confmbtn" class="btn btn-primary pdfmodal-save">CONFIRM</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
    <!-- container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid box-section">
      
      <div class="teams-main-content-scroll report-list-item">
        <ul class="teams-child-content-scroll p-0">
         @foreach($data as $item)
         <li>
              <div class="card">
                <div class="card-body p-2">
                  <div class="d-flex align-items-center">
                    <div class="col-md-2 department-detail-page cursor-pointer" data-id="1">
                      @switch($item->report_format)
                      @case("pptx")
                      <img src="{{ asset('img/ppt-document.svg') }}" alt="document" class="img-fluid mr-3">
                      @break
                      @case("pdf")
                      <img src="{{ asset('img/pdf-document.svg') }}" alt="document" class="img-fluid mr-3">
                      @break
                      @case("xls")
                      <img src="{{ asset('img/xls-document.svg') }}" alt="document" class="img-fluid mr-3">
                      @break
                      @case("doc")
                      <img src="{{ asset('img/document.svg') }}" alt="document" class="img-fluid mr-3">
                      @endswitch
                    </div>
                    <div class="col-md-4 department-detail-page cursor-pointer" data-id="1">
                        <p class="dep_title m-0">Report File</p>
                        @php $file = explode('/', $item->report_path) @endphp
                        <span>{{ end($file) }}</span>
                    </div>
                    <div class="col-md-2">
                      <p class="m-0">Generated at</p>
                      <span>{{ date_format(date_create($item->created_at),'d F Y') }}</span>
                    </div>
                    <div class="col-md-2">
                      <div class="document-add-btn text-right">
                        <a href="{{ env('AWS_URL').'/'.$item->report_path }}" target="_blank" class="btn add--doc-button" type="button">View</a>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="document-add-btn text-right">
                        <a href="{{ env('AWS_URL').'/'.$item->report_path }}" class="btn add--doc-button" type="button">Download</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </li>
          @endforeach

        </ul>
       
      </div>
      <div class="pagination-content pr-4 mt-3">
      @include('includes.pagination')
    </div>


</div>



@endsection