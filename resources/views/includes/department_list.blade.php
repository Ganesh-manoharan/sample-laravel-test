<div id="collapseExample2" class="collapse show">
    <div class="card-body">
        <ul class="depart-itemtable">
            @foreach($data as $list)
            <li>
                <div class="d-flex align-items-center">
                    <div class="col-md-1">
                        <img src="@if(!is_null($list->department_manager)) {{ env('AWS_URL').'/'.$list->department_manager->avatar }} @endif " alt="icon">
                    </div>
                    <div class="col-md-2 {{$click_on_list ?? ''}} cursor-pointer" data-id="{{$list->id}}">
                        <p class="dep_title">{{__('home_manager.Department.Title')}}</p>
                        <span>{{$list->name}}</span>
                    </div>
                    <div class="col-md-2">
                        <p>{{__('home_manager.Department.Dep Manager')}}</p>
                        <span>@if(!is_null($list->department_manager)){{ $list->department_manager->name}}@endif</span>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex">
                            <div class="cricle">
                                <span class="success"><a href="{{ route('task',['status'=>0,'filter'=>1,'filter_name'=>'Active','type'=>base64_encode(strtolower('task')),'department_filter'=>$list->id,'department'=>$list->name]) }}">{{$list['info']['active']}}</a></span>
                                <span class="text-center">{{__('home_manager.Department.On Track')}}</span>
                            </div>
                            <div class="cricle">
                            <span class="warning">
                            <a href="{{ route('task',['status'=>0,'filter'=>2,'filter_name'=>'Urgent','type'=>base64_encode(strtolower('task')),'department_filter'=>$list->id,'department'=>$list->name]) }}">{{$list['info']['urgent']}}</a></span>
                                <span class="text-center">{{__('home_manager.Department.Urgent')}}</span>
                            </div>
                            <div class="cricle">
                            <span class="danger"><a href="{{ route('task',['status'=>0,'filter'=>3,'filter_name'=>'Overdue','type'=>base64_encode(strtolower('task')),'department_filter'=>$list->id,'department'=>$list->name]) }}">{{$list['info']['overdue']}}</a></span>
                                <span class="text-center">{{__('home_manager.Department.Overdue')}}</span>
                            </div>
                            <div class="cricle">
                            <span class="completed"><a href="{{ route('task',['status'=>1,'filter'=>4,'filter_name'=>'Completed','type'=>base64_encode(strtolower('task')),'department_filter'=>$list->id,'department'=>$list->name]) }}">{{$list['info']['completed']}}</a></span>
                                <span class="text-center">{{__('home_manager.Department.Completed')}}</span>
                            </div>
                            <div class="cricle">
                            <span class="awaiting"><a href="{{ route('task',['status'=>2,'filter'=>5,'filter_name'=>'Awaiting Approval','type'=>base64_encode(strtolower('task')),'department_filter'=>$list->id,'department'=>$list->name]) }}">{{$list['info']['awaiting_approval']}}</a></span>
                                <span class="text-center">{{__('home_manager.Department.Awaiting Approval')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 status-bar">
                        <p>{{__('home_manager.Task.Total Tasks')}}: {{$list['info']['total']}}</p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-green text-primary" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $list['per']; ?>%">
                                {{$list['per']}}%
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1 {{$click_on_list ?? ''}} cursor-pointer" data-id="{{$list->id}}">
                              <p><a><img src="{{ asset('/img/view-icon.svg') }}" class="users-view-img" alt="view"/></a></p>
                              <span>{{__('clients.view_details.View')}}</span>
                            </div>
                </div>
            </li>
            @endforeach

        </ul>
    </div>
</div>

<!-- Modal -->

</div>
</div>