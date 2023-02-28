@include('admin.includes.header')
@inject('controller', 'App\Http\Controllers\Controller')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Staff</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard/Staff</li>
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

                <h4 class="card-title">All Staff Records</h4>
                <p class="card-title-desc">All Staff with the month  of {{ empty($year)? date('M Y') : $month .' '. $year }}</p> Attendance Records</p>
                </p>
                <hr>

                <h5 class="card-title mb-4">Query Past Records</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="post" action="{{ url('/admin/pastGeneralAttendanceRecords') }}">
                        @csrf
                        <label>Select Month and Year</label>
                        <div class="hstack gap-3">
                            <input class="form-control me-auto" type="month" name="dateMonth" required  min="2022-03" placeholder="Pick month and year"
                                aria-label="Pick month and year">
                            <button type="submit" class="btn btn-secondary">Submit</button>
                            <div class="vr"></div>
                            <button type="reset " class="btn btn-outline-danger">Reset</button>
                        </div>
                    </form>
                    <br>
                    <hr>
                    <br>

                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Email/Phone Number</th>
                        <th>Attendance -  {{ empty($year)? date('M Y') : $month .' '. $year }}</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach ($staffs as $staff)
                    <tr>
                        <td>{{ $staff->tau_staff_id }}</td>
                        <td>{{ $staff->lastname . ' '.$staff->firstname .' '. $staff->middlename }}</td>
                        <td>{{ $staff->job_specification }}</td>
                        <td>{{ $staff->email .'/'. $staff->phone_number }}</td>
                        <td>{{ $staff->attendance->count() }} Days</td>
                        <td>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#manageStaff{{$staff->id}}" class="dropdown-item btn btn-primary"><i class="mdi mdi-account-edit font-size-16 text-success me-1"></i> Staff</a></li>
                                    @if(empty($year))<li><a href="{{ url('/admin/monthlyAttendance') }}/{{ $staff->id }}" class="dropdown-item"><i class="mdi mdi-eye font-size-16 text-success me-1"></i> View Attendance</a></li>@endif
                                    <li><a href="{{ url('/admin/pastAttendance') }}/{{ $staff->id }}" class="dropdown-item"><i class="mdi mdi-calendar-search font-size-16 text-info me-1"></i> Past Records Attendance</a></li>
                                </ul>
                            </div>

                            <div id="manageStaff{{$staff->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-center p-5">
                                            <div class="text-end">
                                                <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="mt-2">
                                                <lord-icon src="https://cdn.lordicon.com/wloilxuq.json" trigger="hover" style="width:150px;height:150px">
                                                </lord-icon>
                                                <h4 class="mb-3 mt-4">Are you sure you want to unpublish news?</h4>
                                                <form action="{{ url('/admin/updateStaffStatus') }}" method="POST">
                                                    @csrf
                                                    <input name="staff_id" type="hidden" value="{{$staff->id}}">
                                                    <div class="mb-3 mt-5">
                                                        <label for="choices-publish-status-input" class="form-label">Manage Staff</label>
                                                        <select class="form-select" name="status" id="choices-publish-status-input" data-choices data-choices-search-false>
                                                            <option value="" selected>Choose...</option>
                                                            <option value="Active">Active</option>
                                                            <option value="Left">Left</option>
                                                        </select>
                                                        <br>
                                                        <button type="submit" class="btn btn-lg btn-primary"> Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light p-3 justify-content-center">

                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
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
