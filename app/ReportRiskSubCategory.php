<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportRiskSubCategory extends Model
{
    protected $table = "report_risk_subcategories";
    protected $fillable = [
        'risk_subcategory_id','report_id'
    ];
}
