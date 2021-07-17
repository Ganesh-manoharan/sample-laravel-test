<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('tag_types')->truncate();
        $current_datetime=now();
        $data=array(
            array('name'=>'Report tags','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('name'=>'Executive summary-report tag1','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('name'=>'Department summary-report tag2','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('name'=>'Action log-report tag3','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            );
            DB::table('tag_types')->insert($data);
            DB::statement("SET foreign_key_checks=1");
    }
}
