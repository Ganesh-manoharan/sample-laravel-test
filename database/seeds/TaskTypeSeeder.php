<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('task_types')->truncate();
        $current_datetime=now();
        $data=array(
            array('task_type_name'=>'Task','code'=>'task','description'=>'New task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_type_name'=>'Issue','code'=>'issue','description'=>'Issue for a task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_type_name'=>'Risk','code'=>'risk','description'=>'Risk for a task','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            );
            DB::table('task_types')->insert($data);
        DB::statement("SET foreign_key_checks=1");
    }
}
