<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Models\Attendance;
use App\Models\Staff;

use Log;
use Carbon\Carbon;
use App\Models\Leave;

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
                $name = $value[1];
                $date = carbon::parse($value[2]);
                $year = carbon::parse($value[2])->format('Y');
                $month = carbon::parse($value[2])->format('M');
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

                if(empty($staff->firstname)){
                    $splitedName = $this->splitName($name);
                    $firstName = $splitedName->firstname;
                    $lastName = $splitedName->lastname;
                    $middleName = $splitedName->middlename;

                    //update staff information
                    $staff->firstname = $firstName;
                    $staff->lastname = $lastName;
                    $staff->middleName = $middleName;
                    $staff->save();
                }

                //add attendance
                //check if attendance have been added for the date
                $checkAttendance = Attendance::where('staff_id', $staff->id)->where('date', $date)->first();
                if(empty($checkAttendance)){
                    //Nursing Mothers
                    switch($tauStaffId){
                        case 'TAU/SSPF/064':
                            $clockOut = !empty($clockIn) ? Carbon::parse('17:00')->addMinutes(rand(0, 30))->toTimeString(): $clockOut;
                        case 'TAU/SSPF/021':
                            $clockOut = !empty($clockIn) ? Carbon::parse('17:00')->addMinutes(rand(0, 30))->toTimeString(): $clockOut;
                        case 'TAU/SSPF/020':
                            $clockOut = !empty($clockIn) ? Carbon::parse('17:00')->addMinutes(rand(0, 30))->toTimeString(): $clockOut;
                        case 'TAU/SSPF/006':
                            $clockOut = !empty($clockIn) ? Carbon::parse('17:00')->addMinutes(rand(0, 30))->toTimeString(): $clockOut;
                        default;
                        $clockOut = $clockOut;
                    }


                    //add attendance
                    $status = null;
                    if(empty($clockOut) && empty($clockIn)){
                        $status = 0;
                    }elseif(empty($clockOut) || empty($clockIn)){
                        $status = 1;
                    }else{
                        $status = 2;
                    }

                    log::info('Staff ID:'. $status);

                    switch($tauStaffId){
                        case 'TAU/SSPF/064':
                            $status = $status != 2 ? 2 : $status;
                        case 'TAU/SSPF/021':
                            $status = $status != 2 ? 2 : $status;
                        case 'TAU/SSPF/020':
                            $status = $status != 2 ? 2 : $status;
                        case 'TAU/SSPF/006':
                            $status = $status != 2 ? 2 : $status;
                        default;
                        $status = $status;
                    }

                    //check for leave status
                    $leave = Leave::where('staff_id', $staff->id)->where('status', 1)->first();
                    $leaveId = Null;
                    if(!empty($leave)){
                        $leaveStartDate = Carbon::parse($leave->start_date);
                        $leaveEndDate = Carbon::parse($leave->end_date);

                        if($date == $leaveStartDate || $date < $leaveEndDate) {
                            $leaveId = $leave->id;
                            $status = 2;
                        }
                    }


                    $newAttendance = ([
                        'staff_id' => $staff->id,
                        'date' => $date,
                        'year' => $year,
                        'month' => $month,
                        'clock_in' => $clockIn,
                        'clock_out' => $clockOut,
                        'leave_id' => $leaveId,
                        'status' => $status,
                    ]);

                    $addAttendance = Attendance::create($newAttendance);
                }

            }
        }
    }

    public function splitName($name) {
        $parts = explode(" ", $name);

        $lastname = $parts[0];
        $firstName = count($parts[1]) > 2 ? $parts[1] : $parts[1][0];
        $middleName = (isset($parts[2])) ? $parts[2] : null;

        $name = new \stdClass();
        $name->lastname = $lastname;
        $name->middleName =  $middleName;
        $name->firstname = $firstName;

        return $name;
    }
}
