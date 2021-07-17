@extends('layouts.dashboard')
@section('content')
<div class="content-wrapper" style="min-height: 455px;">
  <!-- Main content -->

  <section class="content">
    <!-- container-fluid -->
    <form id="document-upload-apache" action="{{route('document_save')}}" method="post" enctype="multipart/form-data">
      <div class="container-fluid addtask-section">
        <div class="upload-document-create">
          <h1>{{__('documents.popup.Upload Document')}}</h1>
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
              <h3>{{__('documents.popup.Upload file')}}</h3>
              <div class="upload-item-document" id="drag-drop-file">
                <img src="{{env('DOMAIN_URL')}}/img/upload-img-blue.svg" class="img-fluid" alt="upload img">
                <p>{{__('documents.popup.Drag and drop here')}}</p>
                <p>or</p>
                <a type="button" class="document-upload" href="#">{{__('documents.popup.Upload file')}}</a>
                <input type="file" name="document_file" id="attach_file" class="document_file-validation-error" multiple="" hidden="">
                <span class="invalid-feedback" role="alert">
                <span>*</span><strong id="document_file-validation-error-message"></strong>
                  </span>
              </div>
              <div class="document-upload-preview"></div>
              <p class="docformats">({{__('documents.popup.Supported format')}}: pdf)</p>
              <div id="documentimage_status" class="documentimage_status"></div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="d-flex document-right-item">
                <div class="form-group select-document-type">
                  <label>{{__('documents.popup.Document Details')}}</label>
                  <div class="dropdown">
                    <button class="form-control" type="text" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      <span id="selected-frequency">{{__('documents.popup.Choose Doc Type')}}</span> <em class="fas fa-chevron-down pl-2"></em></button>
                    <div class="dropdown-menu task-frequency document_type-validation-error" aria-labelledby="frequency" x-placement="top-start" style="position: absolute; will-change: transform; margin-top: 15px !important; left: 0px; transform: translate3d(0px, -256px, 0px);padding:0">
                      <a class="dropdown-item" data-value="1">{{__('documents.popup.Regulation/Guidance')}}</a>
                      <a class="dropdown-item " data-value="2">{{__('documents.popup.Legislation')}}</a>
                      <a class="dropdown-item " data-value="3">{{__('documents.popup.Policy')}}</a>
                      <a class="dropdown-item " data-value="4">{{__('documents.popup.Business Plan')}}</a>
                      <a class="dropdown-item " data-value="5">{{__('documents.popup.Program of Activity')}}</a>
                    </div>
                    <span class="invalid-feedback" role="alert">
                    <span>*</span><strong id="document_type-validation-error-message"></strong>
                  </span>
                  </div>
                </div>
                <div class="document-title-wrapper form-group">
                  <input class="document-title form-control document_title-validation-error" type="text" placeholder="{{__('documents.popup.Document Title')}}" name="document_title" autocomplete="off">
                  <span class="invalid-feedback" role="alert">
                    <span>*</span><strong id="document_title-validation-error-message"></strong>
                  </span>
                </div>
                <input type="hidden" name="document_type">
                <div class="document-save-item">
                  <button class="btn  save-document-btn FormsubmitBtn" data-value="documentdetails" type="button">{{__('documents.popup.Save')}}</button>
                  <button hidden class="btn save-document-btn" id="document-save" type="submit" data-toggle="modal" data-target="#confrimationUpdate">{{__('documents.popup.Save')}}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
    </form>
  </section>
  <!-- /.content -->
  <!-- modal start -->

  <!-- Confrimation modal -->
  <button data-toggle="modal" data-target="#confrimationDocument" hidden></button>
  <div class="modal fade confrimation-document" id="confrimationDocument" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h1>{{__('documents.popup.This document has been created')}}</h1>
          <div class="tick-mark">
            <img src="{{env('DOMAIN_URL')}}/img/tickmark.svg" class="img-fluid" alt="tick mark">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Confrimation modal -->
</div>
@endsection