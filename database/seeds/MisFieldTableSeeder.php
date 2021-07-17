<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MisFieldTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::statement("SET foreign_key_checks=0");
        DB::table('mis_fields')->truncate();
        $current_datetime=now();
        $data=array(
            array('field_name'=>'text','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            array('field_name'=>'number','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            array('field_name'=>'dropdown','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            );
        DB::table('mis_fields')->insert($data);

        
        DB::statement("SET foreign_key_checks=1");
    }
}
