<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskUsers extends Model
{
    protected $table = "task_users";
    protected $fillable = [
        'task_id', 'company_user_id', 'user_action', 'is_all'
    ];

    public static function savetaskusers($request, $id)
    {
        if (!is_null($request->users)) {
            self::task_users_save($request->users,1,$id);
        }

        if (!is_null($request->review_users)) {
            self::task_users_save($request->review_users,0,$id);
        }
    }

    public static function task_users_save($users,$type,$id)
    {
        if(count($users) == 1 && $users[0] == 0){
            $dep = TaskDepartment::where('task_id', $id)->pluck('department_id');
            $users = DepartmentMembers::select('department_members.company_user_id')->whereIn('department_members.department_id',$dep)->distinct('company_user_id')->pluck('department_members.company_user_id');
        }
        TaskUsers::where('task_id',$id)->where('user_action',$type)->whereNotIn('company_user_id',$users)->delete();
        foreach ($users as $user) {
            $taskUserExists=TaskUsers::where('task_id',$id)
            ->where('company_user_id',$user)->where('user_action',$type)
            ->exists();
            if(!$taskUserExists)
            {
            TaskUsers::create([
                'task_id' => $id,
                'company_user_id' => $user == 0 ? null : $user,
                'user_action' => $type,
                'is_all' => $user == 0 ? 1 : 0
            ]);
            }
        }
    }

    public static function fetch_users($id)
    {
       return TaskUsers::where('task_users.task_id',$id)->join('company_users','company_users.id','=','company_user_id')->join('users','users.id','=','company_users.user_id')->select('task_users.user_action','task_users.id','users.avatar as user_avatar','users.name as task_user_name')->get();
    }
}
