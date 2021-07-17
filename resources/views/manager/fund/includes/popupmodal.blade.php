<div class="modal fade add-department add-fundgroup FundPopupModal" id="FundPopupModal" tabindex="-1" role="dialog" aria-labelledby="FundPopupModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="fundModalLabel">{{__('funds.popupmodal.Create Fund')}}</h5>
          </div>
          <div class="modal-body">
            <div class="create__client">
              <form name="fundform" id="fundform" action="{{ route('funds.fund_save') }}"  method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
                <div class="form-group row">
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="clientName">
                      <label>{{__('funds.popupmodal.Fund Details')}}</label>
                      <input type="hidden" name="editfundID" id="editfundID" value="{{isset($fund_data->id)?$fund_data->id:''}}"  />
                      <input type="text" name="fundName" id="fundName" class="form-control fundName-validation-error" aria-describedby="fundName" placeholder="{{__('funds.popupmodal.Name')}}" value="{{isset($fund_data->fund_group_name)?$fund_data->fund_group_name:''}}">
                      <span class="invalid-feedback" role="alert">
                    <strong id="fundName-validation-error-message"></strong>
                  </span>
                    </div>
                    <div class="clientDescribe">
                      <textarea class="form-control registeredAddress-validation-error"  rows="3" name="registeredAddress" id="registeredAddress" placeholder="{{__('funds.popupmodal.Registered Address')}}">{{ isset($fund_data->registered_address)?$fund_data->registered_address:'' }}</textarea>
                      <span class="invalid-feedback" role="alert">
                    <strong id="registeredAddress-validation-error-message"></strong>
                  </span>
                  </div>
                  </div>
                <div class="col-lg-8 col-md-6 col-sm-12"> 
                  <div class="row">
                      <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="clientName">
                          <label>{{__('funds.popupmodal.Entity Type')}}</label>
                          <textarea class="form-control entity_type"  rows="5" maxlength="250" name="Entity_type" id="Entity_type" placeholder="{{__('funds.popupmodal.Max 250 characters')}}">{{isset($fund_data->entity_type)?$fund_data->entity_type:''}}</textarea>
                              </div>
                         </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                          <div class="clientName">
                            <label>{{__('funds.popupmodal.Key Contact')}}</label>
                            <input type="text" name="keycontact_fundName" id="keycontact_fundName" class="form-control keycontact_clientName" aria-describedby="clientName" placeholder="{{__('funds.popupmodal.Name')}}" value="{{ isset($fund_data['getkeycontactslist'][0]->name)?$fund_data['getkeycontactslist'][0]->name:''}}">
                            <span class="invalid-feedback" role="alert">
                              <strong id="clientName-validation-error-message"></strong>
                            </span>
                          </div>
                          <div class="client_email">
                            <input type="email" name="keycontact_fundEmail" id="keycontact_fundEmail" class="form-control keycontact_fundEmail-validation-error" aria-describedby="clientEmail" placeholder="{{__('funds.popupmodal.Email')}}" value="{{ isset($fund_data['getkeycontactslist'][0]->email)?$fund_data['getkeycontactslist'][0]->email:''}}">
                            <span class="invalid-feedback" role="alert">
                              <strong id="keycontact_fundEmail-validation-error-message"></strong>
                            </span>
                          </div>
                          <div class="client_phonenumber">
                            <input type="text" name="keycontact_fundphonenumber" id="keycontact_fundphonenumber" class="form-control" aria-describedby="phone_number" placeholder="{{__('funds.popupmodal.Phonenumber')}}" value="{{ isset($fund_data['getkeycontactslist'][0]->phone_number)?$fund_data['getkeycontactslist'][0]->phone_number:''}}">
                            <span class="invalid-feedback" role="alert">
                              <strong id="phonenumber-validation-error-message"></strong>
                            </span>
                          </div>
                        </div>
                    </div>
                  </div>
              </div>  
                  <div class="form-group row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                              <div class="clientName">
                                <label>{{__('funds.popupmodal.Other Details')}}</label>
                                <input type="text" name="management" id="management" class="form-control keycontact_clientName" aria-describedby="clientName" placeholder="{{__('funds.popupmodal.Management Company')}}" value="{{isset($fund_data->management)?$fund_data->management:''}}">
                                <span class="invalid-feedback" role="alert">
                                </span>
                              </div>
                              <div class="client_email">
                                <input type="text" name="administrator" id="administrator" class="form-control" aria-describedby="administrator" placeholder="{{__('funds.popupmodal.Administrator')}}" value="{{isset($fund_data->administrator)?$fund_data->administrator:''}}">
                                <span class="invalid-feedback" role="alert">
                                </span>
                              </div>
                              <div class="client_phonenumber">
                                <input type="text" name="depository" id="depository" class="form-control" aria-describedby="depository" placeholder="{{__('funds.popupmodal.Depositary')}}"  value="{{isset($fund_data->depository)?$fund_data->depository:''}}">
                                <span class="invalid-feedback" role="alert">
                                </span>
                              </div>
                              <div class="client_phonenumber">
                                <input type="text" name="auditor" id="auditor" class="form-control" aria-describedby="auditor" placeholder="{{__('funds.popupmodal.Auditor')}}" value="{{isset($fund_data->auditor)?$fund_data->auditor:''}}">
                                <span class="invalid-feedback" role="alert">
                                </span>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                              <div class="clientName task-duedate  updownbtn common_dropdwn">
                                <label>{{__('funds.popupmodal.Accounting Year End')}}</label>                                                                                                                                       
                                <input type="text" name="date" class="form-control" id="datepicker" data-value="task-due-date" placeholder="{{__('funds.popupmodal.Date picker')}}" autocomplete="off" value="{{ isset($fund_data->accounting_year_end)?date('M j, Y', strtotime($fund_data->accounting_year_end)):''}}">
                                </span>
                              </div>
                              <div class="clientName">
                                  <div class="clientName mt-4">
                                    <label>{{__('funds.popupmodal.Jurisdiction')}}</label>
                                    <div class="d-flex">
                                      <div class="team__member">
                                        <select class="form-control select2 all_users modal-select4" name="country" id="country">
                                          <option value="" selected>{{__('funds.popupmodal.Country dropdown')}}</option>
                                          @if(isset($fund_data['getcountrylist']->id))
                                            @foreach(countryList() as $list)
                                              <option value="{{$list->id}}" @if($list->id==$fund_data['getcountrylist']->id)selected="selected"@endif>{{$list->country_name}}</option>
                                            @endforeach
                                          @else
                                          @foreach(countryList() as $list)
                                              <option value="{{$list->id}}">{{$list->country_name}}</option>
                                            @endforeach
                                      @endif
                                        </select>
                                      </div>
                                    </div>
                                </div>
                              </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                              <div class="clientName task-duedate1 updownbtn common_dropdwn">
                                <label>{{__('funds.popupmodal.Initial Launch Date')}}</label>
                                <input type="text" name="initial_launch_date" class="form-control" id="initial_launch_date" data-value="task-duedate1" placeholder="{{__('funds.popupmodal.Date picker')}}" autocomplete="off" value="{{ isset($fund_data->initial_launch_date)?date('M j, Y', strtotime($fund_data->initial_launch_date)):''}}">
                                </span>
                              </div>
                            </div>


                       </div>
                  </div>

                </div>
                <div class="modal-footer">
                <button type="button" name="cancel" class="btn btn-secondary cancelbtn-client" data-dismiss="modal">{{__('clients.popupmodal.Cancel')}}</button>
                <button type="button" data-value="funddetails"  class="btn btn-primary FormsubmitBtn">{{__('clients.popupmodal.Confirm')}}</button>
                <button hidden type="submit" id="fundsubmitBtn" class="btn btn-primary">{{__('clients.popupmodal.Confirm')}}</button>
              </div>
              </form>
            </div>
          </div>
         
        </div>
      