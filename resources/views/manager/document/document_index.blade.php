@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">
  <!-- Main content -->
  @php
  $req = app('request')->request->all();
  unset($req['page']);
  $for_filter = [];
  @endphp
  <section class="content">
    <div class="container-fluid document-list-section">
      <div class="top-header-filter">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="dropdown">
                  <button class="filtertask" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 0 !important;background: #fff !important;">
                    <span>{{__('documents.homepage.Filter By')}} : {{$info['document']}}<em class="pl-2 fas fa-chevron-down"></em></span>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item @if(!isset($req['document_filter'])) text-primary @endif" href="{{ route('document_index',$for_filter) }}">{{__('documents.homepage.All Documents')}}</a>
                    @foreach(regulatoryDocType() as $item)
                    @php
                    $for_filter['document_filter'] = $item->id;
                    $for_filter['document'] = $item->name;
                    @endphp
                    <a class="dropdown-item @if(isset($req['document_filter'])) @if($req['document_filter'] == $item->id) text-primary @endif @endif" href="{{ route('document_index',$for_filter)}}">{{$item['name']}}</a>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex align-items-center">
                  <div class="document-search">
                    <input class="form-control search-module" type="text" placeholder="Search" />
                    <span><img src="{{ asset('img/search-icon.svg') }}" class="img-fluid" alt="search" /> </span>
                  </div>
                  <div class="document-add-btn ml-auto">
                    <a href="{{route('document_create')}}" class="btn add--doc-button" type="button">{{__('documents.homepage.Add New')}}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="document-list-items">
        <div class="document-list-table search-module-append">
          @include('manager/document/document_list')
        </div>
        <div class="pagination-module-append">
          @include('includes/pagination',['data'=>$data])
        </div>
      </div>
    </div>
    <!-- /. fraud graph section -->
  </section>
  <!-- /.content -->
  <!-- modal -->
</div>
<!-- /.content-wrapper -->
<!-- update name modal -->
<div class="modal fade updateName-document" id="updateNameDocument" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h1>{{__('documents.popup.Rename Document')}}</h1>
        <div class="form-group">
          <input type="text" name="document_id" hidden>
          <input type="text" class="form-control" name="document_rename" placeholder="Central Bank Guidance">
        </div>
      </div>
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('documents.popup.Cancel')}}</button>
        <button type="button" data-update="document-rename" class="btn btn-primary document-update-submit">{{__('documents.popup.Save')}}</button>
      </div>
    </div>
  </div>
</div>
<!-- /update name modal -->
<!-- view modal -->
<div class="modal fade view-document" id="viewDocument" tabindex="-1" role="dialog" aria-labelledby="viewDocumentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row  h-100">
          <div class="col-lg-6 col-md-6 col-12 h-100">
            <div class="view-document-left h-100">
              <p>{{__('documents.popup.Document Name')}}: <span id="document-view-name"></span></p>
              <p>{{__('documents.popup.Document Type')}}: <span id="document-view-type"></span></p>
              <p>{{__('documents.popup.Last Modified')}}: <span id="document-view-date"></span></p>
              <p>{{__('documents.popup.Last Modified By')}} : <span id="document-view-reviewer"></span></p>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('documents.popup.Close')}}</button>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-12  h-100" id="iframe-wrapper">
            <div id='viewer'> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /view modal -->
<!-- upload modal -->
<div class="modal fade upload-document" id="uploadDocument" tabindex="-1" role="dialog" aria-labelledby="uploadDocumentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h1>{{__('documents.popup.Update Document')}}</h1>
        <div class="row ">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="upload-document-right">
            <h3 class="doc-Qr-title">{{__('documents.popup.Upload file')}}</h3>
              <div class="upload-item-document" id="drag-drop-file">
                <img src="{{env('DOMAIN_URL')}}/img/upload-img-blue.svg" class="img-fluid" alt="upload img">
                <p>{{__('documents.popup.Drag and drop here')}}</p>
                <p>or</p>
                <a type="button" class="document-upload" href="#">{{__('documents.popup.Upload file')}}</a>
                <input type="file" name="document_file" id="attach_file" multiple="" hidden="">
              </div>
              <div class="document-upload-preview"></div>
              <p class="docformats">({{__('documents.popup.Supported format')}}: pdf)</p>
              <div id="documentimage_status" class="documentimage_status"></div>
              </div>
            </div>
          <div class="col-lg-6 col-md-6 col-12">
            <div class="upload-document-left">
            <h3 class="doc-Qr-title">Document Details</h3>
            <p class="doc-Qr-para">This is a new version of a previously uploaded document and may have active task associations to review. Do you want to proceed?</p>
              <!-- <p>{{__('documents.popup.Document Name')}}: <span id="document-update-name"></span></p>
              <p>{{__('documents.popup.Last Modified')}}: <span id="document-update-date"></span></p>
              <p>{{__('documents.popup.Last Modified By')}} : <span id="document-update-reviewer"></span></p> -->
              <div class="doc-upload-confirm">
                <button type="button" class="btn upload-confirm-btn  document-update-submit" data-update="document-update">confirm</button>
              </div>
            </div>
            <h4 class="error_onupload">There are tasks you do not have access to that will be affected by this change</h4>
            <div class="fetchtask">
            </div>
          </div>
         
          </div>
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('documents.popup.Cancel')}}</button>
          <button type="button" class="btn btn-primary  document-update-submit" data-update="document-update">{{__('documents.popup.Save')}} </button>
        </div> -->
      </div>
    </div>
  </div>
  <!-- /upload modal -->
  <!-- Confrimation modal -->
  <button hidden data-toggle="modal" data-target="#confrimationUpdate"></button>
  <div class="modal fade confrimation-document" id="confrimationUpdate" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h1>{{__('documents.popup.This document has been updated')}}</h1>
          <div class="tick-mark">
            <img src="{{env('DOMAIN_URL')}}/img/tickmark.svg" class="img-fluid" alt="tick mark">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Document delete popupmodal-->
  <div class="modal fade" id="deletedocumentModal" tabindex="-1" role="dialog" aria-labelledby="deletedocumentModal" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <form method="GET" action="" class="modal-approveall">
                          {{ csrf_field() }}
                          <div class="modal-content">
                            <div class="modal-body">
                              <h3>{{__('documents.popup.Do you want to delete the record')}}?</h3>
                              <div class="bottom__btn">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('documents.popup.CANCEL')}}</button>
                                <button type="submit" id="delete-clients-confmbtn" class="btn btn-primary pdfmodal-save">{{__('documents.popup.CONFIRM')}}</button>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                  </div>
  <!-- /Confrimation modal -->
  <div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
@endsection
