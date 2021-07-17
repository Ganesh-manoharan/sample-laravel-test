<?php

use App\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Roles::truncate();
        $current_datetime=now();
        $data=array(
            array('name'=>"Admin",'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            array('name'=>"System Admin",'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            array('name'=>"Basic User",'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            array('name'=>"Review User",'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            array('name'=>"Client User",'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            array('name'=>"Department Admin",'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            );
        DB::table('roles')->insert($data);
        DB::statement("SET foreign_key_checks=1");
    }
}
