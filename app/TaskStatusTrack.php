<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskStatusTrack extends Model
{
    protected $table = 'task_status_track';

    protected $fillable = [
        'task_id','completion_status','task_challenge_status','completed_date_by_assignee','completed_by','approved_date','approved_by','reopen_date','reopen_by'
    ];

    public static function save_complete_status($request)
    {
        TaskStatusTrack::create([
            'task_id' => $request->taskid,
            'task_challenge_status' => $request->completion,
            'completion_status' => $request->completion_status,
            'completed_date_by_assignee' => now(),
            'completed_by' => $request->get('cmpUsrId')
        ]);
    }

    public static function save_reopen_status($request)
    {
        TaskStatusTrack::create([
            'task_id' => $request->id,
            'reopen_date' => now(),
            'reopen_by' => $request->get('cmpUsrId')
        ]);
    }
}
