@foreach($data as $item)
<li>
    <div class="d-flex align-items-center">
        <div class="frm-clients funds">
            <p>{{__('funds.view_details.Fund Entity')}}</p>
            <span>{{$item->fund_group_name}}</span>
        </div>

        <div class="frm-clients-subfunds funds">
            <p>{{__('funds.view_details.Entity Type')}}</p>
            <span class="entity_type">{{$item->entity_type}}</span>
        </div>

        <div class="frm-clients-subfunds funds">
            <p>{{__('clients.view_details.Sub-Funds')}}</p>
            <span>{{ count($item->getsubfundslist) }}</span>
        </div>

        <div class="action_item">
            <div class="view_item">
                <p><a href="{{  url(route('funds.viewfunddetails',['id'=>$item->id])) }}"><img src="{{ asset('/img/view-icon.svg') }}" alt="view" /></a></p>
                <span>{{__('clients.view_details.View')}}</span>
            </div>
            <div class="delete_item">
                <p><a class="deleterecords" data-target-action="{{ url(route('funds.deletethesinglefundrecord',['id'=>$item->id])) }}" data-toggle="modal" data-target="#deletefundModal"><img src="{{ asset('/img/delete__icon.svg') }}" alt="delete" /></a></p>
                <span>{{__('clients.view_details.Delete')}}</span>
            </div>
        </div>
    </div>
</li>
@endforeach