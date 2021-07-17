@if(isset($mis))
<div class="row col-md-12 mt-4 mis-definition" data-task_mis="{{$mis->id}}" data-list-no="{{$list_no}}" data-parent-field-type="dropdown" data-parent-field-id="3">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-8">
                <h3>Dropdown</h3>
            </div>
            <div class="col-md-4"><span class="delete-left-char pr-4 mis-field-close remove-mis-definition">Delete</span></div>
        </div>
        <div class="row">
            <div class="form-group col-md-7 pr-4"><input class="form-control app-input-default mis-label-title mis-field-validation-error" type="text" placeholder="Title of the field" value="{{$mis->label_title}}" autocomplete="off" />
                <span class="invalid-feedback" role="alert">
                    <strong id="validation-error-message"></strong>
                </span>
            </div>
            <div class="form-group col-md-12 pr-4">
                <textarea class="form-control app-textarea-default mis-field-description mis-field-validation-error" type="text" placeholder="Description of the field">{{$mis->description}}</textarea>
                <span class="invalid-feedback" role="alert">
                    <strong id="validation-error-message"></strong>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-6 mt-5">
        <div class="card-body table-responsive drop-down-table mis-table">
            <table class="table" aria-describedby="mis-dropdown-list">
                <thead>
                    <tr>
                        <th scope="col">Option Name</th>
                        <th scope="col">Expected result</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="mis-field-append-dropdown-option">
                    @foreach($mis->mis_field_contents as $item)
                    <tr class="mis-dropdown-option-list" data-mis_content="{{$item->id}}">
                        <td><input type="text" class="form-control dropdown-option-value" placeholder="Title of the Option" value="{{$item->options}}"></td>
                        <td class="addi-attach"><input type="radio" class="custom-control-input dropdown-option-required rounded-checkbox-grey" @if($item->is_required == 1) checked @endif /></td>
                        <td class="mis-field-close"><span class="delete-left-char float-right">Delete</span></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="mt-2 text-center"><img class="mis-field-add" src="{{env('DOMAIN_URL')}}/img/app/plus-into-red-add-icon.png" alt="" data-append-content="dropdown-option" data-field-type="dropdown-option" data-list-no="{{$list_no}}"></div>
        </div>
    </div>
</div>
@else
<div class="row col-md-12 mt-4 mis-definition" data-parent-field-type="dropdown" data-parent-field-id="3">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-8">
                <h3>Dropdown</h3>
            </div>
            <div class="col-md-4"><span class="delete-left-char pr-4 mis-field-close remove-mis-definition">Delete</span></div>
        </div>
        <div class="row">
            <div class="form-group col-md-7 pr-4"><input class="form-control app-input-default mis-label-title mis-field-validation-error" type="text" placeholder="Title of the field" autocomplete="off" />
                <span class="invalid-feedback" role="alert">
                    <strong id="validation-error-message"></strong>
                </span>
            </div>
            <div class="form-group col-md-12 pr-4">
                <textarea class="form-control app-textarea-default mis-field-description mis-field-validation-error" type="text" placeholder="Description of the field"></textarea>
                <span class="invalid-feedback" role="alert">
                    <strong id="validation-error-message"></strong>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-6 mt-5">
        <div class="card-body table-responsive drop-down-table mis-table">
            <table class="table" aria-describedby="mis-dropdown-list">
                <thead>
                    <tr>
                        <th scope="col">Option Name</th>
                        <th scope="col">Expected result</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="mis-field-append-dropdown-option">
                    <tr class="mis-dropdown-option-list">
                        <td><input type="text" class="form-control dropdown-option-value" placeholder="Title of the Option"></td>
                        <td class="addi-attach"><input type="radio" class="custom-control-input dropdown-option-required rounded-checkbox-grey" /></td>
                        <td class="mis-field-close"><span class="delete-left-char float-right">Delete</span></td>
                    </tr>

                </tbody>
            </table>
            <div class="mt-2 text-center"><img class="mis-field-add" src="{{env('DOMAIN_URL')}}/img/app/plus-into-red-add-icon.png" alt="" data-append-content="dropdown-option" data-field-type="dropdown-option"></div>
        </div>
    </div>
</div>

@endif