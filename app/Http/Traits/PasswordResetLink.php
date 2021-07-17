<?php

namespace App\Http\Traits;

use App\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
//class to get the encrypted and decrypted values based on AWS KMS
trait PasswordResetLink
{
    public static function reset_mail_sent($request){
        PasswordReset::insert([
            'email' => hash('sha256', $request->email),
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);
        
        $tokenData = PasswordReset::where('email', hash('sha256', $request->email))->first();

        $token_link = env('DOMAIN_URL') . '/password/reset/' . $tokenData->token . '?email=' . urlencode($request->email);
        try {
            $data = array('token' => $token_link, 'nameofuser' => $request->name,'keyword'=>"newuser");
            Mail::send('email-template', $data, function ($message) use ($request) {
                $message->to($request->email);
                $message->sender(env('MAIL_SENDER_NAME'));
                $message->subject('Invitation Link');
            });
        } catch (\Exception $e) {
            Log::info("Invitation Mail For New User" . $e);
        }
    }
}