<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundsKeyContact extends Model
{
    protected $table = 'funds_keycontacts';
    protected $fillable = [
        'fund_group_id','keycontact_id','name','email','phone_number'
    ];

    public function getFundGroup()
    {
        return $this->hasOne('App\FundGroups','id','fund_group_id');
    }
}
