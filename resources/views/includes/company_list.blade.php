<div class="teams-main-content-scroll data-append">
<ul class="teams-child-content-scroll p-0 search-module-append">
@foreach($data as $item)
            <li>
              <div class="card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-lg-4 col-md-3 col-sm-12">
                      <div class="d-flex align-items-center">
                        <div class="admin-user-img">
                          <img src="{{ isset($item->company_logo)?env('AWS_URL').'/'.$item->company_logo:'' }}" alt="user profile" class="img-fluid"/>
                        </div>
                        <div class="admin-invest-type">
                          <h1>{{$item->company_name}}</h1>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                      <div class="admin-user-type">
                        <h2>System Admin</h2>
                        @php $i=0 @endphp
                        @foreach($item['companyusers'] as $list)
                        @if($i==0)
                        <p>{{decryptKMSvalues($list->name)}}</p>
                          @endif
                       @php $i++ @endphp
                       @endforeach
                       
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                      <div class="sys-admin">
                        <h2>Date Created</h2>
                        <p>{{ isset($item->created_at)?date('M j, Y', strtotime($item->created_at)):''}}</p>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                      <div class="action-admin">
                        <div class="d-flex">
                        
                          <div class="col-lg-6 col-md-12 col-sm-12">
                          <div class="view_item_companylist">
                            <p><a href="{{  url(route('viewcompanydetails',['id'=>$item->id])) }}"><img src="{{ asset('/img/view-icon.svg') }}" alt="view" /></a></p>
                            <span>{{__('funds.view_details.View')}}</span>
                           </div>
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12">
                          <div class="delete_item_companylist">
                            <p><a class="deleterecords" data-toggle="modal" data-target=".deleteclientModal" data-target-action="{{ url(route('clients.deletecompany',['id'=>$item->id])) }}"><img src="{{ asset('/img/delete__icon.svg') }}" alt="delete" /></a></p>
                          <span>{{__('funds.view_details.Delete')}}</span>
                          </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            @endforeach
</ul>
</div>