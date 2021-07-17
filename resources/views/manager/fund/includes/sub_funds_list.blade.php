@foreach($data as $item)
<li>
    <div class="d-flex align-items-center">
        <div class="frm-clients funds">
            <p>Sub-Fund Name</p>
            <span>{{$item->sub_fund_name}}</span>
        </div>
        <div class="frm-clients-subfunds funds">
            <p>Fund Group</p>
            <span class="entity_type">{{$item->fund_group_name}}</span>
        </div>

        <div class="frm-clients-subfunds funds">
            <p>Investment Manager</p>
            <span>{{$item->investment_manager}}</span>
        </div>

        <div class="frm-clients-subfunds funds">
            <p>Initial Launch Date</p>
            <span>{{ isset($item->sub_funds_launch_date)?date('M j, Y', strtotime($item->sub_funds_launch_date)):''}}</span>
        </div>

        <div class="action_item">
            <div class="view_item">
                <p><a href="{{  url(route('funds.viewsubfunddetails',['id'=>$item->subfundid])) }}"><img src="{{ asset('/img/view-icon.svg') }}" alt="view" /></a></p>
                <span>{{__('clients.view_details.View')}}</span>
            </div>
            <div class="delete_item">
                <p><a class="deleterecords" data-toggle="modal" data-target-action="{{ url(route('funds.deletesubfundrecord',['id'=>$item->subfundid])) }}" data-target="#deletesubfundModal"><img src="{{ asset('/img/delete__icon.svg') }}" alt="delete" /></a>
                <p>
                    <span>{{__('clients.view_details.Delete')}}</span>
            </div>
        </div>
    </div>
</li>
@endforeach