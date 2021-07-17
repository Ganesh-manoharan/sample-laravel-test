@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid box-section">
    
      <!-- /. file export section -->
      <!-- fraud graph export section -->
      <div class="table-section awaiting-itemtable">
        <div class="teams-main-content-scroll">
          <ul class="teams-child-content-scroll awaiting-approval">
            <li>
              <div class="d-flex align-items-center">
                <div>
                  <p class="semi-bold"><span>AML - Blocked Account</span></p>
                </div>
                <div class="frm-clients">
                  <p>Department</p>
                  <span>Department desc</span>
                </div>
                <div class="frm-clients-subfunds">
                  <p>Client</p>
                  <span>client</span>
                </div>
                <div class="frm-clients-subfunds">
                  <p>Responsible Party</p>
                  <span>responsible party</span>
                </div>
                <div class="frm-clients-subfunds">
                  <p>Occured</p>
                  <span>Occured</span>
                </div>
                <div class="action_item">
                  <div class="view_item">
                    <p><a href=""><img src="{{ asset('/img/view-icon.svg') }}" alt="view" /></a></p>
                    <span>{{__('funds.view_details.View')}}</span>
                  </div>
                  <div class="delete_item">
                    <p><a href="#" data-toggle="modal" data-target=".deleteclientModal"><img src="{{ asset('/img/delete__icon.svg') }}" alt="delete" /></a></p>
                    <span>{{__('funds.view_details.Delete')}}</span>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="pagination-content pr-4 mt-3">
      
    </div>
  </section>
  <!-- /.content -->

</div>


@endsection