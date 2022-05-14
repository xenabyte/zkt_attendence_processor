<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
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
use Validator;

class HomeController extends Controller
{
    //

    public function completeRegistration(Request $request){

        $validator = Validator::make($request->all(), [
            'tau_staff_id' => 'required|max:255',
            'lastname' => 'required|max:255',
            'firstname' => 'required|max:255',
            'phone_number' => 'required|min:11',
            'email'=> 'required|max:255',
            'date_of_birth'=> 'required',
            'password' => 'required',
            'confirm_password' => 'required',
            'role' => "required",
            'class'=> 'required',
            'type'=>'required',
            'faculty' =>'required',
            'dept' =>'required',
            'file' => 'required|file|mimes:jpg,png,gif,jpeg|max:4096',
        ]);

        if($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        $tauStaffId = $request->tau_staff_id;

        if(empty(strpos($tauStaffId, 'AU/'))) {
            alert()->error('Error', 'Invalid staff ID, please kindly follow the format')->persistent('Close');
            return redirect()->back();
        }

        if(empty(strpos($request->email, 'tau.edu.ng'))) {
            alert()->error('Error', 'Invalid Staff Email')->persistent('Close');
            return redirect()->back();
        }
        
        //get staff information
        $staff = Staff::where('tau_staff_id', $tauStaffId)->first();
        if(!$staff){
            alert()->error('Error', 'Invalid staff ID, no staff record found')->persistent('Close');
            return redirect()->back();
        }

        if(!empty($staff->password)){
            alert()->info('Opps', 'Profile already updated, kindly login.')->persistent('Close');
            return redirect()->back();
        }

        //check if password is valid
        if($request->password != $request->confirm_password){
            alert()->error('Error', 'Password Mismatch')->persistent('Close');
            return redirect()->back();
        }

        $imageUrl = 'uploads/staff/'.md5($tauStaffId).$request->file('file')->getClientOriginalName(); 
        $image = $request->file('file')->move('uploads/staff', $imageUrl);
        

        $staff->lastname = $request->lastname;
        $staff->firstname = $request->firstname;
        $staff->middlename = $request->middlename;
        $staff->phone_number = $request->phone_number;
        $staff->email = $request->email;
        $staff->date_of_birth = $request->date_of_birth;
        $staff->password = bcrypt($request->password);
        $staff->job_specification = $request->role;
        $staff->class = StaffClass::where('class', $request->class)->value('id');
        $staff->type = StaffType::where('type', $request->type)->value('id');
        $staff->faculty = $request->faculty;
        $staff->department = $request->dept;
        $staff->image = $imageUrl;

        if($staff->save()){
            alert()->success('Good Job', 'Profile updated, kindly login to access attendance records')->persistent('Close');
            return redirect()->back();
        }

        alert()->error('Error', 'Error Updating staff profile, please try again')->persistent('Close');
        return redirect()->back();

        //

    }
}
