<?php

namespace App\Http\Middleware;

use App\CompanyUsers;
use App\Permission;
use App\PermissionRole;
use Closure;
use App\Roles;
use App\UserRoles;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserPermissionBasedAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $r = UserRoles::where('user_id', $user->id)->first();
        if (Gate::allows('user-permission', $user)) {
            if ($r->role_id != 1 ) {
                $cmpId = CompanyUsers::where('user_id', $user->id)->first();
                $request->attributes->add(['cmpId' => $cmpId->company_id, 'cmpUsrId' => $cmpId->id]);
            }
            return $next($request);
        } else {
            return response('Unauthorized Action', 403);
        }
    }
}
