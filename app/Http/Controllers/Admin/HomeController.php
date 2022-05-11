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

use App\Models\User;
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

    public function index()
    {

        return view('admin.home');
    }


    public function staffs()
    {

        return view('admin.staffs');
    }

    public function uploadAttendance(Request $request){
        
        $validator = Validator::make(
            [
                'file' => $request->file,
                'extention' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extention' => 'required|in:xls'
            ]
        );

        if ($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        //explode xls file.
        $attendanceFile = $request->files;

    }

}
