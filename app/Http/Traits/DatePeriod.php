<?php

namespace App\Http\Traits;

use Illuminate\Support\Carbon;

trait DatePeriod
{
    public function get_dates($year, $period)
    {

        $month = date('m');
        if ($period == 'quarter') {
            if ($month >= 1 && $month <= 3) {
                $start_date = strtotime('1-January-' . $year);  // timestamp or 1-Januray 12:00:00 AM
                $end_date = strtotime('1-April-' . $year);  // timestamp or 1-April 12:00:00 AM means end of 31 March
            } else  if ($month >= 4 && $month <= 6) {
                $start_date = strtotime('1-April-' . $year);  // timestamp or 1-April 12:00:00 AM
                $end_date = strtotime('1-July-' . $year);  // timestamp or 1-July 12:00:00 AM means end of 30 June
            } else  if ($month >= 7 && $month <= 9) {
                $start_date = strtotime('1-July-' . $year);  // timestamp or 1-July 12:00:00 AM
                $end_date = strtotime('1-October-' . $year);  // timestamp or 1-October 12:00:00 AM means end of 30 September
            } else  if ($month >= 10 && $month <= 12) {
                $start_date = strtotime('1-October-' . $year);  // timestamp or 1-October 12:00:00 AM
                $end_date = strtotime('1-January-' . ($year + 1));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
            }
            $start_date = date('Y-m-d', $start_date);
            $end_date = date('Y-m-d', $end_date);
        }
        if ($period == 'month') {
            $start_date = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d'); //returns 2020-03-01
            $end_date = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');
        }
        if ($period == 'week') {
            $start_date = Carbon::create($year, $month, date('d'))->startOfWeek()->format('Y-m-d'); //returns 2020-03-01
            $end_date = Carbon::create($year, $month, date('d'))->endOfWeek()->format('Y-m-d');
        }
        if ($period == 'overall') {
            $start_date = Carbon::create($year)->startOfYear()->format('Y-m-d'); //returns 2020-03-01
            $end_date = Carbon::create($year)->endOfYear()->format('Y-m-d');
        }
        return [$start_date, $end_date];
    }
}
