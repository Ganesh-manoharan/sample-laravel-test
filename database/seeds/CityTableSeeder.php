<?php

use App\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        
        City::truncate();
        $current_datetime=now();
        $data=array(
            array('city_name'=>'Kabul','country_id'=>1,'created_at'=> $current_datetime,'updated_at'=> $current_datetime),
            array('city_name'=>'Tirana','country_id'=>2,'created_at'=> $current_datetime,'updated_at'=> $current_datetime),
            array('city_name'=>'Algiers','country_id'=>3,'created_at'=> $current_datetime,'updated_at'=> $current_datetime),
            array('city_name'=>'Andorra la Vella','country_id'=>4,'created_at'=> $current_datetime,'updated_at'=> $current_datetime)
            );  
        DB::table('city')->insert($data);
        DB::statement("SET foreign_key_checks=1");
    }
}
