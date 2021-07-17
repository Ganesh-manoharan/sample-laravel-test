<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundsKeyContactTrace extends Model
{
    protected $fillable = [
        'fund_groups_id',
        'funds_keycontact_id',
        'modified_by',
        'action',
        'modified_columns'
    ];
}
