<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = "countries";
    protected $fillable = [
        'country_name'
    ];

    public static function country_list()
    {
        return Countries::all();

    }
}
