<div class="modal fade add-department client-add-model commonmodal" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="departModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="departModalLabel">{{__('clients.popupmodal.Create Client')}}</h5>
          </div>
          <div class="modal-body">
            <div class="create__client">
              <form id="clientform" name="clientform" action="{{ route('clients.client_save') }}"  method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
                <div class="form-group row">
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="clientName">
                      <label>{{__('clients.popupmodal.Client Details')}}</label>
                      <input type="hidden" name="editclientID" id="editclientID"  />
                      <input type="text" name="clientName" id="clientName" class="form-control clientName-validation-error" aria-describedby="clientName" placeholder="{{__('clients.popupmodal.Name')}}">
                      <span class="invalid-feedback" role="alert">
                    <strong id="clientName-validation-error-message"></strong>
                  </span>
                    </div>
                    <div class="client_email">
                      <input type="email" name="clientEmail" id="clientEmail" class="form-control clientEmail-validation-error" aria-describedby="clientEmail" placeholder="{{__('clients.popupmodal.Email')}}">
                      <span class="invalid-feedback" role="alert">
                    <strong id="clientEmail-validation-error-message"></strong>
                  </span>
                    </div>
                    <div class="clientDescribe">
                      <textarea class="form-control"  rows="3" name="shortDescriptions" id="shortDescriptions" placeholder="{{__('clients.popupmodal.Short Client Description')}}"></textarea>
                      <span class="invalid-feedback" role="alert">
                    <strong id="shortDescriptions-validation-error-message"></strong>
                  </span>
                    </div>
                    <!-- <div class="deadline">
                    <input type="text" name="deadline_priority" id="deadline_priority" class="form-control deadline_priority-validation-error" aria-describedby="deadline_priority" placeholder="Deadline Priority Days">
                    <span class="invalid-feedback" role="alert">
                    <strong id="deadline_priority-validation-error-message"></strong>
                  </span>
                    </div> -->
                  </div>
                  <div class="col-lg-8 col-md-6 col-sm-12"> 
                    <div class="row">

                    @for($i=1;$i<=2;$i++)
                    <input type="hidden" name="keyclientID[]" id="keyclientID{{$i}}"  />
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="clientName">
                          <label>{{__('clients.popupmodal.Key Contact')}}</label>
                          <input type="text" name="keycontact_clientName[]" id="keycontact{{$i}}_clientName" class="form-control keycontact{{$i}}_clientName" aria-describedby="clientName" placeholder="{{__('clients.popupmodal.Name')}}">
                          <span class="invalid-feedback" role="alert">
                            <strong id="clientName-validation-error-message"></strong>
                          </span>
                        </div>
                        <div class="client_email">
                          <input type="email" name="keycontact_clientEmail[]" id="keycontact{{$i}}_clientEmail" class="form-control" aria-describedby="clientEmail" placeholder="{{__('clients.popupmodal.Email')}}">
                          <span class="invalid-feedback" role="alert">
                            <strong id="email-validation-error-message"></strong>
                          </span>
                        </div>
                        <div class="client_phonenumber">
                          <input type="text" name="keycontact_clientphonenumber[]" id="keycontact{{$i}}_clientphonenumber" class="form-control" aria-describedby="phone_number" placeholder="{{__('clients.popupmodal.Phonenumber')}}">
                          <span class="invalid-feedback" role="alert">
                            <strong id="phonenumber-validation-error-message"></strong>
                          </span>
                        </div>
                      </div>
                    @endfor
                    
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="uploadclient_logo">
                      <label>{{__('clients.popupmodal.Client Logo')}}</label>
                      <div class="form-group clients-modal-upload-file row">
                          <div class="upload-logo col-md-6" id="hideupload">
                              <img type="button" src="{{ asset('/img/upload-image-icon.png') }}" alt="" for="client-icon">
                              <p>{{__('clients.popupmodal.Upload Logo')}}</p>
                          </div>
                          <input type="hidden" name="aws_url" id="aws_url" value="{{env('AWS_URL')}}" />
                          <div class="hover-effect">
                            <div class="col-md-6" id="imagePreview" hidden>
                                <img type="button" src="" alt="" class="imagePreview-icon">
                            </div>
                            <div class="image-hover-eit">
                              <div class="edit-button">
                                <a class="btn btn-secondary edit-btn"><img src="{{ asset('/img/edit-img.png') }}" alt=""></a>
                               </div>
                            </div>
                           
                          </div>
                          <span class="invalid-feedback" role="alert">
                              <strong id="department_icon-validation-error-message"></strong>
                          </span>
                      </div>
                     <p class="fileformats">({{__('documents.popup.Supported formats')}}:jpg,jpeg,png,gif)</p>
                      <input hidden id="department-icon" name="department-icon" class="form-control department_icon-validation-error client-upload-logo-input" type="file" />
                      <input hidden type="text" name="upload_icon" />
                      <span id="companyimage_status" class="companyimage_status"></span>
                    </div>
                  </div>
                 
                  <div class="col-lg-8 col-md-6 col-sm-12">
                    <div class="uploadclient_logo">
                      <label>{{__('clients.popupmodal.Regulated Status')}}</label>
                      <textarea maxlength="50" class="form-control clients_regulated_status"  rows="3" name="regulated_status" id="regulated_status" placeholder="{{__('clients.popupmodal.Max 50 characters')}}"></textarea>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">                    
                    <div class="clientName mt-4">
                        <label>{{__('clients.popupmodal.Restricted Departments')}}</label>
                        <div class="d-flex">
                          <div class="team__member">
                            <select class="form-control modal-select3 all_users" id="clientpopup-departments">
                            <option value="" selected="selected" disabled>{{__('clients.popupmodal.Departments')}}</option>
                                @foreach($department_listnot_in_selecteditem as $item)
                                <option value="{{$item->id}}"> {{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="listDepartment dept">
                            <ul></ul>
                          </div>
                           <div class="departments_list clients_departments-validation-error">
                          
                            </div>
                             <span class="invalid-feedback" role="alert">
                               <strong id="clients_departments-validation-error-message"></strong>
                             </span> 

                          </div>
                        </div>
                    </div>   
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">        
                    <div class="clientName mt-4">
                        <label>{{__('clients.popupmodal.Restricted Fund Groups')}}</label>
                        <div class="d-flex">
                          <div class="team__member">
                            <select class="form-control modal-select3  all_users" id="clientpopup-fund_groups">
                            <option value="" selected="selected" disabled>{{__('clients.popupmodal.Fund Groups')}}</option>
                              @foreach($fundgroups_listnot_in_selecteditem as $item)
                              <option value="{{$item->id}}">{{$item->fund_group_name}}</option>
                              @endforeach
                            </select>
                            <div class="listDepartment fund_groups dep-list">
                              <ul class="displaylist"></ul>
                            </div>
                            <div class="fund_groups-input clients_fundgroups-validation-error">
                            </div>
                             <span class="invalid-feedback" role="alert">
                            <strong id="clients_fundgroups-validation-error-message"></strong>
                          </span> 
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                <button type="submit" name="cancel" class="btn btn-secondary cancelbtn-client" data-dismiss="modal">{{__('clients.popupmodal.Cancel')}}</button>
                <button type="button" data-value="clientdetails"  class="btn btn-primary FormsubmitBtn">{{__('clients.popupmodal.Confirm')}}</button> 
                 <button hidden type="submit" id="clientsubmitBtn" class="btn btn-primary">{{__('clients.popupmodal.Confirm')}}</button>
              </div>
              </form>
            </div>
          </div>
         
        </div>
      </div>
    </div>