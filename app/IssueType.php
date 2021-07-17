<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IssueType extends Model
{
    protected $table="issues_types";
    protected $fillable = [
        'issue_types'
    ];

    public static function issuetype_list()
    {
        return IssueType::all();
    }
}
