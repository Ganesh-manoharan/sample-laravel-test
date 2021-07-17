<?php

namespace App\Http\Traits;

use App\MisFieldContent;
use App\TaskClient;
use App\TaskDepartment;
use App\TaskDocument;
use App\TaskFieldValue;
use App\TaskFundGroup;
use App\TaskMisField;
use App\TaskSubFund;
use App\TaskUsers;

trait ScheduleTaskUpdate
{
    public static function fields_update($task_id,$data)
    {
        $dt = [];
        foreach($data as $key => $i){
            $dt[$key]['task_id'] = $task_id;
            $dt[$key]['task_field_id'] = $i->task_field_id;
            $dt[$key]['number'] = $i->number;
            $dt[$key]['text'] = $i->text;
            $dt[$key]['long_text'] = $i->long_text;
            $dt[$key]['date'] = $i->date;
            $dt[$key]['dropdown_value_id'] = $i->dropdown_value_id;
            $dt[$key]['created_at'] = now();
            $dt[$key]['updated_at'] = now();
        }
        TaskFieldValue::insert($dt);
    }

    public static function clients_update($task_id,$data)
    {
        $dt = [];
        foreach($data as $key => $i){
            $dt[$key]['task_id'] = $task_id;
            $dt[$key]['client_id'] = $i->client_id;
            $dt[$key]['created_at'] = now();
            $dt[$key]['updated_at'] = now();
        }
        TaskClient::insert($dt);
    }

    public static function funds_update($task_id,$data)
    {
        $dt = [];
        foreach($data as $key => $i){
            $dt[$key]['task_id'] = $task_id;
            $dt[$key]['fund_group_id'] = $i->fund_group_id;
            $dt[$key]['created_at'] = now();
            $dt[$key]['updated_at'] = now();
        }
        TaskFundGroup::insert($dt);
    }

    public static function subfunds_update($task_id,$data)
    {
        $dt = [];
        foreach($data as $key => $i){
            $dt[$key]['task_id'] = $task_id;
            $dt[$key]['sub_funds_id'] = $i->sub_funds_id;
            $dt[$key]['created_at'] = now();
            $dt[$key]['updated_at'] = now();
        }
        TaskSubFund::insert($dt);
    }

    public static function departments_update($task_id,$data)
    {
        $dt = [];
        foreach($data as $key => $i){
            $dt[$key]['task_id'] = $task_id;
            $dt[$key]['department_id'] = $i->department_id;
            $dt[$key]['created_at'] = now();
            $dt[$key]['updated_at'] = now();
        }
        TaskDepartment::insert($dt);
    }

    public static function users_update($task_id,$data)
    {
        $dt = [];
        foreach($data as $key => $i){
            $dt[$key]['task_id'] = $task_id;
            $dt[$key]['company_user_id'] = $i->company_user_id;
            $dt[$key]['user_action'] = $i->user_action;
            $dt[$key]['created_at'] = now();
            $dt[$key]['updated_at'] = now();
        }
        TaskUsers::insert($dt);
    }

    public static function documents_update($task_id,$data)
    {
        $dt = [];
        foreach($data as $key => $i){
            $dt[$key]['task_id'] = $task_id;
            $dt[$key]['document_id'] = $i->document_id;
            $dt[$key]['thumbnail'] = $i->thumbnail; 
            $dt[$key]['selected_type'] = $i->selected_type;
            $dt[$key]['document_specific_page'] = $i->document_specific_page;
            $dt[$key]['text_quads'] = $i->text_quads;
            $dt[$key]['text'] = $i->text;
            $dt[$key]['document_added_as'] = $i->document_added_as;
            $dt[$key]['created_at'] = now();
            $dt[$key]['updated_at'] = now();
        }
        TaskDocument::insert($dt);
    }

    public static function mis_update($task_id,$data)
    {
        $dt = [];
        foreach($data as $key => $i){
            $dt['task_id'] = $task_id;
            $dt['label_title'] = $i->label_title;
            $dt['description'] = $i->description; 
            $dt['field_id'] = $i->field_type_id;
            $tmp = TaskMisField::save_mis_fields($task_id,$dt);
            foreach($i->mis_field_contents as $item){
                MisFieldContent::create([
                    'task_mis_field_id' => $tmp->id,
                    'min_value' => $item->min_value,
                    'options' => $item->options,
                    'is_required' => $item->is_required
                ]);
            }
        }
    }
}