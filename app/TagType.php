<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagType extends Model
{
    protected $table = 'tag_types';
    protected $fillable = [
        'name'
    ];
}
