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

        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body>

    @yield('content')

   


        <!-- JAVASCRIPT -->
        <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

        <!-- validation init -->
        <script src="{{asset('assets/js/pages/validation.init.js')}}"></script>
        
        <!-- App js -->
        <script src="{{asset('assets/js/app.js')}}"></script>

    </body>
    {{-- <a href="{{ url('/staff/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

    <form id="logout-form" action="{{ url('/staff/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form> --}}
</html>

