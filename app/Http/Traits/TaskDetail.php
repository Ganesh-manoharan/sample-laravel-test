<?php

namespace App\Http\Traits;

use App\AppConst;
use App\TaskUsers;
use App\TaskClient;
use App\TaskMisField;
use App\TaskDepartment;
use App\TaskAttachDocumentation;

trait TaskDetail
{

    public static function task_detail($data)
    {
        foreach ($data as $item) {
            $t = TaskClient::where('task_id', $item->id)->join('clients', AppConst::CLIENTS_ID, '=', AppConst::TASK_CLIENTS_CLIENT_ID)->select(AppConst::CLIENTS);
            $item->clients = $t->get();
            $item->deadline = $t->min(AppConst::CLIENTS_DEADLINE);
            $item->departments = TaskDepartment::where('task_id', $item->id)->join('departments', 'departments.id', '=', 'task_departments.department_id')->select('departments.*')->get();
            $item->due_date = task_field_value_text($item->id,'due_date');
            $item->assignees = self::task_users($item->id, [0,1]);
        }
        return $data;
    }

    public static function task_clients($task_id)
    {
        $tmp = TaskClient::where('task_id', $task_id)->join('clients', AppConst::CLIENTS_ID, '=', AppConst::TASK_CLIENTS_CLIENT_ID)->select(AppConst::CLIENTS);
        $clients = $tmp->get();
        $deadline = $tmp->min(AppConst::CLIENTS_DEADLINE);

        return ['clients' => $clients, 'deadline' => $deadline];
    }

    public static function task_users($id, $type)
    {
        return TaskUsers::where('task_id', $id)->whereIn('user_action', $type)->join('company_users', 'company_users.id', '=', 'task_users.company_user_id')->join('users', AppConst::USERS_ID, '=', 'company_users.user_id')->distinct('task_users.company_user_id')->get();
    }

    public function task_mis($id)
    {
        return TaskMisField::with('task_mis_results', 'mis_field_contents')->where('task_id', $id)->get();
    }

    public function attached_docs($task_id)
    {
        $attached_docs = TaskAttachDocumentation::where('task_id', $task_id)->pluck('file_path');
        foreach ($attached_docs as $key => $item) {
            $attached_docs[$key] = explode('/', $item)[1];
        }
        return $attached_docs;
    }
}