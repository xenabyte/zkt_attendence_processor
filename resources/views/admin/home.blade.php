@include('admin.includes.header')
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
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="{{asset('assets/images/users/avatar-1.jpg')}}" alt="" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate">{{ Auth::guard('admin')->user()->name }}</h5>
                        <p class="text-muted mb-0 text-truncate">Administrator</p>
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
                    <h3>{{date('d') - 1 }} Days</h3>
                    <p>Sa</p>
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
                                <p class="text-muted fw-medium">Total Staff</p>
                                <h4 class="mb-0">{{ $staffs->count() }}</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-user font-size-24"></i>
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
                                <p class="text-muted fw-medium">Senior Staff</p>
                                <h4 class="mb-0">{{ $staffs->where('type' , 1)->count() }}</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center ">
                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-user font-size-24"></i>
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
                                <p class="text-muted fw-medium">Junior Staff</p>
                                <h4 class="mb-0">{{ $staffs->where('type' , 2)->count() }}</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-user font-size-24"></i>
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

                <h4 class="card-title">Upload Attendance</h4>
                <p class="card-title-desc">Upload attendance file extracted from attendance capturing device <br><span class="text-danger"><strong>Note:</strong> Only .xls file allowed.</p>
                </p>

                <div>
                    <form action="{{ url('/admin/uploadAttendance') }}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="fallback dropzone"">
                            <input name="file" type="file" required>
                        </div>
                       

                        <br>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Upload Attendance</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

@include('admin.includes.footer')