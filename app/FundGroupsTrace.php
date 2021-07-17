<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundGroupsTrace extends Model
{
    protected $fillable = [
        'fund_groups_id',
        'modified_by',
        'action',
        'modified_columns'
    ];
}
