<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskMisResult extends Model
{
    protected $fillable = [
        'task_mis_field_id','option_id','value'
    ];

    public function mis_options()
    {
        $this->belongsTo('App\MisFieldContent','option_id','id');
    }
}
