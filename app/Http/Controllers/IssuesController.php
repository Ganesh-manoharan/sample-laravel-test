<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Traits\CommonFunction;
use App\IssueType;
use App\Issue;
use App\AppConst;
use App\Tasks;
use App\Http\Traits\TaskFilter;
use App\Http\Traits\TaskDetail;
use App\Support\Collection;

class IssuesController extends Controller
{
   use CommonFunction, TaskFilter, TaskDetail;
    public function issues_dashboard(Request $request)
    {
      
       $notification_list = $this->notificationlist();

       $data=Issue::join('issues_types','issues_types.id','issues.issue_type_id')->join('tasks','tasks.id','issues.task_id')->join('task_departments','task_departments.task_id','issues.task_id')->join('departments','departments.id','task_departments.department_id')->join('task_clients','task_clients.task_id','issues.task_id')->join('company','company.id','task_clients.client_id')->where('tasks.task_type','=',2)->get();
       $data = $this->task_detail($data);
       if ($request->issues_filter) {
         $data = $data->filter(function ($item) use ($request) {
             foreach ($item->issues as $i) {
                 if ($i->issue_type_id==$request->issues_filter) {
                     return $item;
                 }
             }
         })->values()->all();
         $issues = $request->issues;
     } else {
         $issues = 'All';
     }
    
     if ($request->filter) {
      $filter_name = $request->filter_name;
      $data = self::task_status_filter($data, $request->filter, $request->status);
      } else {
            $filter_name = 'All';
      }

    

      $data = (new Collection($data));
      $info = array_merge(Tasks::info_stats($data, $request->issues_filter ?? null), [
            'filter_name' => $filter_name,
            'issues_name' => $issues
      ]);
     $data = $data->paginate(config(AppConst::COMMON_PAGINATE));
    return view('issues_dashboard',compact('data','info'))->with(['awaitingapproval_form_backurl' => __('header.Returns to Task Home'), 'notification_data' => $notification_list]);
    }
}
?>
