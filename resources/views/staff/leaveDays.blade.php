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
                </p>
                <hr>

                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>Leave Purpose</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Total Days</th>
                        <th></th>
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
                            <button type="button" class="btn btn-{{$leave->status == null ? 'warning': $leave->status == 0 ? 'info' : 'success'}} btn-sm btn-rounded">
                                {{$leave->status == null ? 'Pending': $leave->status == 0 ? 'Approved' : 'Success'}}
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

@include('staff.includes.footer')