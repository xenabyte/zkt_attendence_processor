<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\Admin;
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
        $this->middleware(['auth:admin']);
    }

    public function index()
    {
        $staffs = Staff::with('attendance');

        $capturedWorkingDays = $this->capturedWorkingDays();
        $pendingLeaveApplicationCount = Leave::where('status', null)->count();

        return view('admin.home', [
            'staffs' => $staffs,
            'capturedWorkingDays' => $capturedWorkingDays,
            'pendingLeaveApplicationCount' => $pendingLeaveApplicationCount,
        ]);
    }


    public function staffs()
    {
        $year = Carbon::parse()->format('Y');
        $month = Carbon::parse()->format('M');

        $staffRecords = Staff::all();
        $staffs = array();
        foreach ($staffRecords as $staffRecord){
            $staff = $staffRecord;
            $staffId = $staffRecord->id;

            $attendance = Attendance::where('staff_id', $staffId)->where('year', $year)->where('month', $month)->where('status', 2)->get();
            $staff->attendance = $attendance;

            $leaveDays = Attendance::where('staff_id', $staffId)->where('year', $year)->where('month', $month)->where('status', 2)->where('leave_id', '!=', Null)->count();
            $staff->leaveDays = $leaveDays;


            $staffs[] = $staff;
        }


        $pendingLeaveApplicationCount = Leave::where('status', null)->count();

        return view('admin.staffs', [
            'staffs' => $staffs,
            'pendingLeaveApplicationCount' => $pendingLeaveApplicationCount,
        ]);
    }

    public function uploadAttendance(Request $request){
        
        $validator = Validator::make(
            [
                'file' => $request->file,
                'extention' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extention' => 'required|in:xlsx'
            ]
        );


        // $attendanceFile = 'uploads/attendance/'.$request->file('file')->getClientOriginalName(); 
        // $MoveAttendanceFile = $request->file('file')->move('uploads/attendance', $attendanceFile);
        if ($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        //explode xls file.
        $attendanceFile = $request->file;
        //importing xlx file into attendance imports
        if(Excel::import(new AttendanceImport, $attendanceFile)){
            alert()->success('Good', 'Attendance uploaded successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Error', 'Attendance upload not successful')->persistent('Close');
        return redirect()->back();
    }

    public function monthlyAttendance($staffId)
    {
        $startDateOfPresentMonth = Carbon::now()->startOfMonth();
        $endDateOfPresentMonth = Carbon::now()->endOfMonth();

        $monthAttendance = Attendance::with('leave')->where('staff_id', $staffId)->whereBetween('date', [$startDateOfPresentMonth, $endDateOfPresentMonth])->get();
        $staff = Staff::find($staffId);
        $pendingLeaveApplicationCount = Leave::where('status', null)->count();


        return view('admin.monthlyAttendance', [
            'monthAttendance' => $monthAttendance,
            'staff' => $staff,
            'pendingLeaveApplicationCount' => $pendingLeaveApplicationCount,
        ]);
    } 

    public function pastAttendance($staffId)
    {
        $staff = Staff::find($staffId);
        $pendingLeaveApplicationCount = Leave::where('status', null)->count();

        return view('admin.pastAttendance', [
            'staff' => $staff,
            'pendingLeaveApplicationCount' => $pendingLeaveApplicationCount,
        ]);
    }

    public function pastAttendanceRecords (Request $request){
        $staffId = $request->staffId;
        $dateMonth = $request->dateMonth;

        $year = Carbon::parse($dateMonth)->format('Y');
        $month = Carbon::parse($dateMonth)->format('M');

        $staff = Staff::find($staffId);

        $attendances = Attendance::with('leave')->where('staff_id', $staffId)->where('year', $year)->where('month', $month)->where('status', 2)->get();
        $totalPresentdays = Attendance::with('leave')->where('staff_id', $staffId)->where('year', $year)->where('month', $month)->where('status', 1)->count();
        $pendingLeaveApplicationCount = Leave::where('status', null)->count();

        return view('admin.pastAttendance', [
            'staff' => $staff,
            'year' => $year,
            'month' => $month,
            'attendances' => $attendances,
            'totalPresentdays' => $totalPresentdays,
            'pendingLeaveApplicationCount' => $pendingLeaveApplicationCount,
        ]);

    }

    public function pastGeneralAttendanceRecords(Request $request){
        $dateMonth = $request->dateMonth;
        $year = Carbon::parse($dateMonth)->format('Y');
        $month = Carbon::parse($dateMonth)->format('M');
        $staffRecords = Staff::all();
        $staffs = array();
        foreach ($staffRecords as $staffRecord){
            $staff = $staffRecord;
            $staffId = $staffRecord->id;

            $attendance = Attendance::with('leave')->where('staff_id', $staffId)->where('year', $year)->where('month', $month)->where('status', 2)->get();
            $staff->attendance = $attendance;

            $leaveDays = Attendance::where('staff_id', $staffId)->where('year', $year)->where('month', $month)->where('status', 1)->where('leave_id', '!=', Null)->count();
            $staff->leaveDays = $leaveDays;

            $staffs[] = $staff;
        }

        $pendingLeaveApplicationCount = Leave::where('status', null)->count();

        return view('admin.staffs', [
            'staffs' => $staffs,
            'year' => $year,
            'month' => $month,
            'pendingLeaveApplicationCount' => $pendingLeaveApplicationCount,
        ]);

    }

    public function updateAttendance($attendanceId)
    {
        $startDateOfPresentMonth = Carbon::now()->startOfMonth();
        $endDateOfPresentMonth = Carbon::now()->endOfMonth();

        $attendance = Attendance::where('id', $attendanceId)->update(['status' => 2]);
        
        alert()->success('Good', 'Attendance Update successfully')->persistent('Close');
        return redirect()->back();
    }

    public function leaveApplication() {

        $leaves = Leave::with('staff')->get();
        $pendingLeaveApplicationCount = Leave::where('status', null)->count();

        return view('admin.leaveApplication', [
            'leaves' => $leaves,
            'pendingLeaveApplicationCount' => $pendingLeaveApplicationCount,
        ]);
    }

    public function manageLeaveApplication(Request $request) {
        if(empty($request->status)){
            alert()->error('Error', 'Please select and action')->persistent('Close');
            return redirect()->back();
        }

        if(!$leave = Leave::find($request->leaveId)){
            alert()->error('Error', 'Invalid Leave Application')->persistent('Close');
            return redirect()->back();
        }

        $leave->status = $request->status;

        if($leave->save()){
            alert()->success('Good', 'Leave Update successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Error', 'Invalid Leave Application')->persistent('Close');
        return redirect()->back();

    }

    public function holiday() {
        $holidays = Holiday::all();
        $pendingLeaveApplicationCount = Leave::where('status', null)->count();

        return view('admin.holiday', [
            'holidays' => $holidays,
            'pendingLeaveApplicationCount' => $pendingLeaveApplicationCount,
        ]);
    }

    public function addHoliday(Request $request) {
        $validator = Validator::make($request->all(), [
            'purpose' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);


        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }
        
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        if($startDate == $endDate || $startDate > $endDate) {
            alert()->error('Error', 'Invalid holiday, review holiday starting date and resumption date')->persistent('Close');
            return redirect()->back();
        }

        $days = $startDate->diffInDays($endDate) - $this->countWeekendDays($startDate, $endDate);

        $newHoliday = ([
            'purpose' => $request->purpose,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days' => $days,
        ]);

        if(Holiday::create($newHoliday)){
            alert()->success('Success', 'Holiday Created Successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Error', 'Error Creating Holiday, Report to Administrator')->persistent('Close');
        return redirect()->back();

    }

    public function deleteHoliday(Request $request){
        if(!$holiday = Holiday::find($request->holidayId)){
            alert()->error('Error', 'Invalid Holiday')->persistent('Close');
            return redirect()->back();
        }

        if($holiday->delete()){
            alert()->success('Good', 'Holiday deleted successfully')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Error', 'Invalid Holiday')->persistent('Close');
        return redirect()->back();
    }

}
