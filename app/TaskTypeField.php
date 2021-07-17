<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TaskField;

class TaskTypeField extends Model
{
    protected $fillable = [
        'task_type_id',
        'task_field_id'
    ];

    public function getFieldDetails()
    {
        return $this->hasOne(TaskField::class,'id','task_field_id')
        ->join('field_types','field_types.id','task_fields.field_type_id')
        ->select('task_fields.id','task_fields.label','task_fields.code','task_fields.placeholder','task_fields.description','field_types.code as fieldType');
    }
    public function getFieldOptions()
    {
        return $this->hasMany(TaskField::class,'id','task_field_id')
        ->join('field_dropdown_values','field_dropdown_values.task_field_id','task_fields.id')
        ->join('field_types','field_types.id','task_fields.field_type_id')
        ->whereIn('field_types.code',array('dropdown_value','select2','radio_button'))
        ->select('task_fields.id','task_fields.label','task_fields.code','task_fields.placeholder','task_fields.description','field_dropdown_values.code as fieldcode','field_dropdown_values.id as optionID','field_dropdown_values.dropdown_name');
    }

    public function getFormGroupDetails()
    {
        return $this->hasOne(TaskFormFieldGroup::class,'id','task_form_field_group_id');
    }
}
