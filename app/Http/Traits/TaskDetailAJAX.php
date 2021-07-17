<?php

namespace App\Http\Traits;

use App\AppConst;
use App\Client;
use App\TaskClient;
use App\Company;
use App\TaskDepartment;
use App\TaskUsers;
use App\Departments;
use App\DepartmentMembers;
use App\FundGroups;
use App\SubFunds;
use App\TaskFundGroup;
use App\TaskMisField;
use App\TaskSubFund;
use App\TaskAttachDocumentation;
use Illuminate\Support\Facades\Route;

trait TaskDetailAJAX
{

    use EnvelopeEncryption;

    public static function task_overview_clients($task_id, $page, $count)
    {
        $offset = ($page * $count) - $count;
        $client_all = TaskClient::where('task_id', $task_id)->where('is_all', 1)->first();
        if ($client_all) {
            $t = Client::join('company_clients', AppConst::COMPANY_CLIENTS_CLIENTID, AppConst::CLIENTS_ID)->where(AppConst::COMPANY_CLEINTS_COMPANYID, $client_all->company_id)->select('clients.*');
            $clients = $t->offset($offset)->limit($count)->get();
            $deadline = $t->min('clients.deadline_priority');
            $client_ids = $t->pluck('id');
        } else {
            $t = TaskClient::where('task_id', $task_id)->join('clients', 'clients.id', '=', 'task_clients.client_id')->select('clients.*');
            $clients = $t->offset($offset)->limit($count)->get();
            $deadline =  $t->min('clients.deadline_priority');
            $client_ids = TaskClient::where('task_id', $task_id)->pluck('client_id');
        }
        return ['clients' => $clients, 'deadline' => $deadline, 'client_ids' => $client_ids];
    }

    public function task_overview_users($id, $type, $dpts, $page, $count)
    {
        $offset = ($page * $count) - $count;
        $all = TaskUsers::where('task_id', $id)->where('user_action', $type)->where('is_all', 1)->first();
        if ($all) {
            $user = DepartmentMembers::whereIn('department_members.department_id', $dpts)->join('company_users', 'company_users.id', '=', 'department_members.company_user_id')->join('users', AppConst::USERS_ID, '=', 'company_users.user_id')->select('users.*', 'company_users.id as company_user_id')->distinct(AppConst::USERS_ID)->offset($offset)->limit($count)->get();
        } else {
            $user = TaskUsers::where('task_id', $id)->where('user_action', $type)->join('company_users', 'company_users.id', '=', 'task_users.company_user_id')->join('users', AppConst::USERS_ID, '=', 'company_users.user_id')->offset($offset)->limit($count)->get();
        }
        if (Route::currentRouteName() == 'task_detail_assigned') {
            $key = self::decryptDataKey();
            foreach ($user as $item) {
                $item->name = self::DecryptedData($item->name, $key);
            }
        }
        return $user;
    }

    public function task_overview_funds($id, $clients, $page, $count)
    {
        $offset = ($page * $count) - $count;
        $all = TaskFundGroup::where('task_id', $id)->where('is_all', 1)->first();
        if ($all) {
            $t = FundGroups::join('company_fund_groups', 'company_fund_groups.fund_group_id', AppConst::FUND_GROUPS_ID)->join('client_fund_groups', 'client_fund_groups.company_fund_group_id', 'company_fund_groups.id')->whereIn('client_fund_groups.client_id', $clients);
            $funds = $t->select('fund_groups.*')->distinct(AppConst::FUND_GROUPS_ID)->offset($offset)->limit($count)->get();
            $fund_ids = $t->pluck(AppConst::FUND_GROUPS_ID);
        } else {
            $funds = TaskFundGroup::where('task_fund_groups.task_id', $id)->join('fund_groups', AppConst::FUND_GROUPS_ID, '=', 'task_fund_groups.fund_group_id')->select('fund_groups.*')->offset($offset)->limit($count)->get();
            $fund_ids = TaskFundGroup::where('task_id', $id)->pluck('fund_group_id');
        }
        return ['funds' => $funds, 'fund_ids' => $fund_ids];
    }

    public function task_overview_subfunds($id, $funds, $page, $count)
    {
        $offset = ($page * $count) - $count;
        $all = TaskSubFund::where('task_id', $id)->where('is_all', 1)->first();
        if ($all) {
            $subfunds = SubFunds::join('fund_groups', AppConst::FUND_GROUPS_ID, '=', 'sub_funds.fund_group_id')->whereIn('sub_funds.fund_group_id', $funds)->offset($offset)->limit($count)->get();
        } else {
            $subfunds = TaskSubFund::where('task_id', $id)->join('sub_funds', 'sub_funds.id', 'task_sub_funds.sub_funds_id')->offset($offset)->limit($count)->get();
        }
        return $subfunds;
    }

    public function task_overview_departments($id, $cmpId, $page, $count)
    {
        $offset = ($page * $count) - $count;
        $all = TaskDepartment::where('task_id', $id)->where('is_all', 1)->first();
        if ($all) {
            $data = Departments::join('company_departments', 'company_departments.department_id', AppConst::DEPARTMENTS_ID)->join('client_departments', 'client_departments.company_department_id', 'company_departments.id')->whereIn('client_departments.client_id', $cmpId)->offset($offset)->limit($count)->get();
            $data_ids = Departments::pluck('id');
        } else {
            $data = TaskDepartment::where('task_id', $id)->join('departments', AppConst::DEPARTMENTS_ID, '=', 'task_departments.department_id')->distinct(AppConst::DEPARTMENTS_ID)->offset($offset)->limit($count)->get();
            $data_ids = TaskDepartment::where('task_id', $id)->distinct(AppConst::DEPARTMENTS_ID)->pluck('id');
        }
        return ['departments' => $data, 'department_ids' => $data_ids];
    }

    public function task_mis($id)
    {
        return TaskMisField::with('mis_field_contents')->where('task_id', $id)->get();
    }

    public function task_status_one($completion_status, $due_date, $deadline, $challenge = null)
    {
        $stat = collect(['task_status' => '', 'status_background' => '']);
        $fr = task_field_value_text(request()->id, 'frequency');
        if ($completion_status == 1) {
            if ($challenge == 1) {
                $stat['status_background'] = 'overdue-bg-status';
                $stat['task_status'] = "Completed with Challenge";
            } else {
                $stat['status_background'] = "complete-bg-status";
                $stat['task_status'] = 'Completed';
            }
        }
        if ($completion_status == 2) {
            $stat['task_status'] = 'Awaiting Approval';
            $stat['status_background'] = 'awaiting-bg-status';
        }
        if ($completion_status == 0) {
            if ($due_date < date("Y-m-d H:i:s")) {
                $stat['task_status'] = 'Overdue';
                $stat['status_background'] = 'overdue-bg-status';
            } else {
                if ($fr == "Ad Hoc" || $fr == "Daily") {
                    $stat['task_status'] = 'On Track';
                    $stat['status_background'] = 'ontrack-bg-status';
                }
                if ($fr == "Weekly") {
                    if (date("Y-m-d H:i:s", strtotime($due_date . " -1 days")) > date("Y-m-d H:i:s")) {
                        $stat['task_status'] = 'On Track';
                        $stat['status_background'] = 'ontrack-bg-status';
                    } else {
                        $stat['task_status'] = 'Urgent';
                        $stat['status_background'] = 'urgent-bg-status';
                    }
                }
                if ($fr == "Monthly" || $fr == "Quarterly") {
                    if (date("Y-m-d H:i:s", strtotime($due_date . " -3 days")) > date("Y-m-d H:i:s")) {
                        $stat['task_status'] = 'On Track';
                        $stat['status_background'] = 'ontrack-bg-status';
                    } else {
                        $stat['task_status'] = 'Urgent';
                        $stat['status_background'] = 'urgent-bg-status';
                    }
                }
                if ($fr == "Annually") {
                    if (date("Y-m-d H:i:s", strtotime($due_date . " -14 days")) > date("Y-m-d H:i:s")) {
                        $stat['task_status'] = 'On Track';
                        $stat['status_background'] = 'ontrack-bg-status';
                    } else {
                        $stat['task_status'] = 'Urgent';
                        $stat['status_background'] = 'urgent-bg-status';
                    }
                }
            }
        }
        // if ($completion_status == 1) {
        //     $stat['task_status'] = 'Completed';
        //     if($challenge == 0){
        //         $stat['status_background'] = 'complete-bg-status';
        //     }
        //     if($challenge == 1){
        //         $stat['status_background'] = 'overdue-bg-status';
        //         $stat['task_status'] .= ' with Challenge';
        //     }
        // } elseif ($completion_status == 2) {
        //     $stat['task_status'] = 'Awaiting Approval';
        //     $stat['status_background'] = 'awaiting-bg-status';
        // } else {
        //     if ($due_date > date(AppConst::DATEFORMATS, strtotime('+' . $deadline . 'days'))) {
        //         $stat['task_status'] = 'On Track';
        //         $stat['status_background'] = 'ontrack-bg-status';
        //     }
        //     if ( date(AppConst::DATEFORMATS, strtotime($due_date)) <= date(AppConst::DATEFORMATS, strtotime('+' . $deadline . 'days')) && date(AppConst::DATEFORMATS) <= date(AppConst::DATEFORMATS, strtotime($due_date))) {
        //         $stat['task_status'] = 'Urgent';
        //         $stat['status_background'] = 'urgent-bg-status';
        //     }
        //     if ($due_date < date(AppConst::DATEFORMATS)) {
        //         $stat['task_status'] = 'Overdue';
        //         $stat['status_background'] = 'overdue-bg-status';
        //     }
        // }
        return $stat;
    }

    public function attached_docs($task_id)
    {
        $attached_docs = TaskAttachDocumentation::where('task_id', $task_id)->pluck('file_path');
        foreach ($attached_docs as $key => $item) {
            $attached_docs[$key] = explode('/', $item)[1];
        }
        return $attached_docs;
    }
}