<?php
namespace App\Http\Traits;
use App\FundGroups;
use App\AppConst;

trait FundList
{
    public static function fund_list_with_data($paginate = null, $search = null)
    {
        if($search!=""){
            $fundlist = FundGroups::with('getsubfundslist')->where('status', 1)->where('fund_group_name', 'like',"%".strtoupper($search)."%")->paginate(config(AppConst::COMMON_PAGINATE));
        }
        else
        {
            $fundlist =FundGroups::with('getsubfundslist')->where('status', 1)->orderBy('fund_groups.id','DESC')->paginate(config(AppConst::COMMON_PAGINATE));
        }
        return $fundlist;
     
    }
}
?>
