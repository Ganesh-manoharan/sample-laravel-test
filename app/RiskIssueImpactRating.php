<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiskIssueImpactRating extends Model
{
    protected $table = "risk_issue_impactrating";
    protected $fillable = [
        'impact_rating_id','report_id'
    ];
}
