<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientFundGroup extends Model
{
    protected $table = "client_fund_groups";
    protected $fillable = [
        'company_fund_group_id', 'client_id', 'active_status'
    ];

    public static function storeclientfunds($request, $id)
    {
        foreach ($request->fund_groups as $item) {
            ClientFundGroup::create([
                'company_fund_group_id' => $item,
                'client_id' => $id
            ]);
        }
    }

    public static function storeindividualfund($request, $id)
    {
        $data = ClientFundGroup::create([
            'company_fund_group_id' => $request->fundgroupsid,
            'client_id' => $id
        ]);
        return json_encode(["success" => true, $data]);
    }
}
