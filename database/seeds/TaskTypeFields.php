<?php

use App\TaskField;
use App\TaskFormFieldGroup;
use App\TaskType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskTypeFields extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('task_type_fields')->truncate();
        $current_datetime=now();
        $data=array(
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('date_issue_identified'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>1,'sort_order'=>10,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_date_issue_identified'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('date_issue_occurance'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>1,'sort_order'=>11,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_date_issue_occured'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('date_issue_resolution'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>12,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_date_issue_resolution'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('root_cause'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>13,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('root_cause'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('furthr_detail'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>14,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('future_details'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('attachments_text'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>15,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('attachement_details'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('financial_impact'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>16,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('financial_impact'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('impact_rating'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>1,'sort_order'=>17,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('impact_rating'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('risk_register_impact'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>18,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_register_impack'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('financial_impact_value'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>20,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('financial_impact_resolution'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('financial_impact_resolution'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>19,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('financial_impact_value'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('responsible_party'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>9,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_responsible_party'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('external_description'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>99,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_hide'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('additional_attachment_requirement'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>0,'sort_order'=>14,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('attach_documentation'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('add_attach_comments'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>0,'sort_order'=>15,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('attach_documentation'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('risk_velocity'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>6,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_qualification'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('risk_value'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>7,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_qualification'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('risk_response'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>8,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_qualification'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('impact__rating'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>9,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_qualification'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('inherent_risk'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>11,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_qualification'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('probability'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>10,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_qualification'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('mitigation_effectiveness'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>12,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_qualification'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('current_risk_score'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>13,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_qualification'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('entity'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>99,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_hide'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('due_date'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>1,'sort_order'=>3,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('task_timing'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('frequency'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>0,'sort_order'=>4,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('task_timing'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('clients'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>1,'sort_order'=>5,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('clients'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('fund_groups'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>1,'sort_order'=>6,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('clients'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('sub_fund_groups'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>1,'sort_order'=>7,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('clients'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('dependencies'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>0,'sort_order'=>8,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('dependencies'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('departments'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>1,'sort_order'=>9,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('assignedto'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('assignees'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>1,'sort_order'=>10,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('assignedto'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('reviewers'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>0,'sort_order'=>11,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('assignedto'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('attach_documentation'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>0,'sort_order'=>12,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('attach_documentation'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('keyword_search'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>0,'sort_order'=>13,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('attach_documentation'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('task_name'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>1,'sort_order'=>1,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('task_description'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('task_description'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),'is_requried'=>1,'sort_order'=>2,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('task_description'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('risk_name'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>1,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_description'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('risk_id'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>2,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_description'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('risk_description'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>3,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_description'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('risk_category'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>4,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_description'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('risk_subcategory'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>0,'sort_order'=>5,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_description'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('departments'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>14,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_assignedto'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('assignees'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>0,'sort_order'=>15,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_assignedto'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('add_attach_comments'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>16,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_comments'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('risk_trend'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>1,'sort_order'=>17,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('risk_trend'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('issue_name'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>1,'sort_order'=>1,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_description'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('issue_description'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>1,'sort_order'=>2,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_description'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('issue_type'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>1,'sort_order'=>3,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_type'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('clients'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>1,'sort_order'=>4,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_clients'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('fund_groups'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>1,'sort_order'=>5,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_clients'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('sub_fund_groups'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>1,'sort_order'=>6,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_clients'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('departments'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>1,'sort_order'=>7,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_assignedto'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('reviewers'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>8,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_assignedto'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('associate_activity'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),'is_requried'=>0,'sort_order'=>8,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('associated_activity'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>TaskField::getTaskFieldIDbyCode('responsible_party_comments'),'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),'is_requried'=>0,'sort_order'=>10,'task_form_field_group_id'=>TaskFormFieldGroup::getgroupIDBySlug('issue_responsible_party'),'created_at'=>$current_datetime,'updated_at' => $current_datetime),
         
         );
            DB::table('task_type_fields')->insert($data);
        DB::statement("SET foreign_key_checks=1");
    }
}
