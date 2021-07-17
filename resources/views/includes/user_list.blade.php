
<div id="collapseExample2" class="collapse show">
    <div class="card-body">
        <ul class="depart-itemtable user-list-all">
            @foreach($data as $list)
            <li>
                <div class="d-flex align-items-center">
                    <div class="col-md-2">
                        <img src="{{ env('AWS_URL').'/'.$list->avatar }}" alt="icon">
                    </div>
                    <div class="col-md-3">
                        <p class="dep_title">{{decryptKMSvalues($list->name)}}</p>
                        <span>{{$list->user_roles->name}}</span>
                    </div>
                    <div class="col-md-3">
                        <p>{{__('teams.User.User Type')}}</p>
                        <span>{{$list->user_roles->name}}</span>
                    </div>
                
                    <div class="col-md-2 text-center">
                        <a href="{{route('teams.user_profile',['id'=>$list->id])}}">
                        <p class="text-center"><img class="users-view-img" src="{{ asset('/img/view_eye.png') }}" alt=""></em></p>
                        <span>{{__('teams.User.View')}}</span>
                        </a>
                    </div>
                  

                    <div class="col-md-2 delete_item">
                    <p><a class="deleterecords" data-toggle="modal" data-target-action="{{ url(route('teams.delete_company_user',['id'=>$list->id]))}}" data-target="#deleteuserModal"><img src="{{ asset('/img/delete__icon.svg') }}" class="users-view-img" alt="delete"/></a><p>
                     <span>{{__('teams.User.Delete')}}</span>
                   </div>
                    
                </div>
            </li>
            @endforeach

        </ul>
    </div>
    <div class="modal fade deleteuserModal" id="deleteuserModal" tabindex="-1" role="dialog" aria-labelledby="deleteuserModal" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <form method="GET" action="" class="modal-approveall">
                          {{ csrf_field() }}
                          <div class="modal-content">
                            <div class="modal-body">
                              <h3>{{__('clients.view_details.Do you want to delete the record')}}?</h3>
                              <div class="bottom__btn">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('awaiting_approval.Popupmodal.CANCEL')}}</button>
                                <button type="submit" id="delete-clients-confmbtn" class="btn btn-primary pdfmodal-save">{{__('awaiting_approval.Popupmodal.CONFIRM')}}</button>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                  </div>
</div>