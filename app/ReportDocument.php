<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportDocument extends Model
{
    protected $table = "report_documents";
    protected $fillable = [
        'document_id','report_id'
    ];
}
