@if(isset($mis))
<div class="col-md-6 mt-4 mis-definition" data-task_mis="{{$mis->id}}" data-parent-field-type="number" data-parent-field-id="2">
    <div class="row">
        <div class="col-md-8">
            <h3>Number</h3>
        </div>
        <div class="col-md-4"><span class="mis-field-close delete-left-char remove-mis-definition" style="float:right">Delete</span></div>
    </div>
    <div class="row">
        <div class="form-group col-md-7"><input class="form-control app-input-default mis-label-title mis-field-validation-error" type="text" placeholder="Title of the field" value="{{$mis->label_title}}"  autocomplete="off" />
            <span class="invalid-feedback" role="alert">
                <strong id="validation-error-message"></strong>
            </span>
        </div>
        <div class="form-group col-md-5 pl-5"><input class="form-control app-input-default mis-field-min-value mis-field-validation-error" type="text" id="min-value" placeholder="Minimum Value" value="{{$mis->mis_field_contents[0]->min_value}}" data-mis_content="{{$mis->mis_field_contents[0]->id}}" autocomplete="off" />
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
<div class="col-md-6 mt-4 mis-definition" data-parent-field-type="number" data-parent-field-id="2">
    <div class="row">
        <div class="col-md-8">
            <h3>Number</h3>
        </div>
        <div class="col-md-4"><span class="mis-field-close delete-left-char remove-mis-definition" style="float:right">Delete</span></div>
    </div>
    <div class="row">
        <div class="form-group col-md-7"><input class="form-control app-input-default mis-label-title mis-field-validation-error" type="text" placeholder="Title of the field"  autocomplete="off" />
            <span class="invalid-feedback" role="alert">
                <strong id="validation-error-message"></strong>
            </span>
        </div>
        <div class="form-group col-md-5 pl-5"><input class="form-control app-input-default mis-field-min-value mis-field-validation-error" type="text" id="min-value" placeholder="Minimum Value" autocomplete="off" />
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