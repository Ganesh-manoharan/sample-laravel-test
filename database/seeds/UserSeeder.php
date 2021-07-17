<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        
        DB::table('users')->truncate();
        DB::table('user_roles')->truncate();
        $current_datetime=now();
        $users=array(
            
            array("name"=>"w7pOw7fDrcOARsKhw6DCkE8MecOvFh4BXwZlXG7Cs8KMYAscPg3DqsKNfMOs",'avatar' => 'img/user-avatar.png',"email"=>"woDDk8K8bcKHb8K5H2lFwpPDnxXDtQxpw6BrYRoyM1rCnsO5w7k\/w4p6wrMFdxLCl8OxGRcQw4J+Nm3Cl8Klw57Ct3PDgg==","email_hash"=>"7738e879ff98163dcbeb74d69fb607019f4dd3f11a600ee0ef5c890ad565eca3","password"=>"$2y$10$5TdJU3j\/502AO19bj9jBk.Nru3s2OKI.G8ypSd2v8mW7XhwU0z1ZC",'created_at'=>$current_datetime),
            array("name"=>"XFAxworDrnx2w7Rew6DChcOkAsOZX8O9w4QSYsOweG8ZUWQrNMO8McK8Yxs=",'avatar' => 'img/user-avatar.png',"email"=>"w4F6NFcbwpMDw63DkyjDn8KiZMOGOsK8CBoEPUHCpSBGw4\/Ch8KdI8Oiw6bCqMOUw6nCuMOswrLDmnHCnnvCqcKWw7xhaUwpVw==","email_hash"=>"ca89ff51a8d10abfa0db8f14277a150c88788806b68a723f2ea1b490fbc47ea1","password"=>'$2y$10$WaY7jYUW8EaQjYj\/kyUDDeaHCQe03GFDO2WaA5RDdDaLPd84zKmWW',"created_at"=>$current_datetime),
            array("name"=>"w6YEe8OTS8KZw7jCiwxWwpAww7TDi8Krw7LDhQFcwr7Dv8OpJ8KJZyzCtsOXwozClj7CrA==",'avatar' => 'img/user-avatar.png',"email"=>"w5Vywpc8O24Jw6lKC8KFw7FHKE1GdB7Cl8KPw6kFK8Kmw5Qqw5wsZFjCr8OYN8OULyDCk8KjwqLCiSQLwrhNWkpmwr4=","email_hash"=>"ed1e92d0f0edb8edc8a2624711232b952cedeeea78344fc07100abcb05062602","password"=>'$2y$10$xfVEC8ZE9eQUTKMkFmHul.o49lyamjg9m7a6\/5GQZHKUlMDnoqv0K',"created_at"=>$current_datetime),
            array("name"=>"woTCk8KywpJKwoPCpXnDuzdxw49vccKww5TDqMKlwodwwq7Dk1wzwozCm8OLYBHDqsOYw7I=",'avatar' => 'img/user-avatar.png',"email"=>"w5kyw6nCjcKVJwTCgMK1w5QNw4sswopZwo7Dq8OGw5cAw7HDjl\/DqzUHC8KlwrfCnVx\/ZgPDlMKlUAFBw4INK15KB1tIw6Q=","email_hash"=>"fab9596454b82222c7da2c75904385d62bf873382c718cf42c8bcfcfc9389f78","password"=>'$2y$10$irly95C5RhEDy5CG6sC3VepplGimDTCB6Pgze9kfR9eP377sDa7bC',"created_at"=>$current_datetime),
            array("name"=>"acOkTsKtwqXDoTV4wqJJIMOuwoPCq3fDr17DgMOzKQ8PV8O\/V8O9wqTDhSDCtUcf",'avatar' => 'img/user-avatar.png',"email"=>"asOCw4kZwpAwwplkw75Gw4fCpQTCvF7CkB5Swpd6BMKOA8ONwp7DqwdNNsKmwrkbw6vDhMKpworCjQHDqsK7TMK4ZMK+wpLDkcKuwqY=","email_hash"=>"ba12470dddbb46a32a45f4ad464765838085d6960e7aae1b5293e41300f5f2ad","password"=>'$2y$10$pu2eytEwPtlhhUs.dF.9\/.5K0TGwGFBZVVHCOpUTAU8djlOsNWnFS',"created_at"=>$current_datetime),
            array("name"=>"wrxTEsKCwpjCq8KqEAh+JglfFsKMF8Oww5HDk8OTwpvDncKMwp\/Cl8Kiw5sWwqkBw4Qj",'avatar' => 'img/user-avatar.png',"email"=>"JxbCjMKeXXRUX2DCs8OZT8Olwr\/CjUx\/aj\/DqcKdw6ckVS\/CjMKuUMOlBA7CtsOGMsOEw6fCpQcCE8O5w4EqbMODw4V2wrY=","email_hash"=>"1eb123c2207b0be86275e2a38860aae8c248d1db086ea070d2206a4b26ee3020","password"=>'$2y$10$DG8k4MYqTHI5i0gyaQSknOBG\/6R5JD4QyswoRe\/\/JJ0IT9BYnZ7bO',"created_at"=>$current_datetime),
            array("name"=>"woc0w4UsHsKbJ8KYBi3CiAVcVzY0Rhc6w5R1dsK7wrR6csOmw7XCs8O1S8KG",'avatar' => 'img/user-avatar.png',"email"=>"w4QlTcOZw4VDVlJfwobCjTDCmsOvfMO+wrvCisOCw7\/DkXvDlsKpwrooSRPCrnHDtCXCmMKTw7tQTMONw7DDkcK9X8O6CldAw6Aq","email_hash"=>"ad5cadef61eb47e059701461feb734b63c166eba1f5660b97fdc5cce1fc01406","password"=>'$2y$10$lhIjOqyr1GahIVsjJ0IdnOEaRjZcS7UXVB5bpwB8bE.E\/23puRQi2',"created_at"=>$current_datetime),

        );


        $roles=array(
                  array("user_id"=>1,"role_id"=>1),
                  array("user_id"=>2,"role_id"=>1),
                  array("user_id"=>3,"role_id"=>1),
                  array("user_id"=>4,"role_id"=>1),
                  array("user_id"=>5,"role_id"=>1),
                  array("user_id"=>6,"role_id"=>1),
		  array("user_id"=>7,"role_id"=>1),
        );
            DB::table('users')->insert($users);
            DB::table('user_roles')->insert($roles);
            DB::statement("SET foreign_key_checks=1");
    }
}
