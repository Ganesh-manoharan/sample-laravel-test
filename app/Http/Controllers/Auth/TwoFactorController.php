<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserRoles;

class TwoFactorController extends Controller
{
    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            '2fa' => 'required',
        ]);

        if($request->input('2fa') == Auth::user()->token_2fa){
            $user = Auth::user();
            $r = UserRoles::where('user_id', auth()->user()->id)->first();
            User::where('id', $user->id)->update(['token_2fa_status'=> 1,'token_2fa'=>null]);
            if ($r->role_id == 5) {
                return redirect()->route('ftp_documents_index')->cookie('2fa', 'nexus',43200);
            }
            if ($r->role_id == 1) {
                return redirect()->route('admin_home')->cookie('2fa', 'nexus',43200);
            }

            $redirect = redirect()->route('home')->cookie('2fa', 'nexus',43200);   
        } else {
            $redirect = redirect('/two_factor')->with('error', 'Incorrect code.');
        }
        return $redirect;
    }

    public function showTwoFactorForm()
    {
        return view('auth.two_factor');
    }  
}
