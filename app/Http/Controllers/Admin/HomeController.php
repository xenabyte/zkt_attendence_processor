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

use App\Models\User;
use App\Models\Attendance;
use App\Models\Staff;
use App\Models\StaffClass;
use App\Models\StaffType;
use App\Models\Admin;

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

}
