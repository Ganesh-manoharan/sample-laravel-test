<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $current_datetime=now();
        $data=array(
            array('user_id'=>1,'role_id'=>2,'created_at'=>$current_datetime),
            array('user_id'=>2,'role_id'=>1,'created_at'=>$current_datetime),
            array('user_id'=>3,'role_id'=>2,'created_at'=>$current_datetime),
            );
            DB::table('user_roles')->insert($data);
    }
}
