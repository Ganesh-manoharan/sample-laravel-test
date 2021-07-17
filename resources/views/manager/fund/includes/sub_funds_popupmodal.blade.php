<div class="modal fade add-department add-subfund FundPopupModal" id="FundPopupModal" tabindex="-1" role="dialog" aria-labelledby="FundPopupModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="fundModalLabel">Create Sub-Fund</h5>
          </div>
          <div class="modal-body">
            <div class="create__client">
              <form name="subfundform" id="subfundform" action="{{ route('funds.sub_fund_save') }}"  method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
                <div class="form-group row">
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="clientName">
                      <label>Sub-Fund Details</label>
                      <input type="hidden" name="editsubfundID" id="editsubfundID" value="{{isset($data->id)?$data->id:''}}"  />
                      <input type="text" name="subfundName" id="subfundName" class="form-control subfundName-validation-error" aria-describedby="subfundName" placeholder="Name" value="{{ isset($data->sub_fund_name)?$data->sub_fund_name:''}}">
                      <span class="invalid-feedback" role="alert">
                        <strong id="subfundName-validation-error-message"></strong>
                      </span>
                      <span class="invalid-feedback" role="alert">
                    <strong id="fundName-validation-error-message"></strong>
                  </span>
                    </div>
                   
                  </div>
                <div class="col-lg-8 col-md-6 col-sm-12"> 
                  <div class="row">
                      
                        <div class="col-lg-6 col-md-6 col-sm-12">
                          <div class="clientName">
                            <label>{{__('funds.popupmodal.Key Contact')}}</label>
                            <input type="text" name="keycontact_subfundName" id="keycontact_subfundName" class="form-control keycontact_clientName" aria-describedby="clientName" placeholder="{{__('funds.popupmodal.Name')}}" value="{{ isset($data['getkeycontactslist'][0]->name)?$data['getkeycontactslist'][0]->name:''}}">
                            <span class="invalid-feedback" role="alert">
                              <strong id="clientName-validation-error-message"></strong>
                            </span>
                          </div>
                          <div class="client_email">
                            <input type="email" name="keycontact_subfundEmail" id="keycontact_subfundEmail" class="form-control" aria-describedby="clientEmail" placeholder="{{__('funds.popupmodal.Email')}}" value="{{ isset($data['getkeycontactslist'][0]->email)?$data['getkeycontactslist'][0]->email:''}}">
                            <span class="invalid-feedback" role="alert">
                              <strong id="email-validation-error-message"></strong>
                            </span>
                          </div>
                          <div class="client_phonenumber">
                            <input type="text" name="keycontact_subfundphonenumber" id="keycontact_subfundphonenumber" class="form-control" aria-describedby="phone_number" placeholder="{{__('funds.popupmodal.Phonenumber')}}" value="{{ isset($data['getkeycontactslist'][0]->phone_number)?$data['getkeycontactslist'][0]->phone_number:''}}">
                            <span class="invalid-feedback" role="alert">
                              <strong id="phonenumber-validation-error-message"></strong>
                            </span>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="clientName">
                          <label>Investment Strategy</label>
                          <textarea class="form-control entity_type"  rows="5" maxlength="500" name="investment_strategy" id="investment_strategy" placeholder="Max 500 Characters">{{ isset($data->investment_strategy)?$data->investment_strategy:'' }}</textarea>
                              </div>
                         </div>
                    </div>
                  </div>
              </div>  

              <div class="form-group row">

              <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="clientName">
              <label>Associated Fund Group</label>
                           <select class="form-group modal-select4 fund_groups-validation-error" name="fund_groups" id="fund_groups" @if(isset($data->fund_group_id)) {{"disabled"}} @endif>
                                 <option value="">Select Fund Group</option>
                                 @if(isset($data->fund_group_id))
                                 @foreach(fundgroupsList() as $list)
                                <option value="{{$list->id}}" @if($list->id==$data->fund_group_id)selected="selected"@endif>{{$list->fund_group_name}}</option>
                                 @endforeach
                                 @else
                                 @foreach(fundgroupsList() as $list)
                                 <option value="{{$list->id}}">{{$list->fund_group_name}}</option>
                                 @endforeach
                                 @endif
                            </select>
                           

                            <span class="invalid-feedback" role="alert">
                            <strong id="fund_groups-validation-error-message"></strong>
                          </span>

                       </div>
                 </div>

              <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="clientName">
                                <label>Investment Manager</label>
                                <input type="text" name="investment_manager" id="investment_manager" class="form-control keycontact_clientName investment_manager-validation-error" aria-describedby="clientName" placeholder="Enter here" value="{{ isset($data->investment_manager)?$data->investment_manager:''}}">
                                <span class="invalid-feedback" role="alert">
                                <strong id="investment_manager-validation-error-message"></strong>
                                </span>
                              </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="clientName task-duedate1 updownbtn common_dropdwn">
                                <label>{{__('funds.popupmodal.Initial Launch Date')}}</label>
                                <input type="text" name="initial_launch_date" class="form-control initial_launch_date-validation-error" id="initial_launch_date" data-value="task-duedate1" placeholder="{{__('funds.popupmodal.Date picker')}}" autocomplete="off" value="{{ isset($data->initial_launch_date)?date('M j, Y', strtotime($data->initial_launch_date)):''}}">
                                <span class="invalid-feedback" role="alert">
                                <strong id="initial_launch_date-validation-error-message"></strong>
                                </span>
                              </div>
                   </div>
                </div>
                </div>
                <div class="modal-footer">
                <button type="submit" name="cancel" class="btn btn-secondary cancelbtn-client" data-dismiss="modal">{{__('clients.popupmodal.Cancel')}}</button>
                <button  type="button" data-value="subfunddetails" id="submitBtn" class="btn btn-primary FormsubmitBtn">{{__('clients.popupmodal.Confirm')}}</button>
                <button hidden type="submit" id="subfundsubmitBtn" class="btn btn-primary">{{__('clients.popupmodal.Confirm')}}</button>
              </div>
              </form>
            </div>
          </div>
         
        </div>
      </div>
      