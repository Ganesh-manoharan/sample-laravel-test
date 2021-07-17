<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldTYpesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('field_types')->truncate();
        $current_datetime=now();
        $data=array(
            array('code'=>'number','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('code'=>'text','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('code'=>'long_text','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('code'=>'date','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('code'=>'dropdown_value','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('code'=>'radio_button','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('code'=>'select2','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('code'=>'file','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            );
            DB::table('field_types')->insert($data);
        DB::statement("SET foreign_key_checks=1");
    }
}
