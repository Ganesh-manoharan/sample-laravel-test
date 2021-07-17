@foreach($data as $item)
<div class="card">
    <div class="card-body">
        <ul class="p-0 m-0">
            <li>
                <div class="risk-table-items">
                    <div class="row align-items-start">
                        <div class="col-lg-2 col-md-3 col-12">
                            <div class="CyberSecurityRisk">
                                <h1>{{ task_field_value_text($item->id,'risk_name') }}</h1>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-12">
                            <div class="RiskCategory">
                                <h2>Risk Category</h2>
                                <p>{{ task_field_value_text($item->id,'risk_category') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-12">
                            <div class="RiskCategory">
                                <h2>Risk Sub-Category</h2>
                                <p>{{ task_field_value_text($item->id,'risk_subcategory') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-12">
                            <div class="ResidualRisk">
                                <h2>Residual Risk</h2>
                        @if(task_field_value_text($item->id,'current_risk_score')=='Low' || task_field_value_text($item->id,'current_risk_score')=='Very Low')
                          <p class="risk_low_value">{{ task_field_value_text($item->id,'current_risk_score') }}</p>
                        @else
                          <p>{{ task_field_value_text($item->id,'current_risk_score') }}</p>
                        @endif
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="d-flex align-items-start">
                                <div class="issue-risk-items">
                                    <div class="IssuesRaised">
                                    <a href="{{ url(route('task.form',['type'=>base64_encode('issue'),'riskId'=>$item->id,'risktype'=>'raised'])) }}">   
                                    {{issueRaised($item->id)}}
                                    </a>
                                    </div>
                                    <p>Issues Raised</p>
                                </div>
                                <div class="issue-risk-items">
                                    <div class="IssuesRaised">
                                       
                                    <a href="{{ url(route('task.form',['type'=>base64_encode('task'),'riskId'=>$item->id,'risktype'=>'overdue'])) }}">   
                                        {{riskOverdue($item->id)}}
                                    </a>
                                </div>
                                    <p>Overdue</p>
                                </div>
                                <div class="issue-risk-items">
                                    <div class="IssuesRaised">
                                    <a href="{{ url(route('task.form',['type'=>base64_encode('task'),'riskId'=>$item->id,'risktype'=>'withChallenge'])) }}">   
                                    {{riskTaskChallenge($item->id)}}
                                    </a>
                                    </div>
                                    <p>Completed with Challenge</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-3 col-12">
                            <button class="expand-arrow" data-toggle="collapse" data-target='{{ "#riskExample".$item->id}}'><em class="fas fa-caret-down"></em></button>
                                
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <div class="more_view collapse" id="riskExample{{$item->id}}">
            <div class="card card-body">
                <div class="row align-items-start h-100">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="RiskDescription">
                            <h3>Risk Description</h3>
                            <p>{{ task_field_value_text($item->id,'risk_description') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="MitEffectiveness">
                            <p>Effectiveness</p>
                            <h1>{{ task_field_value_text($item->id,'mitigation_effectiveness') }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="MitEffectiveness">
                            <p>Risk Response</p>
                            <h1>{{ task_field_value_text($item->id,'risk_response') }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="InherentRisk">
                            <p>Inherent Risk</p>
                            <h1>{{ task_field_value_text($item->id,'inherent_risk') }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="RiskTrend">
                            <p>Risk Trend</p>
                            <h1>{{ task_field_value_text($item->id,'risk_trend') }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-1">
                    <a href="{{route('taskdetail',['id'=>$item->id])}}" type="button" class="btn risk-view-edit-btn">View</a>
                    @can('manager-only',Auth::user())
                    /
                    <a href="{{route('taskedit',['id'=>$item->id])}}" type="button" class="btn risk-view-edit-btn">Edit</a> @endcan()</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach