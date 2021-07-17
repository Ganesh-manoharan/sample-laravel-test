<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FtpTag extends Model
{
    protected $table = 'ftp_tags';
    protected $fillable = [
        'ftp_tag_id','task_id','company_id'
    ];
}
