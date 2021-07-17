<?php

namespace App\Http\Controllers\Auth;

use App\AppConst;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\SendTwoFactorEmail;
use App\User;
use App\UserRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, SendTwoFactorEmail;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $redirectTo = 'home';

    protected $maxAttempts = 3;
    protected $decayMinutes = 2;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (Auth::attempt(['email_hash' => hash('sha256', $request->get('email')), AppConst::PASSWORD => $request->get(AppConst::PASSWORD)], $request->get('remember'))) {
            return $this->sendLoginResponse($request);
        }
        
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function authenticated(Request $request, $user)
    {
       // if ($request->cookie('2fa')) {
            $r = UserRoles::where('user_id', auth()->user()->id)->first();
            if ($r->role_id == 5) {
                return redirect()->route('ftp_documents_index');
            }
            if ($r->role_id == 1) {
                return redirect()->route('admin_home');
            }

            return redirect()->route('home');
       // } else {
       //     $redirect = $this->sendTwoFactorEmail($user);
       // }
       // return $redirect;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::forget('locale');
        return redirect()->route('landing');

    }
}
