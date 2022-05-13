@include('admin.includes.header')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Staffs</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard/Staffs</li>
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
                <p class="card-title-desc">All Staff with the present month {{ date('M Y') }} Attendance Records</p>
                </p>
                <hr>

                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Email/Phone Number</th>
                        <th>Attendance - {{ date('M Y') }}</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach ($staffs as $staff)
                    <tr>
                        <td>{{ $staff->tau_staff_id }}</td>
                        <td>{{ $staff->lastname . ' '.$staff->firstname }}</td>
                        <td>{{ $staff->job_specification }}</td>
                        <td>{{ $staff->faculty .'/'. $staff->department }}</td>
                        <td>{{ $staff->email .'/'. $staff->phone_number }}</td>
                        <td>{{ $staff->attendance->count() }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

@include('admin.includes.footer')