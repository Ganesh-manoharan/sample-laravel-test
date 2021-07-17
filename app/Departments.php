<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\EnvelopeEncryption;
use App\Http\Traits\UserAccess;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departments extends Model
{
    use SoftDeletes;
    use EnvelopeEncryption, UserAccess;

    protected $table = "departments";
    protected $fillable = [
        'dep_icon', 'name', 'status','description'
    ];
    public function department_manager()
    {
        return $this->hasOneThrough('App\CompanyUsers', 'App\DepartmentMembers', 'department_id', 'id')->join('user_roles', 'user_roles.user_id', '=', 'company_users.user_id')->where('user_roles.role_id', 2)->join('users', AppConst::USERS_ID, '=', 'user_roles.user_id')->select('users.*');
    }

    public function department_tasks()
    {
        return $this->hasManyThrough('App\Tasks', 'department_id')->with('company');
    }
    public static function getMemberList($request)
    {
         $data = User::join('user_roles','user_roles.user_id','users.id')->join('company_users','company_users.user_id','=',AppConst::USERS_ID)->join('department_members','department_members.company_user_id','=','company_users.id')->select('users.*','company_users.id as company_user_id','user_roles.role_id');

        if(empty($request->departments)){
            $department_members = $data->whereIn('department_members.department_id',$request->add_deps)->distinct(AppConst::USERS_ID)->get();
        }else{
            $department_members = $data->whereIn('department_members.department_id', $request->departments)->distinct(AppConst::USERS_ID)->get();
        }
        $key = self::decryptDataKey();
        foreach ($department_members as $members) {
            $members->name = self::DecryptedData($members->name, $key);
        }
        return $department_members;
    }

    public static function departments_list()
    {
        $t = Departments::select('departments.*');
        $tmp = self::department_restriction($t);
        return $tmp->get();
    }
    
    public function getDepartmentMember()
    {
        return $this->hasMany('App\DepartmentMembers','department_id','id');
    }
}
