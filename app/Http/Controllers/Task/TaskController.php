<?php

namespace App\Http\Controllers\Task;

use App\Tasks;
use App\Client;
use App\Company;
use App\AppConst;
use App\SubFunds;
use App\TaskType;
use App\Frequency;
use App\TaskField;
use App\FundGroups;
use App\TaskClient;
use App\CompanyFund;
use App\DepartmentMembers;
use App\Departments;
use App\Dependencies;
use App\DocumentType;
use App\RiskCategory;
use App\TaskFieldValue;
use App\FieldDropdownValue;
use App\Support\Collection;
use Illuminate\Http\Request;
use App\Traits\CommonFunction;
use App\Http\Traits\TaskDetail;
use App\Http\Traits\TaskFilter;
use App\Http\Traits\UserAccess;
use App\Rules\TaskDocumentTypes;
use App\TaskAttachDocumentation;
use Illuminate\Support\Facades\Log;
use App\Clients\QuestionnaireClient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TaskCreationStepOne;
use App\Http\Requests\SaveTaskCreationRequest;
use App\Repositories\TaskFormFieldsRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\FormValidationRequest;
use App\Http\Traits\DatePeriod;
use App\Http\Traits\EnvelopeEncryption;
use App\Http\Traits\TaskList;

class TaskController extends Controller
{
    private $taskFormFields;

    use CommonFunction, TaskFilter, TaskDetail, UserAccess, EnvelopeEncryption, TaskList, DatePeriod;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskFormFieldsRepository $taskFormFieldsRepository)
    {
        $this->taskFormFields=$taskFormFieldsRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data_period = 'Quarterly';
        $data_period_dates = [date('Y-m-d',strtotime(date('Y-m-d').'-90 days')),date('Y-m-d')];
        if($request->data_period)
        {
            $data_period = $request->data_period;
            $data_period_dates = json_decode(base64_decode($request->dates));
        }
        $formType=isset(request()->type)?base64_decode(request()->type):'';
        $data = self::task_list($formType);
        if($request->year && $request->period){
            $dates = $this->get_dates($request->year, $request->period);
            $data = $data->whereBetween('tasks.created_at', [$dates]);
        }
        if($request->search){
            $data->where('task_field_values.text','LIKE','%'.$request->search.'%');
        }
        if($formType=='risk')
        {
            $data = $data->whereBetween('tasks.created_at',$data_period_dates);
            $data=self::task_riskCategory($data,null);
        }
        $data = $data->get();
        
        
        
        if(request()->risktype && request()->risktype=='raised')
        {
            
            $data = $data->filter(function ($item) {
                if(Dependencies::where('dependent_task_id',request()->riskId)->where('task_id',$item->id)->exists())
                {
                    return $item;
                }

            })->values()->all();

            $data = (new Collection($data));
        }

        if(request()->risktype && request()->risktype=='overdue')
        {
            $data = $data->filter(function ($item) {
                if(Dependencies::where('task_id',request()->riskId)->where('dependent_task_id',$item->id)->exists())
                {
                    if (date('Y-m-d') > date('Y-m-d', strtotime($item->due_date))) {
                        return $item;
                    }
                }
            })->values()->all();
            $data = (new Collection($data));
        }

        if(request()->risktype && request()->risktype=='withChallenge')
        {
            $data = $data->filter(function ($item) {
                if(Dependencies::where('task_id',request()->riskId)->where('dependent_task_id',$item->id)->exists())
                {
                    if ($item->task_challenge_status == 1) {
                        return $item;
                    }
                }
            })->values()->all();
            $data = (new Collection($data));
        }

        $tmp_data = Tasks::info_stats($data);

        $data = (new Collection($tmp_data['data']));

        $filter_data = self::task_list_filter($request,$data,$formType);

        $info = array_merge($tmp_data, [
            'filter_name' => $filter_data['filter_name'],
            'department_name' => $filter_data['department']
        ]);
        $info['data_period'] = $data_period;
        $data = $filter_data['data']->paginate(config(AppConst::COMMON_PAGINATE));
        if($request->search){
            $content = view('manager.task.risk_list',compact('data'))->render();
            $pagination = view('includes.pagination', compact('data'))->render();
            return ['data' => $content, 'pagination' => $pagination];
        }
        if($formType=='task')
        {
            $response = view('manager.task.home', compact('data', 'info'))->with(['page' => __('header.Tasks Dashboard')]);
        }
        elseif($formType=='issue')
        {
            $response = view('manager.task.issue_home', compact('data', 'info'))->with(['page' => __('Issue Dashboard')]);
        }
        elseif($formType=='risk')
        {
            $response = view('manager.task.risk_home', compact('data', 'info'))->with(['page' => 'Risk Dashboard']);
        } 
        return $response;
    }

    public function awaiting_approval(Request $request)
    {
        $formType=isset(request()->type)?base64_decode(request()->type):'';
        $callback = function($query) use ($formType) {
            $query->where('code', '=', $formType);
        };
        $data = Tasks::whereHas('getTaskType', $callback)->with(['getTaskType' => $callback])->select(AppConst::TASKS)->orderBy(AppConst::TASKS_CREATEDAT, 'DESC')->where('completion_status', 2);
        $fieldName='task_name';
        if($formType=='issue')
        {
            $fieldName='issue_name';
        }
        $data = self::task_access($data, null);
        $data = $data->get();
        $data = self::task_detail($data, $request->get('cmpUsrId'));
        if ($request->department_filter) {
            $data = $data->filter(function ($item) use ($request) {
                foreach ($item->departments as $i) {
                    if ($i->id == $request->department_filter) {
                        return $item;
                    }
                }
            })->values()->all();
            $department = $request->department;
        } else {
            $department = 'All';
        }
        if ($request->filter) {
            $filter_name = $request->filter_name;
            $data = self::task_status_filter($data, $request->filter, $request->status);
        } else {
            $filter_name = 'All';
        }
        $data = (new Collection($data));
        $info = array_merge(Tasks::info_stats($data, $request->get('cmpId'), $request->get('cmpUsrId'), $request->department_filter ?? null), [
            'filter_name' => $filter_name,
            'department_name' => $department
        ]);
        $info['approveAllID'] = $data->pluck('id');
        $taskdetails = $data->paginate(config(AppConst::COMMON_PAGINATE));
        return view('manager.task.awaiting_approval', compact('taskdetails', 'info','fieldName','formType'))->with(['awaitingapproval_form_backurl' => __('header.Returns to Task Home')]);
    }

    public function addtask_index(Request $request)
    {
        $documenttypes = DocumentType::all();

        $notification_list = $this->notificationlist();
        $formType=isset(request()->type)?base64_decode(request()->type):'';
        $formFields=$this->taskFormFields->getTaskFormFields($formType);
        $taskFieldDetails=array();
        if(request()->task_id)
        {
            $taskFieldDetails=$this->taskFormFields->getTaskFormFieldsValues($request->task_id);  
        }
        return view('manager.task.addtask', compact('documenttypes','formFields','formType','taskFieldDetails'))->with(['page' =>'Create '.ucfirst($formType).' Form' , 'notification_data' => $notification_list]);
    }

    public function edittask(Request $request)
    {
        
        if($request->delete){
            return Tasks::delete_task($request->id);
        }
        $taskDetails=Tasks::find(request()->id);
        $notification_list = $this->notificationlist();
        $formType=$taskDetails->getTaskType->code;
        $formFields=$this->taskFormFields->getTaskFormFields($formType);
        $taskFieldDetails=$this->taskFormFields->getTaskFormFieldsValues($request->id);               
                    if($formType=='risk')
                    {
                        $taskFieldDetails['risk_category']=$taskDetails->getRiskCategory->id;
                        $taskFieldDetails['risk_subcategory']=$taskDetails->getChildCategory->id??null;
                    }
                    if($formType=='task'){
                        $taskFieldDetails['mis'] = $this->task_mis($request->id);
                    }
        return view('manager.task.edittask', compact('formFields','formType','taskFieldDetails'))->with(['page' => 'Edit '.ucfirst($formType).' Form', 'notification_data' => $notification_list]);
    }

    public function dependency_companyid(Request $request)
    {
        $dependency=$this->taskFormFields->gettaskdependiencies($request);
        
        return $dependency;
    }
    public function fundgroupby_companyid(Request $request)
    {
        $f = FundGroups::select('fund_groups.*')->join('company_fund_groups', 'company_fund_groups.fund_group_id', 'fund_groups.id')->where('company_fund_groups.company_id', $request->get('cmpId'));
        $clients = $request->clients;
        if (count($request->clients) == 1 && $request->clients[0] == 0) {
            $company_list = Client::select('clients.*');
            $company_list = self::client_access($company_list);
            $clients = $company_list->pluck('clients.id');
            Log::info($clients);
        }
        return $f->join('client_fund_groups', 'client_fund_groups.company_fund_group_id', '=', 'company_fund_groups.id')->whereIn('client_fund_groups.client_id', $clients)->distinct('fund_groups.id')->get();
    }

    public function subfundby_fundid(Request $request)
    {
    
        return SubFunds::whereIn('fund_group_id', $request->fundgroups)->get();
        
    }

    public function departments_by_clients(Request $request)
    {
        $clients[] = $request->clients;
        $departments_list = Departments::select('departments.name', 'departments.dep_icon', 'company_departments.*');
        $departments_list = self::department_restriction($departments_list);
        if (count($clients) == 1 && $clients[0] == 0) {
            $company_list = Client::select('clients.*');
            $company_list = self::client_access($company_list);
            $clients = $company_list->pluck('clients.id');
        }
        return $departments_list->join('client_departments', 'client_departments.company_department_id', 'company_departments.id')->whereIn('client_departments.client_id', $clients)->distinct('deparments.id')->get();
    }

    public function usersby_departmentid(Request $request)
    {
        Log::info($request->departments);
        $users = DepartmentMembers::select('users.*','company_users.id as company_user_id')->whereIn('department_members.department_id',$request->departments)->join('company_users','company_users.id','department_members.company_user_id')->join('users','users.id','company_users.user_id')->distinct('company_user_id')->get();
        $key = self::decryptDataKey();
        foreach ($users as $members) {
            $members->name = self::DecryptedData($members->name, $key);
        }
        return $users;
    }

    public function task_approval()
    {
        return view('manager.task.task_approval')->with(['page' => __('header.Teams')]);
    }

    public function store_taskdetails(Request $request)
    {
        $formFields = $this->taskFormFields->getTaskFormFields($request->formType);
        $taskinsertion = Tasks::saveRecords($request, $formFields);
        if ($taskinsertion) {
            return ['status' => 'success', 'hasErrors' => false];
        }
        return ['status' => 'failure', 'hasErrors' => true];
    }

    public function update_task(Request $request)
    {
        $formFields = $this->taskFormFields->getTaskFormFields($request->formType);
        $taskinsertion = Tasks::updateRecords($request, $formFields);
        if ($taskinsertion) {
            return ['status' => 'success', 'hasErrors' => false];
        }
        return redirect()->route('task.form',['type'=>base64_encode($request->formType)]);
    }

    public function update_taskdetails(Request $request)
    {
        $input_data = $request->all();
        $validator = Validator::make(
            $input_data, [
            'file.*' => ['max:30000',new TaskDocumentTypes]
            ]
        );
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(['data'=>$validator->errors(),'hasErrors'=>true]));
        }
        Tasks::taskapproval($request);
        $destinationPath = 'uploads';
        if ($request->has('file')) {
            foreach ($request->file('file') as $file) {
                $file->move($destinationPath, $file->getClientOriginalName());
                TaskAttachDocumentation::create([
                    'task_id' => $request->taskid,
                    'file_path' => $destinationPath . "/" . $file->getClientOriginalName(),
                ]);
            }
        }
        return ['hasErrors' => false];
    }

    public function addtask_stepone_validation(TaskCreationStepOne $request)
    {
        return ['hasErrors' => false];
    }

    public function addtask_validation(SaveTaskCreationRequest $request)
    {
        return ['hasErrors' => false];
    }

    public function mis_field(Request $request)
    {
        return view('includes.misFields.mis-field-' . $request->type);
    }
    public function approvetask(Request $request)
    {
        Tasks::approvetask($request);
        return redirect()->route('awaiting_approval');
    }
    public function approveall(Request $request)
    {
        $data=str_replace (array('[', ']'), '' , $request->all_ids);
        $expdata=explode(",",$data);
        foreach($expdata as $value)
        {
        Tasks::where('id',$value)->update(['completion_status' => 1,'approved_date'=>now(),'approved_by'=>$request->get('cmpUsrId')]);
        }
        return redirect()->route('awaiting_approval');
    }

    public function fetchtaskdetails(Request $request, $id)
    {
        $tmp = Tasks::where(AppConst::TASK_ID, $id)->join('users', 'users.id', '=', 'created_by_id')->select(AppConst::TASKS, 'users.name as created_by_name', 'users.avatar as created_by_avatar')->get();
        $data = self::task_detail($tmp, $request->get('cmpId'))[0];
        $data->mis = $this->task_mis($data->id);
        $data->attachdocumentation = $this->attached_docs($data->id);
        return view('manager.task.awaiting-popup-model',compact('data'));
    }

    public function retriveTaskFormDetails()
    {
        if (request()->type == 'client') {
            $company_list = Client::orderBy('clients.created_at')->select('clients.*');
            $company_list = self::client_access($company_list);
            $resposeDetails = $company_list->get();
        } elseif (request()->type == 'riskCategory') {
            $resposeDetails = RiskCategory::whereNull('parent_id')->get();
        } elseif (request()->type == 'riskSubCategory') {
            $resposeDetails = RiskCategory::whereNotNull('parent_id')
            ->where('parent_id',request()->category_id)
                ->get();
        } elseif(request()->type == 'departments') {
            $departments_list = Departments::select('departments.*');
            $departments_list = self::department_restriction($departments_list);
            $resposeDetails = $departments_list->get();
        }
        return $resposeDetails;
    }

    public function form_validation(FormValidationRequest $request)
    {
        return ['hasErrors' => false];
    }

    public function generateFormFields()
    {
      $path = storage_path().'/app/fieldDetails/fieldType.json'; // ie: /var/www/laravel/app/storage/json/filename.json
      $json = json_decode(file_get_contents($path), true);       
      return isset($json[request()->fieldType]) ? $json[request()->fieldType]:array(); 
    }
    public function retriveFormFieldsWorkspace()
    {
      return QuestionnaireClient::getWorkspace();
    }

    public function questionnaire_formdetails()
    {
       if(request()->isMethod('post')) 
       {
            Log::info(request()->all());
            $formData=request()->formdata;
            if(request()->existingworkspace)
            {
                    $formData["workspace"]=array("href"=> "https://api.typeform.com/workspaces/Bh6CEU");
            }
            else
            {
                $workspaceDetails=QuestionnaireClient::createWorkspace(request()->workspace);
                if(isset($workspaceDetails['forms']))
                {
                    $formData["workspace"]=array("href"=> "https://api.typeform.com/workspaces/Bh6CEU");
                } 
            }
            $formResponseData=QuestionnaireClient::createForm($formData);
            Log::info($formResponseData);
            if(isset($formResponseData['id']))
            {
                $data['task_id']=request()->taskId;
                $data['form_id']=$formResponseData['id'];
                $data['created_by']=auth()->user()->id;
                $this->taskFormFields->storeQuestionnaryFormDetails($data);
               $responseDetails=['status'=>true,'message'=>'Form has been created Successfully!!'];
            }
            else if(isset($formResponseData['description']))
            {
                $responseDetails=['status'=>false,'message'=>$formResponseData['description']];
            }
            else
            {
                $responseDetails=['status'=>false,'message'=>'Issue in Form storing'];
            }
            return json_encode($responseDetails);
       }
       else
       {
        return QuestionnaireClient::getFormDetails();
       }
    }
    public function questionnaire_fieldsdetails()
    {
        return json_encode(config('questionary'));
    }
}
