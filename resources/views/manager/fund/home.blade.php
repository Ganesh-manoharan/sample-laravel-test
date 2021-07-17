@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid box-section">
      <div class="flash-message">
        @foreach (['error', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
        @endif
        @endforeach
      
    @include('manager.fund.includes.funds_header_element')
    @if(Route::currentRouteName() == 'funds')
    @include('manager.fund.includes.popupmodal')
    @endif
    @if(Route::currentRouteName() == 'funds.subfunds')
    @include('manager.fund.includes.sub_funds_popupmodal')
    @endif
      <!-- /. file export section -->
      <!-- fraud graph export section -->
      <div class="table-section awaiting-itemtable">
      <div class="tab-content" id="myTabContent">

      @if(Route::currentRouteName() == 'funds')
        <div class="tab-pane fade show active" id="funds" role="tabpanel" aria-labelledby="home-tab">          
          <div class="teams-main-content-scroll">
              <ul class="teams-child-content-scroll awaiting-approval fundgroup search-module-append">
                @include('manager.fund.includes.fund_groups_list')
              </ul>
          </div>
          <div class="modal fade" id="deletefundModal" tabindex="-1" role="dialog" aria-labelledby="deletefundModal" aria-hidden="true">
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
        @endif
        @if(Route::currentRouteName() == 'funds.subfunds')
        <div class="tab-pane fade show active" id="sub-funds" role="tabpanel" aria-labelledby="profile-tab">     
          <div class="teams-main-content-scroll">
              <ul class="teams-child-content-scroll awaiting-approval fundgroup search-module-append">
                @include('manager.fund.includes.sub_funds_list')
              </ul>
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
         @endif
      </div>
      <div class="pagination-content pr-4 mt-3 pagination-module-append common-pagination">
        @include('includes.pagination')
      </div>
    </div>
   
    <!-- /. fraud graph section -->
  </section>
  <!-- /.content -->

</div>



<!-- /.content-wrapper -->

@endsection
