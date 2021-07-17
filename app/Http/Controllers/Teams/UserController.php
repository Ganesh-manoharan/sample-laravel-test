<?php

namespace App\Http\Controllers\Teams;

use App\Client;
use App\ClientUser;
use Illuminate\Http\Request;
use App\CompanyUsers;
use App\DepartmentMembers;
use App\Departments;
use App\Http\Traits\EnvelopeEncryption;
use App\User;
use App\UserRoles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\AppConst;
use App\Http\Requests\UserRequest;
use App\Http\Traits\PasswordResetLink;
use App\Http\Traits\Base64ToImage;
use App\Http\Traits\UserAccess;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserController extends Controller
{
    use EnvelopeEncryption, PasswordResetLink,Base64ToImage,UserAccess;
    public function add_new_user_show_form(Request $request)
    {
        $company_list = Client::orderBy('clients.created_at')->select('clients.*');
        $company_list = self::client_access($company_list);
        $clients = $company_list->get();
        $departments_list = Departments::select('departments.*');
        $departments_list = self::department_restriction($departments_list);
        $daprt = $departments_list->get();
        return ['clients' => $clients, 'departments' => $daprt];
    }

    public function add_new_user(UserRequest $request)
    {
        
        if($request->editUserID)
        {
            try{
            $key = self::decryptDataKey();
            $com = User::where('id', $request->editUserID)->first();
           
           $userdata=[
                'name' => self::EncryptedData($request->name, $key),
                'email' => self::EncryptedData($request->email, $key),
                'email_hash' => Hash::make($request->email),
                'location' => $request->location,
                'company_role'=>$request->company_role
            ];
             if ($request->upload_icon) {
             $image = self::base64todata($request->upload_icon);
             $path = 'user_icon/' . Carbon::now()->month . '/';
             $filename = $request->editUserID . '-' . time() . '.' . $image['extension'];
             Storage::disk('s3')->put($path . $filename, (string)$image['data'], 'public');
             Storage::disk('s3')->delete($com->company_logo);
             $userdata['avatar']= $path . $filename;
           }
           $com->update($userdata);

            UserRoles::where('user_id',$request->editUserID)->update([
                'role_id' => $request->role_id
            ]);

            if (!is_null($request->department_addnewuser_clients)) {
                foreach ($request->department_addnewuser_clients as $item) {
                    ClientUser::create([
                        'client_id' => $item,
                        'company_user_id' => $request->CompUserId,
                    ]);
                }
            }
            if (!is_null($request->department_addnewuser_departments)) {
                foreach ($request->department_addnewuser_departments as $item) {
                    DepartmentMembers::create([
                        'department_id' => $item,
                        'company_user_id' => $request->CompUserId
                    ]);
                }
            }
            return ['hasErrors' => false];
        }
        catch (\Exception $e) {
            Log::info("Locked user attempt for Reset" . $e);

        }

        }
        else
        {
            
        try {
            $password = Str::random(8);
            $key = self::decryptDataKey();
            $user=new User([
                'name' => self::EncryptedData($request->name, $key),
                'avatar' => 'img/user-avatar.png',
                'email' => self::EncryptedData($request->email, $key),
                'email_hash' => hash('sha256', $request->email),
                'password' => Hash::make($password),
                'location' => $request->location,
                'company_role'=>$request->company_role
            ]);
            if ($request->upload_icon) {
                $image = self::base64todata($request->upload_icon);
                $path = 'user_icon/' . Carbon::now()->month . '/';
                $filename = $user->id . '-' . time() . '.' . $image['extension'];
                Storage::disk('s3')->put($path . $filename, (string)$image['data'], 'public');
                $user->avatar = $path . $filename;
            }
            $user->save();
            if ($user) {
                $cmpUserId = CompanyUsers::create([
                    'company_id' => $request->get('cmpId'),
                    'user_id' => $user->id
                ]);
                UserRoles::create([
                    'user_id' => $user->id,
                    'role_id' => $request->role_id
                ]);
                if (!is_null($request->department_addnewuser_clients)) {
                    foreach ($request->department_addnewuser_clients as $item) {
                        ClientUser::create([
                            'client_id' => $item,
                            'company_user_id' => $cmpUserId->id,
                        ]);
                    }
                }
                if (!is_null($request->department_addnewuser_departments)) {
                    foreach ($request->department_addnewuser_departments as $item) {
                        DepartmentMembers::create([
                            'department_id' => $item,
                            'company_user_id' => $cmpUserId->id
                        ]);
                    }
                }
                
                //Create Password Reset Token
                self::reset_mail_sent($request);
                return ['hasErrors' => false];
            }
        } catch (\Exception $e) {
            return ['hasErrors' => true, 'data'=>$e->getMessage()];
        }
     }
    }

    public function user_profile(Request $request, $id)
    {
        $data = User::where('id', $id)->with('departments', 'user_roles')->first();
        $data->company = Client::join('client_users', 'client_users.client_id', AppConst::CLIENTS_ID)->join('company_users', 'company_users.id', 'client_users.company_user_id')->where('client_users.active_status',1)->where('company_users.user_id', $id)->select('clients.*', 'client_users.id as list_id')->get();
        $deps = [];
        $cli = [];
        foreach ($data->departments as $item) {
            $deps[] = $item->id;
        }
        foreach ($data->company as $item) {
            $cli[] = $item->id;
        }

        $users = CompanyUsers::where('user_id', $id)->first();

        $alldepartments = Departments::join('company_departments', 'company_departments.department_id', AppConst::DEPARTMENTS_ID)->where('company_departments.company_id', $request->get('cmpId'))->get();

        $departments = Departments::join('company_departments', 'company_departments.department_id', AppConst::DEPARTMENTS_ID)->where('company_departments.company_id', $request->get('cmpId'))->whereNotIn(AppConst::DEPARTMENTS_ID, $deps)->get();
        $clients = Client::join('company_clients', 'company_clients.client_id', AppConst::CLIENTS_ID)->where('company_clients.company_id', $request->get('cmpId'))->whereNotIn(AppConst::CLIENTS_ID, $cli)->get();

        return view('manager.team.user_profile', compact('data', 'departments', 'clients','alldepartments','users'))->with(['page' => 'Back', 'page_url' => route('teams.allusers'), 'back_button' => 'fas fa-angle-left mr-3']);
    }

    public function delete_client_users($id)
    {
        try {
            ClientUser::where('id', $id)->update(['active_status' => 0]);
            return ['hasErrors' => false];
        } catch (\Exception $e) {
            return ['hasErrors' => true];
        }
    }

    public function delete_company_users($id)
    {
        try{
        $companyuserid=CompanyUsers::where('user_id',$id)->first();
        $id=$companyuserid->id;
        CompanyUsers::find($id)->delete();
        return redirect()->route('teams.allusers');
        }
        catch (\Exception $e) {
            Log::info("Locked user attempt for Reset" . $e);
        }   
    }
}
