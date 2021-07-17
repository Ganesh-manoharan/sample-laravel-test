<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskFormFieldGroup extends Model
{
    protected $fillable = [
        'task_type_id',
        'group_title',
        'group_slug',
        'sort_order',
        'step_wizard'
    ];

    public static function getgroupIDBySlug($slug)
    {
        return TaskFormFieldGroup::where('group_slug',$slug)->pluck('id')->first();
    }
}
