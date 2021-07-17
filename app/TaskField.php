<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskField extends Model
{
    protected $fillable = [
        'field_type_id',
        'label',
        'code',
        'placeholder',
        'description'
    ];

    public function getFieldType()
    {
        return $this->hasOne(FieldType::class,'id','field_type_id');
    }

    public function getDropDownDetails()
    {
        return $this->hasMany(FieldDropdownValue::class,'task_field_id','id');
    }

    public static function getTaskFieldIDbyCode($code)
    {
        return TaskField::where('code',$code)->pluck('id')->first();
    }
}
