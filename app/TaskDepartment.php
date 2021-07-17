<?php

namespace App;

use App\Http\Traits\UserAccess;
use Illuminate\Database\Eloquent\Model;

class TaskDepartment extends Model
{
    use UserAccess;
    protected $table = 'task_departments';
    protected $fillable = [
        'task_id' ,'department_id','is_all'
    ];
    
    public static function savetaskdepartments($departments,$task_id)
    {
        if(count($departments) == 1 && $departments[0] == 0){
            $clients = TaskClient::where('task_id',$task_id)->pluck('client_id');
            $departments = Departments::select('departments.name', 'departments.dep_icon', 'company_departments.*');
            $departments = self::department_restriction($departments);
            $departments = $departments->join('client_departments', 'client_departments.company_department_id', 'company_departments.id')->whereIn('client_departments.client_id', $clients)->distinct('deparments.id')->pluck('departments.id');
        }
        TaskDepartment::where( 'task_id',$task_id)->whereNotIn('department_id',$departments)->delete();
        foreach($departments as $item){
            $is_all = 0;
            if($item == 0){
                $is_all = 1;
                $item = null;
            }
            $TaskDepartmentExists=TaskDepartment::where('task_id', $task_id)
            ->where('department_id', $item)
            ->exists();
            if(!$TaskDepartmentExists)
            {
            TaskDepartment::create([
                'task_id' => $task_id,
                    'department_id' => $item
            ]);
            }
            
        }
    }

    public function departments()
    {
        return $this->belongsTo('App\Departments','department_id','id');
    }
}
