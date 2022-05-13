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

        return view('admin.home', [
            'staffs' => $staffs
        ]);
    }


    public function staffs()
    {
        $Staffs = Staff::with('attendance')->get();

        return view('admin.staffs', [
            'staffs' => $Staffs
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

        $monthAttendance = Attendance::where('staff_id', $staffId)->whereBetween('date', [$startDateOfPresentMonth, $endDateOfPresentMonth])->get();
        $staff = Staff::find($staffId);


        return view('admin.monthlyAttendance', [
            'monthAttendance' => $monthAttendance,
            'staff' => $staff
        ]);
    } 

    public function pastAttendance($staffId)
    {
        $staff = Staff::find($staffId);

        return view('admin.pastAttendance', [
            'staff' => $Staff
        ]);
    }

    public function updateAttendance($attendanceId)
    {
        $startDateOfPresentMonth = Carbon::now()->startOfMonth();
        $endDateOfPresentMonth = Carbon::now()->endOfMonth();

        $attendance = Attendance::where('id', $attendanceId)->update(['status' => 1]);
        
        alert()->success('Good', 'Attendance Update successfully')->persistent('Close');
        return redirect()->back();
    }
}
