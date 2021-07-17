<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\User;
use App\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Http\Traits\EnvelopeEncryption;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    use EnvelopeEncryption;
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        //Create Password Reset Token
        PasswordReset::insert([
            'email' => hash('sha256', $request->email),
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);

        //Get the token just created above
        $tokenData = PasswordReset::where('email', hash('sha256', $request->email))->first();

        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            return redirect()->back()->with('status', trans('A reset link has been sent to your email.'));
        } else {
          
            return redirect()->back()->with(['error' => trans('Email Does not Exist.')]);
        }
    }
    private function sendResetEmail($email, $token)
    {
        
        //Retrieve the user from the database
        $user = User::where('email_hash',  hash('sha256', $email))->select('name', 'email')->first();

        
       
        if(isset($user->email))
        {
        $key = $this->decryptDataKey();
        $decrypted_email = $this->DecryptedData($user->email, $key);
        $decrypted_name = $this->DecryptedData($user->name, $key);

        //Generate, the password reset link. The token generated is embedded in the link
        $token_link = config('base_url') . $token . '?email=' . urlencode($decrypted_email);

        try {
            $data = array('token' => $token_link, 'nameofuser' => $decrypted_name);
            Mail::send('email-template', $data, function($message) use ($decrypted_email) {
                $message->to($decrypted_email)->subject('Reset Password');
                $message->sender(env('MAIL_FROM_ADDRESS'));
                });
            return true;
        } catch (\Exception $e) {

            Log::info("Locked user attempt for Reset" . $e);
            return false;
        }
        }
        else
        {
            return false;
            
            
        }

    }
}
