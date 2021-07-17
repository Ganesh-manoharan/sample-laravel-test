<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Http\Traits\Base64ToImage;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\CompanyUsers;
use App\User;
use App\Departments;
use App\CompanyDepartment;
use App\DepartmentMembers;
use App\Http\Traits\EnvelopeEncryption;
use App\Http\Traits\PasswordResetLink;
use App\UserRoles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\AppConst;
use App\Support\Collection;
use App\Http\Requests\StoreCompanyRequest;
use App\Rules\EncodedDocumentType;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    use  EnvelopeEncryption, Base64ToImage, PasswordResetLink;
    public function index(Request $request)
    {
        $data = Company::with('companyusers');  
        if($request->sortOrder){
            $data = $data->orderBy($request->sortBy,$request->sortOrder);
        }
        if($request->search){
            $data = $data->where('company.company_name','like',"%".$request->search."%");
        }
        if($request->search || $request->sortOrder || $request->page){
            $data = $data->paginate(config(AppConst::COMMON_PAGINATE));
            $content = view('includes.company_list',compact('data'))->render();
            $pagination = view('includes.pagination', compact('data'))->render();
            return ['data' => $content, 'pagination' => $pagination];
        }
        $data = $data->paginate(config(AppConst::COMMON_PAGINATE));


        return view('teams', compact('data'))->with(['page' => __('Home')]);
    }

    public function create_admin(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
            'file.*' => ['max:30000',new EncodedDocumentType]
            ]
        );
        if ($validator->fails()) {
             return redirect()->route('admin_home')
                    ->withErrors($validator)
                    ->withInput();
        }
        
        if($request->editCompanyID)
        {
            return $this->Companyupdate($request);
        }

        try {
            $companydetails = Company::create([
                'company_name' => $request->company_name,
                'contact_number' => $request->contact_number,
                'contact_email' => $request->contact_email,
                'regulatory_status' => $request->regulatory_status,
                'address_line_one' => $request->address_line_one,
                'address_line_two' => $request->address_line_two,
                'address_line_three' => $request->address_line_three,
                'address_line_four' => $request->address_line_four,
                'created_by' => Auth()->user()->id
            ]);

            if ($request->upload_icon) {
                $image = self::base64todata($request->upload_icon);
                $path = 'company_icon/' . Carbon::now()->month . '/';
                $filename = $companydetails->id . '-' . time() . '.' . $image['extension'];
                Storage::disk('s3')->put($path . $filename, (string)$image['data'], 'public');
                $companydetails->update(['company_logo' => $path . $filename]);
            }
            $usr = [];
            $password = Str::random(8);
            $key = self::decryptDataKey();
            for ($i = 0; $i < count($request->company_admin_email); $i++) {
                $userdetails = User::create([
                    'name' => self::EncryptedData($request->company_admin_username[$i], $key),
                    'avatar' => 'img/user-avatar.png',
                    'email' => self::EncryptedData($request->company_admin_email[$i], $key),
                    'email_hash' => hash('sha256', $request->company_admin_email[$i]),
                    'password' => Hash::make($password),
                ]);
                $cmpUsr = CompanyUsers::create([
                    'company_id' => $companydetails->id,
                    'user_id' =>  $userdetails->id
                ]);
                UserRoles::create([
                    'user_id' => $userdetails->id,
                    'role_id' => 2
                ]);
                $data = collect([]);
                $data->email = $request->company_admin_email[$i];
                $data->name = $request->company_admin_username[$i];
                self::reset_mail_sent($data);
                $usr[$i] = $cmpUsr->id;
            }
            foreach ($request->departments as $item) {
                $dep = Departments::create([
                    'name' => $item,
                    'status' => 1
                ]);
                if ($dep) {
                    CompanyDepartment::create([
                        'company_id' => $companydetails->id,
                        'department_id' => $dep->id
                    ]);
                    foreach($usr as $u){
                        DepartmentMembers::create([
                            'company_user_id' => $u,
                            'is_manager' => 1,
                            'department_id' => $dep->id,
                        ]);
                    }
                }
            }
            return redirect()->route('admin_home');
        } catch (\Exception $e) {
            Log::info("Locked user attempt for Reset" . $e);
        }
    }

    public function Companyupdate(Request $request)
    {
       

        try{
            $com = Company::where('id', $request->editCompanyID)->first(); 
            $companydetails = [
                'company_name' => $request->company_name,
                'contact_number' => $request->contact_number,
                'contact_email' => $request->contact_email,
                'regulatory_status' => $request->regulatory_status,
                'address_line_one' => $request->address_line_one,
                'address_line_two' => $request->address_line_two,
                'address_line_three' => $request->address_line_three,
                'address_line_four' => $request->address_line_four,
                'created_by' => Auth()->user()->id
            ];

           if ($request->upload_icon) {
            $image = self::base64todata($request->upload_icon);
            $path = 'company_icon/' . Carbon::now()->month . '/';
            $filename = $request->editCompanyID . '-' . time() . '.' . $image['extension'];
            Storage::disk('s3')->put($path . $filename, (string)$image['data'], 'public');
            Storage::disk('s3')->delete($com->company_logo);
            $companydetails['company_logo']= $path . $filename;
        }

        $com->update($companydetails);
       $usr = [];
            $password = Str::random(8);
            $key = self::decryptDataKey();
            if($request->userid){
            for ($i = 0; $i < count($request->userid); $i++) {
                $userdetails = User::create([
                    'name' => self::EncryptedData($request->username[$i], $key),
                    'avatar' => 'img/user-avatar.png',
                    'email' => self::EncryptedData($request->userid[$i], $key),
                    'email_hash' => hash('sha256', $request->userid[$i]),
                    'password' => Hash::make($password),
                ]);
                $cmpUsr = CompanyUsers::create([
                    'company_id' => $request->editCompanyID,
                    'user_id' =>  $userdetails->id
                ]);
                UserRoles::create([
                    'user_id' => $userdetails->id,
                    'role_id' => 2
                ]);
                $data = collect([]);
                $data->email = $request->userid[$i];
                $data->name = $request->username[$i];
                self::reset_mail_sent($data);
                $usr[$i] = $cmpUsr->id;
            }
        }

        if($request->departments){
        foreach ($request->departments as $item) {
            $dep = Departments::create([
                'name' => $item,
                'status' => 1
            ]);
            if ($dep) {
                CompanyDepartment::create([
                    'company_id' => $request->editCompanyID,
                    'department_id' => $dep->id
                ]);
                foreach($usr as $u){
                    DepartmentMembers::create([
                        'company_user_id' => $u,
                        'is_manager' => 1,
                        'department_id' => $dep->id,
                    ]);
                }
            }
        }
    }
        return redirect()->route('admin_home');




        }catch (\Exception $e) {
            Log::info("Locked user attempt for Reset" . $e);
        }


    }


    public function viewcompanydetails(Request $request,$id)
    {
        $data = Company::with('companyusers')->where('id',$id)->first();
        $companydepartment=CompanyDepartment::join('departments','departments.id','company_departments.department_id')->where('company_departments.company_id',$id)->get();
        $companyusers=CompanyUsers::join('users','users.id','=','company_users.user_id')->where('company_users.company_id',$id)->get();
        return view('companyviewdetail', compact('data','companydepartment','companyusers'))->with(['page' => 'Back', 'page_url' => route('admin_home'), 'back_button' => 'fas fa-angle-left mr-3']);
    }
      public function addcompany_validation(StoreCompanyRequest $request)
    {
        return ['hasErrors' => false];
    }

}
