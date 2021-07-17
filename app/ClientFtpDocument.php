<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientFtpDocument extends Model
{
    protected $table = 'client_ftp_documents';
    protected $fillable = ['document_name','client_id','document_path'];
}
