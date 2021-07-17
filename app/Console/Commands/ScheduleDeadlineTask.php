<?php

namespace App\Console\Commands;

use App\Http\Traits\EnvelopeEncryption;
use App\CompanyUsers;
use App\Http\Traits\DeadlineTaskNotification;
use App\TaskClient;
use Illuminate\Console\Command;

class ScheduleDeadlineTask extends Command
{
    use EnvelopeEncryption, DeadlineTaskNotification;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:deadlinetask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify the user for the deadline tasks';

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
        $key = self::decryptDataKey();
        $tmp = CompanyUsers::select('users.name', 'users.email', 'company_users.*')->with('urgent_tasks')->join('users', 'users.id', 'company_users.user_id')->get();
        foreach ($tmp as $item) {
            $item->name = self::DecryptedData($item->name, $key);
            $item->email = self::DecryptedData($item->email, $key);
            $dt = $item->urgent_tasks;
            $item->selected = $dt->filter(function ($fil) {
                $min = TaskClient::where('task_id', $fil->id)->join('clients', 'clients.id', 'task_clients.client_id')->min('clients.deadline_priority');
                $deadline = date('Y-m-d', strtotime('+' . $min . 'days'));
                if ($deadline > date('Y-m-d', strtotime($fil->date)) && date('Y-m-d') < date('Y-m-d', strtotime($fil->date))) {
                    return $fil;
                }
            })->values()->all();
        }
        $data = $tmp->filter(function ($t) {
            if (!empty($t->selected)) {
                return $t;
            }
        })->values()->all();
        foreach($data as $i){
            self::notification_mail($i);
        }
        return true;
    }
}
