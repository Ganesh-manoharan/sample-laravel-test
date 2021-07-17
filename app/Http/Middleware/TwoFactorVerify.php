<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\SendTwoFactorEmail;

class TwoFactorVerify
{
    use SendTwoFactorEmail;
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
        if($user->token_2fa_status == 1)
        {
            return $next($request); 
        }
        
        return $this->sendTwoFactorEmail($user);      
    }
}