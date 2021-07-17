<?php

namespace App\Http\Traits;

use App\User;
use App\AppConst;
use App\DataKey;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait SendTwoFactorEmail
{
    use EnvelopeEncryption;

    public function sendTwoFactorEmail($user)
    {
        Log::info($user);
        try {
            $key = self::decryptDataKey();
            $token = mt_rand(100000, 999999);
            $email = self::DecryptedData($user->email, $key);
            $name = self::DecryptedData($user->name, $key);
            $url = env('DOMAIN_URL');

            Mail::send('auth.email.twofactor', ['token' => $token, 'name' => $name, 'url' => $url], function ($message) use ($email) {
                $message->to($email);
                $message->sender(env('MAIL_SENDER_NAME'));
                $message->subject('Verify OTP');
            });
            User::where('id', $user->id)->update(['token_2fa' => $token, 'token_2fa_status' => 0]);
            return redirect('two_factor')->with(AppConst::STATUS, 'OTP Sent To Your Registered Email!');
        } catch (\Exception $e) {
            Auth::logout();
            return redirect('login')->with(AppConst::STATUS, 'Something went wrong..!');
        }
    }

}