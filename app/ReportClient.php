<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportClient extends Model
{
    protected $table = "report_clients";
    protected $fillable = [
        'client_id','report_id'
    ];
}
