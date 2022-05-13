@include('admin.includes.header')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Attendance</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard/Attendance</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">{{ $staff->firstname .' '. $staff->lastname }} @if(!empty($month) && !empty($year)) {{ $month .' '. $year }} @endif Attendance Records</h4>
                <p class="card-title-desc">Attendance Records @if(!empty($totalPresentdays)) - {{ $totalPresentdays }} @endif Days</p>
                <hr>
                    <h5 class="card-title mb-4">Query Past Records</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="post" action="{{ url('/admin/pastAttendanceRecords') }}">
                        @csrf
                        <input type="hidden" name="staffId" value="{{ $staff->id }}">
                        <label>Select Month and Year</label>
                        <div class="hstack gap-3">
                            <input class="form-control me-auto" type="month" name="dateMonth" required  min="2022-03" placeholder="Pick month and year"
                                aria-label="Pick month and year">
                            <button type="submit" class="btn btn-secondary">Submit</button>
                            <div class="vr"></div>
                            <button type="reset " class="btn btn-outline-danger">Reset</button>
                        </div>
                    </form>

                @if(!empty($attendances))
                <hr>
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Clock In Time</th>
                        <th>Clock Out Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($attendances as $attendance)
                        <tr>
                            <td>{{  \Carbon\Carbon::parse($attendance->date)->format('jS \o\f F, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('H:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->clock_out)->format('H:i A') }}</td>
                            <td>
                                <button type="button" class="btn btn-{{$attendance->status == null ? 'danger': $attendance->status == 0 ? 'warning' : 'success'}} btn-sm btn-rounded">
                                    {{$attendance->status == null ? 'Danger': $attendance->status == 0 ? 'Pending' : 'Success'}}
                                </button>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                    </a>
                                    @if($attendance->status != 1)
                                    <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a href="{{ url('/admin/updateAttendance') }}/{{ $attendance->id }}" class="dropdown-item"><i class="mdi mdi-check font-size-16 text-success me-1"></i> Mark Present</a></li>
                                    </ul>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

@include('admin.includes.footer')