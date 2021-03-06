<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "user_roles";
    protected $fillable = [
        'user_id', 'role_id'
    ];

  
}
