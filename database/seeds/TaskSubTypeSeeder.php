<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSubTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('task_sub_types')->truncate();
        $current_datetime=now();
        $data=array(
            array('task_type_id'=>1,'task_sub_type_name'=>'Task','code'=>'task','description'=>'New task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_type_id'=>2,'task_sub_type_name'=>'AML-Blocked Account','code'=>'AML','description'=>'Description of AML-Blocked Account','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_type_id'=>2,'task_sub_type_name'=>'Fraud Attempt','code'=>'FRA','description'=>'Description of Fraud Attempt','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_type_id'=>2,'task_sub_type_name'=>'Advertent Breach','code'=>'ADB','description'=>'Description of Advertent Breach','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_type_id'=>2,'task_sub_type_name'=>'Investor Complaint','code'=>'INC','description'=>'Description of Investor Complaint','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_type_id'=>2,'task_sub_type_name'=>'Material Nav Error','code'=>'MNE','description'=>'Description of Material Nav Error','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_type_id'=>3,'task_sub_type_name'=>'Risk Category','code'=>'RIC','description'=>'Description of Risk Category','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            );
            DB::table('task_sub_types')->insert($data);
            DB::statement("SET foreign_key_checks=1");
    }
}
