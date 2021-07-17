<?php

namespace App\Http\Traits;

use App\Tasks;
use App\AppConst;
use App\Support\Collection;
use App\Http\Traits\TaskDetail;

trait TaskList
{

    public static function task_list($formType = null)
    {
        if (!$formType) {
            $formType = isset(request()->type) ? base64_decode(request()->type) : '';
        }
        $callback = function ($query) use ($formType) {
            $query->where('code', '=', $formType);
        };
        $data = Tasks::whereHas('getTaskType', $callback)->with(['getTaskType' => $callback])->select(AppConst::TASKS, 'task_field_values.text')->join('task_field_values', 'task_field_values.task_id', 'tasks.id')->join('task_fields', 'task_fields.id', 'task_field_values.task_field_id')->where('task_fields.code', $formType . '_name')->orderBy(AppConst::TASKS_CREATEDAT, 'DESC');

        $data = self::task_access($data);
        return $data;
    }

    public static function task_list_filter($request, $data, $formType)
    {
        if ($request->label || $request->month) {
            if ($formType == 'issue') {
                $data = $data->filter(function ($item) use ($request) {
                    if (task_field_value_text($item->id, 'issue_type') == $request->label) {
                        return $item;
                    }
                    $m = date('M', strtotime($item->created_at));
                    if ($m == $request->month) {
                        return $item;
                    }
                })->values()->all();
            }
            if ($formType == 'task') {
                $data = $data->filter(function ($item) {
                    if ($item->task_challenge_status == base64_decode(request()->challenge_status)) {
                        return $item;
                    }
                })->values()->all();
            }
            $data = (new Collection($data));
        }
        $data = self::task_detail($data, null);
        if ($request->department_filter) {
            $data = $data->filter(function ($item) use ($request) {
                foreach ($item->departments as $i) {
                    if ($i->id == $request->department_filter) {
                        return $item;
                    }
                }
            })->values()->all();
            $data = (new Collection($data));
            $department = $request->department;
        } else {
            $department = 'All';
        }
        if ($request->user_id) {
            $data = $data->filter(function ($item) use ($request) {
                foreach ($item->assignees as $i) {
                    if ($i->id == $request->user_id) {
                        return $item;
                    }
                }
            })->values()->all();
            $data = (new Collection($data));
        }
        if ($request->client_id) {
            $data = $data->filter(function ($item) use ($request) {
                foreach ($item->clients as $i) {
                    if ($i->id == $request->client_id) {
                        return $item;
                    }
                }
            })->values()->all();
            $data = (new Collection($data));
        }
        if ($request->filter) {
            $filter_name = $request->filter_name;
            if($formType == "task"){
                $data = $data->filter(function ($item) use ($request){
                    if($item->filter == $request->filter){
                        return $item;
                    }
                });
            }else{
                $data = self::task_status_filter($data, $request->filter, $request->status);
            }
            $data = (new Collection($data));
        } else {
            $filter_name = 'All';
        }
        return ['data' => $data, 'department' => $department, 'filter_name' => $filter_name];
    }
}
