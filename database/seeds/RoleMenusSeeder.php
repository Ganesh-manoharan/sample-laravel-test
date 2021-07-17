<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('role_menus')->truncate();
        $current_datetime = now();
        $data = array(
           
            array('role_id' => 2, 'menu_items_id' => 1, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 3, 'menu_items_id' => 1, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 2, 'menu_items_id' => 2, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 2, 'menu_items_id' => 3, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 2, 'menu_items_id' => 4, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 2, 'menu_items_id' => 5, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 2, 'menu_items_id' => 6, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 2, 'menu_items_id' => 7, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 2, 'menu_items_id' => 8, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 3, 'menu_items_id' => 2, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 3, 'menu_items_id' => 3, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 3, 'menu_items_id' => 4, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 1, 'menu_items_id' => 9, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 2, 'menu_items_id' => 10, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 5, 'menu_items_id' => 11, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 1, 'menu_items_id' => 12, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 2, 'menu_items_id' => 13, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 2, 'menu_items_id' => 14, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 2, 'menu_items_id' => 15, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 6, 'menu_items_id' => 15, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 6, 'menu_items_id' => 6, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 6, 'menu_items_id' => 7, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
            array('role_id' => 6, 'menu_items_id' => 8, 'created_at' => $current_datetime, 'updated_at' => $current_datetime),
        );
        DB::table('role_menus')->insert($data);
        DB::statement("SET foreign_key_checks=1");
    }
}
