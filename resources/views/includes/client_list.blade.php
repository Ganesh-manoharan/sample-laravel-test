<div id="collapseExample2" class="collapse show">
  <div class="card">
    <ul class="awaiting-approval">

      @foreach($data as $list)

      <li>
        <div class="d-flex align-items-center">
          <div class="frm-clients-logo">
            <p class="semi-bold"><img class="client-img" src="@if(isset($list->client_logo)){{ env('AWS_URL').'/'.$list->client_logo }}@else{{ asset('img/user-avatar.png') }} @endif" alt=""></p>
          </div>
          <div class="frm-clients">
            <p>{{__("clients.view_details.Client Name")}}</p> 
            <span>{{$list->client_name}}</span>
          </div>

          <div class="frm-clients-assignedto">
            <p>{{__("clients.view_details.Assigned to")}}: </p>
            <span>{{$list->description}}</span>
          </div>
          <div class="frm-clients-subfunds">
            <p>{{__('clients.view_details.Sub-Funds')}}</p>
            <span></span>
          </div>
          <div class="action_item">
            <div class="view_item">
              <p><a href="{{  url(route('clients.viewclientdetails',['id'=>$list->id])) }}"><img src="{{ asset('/img/view-icon.svg') }}" alt="view" /></a></p>
              <span>{{__('clients.view_details.View')}}</span>
            </div>
            <div class="delete_item">
              <p><img src="{{ asset('/img/delete__icon.svg') }}" alt="delete" /></p>
              <span>{{__('clients.view_details.Delete')}}</span>
            </div>
          </div>
        </div>
      </li>
      @endforeach
    </ul>
  </div>
</div>