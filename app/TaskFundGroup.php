<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskFundGroup extends Model
{
    protected $table = 'task_fund_groups';
    protected $fillable = [
        'task_id', 'fund_group_id', 'is_all'
    ];

    public static function savefundgroups($request, $id)
    {
        
        if(count($request) == 1 && $request[0] == 0){
            $clients = TaskClient::where('task_id',$id)->pluck('client_id');
            $request = FundGroups::select('fund_groups.*')->join('company_fund_groups', 'company_fund_groups.fund_group_id', 'fund_groups.id')->join('client_fund_groups', 'client_fund_groups.company_fund_group_id', '=', 'company_fund_groups.id')->whereIn('client_fund_groups.client_id', $clients)->distinct('fund_groups.id')->pluck('fund_groups.id');
        }
        TaskFundGroup::where('task_id',$id)->whereNotIn('id',$request)->delete();
        foreach ($request as $item) {
            $taskFundExists=TaskFundGroup::where('task_id',$id)
            ->where('fund_group_id',$item)
            ->exists();
            if(!$taskFundExists)
            {
            TaskFundGroup::create([
                'task_id' => $id,
                'fund_group_id' => $item == 0 ? null : $item,
                'is_all' => $item == 0 ? 1 : 0
            ]);
            }
        }
    }

    public function fundgroups()
    {
        return $this->belongsTo('App\FundGroups','fund_group_id','id');
    }
}
