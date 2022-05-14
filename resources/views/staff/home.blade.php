@include('staff.includes.header')
 <!-- start page title -->
 <div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">Welcome Back!</h5>
                            <p>{{ env('APP_NAME') }} Dashboard</p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="{{asset('assets/images/profile-img.png')}}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="{{asset(Auth::guard('staff')->user()->image)}}" alt="" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15">{{ Auth::guard('staff')->user()->firstname .' '. Auth::guard('staff')->user()->lastname }}</h5> 
                        <p class="text-muted mb-0 ">{{ Auth::guard('staff')->user()->job_specification }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Captured Days</h4>

                <div class="text-center">
                    <div class="mb-4">
                        <i class="bx bx-time-five text-primary display-4"></i>
                    </div>
                    <h3>{{$capturedWorkingDays - 1 }} Days</h3>
                    <p></p>
                    <p>Today's date is {{date('d D M, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Total Active Day <small>- {{date('M, Y') }}</small></p>
                                <h4 class="mb-0">{{ $workingDays }}</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-time-five font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Days Present <small>- {{date('M, Y') }}</small> </p>
                                <h4 class="mb-0">{{ $presentMonthAttendance->where('status', 1)->count() }}</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center ">
                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-time-five font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Days Absent <small>- {{date('M, Y') }}</small></p>
                                <h4 class="mb-0">{{ $absentMonthAttendance }}</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-time-five font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Attendance <small>- {{date('M, Y') }}</small></h4>
                <p class="card-title-desc">This Prsent Month Attendance</p>
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Clock In Time</th>
                        <th>Clock Out Time</th>
                        <th></th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach ($allPresentMonthAttendance as $attendance)
                    <tr>
                        <td>{{  \Carbon\Carbon::parse($attendance->date)->format('jS \o\f F, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('H:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($attendance->clock_out)->format('H:i A') }}</td>
                        <td>
                            <button type="button" class="btn btn-{{$attendance->status == null ? 'danger': $attendance->status == 0 ? 'warning' : 'success'}} btn-sm btn-rounded">
                                {{$attendance->status == null ? 'Danger': $attendance->status == 0 ? 'Pending' : 'Success'}}
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

@include('staff.includes.footer')