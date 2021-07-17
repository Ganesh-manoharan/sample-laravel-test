<?php

namespace App\Http\Controllers\Task;

use App\Dependencies;
use App\Documents;
use App\TaskDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\TaskDetailAJAX;
use App\TaskMisField;
use App\TaskMisResult;
use App\Tasks;
use App\Issue;
use App\MisFieldContent;
use App\TaskStatusTrack;
use App\TaskFieldValue;
use App\FieldDropdownValue;
use App\Http\Traits\UserAccess;
use App\Repositories\TaskFormFieldsRepository;

class TaskDetailController extends Controller
{
    use TaskDetailAJAX,UserAccess;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskFormFieldsRepository $taskFormFieldsRepository)
    {
        $this->taskFormFields=$taskFormFieldsRepository;
    }

    public function get_task_documents($id)
    {
        $docs = TaskDocument::where('task_id',$id)->get()->groupBy('document_id');
        $doc_detail = [];
        foreach($docs as $key => $value){
            $doc_detail[$key] = Documents::where('id',$key)->select('id','document_name','document_path')->get();
        }
        return ['docs' => $docs, 'doc_detail' => $doc_detail];
    }

    public function mis_result(Request $request)
    {
        $task_mis_ids = TaskMisField::where('task_id',$request->task_id)->pluck('id');
        return TaskMisResult::whereIn('task_mis_field_id',$task_mis_ids)->get();
    }

    public function taskdetail_index(Request $request)
    {
        $tmp = Tasks::where('tasks.id', $request->id)->join('company_users','company_users.id','tasks.created_by_id')->join('users','users.id','company_users.user_id')->select('tasks.*','users.avatar as created_by_avatar','users.name as created_by_name');
        $data = self::task_access($tmp, null);
        if(!$data->exists())
        {
            return response('Unauthorized Action', 403);
        }
        $tmp=$tmp->first();
        $formFields=$this->taskFormFields->getTaskFormFields($tmp->getTaskType->code);
        $fieldvalue=TaskFieldValue::with('getTaskFieldType','getTaskFieldType.getFieldType')
                 ->where('task_id',$request->id)
                 ->get();
                 $taskFieldDetails=[];
                 if($fieldvalue)
                 {
                     foreach($fieldvalue as $taskFieldValues)
                     {
                        $type=$taskFieldValues->getTaskFieldType->getFieldType->code;
                        if($type=='dropdown_value')
                        {
                            $dropDownID=$taskFieldValues->dropdown_value_id;
                            $taskdropDownFieldValue=FieldDropdownValue::where('id',$dropDownID)->first();
                            $taskFieldDetails[$taskFieldValues->getTaskFieldType->code]=$taskdropDownFieldValue?$taskdropDownFieldValue->dropdown_name:'';
                        }
                        else
                        {
                        $taskFieldDetails[$taskFieldValues->getTaskFieldType->code]=$taskFieldValues->$type;
                     }
                        
                     }
                 }
        
        $clients = $this->task_overview_clients($tmp->id, 1, 3);
        $tmp->clients = $clients['clients'];
        $tmp->deadline = $clients['deadline'];

        $funds = $this->task_overview_funds($tmp->id,$clients['client_ids'], 1, 3);

        $tmp->funds = $funds['funds'];
        $tmp->subfunds = $this->task_overview_subfunds($tmp->id, $funds['fund_ids'], 1, 3);

        $departments = $this->task_overview_departments($tmp->id,$clients['client_ids'], 1, 3);
        $tmp->departments = $departments['departments'];
        $tmp->assignees = $this->task_overview_users($tmp->id, 1, $departments['department_ids'], 1, 4);

        $tmp->reviewers = $this->task_overview_users($tmp->id, 0, $departments['department_ids'], 1, 4);

        $tmp->mis = $this->task_mis($tmp->id);

        if($tmp->getTaskType->code!='risk' && isset($taskFieldDetails['due_date']))
        {
            $tmp->status = $this->task_status_one($tmp->completion_status, $taskFieldDetails['due_date'], $tmp->deadline, $tmp->task_challenge_status);
        }
        $tmp->attached_docs = $this->attached_docs($tmp->id);
        if ($tmp->additional_attachment_requirement == 1) {
            $tmp->additional_requirement_status = 'Required';
        } elseif ($tmp->additional_attachment_requirement == 2) {
            $tmp->additional_requirement_status = 'Optional';
        } elseif ($tmp->additional_attachment_requirement == 0) {
            $tmp->additional_requirement_status = 'Not Required';
        }
        
        $task = $tmp;
        if($tmp->getTaskType->code=='risk')
        {
            return view('manager.task.risktaskdetail', compact('task','taskFieldDetails','formFields')); 
        }
        elseif($tmp->getTaskType->code=='issue')
        {
            return view('manager.task.issuetaskdetail', compact('task','taskFieldDetails','formFields'))->with(['page' => __('header.Task Details')]);
        }
        else
        {
            return view('manager.task.taskdetail', compact('task','taskFieldDetails'))->with(['page' => __('header.Task Details')]);    
        }
    }

    public function task_detail_client(Request $request)
    {
        $clients = $this->task_overview_clients($request->task_id, $request->page, $request->count);
        $funds = $this->task_overview_funds($request->task_id,$clients['client_ids'], $request->page, $request->count);
        $data['subfunds'] = $this->task_overview_subfunds($request->task_id, $funds['fund_ids'],$request->page, $request->count);
        $data['clients'] = $clients['clients'];
        $data['funds'] = $funds['funds'];
        return $data;
    }

    public function task_detail_assigned(Request $request)
    {
        $depts = $this->task_overview_departments($request->task_id,$request->get('cmpId'), $request->page, $request->count);
        $data['assignees'] = $this->task_overview_users($request->task_id,1,$depts['department_ids'], $request->page, $request->count);
        $data['reviewers'] = $this->task_overview_users($request->task_id,0,$depts['department_ids'], $request->page, $request->count);
        $data['departments'] = $depts['departments'];
        return $data;
    }

    public function store_issues_details(Request $request)
    {
        $issue_typeid=$request->issue_type_id;
        $taskid=$request->taskid;
        $issue_description=$request->issue_description;

        $issuedetails=Issue::create([
            'task_id'=> $taskid,
            'issue_type_id'=>$issue_typeid,
            'issue_description'=>$issue_description,
            'created_by_id'=>Auth()->user()->id
        ]);

        Tasks::where('id',$taskid)->update([
         'task_type'=>2
        ]);

       return  $issuedetails;
    }

    public function dependency_check(Request $request)
    {
       $t = Dependencies::where('task_id',$request->task_id)->join('tasks','tasks.id','dependencies.dependent_task_id')->where('tasks.completion_status',0)->first();
       if($t){
           return ['hasDependency' => true];
       }else{
           return ['hasDependency' => false];
       }
    }

    public function mis_validation(Request $request)
    {
        $misSat = true;
        foreach($request->mis_fileds as $item){
            $t = TaskMisField::where('id',$item['mis_id'])->first();
            if($t->field_type_id == 2){
                $tmp = MisFieldContent::where('task_mis_field_id',$item['mis_id'])->first();
                if($tmp->min_value > $item['value']){
                    $misSat = false;
                }
            }else{
                $tmp = MisFieldContent::where('task_mis_field_id',$item['mis_id'])->where('is_required',1)->first();
                if($tmp->options != $item['value']){
                    $misSat = false;
                }
            }
        }
        return ['misSatisfy' => $misSat];
    }

    public function task_reopen(Request $request)
    {
        $t = Tasks::where('id', $request->id)->first();
        $t->update([
            'completion_status' => 0,
            'task_challenge_status' => NULL,
            'completed_date_by_assignee' => NULL,
            'completed_by' => NULL,
            'approved_date' => NULL,
            'approved_by' => NULL,
            'reopen_reason' => $request->reopen_reason,
            'reopen_date' =>  date('Y-m-d H:i:s'),
            'reopen_by' => $request->get('cmpId')
        ]);
        TaskStatusTrack::save_reopen_status($request);
        return redirect()->back();
    }
}
