<?php

namespace App\Http\Controllers\Funds;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonFunction;
use App\FundGroups;
use App\AppConst;
use App\CompanyFund;
use App\FundsKeyContact;
use App\Http\Traits\FundList;
use App\Countries;
use App\Http\Traits\Base64ToImage;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Requests\SaveFundRequest;
use App\SubFunds;
use App\SubFundsKeyContact;
use App\CompanySubFund;
use Illuminate\Support\Facades\Log;

class FundController extends Controller
{
    use CommonFunction, FundList, Base64ToImage;

    public function funds(Request $request)
    {
         // $data = FundGroups::with('getsubfundslist')->join('company_fund_groups','company_fund_groups.fund_group_id','fund_groups.id')->where('company_fund_groups.company_id',$request->get('cmpId'))->orderBy('fund_groups.id', 'DESC')->paginate(config(AppConst::COMMON_PAGINATE));
	  
	   $data = FundGroups::with('getsubfundslist')->join('company_fund_groups','company_fund_groups.fund_group_id','fund_groups.id')->where('company_fund_groups.company_id',$request->get('cmpId'))->orderBy('fund_groups.id', 'DESC')->select('fund_groups.id as id','fund_groups.*');

       if($request->search || $request->page){
           $data = $data->where('fund_groups.fund_group_name', 'like', "%" . $request->search . "%")->paginate(config(AppConst::COMMON_PAGINATE));
           $content = view('manager.fund.includes.fund_groups_list',compact('data'))->render();
           $pagination = view('includes.pagination', compact('data'))->render();
           return ['data' => $content, 'pagination' => $pagination];
       }

       $data = $data->paginate(config(AppConst::COMMON_PAGINATE));
	 // echo "<pre>";
	//  print_r($data);exit;
  
        return view('manager.fund.home', compact('data'))->with(['page' => __('header.Funds'), 'fundgroups_class' => 'active', 'subfunds_class' => '', 'search_url' => route('funds.fund_search')]);
    }
    public function index_subfunds(Request $request)
    {
        $data=SubFunds::join('fund_groups','fund_groups.id','sub_funds.fund_group_id')->orderBy('sub_funds.id', 'DESC')->select('sub_funds.id as subfundid','sub_funds.initial_launch_date as sub_funds_launch_date','sub_funds.*','fund_groups.*')->join('company_sub_funds','company_sub_funds.sub_funds_id','sub_funds.id')->where('company_sub_funds.company_id',$request->get('cmpId'));

        if($request->search || $request->page){
            $data = $data->where('sub_funds.sub_fund_name', 'like', "%" . $request->search . "%")->paginate(config(AppConst::COMMON_PAGINATE));
            $content = view('manager.fund.includes.sub_funds_list',compact('data'))->render();
            $pagination = view('includes.pagination', compact('data'))->render();
            return ['data' => $content, 'pagination' => $pagination];
        }
      $data = $data->paginate(config(AppConst::COMMON_PAGINATE));
       return view('manager.fund.home', compact('data'))->with(['page' => __('header.Funds'), 'fundgroups_class' => '', 'subfunds_class' => 'active', 'search_url' => route('funds.fund_search')]);
    }
    public function fund_search(Request $request)
    {

        $data = self::fund_list_with_data(config(AppConst::COMMON_PAGINATE), $request->search);
        $pagination = view('includes.pagination', compact('data'))->render();
        return ['data' => $data, 'pagination' => $pagination, 'total_funds' => FundGroups::count()];
    }
    public function viewfunddetails(Request $request, $id)
    {
        $fund_data = FundGroups::with('getsubfundslist', 'getcountrylist', 'getkeycontactslist')->join('company_fund_groups','company_fund_groups.fund_group_id','fund_groups.id')->where('company_fund_groups.company_id',$request->get('cmpId'))->where('fund_groups.id', $id);
        if(!$fund_data->exists())
        {
            return response('Unauthorized Action', 403);
        }
        $fund_data=$fund_data->first();
        $data=SubFunds::join('fund_groups','fund_groups.id','sub_funds.fund_group_id')->orderBy('sub_funds.id', 'DESC')->select('sub_funds.id as subfundid','sub_funds.initial_launch_date as sub_funds_launch_date','sub_funds.*','fund_groups.*')->join('company_sub_funds','company_sub_funds.sub_funds_id','sub_funds.id')->where('company_sub_funds.company_id',$request->get('cmpId'))->where('sub_funds.fund_group_id',$id)->paginate(config(AppConst::COMMON_PAGINATE));
        return view('manager.fund.fund_detail', compact('data','fund_data'))->with(['page' => 'Back', 'page_url' => route('funds'), 'back_button' => 'fas fa-angle-left mr-3']);
    }
    public function viewsubfunddetails(Request $request, $id)
    {
        $data = SubFunds::with('getkeycontactslist')->join('company_sub_funds','company_sub_funds.sub_funds_id','sub_funds.id')->where('company_sub_funds.company_id',$request->get('cmpId'))->where('sub_funds.id', $id)->first();
        if(!$data->exists())
        {
            return response('Unauthorized Action', 403);
        }
        $data=$data->first();
        return view('manager.fund.sub_fund_detail', compact('data'))->with(['page' => 'Back', 'page_url' => route('funds.subfunds'), 'back_button' => 'fas fa-angle-left mr-3']);
    }

    public function edit_funddetails($id)
    {
        return FundGroups::with('getsubfundslist', 'getcountrylist', 'getkeycontactslist')->where('id', $id)->first();
    }
    public function new_funds_save(Request $request)
    {
        try{

        if($request->editfundID){
           return $this->update_fund($request);
        }
        if ($request->date != null) {
            $accounting_year_end = date(AppConst::DATEFORMATS, strtotime($request->date));
            $initial_launch_date = date(AppConst::DATEFORMATS, strtotime($request->initial_launch_date));
        } else {
            $accounting_year_end = $request->date;
            $initial_launch_date = $request->initial_launch_date;
        }
        $fundins = new FundGroups([
            'fund_group_name' => $request->fundName,
            'registered_address' => $request->registeredAddress,
            'entity_type' => $request->Entity_type,
            'management' => $request->management,
            'administrator' => $request->administrator,
            'depository' => $request->depository,
            'auditor' => $request->auditor,
            'accounting_year_end' => $accounting_year_end,
            'initial_launch_date' => $initial_launch_date,
            'country_id' => $request->country,
            'created_by' => $request->get('cmpUsrId')
        ]);
        $fundins->save();

        if ($request->keycontact_fundName || $request->keycontact_fundEmail || $request->keycontact_fundphonenumber) {
            $fundname = $request->keycontact_fundName;
            $fundemail = $request->keycontact_fundEmail;
            $fundphonenumber = $request->keycontact_fundphonenumber;
            FundsKeyContact::create([
                'fund_group_id' => $fundins->id,
                'keycontact_id' => 1,
                'name' => $fundname,
                'email' => $fundemail,
                'phone_number' => $fundphonenumber
            ]);
        }
        if ($fundins) {
            CompanyFund::create([
                'company_id' => $request->get('cmpId'),
                'fund_group_id' => $fundins->id,
            ]);
        }

        return redirect()->back()->with(["alert-success" => "Funds added successfully! Thanks"]);
        
        }catch(\Exception $e){
            return ["isError" => true, "errorInfo"=>$e->getMessage()];
        }
    }
    public function new_sub_funds_save(Request $request)
    {
        try{
        if($request->editsubfundID){
            return $this->update_sub_fund($request);
         }

        if ($request->initial_launch_date != null) {
            $initial_launch_date = date(AppConst::DATEFORMATS, strtotime($request->initial_launch_date));
        } else {
            $initial_launch_date = $request->initial_launch_date;
        }
        $subfundins = SubFunds::create([
            'sub_fund_name' => $request->subfundName,
            'fund_group_id'=> $request->fund_groups,
            'investment_strategy' => $request->investment_strategy,
            'investment_manager'=>$request->investment_manager,
            'initial_launch_date' => $initial_launch_date,
            'created_by' => $request->get('cmpUsrId')
        ]);
        if ($request->keycontact_subfundName || $request->subkeycontact_fundEmail || $request->subkeycontact_fundphonenumber) {
            $subfundname = $request->keycontact_subfundName;
            $subfundemail = $request->keycontact_subfundEmail;
            $subfundphonenumber = $request->keycontact_subfundphonenumber;
            SubFundsKeyContact::create([
                'sub_funds_id' => $subfundins->id,
                'name' => $subfundname,
                'email' => $subfundemail,
                'phone_number' => $subfundphonenumber
            ]);
        }
        if ($subfundins) {
            CompanySubFund::create([
                'company_id' => $request->get('cmpId'),
                'sub_funds_id' => $subfundins->id,
            ]);
           
        }
        return redirect()->back()->with(["alert-success" => "SubFunds added successfully! Thanks"]);
    
            }catch(\Exception $e){
                return ["isError" => true, "errorInfo"=>$e->getMessage()];
            }
    }

    public function update_sub_fund(Request $request)
    {
        if ($request->initial_launch_date != null) {
            $initial_launch_date = date(AppConst::DATEFORMATS, strtotime($request->initial_launch_date));
        } else {
            $initial_launch_date = $request->initial_launch_date;
        }
        $subfundetails = SubFunds::where('id', $request->editsubfundID)->first();
        SubFunds::where('id', $request->editsubfundID)->update([
            'sub_fund_name' => $request->subfundName,
            'investment_strategy' => $request->investment_strategy,
            'investment_manager'=>$request->investment_manager,
            'initial_launch_date' => $initial_launch_date,
        ]);
       
        if ($request->keycontact_subfundName || $request->subkeycontact_fundEmail || $request->subkeycontact_fundphonenumber) {

            $subfundname = $request->keycontact_subfundName;
            $subfundemail = $request->keycontact_subfundEmail;
            $subfundphonenumber = $request->keycontact_subfundphonenumber;

            $subfundetails = SubFundsKeyContact::where('sub_funds_id', $request->editsubfundID)->update([
                'name' => $subfundname,
                'email' => $subfundemail,
                'phone_number' => $subfundphonenumber
            ]);

            if ($subfundetails == 0) {
                SubFundsKeyContact::create([
                    'sub_funds_id' => $request->editfundID,
                    'keycontact_id' => 1,
                    'name' => $subfundname,
                    'email' => $subfundemail,
                    'phone_number' => $subfundphonenumber
                ]);
            }
        }
        return redirect()->back()->with(["alert-success" => "SubFunds Updated successfully! Thanks"]);
    }
    public function update_fund(Request $request)
    {
        if ($request->date != null) {
            $accounting_year_end = date(AppConst::DATEFORMATS, strtotime($request->date));
            $initial_launch_date = date(AppConst::DATEFORMATS, strtotime($request->initial_launch_date));
        } else {
            $accounting_year_end = $request->date;
            $initial_launch_date = $request->initial_launch_date;
        }
        $com = FundGroups::where('id', $request->editfundID)->first();
        $fundsGroupData=[
            'fund_group_name' => $request->fundName,
            'registered_address' => $request->registeredAddress,
            'entity_type' => $request->Entity_type,
            'management' => $request->management,
            'administrator' => $request->administrator,
            'depository' => $request->depository,
            'auditor' => $request->auditor,
            'accounting_year_end' => $accounting_year_end,
            'initial_launch_date' => $initial_launch_date,
            'country_id' => $request->country
        ];
        $com->update($fundsGroupData);
        if ($request->keycontact_fundName || $request->keycontact_fundEmail || $request->keycontact_fundphonenumber) {
            $fundname = $request->keycontact_fundName;
            $fundemail = $request->keycontact_fundEmail;
            $fundphonenumber = $request->keycontact_fundphonenumber;
            $fundetails = FundsKeyContact::where('fund_group_id', $request->editfundID)->first();
            $fundetailsData = [
                'keycontact_id' => 1,
                'name' => $fundname,
                'email' => $fundemail,
                'phone_number' => $fundphonenumber
            ];
            if($fundetails)
            {
                $fundetails->update($fundetailsData);
            }
            else
            {
                $fundKeyContact=new FundsKeyContact([
                    'fund_group_id' => $request->editfundID,
                    'keycontact_id' => 1,
                    'name' => $fundname,
                    'email' => $fundemail,
                    'phone_number' => $fundphonenumber
                ]);
                $fundKeyContact->save();
            }
        }
        return redirect()->back()->with(["alert-success" => "Funds Updated successfully! Thanks"]);
    }
    public function deletethesinglefundrecord(Request $request)
    {
        FundGroups::findOrFail($request->id)->delete();
        return redirect()->route('funds');
    }
    public function deletesubfundrecord(Request $request)
    {
     
        SubFunds::findOrFail($request->id)->delete();
        return redirect()->route('funds.subfunds');
    }
}
