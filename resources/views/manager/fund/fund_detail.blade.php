@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">
  <!-- Main content -->
  <section class="content">
  <div class="flash-message">
        @foreach (['error', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
        @endif
        @endforeach
      </div>
    <!-- container-fluid -->
    <div class="container-fluid box-section">
    @include('manager.fund.includes.popupmodal')
        <div class="fund-detail-section">
          <div class="card fund-card">
            <div class="card-body fund-card-body">
              <div class="fund-card-header">
                <h3>{{isset($fund_data->fund_group_name)?$fund_data->fund_group_name:''}}</h3>
              </div>
              <div class="fund-detail__inner">
                <div class="row">
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Entity Type</label>
                      <p>{{isset($fund_data->entity_type)?$fund_data->entity_type:''}} </p>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Registered Address</label>
                      <p>{{ isset($fund_data->registered_address)?$fund_data->registered_address:'' }}</p>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Key Contacts</label>
                      <ul class="pl-0">
                      <li class="fund-client__info">{{ isset($fund_data['getkeycontactslist'][0]->name)?$fund_data['getkeycontactslist'][0]->name:''}}</li>
                        <li class="fund-client__email">{{ isset($fund_data['getkeycontactslist'][0]->email)?$fund_data['getkeycontactslist'][0]->email:''}}</li>
                        <li class="fund-client__phone">{{ isset($fund_data['getkeycontactslist'][0]->phone_number)?$fund_data['getkeycontactslist'][0]->phone_number:''}}</li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Jurisdiction Type</label>
                      <div>
                          <button class="btn typeOfJurisdition" type="button">{{ isset($fund_data['getcountrylist']->country_name)?$fund_data['getcountrylist']->country_name:''}}</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                <div class="col-lg-9">
                <div class="row pt-5">
                  <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="fund-content">
                      <label>Initial Launch Date</label>
                      <p>{{ isset($fund_data->initial_launch_date)?date('M j, Y', strtotime($fund_data->initial_launch_date)):''}}</p>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Management Company</label>
                      <p>{{isset($fund_data->management)?$fund_data->management:''}}</p>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Accounting Year End</label>
                      <p>{{ isset($fund_data->accounting_year_end)?date('M j, Y', strtotime($fund_data->accounting_year_end)):''}}</p>
                    </div>
                  </div>
                </div>
                <div class="row pt-5">
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Administrator</label>
                      <p>{{isset($fund_data->administrator)?$fund_data->administrator:''}}</p>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Depositary</label>
                      <p>{{isset($fund_data->depository)?$fund_data->depository:''}}</p>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Auditor</label>
                      <p>{{isset($fund_data->auditor)?$fund_data->auditor:''}}</p>
                    </div>
                  </div>
                </div>
                </div>
                <!-- <div class="col-lg-2">
                <div class="logo">
                <img src="{{ isset($data->avatar)?env('AWS_URL').'/'.$data->avatar:''}}" alt="fund_logo" class="funds-imagePreview-icon" />
                </div>
                </div> -->
                </div>
                <div class="row pt-5">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="fund-content">
                    <label class="funds_sub_funds">Sub-Funds</label>
                    <!-- @if($fund_data['getsubfundslist'])
                    
                    @foreach($fund_data['getsubfundslist'] as $item)
                    
                      <div>
                          <button class="btn typeOfJurisdition_funds" type="button">{{ $item->sub_fund_name?$item->sub_fund_name:''}}</button>
                      </div>
                    
                    @endforeach
                    
                    @endif -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show active" id="sub-funds" role="tabpanel" aria-labelledby="profile-tab">     
          <div class="teams-main-content-scroll">
              <ul class="teams-child-content-scroll awaiting-approval fundgroup">
             
                @foreach($data as $item)
                  <li>
                        <div class="d-flex align-items-center">
                          <div class="frm-clients funds">
                            <p>Sub-Fund Name</p>
                            <span>{{$item->sub_fund_name}}</span>
                          </div>
                          <div class="frm-clients-subfunds funds">
                            <p>Fund Group</p>
                            <span class="entity_type">{{$item->fund_group_name}}</span>
                          </div>

                          <div class="frm-clients-subfunds funds">
                            <p>Investment Manager</p>
                            <span>{{$item->investment_manager}}</span>
                          </div>

                          <div class="frm-clients-subfunds funds">
                            <p>Initial Launch Date</p>
                            <span>{{ isset($item->sub_funds_launch_date)?date('M j, Y', strtotime($item->sub_funds_launch_date)):''}}</span>
                          </div>

                          <div class="action_item">
                            <div class="view_item">
                              <p><a href="{{  url(route('funds.viewsubfunddetails',['id'=>$item->subfundid])) }}"><img src="{{ asset('/img/view-icon.svg') }}" alt="view"/></a></p>
                              <span>{{__('clients.view_details.View')}}</span>
                            </div>
                            <div class="delete_item">
                              <p><a class="deleterecords" data-toggle="modal" data-target-action="{{ url(route('funds.deletesubfundrecord',['id'=>$item->subfundid])) }}" data-target="#deletesubfundModal"><img src="{{ asset('/img/delete__icon.svg') }}" alt="delete"/></a><p>
                              <span>{{__('clients.view_details.Delete')}}</span>
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
          <div class="modal fade deletesubfundModal" id="deletesubfundModal" tabindex="-1" role="dialog" aria-labelledby="deletesubfundModal" aria-hidden="true">
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
          </div>
        </div>
        </div>
</div>
              <div class="depart__add-edit">
                  <div class="edit_depart-btn mr-3"><button type="button" class="btn depart__editBtn fund__editBtn" data-toggle="modal" data-value="{{$fund_data->id}}" data-target=".add-fundgroup">{{__('clients.view_details.Edit')}}</button></div>
                 <div class="delete_depart-btn"><button type="button" data-toggle="modal" data-value="{{$fund_data->id}}" data-target="#deletefundModal" class="btn depart__deleteBtn">{{__('clients.view_details.Delete')}}</button></div>
              </div>
              <div class="modal fade" id="deletefundModal" tabindex="-1" role="dialog" aria-labelledby="deletefundModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <form method="GET" action="{{ url(route('funds.deletethesinglefundrecord',['id'=>$fund_data->id])) }}" class="modal-approveall">
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
        </div>
    </div>
  </section>

 


@endsection