<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentMembers extends Model
{
    use SoftDeletes;
    protected $table = "department_members";
    protected $fillable = [
        'company_user_id', 'department_id', 'is_manager', 'active_status'
    ];

    public static function save_department_members($users, $dep_id, $is_manager)
    {
        foreach ($users as $user) {
            $ex = DepartmentMembers::where('department_id', $dep_id)->where('company_user_id', $user)->first();
            if ($ex) {
                $ex->update(['active_status' => 1, 'is_manager' => $is_manager]);
            } else {
                DepartmentMembers::create([
                    'company_user_id' => $user,
                    'department_id' => $dep_id,
                    'is_manager' => $is_manager
                ]);
            }
        }
    }

    public static function remove_members($d, $dep_id)
    {
        DepartmentMembers::whereIn('id', $d)->update(['active_status' => 0]);
    }

    public function getDepartment()
    {
        return $this->hasOne('App\Departments','id','department_id');
    }
}
