<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "roles";
    protected $fillable = [
        'id', 'name'
    ];

    public static function roletype_list()
    {
        return Roles::whereIn('name',['System Admin','Basic User','Review User'])->get();
    }

    public static function getRoleByName($roleName)
    {
        return Roles::where('name',$roleName)->pluck('id')->first();
    }
}
