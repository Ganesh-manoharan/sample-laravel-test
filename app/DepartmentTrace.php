<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentTrace extends Model
{
    protected $fillable = [
        'department_id',
        'modified_by',
        'action',
        'modified_columns'
    ];
}
