<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AttendanceImport;

use App\Models\Attendance;
use App\Models\Staff;
use App\Models\StaffClass;
use App\Models\StaffType;

use SweetAlert;
use Mail;
use Alert;
use Log;
use Carbon\Carbon;

class HomeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth:staff']);
    }

    public function index()
    {
        $staffId = Auth::guard('staff')->user()->id;
        $workingDays = $this->workingDays();
        $capturedWorkingDays = $this->capturedWorkingDays();
        //count attendance for present month
        $startDateOfPresentMonth = Carbon::now()->startOfMonth();
        $endDateOfPresentMonth = Carbon::now()->endOfMonth();
        $allPresentMonthAttendance = Attendance::where('staff_id', $staffId)->whereBetween('date', [$startDateOfPresentMonth, $endDateOfPresentMonth])->get();
        $presentMonthAttendance = Attendance::where('staff_id', $staffId)->where('status', 1)->whereBetween('date', [$startDateOfPresentMonth, $endDateOfPresentMonth])->get();
        $absentMonthAttendance = Attendance::where('staff_id', $staffId)->where('status', 0)->whereBetween('date', [$startDateOfPresentMonth, $endDateOfPresentMonth])->count();
        

        return view('staff.home', [
            'presentMonthAttendance' => $presentMonthAttendance,
            'absentMonthAttendance' => $absentMonthAttendance,
            'workingDays' => $workingDays,
            'allPresentMonthAttendance' => $allPresentMonthAttendance,
            'capturedWorkingDays' => $capturedWorkingDays,
        ]);
    }

    public function attendance()
    {
        $staffId = Auth::guard('staff')->user()->id;
        $attendances = Attendance::where('staff_id', $staffId)->orderBy('date')->get();

        return view('staff.attendance', [
            'attendances' => $attendances
        ]);
    }

    public function leaveDays() {

        return view('staff.leaveDays');
    }

    public function applyLeaveDays(Request $request) {


    }
}
