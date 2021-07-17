<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportRiskCategory extends Model
{
    protected $table = "report_risk_categories";
    protected $fillable = [
        'risk_category_id','report_id'
    ];
}
