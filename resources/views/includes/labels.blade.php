      <div class="info-box-item">
          <div class="row">
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-3">
                  <div class="ibox bg-info">
                    <div class="ibox-content">
                      <p>{{__('stats.ACTIVE')}}</p>
                      <h3><a style="color: #ffffff;" href="{{ route('task',['status'=>0,'filter'=>1,'filter_name'=>'Active','type'=>base64_encode(strtolower('task'))]) }}">{{$info['active']}}</a></h3>
                    </div>
                    <!-- <div class="ibox-footer">
                      <span class="mr-auto">0% {{__('stats.INCREASE')}}</span>
                      <span class="ml-auto"><img src="{{ asset('img/Icon.png')}}" alt="increase" class="increasedecreaseicon" /> </span>
                    </div> -->
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="ibox bg-warning">
                    <div class="ibox-content">
                    <p>{{__('stats.URGENT')}}</p>
                      <h3><a style="color: #ffffff;" href="{{ route('task',['status'=>0,'filter'=>2,'filter_name'=>'Urgent','type'=>base64_encode(strtolower('task'))]) }}">{{$info['urgent']}}</a></h3>
                    </div>
                    <!-- <div class="ibox-footer">
                      <span class="mr-auto">0% {{__('stats.INCREASE')}}</span>
                      <span class="ml-auto"><img src="{{ asset('img/Icon.png')}}" alt="increase" class="increasedecreaseicon" /></span>
                    </div> -->
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="ibox bg-danger">
                    <div class="ibox-content">
                    <p>{{__('stats.OVERDUE')}}</p>  
                      <h3><a style="color: #ffffff;" href="{{ route('task',['status'=>0,'filter'=>3,'filter_name'=>'Overdue','type'=>base64_encode(strtolower('task'))]) }}">{{$info['overdue']}}</a></h3>
                    </div>
                    <!-- <div class="ibox-footer">
                      <span class="mr-auto">0% {{__('stats.DECREASE')}}</span>
                      <span class="ml-auto"><img src="{{ asset('img/downIcon.png')}}" alt="decrease" class="increasedecreaseicon" /></span>
                    </div> -->
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="ibox bg-success">
                    <div class="ibox-content">
                     <p>{{__('stats.COMPLETED')}}</p>
                      <h3><a style="color: #ffffff;" href="{{ route('task',['status'=>1,'filter'=>4,'filter_name'=>'Completed','type'=>base64_encode(strtolower('task'))]) }}">{{$info['completed']}}</a></h3>
                    </div>
                    <!-- <div class="ibox-footer">
                      <span class="mr-auto">0% {{__('stats.DECREASE')}}</span>
                      <span class="ml-auto"><img src="{{ asset('img/downIcon.png')}}" alt="decrease" class="increasedecreaseicon" /></span>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="ibox bg-approval">
                <div class="approval-item">
                  <div class="ibox-content">
                  <p>{{__('stats.AWAITING APPROVAL')}}</p>
                    <h3>{{$info['awaiting_approval']}}</h3>
                  </div>
                  <!-- <div class="ibox-footer">
                    <span class="mr-auto">0% {{__('stats.DECREASE')}}</span>
                    <span class="ml-auto"><img src="{{ asset('img/downIcon.png')}}" alt="decrease" class="increasedecreaseicon" /></span>
                  </div> -->
                </div>
                <div class="approval-item-btn text-right">
                  <a href="{{ url(route('awaiting_approval',['type'=>request()->type]))}}"><span class="cricle-dots"><em class="fa fa-play" aria-hidden="true"></em></span></a>
                </div>
              </div>
            </div>
          </div>
        </div>