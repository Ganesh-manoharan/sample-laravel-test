<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskAttachDocumentation extends Model
{
    protected $fillable = [
        'task_id', 'file_path'
    ];
}
