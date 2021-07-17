<?php

namespace App\Console\Commands;

use App\FieldDropdownValue;
use App\Http\Traits\ScheduleTaskUpdate;
use App\Tasks;
use App\TaskScheduler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScheduleTasks extends Command
{
    use ScheduleTaskUpdate;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $task = Tasks::with('task_schedule_fieldvalues','task_schedule_clients','task_schedule_funds','task_schedule_subfunds','task_schedule_dependencies','task_schedule_departments','task_schedule_users','task_schedule_documents','task_schedule_misfields')->join('task_schedulers','task_schedulers.task_id','tasks.id')->where('task_schedulers.run_date','<=',date('Y-m-d H:i:s'))->get();

        foreach($task as $item){
           $t = Tasks::create([
            'additional_attachment_requirement' => $item->additional_attachment_requirement,
            'comments' => $item->comments,
            'task_status' => 1,
            'completion_status' => 0,
            'created_by_id' => $item->created_by_id,
            'task_type' => $item->task_type,
            'status' => 1
           ]);
           $tmp = $item->task_schedule_fieldvalues;
           $frequency = $tmp->filter(function($f) {
                if($f->task_field_id == 26){
                    return $f;
                }
           })->values()->all();
           Log::info('>>> Running Task Id - '.$item->id);
           Log::info($tmp);
           Log::info($frequency);
           $fr_code = FieldDropdownValue::where('id',$frequency[0]->dropdown_value_id)->first();
           TaskScheduler::where('task_id',$item->task_id)->update([
               'task_id' => $t->id,
               'run_date' => TaskScheduler::get_run_date($fr_code->code,$t->created_at),
               'last_run' => $t->created_at
           ]);
            self::fields_update($t->id,$item->task_schedule_fieldvalues);
            self::clients_update($t->id,$item->task_schedule_clients);
            self::funds_update($t->id,$item->task_schedule_funds);
            self::subfunds_update($t->id,$item->task_schedule_subfunds);
            self::departments_update($t->id,$item->task_schedule_departments);
            self::users_update($t->id,$item->task_schedule_users);
            self::documents_update($t->id,$item->task_schedule_documents);
            self::mis_update($t->id,$item->task_schedule_misfields);
        }
        return true;
    }
}
