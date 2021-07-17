<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = "issues";
    protected $fillable = [
        'task_id','issue_type_id','issue_description','created_by_id'
    ];

    
}
