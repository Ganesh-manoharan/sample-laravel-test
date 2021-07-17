<?php

namespace App\Policies;

use App\UserRoles;
use App\PermissionRole;
use Illuminate\Support\Facades\Route;
use App\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPermissionPolicy
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
    public static function userpermissions($user)
    {
        $user_role = UserRoles::where('user_id',$user->id)->first();
        $permissions = PermissionRole::where('role_id',$user_role->role_id)->get();
        // get requested action
        $actionName = class_basename(Route::current()->getActionName());
        // check if requested action is in permissions list
        foreach ($permissions as $item) {
            $permission = Permission::where('id',$item->permission_id)->first();
            if ($actionName == $permission->controller . '@' . $permission->method) {
                // authorized request
                return true;
            }
        }
        // none authorized request
        return false;
    }
}
