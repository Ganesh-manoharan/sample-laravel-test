<?php

use App\TaskFormFieldGroup;
use App\TaskType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskFormFieldGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    DB::statement("SET foreign_key_checks=0");
        TaskFormFieldGroup::truncate();
        $taskFormFieldGroupDetails=array(
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),
                'group_title'=>'Task Description',
                'group_slug'=>'task_description',
                'sort_order'=>1,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),
                'group_title'=>'Task Timing & Frequency',
                'group_slug'=>'task_timing',
                'sort_order'=>2,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),
                'group_title'=>'Clients',
                'group_slug'=>'clients',
                'sort_order'=>3,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),
                'group_title'=>'Dependencies',
                'group_slug'=>'dependencies',
                'sort_order'=>4,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),
                'group_title'=>'Assigned To',
                'group_slug'=>'assignedto',
                'sort_order'=>5,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),
                'group_title'=>'Attach Documentation',
                'group_slug'=>'attach_documentation',
                'sort_order'=>6,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('task'),
                'group_title'=>'MIS',
                'group_slug'=>'mis',
                'sort_order'=>7,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),
                'group_title'=>'Risk Description',
                'group_slug'=>'risk_description',
                'sort_order'=>1,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),
                'group_title'=>'Risk Qualification',
                'group_slug'=>'risk_qualification',
                'sort_order'=>2,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),
                'group_title'=>'Associated Activity',
                'group_slug'=>'associated_activity',
                'sort_order'=>3,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),
                'group_title'=>'Associated Activitied',
                'group_slug'=>'risk_asscociate_activities',
                'sort_order'=>4,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),
                'group_title'=>'Assigned To',
                'group_slug'=>'risk_assignedto',
                'sort_order'=>5,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),
                'group_title'=>'Risk Commentary',
                'group_slug'=>'risk_comments',
                'sort_order'=>6,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('risk'),
                'group_title'=>'Risk Trend',
                'group_slug'=>'risk_trend',
                'sort_order'=>7,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Issue Description',
                'group_slug'=>'issue_description',
                'sort_order'=>1,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Issue Type',
                'group_slug'=>'issue_type',
                'sort_order'=>2,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Clients',
                'group_slug'=>'issue_clients',
                'sort_order'=>3,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Assigned To',
                'group_slug'=>'issue_assignedto',
                'sort_order'=>4,
                'step_wizard'=>'one'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Responsible Party',
                'group_slug'=>'issue_responsible_party',
                'sort_order'=>5,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Date Issue Identified',
                'group_slug'=>'issue_date_issue_identified',
                'sort_order'=>6,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Date issue Occured',
                'group_slug'=>'issue_date_issue_occured',
                'sort_order'=>7,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Date issue Resolution(Optional)',
                'group_slug'=>'issue_date_issue_resolution',
                'sort_order'=>8,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Root cause',
                'group_slug'=>'root_cause',
                'sort_order'=>9,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Further Detail',
                'group_slug'=>'future_details',
                'sort_order'=>10,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Attachment Details (Optional)',
                'group_slug'=>'attachement_details',
                'sort_order'=>12,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Financial Impact',
                'group_slug'=>'financial_impact',
                'sort_order'=>13,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Impact Rating',
                'group_slug'=>'impact_rating',
                'sort_order'=>14,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Risk Register Impact',
                'group_slug'=>'risk_register_impack',
                'sort_order'=>15,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Financial Impact - Monetary Value',
                'group_slug'=>'financial_impact_value',
                'sort_order'=>16,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Please Provide Detail On The Monetary Value Resolution',
                'group_slug'=>'financial_impact_resolution',
                'sort_order'=>17,
                'step_wizard'=>'two'
            ],
            [
                'task_type_id'=>TaskType::getTaskTypeIDbyCode('issue'),
                'group_title'=>'Hide',
                'group_slug'=>'issue_hide',
                'sort_order'=>17,
                'step_wizard'=>'two'
            ]
        );
        TaskFormFieldGroup::insert($taskFormFieldGroupDetails);
	DB::statement("SET foreign_key_checks=1");
    }
}
