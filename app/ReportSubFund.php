<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportSubFund extends Model
{
    protected $table = "report_sub_funds";
    protected $fillable = [
        'report_sub_fund_id','report_id'
    ];
}
