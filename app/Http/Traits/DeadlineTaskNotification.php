<?php

namespace App\Http\Traits;

use App\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
//class to get the encrypted and decrypted values based on AWS KMS
trait DeadlineTaskNotification
{
    public static function notification_mail($data){
        
        try {
            $dt = array('name'=>$data->name,'email'=>$data->email,'tasks'=>$data->selected);
            Mail::send('task-notification', $dt, function ($message) use ($data) {
                $message->to($data->email);
                $message->sender(env('MAIL_SENDER_NAME'));
                $message->subject('Invitation Link');
            });
        } catch (\Exception $e) {
            Log::info("Invitation Mail For New User" . $e);
        }
    }
}