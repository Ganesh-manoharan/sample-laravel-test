<?php

namespace App\Http\Traits;

use App\DepartmentMembers;
use App\Departments;
use App\Tasks;

trait DepartmentList
{
    use TaskDetail, EnvelopeEncryption;

    public static function department_list_with_data($paginate, $search = null)
    {
        if (!is_null($search)) {
            $dt = Departments::whereRaw("UPPER(name) LIKE '%" . strtoupper($search) . "%'")->orderBy('name');
        } else {
            $dt = Departments::orderBy('created_at','DESC');
        }
        $dt = self::department_restriction($dt);
        $departmentlist = $dt->select('departments.*')->paginate($paginate);

        $key = self::decryptDataKey();

        foreach ($departmentlist as $item) {

            $item->department_manager = DepartmentMembers::where('department_id', $item->id)->join('company_users', 'company_users.id', 'department_members.company_user_id')->join('users', 'users.id', '=', 'company_users.user_id')->where('department_members.is_manager', 1)->select('users.*')->first();
            if ($item->department_manager) {
                $item->department_manager->name = self::DecryptedData($item->department_manager->name, $key);
            }
            $task = Tasks::select('tasks.*')->where('task_type', 1);
            $task = self::task_access($task);
            $task = $task->where('task_departments.department_id', $item->id)->get();

            foreach ($task as $i) {
                $tmp = self::task_clients($i->id);
                $i->clients = $tmp['clients'];
                $i->deadline = $tmp['deadline'];
                $i->due_date = task_field_value_text($i->id,'due_date');
            }
            $count = Tasks::info_stats($task);
            $item['info'] = $count;
            $item['per'] = 0;
            if ($count['total'] > 0) {
                $item['per'] = round($count['completed'] / $count['total'] * 100);
            }
        }
        return $departmentlist;
    }
}
