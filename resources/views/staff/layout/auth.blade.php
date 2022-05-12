<!doctype html>
<html lang="en">

    

    <head>
        
        <meta charset="utf-8" />
        <title>{{ $name }} | {{env('APP_NAME')}} - {{ env('APP_SLOGAN') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{ env('APP_DESCRIPTION') }}" name="description" />
        <meta content="Damilare Ogundele" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
         <!-- Plugins css -->
         <link href="{{asset('assets/libs/dropzone/min/dropzone.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    </head>

    <body>
        @include('sweetalert::alert')

    @yield('content')

   


        <!-- JAVASCRIPT -->
        <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

        <!-- validation init -->
        <script src="{{asset('assets/js/pages/validation.init.js')}}"></script>

         <!-- jquery step -->
         <script src="{{asset('assets/libs/jquery-steps/build/jquery.steps.min.js')}}"></script>
         <!-- dropzone js -->
        <script src="{{asset('assets/libs/dropzone/min/dropzone.min.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('assets/js/app.js')}}"></script>

        <script>
            $(document).ready(function () {
                $('#submit').hide();
                $("#kyc-verify-wizard").steps({
                    headerTag: "h3",
                    bodyTag: "section",
                    transitionEffect: "slide",
                    labels: {
                        finish: 'Complete Profile <i class="fa fa-chevron-right"></i>',
                        next: 'Next <i class="fa fa-chevron-right"></i>',
                        previous: '<i class="fa fa-chevron-left"></i> Previous'
                    },
                    onFinishing: function (event, currentIndex) {
                        $('#submit').trigger('click');
                    }
                });
            });
        </script>
        

    </body>
    {{-- <a href="{{ url('/staff/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

    <form id="logout-form" action="{{ url('/staff/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form> --}}
</html>

