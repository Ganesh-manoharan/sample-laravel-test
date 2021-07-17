<?php

use App\DocumentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        
        DocumentType::truncate();
        $current_datetime=now();
        $data=array(
            array('name'=>"Regulation/Guidance",'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            array('name'=>"Legislation",'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            array('name'=>"Policy",'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            array('name'=>"Business Plan",'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
            array('name'=>"Program of Activity",'created_at'=>$current_datetime,'updated_at'=>$current_datetime)
            );  
        DB::table('document_type')->insert($data);
        
        DB::statement("SET foreign_key_checks=1");
        
    }
}

?>
