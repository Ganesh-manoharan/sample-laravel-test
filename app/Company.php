<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    protected $table = "company";
    protected $fillable = [
        'company_name','contact_number','contact_email','regulatory_status','address_line_one','address_line_two','address_line_three',
        'address_line_four','company_logo','created_by','active_status'
    ];

    public  function fund_groups()
    {
        return $this->hasMany('App\CompanyFund','company_id')->join('fund_groups','company_funds.fund_group_id','=','fund_groups.id');
    }
    public  function company_departments()
    {
        return $this->hasMany('App\CompanyDepartment','company_id')->join('departments','departments.id','=','company_departments.department_id')->select('company_departments.*','departments.*');
    }

    public function sub_funds()
    {
        return $this->hasMany('App\SubFunds','fund_group_id');
    }
    public function companyusers()
    {
        return $this->hasMany('App\CompanyUsers','company_id')->join('users','users.id','=','company_users.user_id');
    }

    public function clientkeycontact()
    {
        return $this->hasMany('App\ClientKeyContacts','company_id');
    }
   
    public function company_fundgroups_count()
    {
        return $this->hasMany('App\CompanyFund');
    }

    public function company_sub_funds_count()
    {
        return $this->hasMany('App\CompanyFund')->join('sub_funds','sub_funds.fund_group_id','=','company_funds.fund_group_id');
    }

}
