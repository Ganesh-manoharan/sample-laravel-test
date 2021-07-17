<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('report_type')->truncate();
        $current_datetime=now();
        $data=array(
            array('name'=>'Audit','description'=>'To generate the audit reports','code'=> 'audit','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
	    array('name'=>'Risk','description'=>'To give the details of risk report','code'=> 'risk','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
	    array('name'=>'Issue','description'=>'To give the details of issue report','code'=> 'issue','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            array('name'=>'Activity','description'=>'To give the details of activity report','code'=> 'activity','created_at'=>$current_datetime,'updated_at'=>$current_datetime),

        );  
        DB::table('report_type')->insert($data);
        DB::statement("SET foreign_key_checks=0");
    }
}
