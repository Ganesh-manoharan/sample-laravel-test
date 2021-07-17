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
      </div>
      @include('manager.client.includes.clients_header_element')
      <!-- /. file export section -->
      <!-- fraud graph export section -->
      <div class="table-section awaiting-itemtable">
        <div class="teams-main-content-scroll">
          <ul class="teams-child-content-scroll awaiting-approval search-module-append">
            @include('manager.client.includes.client_list')
          </ul>
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
      </div>
    <div class="pagination-content pr-4 mt-3 pagination-module-append client-pagination">
      @include('includes.pagination')
    </div>
    </div>
  </section>
  <!-- /.content -->

</div>


@include('manager.client.includes.popupmodal')

<!-- /.content-wrapper -->

@endsection