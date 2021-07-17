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
    @include('manager.fund.includes.sub_funds_popupmodal')
        <div class="fund-detail-section">
          <div class="card fund-card">
            <div class="card-body fund-card-body">
              <div class="fund-card-header">
                <h3>{{$data->sub_fund_name}}</h3>
              </div>
              <div class="fund-detail__inner">
                <div class="row">
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Investment Manager</label>
                      <p>{{ isset($data->investment_manager)?$data->investment_manager:'' }} </p>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                      <label>Key Contacts</label>
                      <ul class="pl-0">
                      <li class="fund-client__info">{{ isset($data['getkeycontactslist'][0]->name)?$data['getkeycontactslist'][0]->name:''}}</li>
                        <li class="fund-client__email">{{ isset($data['getkeycontactslist'][0]->email)?$data['getkeycontactslist'][0]->email:''}}</li>
                        <li class="fund-client__phone">{{ isset($data['getkeycontactslist'][0]->phone_number)?$data['getkeycontactslist'][0]->phone_number:''}}</li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                    <label>Investment Strategy</label>
                      <div>
                      <p>{{ isset($data->investment_strategy)?$data->investment_strategy:'' }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="fund-content">
                    <label>Initial Launch Date</label>
                      <div>
                      <p>{{ isset($data->initial_launch_date)?date('M j, Y', strtotime($data->initial_launch_date)):''}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="depart__add-edit">
                  <div class="edit_depart-btn mr-3"><button type="button" class="btn depart__editBtn fund__editBtn" data-toggle="modal"  data-target=".add-subfund">Edit</button></div>
                 <div class="delete_depart-btn"><button type="button" data-toggle="modal"  data-target="#deletesubfundModal" class="btn depart__deleteBtn">Delete</button></div>
              </div>
              <div class="modal fade deletesubfundModal" id="deletesubfundModal" tabindex="-1" role="dialog" aria-labelledby="deletesubfundModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <form method="GET" action="{{ url(route('funds.deletesubfundrecord',['id'=>$data->id])) }}" class="modal-approveall">
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
  </section>

</div>


@endsection