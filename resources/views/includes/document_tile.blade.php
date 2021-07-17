<div class="document-tile-card {{$width}}">
    <div class="viewdoc-section viewdoc-id-{{$id}}">
        <div class="row align-items-center">
            <div class="col-md-5 selected-doc-tile-img">
                <div class="document-thumbnail-{{$id}} canvas-content" id="document-thumbnail-{{$id}}">
                </div>
                <span class="document-filename" data-filename="{{$name}}" style="white-space: nowrap;">{{ Str::limit($name, 15) }}</span>
                <input type="text" hidden class="canvas-base64-image" id="canvas-base64-image-{{$id}}">
            </div>
            <div class="col-md-7 selected-doc-tile">
                <p>{{__('task_creation.Taskdetails_attachdocumentation_modal.Document Name')}}: {{ Str::limit($title, 15) }}</p>
                <p>{{__('task_creation.Taskcreation_steptwo.All or Selection')}}: <span id="document-selection-type-{{$id}}"></span></p>
                <p id="selection-content-{{$id}}" hidden>Selection: <span id="document-selection-content-string-{{$id}}"></span></p>
                <button type="button" class="btn btn-primary doc-view-btn mt-3 select-suggest" data-id="{{$id}}" data-toggle="modal" data-target="#exampleModalCenter">View</button>
            </div>
        </div>
        <span class="close-item selected-doc-clear" data-id="{{$id}}"><em class="fas fa-times"></em></span>
    </div>
</div>