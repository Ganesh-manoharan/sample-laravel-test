@extends('layouts.dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper dashboard">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid document-list-section">
      <div class="top-header-filter">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="document-filter-title">
                  <h1>Filter By: All Documents</h1>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex align-items-center">
                  <div class="document-search">
                    <input class="form-control" type="text" placeholder="Search"/>
                    <span><img src="{{ asset('img/search-icon.svg') }}" class="img-fluid" alt="search"/> </span>
                  </div>
                  <div class="document-add-btn ml-auto">
                    <a href="#" type="button" data-toggle="modal" data-target="#uploadDocument" class="btn add--doc-button" type="button">Add New</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="document-list-items">
        <div class="document-list-table">
        
        @include('client/document_list')
        </div>
      </div>
    </div>
    <!-- /. fraud graph section -->
  </section>
  <!-- /.content -->
  <!-- modal -->
</div>
<div class="modal fade upload-document" id="uploadDocument" tabindex="-1" role="dialog" aria-labelledby="uploadDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <form id="document-upload-apache" action="{{route('ftp_document_save')}}" method="post">
      <input hidden type="text" id="ftp-document-upload">
        <div class="modal-body">
          <h1>Update Document</h1>
          <div class="row ">
            <div class="col-lg-6 col-md-6 col-12">
              <div class="upload-document-left">
                <p>Document Name:</p>
                <input class="document-title form-control document_title-validation-error" type="text" placeholder="{{__('documents.popup.Document Title')}}" name="document_title" autocomplete="off">
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
              <div class="upload-document-right">
              <h3>Upload file</h3>
              <div class="upload-item-document">
                <img src="{{env('DOMAIN_URL')}}/img/upload-img-blue.svg" class="img-fluid" alt="upload img">
                <p>Drag and drop here</p>
                <p>or</p>
                <a type="button" class="document-upload" href="#">Upload file</a>
                <input type="file" name="document_file" id="attach_file" multiple="" hidden="">
                <div class="document-upload-preview"></div>
              </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
      </div>
    </div>
  </div>

  <button data-toggle="modal" data-target="#confrimationDocument" hidden></button>
  <div class="modal fade confrimation-document" id="confrimationDocument" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h1>This document has been created</h1>
          <div class="tick-mark">
            <img src="{{env('DOMAIN_URL')}}/img/tickmark.svg" class="img-fluid" alt="tick mark">
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection