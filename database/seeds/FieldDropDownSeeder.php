<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldDropDownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('field_dropdown_values')->truncate();
        $current_datetime=now();
        $data=array(
            array('task_field_id'=>7,'dropdown_name'=>'Yes','code'=>'yes','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>7,'dropdown_name'=>'No','code'=>'no','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>8,'dropdown_name'=>'Material Event-Significant Impact','code'=>'material_event_si','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>8,'dropdown_name'=>'Material Event','code'=>'material_event','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>8,'dropdown_name'=>'Non Material - Reportable','code'=>'non_material_reportable','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>8,'dropdown_name'=>'Non Material - not Reportable','code'=>'non_material_not_reportable','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>8,'dropdown_name'=>'Minor Issue','code'=>'minor_issue','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>12,'dropdown_name'=>'Internal','code'=>'internal','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>12,'dropdown_name'=>'External','code'=>'external','created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>14,'dropdown_name'=>'Required','code'=>1,'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>14,'dropdown_name'=>'Optional','code'=>2,'created_at'=>$current_datetime,'updated_at' => $current_datetime),
            array('task_field_id'=>14,'dropdown_name'=>'Not Required','code'=>0,'created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>15,'dropdown_name'=>'0-3 Months','code'=>'3_months','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>18,'dropdown_name'=>'Acceptance','code'=>'acceptance','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>18,'dropdown_name'=>'Avoidance','code'=>'avoidance','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>18,'dropdown_name'=>'Transfer','code'=>'transfer','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>18,'dropdown_name'=>'Reduction','code'=>'reduction','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>19,'dropdown_name'=>'Extreme','code'=>'extreme','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>19,'dropdown_name'=>'Major','code'=>'major','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>19,'dropdown_name'=>'Moderate','code'=>'moderate','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>19,'dropdown_name'=>'Minor','code'=>'minor','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>19,'dropdown_name'=>'Incidental','code'=>'incidental','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>20,'dropdown_name'=>'Very Low','code'=>'very_low','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>20,'dropdown_name'=>'Low','code'=>'low','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>20,'dropdown_name'=>'Medium','code'=>'medium','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>20,'dropdown_name'=>'High','code'=>'high','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>20,'dropdown_name'=>'Very High','code'=>'very_high','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>21,'dropdown_name'=>'Rare','code'=>'rare','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>21,'dropdown_name'=>'Unlikely','code'=>'unlikely','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>21,'dropdown_name'=>'Possible','code'=>'possinle','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>21,'dropdown_name'=>'Likely','code'=>'likely','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>21,'dropdown_name'=>'Almost Certain','code'=>'almost_creation','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>22,'dropdown_name'=>'Inadequate','code'=>'inadequate','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>22,'dropdown_name'=>'Deficient','code'=>'deficient','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>22,'dropdown_name'=>'Enhancements Needed','code'=>'enhancements_needed','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>22,'dropdown_name'=>'Satisfactory','code'=>'satisfactory','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>22,'dropdown_name'=>'Strong','code'=>'strong','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>17,'dropdown_name'=>'Very Low','code'=>'very_low','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>17,'dropdown_name'=>'Low','code'=>'low','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>17,'dropdown_name'=>'Medium','code'=>'medium','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>17,'dropdown_name'=>'High','code'=>'high','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>17,'dropdown_name'=>'Very High','code'=>'very_high','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>26,'dropdown_name'=>'Ad Hoc','code'=>'adhoc','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>26,'dropdown_name'=>'Daily','code'=>'daily','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>26,'dropdown_name'=>'Weekly','code'=>'weekly','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>26,'dropdown_name'=>'Monthly','code'=>'monthly','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>26,'dropdown_name'=>'Quarterly','code'=>'quarterly','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>26,'dropdown_name'=>'Annually','code'=>'annually','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>34,'dropdown_name'=>'Regulation/Guidance','code'=>'regulation_guidance','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>34,'dropdown_name'=>'Legislation','code'=>'legislation','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>34,'dropdown_name'=>'Policy','code'=>'policy','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>34,'dropdown_name'=>'Business Plan','code'=>'business_plan','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>34,'dropdown_name'=>'Program of Activity','code'=>'program_activity','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>23,'dropdown_name'=>'Very Low','code'=>'very_low','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>23,'dropdown_name'=>'Low','code'=>'low','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>23,'dropdown_name'=>'Medium','code'=>'medium','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>23,'dropdown_name'=>'High','code'=>'high','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>23,'dropdown_name'=>'Very High','code'=>'very_high','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Advertent Breach','code'=>'advertent_breach','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>43,'dropdown_name'=>'Increasing','code'=>'increasing','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>43,'dropdown_name'=>'Decreasing','code'=>'decreasing','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>43,'dropdown_name'=>'Stable','code'=>'stable','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>16,'dropdown_name'=>'0 - 3 Months','code'=>'0_3_month','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>16,'dropdown_name'=>'3 - 9 Monts','code'=>'0_9_months','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>16,'dropdown_name'=>'Greater than 12','code'=>'greater_than_12','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Inadvertent Breach','code'=>'inadvertent_breach','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Poor Performance','code'=>'poor_performance','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Cyber event/ Data Breach','code'=>'cyber_event','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Business Resiliency','code'=>'business_resiliency','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Liquidity','code'=>'liquidity','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'NAV Errors','code'=>'nav_rrrors','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Cash Recon Issues','code'=>'cash_recon_issues','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Stale Pricing','code'=>'stale_pricing','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Service Issues','code'=>'service_issues','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Investor Service - missed deal','code'=>'investor_service','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'AML','code'=>'aml','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Settlement Issues','code'=>'settlement_issues','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Tax Issues','code'=>'tax_issues','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'IT Issues','code'=>'it_issues','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             array('task_field_id'=>46,'dropdown_name'=>'Other Issue Type','code'=>'other_issue','created_at'=>$current_datetime,'updated_at' => $current_datetime),
             
            );
            DB::table('field_dropdown_values')->insert($data);
            DB::statement("SET foreign_key_checks=1");
    }
}
