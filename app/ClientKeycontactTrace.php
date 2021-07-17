<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientKeycontactTrace extends Model
{
    protected $fillable = [
        'client_id',
        'client_keycontacts_id',
        'modified_by',
        'action',
        'modified_columns'
    ];
}
