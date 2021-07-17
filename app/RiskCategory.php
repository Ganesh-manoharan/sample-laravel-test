<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiskCategory extends Model
{
    protected $table = "risk_categories";
    protected $fillable = [
        'parent_id','title','code'
    ];
}
