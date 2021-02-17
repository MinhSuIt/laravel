<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    {{-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  // hỗ trợ các phiên bản trình duyệt--}}

    {{-- <link rel="apple-touch-icon" href="https://colorlib.com/wp/wp-content/uploads/sites/2/2014/05/apple-retina-colorlib.png" 
        sizes="120x120 / 32/ 57/76/120,114
        "> 
    --}}
    <meta charset="UTF-8">
    {{-- <title>{{ config('app.name') }}</title> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="SHORTCUT ICON" href="https://cdn.24h.com.vn/upload/icon/icon_24h.ico" type="image/x-icon">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    {{-- <meta property="og:image" content="https://hstatic.net/173/1000012173/10/2015/11-17/fb_og.jpg"> --}}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
          <style>
            .d-none{
                display: none;
            }
            .content-header{
                padding: 15px;
            }
            .activeSort{
                color:red;
            }
            </style>
    <link rel="stylesheet" href={{ asset('dashboard/style.css') }}>
    @yield('css')

</head>

@php
    $url = request()->fullUrlWithQuery(['language'=>'replaceLanguage']);
    $currencyUrl = request()->fullUrlWithQuery(['currency'=>'replaceCurrency']);
@endphp



<body class="skin-blue sidebar-mini">
    {{-- {{dd(app()->getLocale())}} --}}
@if (!Auth::guest())

    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <b>Admin</b>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <select name="" id="changeLanguage" style="margin-top:15px">
                    @foreach ($languages as $lang)
                        <option value="{{$lang->code}}" @php if($lang->code === app()->getLocale()) echo 'selected'; @endphp>{{$lang->name}}</option>
                    @endforeach

                    
                </select>

                <select name="" id="changeCurrency">
                    @foreach ($currencies as $currency)
                        <option value="{{$currency['code']}}" @php if( currency()->getUserCurrency() === $currency['code'] ) echo 'selected'; @endphp>{{$currency['name']}}</option>
                    @endforeach
                </select>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                {{-- <img src="http://infyom.com/images/logo/blue_logo_150x150.jpg"
                                     class="user-image" alt="User Image"/> --}}
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    
                                    {{-- <img src="http://infyom.com/images/logo/blue_logo_150x150.jpg"
                                         class="img-circle" alt="User Image"/>
                                    <p> --}}
                                        {{ Auth::user()->name }}
                                        {{-- <small>@lang('auth.app.member_since') {{ Auth::user() || Auth::user()->created_at->format('M. Y') }}</small> --}}
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">@lang('auth.app.profile')</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            @lang('auth.sign_out')
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
    @include('layouts.sidebar')
    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © 2016 <a href="#">Company</a>.</strong> All rights reserved.
        </footer>

    </div>
@else

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    InfyOm Generator
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Button trigger modal -->
  
  <!-- Modal -->
@if(isset($importType))
<form action='{{route("$importType.import")}}' method="POST" enctype="multipart/form-data">
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="exampleFormControlFile1">Upload ur file</label>
                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="fileexcel">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endif
<!-- jQuery 3.1.1 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<script>
    // alert('chưa có change language và currency,dùng thư viện làm');
    document.querySelector('#changeLanguage').addEventListener('change',function(e){
        let language = e.target.value;
        let og = "{!! $url !!}";
        let url = og.replace("replaceLanguage", language);;
        window.location.href = url;
    });
    document.querySelector('#changeCurrency').addEventListener('change',function(e){
    let currency = e.target.value;
    let currencyUrl = "{!! $currencyUrl !!}";
    let currencyUrlResult = currencyUrl.replace("replaceCurrency", currency);;
    window.location.href = currencyUrlResult;
});
</script>
@stack('scripts')
</body>
</html>