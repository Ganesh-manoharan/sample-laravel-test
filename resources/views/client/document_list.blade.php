<ul class="p-0">
    @foreach($data as $item)
    <li>
        <div class="card">
            <div class="card-body">
                <div class="document-divi-item">
                    <div class="items--docu" style="width: calc(100% / 4 );">
                        <div class="pdf-document-item clearfix d-flex align-items-center">
                            <img src="{{ asset('img/pdf-document.svg') }}" alt="PDF document" class="img-fluid mr-4" />
                            <h1>{{$item->document_path}}</h1>
                        </div>
                    </div>
                    <div class="items--docu">
                        <div class="clearfix">
                            
                        </div>
                    </div>
                    
                    <div class="items--docu">
                        <div class="clearfix">
                            <p>Uploaded Date</p>
                            <span>{{date('d/m/Y',strtotime($item->created_at))}}</span>
                        </div>
                    </div>
                    <div class="items--docu">
                        <div class="clearfix">
                            <p>Uploaded Person</p>
                            <div class="d-flex align-items-center">
                                <span class="mr-auto">{{ decryptKMSvalues(Auth::user()->name) }}</span>
                                <span class="ml-auto">{{date('d/m/Y',strtotime($item->updated_at))}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="items--docu">
                        <div class="action-icon-doc clearfix">
                            <ul class="p-0">
                            <li>
                                <a href="#" type="button" data-id="{{$item->id}}" data-name="{{$item->document_name}}" data-reviewer="{{decryptKMSvalues($item->user_name)}}" data-document-type="{{$item->document_type_name}}" data-modified-date="{{date('d/m/Y',strtotime($item->updated_at))}}" data-path="{{$item->document_path}}" data-toggle="modal" data-target="#viewDocument" class="document-view">
                                    <img src="{{ asset('img/view-icon.svg') }}" alt="rename-icon" class="img-fluid" />
                                    <p>{{__('documents.list_documents.View')}}</p>
                                </a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
    @endforeach
</ul>

<div class="modal fade view-document" id="viewDocument" tabindex="-1" role="dialog" aria-labelledby="viewDocumentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row  h-100">
          <div class="col-lg-6 col-md-6 col-12 h-100">
            <div class="view-document-left h-100">
              <p>{{__('documents.popup.Document Name')}}: <span id="document-view-name"></span></p>
              <!-- <p>{{__('documents.popup.Document Type')}}: <span id="document-view-type"></span></p>
              <p>{{__('documents.popup.Last Modified')}}: <span id="document-view-date"></span></p>
              <p>{{__('documents.popup.Last Modified By')}} : <span id="document-view-reviewer"></span></p> -->
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

@include('includes/pagination',['data'=>$data])