<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubFundsKeyContact extends Model
{
    protected $table = "sub_funds_keycontacts";
    protected $fillable = [
        'sub_funds_id', 'name','email','phone_number'
    ];
}
