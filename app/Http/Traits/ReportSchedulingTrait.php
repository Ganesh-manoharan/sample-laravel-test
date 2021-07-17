<?php

namespace App\Http\Traits;

use App\Tasks;
use App\Report;
use App\TaskField;
use App\CompanyUsers;
use App\TaskFieldValue;
use App\FieldDropdownValue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Tagging;
use App\ReportTag;
use App\TaskTag;
use App\Departments;
use App\FundGroups;
use App\SubFunds;

trait ReportSchedulingTrait
{
    public static function checkCurrentRun($report){
          
          $report_satus = false;

          switch(strtolower($report->frequency)) {
            case 'daily':
                if(self::getDayDifference($report->last_run, $report->creted_at) >= 1){
                   $report_satus = true;
                }
            break;
            case 'weekly':
                if(self::getDayDifference($report->last_run, $report->creted_at) >= 6){
                   $report_satus = true;
                }
            break;
            case 'monthly':
                if(self::getDayDifference($report->last_run, $report->creted_at) >= 30){
                    $report_satus = true;
                }
            break;
            case 'yearly':
                if(self::getDayDifference($report->last_run, $report->creted_at) >= 365){
                    $report_satus = true;
                }
            break;
            default:
                 $report_satus = false;
          }

          return $report_satus;
        
    }

    public static function getDayDifference($last_run, $created_at){
        $to = ($last_run == NULL)? \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $created_at) : \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $last_run);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', \Carbon\Carbon::now());
        return $to->diffInDays($from);
    }

    public static function getReportData($report){

        switch($report->code){
            case 'audit':
                $reportConstraints = Report::with('report_clients','report_department','report_documents','report_funds','report_subfunds','report_tag')->where('id',$report->id)->first();

                $tmp = '';
                for($i=0;$i<count($reportConstraints['report_department']);$i++)
                {
                    $tmp.=",".$reportConstraints['report_department'][$i]['department_id'];
                }
                $valueofdepartments= substr($tmp,1);
                $reportData['format'] = 'pdf';
                $reportData['data'] = self::auditData($report, $reportConstraints,$valueofdepartments);
            break;
            case 'risk':
                $reportConstraints = Report::with('report_department','get_risk_category','get_child_category')->where('id',$report->id)->first();
                $reportData['format'] = 'pdf';
                $reportData['data'] = self::riskData($report, $reportConstraints);
            break;
            case 'issue':
                $reportConstraints = Report::with('report_clients','report_department','report_funds','report_subfunds')->where('id',$report->id)->first();
                $reportData['format'] = 'pdf';
                $reportData['data'] = self::issueData($report, $reportConstraints);
            break;
            case 'activity':
               $reportConstraints = Report::with('report_clients','report_department','report_documents','report_funds','report_subfunds')->where('id',$report->id)->first();
                $reportData['format'] = 'pdf';
                $reportData['data'] = self::activityData($report,$reportConstraints);
            break;
            case 'governance':
                $reportConstraints = Report::with('report_clients','report_department','report_funds','report_subfunds')->where('id',$report->id)->first();
                $reportData['format'] = 'pdf';
                $reportData['data'] = self::governanceData($report, $reportConstraints);
            break;
        }

        return $reportData;
       
    }

    public static function generateReportJs($data,$company,$format){
  
        $headers = [
            'Content-Type: application/json'
        ];
        Log::debug("General fix");
        Log::debug($data);
        Log::debug(env('REPORT_JS'));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,env('REPORT_JS')."/api/report");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        Log::debug($response);
        $path = 'reports/'.$company->id.'/'.\Carbon\Carbon::now()->timestamp.'report.'.$format;
        Storage::disk('s3')->put($path,$response,'public');
        $storage_data['path'] = Storage::disk('s3')->getDriver()->getAdapter()->applyPathPrefix($path);
        $storage_data['format'] = $format;
        
        return $storage_data;
    }

    public static function riskData($report, $reportConstraints)
    {
        $where_department =  $reportConstraints->report_department->pluck('department_id');
        $where_risk_cateogry = $reportConstraints->get_risk_category->risk_category_id;
        $where_risk_subcateogry = $reportConstraints->get_child_category->risk_subcategory_id;

        $risks = Tasks::with('task_department','getRiskCategory')
            ->join('task_risk_categories','task_risk_categories.task_id','=','tasks.id')
            ->join('task_departments','task_departments.task_id','=','tasks.id')
            ->whereIn('task_departments.department_id',$where_department)
            ->where('task_risk_categories.risk_category_id',$where_risk_cateogry)
            ->where('task_risk_categories.risk_sub_category_id',$where_risk_subcateogry)
            ->where('tasks.task_type',3)
            ->select('tasks.*')
            ->distinct()->get();
   
        $reportData['template']['name'] = env('RISK_REPORT_URL');
        $reportData['data']['reportName'] = $report->name;
        $reportData['data']['reportedOn'] = date("F d Y");
        $reportData['data']['calendarPeriod'] = date_format(date_create($report->last_run),"d-m-Y")." to ".date('d-m-Y');

        $inc = 0;
        $department_name = [];
        $reportData['data']['heatMap']['inherent']['extreme_rare'] = $reportData['data']['heatMap']['inherent']['extreme_unlikely'] = $reportData['data']['heatMap']['inherent']['extreme_possible'] = $reportData['data']['heatMap']['inherent']['extreme_likely'] = $reportData['data']['heatMap']['inherent']['extreme_almost_certain'] = '0';

        $reportData['data']['heatMap']['inherent']['major_rare'] = $reportData['data']['heatMap']['inherent']['major_unlikely'] = $reportData['data']['heatMap']['inherent']['major_possible'] = $reportData['data']['heatMap']['inherent']['major_likely'] = $reportData['data']['heatMap']['inherent']['major_almost_certain'] = '0';

        $reportData['data']['heatMap']['inherent']['moderate_rare'] = $reportData['data']['heatMap']['inherent']['moderate_unlikely'] = $reportData['data']['heatMap']['inherent']['moderate_possible'] = $reportData['data']['heatMap']['inherent']['moderate_likely'] = $reportData['data']['heatMap']['inherent']['moderate_almost_certain'] = '0';

        $reportData['data']['heatMap']['inherent']['minor_rare'] = $reportData['data']['heatMap']['inherent']['minor_unlikely'] = $reportData['data']['heatMap']['inherent']['minor_possible'] = $reportData['data']['heatMap']['inherent']['minor_likely'] = $reportData['data']['heatMap']['inherent']['minor_almost_certain'] = '0';

        $reportData['data']['heatMap']['inherent']['incidental_rare'] = $reportData['data']['heatMap']['inherent']['incidental_unlikely'] = $reportData['data']['heatMap']['inherent']['incidental_possible'] = $reportData['data']['heatMap']['inherent']['incidental_likely'] = $reportData['data']['heatMap']['inherent']['incidental_almost_certain'] = '0';

        $reportData['data']['heatMap']['residual']['inadequate_very_low'] = $reportData['data']['heatMap']['residual']['inadequate_low'] = $reportData['data']['heatMap']['residual']['inadequate_medium'] = $reportData['data']['heatMap']['residual']['inadequate_high'] = $reportData['data']['heatMap']['residual']['inadequate_very_high'] = '0';

        $reportData['data']['heatMap']['residual']['deficient_very_low'] = $reportData['data']['heatMap']['residual']['deficient_low'] = $reportData['data']['heatMap']['residual']['deficient_medium'] = $reportData['data']['heatMap']['residual']['deficient_high'] = $reportData['data']['heatMap']['residual']['deficient_very_high'] = '0';

        $reportData['data']['heatMap']['residual']['enhancements_needed_very_low'] = $reportData['data']['heatMap']['residual']['enhancements_needed_low'] = $reportData['data']['heatMap']['residual']['enhancements_needed_medium'] = $reportData['data']['heatMap']['residual']['enhancements_needed_high'] = $reportData['data']['heatMap']['residual']['enhancements_needed_very_high'] = '0';

        $reportData['data']['heatMap']['residual']['satisfactory_very_low'] = $reportData['data']['heatMap']['residual']['satisfactory_low'] = $reportData['data']['heatMap']['residual']['satisfactory_medium'] = $reportData['data']['heatMap']['residual']['satisfactory_high'] = $reportData['data']['heatMap']['residual']['satisfactory_very_high'] = '0';

        $reportData['data']['heatMap']['residual']['strong_very_low'] = $reportData['data']['heatMap']['residual']['strong_low'] = $reportData['data']['heatMap']['residual']['strong_medium'] = $reportData['data']['heatMap']['residual']['strong_high'] = $reportData['data']['heatMap']['residual']['strong_very_high'] = '0';

        $riskCollection['data']['riskChartData']=[];
        $riskScoreId=TaskField::where('code','risk_value')->first();
        foreach($riskScoreId->getDropDownDetails as $riskScore)
        {
            $riskCollection['data']['riskScoreList'][]=$riskScore->code;
        }
        $riskTrendId=TaskField::where('code','risk_trend')->first();
        
        foreach($riskTrendId->getDropDownDetails as $riskTrend)
        {
            $riskDetails=[];
            $riskDetails['label']=$riskTrend->code;
            $riskTaskDetails=TaskFieldValue::where('dropdown_value_id',$riskTrend->id)->pluck('task_id')->toArray();
            foreach($riskScoreId->getDropDownDetails as $riskScore)
            {
                $riskScoreCount=TaskFieldValue::where('dropdown_value_id',$riskScore->id)->whereIn('task_id',$riskTaskDetails)->count();
                $riskDetails['data'][]=$riskScoreCount;
            }
            array_push($riskCollection['data']['riskChartData'],$riskDetails);
        }

        foreach($risks as $risk){

            foreach($risk->task_department as $departmentsdata){
                $department_name[$departmentsdata->departments->name] = $departmentsdata->departments->name;
            }

            $riskFields = self::getFieldValues($risk->id);

            $index = strtolower(str_replace("-", " ", $riskFields['impact__rating'])).'_'.strtolower(str_replace("-", " ", $riskFields['probability']));
            if(isset($reportData['data']['heatMap']['inherent'][$index])){
                $reportData['data']['heatMap']['inherent'][$index]++;
            }

            if(isset($reporData['data']['heatMap']['residual'][$index])){
                $reportData['data']['heatMap']['residual'][$index]++;
            }

            Log::debug($reportData['data']['heatMap']['inherent']);
            //exit();
            

            $reportData['data']['riskRegister'][$inc]['riskTitle'] = $riskFields['risk_name'];
            $reportData['data']['riskRegister'][$inc]['riskId'] = $riskFields['risk_id'];
            $reportData['data']['riskRegister'][$inc]['riskCategory'] = $reportConstraints->get_risk_category->title;
            $reportData['data']['riskRegister'][$inc]['riskSubCategory'] = $reportConstraints->get_child_category->title;
            $reportData['data']['riskRegister'][$inc]['riskDescription'] = $riskFields['risk_description'];
            $reportData['data']['riskRegister'][$inc]['impactRating'] = $riskFields['impact__rating'];
            $reportData['data']['riskRegister'][$inc]['probability'] = $riskFields['probability'];
            $reportData['data']['riskRegister'][$inc]['inherentRisk'] = $riskFields['inherent_risk'];
            $reportData['data']['riskRegister'][$inc]['riskResponse'] = $riskFields['risk_response'];
            $reportData['data']['riskRegister'][$inc]['mitigationEffectiveness'] = $riskFields['mitigation_effectiveness'];
            $reportData['data']['riskRegister'][$inc]['currentRiskScore'] = $riskFields['current_risk_score'];
            $reportData['data']['riskRegister'][$inc]['riskTrend'] = $riskFields['risk_trend'];

            if($riskFields['risk_trend'] == 'increasing'){
                $reportData['data']['trendingDetail'][$inc]['riskTitle'] =  $riskFields['risk_name'];
                $reportData['data']['trendingDetail'][$inc]['riskCategory'] = $reportConstraints->get_risk_category->title;
                $reportData['data']['trendingDetail'][$inc]['riskSubCategory'] = $reportConstraints->get_child_category->title;
                $reportData['data']['trendingDetail'][$inc]['riskDescription'] = $riskFields['risk_description'];
                $reportData['data']['trendingDetail'][$inc]['inherentRisk'] = $riskFields['inherent_risk'];
                $reportData['data']['trendingDetail'][$inc]['mitigationEffectiveness'] = $riskFields['mitigation_effectiveness'];
                $reportData['data']['trendingDetail'][$inc]['currentRiskScore'] = $riskFields['current_risk_score'];
                $reportData['data']['trendingDetail'][$inc]['riskTrend'] = $riskFields['risk_trend'];
                $reportData['data']['trendingDetail'][$inc]['comments'] = '-';
            }else{
                $reportData['data']['topRiskDetail'][$inc]['riskTitle'] = $riskFields['risk_name'];
                $reportData['data']['topRiskDetail'][$inc]['riskCategory'] = $reportConstraints->get_risk_category->title;
                $reportData['data']['topRiskDetail'][$inc]['riskSubCategory'] = $reportConstraints->get_child_category->title;
                $reportData['data']['topRiskDetail'][$inc]['riskDescription'] = $riskFields['risk_description'];
                $reportData['data']['topRiskDetail'][$inc]['inherentRisk'] = $riskFields['inherent_risk'];
                $reportData['data']['topRiskDetail'][$inc]['mitigationEffectiveness'] = $riskFields['mitigation_effectiveness'];
                $reportData['data']['topRiskDetail'][$inc]['currentRiskScore'] = $riskFields['current_risk_score'];
                $reportData['data']['topRiskDetail'][$inc]['riskTrend'] = $riskFields['risk_trend'];
                $reportData['data']['topRiskDetail'][$inc]['comments'] = '-';

            }
            $inc++;
        }
        
        $reportData['data']['riskCateogry'] = $reportConstraints->get_risk_category->title;;
        $reportData['data']['riskSubCategory'] = $reportConstraints->get_child_category->title;
        $reportData['data']['department'] = implode(", ",$department_name);
        $reportData['data']['riskScore'] = 'ALL';

        return json_encode($reportData);
    }

    public static function issueData($report, $reportConstraints)
    {
        $where_client = $reportConstraints->report_clients->pluck('client_id');
        $where_department = $reportConstraints->report_department->pluck('department_id');
        $where_funds = $reportConstraints->report_funds->pluck('fund_group_id');
        $where_subfunds = $reportConstraints->report_subfunds->pluck('report_sub_fund_id');

        $issues = Tasks::with('task_clients','task_department','task_funds','task_subfunds')
            ->join('task_clients','task_clients.task_id','=','tasks.id')
            ->join('task_departments','task_departments.task_id','=','tasks.id')
            ->join('task_fund_groups','task_fund_groups.task_id','=','tasks.id')
            ->join('task_sub_funds','task_sub_funds.task_id','=','tasks.id')
            ->whereIn('task_clients.client_id',$where_client)
            ->whereIn('task_departments.department_id',$where_department)
            ->whereIn('task_fund_groups.fund_group_id',$where_funds)
            ->whereIn('task_sub_funds.sub_funds_id',$where_subfunds)
            ->where('tasks.task_type',2)
            ->select('tasks.*')
            ->distinct()->get();

        $reportData['template']['name'] = env('ISSUE_REPORT_URL');
        $reportData['data']['reportName'] = $report->name;
        $reportData['data']['reportedOn'] = date("F d Y");
        $reportData['data']['calendarPeriod'] = date_format(date_create($report->last_run),"d-m-Y")." to ".date('d-m-Y');
        //$reportData['data']['issues'] = json_encode($issues);

        $department_name = $clients_name = $fund_name = $sub_fund_name = array();

        $chart_department_task_count = $chart_issue_type_count = array();

        $inc=0;
        foreach($issues as $issue){
            $issueFields = self::getFieldValues($issue->id);
            Log::debug($issueFields);
            $current_task_departent = $current_task_client = $current_task_fund_group = $current_task_sub_fund_group = array();

            foreach($issue->task_department as $departmentsdata){
                $department_name[$departmentsdata->departments->name] = $departmentsdata->departments->name;
                $current_task_departent[$departmentsdata->departments->name] = $departmentsdata->departments->name;
                if(isset($chart_department_task_count[$departmentsdata->departments->name])){
                    $chart_department_task_count[$departmentsdata->departments->name]++;
                }else{
                    $chart_department_task_count[$departmentsdata->departments->name] = 1;
                }
            }

            foreach($issue->task_clients as $clientsdata){
                ($clientsdata->clients)?$clients_name[$clientsdata->clients->client_name] = $clientsdata->clients->client_name:'-';
                ($clientsdata->clients)?$current_task_client[$clientsdata->clients->client_name] = $clientsdata->clients->client_name:'-';
            }

            foreach($issue->task_funds as $funddata){
                ($funddata->fundgroups)?$fund_name[$funddata->fundgroups->fund_group_name] = $funddata->fundgroups->fund_group_name:'-';
                ($funddata->fundgroups)?$current_task_fund_group[$funddata->fundgroups->fund_group_name] = $funddata->fundgroups->fund_group_name:'-';
            }

            foreach($issue->task_subfunds as $subfunddata){
                ($subfunddata->subfunds->sub_fund_name)?$sub_fund_name[$subfunddata->subfunds->sub_fund_name] = $subfunddata->subfunds->sub_fund_name:'-';
                ($funddata->fundgroups)?$current_task_sub_fund_group[$funddata->fundgroups->fund_group_name] = $funddata->fundgroups->fund_group_name:'-';
            }

            if(isset( $chart_issue_type_count[$issueFields['issue_type']])){
                $chart_issue_type_count[$issueFields['issue_type']]++;
            }else{
                $chart_issue_type_count[$issueFields['issue_type']] = 1;
            }


            if($inc < 10){
            $reportData['data']['issueDetails'][$inc]['department'] =   implode(",",$current_task_departent);
            $reportData['data']['issueDetails'][$inc]['fundGroup'] =    implode(",",$current_task_fund_group);
            $reportData['data']['issueDetails'][$inc]['issueSummary'] = isset($issueFields['issue_description'])?$issueFields['issue_description']:'-';
            $reportData['data']['issueDetails'][$inc]['issueType'] = isset($issueFields['issue_type'])?$issueFields['issue_type']:'-';
            $reportData['data']['issueDetails'][$inc]['dateOfOcuurenace'] = isset($issueFields['date_issue_identified'])?date_format(date_create($issueFields['date_issue_identified']),"d-m-Y"):'-';
            $reportData['data']['issueDetails'][$inc]['impactRating'] = isset($issueFields['impact_rating'])?$issueFields['impact_rating']:'-';
            $reportData['data']['issueDetails'][$inc]['financialImpact '] = isset($issueFields['financial_impact'])?$issueFields['financial_impact']:'-';
            $reportData['data']['issueDetails'][$inc]['status'] = 'Open';
            }
            else
            {
                $additional_index = (int)$inc/10;
                $reportData['data']['issueDetails_additional_details'][$additional_index]['inner_data'][$inc]['department'] =   implode(",",$current_task_departent);
                $reportData['data']['issueDetails_additional_details'][$additional_index]['inner_data'][$inc]['fundGroup'] =    implode(",",$current_task_fund_group);
                $reportData['data']['issueDetails_additional_details'][$additional_index]['inner_data'][$inc]['issueSummary'] = isset($issueFields['issue_description'])?$issueFields['issue_description']:'-';
                $reportData['data']['issueDetails_additional_details'][$additional_index]['inner_data'][$inc]['issueType'] =    isset($issueFields['issue_type'])?$issueFields['issue_type']:'-';
                $reportData['data']['issueDetails_additional_details'][$additional_index]['inner_data'][$inc]['dateOfOcuurenace'] = isset($issueFields['date_issue_identified'])?date_format(date_create($issueFields['date_issue_identified']),"d-m-Y"):'-';
                $reportData['data']['issueDetails_additional_details'][$additional_index]['inner_data'][$inc]['impactRating'] =     isset($issueFields['impact_rating'])?$issueFields['impact_rating']:'-';
                $reportData['data']['issueDetails_additional_details'][$additional_index]['inner_data'][$inc]['financialImpact '] = isset($issueFields['financial_impact'])?$issueFields['financial_impact']:'-';
                $reportData['data']['issueDetails_additional_details'][$additional_index]['inner_data'][$inc]['status '] = 'Open';
            }
           
            

            $reportData['data']['issuesGrid'][$inc]['client'] = implode(", ",$current_task_client);
            $reportData['data']['issuesGrid'][$inc]['fundGroup'] = implode(", ",$current_task_client);
            $reportData['data']['issuesGrid'][$inc]['subFund'] = implode(", ",$current_task_fund_group);
            $reportData['data']['issuesGrid'][$inc]['issueType'] = isset($issueFields['issue_type'])?$issueFields['issue_type']:'-';
            $reportData['data']['issuesGrid'][$inc]['impactRating'] = isset($issueFields['impact_rating'])?$issueFields['impact_rating']:'-';
            $reportData['data']['issuesGrid'][$inc]['financialImpact'] = isset($issueFields['financial_impact'])?$issueFields['financial_impact']:'-';
            $reportData['data']['issuesGrid'][$inc]['summary'] = isset($issueFields['issue_description'])?$issueFields['issue_description']:'-';
            $reportData['data']['issuesGrid'][$inc]['issueDetails'] = '-';
            $reportData['data']['issuesGrid'][$inc]['rootCause'] = isset($issueFields['root_cause'])?$issueFields['root_cause']:'-';
            $reportData['data']['issuesGrid'][$inc]['issueIdentified'] = isset($issueFields['date_issue_identified'])?$issueFields['date_issue_identified']:'-';
            $reportData['data']['issuesGrid'][$inc]['issueLogged'] = isset($issueFields['date_issue_occurance'])?$issueFields['date_issue_occurance']:'-';
            $reportData['data']['issuesGrid'][$inc]['issueOccured'] = isset($issueFields['date_issue_identified'])?$issueFields['date_issue_identified']:'-';
            $reportData['data']['issuesGrid'][$inc]['department'] = implode(", ",$current_task_departent);
            $reportData['data']['issuesGrid'][$inc]['responsiblePartiesExt'] = '-';
            $reportData['data']['issuesGrid'][$inc]['responsiblePartiesInt'] = '-';
            $reportData['data']['issuesGrid'][$inc]['participant'] = '-';
            $reportData['data']['issuesGrid'][$inc]['financialValue'] = '-';
            $reportData['data']['issuesGrid'][$inc]['impactResolution'] = '-';
            $reportData['data']['issuesGrid'][$inc]['actionTasks'] = '-';
            $reportData['data']['issuesGrid'][$inc]['isueeLog'] = '-';
            $reportData['data']['issuesGrid'][$inc]['registerImpact'] = isset($issueFields['risk_register_impact'])?$issueFields['risk_register_impact']:'-';
            $reportData['data']['issuesGrid'][$inc]['review'] = isset($issueFields['external_description'])?$issueFields['external_description']:'-';

            $inc++;
        }

        $reportData['data']['issueTypeChart'] = $chart_issue_type_count;
        $reportData['data']['departmentChartData'] = $chart_department_task_count;
        $reportData['data']['departments'] = implode(", ",$department_name);
        $reportData['data']['clients'] = implode(", ",$clients_name);
        $reportData['data']['fundGroup'] = implode(", ",$fund_name);
        $reportData['data']['subFund'] = implode(", ",$sub_fund_name);

        $issueouccuredType=TaskField::where('code','date_issue_occurance')->pluck('id')->first();
        $issueTypeID=TaskField::where('code','issue_type')->pluck('id')->first();
        $getLastyearissueList=TaskFieldValue::where('task_field_id',$issueTypeID)
        ->whereMonth('created_at', '>=', Carbon::now()->subMonth(12))
        ->whereNotNull('dropdown_value_id')
        ->select('dropdown_value_id')
        ->groupby('dropdown_value_id')
        ->get();
        $reportdata['data']['trendAnalysis']=[];
        for ($i = 11; $i >=0; $i--)
        {
        $months = date("Y-m-d", strtotime( date( 'Y-m-01' )." -$i months"));
        $reportData['data']['issueMonths'][]=date('M',strtotime($months));
        }
        Log::debug($getLastyearissueList);
        foreach($getLastyearissueList as $issueType)
        {
        $reportMonth=[];
        Log::debug($issueType->getDropDownText);
        $countData['label']=$issueType->getDropDownText->code;
        $issueouccuredCount=0;
        for ($i = 11; $i >= 0; $i--)
        {
        $months = date("Y-m-d", strtotime( date( 'Y-m-01' )." -$i months"));
        if($issueouccuredType)
        {
        $y = date('Y',strtotime($months));
        $issueouccuredCount=TaskFieldValue::with('getTaskFieldType')
        ->where('task_field_id',$issueouccuredType)
        ->whereMonth('date', date('m',strtotime('-'.$i.' month')))
        ->whereYear('date',$y)->count();
        }
        $countData['data'][]=$issueouccuredCount;
        }
        $reportData['data']['trendAnalysis'][]=$countData;
        }
        Log::debug(json_encode($reportData));
        return json_encode($reportData);
    }

    public static function governanceData($report, $reportConstraints)
    {
        $where_client = $reportConstraints->report_clients->pluck('client_id');
        $where_department = $reportConstraints->report_department->pluck('department_id');
        $where_funds = $reportConstraints->report_funds->pluck('fund_group_id');
        $where_subfunds = $reportConstraints->report_subfunds->pluck('report_sub_fund_id');

        $governances = Tasks::with('task_clients','task_department','task_funds','task_subfunds')
            ->join('task_clients','task_clients.task_id','=','tasks.id')
            ->join('task_departments','task_departments.task_id','=','tasks.id')
            ->join('task_fund_groups','task_fund_groups.task_id','=','tasks.id')
            ->join('task_sub_funds','task_sub_funds.task_id','=','tasks.id')
            ->whereIn('task_clients.client_id',$where_client)
            ->whereIn('task_departments.department_id',$where_department)
            ->whereIn('task_fund_groups.fund_group_id',$where_funds)
            ->whereIn('task_sub_funds.sub_funds_id',$where_subfunds)
            ->where('tasks.task_type',2)
            ->select('tasks.*')
            ->distinct()->get();

        $reportData['template']['name'] = env('GOVERNANCE_REPORT_URL');
        $reportData['data']['reportName'] = $report->name;
        $reportData['data']['reportedOn'] = date("F d Y");
        $reportData['data']['calendarPeriod'] = date_format(date_create($report->last_run),"d-m-Y")." to ".date('d-m-Y');
        $department_name = $clients_name = $fund_name = $sub_fund_name = array();
        $chart_department_task_count = $chart_issue_type_count = array();

        $inc=0;
        foreach($governances as $governance){
            $governanceFields = self::getFieldValues($governance->id);
            Log::debug($governanceFields);
            $current_task_departent = $current_task_client = $current_task_fund_group = $current_task_sub_fund_group = array();

            foreach($governance->task_department as $departmentsdata){
                $department_name[$departmentsdata->departments->name] = $departmentsdata->departments->name;
                $current_task_departent[$departmentsdata->departments->name] = $departmentsdata->departments->name;
                if(isset($chart_department_task_count[$departmentsdata->departments->name])){
                    $chart_department_task_count[$departmentsdata->departments->name]++;
                }else{
                    $chart_department_task_count[$departmentsdata->departments->name] = 1;
                }
            }

            foreach($governance->task_clients as $clientsdata){
                ($clientsdata->clients)?$clients_name[$clientsdata->clients->client_name] = $clientsdata->clients->client_name:'-';
                ($clientsdata->clients)?$current_task_client[$clientsdata->clients->client_name] = $clientsdata->clients->client_name:'-';
            }

            foreach($governance->task_funds as $funddata){
                ($funddata->fundgroups)?$fund_name[$funddata->fundgroups->fund_group_name] = $funddata->fundgroups->fund_group_name:'-';
                ($funddata->fundgroups)?$current_task_fund_group[$funddata->fundgroups->fund_group_name] = $funddata->fundgroups->fund_group_name:'-';
            }

            foreach($governance->task_subfunds as $subfunddata){
                ($subfunddata->subfunds->sub_fund_name)?$sub_fund_name[$subfunddata->subfunds->sub_fund_name] = $subfunddata->subfunds->sub_fund_name:'-';
                ($funddata->fundgroups)?$current_task_sub_fund_group[$funddata->fundgroups->fund_group_name] = $funddata->fundgroups->fund_group_name:'-';
            }

            if(isset( $chart_issue_type_count[$governanceFields['issue_type']])){
                $chart_issue_type_count[$governanceFields['issue_type']]++;
            }else{
                $chart_issue_type_count[$governanceFields['issue_type']] = 1;
            }

            $reportData['data']['issueDetails'][$inc]['department'] = implode(",",$current_task_departent);
            $reportData['data']['issueDetails'][$inc]['fundGroup'] =  implode(",",$current_task_fund_group);
            $reportData['data']['issueDetails'][$inc]['issueSummary'] = isset($governanceFields['issue_description'])?$governanceFields['issue_description']:'-';
            $reportData['data']['issueDetails'][$inc]['issueType'] = isset($governanceFields['issue_type'])?$governanceFields['issue_type']:'-';
            $reportData['data']['issueDetails'][$inc]['dateOfOcuurenace'] = isset($governanceFields['date_issue_identified'])?date_format(date_create($governanceFields['date_issue_identified']),"d-m-Y"):'-';
            $reportData['data']['issueDetails'][$inc]['impactRating'] = isset($governanceFields['impact_rating'])?$governanceFields['impact_rating']:'-';
            $reportData['data']['issueDetails'][$inc]['financialImpact '] = isset($governanceFields['financial_impact'])?$governanceFields['financial_impact']:'-';
            $reportData['data']['issueDetails'][$inc]['status '] = 'Open';

            $reportData['data']['issuesGrid'][$inc]['client'] = implode(", ",$current_task_client);
            $reportData['data']['issuesGrid'][$inc]['fundGroup'] = implode(", ",$current_task_client);
            $reportData['data']['issuesGrid'][$inc]['subFund'] = implode(", ",$current_task_fund_group);
            $reportData['data']['issuesGrid'][$inc]['issueType'] = isset($governanceFields['issue_type'])?$governanceFields['issue_type']:'-';
            $reportData['data']['issuesGrid'][$inc]['impactRating'] = isset($governanceFields['impact_rating'])?$governanceFields['impact_rating']:'-';
            $reportData['data']['issuesGrid'][$inc]['financialImpact'] = isset($governanceFields['financial_impact'])?$governanceFields['financial_impact']:'-';
            $reportData['data']['issuesGrid'][$inc]['summary'] = isset($governanceFields['issue_description'])?$governanceFields['issue_description']:'-';
            $reportData['data']['issuesGrid'][$inc]['issueDetails'] = '-';
            $reportData['data']['issuesGrid'][$inc]['rootCause'] = isset($governanceFields['root_cause'])?$governanceFields['root_cause']:'-';
            $reportData['data']['issuesGrid'][$inc]['issueIdentified'] = isset($governanceFields['date_issue_identified'])?$governanceFields['date_issue_identified']:'-';
            $reportData['data']['issuesGrid'][$inc]['issueLogged'] = isset($governanceFields['date_issue_occurance'])?$governanceFields['date_issue_occurance']:'-';
            $reportData['data']['issuesGrid'][$inc]['issueOccured'] = isset($governanceFields['date_issue_identified'])?$governanceFields['date_issue_identified']:'-';
            $reportData['data']['issuesGrid'][$inc]['department'] = implode(", ",$current_task_departent);
            $reportData['data']['issuesGrid'][$inc]['responsiblePartiesExt'] = '-';
            $reportData['data']['issuesGrid'][$inc]['responsiblePartiesInt'] = '-';
            $reportData['data']['issuesGrid'][$inc]['participant'] = '-';
            $reportData['data']['issuesGrid'][$inc]['financialValue'] = '-';
            $reportData['data']['issuesGrid'][$inc]['impactResolution'] = '-';
            $reportData['data']['issuesGrid'][$inc]['actionTasks'] = '-';
            $reportData['data']['issuesGrid'][$inc]['isueeLog'] = '-';
            $reportData['data']['issuesGrid'][$inc]['registerImpact'] = isset($governanceFields['risk_register_impact'])?$governanceFields['risk_register_impact']:'-';
            $reportData['data']['issuesGrid'][$inc]['review'] = isset($governanceFields['external_description'])?$governanceFields['external_description']:'-';
            $inc++;
        }
        $reportData['data']['issueTypeChart'] = $chart_issue_type_count;
        $reportData['data']['departmentChartData'] = $chart_department_task_count;
        $reportData['data']['departments'] = implode(", ",$department_name);
        $reportData['data']['clients'] = implode(", ",$clients_name);
        $reportData['data']['fundGroup'] = implode(", ",$fund_name);
        $reportData['data']['subFund'] = implode(", ",$sub_fund_name);

        $issueouccuredType=TaskField::where('code','date_issue_occurance')->pluck('id')->first();
        $issueTypeID=TaskField::where('code','issue_type')->pluck('id')->first();
        $getLastyearissueList=TaskFieldValue::where('task_field_id',$issueTypeID)
        ->whereMonth('created_at', '>=', Carbon::now()->subMonth(12))
        ->whereNotNull('dropdown_value_id')
        ->select('dropdown_value_id')
        ->groupby('dropdown_value_id')
        ->get();
        $reportdata['data']['trendAnalysis']=[];
        for ($i = 11; $i >=0; $i--)
        {
        $months = date("Y-m-d", strtotime( date( 'Y-m-01' )." -$i months"));
        $reportData['data']['issueMonths'][]=date('M',strtotime($months));
        }
        Log::debug($getLastyearissueList);
        foreach($getLastyearissueList as $issueType)
        {
        $reportMonth=[];
        Log::debug($issueType->getDropDownText);
        $countData['label']=$issueType->getDropDownText->code;
        $issueouccuredCount=0;
        for ($i = 11; $i >= 0; $i--)
        {
        $months = date("Y-m-d", strtotime( date( 'Y-m-01' )." -$i months"));
        if($issueouccuredType)
        {
        $y = date('Y',strtotime($months));
        $issueouccuredCount=TaskFieldValue::with('getTaskFieldType')
        ->where('task_field_id',$issueouccuredType)
        ->whereMonth('date', date('m',strtotime('-'.$i.' month')))
        ->whereYear('date',$y)->count();
        }
        $countData['data'][]=$issueouccuredCount;
        }
        $reportData['data']['trendAnalysis'][]=$countData;
        }
        Log::debug(json_encode($reportData));
        return json_encode($reportData);
    }
    public static function auditData($report, $reportConstraints,$valueofdepartments)
    {
            
            $where_client = $reportConstraints->report_clients->pluck('client_id');
            $where_document = $reportConstraints->report_documents->pluck('document_id');
            $where_department1=explode(",",$valueofdepartments);
            $where_department = $reportConstraints->report_department->pluck('department_id');
            $where_funds = $reportConstraints->report_funds->pluck('fund_group_id');
            $where_subfunds = $reportConstraints->report_subfunds->pluck('report_sub_fund_id');
            $where_tags=$reportConstraints->report_tag->pluck('tag_id');
            /*department details */
            $departmentdetails=Departments::whereIn('id',$where_department1)->get();
            $fundetails=FundGroups::whereIn('id',$where_funds)->get();
            $subfundetails=SubFunds::whereIn('id',$where_subfunds)->get();

            $report_deptdetails = '';
            $fund_group_details = '';
            $subfund_group_details = '';
            foreach($departmentdetails as $deptdetails)
            {
                $report_deptdetails.=",".$deptdetails->name;
            }
            $valueofselecteddepartments= substr($report_deptdetails,1);
            foreach($fundetails as $auditfunddetails)
            {
                $fund_group_details.=",".$auditfunddetails->fund_group_name;
            }
            $valueofselectedfundgroups= substr($fund_group_details,1);

            foreach($subfundetails as $auditsubfunddetails)
            {
                $subfund_group_details.=",".$auditsubfunddetails->sub_fund_name;
            }
            $valueofselectedsubfundgroups= substr($subfund_group_details,1);


            if(count($where_tags)>0)
            {

                // Log::debug("##########################");

                // Log::debug("withTagssssssssssssssssssss");
                // Log::debug($where_department1);
    
                // Log::debug("##########################");


                $tasks = Tasks::with('task_clients','task_documents','task_department','task_funds','task_subfunds','task_tagging')
                ->join('task_documents','task_documents.task_id','=','tasks.id')
                ->join('task_clients','task_clients.task_id','=','tasks.id')
                ->join('task_departments','task_departments.task_id','=','tasks.id')
                ->join('task_fund_groups','task_fund_groups.task_id','=','tasks.id')
                ->join('task_sub_funds','task_sub_funds.task_id','=','tasks.id')
                ->join('task_tags','task_tags.task_id','=','tasks.id')
                ->where('tasks.task_type',1)
                ->whereIn('task_documents.document_id',$where_document)
                ->whereIn('task_clients.client_id',$where_client)
                ->whereIn('task_departments.department_id',$where_department1)
                ->whereIn('task_fund_groups.fund_group_id',$where_funds)
                ->whereIn('task_sub_funds.sub_funds_id',$where_subfunds)
                ->whereIn('task_tags.task_tag_id',$where_tags)
                ->select('tasks.*')
                ->distinct()->get();
            }
            else
            {
                

                $tasks = Tasks::with('task_clients','task_documents','task_department','task_funds','task_subfunds')
                ->join('task_documents','task_documents.task_id','=','tasks.id')
                ->join('task_clients','task_clients.task_id','=','tasks.id')
                ->join('task_departments','task_departments.task_id','=','tasks.id')
                ->join('task_fund_groups','task_fund_groups.task_id','=','tasks.id')
                ->join('task_sub_funds','task_sub_funds.task_id','=','tasks.id')
                ->join('task_tags','task_tags.task_id','=','tasks.id')
                ->where('tasks.task_type',1)
                ->whereIn('task_documents.document_id',$where_document)
                ->whereIn('task_clients.client_id',$where_client)
                ->whereIn('task_departments.department_id',$where_department1)
                ->whereIn('task_fund_groups.fund_group_id',$where_funds)
                ->whereIn('task_sub_funds.sub_funds_id',$where_subfunds)
                ->select('tasks.*')
                ->distinct()->get();  
            }

            // $tasks = Tasks::with('task_clients','task_documents','task_department','task_funds','task_subfunds')->join('task_documents','task_documents.task_id','=','tasks.id')->join('task_clients','task_clients.task_id','=','tasks.id')->join('task_departments','task_departments.task_id','=','tasks.id')->join('task_fund_groups','task_fund_groups.task_id','=','tasks.id')->join('task_sub_funds','task_sub_funds.task_id','=','tasks.id')->whereIn('task_documents.document_id',$where_document)->whereIn('task_clients.client_id',$where_client)->whereIn('task_departments.department_id',$where_department)->whereIn('task_fund_groups.fund_group_id',$where_funds)->whereIn('task_sub_funds.sub_funds_id',$where_subfunds)->select('tasks.*')->distinct()->get();

            $reportData['template']['name'] = env('AUDIT_REPORT_URL');
            $reportData['data']['reportName'] = $report->name;
            $reportData['data']['reportedOn'] = date("F d Y");
            $reportData['data']['calendarPeriod'] = date_format(date_create($report->last_run),"d-m-Y")." to ".date('d-m-Y');

            $inc = $exception_inc = 0;
            $task_satisfactory_count = $task_challenge_count = $task_overdue_count = 0;

            $document_name = $department_name = $clients_name = $fund_name = $sub_fund_name = array();


            foreach($tasks as $task){

                $taskDetails = self::getFieldValues($task->id);

                $current_task_departent = $current_task_pages =  $current_task_client = $current_task_document = $current_task_fund_group = $current_task_sub_fund_group = array();

                $taskcompletedby = ($task->completed_by===NULL)?NULL:CompanyUsers::join('users','users.id','=','company_users.user_id')->where('company_users.id',$task->completed_by)->select('users.name')->first();

                if($taskcompletedby !== NULL){
                    $taskcompletedby = decryptKMSvalues($taskcompletedby->name);
                }else{
                    $taskcompletedby = '-';
                }

                foreach($task->task_documents as $reportdocumentdata){
                    $document_name[$reportdocumentdata->document->document_name] = $reportdocumentdata->document->document_name;
                    $current_task_document[$reportdocumentdata->document->document_name] = $reportdocumentdata->document->document_name;

                    $current_task_pages[$reportdocumentdata->document_specific_page] = $reportdocumentdata->document_specific_page;
                }

                foreach($task->task_department as $departmentsdata){
                    $department_name[$departmentsdata->departments->name] = $departmentsdata->departments->name;
                    $current_task_departent[$departmentsdata->departments->name] = $departmentsdata->departments->name;
                }

                foreach($task->task_clients as $clientsdata){
                    $clients_name[$clientsdata->clients->client_name] = $clientsdata->clients->client_name;
                    $deathline_priority = $clientsdata->clients->deadline_priority;
                    $current_task_client[$clientsdata->clients->client_name]=$clientsdata->clients->client_name;
                }

                foreach($task->task_funds as $funddata){
                    $fund_name[$funddata->fundgroups->fund_group_name] = $funddata->fundgroups->fund_group_name;
                    $current_task_fund_group[$funddata->fundgroups->fund_group_name] = $funddata->fundgroups->fund_group_name;
                }

                foreach($task->task_subfunds as $subfunddata){
                    $sub_fund_name[$subfunddata->subfunds->sub_fund_name] = $subfunddata->subfunds->sub_fund_name;
                    $current_task_sub_fund_group[$subfunddata->subfunds->sub_fund_name] = $subfunddata->subfunds->sub_fund_name;
                }
                if(isset($task->task_tagging))
                {
                    $tagval = '';
                    foreach($task->task_tagging as $tagvalue)
                    {
                    $tagval.=",".$tagvalue->name;
                    }
                    $valueofselectedtags = substr($tagval,1);
               }

                $taskOutCome = TaskFilter::task_status($task, $deathline_priority);

                if($taskOutCome == 'OVERDUE'){
                    $task_overdue_count++;
                }

                if($taskOutCome == 'COMPLETED WITH CHALLENGE'){
                    $task_challenge_count++;
                }

                if($taskOutCome == 'COMPLETED'){
                    $task_satisfactory_count++;
                }
                if($inc < 10){
                $reportData['data']['tasks_details'][$inc]['taskName'] = $taskDetails['task_name'];
                $reportData['data']['tasks_details'][$inc]['frequency'] =  $taskDetails['frequency'];
                $reportData['data']['tasks_details'][$inc]['completion_date'] = ($task->completed_date_by_assignee)?date_format(date_create($task->completed_date_by_assignee),"F Y m"):'-';
                $reportData['data']['tasks_details'][$inc]['outcome'] = TaskFilter::task_status($task, $deathline_priority);
                $reportData['data']['tasks_details'][$inc]['department'] = implode(", ",$current_task_departent);
                $reportData['data']['tasks_details'][$inc]['completed_by'] = $taskcompletedby;
                $reportData['data']['tasks_details'][$inc]['reference_page'] = implode(", ",$current_task_pages);
                }
                else
                {
                    $additional_index = (int)$inc/10;
                    $reportData['data']['tasks_additional_details'][$additional_index]['inner_data'][$inc]['taskName'] = $taskDetails['task_name'];
                    $reportData['data']['tasks_additional_details'][$additional_index]['inner_data'][$inc]['frequency'] =  $taskDetails['frequency'];
                    $reportData['data']['tasks_additional_details'][$additional_index]['inner_data'][$inc]['completion_date'] = ($task->completed_date_by_assignee)?date_format(date_create($task->completed_date_by_assignee),"F Y m"):'-';
                    $reportData['data']['tasks_additional_details'][$additional_index]['inner_data'][$inc]['outcome'] = TaskFilter::task_status($task, $deathline_priority);
                    $reportData['data']['tasks_additional_details'][$additional_index]['inner_data'][$inc]['department'] = implode(", ",$current_task_departent);
                    $reportData['data']['tasks_additional_details'][$additional_index]['inner_data'][$inc]['completed_by'] = $taskcompletedby;
                    $reportData['data']['tasks_additional_details'][$additional_index]['inner_data'][$inc]['reference_page'] = implode(", ",$current_task_pages);
                }
                $inc++;
                if($task->task_challenge_status == 1){
                    $reportData['data']['exception_tasks'][$exception_inc]['exception_title'] = 'Compliance Audit Report – Exception Detail';
                    $reportData['data']['exception_tasks'][$exception_inc]['document_under_review'] = implode(", ",$current_task_document);
                    $reportData['data']['exception_tasks'][$exception_inc]['run_date'] = date("d F Y");
                    $reportData['data']['exception_tasks'][$exception_inc]['taskName'] = $taskDetails['task_name'];
                    $reportData['data']['exception_tasks'][$exception_inc]['client'] = implode(", ",$current_task_client);
                    $reportData['data']['exception_tasks'][$exception_inc]['fund_group'] = implode(", ",$current_task_fund_group);
                    $reportData['data']['exception_tasks'][$exception_inc]['sub_fund'] = implode(", ",$current_task_sub_fund_group);
                    $reportData['data']['exception_tasks'][$exception_inc]['task_outcome'] = 'COMPLETED WITH CHALLENGE';
                    $reportData['data']['exception_tasks'][$exception_inc]['commentary'] =isset($valueofselectedtags)?$valueofselectedtags:'';
                    $reportData['data']['exception_tasks'][$exception_inc]['task_frequency'] = $taskDetails['frequency'];
                    $reportData['data']['exception_tasks'][$exception_inc]['last_completed_by'] = $taskcompletedby;
                    $reportData['data']['exception_tasks'][$exception_inc]['completion_date'] = date_format(date_create($task->due_date),"Y/m/d");
                    $reportData['data']['exception_tasks'][$exception_inc]['next_completion_date'] = '-';
                    $reportData['data']['exception_tasks'][$exception_inc]['task_initiation_date'] = date_format(date_create($task->created_at),"d F Y");
                    $reportData['data']['exception_tasks'][$exception_inc]['page_reference'] = implode(", ", $current_task_pages);
                    $exception_inc++;
                }
            }

            $reportData['data']['satisfactory_count'] = $task_satisfactory_count;
            $reportData['data']['challenge_count'] = $task_challenge_count;
            $reportData['data']['overdue_count'] = $task_overdue_count;

            $reportData['data']['documentName'] = implode(", ",$document_name);
            $reportData['data']['departments'] = $valueofselecteddepartments;
            $reportData['data']['clients'] = implode(", ",$clients_name);
            $reportData['data']['fundGroup'] = $valueofselectedfundgroups;
            $reportData['data']['subFund'] = $valueofselectedsubfundgroups;
            return json_encode($reportData);

    }
    public static function activityData($report, $reportConstraints)
    {
            $where_client = $reportConstraints->report_clients->pluck('client_id');
            $where_document = $reportConstraints->report_documents->pluck('document_id');
            $where_department = $reportConstraints->report_department->pluck('department_id');
            $where_funds = $reportConstraints->report_funds->pluck('fund_group_id');
            $where_subfunds = $reportConstraints->report_subfunds->pluck('report_sub_fund_id');

            $tasks = Tasks::with('task_clients','task_documents','task_department','task_funds','task_subfunds')
            ->join('task_documents','task_documents.task_id','=','tasks.id')
            ->join('task_clients','task_clients.task_id','=','tasks.id')
            ->join('task_departments','task_departments.task_id','=','tasks.id')
            ->join('task_fund_groups','task_fund_groups.task_id','=','tasks.id')
            ->join('task_sub_funds','task_sub_funds.task_id','=','tasks.id')
            ->where('tasks.task_type',1)
            ->whereIn('task_documents.document_id',$where_document)
            ->whereIn('task_clients.client_id',$where_client)
            ->whereIn('task_departments.department_id',$where_department)
            ->whereIn('task_fund_groups.fund_group_id',$where_funds)
            ->whereIn('task_sub_funds.sub_funds_id',$where_subfunds)
            ->select('tasks.*')
            ->distinct()->get();

            $reportData['template']['name'] = env('ACTIVITY_REPORT_URL');
            $reportData['data']['reportName'] = $report->name;
            $reportData['data']['reportedOn'] = date("F d Y");
            $reportData['data']['calendarPeriod'] = date_format(date_create($report->last_run),"d-m-Y")." to ".date('d-m-Y');

            $inc = $exception_inc = 0;
            $task_satisfactory_count = $task_challenge_count = $task_overdue_count = 0;
            $document_name = $department_name = $clients_name = $fund_name = $sub_fund_name = array();

            Log::debug('************');
            Log::debug(env('ACTIVITY_REPORT_URL'));
            Log::debug('************');
            
            foreach($tasks as $task){

                $taskDetails = self::getFieldValues($task->id);
                $tagdetails=TaskTag::join('tagging','tagging.id','task_tags.task_tag_id')->where('task_tags.task_id',$task->id)->distinct()->get();

                foreach($tagdetails as $tags)
                {
                    $tag_details[]=$tags->name;
                }

                $current_task_departent = $current_task_pages =  $current_task_client = $current_task_document = $current_task_fund_group = $current_task_sub_fund_group = array();

                $taskcompletedby = ($task->completed_by===NULL)?NULL:CompanyUsers::join('users','users.id','=','company_users.user_id')->where('company_users.id',$task->completed_by)->select('users.name')->first();

                if($taskcompletedby !== NULL){
                    $taskcompletedby = decryptKMSvalues($taskcompletedby->name);
                }else{
                    $taskcompletedby = '-';
                }
                foreach($task->task_documents as $reportdocumentdata){
                    $document_name[$reportdocumentdata->document->document_name] = $reportdocumentdata->document->document_name;
                    $current_task_document[$reportdocumentdata->document->document_name] = $reportdocumentdata->document->document_name;
                    $current_task_pages[$reportdocumentdata->document_specific_page] = $reportdocumentdata->document_specific_page;
                }
                foreach($task->task_department as $departmentsdata){
                    $department_name[$departmentsdata->departments->name] = $departmentsdata->departments->name;
                    $current_task_departent[$departmentsdata->departments->name] = $departmentsdata->departments->name;
                }
                foreach($task->task_clients as $clientsdata){
                    $clients_name[$clientsdata->clients->client_name] = $clientsdata->clients->client_name;
                    $deathline_priority = $clientsdata->clients->deadline_priority;
                    $current_task_client[$clientsdata->clients->client_name]=$clientsdata->clients->client_name;
                }
                foreach($task->task_funds as $funddata){
                    $fund_name[$funddata->fundgroups->fund_group_name] = $funddata->fundgroups->fund_group_name;
                    $current_task_fund_group[$funddata->fundgroups->fund_group_name] = $funddata->fundgroups->fund_group_name;
                }
                foreach($task->task_subfunds as $subfunddata){
                    $sub_fund_name[$subfunddata->subfunds->sub_fund_name] = $subfunddata->subfunds->sub_fund_name;
                    $current_task_sub_fund_group[$subfunddata->subfunds->sub_fund_name] = $subfunddata->subfunds->sub_fund_name;
                }

                $taskOutCome = TaskFilter::task_status($task, $deathline_priority);

                if($taskOutCome == 'OVERDUE'){
                    $task_overdue_count++;
                  
                }
                if($taskOutCome == 'COMPLETED WITH CHALLENGE'){
                    $task_challenge_count++;
                   
                }
                if($taskOutCome == 'COMPLETED'){
                    $task_satisfactory_count++;
                   
                }
		
                $tskstatus='';
                if(TaskFilter::task_status($task, $deathline_priority)=="COMPLETED WITH CHALLENGE")
                {
                    $tskstatus="completed_with_challenge";
                }
                if(TaskFilter::task_status($task, $deathline_priority)=="COMPLETED")
                {
                    $tskstatus="completed";
                }
                if(TaskFilter::task_status($task, $deathline_priority)=="OVERDUE")
                {
                    $tskstatus="overdue";
                }


                $reportData['data']['tasks_details'][$inc]['taskName'] = $taskDetails['task_name'];
                $reportData['data']['tasks_details'][$inc]['frequency'] =  $taskDetails['frequency'];
                $reportData['data']['tasks_details'][$inc]['client'] =  implode(", ",$current_task_client);
                $reportData['data']['tasks_details'][$inc]['completion_date'] = ($task->completed_date_by_assignee)?date_format(date_create($task->completed_date_by_assignee),"F Y m"):'-';
                $reportData['data']['tasks_details'][$inc]['outcome'] = TaskFilter::task_status($task, $deathline_priority);
                $reportData['data']['tasks_details'][$inc]['tskstatus']=$tskstatus;
                $reportData['data']['tasks_details'][$inc]['department'] = implode(", ",$current_task_departent);
                $reportData['data']['tasks_details'][$inc]['completed_by'] = $taskcompletedby;
                $reportData['data']['tasks_details'][$inc]['reference_page'] = implode(", ",$current_task_pages);
                $inc++;

                if($task->task_challenge_status == 1){
                    $reportData['data']['exception_tasks'][$exception_inc]['exception_title'] = 'Compliance Audit Report – Exception Detail';
                    $reportData['data']['exception_tasks'][$exception_inc]['document_under_review'] = implode(", ",$current_task_document);
                    $reportData['data']['exception_tasks'][$exception_inc]['run_date'] = date("d F Y");
                    $reportData['data']['exception_tasks'][$exception_inc]['taskName'] = $taskDetails['task_name'];
                    $reportData['data']['exception_tasks'][$exception_inc]['client'] = implode(", ",$current_task_client);
                    $reportData['data']['exception_tasks'][$exception_inc]['fund_group'] = implode(", ",$current_task_fund_group);
                    $reportData['data']['exception_tasks'][$exception_inc]['sub_fund'] = implode(", ",$current_task_sub_fund_group);
                    $reportData['data']['exception_tasks'][$exception_inc]['task_outcome'] = 'COMPLETED WITH CHALLENGE';
                    $reportData['data']['exception_tasks'][$exception_inc]['commentary'] = isset($tag_details)?array_unique($tag_details):'-';
                    $reportData['data']['exception_tasks'][$exception_inc]['task_frequency'] = $taskDetails['frequency'];
                    $reportData['data']['exception_tasks'][$exception_inc]['last_completed_by'] = $taskcompletedby;
                    $reportData['data']['exception_tasks'][$exception_inc]['completion_date'] = date_format(date_create($task->due_date),"Y/m/d");
                    $reportData['data']['exception_tasks'][$exception_inc]['next_completion_date'] = '-';
                    $reportData['data']['exception_tasks'][$exception_inc]['task_initiation_date'] = date_format(date_create($task->created_at),"d F Y");
                    $reportData['data']['exception_tasks'][$exception_inc]['page_reference'] = implode(", ", $current_task_pages);
                    $exception_inc++;
                }
            }

            $reportData['data']['satisfactory_count'] = $task_satisfactory_count;
            $reportData['data']['challenge_count'] = $task_challenge_count;
            $reportData['data']['overdue_count'] = $task_overdue_count;
            $reportData['data']['documentName'] = implode(", ",$document_name);
            $reportData['data']['departments'] = implode(", ",$department_name);
            $reportData['data']['clients'] = implode(", ",$clients_name);
            $reportData['data']['fundGroup'] = implode(", ",$fund_name);
            $reportData['data']['subFund'] = implode(", ",$sub_fund_name);
            return json_encode($reportData);

    }

    public static function getFieldValues($task_id){
                    $fieldvalue = TaskFieldValue::with('getTaskFieldType','getTaskFieldType.getFieldType')
                    ->where('task_id',$task_id)
                    ->get();
                    $taskFieldDetails=[];
                    if($fieldvalue)
                    {
                        foreach($fieldvalue as $taskFieldValues)
                        {
                            $type=$taskFieldValues->getTaskFieldType->getFieldType->code;
                            if($type=='dropdown_value')
                            {
                                $dropDownID=$taskFieldValues->dropdown_value_id;
                                $taskdropDownFieldValue=FieldDropdownValue::where('id',$dropDownID)->first();
                                $taskFieldDetails[$taskFieldValues->getTaskFieldType->code]=$taskdropDownFieldValue?$taskdropDownFieldValue->dropdown_name:'';
                            }
                            else
                            {
                                $taskFieldDetails[$taskFieldValues->getTaskFieldType->code]=$taskFieldValues->$type;
                            }
                            
                        }
                    }

                return $taskFieldDetails;
    }
    public function tagging($tag,$reportdet,$companylist,$type)
    {
        $tags=explode(",", $tag);
        foreach($tags as $list)
        {
              $cntofrecords=Tagging::where('name','like',$list)->count();
              if($cntofrecords>0)
              {
                  $cntofrecords=Tagging::where('name','like',$list)->first();

                  try{
                  ReportTag::create([
                      'tag_id'=>$cntofrecords->id,
                      'report_id'=>$reportdet->id,
                      'company_id'=>$companylist->company_id,
                      'tagtype_id'=>$type
                  ]);
                }
                  catch (\Exception $e) {
                    Log::info("Check Store Reports on ReportSchedulingTraits page" . $e);
                  } 
              }
              else
              {
                   $tagins=Tagging::create([
                        'name'=>$list,
                        'code'=>$list,
                        'company_id'=>$companylist->company_id
                   ]);

                   if($tagins)
                    {
                        try{
                                ReportTag::create([
                                    'tag_id'=>$tagins->id,
                                    'report_id'=>$reportdet->id,
                                    'company_id'=>$companylist->company_id,
                                    'tagtype_id'=>$type
                                ]); 
                          }
                          catch (\Exception $e) {
                            Log::info("Check Store Reports on ReportSchedulingTraits page" . $e);
                          } 
                   }
              }
          }
    }
}