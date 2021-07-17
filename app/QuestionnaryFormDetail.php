<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionnaryFormDetail extends Model
{
    protected $fillable =[
        'task_id',
        'form_id',
        'status',
        'created_by'
    ];
}
