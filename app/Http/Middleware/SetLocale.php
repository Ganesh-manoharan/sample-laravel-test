<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class SetLocale
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
        if($request->language){
            app()->setLocale($request->language);
           return $next($request)->withCookie(cookie('locale', $request->language, 500000));
        }
        app()->setLocale($request->cookie('locale'));
        return $next($request)->withCookie(cookie('locale', $request->cookie('locale'), 500000));
    }
}
