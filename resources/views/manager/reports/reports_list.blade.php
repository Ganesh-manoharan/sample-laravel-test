@foreach($data as $item)
<li>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="report-name-item">
                        <h1>Report Name</h1>
                        <span>{{$item->name}}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="report-frequency">
                        <h1>Frequency</h1>
                        <span>{{$item->frequency}}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="report-frequency">
                        <h1>Lastrun</h1>
                        <span>{{$item->last_run}}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="report-action">
                        <a href="{{ route('viewreportdetails',['id'=>$item->id])}}"><img src="{{ asset('/img/view-icon.svg') }}" alt="view" />View</a>
                        <a class="deleterecords" data-toggle="modal" data-target-id="{{$item->id}}" data-target-action="{{ url(route('deletereports',['id'=>$item->id])) }}" data-target=".deletereportModal"><img src="{{ asset('/img/delete__icon.svg') }}" alt="delete" />Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>
@endforeach