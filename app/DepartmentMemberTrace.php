<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentMemberTrace extends Model
{
    protected $fillable = [
        'department_id',
        'department_members_id',
        'modified_by',
        'action',
        'modified_columns'
    ];
}
