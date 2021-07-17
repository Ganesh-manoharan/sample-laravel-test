<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientDepartment extends Model
{
    protected $table = 'client_departments';
    protected $fillable = [
        'client_id', 'company_department_id', 'active_status'
    ];

    public static function storeclientdepartment($request, $id)
    {
        foreach ($request->departments1 as $item) {
            ClientDepartment::create([
                'company_department_id' => $item,
                'client_id' => $id
            ]);
        }
    }

    public static function storeindividualdepartment($request, $id)
    {
        ClientDepartment::create([
            'company_department_id' => $request->departments,
            'client_id' => $id
        ]);

        return Departments::where('id', $request->departments)->first();
    }

    public function departments()
    {
        return $this->hasManyThrough('App\Departments', 'App\CompanyDepartment', 'department_id', 'id');
    }

    public static function client_departments($id)
    {
        return ClientDepartment::join('company_departments', 'company_departments.id', 'client_departments.company_department_id')->join('departments', 'departments.id', '=', 'company_departments.department_id')->where('client_departments.client_id', $id)->select('client_departments.id as action_id', 'company_departments.id as notIn_id', 'departments.*')->get();
    }
}
