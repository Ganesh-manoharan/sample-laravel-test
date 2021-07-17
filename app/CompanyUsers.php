<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CompanyUsers extends Model
{
    use SoftDeletes;
    protected $table = "company_users";
    protected $fillable = [
        'company_id','user_id'
    ];

    public function urgent_tasks()
    {
        return $this->hasManyThrough('App\Tasks','App\TaskUsers','company_user_id','id')->join('task_field_values','task_field_values.task_id','tasks.id')->where('task_field_values.task_field_id',25)->where('tasks.completion_status',0)->where('tasks.task_type',1)->select('tasks.*','task_field_values.date');
    }
}

?>
