<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentsHistory extends Model
{
    protected $table = "documents_history";
    protected $fillable = [
        'document_id','document_name','description','document_path', 'document_thumbnail', 'document_type_id','company_id','created_by','created_at','updated_at'
    ];
}
