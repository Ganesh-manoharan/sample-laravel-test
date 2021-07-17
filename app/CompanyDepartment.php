<?php
namespace App;

use App\Departments;
use Illuminate\Database\Eloquent\Model;

class CompanyDepartment extends Model
{
    protected $table = 'company_departments';
    protected $fillable = [
        'company_id','department_id','active_status'
    ];

    public function departments()
    {
        return $this->hasMany('App\Departments','id');
    }

    public static function storecompanydepartment($request,$id)
    {
    foreach ($request->departments1 as $item) {
        CompanyDepartment::create([
            'department_id' => $item,
            'company_id'=>$id
        ]);
    }
  } 

  public static function dpt_notWith_client($deps, $cmpId)
  {
      return CompanyDepartment::join('departments','departments.id','company_departments.department_id')->whereNotIn('company_departments.id', $deps)->where('company_departments.company_id',$cmpId)->select('company_departments.id as action_id','departments.*')->get();
  }
}
