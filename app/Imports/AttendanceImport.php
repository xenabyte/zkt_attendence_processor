<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Models\Attendance;
use App\Models\Staff;

use Log;
use Carbon\Carbon;

class AttendanceImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
        foreach ($collection as $key => $value) {
            //jumb the first row
            if($key > 0){
                $tauStaffId = 'TAU/'.$value[0];
                $date = carbon::parse($value[2]);
                $clockIn = $value[3];
                $clockOut = $value[4];

                //add the staff
                //check if the staff is already present
                $staff = Staff::where('tau_staff_id', $tauStaffId)->first();
                if(empty($staff)){
                    //create Staff
                    Staff::create(['tau_staff_id' => $tauStaffId]);
                    $staff = Staff::where('tau_staff_id', $tauStaffId)->first();
                }

                //add attendance
                //check if attendance have been added for the date
                $checkAttendance = Attendance::where('staff_id', $staff->id)->where('date', $date)->first();
                if(empty($checkAttendance)){
                    //add attendance
                    $status = null;
                    if(empty($clockOut) || empty($clockIn)){
                        $status = 0;
                    }elseif(empty($clockOut) && empty($clockIn)){
                        $status = null;
                    }else{
                        $status = 1;
                    }
                    $newAttendance = ([
                        'staff_id' => $staff->id,
                        'date' => $date,
                        'clock_in' => $clockIn,
                        'clock_out' => $clockOut,
                        'status' => $status,
                    ]);

                    $addAttendance = Attendance::create($newAttendance);
                }

            }
        }
    }
}
