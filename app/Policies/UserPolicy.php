<?php

namespace App\Policies;

use App\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
    public static function user($user)
    {
        $user_role = UserRoles::where('user_id', $user->id)->first();
        if ($user_role->role_id == 3) {
            return true;
        }
        return false;
    }
}
