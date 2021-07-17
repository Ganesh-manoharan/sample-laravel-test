<?php

namespace App;

use App\RiskCategory;
use Illuminate\Database\Eloquent\Model;

class TaskRiskCategory extends Model
{
    protected $fillable = [
        'task_id','risk_category_id','risk_sub_category_id'
    ];

    public function getParentCategory()
    {
        return $this->hasOne(RiskCategory::class,'id','risk_category_id');
    }
    public function getChildCategory()
    {
        return $this->hasOne(RiskCategory::class,'id','risk_sub_category_id');
    }
}
