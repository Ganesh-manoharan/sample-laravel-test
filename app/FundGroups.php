<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class FundGroups extends Model
{
    use SoftDeletes;
    protected $table = "fund_groups";
    protected $fillable = [
        'avatar','fund_group_name','registered_address','entity_type','management','administrator','depository','auditor','accounting_year_end','initial_launch_date','country_id','amount','created_by'
    ];
    public static function fundgroups_list()
    {
        $cmp = CompanyUsers::where('user_id',auth()->user()->id)->first();
        return FundGroups::join('company_fund_groups','company_fund_groups.fund_group_id','fund_groups.id')->where('company_fund_groups.company_id',$cmp->company_id)->select('company_fund_groups.id as company_fund_group_id','company_fund_groups.*','fund_groups.*')->get();
    }
    public  function getsubfundslist()
    {
        return $this->hasMany('App\SubFunds','fund_group_id');
    }
    public function getcompanyfundslist()
    {
        return $this->hasMany('App\CompanyFund','fund_group_id');
    }
    public function getcountrylist()
    {
        return $this->belongsTo('App\Countries','country_id');
    }
    public function getkeycontactslist()
    {
        return $this->hasMany('App\FundsKeyContact','fund_group_id');
    }
    public static function getfundslist($id)
    {
        return FundGroups::with('getsubfundslist')->get();
    }
   
    public static function client_funds($id)
    {
        return FundGroups::with('getsubfundslist')->join('company_fund_groups','company_fund_groups.fund_group_id','fund_groups.id')->join('client_fund_groups','client_fund_groups.company_fund_group_id','company_fund_groups.id')->where('client_fund_groups.client_id', $id)->select('client_fund_groups.id as action_id','company_fund_groups.id as notIn_id','fund_groups.*')->get();
    }

    public static function fund_notWith_client($funds, $cmpId)
    {
        return FundGroups::join('company_fund_groups','company_fund_groups.fund_group_id','fund_groups.id')->whereNotIn('company_fund_groups.id', $funds)->where('company_fund_groups.company_id',$cmpId)->select('fund_groups.*','company_fund_groups.id as action_id')->get();
    }

}
