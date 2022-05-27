@extends('staff.layout.auth')
<?php $name = "Login" ?>

@section('content')
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p>Sign in to continue to {{env('APP_NAME')}}.</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{asset('assets/images/profile-img.png')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0"> 
                        <div>
                            <a href="index-2.html">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img src="{{asset('assets/images/logo.png')}}" alt="" class="rounded-circle" height="34">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="p-2">
                            <form class="form-horizontal" method="POST" action="{{ url('/staff/login') }}">
                                @csrf
                                <div class="mb-3{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="useremail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="useremail" placeholder="firstname.lastname@tau.edu.ng" name="email" required value="{{ old('email') }}" autofocus >
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif 
                    
                                </div>
        
        
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password" name="password" class="form-control" placeholder="Enter password" aria-label="Password" required aria-describedby="password-addon">
                                        <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                    </div>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  name="remember" id="remember-check">
                                    <label class="form-check-label" for="remember-check">
                                        Remember me
                                    </label>
                                </div>
            
                                <div class="mt-4 d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">Login</button>
                                </div>

                                <div class="mt-4 text-center">
                                    <a href="{{ url('/staff/password/reset') }}" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                </div>
                                <hr>
                                <p class="text-center">You dont have password yet? Kindly complete your registration using the button below</p>
                                <div class="mt-4 d-grid">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verificationModal">
                                        Click here for complete profile
                                    </button>
                                </div>
                                
                                <div class="mt-5 text-center">
                                    <hr>
                                    <div>
                                        <p>© <script>document.write(new Date().getFullYear())</script> {{env('APP_NAME')}}.</p>
                                    </div>
                                </div>

                            </form>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="verificationModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Complete Staff Profile</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('/staff/completeRegistration') }}" id="profile-form" method="post" enctype="multipart/form-data">
                                           @csrf 
                                            <div id="kyc-verify-wizard">
                                                <!-- Personal Info -->
                                                <h3>Personal Info</h3>
                                                
                                                <section>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" name="lastname" class="form-control" id="kyclastname-input" placeholder="Enter Last name">
                                                                <label for="kyclastname-input" class="form-label">Last name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" name="firstname" class="form-control" id="kycfirstname-input"  placeholder="Enter First name">
                                                                <label for="kycfirstname-input" class="form-label">First name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-floating  mb-3">
                                                                <input type="text" name="middlename" class="form-control" id="kycmidname-input" placeholder="Enter Middle name">
                                                                <label for="kycmidname-input" class="form-label">Middle name</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <div class="form-floating mb-4">
                                                                <input type="text" name="phone_number" class="form-control" id="kycphoneno-input" placeholder="Enter Phone number" >
                                                                <label for="kycphoneno-input" class="form-label">Phone</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-floating mb-4">
                                                                <input type="date" name="date_of_birth"  class="form-control" id="kycbirthdate-input"  max="2000-01-01" placeholder="Enter Date of birth">
                                                                <label for="kycbirthdate-input" class="form-label">Date of birth</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h6 class="text-muted">Authentication Information</h6>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" name="tau_staff_id"  class="form-control" id="kycstaffid-input" >
                                                                <label for="kycstaffid-input" class="form-label">TAU Staff IDs</label>
                                                                <code>TAU Staff ID eg. (TAU/****/*******) </code>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="email" name="email"  class="form-control" id="kycemail-input" >
                                                                <label for="kycemail-input" class="form-label">Email</label>
                                                                <code>TAU Staff Email eg. (firstname.lastname@tau.edu.ng) </code>
                                                            </div>
                                                        </div>
                                                         
                                                        <div class="col-lg-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="password" name="password" class="form-control" id="kycpass-input" placeholder="Enter Password" >
                                                                <label for="kycpass-input" class="form-label">Password</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="password" name="confirm_password" class="form-control" id="kycpass1-input" placeholder="Confirm Password" >
                                                                <label for="kycpass1-input" class="form-label">Confirm Password</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </section>
    
                                                <!-- Confirm email -->
                                                <h3>Position</h3>
                                                <section>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" name="role"  id="kycrole">
                                                                <label for="kycrole-input" class="form-label">Job Position</label>
                                                                <code>eg. Lecturer II</code>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-floating mb-3">
                                                                <select   name="class" class="form-select" id="kyctye-input">
                                                                    <option value="" selected>Select Category</option>
                                                                    <option value="Academic Staff">Academic Staff</option>
                                                                    <option value="Non Academic Staff">Non Academic Staff</option>
                                                                </select>
                                                                <label for="kyctye-input" class="form-label">Staff Category</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-floating mb-3">
                                                                <select class="form-select" name="type" id="kycclass-input">
                                                                    <option value="" selected>Select Classification</option>
                                                                    <option value="Senior Staff">Senior Staff</option>
                                                                    <option value="Junior Staff">Junior Staff</option>
                                                                </select>
                                                                <label for="kycclass-input" class="form-label">Staff Classification</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-floating mb-3">
                                                                <select class="form-select" name="faculty" id="kycdept-input">
                                                                    <option value="" selected>Select Faculty</option>
                                                                    <option value="Faculty of Computing and Applied Sciences">Faculty of Computing and Applied Sciences</option>
                                                                    <option value="Faculty of Basic Health and Medical Sciences">Faculty of Basic Health and Medical Sciences</option>
                                                                    <option value="Faculty of Management and Social Sciences">Faculty of Management and Social Sciences</option>
                                                                    <option value="Directoriate of Information and Communication Technology">Directoriate of Information  and Communication  Technology</option>
                                                                    <option value="University Health Center">University Health Center</option>
                                                                    <option value="Student Care Services">Student Care Services</option>
                                                                    <option value="Library and Information Services">Library and Information Services</option>
                                                                    <option value="Registry">Registry</option>
                                                                    <option value="Busary">Busary</option>
                                                                    <option value="Directoriate of Academic Planning">Directoriate of Academic Planning</option>
                                                                    <option value="Physical Planning and Development">Physical Planning and Development (Works)</option>
                                                                    <option value="Thomas Adewumi University Ventures">Thomas Adewumi University Ventures</option>
                                                                </select>
                                                                <label for="kycdept-input" class="form-label">Faculty</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" name="dept"  id="kycdept-inpute">
                                                                <label for="kycdept-input" class="form-label">Department</label>
                                                                <code>eg. Academic Departments, Cafeteria, Campus Cleaners. etc</code>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
    
                                                <!-- Document Verification -->
                                                <h3>Upload Passport</h3>
                                                <section>
                                                    <div>
                                                        <h5 class="font-size-14 mb-3">Kindly upload a passport photograph</h5>
                                                        <div class="kyc-doc-verification mb-3">
                                                            <div class="fallback dropzone">
                                                                <input name="file" type="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                               
                                                <button id='submit' type="submit"></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection
