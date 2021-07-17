@if(isset($mis))
<div class="col-md-6 mt-4 mis-definition" data-task_mis="{{$mis->id}}" data-parent-field-type="text" data-parent-field-id="1">
    <div class="row">
        <div class="col-md-8">
            <h3>Text</h3>
        </div>
        <div class="col-md-4"><span class="mis-field-close delete-left-char remove-mis-definition" style="float:right">Delete</span></div>
    </div>
    <div class="row">
        <div class="form-group col-md-7"><input class="form-control app-input-default mis-label-title mis-field-validation-error" type="text" placeholder="Title of the field" value="{{$mis->label_title}}" autocomplete="off" />
            <span class="invalid-feedback" role="alert">
                <strong id="validation-error-message"></strong>
            </span>
        </div>
        <div class="form-group col-md-12">
            <textarea class="form-control app-textarea-default mis-field-description mis-field-validation-error" type="text" placeholder="Description of the field">{{$mis->description}}</textarea>
            <span class="invalid-feedback" role="alert">
                <strong id="validation-error-message"></strong>
            </span>
        </div>
    </div>
</div>
@else
<div class="col-md-6 mt-4 mis-definition" data-parent-field-type="text" data-parent-field-id="1">
    <div class="row">
        <div class="col-md-8">
            <h3>Text</h3>
        </div>
        <div class="col-md-4"><span class="mis-field-close delete-left-char remove-mis-definition" style="float:right">Delete</span></div>
    </div>
    <div class="row">
        <div class="form-group col-md-7"><input class="form-control app-input-default mis-label-title mis-field-validation-error" type="text" placeholder="Title of the field" autocomplete="off" />
            <span class="invalid-feedback" role="alert">
                <strong id="validation-error-message"></strong>
            </span>
        </div>
        <div class="form-group col-md-12">
            <textarea class="form-control app-textarea-default mis-field-description mis-field-validation-error" type="text" placeholder="Description of the field"></textarea>
            <span class="invalid-feedback" role="alert">
                <strong id="validation-error-message"></strong>
            </span>
        </div>
    </div>
</div>
@endif