<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportTag extends Model
{
    protected $table = "report_tags";
    protected $fillable = [
        'tag_id','report_id','company_id','tagtype_id'
    ];
}
