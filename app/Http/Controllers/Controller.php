<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Log;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function capturedWorkingDays(){

        $startDateOfPresentMonth = Carbon::now()->startOfMonth();
        $today = Carbon::now();
        $diff = $startDateOfPresentMonth->diffInDays($today);
        $weekendDays = $this->countWeekendDays($startDateOfPresentMonth, $today); 
        $capturedWorkingDays = $diff - $weekendDays;

        return $capturedWorkingDays;

    }

    public function workingDays() {
        $startDateOfPresentMonth = Carbon::now()->startOfMonth();
        $endDateOfPresentMonth = Carbon::now()->endOfMonth();
        $daysOfPresentMonth = Carbon::now()->daysInMonth;
        $weekendDays = $this->countWeekendDays($startDateOfPresentMonth, $endDateOfPresentMonth); 

        $workingDays = $daysOfPresentMonth - $weekendDays;

        return $workingDays;
    }

    public function countWeekendDays($startDate, $endDate) {
        $weekendDays = $startDate->diffInDaysFiltered(function(Carbon $date) {
            return $date->isWeekend();
        }, $endDate);

        return $weekendDays;
    }
}
