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
        $weekendDays = $startDateOfPresentMonth->diffInDaysFiltered(function(Carbon $date) {
            return $date->isWeekend();
        }, $today);

        $capturedWorkingDays = $diff - $weekendDays;

        return $capturedWorkingDays;

    }

    public function workingDays() {
        $startDateOfPresentMonth = Carbon::now()->startOfMonth();
        $endDateOfPresentMonth = Carbon::now()->endOfMonth();
        $daysOfPresentMonth = Carbon::now()->daysInMonth;
        $weekendDays = $startDateOfPresentMonth->diffInDaysFiltered(function(Carbon $date) {
            return $date->isWeekend();
        }, $endDateOfPresentMonth);

        $workingDays = $daysOfPresentMonth - $weekendDays;

        return $workingDays;
    }
}
