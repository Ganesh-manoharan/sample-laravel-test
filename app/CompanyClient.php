<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyClient extends Model
{
    protected $table = "company_clients";

    protected $fillable = [
        'company_id', 'client_id','active_status'
    ];

    public static function addCom_client($cmp, $cli)
    {
        $c = CompanyClient::create([
            'company_id' => $cmp,
            "client_id" => $cli
        ]);
        return $c->id;
    }
}
