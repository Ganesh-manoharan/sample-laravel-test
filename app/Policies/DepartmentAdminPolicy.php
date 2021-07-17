<?php

namespace App\Policies;

use App\DepartmentMembers;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentAdminPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public static function departmentAdmin($user)
    {
        $da = DepartmentMembers::where('company_user_id',$user->getCompanyID->id)->where('is_manager',1)->first();
        if($da){
            return true;
        }
        return false;
    }
}
