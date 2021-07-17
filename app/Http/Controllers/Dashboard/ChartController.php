<?php

namespace App\Http\Controllers\Dashboard;

use App\Tasks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppConst;
use App\CompanyUsers;
use App\Http\Traits\DatePeriod;
use App\Http\Traits\UserAccess;
use Carbon\Carbon;

class ChartController extends Controller
{
    use UserAccess, DatePeriod;
    public function chart_data(Request $request)
    {
        $tmp = Tasks::select(AppConst::TASKS)->where('tasks.task_type',1);
        $issues_donut = Tasks::where('tasks.task_type',2)->select('tasks.*');
        if($request->year && $request->period){
            $dates = $this->get_dates($request->year, $request->period);
            $tmp = $tmp->whereBetween('tasks.created_at', [$dates]);
            $issues_donut = $issues_donut->whereBetween('tasks.created_at', [$dates]);
        }

        $tmp = self::task_access($tmp);
        if($request->department_id){
            $tmp->where('task_departments.department_id', $request->department_id);
        }
        if($request->user_id){
            $cmpUID = CompanyUsers::where('user_id',$request->user_id)->pluck('id');
            $tmp->join('task_users','tasks.id','task_users.task_id')->whereIn('task_users.company_user_id',$cmpUID);
        }
        if($request->client_id){
            $tmp->join('task_clients','tasks.id','task_clients.task_id')->where('task_clients.client_id',$request->client_id);
        }
        $tmp = $tmp->get();
        $not_completed = $tmp->filter(function ($q) {
            return $q->completion_status == 0;
        })->count();
        $satisfactory = $tmp->filter(function ($q) {
            if($q->completion_status != 0){
                return $q->task_challenge_status == 0 ;
            }
        })->count();
        $challenge = $tmp->filter(function ($q) {
            if ($q->completion_status != 0) {
                return $q->task_challenge_status == 1;
            }
        })->count();
        $completed = $satisfactory + $challenge;
        $total = $completed + $not_completed;
        //issuedonut
        $company_issues = self::task_access($issues_donut);
        if($request->department_id){
            $company_issues->where('task_departments.department_id', $request->department_id);
        }
        $issue_data = [];
        foreach($company_issues->get() as $issue_list){
            if(isset($issue_data[task_field_value_text($issue_list->id,'issue_type')]))
            {
                $issue_data[task_field_value_text($issue_list->id,'issue_type')]++;
            }else{
                $issue_data[task_field_value_text($issue_list->id,'issue_type')] = 1;
            }
        }

        $comp_rating = 0;
        if ($completed != 0) {
            $comp_rating = $satisfactory / $completed * 100;
        }
        return [
            'chart_data' => [$satisfactory, $challenge, $not_completed],
            'chart_issues_data' => array_keys($issue_data),
            'data' => [
                'total_task' => $total,
                'not_completed' => $not_completed,
                'completion_with_satisfactory' => $satisfactory,
                'completion_with_challenge' => $challenge,
                'compilance_rating' => round($comp_rating) . "%",
            ],
            'issues_data' => array_values($issue_data),
            'issue_chart' => $this->issues_fraud_chart($request)
        ];
    }

    public function issues_fraud_chart($request)
    {
        return Tasks::issues_count($request);
    }
}
