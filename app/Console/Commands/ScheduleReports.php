<?php

namespace App\Console\Commands;

use Mail;
use App\Report;
use App\Company;
use App\ReportList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\ReportSchedulingTrait;

class ScheduleReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:reports';

    use ReportSchedulingTrait;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to shcedule the reports for the clients based on the frequency';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         
          $companies = Company::all();

          foreach($companies as $company){
                $company_reports = Report::join('report_type','report.report_type_id','=','report_type.id')->select('report.*','report_type.code')->where('report.company_id', $company->id)->get();

                foreach($company_reports as $report){
                    try{
                        $reportJobStauts = ReportSchedulingTrait::checkCurrentRun($report);
                        if($reportJobStauts){
                            $generatedReports = ReportSchedulingTrait::getReportData($report);
                            $storageData = ReportSchedulingTrait::generateReportJs($generatedReports['data'], $company, $generatedReports['format']);
                            $status = ReportList::saveReport($report, $storageData);
                            if($status){
                                Report::updateReportStatus($report,1);
                            }else{
                                Report::updateReportStatus($report,0);
                            }
                        }
                    }catch(\Exception $e){
                        Log::info("report schedule error fix");
                        Log::debug($e);
                    }
                }
          }

          return true;
         
    }
}
