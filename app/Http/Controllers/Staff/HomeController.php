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
use App\Models\Leave;
use App\Models\Holiday;

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
        $allPresentMonthAttendance = Attendance::with('leave')->where('staff_id', $staffId)->whereBetween('date', [$startDateOfPresentMonth, $endDateOfPresentMonth])->get();
        $presentMonthAttendance = Attendance::with('leave')->where('staff_id', $staffId)->where('status', 1)->whereBetween('date', [$startDateOfPresentMonth, $endDateOfPresentMonth])->get();
        $absentMonthAttendance = Attendance::with('leave')->where('staff_id', $staffId)->where('status', 0)->whereBetween('date', [$startDateOfPresentMonth, $endDateOfPresentMonth])->count();
        

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
        $attendances = Attendance::with('leave')->where('staff_id', $staffId)->orderBy('date')->get();

        return view('staff.attendance', [
            'attendances' => $attendances
        ]);
    }

    public function leaveDays() {

        $staffId = Auth::guard('staff')->user()->id;

        $leaves = Leave::where('staff_id', $staffId)->get();

        return view('staff.leaveDays', [
            'leaves' => $leaves,
        ]);
    }

    public function applyLeaveDays(Request $request) {

        $validator = Validator::make($request->all(), [
            'purpose' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $staffId = Auth::guard('staff')->user()->id;

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }
        
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        if($startDate == $endDate || $startDate > $endDate) {
            alert()->error('Error', 'Invalid leave application, review your leave starting date and resumption date')->persistent('Close');
            return redirect()->back();
        }

        $days = $startDate->diffInDays($endDate) - $this->countWeekendDays($startDate, $endDate);

        $newLeaveApplication = ([
            'staff_id' => $staffId,
            'purpose' => $request->purpose,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days' => $days,
        ]);

        if(Leave::create($newLeaveApplication)){
            alert()->success('Success', 'Leave Application Submitted Successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Error', 'Error Submitting Leave Application, Report to Administrator')->persistent('Close');
        return redirect()->back();

    }

    public function deleteLeave(Request $request){
        if(!$holiday = Leave::where('id', $request->holidayId)->where('status', null)->first()) {
            alert()->error('Error', 'Invalid Leave')->persistent('Close');
            return redirect()->back();
        }

        if($holiday->delete()){
            alert()->success('Good', 'Leave deleted successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Error', 'Invalid Leave')->persistent('Close');
        return redirect()->back();
    }
}
