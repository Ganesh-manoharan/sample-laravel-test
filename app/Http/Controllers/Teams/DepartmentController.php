<?php

namespace App\Http\Controllers\Teams;

use App\User;
use App\Issue;
use App\Tasks;
use App\AppConst;
use App\TaskUsers;
use Carbon\Carbon;
use App\Departments;
use App\TaskDepartment;
use App\CompanyDepartment;
use App\DepartmentMembers;
use Illuminate\Http\Request;
use App\Http\Traits\UserAccess;
use App\Http\Traits\Base64ToImage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Traits\EnvelopeEncryption;
use App\Http\Traits\TaskList;
use Illuminate\Support\Facades\Storage;
use App\Support\Collection;


class DepartmentController extends Controller
{
    use Base64ToImage, EnvelopeEncryption, UserAccess, TaskList;

    public function new_department_save(Request $request)
    {
        if($request->editdepartmentID){
            return $this->update_department($request);
        }
        $dep = new Departments([
            'name' => $request->department_name,
            'description' => $request->department_description,
            'status' => 1
        ]);
       // if ($request->has('upload_icon')) {
           // $image = self::base64todata($request->upload_icon);
           // $path = 'department_icon/' . Carbon::now()->month . '/';
           // $filename = $dep->id . '-' . time() . '.' . $image['extension'];
           // Storage::disk('s3')->put($path . $filename, (string)$image['data'], 'public');
           // $dep->dep_icon = $path . $filename;
       // }
        $dep->save();

        if ($dep) {
            $comapanyDepartment=new CompanyDepartment;
            $comapanyDepartmentData=[
                'company_id' => $request->get('cmpId'),
                'department_id' => $dep->id
            ];
            $comapanyDepartment->insert($comapanyDepartmentData);
            if ($request->department_admin) {
                DepartmentMembers::save_department_members($request->department_admin, $dep->id,true);
            }
            if ($request->department_all) {
                DepartmentMembers::save_department_members($request->department_all, $dep->id,false);
            }
        }
        $t = DepartmentMembers::where('company_user_id',$request->get('cmpUsrId'))->where('department_id',$dep->id)->first();
        if($t){
            $t->update(['is_manager'=>1]);
        }else{
            $d = collect([$request->get('cmpUsrId')]);
            DepartmentMembers::save_department_members($d, $dep->id,true);
        }
        return redirect()->back();
    }

    public function update_department($request)
    {
        $dep = Departments::where('id', $request->editdepartmentID)->first();
        $dep->update([
            'name' => $request->department_name,
            'description' => $request->department_description,
            'status' => 1
        ]);
        // if ($request->upload_icon) {
        //     $image = self::base64todata($request->upload_icon);
        //     $path = 'department_icon/' . Carbon::now()->month . '/';
        //     $filename = $request->editdepartmentID . '-' . time() . '.' . $image['extension'];
        //     Storage::disk('s3')->put($path . $filename, (string)$image['data'], 'public');
        //     Storage::disk('s3')->delete($dep->dep_icon);
        //     $dep->update(['dep_icon' => $path . $filename]);
        // }
        if($request->department_member_remove){
            DepartmentMembers::remove_members($request->department_member_remove,$dep->id);
        }
        if ($request->department_admin) {
            DepartmentMembers::save_department_members($request->department_admin, $dep->id,true);
        }
        if ($request->department_all) {
            DepartmentMembers::save_department_members($request->department_all, $dep->id,false);
        }
        return redirect()->back();
    }

    public function department_detail(Request $request,$id)
    {
        $dep = Departments::where('id', $id)->first();
        $dep->dep_manager = DepartmentMembers::where(AppConst::DEPARTMENT_MEMBERS_DEPARTMENT_ID,$id)->where('department_members.is_manager',1)->join('company_users',AppConst::COMPANY_USERS_ID,AppConst::DEPT_MEMS_COMUSRID)->join('users',AppConst::USERS_ID,'company_users.user_id')->select('users.*')->first();
        
        $data = User::with('user_roles')->orderBy('users.created_at', 'DESC');
        $data = self::user_list($data);
        if($request->search){
            $key = self::decryptDataKey();
            $data = $data->get()->filter(function ($q) use ($key, $request) {
                $name = self::DecryptedData($q->name, $key);
                    if (strpos(strtolower($name), strtolower($request->search)) === 0) {
                        return $q;
                    }
                })->values()->all();
                $data = (new Collection($data));
                $data = $data->paginate(config(AppConst::COMMON_PAGINATE));
                $content = view('includes.user_list',compact('data'))->render();
                $pagination = view('includes.pagination', compact('data'))->render();
                return ['data' => $content, 'pagination' => $pagination];
        }
        $dep_members = $data->select('users.*','company_users.id as company_user_id')->join('department_members', AppConst::DEPT_MEMS_COMUSRID, '=', AppConst::COMPANY_USERS_ID)->where(AppConst::DEPARTMENT_MEMBERS_DEPARTMENT_ID, $dep->id)->where('department_members.active_status',1)->paginate(config(AppConst::COMMON_PAGINATE));
        // $user_action = 1;
        // $com_sts = 0;
        // foreach ($dep_members as $item) {
        //     if ($item->user_roles->role_id == 4) {
        //         $user_action = 0;
        //         $com_sts = 2;
        //     }
        //     $item->task_count = TaskUsers::join('tasks', AppConst::TASK_ID, 'task_users.task_id')->where(function ($query) use ($item) {
        //         $query->where('task_users.company_user_id', $item->company_user_id);
        //         $query->orWhere('task_users.is_all', 1);
        //     })->where('tasks.completion_status', $com_sts)->where('task_users.user_action', $user_action)->count();
        // }
        // $tasks = Tasks::join('task_departments', 'task_departments.task_id', '=', AppConst::TASK_ID)->where(function ($query) use ($id) {
        //     $query->where('task_departments.department_id', $id);
        //     $query->orWhere('task_departments.is_all', 1);
        // })->where('tasks.created_by_id', auth()->user()->id)->pluck(AppConst::TASK_ID);
        // $issues = Issue::whereIn('task_id', $tasks)->get();
        $date = new Carbon();
        $now = $date->format('Y-m-d');        
        $aYearAgo = $date->clone()->subYears(1)->format('Y-m-d');
        $issues = self::task_list('issue')->where('task_departments.department_id',$id)->whereBetween('tasks.created_at',[$aYearAgo,$now]);
        $total = $issues->count();
        $resolved = $issues->where('completion_status',1)->count();
        $comp_per = $total != 0 ? number_format($resolved/$total * 100,1,'.') : 0;
        $data = ['department_members' => $dep_members, 'department_detail' => $dep, 'issues' => ['total'=>$total,'resolved'=>$resolved,'completion_percentage'=>$comp_per]];
        return view('manager.team.department_detail', compact('data'))->with(['page' => 'Back', 'page_url' => url()->route('teams'), 'back_button' => 'fas fa-angle-left mr-3']);
    }
    
    public function fetchdepartmentdetails($id)
    {
        $dep = Departments::where('id', $id)->first();

        $data = User::orderBy('users.created_at', 'DESC');
        $data = self::user_list($data);

        $dep_members =$data->join('user_roles', 'user_roles.user_id', '=', AppConst::USERS_ID)->join('department_members', AppConst::DEPT_MEMS_COMUSRID, '=', AppConst::COMPANY_USERS_ID)->where(AppConst::DEPARTMENT_MEMBERS_DEPARTMENT_ID, $dep->id)->select('users.name', 'users.avatar', 'company_users.id as company_user_id', 'user_roles.role_id', 'department_members.is_manager','department_members.id as department_member_id')->where('department_members.active_status',1)->get();

        $key = self::decryptDataKey();
        foreach ($dep_members as $members) {
            $members->name = self::DecryptedData($members->name, $key);
        }
        $tasks = Tasks::join('task_departments', 'task_departments.task_id', '=', AppConst::TASK_ID)->where(function ($query) use ($id) {
            $query->where('task_departments.department_id', $id);
            $query->orWhere('task_departments.is_all', 1);
        })->where('tasks.created_by_id', auth()->user()->id)->pluck(AppConst::TASK_ID);
        $issues = Issue::whereIn('task_id', $tasks)->get();
        $data = ['department_members' => $dep_members, 'department_detail' => $dep, 'issues' => $issues];

        return $data;
    }

    public function get_data_for_adding_dept(Request $request)
    {
        return User::userlist($request->get('cmpId'));
    }
    public function deletethesingledepartmentrecord(Request $request, $id)
    {
        $departments=Departments::find($id);
        foreach($departments->getDepartmentMember as $departmentMembers)
        {
            DepartmentMembers::find($departmentMembers->id)->delete();
        }
        Departments::find($id)->delete();
        return redirect()->route('teams');
    }

    public function delete_department_members($id)
    {
        try {
            DepartmentMembers::find($id)->delete();
            return ['hasErrors' => false];
        } catch (\Exception $e) {
            return ['hasErrors' => true];
        }
    }
}
