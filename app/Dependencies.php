<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependencies extends Model
{
    protected $table = "dependencies";
    protected $fillable = [
        'task_id', 'dependent_task_id', 'is_all'
    ];

    public static function savedependencies($dependencies, $id)
    {
        Dependencies::where('task_id',$id)->whereNotIn('dependent_task_id',$dependencies)->delete();
        foreach ($dependencies as $item) {
            $tasksubfundExists=Dependencies::where('task_id',$id)
            ->where('dependent_task_id',$item)
            ->exists();
            if(!$tasksubfundExists)
    {
            Dependencies::create([
                'task_id' => $id,
                'dependent_task_id' => $item == 0 ? null : $item,
                'is_all' => $item == 0 ? 1 : 0
            ]);
            }

        }
    }

    public function getDependencias()
    {
        return $this->hasOne(Tasks::class,'id','dependent_task_id');
    }
    public function getTask()
    {
        return $this->hasOne(Tasks::class,'id','task_id');
    }
}
