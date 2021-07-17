<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportFund extends Model
{
    protected $table = "report_funds";
    protected $fillable = [
        'fund_group_id','report_id'
    ];
}
