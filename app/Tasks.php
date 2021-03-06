<?php

namespace App;

use App\FtpTag;
use App\TaskTag;
use Carbon\Carbon;
use App\TaskRiskCategory;
use Illuminate\Support\Str;
use App\Http\Traits\UserAccess;

use App\Http\Traits\Base64ToImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tasks extends Model
{
    use UserAccess, SoftDeletes,Base64ToImage;

    protected $table = "tasks";
    protected $fillable = [
        'task_name', 'task_desc', 'due_date', 'frequency', 'company_id', 'department_id', 'additional_attachment_requirement', 'comments', 'is_mis', 'mis_defenition', 'task_status',
        'completion_status', 'created_by_id', 'task_type', 'completed_date_by_assignee','approved_date','approved_by','document_status'
    ];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    public function fund_group()
    {
        return $this->belongsTo('App\FundGroups');
    }
    public function sub_fund()
    {
        return $this->belongsTo('App\SubFunds');
    }
    public function assignees()
    {
        return $this->hasMany('App\TaskUsers', 'task_id', 'id')->where('user_action', 1)->join('company_users', 'company_users.id', '=', 'company_user_id')->join('users', 'users.id', '=', 'company_users.user_id')->select('company_users.*', 'task_users.*', 'users.*');
    }
    public function department()
    {
        return $this->belongsTo('App\Departments');
    }
    public function attachdocumentation()
    {
        return $this->hasMany('App\TaskAttachDocumentation', 'task_id', 'id');
    }
    public function mis_fields()
    {
        return $this->hasMany('App\TaskMisField', 'task_id', 'id');
    }
    public function reviewers()
    {
        return $this->hasMany(TaskUsers::class,'task_id', 'id')->where('user_action', 0);
    }
    public function task_clients()
    {
        return $this->hasMany('App\TaskClient', 'task_id', 'id')->with('clients');
    }
    public function task_documents()
    {
        return $this->hasMany('App\TaskDocument','task_id', 'id')->with('document');
    }
    public function task_department()
    {
        return $this->hasMany('App\TaskDepartment','task_id', 'id')->with('departments');
    }
    public function task_funds()
    {
        return $this->hasMany('App\TaskFundGroup','task_id', 'id')->with('fundgroups');
    }
    public function task_subfunds()
    {
        return $this->hasMany('App\TaskSubFund','task_id', 'id')->with('subfunds');
    }
    public function task_tagging()
    {
        return $this->hasMany('App\TaskTag','task_id','id')->join('tagging','tagging.id','=','task_tags.task_tag_id');
    }
    public static function saveRecords($request)
    {
        try {
            $taskinsertion = Tasks::create([
                'additional_attachment_requirement' => $request->customRadio1,
                'comments' => $request->task_tags,
                'task_status' => 1,
                'completion_status' => 0,
                'created_by_id' => Auth()->user()->getCompanyID->id,
                'task_type' => TaskType::getTaskTypeIDbyCode($request->formType),
                'status' => 1,
                'company_id'=>Auth()->user()->getCompanyID->company_id
            ]);  

            $taskFormfieldCollection=TaskType::with('getTaskTypeFields','getTaskTypeFields.getFieldDetails')
            ->where('code',$request->formType)->first();
            $taskFieldIDs=[];$taskFieldTypes=[];
            if($taskFormfieldCollection)
            {
                foreach($taskFormfieldCollection->getTaskTypeFields as $fieldtype)
                {
                    $taskFieldIDs[$fieldtype->getFieldDetails->id]=$fieldtype->getFieldDetails->code; 
                    $taskFieldTypes[$fieldtype->getFieldDetails->id]=$fieldtype->getFieldDetails->fieldType;               
                }
            }
            Log::info($taskFieldIDs);
            if($taskinsertion)
            {
                $riskCategoryDetails=[];
                foreach($request->formField as $requestKey => $requestDetails)
                {   
                    if(is_array($requestDetails))
                    {
                        Log::info("Key exists!".$taskFieldIDs[$requestKey]);
                        self::storeTaskSubDetails($taskinsertion->id,$requestDetails,$taskFieldIDs[$requestKey]);
                    }
                    elseif(in_array($taskFieldIDs[$requestKey],array('risk_category','risk_subcategory')))
                    {
                       
                        $riskCategoryDetails[$taskFieldIDs[$requestKey]]=$requestDetails;
                    }
                    elseif(in_array($taskFieldIDs[$requestKey],array('risk_register_impact','dependencies')))
                    {
                        self::storeTaskSubDetails($taskinsertion->id,array($requestDetails),$taskFieldIDs[$requestKey]);
                    }
                    else
                    {
                        $taskFieldValues=self::getFieldTypeValues($taskFieldTypes[$requestKey],$requestDetails);
                        $taskFieldValues['task_id']=$taskinsertion->id;
                        $taskFieldValues['task_field_id']=$requestKey;
                        TaskFieldValue::create($taskFieldValues);
                    }
                       
                }
                self::storeRiskCategory($taskinsertion->id,$riskCategoryDetails,'add');
            }

            if ($taskinsertion) {
                if($request->parent_task){
                    Dependencies::create([
                        'task_id' => $request->parent_task,
                        'dependent_task_id' => $taskinsertion->id
                    ]);
                }
                if (!is_null($request->mis)) {
                    MisFieldContent::mis_fields($request->mis, $taskinsertion->id);
                }
                if (!is_null($request->docs)) {
                    TaskDocument::save_task_docuemnts($request->docs, $taskinsertion->id);
                }
                if($taskinsertion->task_type == 1){
                    $fr = TaskFieldValue::where('task_field_values.task_id',$taskinsertion->id)->where('task_field_values.task_field_id',26)->join('field_dropdown_values','field_dropdown_values.id','task_field_values.dropdown_value_id')->select('field_dropdown_values.code')->first();
                    TaskScheduler::save_schedule_task($taskinsertion->id,$fr->code,$taskinsertion->created_at);
                }
                 if($request->task_tags)
            {
                  $tags=explode(",", $request->task_tags);
                  foreach($tags as $list)
                  {
                        $cntofrecords=Tagging::where('name','like',$list)->count();
                        if($cntofrecords>0)
                        {
                            $taggingdetails=Tagging::where('name','like',$list)->first();
                           
                            TaskTag::create([
                                'task_tag_id'=>$taggingdetails->id,
                                'task_id'=>$taskinsertion->id,
                                'company_id'=>Auth()->user()->getCompanyID->company_id
                            ]);
                        }
                        else
                        {
                            $companylist = CompanyUsers::where('user_id', '=', Auth()->user()->id)->first();
                             $tagins=Tagging::create([
                                  'name'=>$list,
                                  'code'=>$list,
                                  'company_id'=>$companylist->company_id
                             ]);

                             if($tagins)
                              {
                                TaskTag::create([
                                    'task_tag_id'=>$tagins->id,
                                    'task_id'=>$taskinsertion->id,
                                    'company_id'=>$companylist->company_id
                                ]);
                            }
                        }
                        
                    }
                 }

                 if($request->ftp_tags)
                 {
                  $ftptags=explode(",", $request->ftp_tags);
                  foreach($ftptags as $list)
                  {
                        $cntofrecords=Tagging::where('name','like',$list)->count();
                        if($cntofrecords>0)
                        {
                            $taggingdetails=Tagging::where('name','like',$list)->first();
                           
                            FtpTag::create([
                                'ftp_tag_id'=>$taggingdetails->id,
                                'task_id'=>$taskinsertion->id,
                                'company_id'=>Auth()->user()->getCompanyID->company_id
                            ]);
                        }
                        else
                        {
                            $companylist = CompanyUsers::where('user_id', '=', Auth()->user()->id)->first();
                             $tagins=Tagging::create([
                                  'name'=>$list,
                                  'code'=>$list,
                                  'company_id'=>$companylist->company_id
                             ]);

                             if($tagins)
                              {
                                FtpTag::create([
                                    'ftp_tag_id'=>$tagins->id,
                                    'task_id'=>$taskinsertion->id,
                                    'company_id'=>$companylist->company_id
                                ]);
                            }
                        }
                        
                    }
                 }
                 QuestionnaryFormDetail::where('created_by',auth()->user()->id)->update([
                    'task_id'=>$taskinsertion->id,
                    'status'=>1
                 ]);
                return true;
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    public static function updateRecords($request)
    {
        try {
            $taskUpdateData=[
                'additional_attachment_requirement' => $request->customRadio1,
                'comments' => $request->comments
            ];
            $taskinsertion = Tasks::find(request()->id);
            $taskFormfieldCollection=TaskType::with('getTaskTypeFields','getTaskTypeFields.getFieldDetails')
            ->where('code',$request->formType)->first();
            $taskFieldIDs=[];$taskFieldTypes=[];
            if($taskFormfieldCollection)
            {
                foreach($taskFormfieldCollection->getTaskTypeFields as $fieldtype)
                {
                    $taskFieldIDs[$fieldtype->getFieldDetails->id]=$fieldtype->getFieldDetails->code; 
                    $taskFieldTypes[$fieldtype->getFieldDetails->id]=$fieldtype->getFieldDetails->fieldType;               
                }
            }
            Log::info($taskFieldIDs);
            if($taskinsertion)
            {
                $riskCategoryDetails=[];
                foreach($request->formField as $requestKey => $requestDetails)
                {   
                    if(is_array($requestDetails))
                    {
                        self::storeTaskSubDetails($taskinsertion->id,$requestDetails,$taskFieldIDs[$requestKey]);
                    }
                    elseif(in_array($taskFieldIDs[$requestKey],array('risk_category','risk_subcategory')))
                    {
                       
                        $riskCategoryDetails[$taskFieldIDs[$requestKey]]=$requestDetails;
                    }
                    elseif(in_array($taskFieldIDs[$requestKey],array('risk_register_impact','dependencies')))
                    {
                        self::storeTaskSubDetails($taskinsertion->id,array($requestDetails),$taskFieldIDs[$requestKey]);
                    }
                    else
                    {
                        $taskFieldValues=self::getFieldTypeValues($taskFieldTypes[$requestKey],$requestDetails);
                        if(TaskFieldValue::where('task_id',$taskinsertion->id)
                        ->where('task_field_id',$requestKey)->exists())
                        {
                            TaskFieldValue::where('task_id',$taskinsertion->id)
                            ->where('task_field_id',$requestKey)
                            ->update($taskFieldValues);
                        }
                        else
                        {
                            $taskFieldValues['task_id']=$taskinsertion->id;
                            $taskFieldValues['task_field_id']=$requestKey;
                            TaskFieldValue::create($taskFieldValues);
                        }
                        
                    }
                       
                }
                self::storeRiskCategory($taskinsertion->id,$riskCategoryDetails,'update');
                if (!is_null($request->mis)) {
                    MisFieldContent::mis_fields($request->mis, $taskinsertion->id);
                }else{
                    TaskMisField::where('task_id',$taskinsertion->id)->delete();
                }
                TaskDocument::where('task_id',$taskinsertion->id)->delete();
                if (!is_null($request->docs)) {
                    TaskDocument::save_task_docuemnts($request->docs, $taskinsertion->id);
                }
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    public static function taskapproval($request)
    {
        Tasks::where('id', $request->taskid)->update([
            'task_challenge_status' => $request->completion,
            'completion_status' => $request->completion_status,
            'completed_date_by_assignee' => now(),
            'completed_by' => $request->get('cmpUsrId')
        ]);
        TaskStatusTrack::save_complete_status($request);
        $mis = json_decode($request->mis, true);
        foreach ($mis as $item) {
            $data = [];
            if ($item['type'] == 'number' || $item['type'] == 'text') {
                $data = [
                    'task_mis_field_id' => $item['mis_id'],
                    'value' => $item['value'],
                ];               
            } else {
               $data = [
                    'task_mis_field_id' => $item['mis_id'],
                    'option_id' => $item['value']
                ];
            }
            $ex = TaskMisResult::where('task_mis_field_id',$item['mis_id'])->first();
            if($ex){
                $ex->update($data);
            }else{
                TaskMisResult::create($data);
            }
        }
        return true;
    }
    public static function approvetask($request)
    {
        Tasks::where('id', $request->taskid)->update(['completion_status' => 1,'approved_date'=>now(),'approved_by'=>$request->get('cmpUsrId')]);
        return true;
    }
    public static function approveall($departmentfilter)
    {
        if ($departmentfilter != "") {
            Tasks::where('completion_status', 2)->where('department_id', $departmentfilter)->update(['completion_status' => 1]);
        } else {
            Tasks::where('completion_status', 2)->update(['completion_status' => 1]);
        }
        return true;
    }
   
    public static function info_stats($data)
    {
        $comp = $data->filter(function ($q) {
            return $q->completion_status != 0;
        });
        $not_completed = $data->filter(function ($q) {
            return $q->completion_status == 0;
        });
        $completed = 0;
        $active = 0;
        $urgent = 0;
        $overdue = 0;
        $awaiting_approval = 0;
        foreach($data as $item){
            $fr = task_field_value_text($item->id,'frequency');
            $due_date=task_field_value_text($item->id,'due_date');
            if($item->completion_status == 1){
                $item->status = 2;
                $item->filter = 4;
                $completed++;
                if($item->task_challenge_status == 1){
                    $item->uiClass = "circle_danger";
                    $item->status_name = "Completed with Challenge";
                }else{
                    $item->uiClass = "circle_success";
                    $item->status_name = "Completed";
                }
            }
            if($item->completion_status == 2){
                $awaiting_approval++;
                $item->uiClass = $item->task_challenge_status == 1 ? "circle_danger" : "circle_waiting";
                $item->status_name = "Awaiting Approval";
                $item->status = 2;
                $item->filter = 5;
            }
            if($item->completion_status == 0){
                $item->status = 0;
                if($due_date < date("Y-m-d H:i:s")){
                    $overdue++;
                    $item->uiClass = "circle_danger";
                    $item->status_name = "Overdue";
                    $item->filter = 3;
                }else{
                    if ($fr == "Ad Hoc" || $fr == "Daily" || $fr == "Weekly") {
                        if(date("Y-m-d H:i:s",strtotime($due_date. " -1 days")) > date("Y-m-d H:i:s")){
                            $active++;
                            $item->uiClass = "circle_primary";
                            $item->status_name = "On Track";
                            $item->filter = 1;
                        }else{
                            $urgent++;
                            $item->uiClass = "circle_warning";
                            $item->status_name = "Urgent";
                            $item->filter = 2;
                        }
                    }
                    if ($fr == "Monthly" || $fr == "Quarterly") {
                        if(date("Y-m-d H:i:s",strtotime($due_date. " -3 days")) > date("Y-m-d H:i:s")){
                            $active++;
                            $item->uiClass = "circle_primary";
                            $item->status_name = "On Track";
                            $item->filter = 1;
                        }else{
                            $urgent++;
                            $item->uiClass = "circle_warning";
                            $item->status_name = "Urgent";
                            $item->filter = 2;
                        }
                    }
                    if ($fr == "Annually") {
                        if(date("Y-m-d H:i:s",strtotime($due_date. " -14 days")) > date("Y-m-d H:i:s")){
                            $active++;
                            $item->uiClass = "circle_primary";
                            $item->status_name = "On Track";
                            $item->filter = 1;
                        }else{
                            $urgent++;
                            $item->uiClass = "circle_warning";
                            $item->status_name = "Urgent";
                            $item->filter = 2;
                        }
                    }
                }
                
            }

        }
        // $active = $not_completed->filter(function ($q) {
        //     $due_date=task_field_value_text($q->id,'due_date');
        //     Log::info($due_date);
        //     $deadline = date('Y-m-d', strtotime('+' . $q->deadline . 'days'));
        //     if ($deadline < date('Y-m-d', strtotime($due_date))) {
        //         return $q;
        //     }
        // })->count();
        // $urgent = $not_completed->filter(function ($q) {
        //     $due_date=task_field_value_text($q->id,'due_date');
        //     $deadline = date('Y-m-d', strtotime('+' . $q->deadline . 'days'));
        //     if ($deadline >= date('Y-m-d', strtotime($due_date)) && date('Y-m-d') <= date('Y-m-d', strtotime($due_date))) {
        //         return $q;
        //     }
        // })->count();
        // $overdue = $not_completed->filter(function ($q) {
        //     $due_date=task_field_value_text($q->id,'due_date');
        //     if (date('Y-m-d') > date('Y-m-d', strtotime($due_date))) {
        //         return $q;
        //     }
        // })->count();

        // $completed = $comp->filter(function ($q) {
        //     return $q->completion_status == 1;
        // })->count();
        // $awaiting_approval = $comp->filter(function ($q) {
        //     return $q->completion_status == 2;
        // })->count();

        return [
            'active' => $active,
            'overdue' => $overdue,
            'urgent' => $urgent,
            'completed' => $completed,
            'awaiting_approval' => $awaiting_approval,
            'total' => $active + $overdue + $urgent + $completed + $awaiting_approval,
            'data' => $data
        ];
    }

    public static function storeTaskSubDetails($task_id,$taskSubDetails,$subDetailType)
    {
        switch($subDetailType)
        {
            case 'clients':
                    TaskClient::savetaskclients($taskSubDetails, $task_id, Auth::user()->getCompanyID->id);
                    break;
            case 'fund_groups':
                    TaskFundGroup::savefundgroups($taskSubDetails, $task_id);
                    break;
            case 'sub_fund_groups':
                    TaskSubFund::savesubfundgroups($taskSubDetails, $task_id);
                    break;
            case 'departments':
                    TaskDepartment::savetaskdepartments($taskSubDetails, $task_id);
                    break;
            case 'assignees':
                    TaskUsers::task_users_save($taskSubDetails,1,$task_id);
                    break;
            case 'reviewers':
                    TaskUsers::task_users_save($taskSubDetails,0,$task_id);
                    break;
            case 'dependencies':
            case 'risk_register_impact':
                    Dependencies::savedependencies($taskSubDetails, $task_id);
                    break;
	    case 'associate_activity':
                    Dependencies::savedependencies($taskSubDetails, $task_id);
                    break;
            default:
                    Log::info($task_id);
        }
    }
    public static function getFieldTypeValues($type,$FieldValue)
    {
        
        if(in_array($type,array('dropdown_value','radio_button','select2')))
        {
            if($FieldValue)
            {
                $formFieldsValue['dropdown_value_id']=(int) $FieldValue;
            }
            else
            {
                $formFieldsValue['dropdown_value_id']=null;
            }

        }
        elseif($type=='date')
        {
            $formFieldsValue['date']=$FieldValue?date(AppConst::DATEFORMATS, strtotime($FieldValue)):null;
        }
        elseif($type=='file')
        {
            $document=$FieldValue;
            $documentFormat=explode('Nexus',$document);
            $extension=$documentFormat[1];
            $fileName = Str::random(10).'.'.$extension;
            $path = 'documents/'.$fileName;
            Log::info($path);
            Storage::disk('s3')->put($path, base64_decode($documentFormat[0]), 'public');
            $formFieldsValue['text']= $path;
        }
        else
        {
            $formFieldsValue[$type]=$FieldValue;
        }
        return $formFieldsValue; 
    }

    public function getTaskType()
    {
        return $this->hasOne(TaskType::class,'id','task_type');
    }

    public function task_schedule_fieldvalues()
    {
        return $this->hasMany('App\TaskFieldValue','task_id','id');
    }

    public function task_schedule_clients()
    {
        return $this->hasMany('App\TaskClient','task_id','id');
    }

    public function task_schedule_funds()
    {
        return $this->hasMany('App\TaskFundGroup','task_id','id');
    }

    public function task_schedule_subfunds()
    {
        return $this->hasMany('App\TaskSubFund','task_id','id');
    }

    public function task_schedule_dependencies()
    {
        return $this->hasMany('App\Dependencies','task_id','id');
    }

    public function task_schedule_departments()
    {
        return $this->hasMany('App\TaskDepartment','task_id','id');
    }

    public function task_schedule_users()
    {
        return $this->hasMany('App\TaskUsers','task_id','id');
    }

    public function task_schedule_documents()
    {
        return $this->hasMany('App\TaskDocument','task_id','id');
    }

    public function task_schedule_misfields()
    {
        return $this->hasMany('App\TaskMisField','task_id','id')->with('mis_field_contents');
    }
  
    public static function storeRiskCategory($taskID,$riskCategoryDetails,$mode)
    {
        Log::info($riskCategoryDetails);
        if(!empty($riskCategoryDetails))
        {
        $taskRiskCategory=([
            'task_id'=>$taskID,
            'risk_category_id'=>$riskCategoryDetails['risk_category'],
            'risk_sub_category_id'=>isset($riskCategoryDetails['risk_subcategory'])?$riskCategoryDetails['risk_subcategory']:null
        ]);
        if($mode=='add')
        {
        TaskRiskCategory::create($taskRiskCategory);
        }
        else
        {
            TaskRiskCategory::where('task_id',$taskID)->update($taskRiskCategory);
        }
        
        }
    }

    public function getRiskCategory()
    {
        return $this->hasOne(TaskRiskCategory::class,'task_id','id')->join('risk_categories','risk_categories.id','task_risk_categories.risk_category_id');
    }
    public function getChildCategory()
    {
        return $this->hasOne(TaskRiskCategory::class,'task_id','id')->join('risk_categories','risk_categories.id','task_risk_categories.risk_sub_category_id');
    }

    public function getCreatedUserDetails()
    {
        return $this->hasOne(User::class,'id','created_by_id');
    }

    public function departmentDetails()
    {
        return $this->hasMany(TaskDepartment::class,'task_id','id');
    }

    public function fundGroupDetails()
    {
        return $this->hasMany(TaskFundGroup::class, 'task_id', 'id');
    }
    public function subFundGroupDetails()
    {
        return $this->hasMany(TaskSubFund::class, 'task_id', 'id');
    }

    public static function issues_count($request)
    {
        $formType = 'issue';
        $callback = function($query) use ($formType) {
            $query->where('code', '=', $formType);
        };
        $tasks = Tasks::whereHas('getTaskType', $callback)->with(['getTaskType' => $callback]);
        $tasks = self::task_access($tasks);
        if($request->department_id){
            $tasks->where('task_departments.department_id', $request->department_id);
        }
        $tasks = $tasks->pluck('tasks.id');
        $data = [];
        for($i=1;$i<=date('m',strtotime('dec'));$i++){
            $month = date('m', mktime(0, 0, 0, $i, 10));
           $data[$i-1] = Tasks::whereIn('id',$tasks)->whereMonth('created_at',$month)->count();
        }
        return ['issue_data'=>$data];
    }

    public static function delete_task($id)
    {
        try {
            Tasks::find($id)->delete();
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info("Locked user attempt for Reset" . $e);
        }
    }
}
