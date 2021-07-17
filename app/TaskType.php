<?php

namespace App;

use App\TaskTypeField;
use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    protected $fillable = [
        'task_type_name',
        'code',
        'description'
    ];

    public function getTaskTypeFields()
    {
        return $this->hasMany(TaskTypeField::class)->orderBy('sort_order','asc');
    }

    public static function getTaskTypeIDbyCode($code)
    {
        return TaskType::where('code',$code)->pluck('id')->first();
    }
}
