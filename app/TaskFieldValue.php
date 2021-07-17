<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskFieldValue extends Model
{
    protected $fillable = [
        'task_id','task_field_id','number', 'text', 'long_text','date','dropdown_value_id'
    ];

    public function getTaskFieldType()
    {
        return $this->hasOne(TaskField::class,'id','task_field_id');
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::class,'id','task_id');
    }

    public function getDropDownText()
    {
        return $this->hasOne(FieldDropdownValue::class,'id','dropdown_value_id');
    }
    
}
