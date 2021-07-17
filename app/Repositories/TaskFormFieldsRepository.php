<?php

namespace App\Repositories;

use App\Tasks;
use App\TaskType;
use App\Dependencies;
use App\TaskFieldValue;
use App\FieldDropdownValue;
use App\QuestionnaryFormDetail;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\TaskFormFieldsInterface;

class TaskFormFieldsRepository implements TaskFormFieldsInterface
{

   /**
    * TaskFormFieldsRepository constructor.
    *
    * @param TaskType $model
    */
    protected $tableModel;
   public function __construct(TaskType $model)
   {
       $this->tableModel=$model;
   }

   /**
    * @return Collection
    */
   public function taskType(): Collection
   {
       return $this->tableModel->all();    
   }

   public function getTaskFormFields($taskType = null)
   {
       $taskTypecollaction=$this->tableModel::with('getTaskTypeFields','getTaskTypeFields.getFieldDetails')->where('code',$taskType)->first();
       $formFieldCollection=[];
       if($taskTypecollaction)
       {
        foreach($taskTypecollaction->getTaskTypeFields as $fieldtype)
        {
            $formField['formGroupDetails']=$fieldtype->getFormGroupDetails;
            $formField['details']=$fieldtype->getFieldDetails;
            $formField['details']['option']=$fieldtype->getFieldOptions;
            $formField['details']['is_requried']=$fieldtype->is_requried;
            $formFieldCollection[$fieldtype->task_form_field_group_id][]=$formField;
        }
       }
       $taskFormDetails=[];
       foreach($formFieldCollection as $fieldGroup => $fieldDetails)
       {
           
           $fieldgroupDetails=[];
           $groupSlug=[];
           $groupDetails=[];
            foreach($fieldDetails as $field)
            {
               
                $fieldgroupDetailsSlug=$field['formGroupDetails']->group_slug;
                
                $fieldgroupDetailsWizard=$field['formGroupDetails']->step_wizard;
                if(!isset($groupSlug[$field['formGroupDetails']->group_slug]))
                {
                $groupDetails[$fieldgroupDetailsSlug]['groupDetails']=$field['formGroupDetails'];
                }
                $groupSlug[$field['formGroupDetails']->group_slug]=$field['formGroupDetails']->group_slug;
                $groupDetails[$fieldgroupDetailsSlug]['details'][]=$field['details'];
                
            }
                $taskFormDetails[$fieldgroupDetailsWizard][]=$groupDetails;
            //array_push($taskFormDetails,$fieldgroupDetails);
       }
       return $taskFormDetails;
   }

   public function gettaskdependiencies($request)
   {
    $formType='risk';
        $taskFieldType = function($query) {
            $query->whereIn('code', array('risk_name'));
        };
    $taskType = function($query) use ($formType) {
        $query->where('code', '=', $formType)
        ->where('company_id',Auth()->user()->getCompanyID->company_id);
    };
    
        $task = TaskFieldValue::whereHas('getTaskFieldType', $taskFieldType)
        ->whereHas('getTask.getTaskType',$taskType)
        ->with('getTaskFieldType')
        ->with('getTask');
    $taskDetails=$task->get();
    $taskCollection=[];
    foreach($taskDetails as $task)
    {
        $taskCollection[]=array('task_name'=>$task->text,'id'=>$task->task_id);
    }
    return $taskCollection;
   }

   public function getTaskFormFieldsValues($taskID)
   {
        $taskDetails=Tasks::find($taskID);
        $fieldvalue=TaskFieldValue::with('getTaskFieldType','getTaskFieldType.getFieldType')
        ->where('task_id',$taskID)
        ->get();
        $taskFieldDetails=[];
        if($taskDetails)
        {
            if($fieldvalue)
            {
                foreach($fieldvalue as $taskFieldValues)
                {
                $type=$taskFieldValues->getTaskFieldType->getFieldType->code;
                if(in_array($type,array('dropdown_value','radio_button')))
                {
                    $dropDownID=$taskFieldValues->dropdown_value_id;
                    $taskdropDownFieldValue=FieldDropdownValue::where('id',$dropDownID)->first();
                    $taskFieldDetails[$taskFieldValues->getTaskFieldType->code]=$taskdropDownFieldValue?$taskdropDownFieldValue->id:'';
                }
                elseif($type=='file')
                {
                    $taskFieldDetails[$taskFieldValues->getTaskFieldType->code]=$taskFieldValues->text;
                }
                else
                {
                    $taskFieldDetails[$taskFieldValues->getTaskFieldType->code]=$taskFieldValues->$type;
                }
                
                }
            }
            $clientDetails=$taskDetails->task_clients;
            if($clientDetails)
            {
                $clientCollection=[];
                foreach($clientDetails as $client)
                {
                    $clientCollection[]=$client->client_id;
                }
                $taskFieldDetails['clients']=$clientCollection;
            }
            $departmentsDetails=$taskDetails->departmentDetails;
            if($departmentsDetails)
            {
                $departmentCollection=[];
                foreach($departmentsDetails as $department)
                {
                    $departmentCollection[]=$department->departments->id;
                }
                $taskFieldDetails['departments']=$departmentCollection;
            }
            $assigneesDetails=$taskDetails->assignees;
            if($assigneesDetails)
            {
                $assigneesCollection=[];
                foreach($assigneesDetails as $assignees)
                {
                    $assigneesCollection[]=$assignees->company_user_id;
                }
                $taskFieldDetails['assignees']=$assigneesCollection;
            }
            $fund_groupDetails=$taskDetails->fundGroupDetails;
            if($fund_groupDetails)
            {
                $fundGroupCollection=[];
                foreach($fund_groupDetails as $fund_group)
                {
                    $fundGroupCollection[]=$fund_group->fund_group_id;
                }
                $taskFieldDetails['fund_groups']=$fundGroupCollection;
            }
            $subfund_groupDetails=$taskDetails->subFundGroupDetails;
            if($subfund_groupDetails)
            {
                $subfundGroupCollection=[];
                foreach($subfund_groupDetails as $subfund_group)
                {
                    $subfundGroupCollection[]=$subfund_group->sub_funds_id;
                }
                $taskFieldDetails['sub_fund_groups']=$subfundGroupCollection;
            }
            $reviewers_groupDetails=$taskDetails->reviewers;
            if($reviewers_groupDetails)
            {
                $reviewerGroupCollection=[];
                foreach($reviewers_groupDetails as $reviewer)
                {
                    $reviewerGroupCollection[]=$reviewer->company_user_id;
                }
                $taskFieldDetails['reviewers']=$reviewerGroupCollection;
            }
            $dependencies=$taskDetails->task_schedule_dependencies;
            if($dependencies)
            {
                $dependenciesCollection=[];
                foreach($dependencies as $taskdependencies)
                {
                    $dependenciesCollection[]=$taskdependencies->dependent_task_id;
                }
                $taskFieldDetails['dependencies']=$dependenciesCollection;
            }
        }
        return $taskFieldDetails;
   }

   /**
     * Store the QuestionnaryForm Details
     *
     * @param array $data type
     * @return string
     */
    public function storeQuestionnaryFormDetails(array $data)
    {
        $questionnaryForm=new QuestionnaryFormDetail($data);
        $questionnaryForm->save();
    }
}