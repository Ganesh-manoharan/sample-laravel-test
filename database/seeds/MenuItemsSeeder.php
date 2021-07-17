<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('menu_items')->truncate();
        $current_datetime=now();
        $selfvariable='_self';
        $data=array(
             array('menus_id'=>1,'title'=>'Home','url'=>'home','target'=>$selfvariable,'order'=>1,'icon_general'=>'img/sidebaricons/Home-icon.svg','icon_active'=>'img/sidebaricons/Home-icon_active.svg','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>1,'title'=>'Task','url'=>'task.form','target'=>$selfvariable,'order'=>2,'icon_general'=>'img/sidebaricons/task.svg','icon_active'=>'img/sidebaricons/task_active.svg','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>1,'title'=>'Teams','url'=>'teams','target'=>$selfvariable,'order'=>3,'icon_general'=>'img/sidebaricons/Customers-icon.svg','icon_active'=>'img/sidebaricons/Customers-icon_active.svg','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>1,'title'=>'Clients','url'=>'clients','target'=>$selfvariable,'order'=>4,'icon_general'=>'img/sidebaricons/Market-icon.svg','icon_active'=>'img/sidebaricons/Market-icon_active.svg','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>1,'title'=>'Funds','url'=>'funds','target'=>$selfvariable,'order'=>5,'icon_general'=>'img/sidebaricons/fund.svg','icon_active'=>'img/sidebaricons/fund_active.svg','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>2,'title'=>'View','url'=>'taskdetail','target'=>$selfvariable,'order'=>1,'icon_general'=>null,'icon_active'=>null,'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>2,'title'=>'Task Edit','url'=>'taskedit','target'=>$selfvariable,'order'=>2,'icon_general'=>null,'icon_active'=>null,'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>2,'title'=>'Reopen Task','url'=>'taskReopen','target'=>$selfvariable,'order'=>3,'icon_general'=>null,'icon_active'=>null,'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>1,'title'=>'Reports','url'=>'reports','target'=>$selfvariable,'order'=>6,'icon_general'=>'img/sidebaricons/report.svg','icon_active'=>'img/sidebaricons/report_active.svg','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>1,'title'=>'Documents','url'=>'document_index','target'=>$selfvariable,'order'=>7,'icon_general'=>'img/sidebaricons/document_inactive.svg','icon_active'=>'img/sidebaricons/document_active.svg','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>1,'title'=>'File Delivery','url'=>'ftp_docuements_index','target'=>$selfvariable,'order'=>8,'icon_general'=>'img/sidebaricons/document_inactive.svg','icon_active'=>'img/sidebaricons/document_active.svg','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>1,'title'=>'Companies','url'=>'admin_home','target'=>$selfvariable,'order'=>9,'icon_general'=>'img/sidebaricons/Customers-icon.svg','icon_active'=>'img/sidebaricons/Customers-icon_active.svg','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>1,'title'=>'Reports','url'=>'report_schedule','target'=>$selfvariable,'order'=>7,'icon_general'=>'img/sidebaricons/report.svg','icon_active'=>'img/sidebaricons/report_active.svg','created_at'=>$current_datetime,'updated_at'=>$current_datetime), 
             array('menus_id'=>1,'title'=>'Risk','url'=>'task.form','target'=>$selfvariable,'order'=>3,'icon_general'=>'img/sidebaricons/risk.svg','icon_active'=>'img/sidebaricons/risk_active.svg','created_at'=>$current_datetime,'updated_at'=>$current_datetime),
             array('menus_id'=>2,'title'=>'Delete','url'=>'taskedit','target'=>$selfvariable,'order'=>4,'icon_general'=>null,'icon_active'=>null,'created_at'=>$current_datetime,'updated_at'=>$current_datetime),
        );  
        DB::table('menu_items')->insert($data);
        DB::statement("SET foreign_key_checks=1");
    }
}
