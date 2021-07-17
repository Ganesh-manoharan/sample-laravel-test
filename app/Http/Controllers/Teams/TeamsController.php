<?php

namespace App\Http\Controllers\Teams;

use App\User;
use App\DataKey;
use App\AppConst;
use App\Support\Collection;
use Illuminate\Http\Request;
use App\Traits\CommonFunction;
use App\Http\Controllers\Controller;
use App\Http\Traits\DepartmentList;
use App\Http\Traits\EnvelopeEncryption;
use App\Http\Traits\UserAccess;
use App\TaskUsers;

class TeamsController extends Controller
{
    use CommonFunction, DepartmentList, UserAccess;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // to do
    }

    public function index(Request $request)
    {
        $data = self::department_list_with_data(config(AppConst::COMMON_PAGINATE), $request->search);
        if($request->search || $request->page){
            $content = view('includes.department_list', compact('data'))->render();
            $pagination = view('includes.pagination', compact('data'))->render();
            return ['data'=>$content,'pagination'=>$pagination];
        }
        return view('manager.team.home', compact('data'))->with(['page' =>  __('header.Teams'), 'department_class' => 'underline-active', 'users_class' => '', 'search_url' => route('teams.department_search'),'click_on_list'=>'department-detail-page','add_button'=>'addDepartmentModal']);
    }

    public function index_all_users(Request $request)
    {
        $data = User::with('user_roles')->join('user_roles','user_roles.user_id','users.id')->whereIn('user_roles.role_id',[2,3,4])->orderBy('users.created_at', 'DESC')->select('users.*','company_users.id as company_user_id');
        $data = self::user_list($data);

        if($request->search){
            $key = self::decryptDataKey();
            $data = $data->get()->filter(function ($q) use ($key, $request) {
                $name = self::DecryptedData($q->name, $key);
                    if (strpos('_'.strtolower($name), strtolower($request->search))) {
                        return $q;
                    }
                })->values()->all();
                $data = (new Collection($data));
        }
        $data = $data->paginate(config(AppConst::COMMON_PAGINATE));
        $user_action = 1;
        $com_sts = 0;
        foreach($data as $item){
            if($item->user_roles->role_id == 4){
                $user_action = 0;
                $com_sts = 2;
            }
            $item->task_count = TaskUsers::join('tasks','tasks.id','task_users.task_id')->where(function ($query) use($item) {
                $query->where('task_users.company_user_id', $item->company_user_id);
                $query->orWhere('task_users.is_all',1);
            })->where('tasks.completion_status', $com_sts)->where('user_action',$user_action)->count();
        }
        if($request->search || $request->page){
            $content = view('includes.user_list',compact('data'))->render();
            $pagination = view('includes.pagination', compact('data'))->render();
            return ['data' => $content, 'pagination' => $pagination];
        }
        return view('manager.team.home', compact('data'))->with(['page' => __('header.Teams'), 'department_class' => '', 'users_class' => 'underline-active', 'search_url' => route('teams.user_search'),'add_button'=>'add_new_user']);
    }

    public function department_search(Request $request)
    {
        $data = self::department_list_with_data(config(AppConst::COMMON_PAGINATE),$request->get('cmpId'),$request->get('cmpUsrId'), $request->search);
        $pagination = view('includes.pagination', compact('data'))->render();
        return ['data' => $data, 'pagination' => $pagination,'click_on_list'=>'department-detail-page'];
    }

    public function user_search(Request $request)
    {
        $search = $request->search;
        $key = DataKey::latest()->first();
        $plain = self::EnvelopeDecrypt($key->key);
        $user = User::with('user_roles');
        if ($request->department_id) {
            $user=User::with('user_roles')->join('company_users','company_users.user_id','=','users.id')->join('department_members','department_members.company_user_id','=','company_users.id')->where('department_members.department_id',$request->department_id)->select('users.*','company_users.id as company_user_id');
        }
        $user = $user->get()->filter(function ($q) use ($plain, $search) {
            $name = self::DecryptedData($q->name, $plain);
            $q->name = $name;
            if (!is_null($search)) {
                if (strpos(strtolower($name), strtolower($search)) === 0) {
                    return $q;
                }
            } else {
                return $q;
            }
        });
        if($request->sortOrder == 'ASC'){
            $data = (new Collection($user))->sortBy($request->sortBy)->paginate(config(AppConst::COMMON_PAGINATE));
        }else{
            $data = (new Collection($user))->sortByDesc($request->sortBy)->paginate(config(AppConst::COMMON_PAGINATE));
        }
        $user_action = 1;
        $com_sts = 0;
        foreach($data as $item){
            if($item->user_roles->role_id == 4){
                $user_action = 0;
                $com_sts = 2;
            }
            $item->task_count = TaskUsers::join('tasks','tasks.id','task_users.task_id')->where(function ($query) use($item) {
                $query->where('task_users.company_user_id', $item->company_user_id);
                $query->orWhere('task_users.is_all',1);
            })->where('tasks.completion_status', $com_sts)->where('user_action',$user_action)->count();
        }
        $content = view('includes.user_list', compact('data'))->render();
        $pagination = view('includes.pagination', compact('data'))->render();
        return ['data' => $content, 'pagination' => $pagination];
    }
}
