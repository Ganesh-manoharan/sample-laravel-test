<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table='permission';
    protected $fillable = [
        'key',
        'controller',
        'method',
        'description'
    ];
}
