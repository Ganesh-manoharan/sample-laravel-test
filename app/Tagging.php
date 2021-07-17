<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tagging extends Model
{
    protected $table = 'tagging';
    protected $fillable = [
        'name','code','company_id'
    ];
}
