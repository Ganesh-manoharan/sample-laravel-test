<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FrequencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('frequency')->truncate();
        $datetime=now();
        $data=array(
            array('name'=>"Ad Hoc",'created_at'=> $datetime,'updated_at'=> $datetime),
            array('name'=>"Daily",'created_at'=>$datetime,'updated_at'=> $datetime),
            array('name'=>"Weekly",'created_at'=> $datetime,'updated_at'=> $datetime),
            array('name'=>"Monthly",'created_at'=> $datetime,'updated_at'=> $datetime),
            array('name'=>"Quarterly",'created_at'=> $datetime,'updated_at'=> $datetime),
            array('name'=>"Annually",'created_at'=> $datetime,'updated_at'=> $datetime),
            );  
        DB::table('frequency')->insert($data);
        DB::statement("SET foreign_key_checks=1");
    }
}
