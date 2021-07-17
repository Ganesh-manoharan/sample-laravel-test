<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
   

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8|pwned',
        ];
    }
    public function reset(Request $request)
    {

        $password = $request->password;

        $tokenData = DB::table('password_resets')->where('token', $request->token)->first();

        if(!$tokenData){
            return redirect()->back()->withErrors(['email' => ['This password reset token is invalid.']]);
        }

        $user = User::where('email_hash', $tokenData->email)->first();
        if(!$user){
            return redirect()->back()->withErrors(['email' => ["We can't find a user with that email address."]]);
        }

        $user->password = Hash::make($password);
        $user->update();

        Auth::login($user);

        DB::table('password_resets')->where('email', $user->email_hash)->delete();

        // if (Gate::allows('admin-only', $user)) {
        //     $response = redirect()->route('home');
        // } else if (Gate::allows('manager-only', $user)) {
        //     $response = redirect()->route('home');
        // } else {
        //     $response = redirect()->route('home');
        // }
        return redirect()->route('home');
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
