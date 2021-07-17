<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubFunds extends Model
{
    use SoftDeletes;
    //
    protected $table = "sub_funds";
    protected $fillable = [
        'sub_fund_name','sub_fund_avatar','fund_group_id','investment_strategy','investment_manager','initial_launch_date','created_by','active_status'
    ];

    public function getkeycontactslist()
    {
        return $this->hasMany('App\SubFundsKeyContact','sub_funds_id');
    }
}
