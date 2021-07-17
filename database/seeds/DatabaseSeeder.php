<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TagTableSeeder::class);
        //  $this->call(RoleTableSeeder::class);
        //  $this->call(FrequencyTableSeeder::class);
        //  $this->call(CountriesTableSeeder::class);
        //  $this->call(CityTableSeeder::class);
        //  $this->call(DocumentTypeTableSeeder::class);
        //  $this->call(MisFieldTableSeeder::class);

          $this->call(MenuItemsSeeder::class);
          $this->call(MenuSeeder::class);
        //  $this->call(DataKeySeeder::class);
        //  $this->call(TaskTypeSeeder::class);
       //  $this->call(TaskFormFieldGroupSeeder::class);
        //  $this->call(FieldTYpesSeeder::class);
        //  $this->call(TaskSubTypeSeeder::class);
        //  $this->call(TaskFieldsSeeder::class);
        //  $this->call(TaskTypeFields::class);
        //  $this->call(FieldDropDownSeeder::class);
        $this->call(ReportType::class);
          // $this->call(TagTableSeeder::class);
        //  $this->call(RiskCategorySeeder::class);
         $this->call(RoutePermissionSeeder::class);
          // $this->call(ReportType::class);
          // $this->call(UserSeeder::class);
    }
}
