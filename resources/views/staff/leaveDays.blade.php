@include('staff.includes.header')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Leave Records</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard/Leave Records</li>
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

                <h4 class="card-title">Leave Records</h4>
                <p class="card-title-desc">Leave Records</p>
               <!-- Static Backdrop modal Button -->
                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Apply for Leave
                </button><br>
                <hr>

                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                    <tr>
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
                        <td>{{  $leave->purpose }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('jS \o\f F, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('jS \o\f F, Y') }}</td>
                        <td>{{ $leave->days }} Days</td>
                        <td>
                            <button type="button" class="btn btn-{{$leave->status == null ? 'warning': 'success'}} btn-sm btn-rounded">
                                {{$leave->status == null ? 'Pending': 'Approved'}}
                            </button>
                        </td>
                        <td>
                            @if(empty($leave->status))
                            <form method="post" action="{{ url('/staff/deleteLeave') }}">
                                @csrf
                                <input type="hidden" name="leaveId" value="{{ $leave->id }}">
                                <button type="submit" class="btn btn-danger waves-effect waves-light">
                                  <i class="mdi mdi-trash-can"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<!-- Static Backdrop Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('/staff/applyLeaveDays') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Leave Application Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger card-title-desc">You must also complete the manual application.</p>

                
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="purpose" required id="floatingnameInput" placeholder="Enter Name">
                        <label for="floatingnameInput">Leave Purpose</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" required name="start_date" id="startdate">
                                <label for="startdate">Start Date</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="date" name="end_date" required class="form-control" id="enddate">
                                <label for="enddate">Resumption Date</label>
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

@include('staff.includes.footer')