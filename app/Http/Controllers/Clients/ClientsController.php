<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonFunction;
use App\Http\Traits\DepartmentList;
use App\Http\Traits\EnvelopeEncryption;
use App\Http\Traits\ClientList;
use Illuminate\Support\Facades\Storage;
use App\AppConst;
use App\User;
use App\Http\Traits\Base64ToImage;
use App\Company;
use App\CompanyDepartment;
use Carbon\Carbon;
use App\FundGroups;
use App\Http\Requests\CreateClientRequest;
use App\Tasks;
use App\CompanyFund;
use App\SubFunds;
use App\ClientKeyContacts;
use App\Departments;
use App\CompanyUsers;
use App\Client;
use App\ClientDepartment;
use App\ClientFundGroup;
use App\CompanyClient;
use App\Http\Traits\UserAccess;
use Illuminate\Support\Facades\Log;

class ClientsController extends Controller
{
    use CommonFunction, ClientList, EnvelopeEncryption, Base64ToImage, UserAccess;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // to do
    }

    public function new_clients_save(CreateClientRequest $request)
    {
        if ($request->editclientID != "") {
            return $this->update_client($request);
        }
        $tmp = Client::save_client($request);
        if ($tmp["isError"]) {
            return redirect()->back()->with(["alert-error" => $tmp["errorInfo"]]);
        }
        User::save_user($request->clientName,$request->clientEmail,$request->get('cmpId'),$tmp['data']);
        $filePath = 'client_ftp/'.$tmp['data'].'/'.time();
        Storage::disk('s3')->put($filePath,null,'public');
        Client::where('id',$tmp['data'])->update(['ftp_path'=>$filePath]);
        CompanyClient::addCom_client($request->get('cmpId'), $tmp['data']);
        ClientKeyContacts::contacts_save($request, $tmp['data'],'add');
        if ($request->fund_groups) {
            ClientFundGroup::storeclientfunds($request, $tmp['data']);
        }
        if ($request->departments1) {
            ClientDepartment::storeclientdepartment($request, $tmp['data']);
        }
      
        // if ($request->has('upload_icon')) {
        //     $image = self::base64todata($request->upload_icon);
        //     $path = 'company_icon/' . Carbon::now()->month . '/';
        //     $filename = $tmp['data'] . '-' . time() . '.' . $image['extension'];
        //     Storage::disk('s3')->put($path . $filename, (string)$image['data'], 'public');
        //     Client::where('id', $tmp['data'])->update(['client_logo' => $path . $filename]);
        // }
        return redirect()->back()->with(["alert-success" => "Client added successfully! Thanks"]);
    }

    public function update_client($request)
    {
        $client = Client::where('id',$request->editclientID)->first();
            $clientData=[
                'client_name' => $request->clientName,
                'description' => $request->shortDescriptions,
                'email' => $request->clientEmail,
                'regulated_status' => $request->regulated_status
            ];
            if ($request->departments1 != "") {
                ClientDepartment::storeclientdepartment($request, $request->editclientID);
            }
            if ($request->fund_groups != "") {
                ClientFundGroup::storeclientfunds($request, $request->editclientID);
            }
            if ($request->upload_icon) {
                $image = self::base64todata($request->upload_icon);
                $path = 'company_icon/' . Carbon::now()->month . '/';
                $filename = $request->editclientID . '-' . time() . '.' . $image['extension'];
                Storage::disk('s3')->put($path . $filename, (string)$image['data'], 'public');
                Storage::disk('s3')->delete($client->client_logo);
                $clientData['client_logo'] = $path . $filename;
            }
            $client->update($clientData);
            if ($request->keycontact_clientName || $request->keycontact_clientEmail || $request->keycontact_clientphonenumber) {
                ClientKeyContacts::contacts_save($request, $request->editclientID,'update');
            }
            return redirect()->back()->with(["alert-success" => "Client updated successfully! Thanks"]);
    }

    public function index(Request $request)
    {
        $data = Client::with('client_fundgroups_count', 'client_sub_funds_count')->where('clients.active_status', 1)->select('client_name', AppConst::CLIENTS_ID, 'description', 'client_logo')->orderBy(AppConst::CLIENTS_ID, 'DESC');
 
        $data = self::client_access($data);
        if ($request->search || $request->page) {
            $data = $data->where('clients.client_name', 'like', "%" . $request->search . "%")->paginate(config(AppConst::COMMON_PAGINATE));
            $content = view('manager.client.includes.client_list',compact('data'))->render();
            $pagination = view('includes.pagination', compact('data'))->render();
            return ['data' => $content, 'pagination' => $pagination];
        }
        $data = $data->paginate(config(AppConst::COMMON_PAGINATE));
        $data->total_departments = Departments::count();
        $dt = Departments::select('departments.name','departments.dep_icon','company_departments.*');
        $department_listnot_in_selecteditem = $this->department_restriction($dt)->get();
        $fundgroups_listnot_in_selecteditem = FundGroups::select('fund_groups.id as fundid','fund_groups.fund_group_name','fund_groups.avatar','company_fund_groups.*')->join('company_fund_groups','company_fund_groups.fund_group_id','fund_groups.id')->where('company_fund_groups.company_id',$request->get('cmpId'))->get();
        return view('manager.client.home', compact('data', 'department_listnot_in_selecteditem', 'fundgroups_listnot_in_selecteditem'))->with(['page' => __('header.Clients'), 'department_class' => 'underline-active', 'users_class' => '', 'search_url' => route('clients')]);
    }
    public function viewclientdetails(Request $request, $id)
    {
        $data = Client::with('clientkeycontact')->where('id', '=', $id)->first();

        $department_list = ClientDepartment::client_departments($id);
        $deps = [];
        foreach ($department_list as $item) {
            $deps[] = $item->id;
        }
        $dt = Departments::select('departments.name','departments.dep_icon','company_departments.*');
        $department_listnot_in_selecteditem = $this->department_restriction($dt)->whereNotIn('departments.id',$deps)->get();

        $fundgroups_list = FundGroups::client_funds($id);
        $funds = [];
        foreach ($fundgroups_list as $item) {
            $funds[] = $item->id;
        }
        $fundgroups_listnot_in_selecteditem = FundGroups::select('fund_groups.fund_group_name','fund_groups.avatar','company_fund_groups.*')->join('company_fund_groups','company_fund_groups.fund_group_id','fund_groups.id')->where('company_fund_groups.company_id',$request->get('cmpId'))->whereNotIn('fund_groups.id',$funds)->get();

        return view('manager.client.viewclientdetail', compact('data', 'department_list', 'department_listnot_in_selecteditem', 'fundgroups_list', 'fundgroups_listnot_in_selecteditem'))->with(['page' => 'Back', 'page_url' => route('clients'), 'back_button' => 'fas fa-angle-left mr-3']);;
    }
    public function fetchclientdetails($id)
    {
        $data = Client::with('clientkeycontact')->where(AppConst::CLIENTS_ID, '=', $id)->first();
        $data['fund_groups'] = FundGroups::client_funds($id);
        $data['departments'] = ClientDepartment::client_departments($id);
        return $data;
    }
    public function adddepartmentassignedvalue(Request $request)
    {
        $clientid = $request->clientid;
        return ClientDepartment::storeindividualdepartment($request, $clientid);
    }

    public function addfundgroupsassignedvalue(Request $request)
    {
        $clientid = $request->clientid;
        ClientFundGroup::storeindividualfund($request, $clientid);
        $fundgroupid = $request->fundgroupsid;
        return FundGroups::with('getsubfundslist')->where('fund_groups.id', $fundgroupid)->join('company_fund_groups','company_fund_groups.fund_group_id','fund_groups.id')->join('client_fund_groups', 'company_fund_groups.id', '=', 'client_fund_groups.company_fund_group_id')->select('client_fund_groups.id as action_id','fund_groups.*')->get();
    }
    public function department_client_search(Request $request)
    {
        $data = self::client_list_with_data(config(AppConst::COMMON_PAGINATE), $request->search);
        $pagination = view('includes.pagination', compact('data'))->render();
        return ['data' => $data, 'pagination' => $pagination, 'total_departments' => Departments::count()];
    }
    public function deletedepartmentassignedvalue(Request $request, $id)
    {
        try {
            ClientDepartment::where('id', $id)->delete();
            return ['hasErrors' => false];
        } catch (\Exception $e) {
            return ['hasErrors' => true];
        }
    }
    public function deletefundgroupsassignedvalue(Request $request, $id)
    {
        try {
            ClientFundGroup::where('id', $id)->delete();
            return ['hasErrors' => false];
        } catch (\Exception $e) {
            return ['hasErrors' => true];
        }
    }
    public function deletethesingleclientrecord(Request $request, $id)
    {
        try{
        Client::find($request->id)->delete();
        }
        catch (\Exception $e) {
            Log::info("Locked user attempt for Reset" . $e);
            }  
        return redirect()->route('clients');
    }

    public function deletecompany(Request $request, $id)
    {
        try{
            Company::find($request->id)->delete();
        }
        catch (\Exception $e) {
            Log::info("Locked user attempt for Reset" . $e);
            }  
        return redirect()->route('admin_home');
    }

   
    
}
