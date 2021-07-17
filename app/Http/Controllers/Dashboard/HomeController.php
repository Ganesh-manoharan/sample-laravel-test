<?php

namespace App\Http\Controllers\Dashboard;

use App\Tasks;
use Illuminate\Http\Request;
use App\Traits\CommonFunction;
use App\Http\Controllers\Controller;
use App\Http\Traits\DepartmentList;
use App\AppConst;
use App\Http\Traits\UserAccess;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = self::department_list_with_data(config(AppConst::COMMON_PAGINATE));
        $formType = 'task';
        $callback = function($query) use ($formType) {
            $query->where('code', '=', $formType);
        };
        $tmp = Tasks::whereHas('getTaskType', $callback)->with(['getTaskType' => $callback])->select(AppConst::TASKS)->orderBy(AppConst::TASKS_CREATEDAT, 'DESC');
        $tmp = self::task_access($tmp);
        if($request->department_id){
            $tmp->where('task_departments.department_id', $request->department_id);
        }
        $tmp = $tmp->get();
        $tmp = self::task_detail($tmp);
        $info = Tasks::info_stats($tmp);
        return view('home', compact('info', 'data'))->with(['page' => __('header.Dashboard'), 'click_on_list' => 'task-filter-by-department']);
    }
}
