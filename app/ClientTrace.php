<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientTrace extends Model
{
    protected $fillable = [
        'client_id',
        'modified_by',
        'action',
        'modified_columns'
    ];
}
