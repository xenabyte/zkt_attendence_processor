@extends('user.layout.auth')
<?php $name = "Reset Password" ?>
<!-- Main Content -->
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
                                    <h5 class="text-primary"> Reset Password</h5>
                                    <p>Reset Password with {{env('APP_NAME')}}.</p>
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
                            <div class="alert alert-info text-center mb-4" role="alert">
                                Enter your Email and instructions will be sent to you!
                            </div>
                            <form class="form-horizontal" method="POST" action="{{ url('/staff/password/email') }}">
    
                                <div class="mb-3{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="useremail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="useremail" placeholder="Enter email" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
            
                                <div class="text-center">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Reset</button>
                                </div>

                                <div class="mt-5 text-center">
                                    <hr>
                                    <p>Remember It ? <a href="{{ url('/login') }}" class="fw-medium text-primary"> Sign In here</a> </p>
                                    <p>© <script>document.write(new Date().getFullYear())</script> {{env('APP_NAME') }}.</p>
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
