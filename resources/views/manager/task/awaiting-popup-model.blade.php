
            <h3>{{__('awaiting_approval.Popupmodal.Approve Task')}}</h3>
            <div class="row">
              <div class="col-md-7">
                <input type="hidden" name="taskid" id="taskid" value="{{$data->id}}" />
                <div class="awaitingApproval">
                  <p>{{__('awaiting_approval.Popupmodal.Task Name')}}: <span id="awaitingmodal_taskname">{{ task_field_value_text($data->id,'task_name') }}</span></p>
                  <p>{{__('awaiting_approval.Popupmodal.Task ID')}}: <span id="awaitingmodal_taskid">{{$data->id}}</span></p>
                </div>
              </div>
              <div class="col-md-5">
                <div class="awaitingApproval">
                  <p>{{__('awaiting_approval.Popupmodal.Assigned to')}}: <span id="awaitingmodal_assigned_to">{{$data->departments[0]->name}}</span></p>
                  <ul class="popupassignedto">
                      @foreach($data->assignees as $user)
                      <li><img src="{{env('AWS_URL').'/'.$user->avatar}}" alt=""></li>
                      @endforeach
                  </ul>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <div class="awaitingApproval">
                  <p>{{__('awaiting_approval.Popupmodal.Client Name')}}: <span class="client_name" id="awaitingmodal_clientname">{{$data->clients[0]->client_name}}</span></p>
                  <div class="awaiting-doc">
                    <p>{{__('awaiting_approval.Popupmodal.MIS')}}:</p>
                    <div id="awaitingmodal_mis" class="awaitingmodal_mis">
                      <ul>
                          @foreach($data->mis as $mis)
                          <li>{{$mis->label_title}} : 
                              @if($mis->field_type_id == 3)
                              {{$mis->task_mis_results->options}}
                              @else($mis->field_type_id == 2 || $mis->field_type_id == 1)
                              {{$mis->task_mis_results->value}}
                              @endif
                          </li>
                          @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="awaitingApproval">
                  <p>{{__('awaiting_approval.Popupmodal.Deadline')}}: <span id="awaitingmodal_deadline">{{date('m/d/Y',strtotime(task_field_value_text($data->id,'due_date')))  }}</span></p>
                  <p>{{__('awaiting_approval.Popupmodal.Status')}}: <span id="awaitingmodal_status">
                      @if($data->task_challenge_status == 1)
                      <input id="statisfactory" value="Satisfactory" class="statisfactory"/>
                      @else
                      <input  id="critical" value="Critical" class="statisfactory critical"/>
                      @endif
                  </span></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <div class="awaitingApproval">
                  <div class="d-flex">
                    <p>{{__('awaiting_approval.Popupmodal.Completed By')}}:</p>
                    {{ decryptKMSvalues(Auth::user()->name) }}
                  </div>
                  <div>
                    <img src="{{ asset(Auth::user()->avatar) }}" alt="user-img" class="img-completedby">
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="awaitingApproval">
                  <div class="awaiting-doc">
                    <p>{{__('awaiting_approval.Popupmodal.Documents')}}:</p>
                    <ul id="awaitingmodal_documents" class="awaitingmodal_documents">
                        @foreach($data->attachdocumentation as $i)
                        <li><img src='/img/doc-list.svg' alt>  $i<li>
                        @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>