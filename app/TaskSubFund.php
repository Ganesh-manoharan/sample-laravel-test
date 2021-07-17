<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskSubFund extends Model
{
    protected $fillable = [
        'task_id', 'sub_funds_id', 'is_all'
    ];
    public static function savesubfundgroups($request, $id)
    {
        if(count($request) == 1 && $request[0] == 0){
            $funds = TaskFundGroup::where('task_id',$id)->pluck('fund_group_id');
            $request = SubFunds::where('active_status', 1)->whereIn('fund_group_id', $funds)->pluck('id');
        }
        TaskSubFund::where('task_id',$id)->whereNotIn('id',$request)->delete();
        foreach ($request as $item) {
            $tasksubfundExists=TaskSubFund::where('task_id',$id)
            ->where('sub_funds_id',$item)
            ->exists();
            if(!$tasksubfundExists)
            {
            TaskSubFund::create([
                'task_id' => $id,
                'sub_funds_id' => $item == 0 ? null : $item,
                'is_all' => $item == 0 ? 1 : 0
            ]);
            }
        }
    }

    public function subfunds()
    {
        return $this->belongsTo('App\SubFunds','sub_funds_id','id');
    }
}
