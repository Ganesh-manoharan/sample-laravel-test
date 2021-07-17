<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientUser extends Model
{
    protected $table = "client_users";
    protected $fillable = [
        'company_user_id','client_id','active_status'
    ];
}
