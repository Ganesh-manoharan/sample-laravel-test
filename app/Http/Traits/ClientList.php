<?php

namespace App\Http\Traits;

use App\Company;
use App\Departments;

trait ClientList
{

    public static function client_list_with_data($paginate = null, $search = null)
    {
        if(!is_null($search)){
            $clientlist = Company::with('company_departments', 'company_fundgroups_count', 'company_sub_funds_count')->where('status', 1)->select('client_name', 'id', 'description', 'company_logo')->where('client_name', 'like', "%".strtoupper($search)."%");
            $clientlist = $clientlist->paginate($paginate);
        }
        else
        {
            $clientlist =Company::with('company_departments', 'company_fundgroups_count', 'company_sub_funds_count')->select('client_name', 'id', 'description', 'company_logo')->where('status', 1)->orderBy('company.id','DESC')->paginate($paginate);
        }
     
        return $clientlist;
    }
}
