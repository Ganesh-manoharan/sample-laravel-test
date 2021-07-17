<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\Base64ToImage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use Base64ToImage;
    use SoftDeletes;
    protected $table = "clients";
    protected $fillable = [
        'client_name','description','phone_number','email','address_line_one','address_line_two',
        'zip_code','client_logo','city_id','country_id','deadline_priority','regulated_status','created_by'
    ];

    public  function client_departments()
    {
        return $this->hasMany('App\ClientDepartment','client_id')->with('departments');
    }

    public function client_fundgroups_count()
    {
        return $this->hasMany('App\ClientFundGroup');
    }

    public function client_sub_funds_count()
    {
        return $this->hasMany('App\ClientFundGroup')->join('company_fund_groups','company_fund_groups.id','client_fund_groups.company_fund_group_id')->join('sub_funds','sub_funds.fund_group_id','=','company_fund_groups.fund_group_id');
       
    }

    public function clientkeycontact()
    {
        return $this->hasMany('App\ClientKeyContacts','client_id');
    }

    public static function save_client($request)
    {
        try{
            $clientDetails = new Client([
                'client_name' => $request->clientName,
                'description' => $request->shortDescriptions,
                'email' => $request->clientEmail,
                'regulated_status' => $request->regulated_status,
                'created_by' => $request->get('cmpUsrId')
            ]);
            if ($request->upload_icon) {
                $image = self::base64todata($request->upload_icon);
                $path = 'company_icon/' . Carbon::now()->month . '/';
                $filename = random_int(1,1000) . '-' . time() . '.' . $image['extension'];
                Storage::disk('s3')->put($path . $filename, (string)$image['data'], 'public');
                $clientDetails->client_logo = $path . $filename;
            }
            $clientDetails->save();
            return ["isError" => false, "data"=>$clientDetails->id];
        }catch(\Exception $e){
            return ["isError" => true, "errorInfo"=>$e->getMessage()];
        }
    }
}
