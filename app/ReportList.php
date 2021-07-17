<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportList extends Model
{
    protected $table = "report_list";
    protected $fillable = [
        'report_id','report_path','report_format'
    ];

    public static function saveReport($report, $storage_data)
    {
        return ReportList::create([
                    'report_id' => $report->id,
                    'report_path' => $storage_data['path'],
                    'report_format' => $storage_data['format']
               ]);
    }

}
