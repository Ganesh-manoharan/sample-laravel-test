@foreach($data as $item)
<li>
    <div class="d-flex align-items-center">
        <div class="frm-clients-logo">
           <p class="semi-bold"><img class="client-img" src="@if(isset($item->client_logo)){{ env('AWS_URL').'/'.$item->client_logo }}@else{{ asset('img/user-avatar.png') }} @endif" alt=""></p>
        </div>
        <div class="frm-clients">
            <p>{{__('clients.view_details.Client Name')}}</p>
            <span>{{$item->client_name}}</span>
        </div>
        <div class="frm-clients-subfunds">
            <p>{{__('clients.view_details.Fund Groups')}}</p>
            <span>{{count($item->client_fundgroups_count)}}</span>
        </div>
        <div class="frm-clients-subfunds">
            <p>{{__('clients.view_details.Sub-Funds')}}</p>
            <span>{{count($item->client_sub_funds_count)}}</span>
        </div>
        <div class="action_item">
            <div class="view_item">
                <p><a href="{{  url(route('clients.viewclientdetails',['id'=>$item->id])) }}"><img src="{{ asset('/img/view-icon.svg') }}" alt="view" /></a></p>
                <span>{{__('funds.view_details.View')}}</span>
            </div>
            @can('manager-only',Auth::user())
            <div class="delete_item">
                <p><a class="deleterecords" data-toggle="modal" data-target-action="{{ url(route('clients.deletethesingleclientrecord',['id'=>$item->id])) }}" data-target=".deleteclientModal"><img src="{{ asset('/img/delete__icon.svg') }}" alt="delete" /></a></p>
                <span>{{__('funds.view_details.Delete')}}</span>
            </div>
            @endcan
        </div>

    </div>
</li>
@endforeach