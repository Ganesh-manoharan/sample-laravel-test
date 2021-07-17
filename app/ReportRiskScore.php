<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportRiskScore extends Model
{
    protected $table = "report_risk_score";
    protected $fillable = [
        'report_score_id','report_id'
    ];
}
