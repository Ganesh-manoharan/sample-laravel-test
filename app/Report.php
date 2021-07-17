<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;
    protected $table = "report";
    protected $fillable = [
        'name','frequency','report_type_id','last_run','last_run_status','company_id','period'
    ];

    public  function Departmentlist()
    {
        return $this->hasMany('App\ReportDepartment','report_id')->join('departments','departments.id','report_departments.department_id');
    }
    public  function Documentlist()
    {
        return $this->hasMany('App\ReportDocument','report_id')->join('documents','documents.id','report_documents.document_id');
    }
    public  function clientlist()
    {
        return $this->hasMany('App\ReportClient','report_id')->join('clients','clients.id','report_clients.client_id');
    }
    public  function fundgrouplist()
    {
        return $this->hasMany('App\ReportFund','report_id')->join('fund_groups','fund_groups.id','report_funds.fund_group_id');
    }
    public  function subfundlist()
    {
        return $this->hasMany('App\ReportSubFund','report_id')->join('sub_funds','sub_funds.id','report_sub_funds.report_sub_fund_id');
    }

    public function report_clients()
    {
        return $this->hasMany('App\ReportClients');
    }

    public function report_department()
    {
        return $this->hasMany('App\ReportDepartments');
    }

    public function report_documents()
    {
        return $this->hasMany('App\ReportDocuments');
    }

    public function report_funds()
    {
        return $this->hasMany('App\ReportFunds');
    }

    public function report_subfunds()
    {
        return $this->hasMany('App\ReportSubfunds');
    }
    
    public function report_tag()
    {
        return $this->hasMany('App\ReportTag');
    }

    public function get_risk_category()
    {
        return $this->hasOne('App\ReportRiskCategory','report_id','id')->join('risk_categories','risk_categories.id','=','report_risk_categories.risk_category_id')->select('report_risk_categories.*','risk_categories.title');
    }
    public function get_child_category()
    {
        return $this->hasOne('App\ReportRiskSubCategory','report_id','id')->join('risk_categories','risk_categories.id','=','report_risk_subcategories.risk_subcategory_id')->select('report_risk_subcategories.*','risk_categories.title');
    }

    public static function updateReportStatus($report, $status)
    {
        return Report::where('id',$report->id)->update([
                                                    'last_run' => date('Y-m-d H:i:s'),
                                                    'last_run_status' => $status,
                                                ]);
    }
}
