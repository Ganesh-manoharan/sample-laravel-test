<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportDepartment extends Model
{
    protected $table = "report_departments";
    protected $fillable = [
        'department_id','report_id'
    ];
}
