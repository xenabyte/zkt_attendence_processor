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

                <h4 class="card-title">{{ $staff->firstname .' '. $staff->lastname }} ({{ date('M Y') }}) Attendance Records</h4>
                <p class="card-title-desc">Attendance Records</p>
                </p>
                <hr>

                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Clock In Time</th>
                        <th>Clock Out Time</th>
                        <th>Leave</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach ($monthAttendance as $attendance)
                    <tr>
                        <td>{{  \Carbon\Carbon::parse($attendance->date)->format('jS \o\f F, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($attendance->clock_out)->format('h:i A') }}</td>
                        <td>{{ $attendance->leave? $attendance->leave->purpose : null }}</td>
                        <td>
                            @if($attendance->status == 2)
                            <button type="button" class="btn btn-success btn-sm btn-rounded">
                                Present
                            </button>
                            @elseif($attendance->status == 1)
                            <button type="button" class="btn btn-warning btn-sm btn-rounded">
                                Awaiting ClockIn/ClockOut
                            </button>
                            @else
                            <button type="button" class="btn btn-danger btn-sm btn-rounded">
                              Absent
                            </button>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                </a>
                                @if($attendance->status != 2)
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
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

@include('admin.includes.footer')