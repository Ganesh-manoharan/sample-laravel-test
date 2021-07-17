<?php

namespace App;

use App\Http\Traits\UserAccess;
use Illuminate\Database\Eloquent\Model;

class TaskClient extends Model
{
    use UserAccess;
    protected $table = 'task_clients';
    protected $fillable = [
        'task_id' ,'client_id','is_all','company_id'
    ];
    
    public static function savetaskclients($clients,$task_id, $tcmpId)
    {
        if(count($clients) == 1 && $clients[0]==0){
            $company_list = Client::orderBy('clients.created_at')->select('clients.*');
            $company_list = self::client_access($company_list);
            $clients = $company_list->pluck('clients.id');
        }
        TaskClient::where('task_id',$task_id)->whereNotIn('id',$clients)->delete();
        foreach($clients as $item){
            $is_all = 0;
            $cmpId = null;
            if($item == 0){
                $is_all = 1;
                $item = null;
                $cmpId = $tcmpId;
            }
            $taskClientExists=TaskClient::where('task_id',$task_id)
            ->where('client_id',$item)
            ->exists();
            if(!$taskClientExists)
            {
            TaskClient::create([
                'task_id' => $task_id,
                'client_id' => $item,
                'is_all' => $is_all,
                'company_id' => $cmpId
            ]);
            }            
        }
    }

    public function clients()
    {
        return $this->belongsTo('App\Client','client_id','id');
    }
}
