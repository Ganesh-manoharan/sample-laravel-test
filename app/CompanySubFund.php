<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySubFund extends Model
{
    protected $table = 'company_sub_funds';
    protected $fillable = [
        'company_id','sub_funds_id','active_status'
    ];
}
