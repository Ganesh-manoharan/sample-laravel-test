<?php

use App\Company;
use App\Departments;
use App\DocumentType;
use App\Http\Traits\EnvelopeEncryption;
use App\Http\Traits\MenuList;
use App\Http\Traits\CommonTrait;
use App\FundGroups;
use App\Countries;
use App\Dependencies;
use App\UserNotification;
use App\IssueType;
use App\Roles;
use App\TaskFieldValue;
use App\FieldDropdownValue;
use App\TaskRiskCategory;

if (! function_exists('decryptKMSvalues')) {
    function decryptKMSvalues($data,$key=null){
        
        try {
            return EnvelopeEncryption::DecryptedData($data,$key);
        } catch(\RuntimeException $e) {
            return $data;
        }

    }
}

if (! function_exists('menuList')) {
    function menuList($menu){
        
        try {
            return MenuList::menu($menu);
        } catch(\RuntimeException $e) {
            return $e;
        }

    }
}

if (! function_exists('taskFilterList')) {
    function taskFilterList($type=''){
        
        try {
            if($type=='issue')
                return CommonTrait::issue_filter_options();
            else
            return CommonTrait::task_filter_options();
        } catch(\RuntimeException $e) {
            return $e;
        }

    }
}

if (! function_exists('departmentList')) {
    function departmentList(){
        
        try {
            return Departments::departments_list();
        } catch(\RuntimeException $e) {
            return $e;
        }

    }
}

if(! function_exists('fundgroupsList'))
{
    function fundgroupsList(){
        try{
            return FundGroups::fundgroups_list();
        } catch(\RuntimeException $e)
        {
            return $e;
        }
    }
}

if(! function_exists('countryList'))
{
    function countryList(){
        try{
            return Countries::country_list();
        }catch(\RuntimeException $e)
        {
            return $e;
        }
    }

}

if (! function_exists('userNotifications')) {
    function userNotifications(){
        
        try {
            return UserNotification::notifications();
        } catch(\RuntimeException $e) {
            return $e;
        }

    }
}

if (! function_exists('regulatoryDocType')) {
    function regulatoryDocType(){
        
        try {
            return DocumentType::all();
        } catch(\RuntimeException $e) {
            return $e;
        }

    }
}

if(!function_exists('issuetypeList'))
{
     function issuetypeList(){
               try{
                    return IssueType::issuetype_list();
               } catch(\RuntimeException $e)
               {
                   return $e;
               }
        }

}
if(!function_exists('roletypeList'))
{
     function roletypeList(){
               try{
                    return Roles::roletype_list();
               } catch(\RuntimeException $e)
               {
                   return $e;
               }
        }
        
}

if(!function_exists('task_field_value_text'))
{
     function task_field_value_text($task_id,$field_code){
               try{

                if($field_code == 'risk_category'){
                      $risk_cateogry = TaskRiskCategory::join('risk_categories','risk_categories.id','=','task_risk_categories.risk_category_id')->where('task_risk_categories.task_id',$task_id)->first();

                      return isset($risk_cateogry->title)?$risk_cateogry->title:'-';
                }

                if($field_code == 'risk_subcategory'){
                    $risk_cateogry = TaskRiskCategory::join('risk_categories','risk_categories.id','=','task_risk_categories.risk_sub_category_id')->where('task_risk_categories.task_id',$task_id)->first();

                    return isset($risk_cateogry->title)?$risk_cateogry->title:'-';
                }
                
                $fieldvalue=TaskFieldValue::with('getTaskFieldType','getTaskFieldType.getFieldType')
                    ->whereHas('getTaskFieldType', function($q) use($field_code) {
                        // Query the name field in status table
                        $q->where('code', '=', $field_code); // '=' is optional
                 })
                 ->where('task_id',$task_id)
                 ->first();
                 $responseValue='';
                 if($fieldvalue)
                 {
                     $type=$fieldvalue->getTaskFieldType->getFieldType->code;
                     if(in_array($type,array('dropdown_value','radio_button')))
                    {
                        $fieldSelectedvalue=FieldDropdownValue::where('id',$fieldvalue->dropdown_value_id)->first();
                        if($fieldSelectedvalue)
                        {
                            $responseValue=$fieldSelectedvalue->dropdown_name;
                        }
                    }
                    elseif($type=='file')
                    {
                        $responseValue=$fieldvalue->text;
                    }
                    else
                    {
                        $responseValue=$fieldvalue->$type;
                    }
                 }
                 return $responseValue;
               } catch(\RuntimeException $e)
               {
                   return $e;
               }
        }
        
}

if(!function_exists('companyYear'))
{
     function companyYear(){
               try{
                    return Company::join('company_users','company_users.company_id','company.id')->where('company_users.user_id',auth()->user()->id)->select('company.*')->first();
               } catch(\RuntimeException $e)
               {
                   return $e;
               }
        }
        
}
if(!function_exists('issueRaised')){
    function issueRaised($risk_id){
        try{
           return  Dependencies::where('dependent_task_id',$risk_id)->join('tasks','tasks.id','dependencies.dependent_task_id')->where('tasks.task_type',3)->count();
        }catch(\RuntimeException $e){
            return $e;
        }
    }
}
if(!function_exists('riskOverdue')){
    function riskOverdue($risk_id){
        try{
           return  Dependencies::where('task_id',$risk_id)->join('tasks','tasks.id','dependencies.dependent_task_id')->where('tasks.task_type',1)->count();
        }catch(\RuntimeException $e){
            return $e;
        }
    }
}
if(!function_exists('riskTaskChallenge')){
    function riskTaskChallenge($risk_id){
        try{
           return  Dependencies::where('task_id',$risk_id)->join('tasks','tasks.id','dependencies.dependent_task_id')->where('tasks.task_type',1)->where('tasks.task_challenge_status',1)->count();
        }catch(\RuntimeException $e){
            return $e;
        }
    }
}

?>