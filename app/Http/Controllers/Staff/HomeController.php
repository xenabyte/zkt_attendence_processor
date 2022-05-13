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
        $staffs = Staff::with('attendance');

        $tauStaffId = Auth::guard('staff')->user()->tau_staff_id;

        return view('staff.home', [
            'staffs' => $staffs
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
}
