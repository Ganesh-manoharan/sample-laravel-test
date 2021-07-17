<?php

namespace App\Http\Controllers\Reports;

use App\AppConst;
use App\Http\Controllers\Controller;
use App\Http\Traits\UserAccess;
use Illuminate\Http\Request;
use App\Report;
use App\ReportType;
use App\Frequency;
use App\Documents;
use App\Client;
use App\Company;
use App\FundGroups;
use App\SubFunds;
use App\CompanyUsers;
use App\ClientDepartment;
use App\ReportDocument;
use App\ReportClient;
use App\ReportDepartment;
use App\ReportFund;
use App\ReportSubFund;
use App\Departments;
use App\ReportList;
use Illuminate\Support\Facades\Log;
use App\RiskScore;
use App\ImpactRating;
use App\RiskCategory;
use App\TaskField;
use App\ReportRiskScore;
use App\ReportRiskCategory;
use App\ReportRiskSubCategory;
use App\RiskIssueImpactRating;
use App\Tagging;
use App\ReportTag;
use App\Http\Traits\ReportSchedulingTrait;

class ReportsController extends Controller
{
    use UserAccess, ReportSchedulingTrait;
    public function index()
    {
        return view('admin.reports.home');
    }

    public function jsreport()
    {
        $redirectUrl = env('DOMAIN_URL').'/admin/displayreport';
        return redirect($redirectUrl);
    }

    public function schedule(Request $request)
    {
        $tmp = Report::where('company_id', $request->get('cmpId'));
        $data = $this->report_list($tmp);
        if($request->search || $request->page){
            $data = $data->where('report.name', 'LIKE', "%".$request->search ."%")->paginate(config(AppConst::COMMON_PAGINATE)); 
            $content = view('manager.reports.reports_list', compact('data'))->render();
            $pagination = view('includes.pagination', compact('data'))->render();
            return ['data'=>$content,'pagination'=>$pagination];
        }
        $data = $data->orderBy('id', 'DESC')->paginate(config(AppConst::COMMON_PAGINATE));
        $report_type = ReportType::all();
        $frequency_list = Frequency::all();
        $companylist = CompanyUsers::where('user_id', '=', Auth()->user()->id)->first();
        $document_list = Documents::where('company_id', $companylist->company_id)->get();

        //$department_list=Departments::with('departmentlist')->where('company_departments.company_id',1)->get();

        $department_list = Departments::join('company_departments', 'company_departments.department_id', 'departments.id')->where('company_departments.company_id', $request->get('cmpId'))->get();

        $client_list = Client::select('clients.*');
        $client_list = self::client_access($client_list)->get();
       // $fundgroups_list = FundGroups::all();
        $fundgroups_list = FundGroups::join('company_fund_groups', 'company_fund_groups.fund_group_id', 'fund_groups.id')->where('company_fund_groups.company_id', $request->get('cmpId'))->select('fund_groups.*')->get();
        $riskscore_list = TaskField::join('field_dropdown_values', 'field_dropdown_values.task_field_id', '=', 'task_fields.id')->where('task_fields.code', 'risk_response')->select('field_dropdown_values.*')->get();
        // $impactrating_list=ImpactRating::all();
        $impactrating_list = TaskField::join('field_dropdown_values', 'field_dropdown_values.task_field_id', '=', 'task_fields.id')->where('task_fields.code', 'impact__rating')->select('field_dropdown_values.*')->get();
        $riskcategory_list = RiskCategory::all();

        return view('manager.reports.home', compact('data', 'report_type', 'frequency_list', 'document_list', 'companylist', 'client_list', 'fundgroups_list', 'riskscore_list', 'impactrating_list', 'riskcategory_list', 'department_list'))->with(['page' => 'Reports']);
    }

    public function create_reports(Request $request)
    {
     
                try{ 
                    $reportdet=Report::create([
                        'name'=>$request->report_name,
                        'frequency'=>$request->frequency,
                        'report_type_id'=>$request->report_type,
                        'last_run'=>now(),
                        'company_id'=>$request->company_id
                    ]);
                    $companylist = CompanyUsers::where('user_id', '=', Auth()->user()->id)->first();

                    if($request->tags)
                    {
                          $tags=explode(",", $request->tags);
                          foreach($tags as $list)
                          {
                                $cntofrecords=Tagging::where('name','like',$list)->count();
                                if($cntofrecords>0)
                                {
                                    $cntofrecords=Tagging::where('name','like',$list)->first();
                                   
                                    ReportTag::create([
                                        'tag_id'=>$cntofrecords->id,
                                        'report_id'=>$reportdet->id,
                                        'company_id'=>$companylist->company_id
                                    ]);
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
                                        ReportTag::create([
                                            'tag_id'=>$tagins->id,
                                            'report_id'=>$reportdet->id,
                                            'company_id'=>$companylist->company_id
                                        ]); 
                                    }
                                }

                            }
                    }

                    if($reportdet)
                    {
                        if($request->report_type==1 || $request->report_type==4)
                        {
                            foreach($request->document as $item)
                            {
                                ReportDocument::create([
                                    'document_id'=>$item,
                                    'report_id'=>$reportdet->id
                                ]);
                            }

                            if($request->clients)
                            {
                                ReportClient::create([
                                    'client_id'=>$request->clients,
                                    'report_id'=>$reportdet->id
                                ]);
                            }

                            foreach($request->departments as $item)
                            {
                                ReportDepartment::create([
                                    'department_id'=>$item,
                                    'report_id'=>$reportdet->id

                                ]);
                            }

                            foreach($request->fund_groups as $item)
                            {
                                 ReportFund::create([
                                    'fund_group_id'=>$item,
                                    'report_id'=>$reportdet->id
                                 ]);
                            }

                            foreach($request->subfunds as $item)
                            {
                                  ReportSubFund::create([
                                        'report_sub_fund_id'=>$item,
                                        'report_id'=>$reportdet->id
                                  ]);
                            }

                        }
                        elseif($request->report_type==2)
                        {
                            if($request->risk_score)
                            {
                                ReportRiskScore::create([
                                    'report_score_id'=>$request->risk_score,
                                    'report_id'=>$reportdet->id
                                ]);
                            }
                             
                            if($request->risk_departments)
                            {
                                foreach($request->risk_departments as $item)
                                {
                                    ReportDepartment::create([
                                        'department_id'=>$item,
                                        'report_id'=>$reportdet->id
                                    ]);
                                }
                            }

                            if($request->risk_category)
                            {
                                     ReportRiskCategory::create([
                                         'risk_category_id'=>$request->risk_category,
                                         'report_id'=>$reportdet->id
                                     ]);
                            }

                            if($request->subcategory)
                            {
                                ReportRiskSubCategory::create([
                                    'risk_subcategory_id'=>$request->subcategory,
                                    'report_id'=>$reportdet->id
                                ]);
                            }

                        }
                        elseif($request->report_type==3){
                                    
                            if($request->impact_rating)
                            {
                                RiskIssueImpactRating::create([
                                     'impact_rating_id'=>$request->impact_rating,
                                     'report_id'=>$reportdet->id
                                ]);
                            }

                            if($request->clients)
                            {
                                ReportClient::create([
                                      'client_id'=>$request->clients,
                                      'report_id'=>$reportdet->id
                                ]);
                            }
                                   
                            foreach($request->departments as $item)
                            {
                                ReportDepartment::create([
                                        'department_id'=>$item,
                                        'report_id'=>$reportdet->id
                                ]);
                            }
                                   
                            foreach($request->fund_groups as $item)
                            {
                                ReportFund::create([
                                        'fund_group_id'=>$item,
                                        'report_id'=>$reportdet->id
                                ]);
                            }
                                   
                            foreach($request->subfunds as $item)
                            {
                                ReportSubFund::create([
                                        'report_sub_fund_id'=>$item,
                                        'report_id'=>$reportdet->id
                                ]);
                            }

                        }

                        if($request->frequency == 'Ad Hoc'){
                            $this->adhocreport($reportdet->id, $request->company_id);
                        }
                                   
                    }

                    return redirect()->route('report_schedule');
                }
                catch (\Exception $e) {
                    Log::info("Locked user attempt for Reset" . $e);
             }   
    }

    public function adhocreport($reportId, $companyId){

        try{
            $report = Report::join('report_type','report.report_type_id','=','report_type.id')->select('report.*','report_type.code')->where('report.id', $reportId)->first();

            $company = Company::where('id', $companyId)->first();

            $generatedReports = ReportSchedulingTrait::getReportData($report);
            $storageData = ReportSchedulingTrait::generateReportJs($generatedReports['data'], $company, $generatedReports['format']);

            $status = ReportList::saveReport($report, $storageData);
            if($status){
                Report::updateReportStatus($report,1);
            }else{
                Report::updateReportStatus($report,0);
            }

            return true;
        }catch (\Exception $e){
            Log::info("Error in report creation" . $e);
        }

    }
       
    

    public function update_reports(Request $request)
    {

        try {

            $reportsupdate = Report::where('id', $request->editReportID)->update([
                'name' => $request->report_name,
                'frequency' => $request->frequency,
                'report_type_id' => $request->report_type,
                'last_run' => now(),
                'company_id' => $request->company_id
            ]);


            if ($reportsupdate) {
                if (isset($request->document)) {
                    foreach ($request->document as $item) {
                        ReportDocument::create([
                            'document_id' => $item,
                            'report_id' => $request->editReportID
                        ]);
                    }
                }
                if (isset($request->clients)) {
                    ReportClient::where('report_id', $request->editReportID)->update([
                        'client_id' => $request->clients,
                        'report_id' => $request->editReportID
                    ]);
                }

                if (isset($request->departments)) {
                    foreach ($request->departments as $item) {
                        ReportDepartment::create([
                            'department_id' => $item,
                            'report_id' => $request->editReportID
                        ]);
                    }
                }

                if (isset($request->fund_groups)) {
                    foreach ($request->fund_groups as $item) {
                        ReportFund::create([
                            'fund_group_id' => $item,
                            'report_id' => $request->editReportID
                        ]);
                    }
                }

                if (isset($request->subfunds)) {
                    foreach ($request->subfunds as $item) {
                        ReportSubFund::create([
                            'report_sub_fund_id' => $item,
                            'report_id' => $request->editReportID
                        ]);
                    }
                }
            }

            return redirect()->route('report_schedule');
        } catch (\Exception $e) {
            Log::info("Locked user attempt for Reset" . $e);
        }
    }

    public function fetchsubcategory(Request $request)
    {
        return RiskCategory::where('parent_id', $request->riskcategoryid)->get();
    }

    public function viewreportdetails(Request $request, $id)
    {
        $data_report = Report::with('Departmentlist', 'Documentlist', 'clientlist', 'fundgrouplist', 'subfundlist')->where('id', $id)->first();
        $data = ReportList::where('report_id', $id)->OrderBy('id', 'DESC')->paginate(config(AppConst::COMMON_PAGINATE));
        $report_type = ReportType::all();
        $frequency_list = Frequency::all();
        $client_list = Client::all();

        $docs = [];
        $deps = [];
        $funds = [];
        $subfunds = [];
        foreach ($data_report['Documentlist'] as $item) {
            $docs[] = $item->document_id;
        }
        foreach ($data_report['Departmentlist'] as $item) {
            $deps[] = $item->id;
        }
        foreach ($data_report['fundgrouplist'] as $item) {
            $funds[] = $item->id;
        }
        foreach ($data_report['subfundlist'] as $item) {
            $subfunds[] = $item->id;
        }

        $document_list = Documents::whereNotIn('id', $docs)->where('company_id', $request->get('cmpId'))->get();
        $departmentlist = Departments::whereNotIn('id', $deps)->get();
        $fundgrouplist = FundGroups::whereNotIn('id', $funds)->get();
        $subfundslist = SubFunds::whereNotIn('id', $subfunds)->get();

        $riskscore_list = ReportRiskScore::join('field_dropdown_values', 'field_dropdown_values.id', '=', 'report_risk_score.report_score_id')->where('report_risk_score.report_id', $id)->get();

        $impactrating_list = RiskIssueImpactRating::join('field_dropdown_values', 'field_dropdown_values.id', 'risk_issue_impactrating.impact_rating_id')->where('risk_issue_impactrating.report_id', $id)->get();

        $riskcategorylist = ReportRiskCategory::join('risk_categories', 'risk_categories.id', '=', 'report_risk_categories.risk_category_id')->where('report_risk_categories.report_id', $id)->get();

        $risksubcategorylist = ReportRiskSubCategory::join('risk_categories', 'risk_categories.id', '=', 'report_risk_subcategories.risk_subcategory_id')->where('report_risk_subcategories.report_id', $id)->get();
        return view('manager.reports.view_report_detail', compact('data', 'data_report', 'report_type', 'frequency_list', 'client_list', 'document_list', 'departmentlist', 'fundgrouplist', 'subfundslist', 'riskscore_list', 'riskcategorylist', 'risksubcategorylist', 'impactrating_list'))->with(['page' => 'Back', 'page_url' => route('report_schedule'), 'back_button' => 'fas fa-angle-left mr-3']);
    }

    public function deletereports(Request $request)
    {
        Report::find($request->id)->delete();
        return redirect()->route('report_schedule');
    }

    public function fetchtags(Request $request)
    {
        return Tagging::all();
    }
}
