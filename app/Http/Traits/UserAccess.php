<?php

namespace App\Http\Traits;

use App\UserRoles;
use App\CompanyUsers;
use App\AppConst;

trait UserAccess
{
    public static function department_restriction($data)
    {
        $cmp = CompanyUsers::where('user_id', auth()->user()->id)->first();

        return $data->join('company_departments', AppConst::CMP_DEP_ID, AppConst::DEPARTMENTS_ID)->where(AppConst::CMP_DEP_CMPID, $cmp->company_id)->join('department_members', 'department_members.department_id', AppConst::DEPARTMENTS_ID)->where('department_members.company_user_id', $cmp->id);
    }

    public static function task_access($data)
    {
        $cmp = CompanyUsers::where('user_id', auth()->user()->id)->first();
        
        return $data->join('task_departments', 'task_departments.task_id', '=', 'tasks.id')->join('company_departments', AppConst::CMP_DEP_ID, 'task_departments.department_id')->join('department_members', 'department_members.department_id', 'task_departments.department_id')->where('department_members.company_user_id', $cmp->id)->where(function ($q) use ($cmp) {
            $q->where(AppConst::CMP_DEP_CMPID, $cmp->company_id);
        })->distinct('tasks.id');        
    }

    public static function client_access($data)
    {
        $cmp = CompanyUsers::where('user_id', auth()->user()->id)->first();
        
            return  $data->leftjoin('client_departments','client_departments.client_id','clients.id')->join('company_departments', AppConst::CMP_DEP_ID, 'client_departments.company_department_id')->where(AppConst::CMP_DEP_CMPID, $cmp->company_id)->leftjoin('department_members', 'department_members.department_id', 'company_departments.department_id')->where(function ($q) use ($cmp) {
                $q->where('department_members.company_user_id', $cmp->id);
                $q->where('clients.created_by',$cmp->id);
            })->distinct('clients.id');
    }

    public static function user_list($data)
    {
        $cmp = CompanyUsers::where('user_id', auth()->user()->id)->first();

        return $data->join('company_users', 'company_users.user_id', 'users.id')->where('company_users.company_id', $cmp->company_id)->whereNull('company_users.deleted_at');
    }

    public function report_list($data)
    {
        $r = UserRoles::where('user_id',auth()->user()->id)->select('role_id')->first();
        $cmp = CompanyUsers::where('user_id',auth()->user()->id)->first();
        return $data;
    }

    public  static function task_riskCategory($data)
    {
        return $data->with('getRiskCategory','getChildCategory');
    }
}
