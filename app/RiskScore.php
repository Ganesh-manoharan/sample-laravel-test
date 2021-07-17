<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiskScore extends Model
{
    protected $table = "risk_scores";
    protected $fillable = [
        'name'
    ];
}
