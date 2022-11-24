@include('admin.includes.header')
@inject('controller', 'App\Http\Controllers\Controller')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Admins</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard/Admins</li>
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

                <h4 class="card-title">All Admin Records</h4>
                <p class="card-title-desc">All Admin Records</p>
                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#addAdmin">
                    Add Administrator
                </button><br>
                <hr>


                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>Admin ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach ($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->role == 1 ? 'SuperAdmin' : ($admin->role == 2 ? "Regular Administrator" : "View Access" ) }}</td>
                        <td>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#updateAdmin{{$admin->id}}" class="dropdown-item"><i class="mdi mdi-edit-line font-size-16 text-success me-1"></i> Edit Admin details</a></li>
                                </ul>
                            </div>

                            <!-- Static Backdrop Modal -->
                            <div class="modal fade" id="updateAdmin{{$admin->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="updateAdmin{{$admin->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="post" action="{{ url('/admin/updateAdmin') }}">
                                            @csrf
                                            <input type="hidden" name="id" required  value="{{ $admin->id }}">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addAdminLabel">Update Administrator</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="name" required id="name" value="{{ $admin->name }}">
                                                    <label for="name">Name</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="email" required id="email" value="{{ $admin->email }}">
                                                    <label for="email">Email</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="password"  id="password" placeholder="Enter Password">
                                                    <label for="password">Password</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <select class="form-select"  id="role" name="role" aria-label="Role">
                                                        <option value="" selected>Select Role</option>
                                                        <option value="1">Super Admin</option>
                                                        <option value="2">Regular Admin</option>
                                                        <option value="3">View Access</option>
                                                    </select>
                                                    <label for="role">Select Role</label>
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

<!-- Static Backdrop Modal -->
<div class="modal fade" id="addAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="addAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('/admin/addAdmin') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminLabel">Add Administrator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="name" required id="name" placeholder="Enter Name">
                        <label for="name">Name</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="email" required id="email" placeholder="Enter Email">
                        <label for="email">Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="password" required id="password" placeholder="Enter Password">
                        <label for="password">Password</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" required id="role" name="role" aria-label="Role">
                            <option value="" selected>Select Role</option>
                            <option value="1">Super Admin</option>
                            <option value="2">Regular Admin</option>
                            <option value="3">View Access</option>
                        </select>
                        <label for="role">Select Role</label>
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

@include('admin.includes.footer')
