<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyFund extends Model
{
    protected $table = 'company_fund_groups';
    protected $fillable = [
        'company_id','fund_group_id','active_status'
    ];

    public static function storecompanyfunds($request,$id)
    {
    foreach ($request->fund_groups as $item) {

        CompanyFund::create([
            'fund_group_id' => $item,
            'company_id'=>$id
        ]);
    }
  } 
  
  public static function storefundgroups($request,$id)
    {
        foreach ($request->fund_groups as $item) {
            CompanyFund::create([
                'fund_group_id' => $item,
                'company_id'=>$id
            ]);
        }
    }
}
