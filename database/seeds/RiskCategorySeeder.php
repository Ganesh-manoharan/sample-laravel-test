<?php

use App\RiskCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiskCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        RiskCategory::truncate();
        $riskCategoryValues=array(
            [
                'title'=>'Operational Risk',
                'code'=>'operational_risk',
                'child'=>array(
                    [ 
                        'code'=>'processing_risk',
                        'title'=>'Processing Risk'
                    ],
                    [ 
                        'code'=>'business_continuity',
                        'title'=>'Business Continuity'
                    ],
                    [ 
                        'code'=>'information_technology',
                        'title'=>'Information Technology'
                    ],
                    [ 
                        'code'=>'information_security',
                        'title'=>'Information Security'
                    ],
                    [ 
                        'code'=>'data_management',
                        'title'=>'Data Management'
                    ],

                )
                ],
                [
                    'title'=>'Regulatory Compliance',
                    'code'=>'regulatory_compliance'
                ],
                [
                    'title'=>'Market Risk',
                    'code'=>'market_risk'
                ],
                [
                    'title'=>'Credit and Counterparty Risk',
                    'code'=>'credit_counterparty_risk'
                ],
                [
                    'title'=>'Credit and Counterparty Risk',
                    'code'=>'credit_counterparty_risk'
                ],
                [
                    'title'=>'Liquidity Risk',
                    'code'=>'liquidity_risk'
                ],
                [
                    'title'=>'Strategy Risk',
                    'code'=>'strategy_risk'
                ],
                [
                    'title'=>'Group Risk',
                    'code'=>'group_risk'
                ],
                [
                    'title'=>'Governance Risk',
                    'code'=>'governance_risk',
                    'child'=>array(
                        [ 
                            'code'=>'corporate_governance',
                            'title'=>'Corporate Governance'
                        ],
                        [ 
                            'code'=>'risk_governance',
                            'title'=>'Risk Governance'
                        ],
                        [ 
                            'code'=>'compliance_governance',
                            'title'=>'Compliance Governance'
                        ],
                        [ 
                            'code'=>'internal_audit',
                            'title'=>'Internal Audit'
                        ],
                        [ 
                            'code'=>'wind_down_planning',
                            'title'=>'Wind Down Planning'
                        ],
    
                    )
                ],
                [
                    'title'=>'Environmental  Risk',
                    'code'=>'environmental_risk'
                ],
                [
                    'title'=>'Conduct Risk',
                    'code'=>'conduct_risk'
                ]
            );

            foreach($riskCategoryValues as $category)
            {
                $categoryDetails['title']=$category['title'];
                $categoryDetails['code']=$category['code'];
                $RiskCategory=RiskCategory::create($categoryDetails);
                if(isset($category['child']))
                {
                    foreach($category['child'] as $childCategory)
                    {
                        $childCategoryDetails['parent_id']=$RiskCategory->id;
                        $childCategoryDetails['title']=$childCategory['title'];
                        $childCategoryDetails['code']=$childCategory['code'];
                        RiskCategory::create($childCategoryDetails);
                    }
                }
            }
        DB::statement("SET foreign_key_checks=1");
    }
}
