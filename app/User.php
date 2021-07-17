<?php

namespace App;

use App\Http\Traits\EnvelopeEncryption;
use App\Http\Traits\PasswordResetLink;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{

    use Notifiable, EnvelopeEncryption, PasswordResetLink;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','avatar','email', 'password', 'email_hash','location','company_role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_roles()
    {
        return $this->hasOne('App\UserRoles')->join('roles','roles.id','=','user_roles.role_id');
    }

    public function departments()
    {
        return $this->hasManyThrough('App\DepartmentMembers','App\CompanyUsers','user_id','company_user_id')->join('departments','departments.id','=','department_id')->where('department_members.active_status',1)->select('departments.*','department_members.id as list_id');
    }

    public function company()
    {
        return $this->belongsToMany('App\Company','App\CompanyUsers')->select('company.*','company_users.id as list_id');
    }

    public static function userlist($cmpId='')
    {
        if($cmpId=='')
        {
            $cmpId=request()->get('cmpId');
        }
        $data = User::join('user_roles','user_roles.user_id','=','users.id')->join('company_users','company_users.user_id','=','users.id')->select('users.name','users.avatar','company_users.id as company_user_id','user_roles.role_id')->distinct('company_users.user_id')->where('company_users.company_id',$cmpId )->whereIn('user_roles.role_id',[2,3,4])->get();

        $key = self::decryptDataKey();
        foreach ($data as $members) {
            $members->name = self::DecryptedData($members->name, $key);
        }
        return $data;
    }

    public static function save_user($name, $email, $cmpId, $client_id = null)
    {
        $password = Str::random(8);
        $key = self::decryptDataKey();
        $user = User::create([
            'name' => self::EncryptedData($name, $key),
            'avatar' => 'img/user-avatar.png',
            'email' => self::EncryptedData($email, $key),
            'email_hash' => hash('sha256', $email),
            'password' => Hash::make($password),
            'location' => null,
            'company_role' => null
        ]);
        if ($user) {
            $cmpUserId = CompanyUsers::create([
                'company_id' => $cmpId,
                'user_id' => $user->id
            ]);
            UserRoles::create([
                'user_id' => $user->id,
                'role_id' => 5
            ]);
            ClientUser::create([
                'company_user_id' => $cmpUserId->id,
                'client_id' => $client_id,
                'active_status' => 1
            ]);
            $data = collect([]);
            $data->email = $email;
            $data->name = $name;
            self::reset_mail_sent($data);
        }
    }

    public function getCompanyID()
    {
        return $this->hasOne('App\CompanyUsers');
    }

    public function urgent_tasks()
    {
        return $this->hasMany('App\CompanyUsers')->select('tasks.*')->join('task_users','task_users.company_user_id','company_users.id')->join('tasks','tasks.id','task_users.task_id')->where('tasks.completion_status',0);
    }
}
