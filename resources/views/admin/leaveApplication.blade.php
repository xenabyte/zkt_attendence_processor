@include('admin.includes.header')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Leave Application Records</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard/Leave Application Records</li>
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

                <h4 class="card-title">Leave Application Records</h4>
                <p class="card-title-desc">Leave Application Records</p>
               <!-- Static Backdrop modal Button -->
                <hr>

                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>Staff Fullname</th>
                        <th>Staff ID</th>
                        <th>Leave Purpose</th>
                        <th>Start Date</th>
                        <th>Resumption Date</th>
                        <th>Total Days</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach ($leaves as $leave)
                    <tr>
                        <td>{{ $leave->staff->firstname .' '. $leave->staff->lastname }}</td>
                        <td>{{ $leave->staff->tau_staff_id}}</td>
                        <td>{{ $leave->purpose }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('jS \o\f F, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('jS \o\f F, Y') }}</td>
                        <td>{{ $leave->days }} Days</td>
                        <td>
                            <button type="button" class="btn btn-{{($leave->status == null ? 'warning') : ($leave->status == 1 ? 'success' : 'primary')}} btn-sm btn-rounded">
                                {{($leave->status == null ? 'Pending') : ($leave->status == 1 ? 'Approved' : 'Ended')}}
                            </button>
                        </td>
                        <td>
                            @if($leave->status == null)
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $leave->id }}">
                                Manage Leave
                            </button>
                            @endif
                            <!-- Static Backdrop Modal -->
                            <div class="modal fade" id="staticBackdrop-{{ $leave->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="post" action="{{ url('/admin/manageLeaveApplication') }}">
                                            @csrf
                                            <input type="hidden" name="leaveId" value="{{ $leave->id }}">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Manage Leave Application</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-danger card-title-desc">Ensure staff already completed the manual application.</p>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-floating mb-3">
                                                            <select class="form-select" required id="floatingSelectGrid" name="status" aria-label="Floating label select example">
                                                                <option value="" selected>Manage Leave Application</option>
                                                                <option value="1">Approved</option>
                                                                <option value="">Declined</option>
                                                            </select>
                                                            <label for="floatingSelectGrid">Manage Leave Application</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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