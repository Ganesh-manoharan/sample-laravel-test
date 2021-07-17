<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImpactRating extends Model
{
    protected $table = 'impact_ratings';
    protected $fillable = [
        'name'
    ];
}
