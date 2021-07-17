<ul class="p-0">
    @foreach($data as $item)
    <li>
        <div class="card">
            <div class="card-body">
                <div class="document-divi-item row">
                    <div class="col-lg-2 col-md-2 items--docu">
                        <div class="pdf-document-item clearfix d-flex align-items-center">
                            <img src="{{ asset('img/pdf-document.svg') }}" alt="PDF document" class="img-fluid mr-4" />
                            <h1 id="document-name-{{$item->id}}">{{$item->document_name}}</h1>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 items--docu">
                        <div class="clearfix">
                            <p>{{__('documents.list_documents.Document Type')}}</p>
                            <span>{{$item->document_type_name}}</span>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1 pl-0 items--docu ">
                        <div class="clearfix">
                            <p>{{__('documents.list_documents.Last Review Date')}}</p>
                            <span>{{date('d/m/Y',strtotime($item->updated_at))}}</span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 items--docu">
                        <div class="clearfix">
                            <p>{{__('documents.list_documents.Last Review Person')}}</p>
                            <div class="d-flex align-items-center">
                                <span class="mr-auto">{{decryptKMSvalues($item->user_name)}}</span>
                                <!-- <span class="ml-auto">{{date('d/m/Y',strtotime($item->updated_at))}}</span> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 items--docu">
                        <div class="action-icon-doc clearfix">
                            <ul class="p-0">
                                <li>
                                    <a href="#" id="document-rename" data-id="{{$item->id}}" data-value="{{$item->document_name}}" type="button" data-toggle="modal" data-target="#updateNameDocument">
                                        <img src="{{ asset('img/rename.svg') }}" alt="rename-icon" class="img-fluid" />
                                        <p>{{__('documents.list_documents.Rename')}}</p>
                                    </a>
                                </li>
                                <li>
                                <a href="#" type="button" data-id="{{$item->id}}" data-name="{{$item->document_name}}" data-reviewer="{{decryptKMSvalues($item->user_name)}}" data-document-type="{{$item->document_type_name}}" data-modified-date="{{date('d/m/Y',strtotime($item->updated_at))}}" data-path="{{$item->document_path}}" data-toggle="modal" data-target="#viewDocument" class="document-view">
                                    <img src="{{ asset('img/view-icon.svg') }}" alt="rename-icon" class="img-fluid" />
                                    <p>{{__('documents.list_documents.View')}}</p>
                                </a>
                                </li>
                                <li>
                                <a class="deleterecords" data-target-action="{{ url(route('delete_documents',['id'=>$item->id])) }}" type="button" data-toggle="modal" data-target="#deletedocumentModal">
                                    <img src="{{ asset('img/delete__icon.svg') }}" alt="rename-icon" class="img-fluid" />
                                    <p>{{__('documents.list_documents.Delete')}}</p>
                                </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 items--docu">
                        <div class="clearfix">
                            <button id="document-reupdate" data-href="{{ url('/') }}" type="button" data-id="{{$item->id}}" data-name="{{$item->document_name}}" data-reviewer="{{decryptKMSvalues($item->user_name)}}" data-document-type="{{$item->document_type_name}}" data-modified-date="{{date('d/m/Y',strtotime($item->updated_at))}}" data-path="{{$item->document_path}}" data-toggle="modal" data-target="#uploadDocument" class="btn update-document-btn list-tasks">{{__('documents.list_documents.Update')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
    @endforeach
</ul>
