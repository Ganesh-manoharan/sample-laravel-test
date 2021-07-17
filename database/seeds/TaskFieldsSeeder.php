<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('task_fields')->truncate();
        $current_datetime=now();
        $data=array(
            array('field_type_id'=>4,'label'=>null,'code'=>'date_issue_identified','placeholder'=>'Select Date','description'=>'Issue identified date','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>4,'label'=>null,'code'=>'date_issue_occurance','placeholder'=>'Select Date','description'=>'Issue occured date','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>4,'label'=>null,'code'=>'date_issue_resolution','placeholder'=>'Select Date(Optional)','description'=>'Issue resolution date','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>3,'label'=>null,'code'=>'root_cause','placeholder'=>'Max 400 characters','description'=>'Description of the Root Cause','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>3,'label'=>null,'code'=>'furthr_detail','placeholder'=>'Max 400 characters','description'=>'Description of the Further Detail','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>8,'label'=>null,'code'=>'attachments_text','placeholder'=>'Attachment Instructions','description'=>'Description of the Attachment Instruction','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>null,'code'=>'financial_impact','placeholder'=>'Select','description'=>'Description of the Financial Impact','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>null,'code'=>'impact_rating','placeholder'=>'Select','description'=>'Description of the Impact rating','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>null,'code'=>'risk_register_impact','placeholder'=>'Select','description'=>'Description of the Risk register Impact','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>2,'label'=>null,'code'=>'financial_impact_value','placeholder'=>'Enter Value','description'=>'Description of the Financial Impact value','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>2,'label'=>null,'code'=>'financial_impact_resolution','placeholder'=>'Enter Value','description'=>'Description of the Financial Impact Resolution','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>6,'label'=>null,'code'=>'responsible_party','placeholder'=>null,'description'=>'Description of the Responsible Party','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>3,'label'=>null,'code'=>'external_description','placeholder'=>'Max 400 characters','description'=>null,'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>6,'label'=>'Additional Attachments','code'=>'additional_attachment_requirement','placeholder'=>null,'description'=>'Description of the Attach Documentation','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>3,'label'=>'','code'=>'add_attach_comments','placeholder'=>'Add comment here','description'=>'Instruction for the Attaching Documentation when completing this task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>'Risk Velocity','code'=>'risk_velocity','placeholder'=>'Enter risk velocity','description'=>'Risk velocity description','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>1,'label'=>'Risk Value','code'=>'risk_value','placeholder'=>'Enter risk value','description'=>'Risk value description','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>'Risk Response','code'=>'risk_response','placeholder'=>'Select','description'=>'Risk response description','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>'Impact  Rating','code'=>'impact__rating','placeholder'=>'Select','description'=>'Impact rating description','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>'Inherent Risk','code'=>'inherent_risk','placeholder'=>'Select','description'=>'Inherent Risk description','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>'Probability','code'=>'probability','placeholder'=>'Select','description'=>'Probability description','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>'Mitigation Effectiveness','code'=>'mitigation_effectiveness','placeholder'=>'Select','description'=>'Mitigation Effectiveness description','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>'Current Risk Score','code'=>'current_risk_score','placeholder'=>'Select','description'=>'Current Risk Score description','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>2,'label'=>null,'code'=>'entity','placeholder'=>'Enter here','description'=>'Entity description','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>4,'label'=>null,'code'=>'due_date','placeholder'=>'Task Due Date','description'=>'Due date for completing the task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>null,'code'=>'frequency','placeholder'=>null,'description'=>'Frequency to schedule the task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>7,'label'=>null,'code'=>'clients','placeholder'=>'Choose Clients','description'=>'Choose the clients for the task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>7,'label'=>null,'code'=>'fund_groups','placeholder'=>'Choose Fund Groups','description'=>'Choose the fund groups for the task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>7,'label'=>null,'code'=>'sub_fund_groups','placeholder'=>'Choose Sub Fund','description'=>'Choose the sub funds for the task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>7,'label'=>null,'code'=>'dependencies','placeholder'=>'Choose Dependency','description'=>'Choose dependency task for the task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>7,'label'=>null,'code'=>'departments','placeholder'=>'Choose Departments','description'=>'Choose the departments for the task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>7,'label'=>null,'code'=>'assignees','placeholder'=>'Choose Users','description'=>'Choose the assignees for the task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>7,'label'=>null,'code'=>'reviewers','placeholder'=>'Choose Review Users','description'=>'Choose the review users for the task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>'Attach Documentation','code'=>'attach_documentation','placeholder'=>null,'description'=>'Filter the regulated documents','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>2,'label'=>null,'code'=>'keyword_search','placeholder'=>'Keyword Search','description'=>'Search the documents by keywords','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>2,'label'=>null,'code'=>'task_name','placeholder'=>'Task Name','description'=>'','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>3,'label'=>null,'code'=>'task_description','placeholder'=>'Task Description','description'=>'','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>2,'label'=>'Risk Name','code'=>'risk_name','placeholder'=>'Risk Name','description'=>'','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>2,'label'=>'Risk ID','code'=>'risk_id','placeholder'=>'Risk Id','description'=>'','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>3,'label'=>'Risk Description','code'=>'risk_description','placeholder'=>'Risk Description','description'=>'','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>'Risk Category','code'=>'risk_category','placeholder'=>'Risk Category','description'=>'','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>'Risk Sub-Category','code'=>'risk_subcategory','placeholder'=>'Risk sub-category','description'=>'','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>null,'code'=>'risk_trend','placeholder'=>'Risk trend','description'=>'','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>2,'label'=>null,'code'=>'issue_name','placeholder'=>'Issue Name','description'=>'','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>3,'label'=>null,'code'=>'issue_description','placeholder'=>'Issue Description','description'=>null,'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>5,'label'=>null,'code'=>'issue_type','placeholder'=>'Issue Type','description'=>'','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>7,'label'=>null,'code'=>'associate_activity','placeholder'=>'Issue Type','description'=>'','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('field_type_id'=>3,'label'=>null,'code'=>'responsible_party_comments','placeholder'=>'Max 400 characters','description'=>'','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            
        );
            DB::table('task_fields')->insert($data);
        DB::statement("SET foreign_key_checks=1");
    }
}
