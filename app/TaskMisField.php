<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskMisField extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'task_id','label_title','description','field_type_id',
    ];

    public function mis_field_contents()
    {
        return $this->hasMany('App\MisFieldContent');
    }

    public function task_mis_results()
    {
        return $this->hasOne('App\TaskMisResult','task_mis_field_id','id')->leftjoin('mis_field_contents','mis_field_contents.id','task_mis_results.option_id')->select('task_mis_results.*','mis_field_contents.options');
    }

    public static function save_mis_fields($id, $item)
    {
        if(array_key_exists("task_mis",$item)){
            TaskMisField::where('id',$item['task_mis'])->update([
                'label_title' => $item['label_title'],
                'description' => $item['description'],
            ]);
            return TaskMisField::where('id',$item['task_mis'])->first();
        }
       return TaskMisField::create([
            'task_id' => $id,
            'label_title' => $item['label_title'],
            'description' => $item['description'],
            'field_type_id' => $item['field_id']
        ]);
    }
}
