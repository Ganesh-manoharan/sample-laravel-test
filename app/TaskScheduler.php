<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class TaskScheduler extends Model
{
    protected $table = 'task_schedulers';
    protected $fillable = [
        'task_id', 'run_date', 'last_run'
    ];

    public static function save_schedule_task($task_id, $frequency, $created_at)
    {
        $run_date = self::get_run_date($frequency,$created_at);
        TaskScheduler::create([
            'task_id' => $task_id,
            'run_date' => $run_date,
            'last_run' => $created_at
        ]);
    }

    public static function get_run_date($frequency, $date)
    {
        switch ($frequency) {
            case 'daily':
                $d = date("Y-m-d H:i:s", strtotime('+1 days', strtotime($date)));
                break;
            case 'weekly':
                $d = date("Y-m-d H:i:s", strtotime('+7 days', strtotime($date)));
                break;
            case 'monthly':
                $d = date("Y-m-d H:i:s", strtotime('+30 days', strtotime($date)));
                break;
            case 'quarterly':
                $d = date("Y-m-d H:i:s", strtotime('+120 days', strtotime($date)));
                break;
            case 'yearly':
                $d = date("Y-m-d H:i:s", strtotime('+365 days', strtotime($date)));
                break;
            default:
                $d = $date;
        }

        return $d;
    }
}
