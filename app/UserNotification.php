<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CommonFunction;

class UserNotification extends Model
{
    use CommonFunction;

    public static function notifications()
    {
        return CommonFunction::notificationlist();
    }
}
