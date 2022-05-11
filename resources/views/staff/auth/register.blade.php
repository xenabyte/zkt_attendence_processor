@extends('user.layout.auth')
<?php $name = "Register" ?>
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
                                    <h5 class="text-primary">Free Register</h5>
                                    <p>Get your free {{env('APP_NAME')}} account now.</p>
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
                                        <img src="{{asset('assets/images/logo.svg')}}" alt="" class="rounded-circle" height="34">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="p-2">
                            <form class="needs-validation" novalidate method="POST" action="{{ url('/staff/register') }}">
                                @csrf
                               
                                <div class="mb-3{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="{{ old('username') }}" autofocus required>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif

                                    <div class="invalid-feedback">
                                        Please Enter Username
                                    </div>  
                                </div>

                                <div class="mb-3{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="useremail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="useremail" placeholder="Enter email" name="email" value="{{ old('email') }}" required>  
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    <div class="invalid-feedback">
                                        Please Enter Email
                                    </div>      
                                </div>
        
                                <div class="mb-3{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="userpassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="userpassword"  name="password" placeholder="Enter password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif

                                    <div class="invalid-feedback">
                                        Please Enter Password
                                    </div>       
                                </div>

                                <div class="mb-3{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="userpassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="userpassword"  name="password_confirmation" placeholder="Confirm password" required>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif 
                                    
                                    <div class="invalid-feedback">
                                        Please Enter Confirmation Password
                                    </div>
                                </div>
            
                                <div class="mt-4 d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                                </div>
        
                                <div class="mt-4 text-center">
                                    <p class="mb-0">By registering you agree to the Skote <a href="#" class="text-primary">Terms of Use</a></p>
                                </div>

                                <div class="mt-5 text-center">
                    
                                    <div>
                                    <hr>
                                        <p>Already have an account ? <a href="{{url('user/login')}}" class="fw-medium text-primary"> Login</a> </p>
                                        <p>© <script>document.write(new Date().getFullYear())</script> {{ env('APP_NAME') }}. </p>
                                    </div>
                                </div>
                
                            </form>
                        </div>
    
                    </div>
                </div>
    
            </div>
        </div>
    </div>
</div>

@endsection
