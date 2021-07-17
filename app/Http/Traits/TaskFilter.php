<?php

namespace App\Http\Traits;

trait TaskFilter
{

    public static function task_filter($data, $filter, $status)
    {
        $data->where('completion_status', $status);
        if ($filter == 1) {
            $data = $data->get()->filter(function ($q) {
                $deadline = date('Y-m-d', strtotime('+' . $q->company->deadline_priority . 'days'));
                if ($deadline < date('Y-m-d', strtotime($q->due_date))) {
                    return $q->id;
                }
            })->values()->all();
        }
        if($filter == 2){
            $data = $data->get()->filter(function ($q) {
                $deadline = date('Y-m-d', strtotime('+' . $q->company->deadline_priority . 'days'));
                if ($deadline > date('Y-m-d', strtotime($q->due_date)) && date('Y-m-d') < date('Y-m-d', strtotime($q->due_date))) {
                    return $q->id;
                }
            })->values()->all();
        }
        if($filter == 3){
            $data = $data->get()->filter(function ($q) {
                if (date('Y-m-d') > date('Y-m-d', strtotime($q->due_date))) {
                    return $q->id;
                }
            })->values()->all();
        }
        if($filter == 4 || $filter == 5){
            $data = $data->get();
        }
        return $data;
    }

    public static function task_status_filter($data, $filter, $status)
    {
        $tmp = $data->filter(function($q) use ($status){
            return $q->completion_status == $status;
        });
        if ($filter == 1) {
            $data = $tmp->filter(function ($q) {
                $deadline = date('Y-m-d', strtotime('+' . $q->deadline . 'days'));
                if ($deadline < date('Y-m-d', strtotime($q->due_date))) {
                    return $q;
                }
            })->values()->all();
        }
        if($filter == 2){
            $data = $tmp->filter(function ($q) {
                $deadline = date('Y-m-d', strtotime('+' . $q->deadline . 'days'));
                if ($deadline > date('Y-m-d', strtotime($q->due_date)) && date('Y-m-d') < date('Y-m-d', strtotime($q->due_date))) {
                    return $q;
                }
            })->values()->all();
        }
        if($filter == 3){
            $data = $tmp->filter(function ($q) {
                if (date('Y-m-d') > date('Y-m-d', strtotime($q->due_date))) {
                    return $q;
                }
            })->values()->all();
        }
        if($filter == 4 || $filter == 5){
            $data = $tmp;
        }
        return $data;
    }

    public static function task_status($task,$priority)
    {
        $status = '-';
        switch($task->completion_status){
            case 0:
                $deadline = date('Y-m-d', strtotime('+' . $priority . 'days'));
                if(date('Y-m-d') > date('Y-m-d', strtotime($task->due_date))){
                    $status = 'OVERDUE';
                }
                else if($deadline < date('Y-m-d', strtotime($task->due_date))){
                    $status = 'ON TRACK';
                }
                else{
                    $status = 'URGENT';
                }

            break;
            case 1:
                if($task->task_challenge_status == 1){
                    $status = 'COMPLETED WITH CHALLENGE';
                }
                else{
                    $status = 'COMPLETED';
                }
            break;
            case 2:
                $status = 'AWAITING APPROVAL';
            break;
            default:
            return '-';
        }

        return $status;
    }

    public static function task_frequency($frequency)
    {
        switch($frequency){
            case 1:
                 $frequency_status = 'Ad Hoc';
            break;
            case 2:
                $frequency_status = 'Daily';
            break;
            case 3:
                $frequency_status = 'Weekly';
            break;
            case 4:
                $frequency_status = 'Monthly';
            break;
            case 5:
                $frequency_status = 'Quarterly';
            break;
            case 6:
                $frequency_status = 'Annually';
            break;
            default:
                $frequency_status = '-';
        }

        return $frequency_status;
    }
}
