@extends('layouts.auth')

@section('content')
<div id="wrapper" class="login">

    <div id="top">
        <div id="topBar" class="clearfix widget-content pad10">
            <a class="logo" href="index-2.html">
                <img src="images/logo.png" rel="logo">
            </a>
            <div class="topNav clearfix">
                <ul class="tNav clearfix">
                    <li>
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle"><i class="fa fa-gear icon-white"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ url('/password/reset') }}"><i class="fa fa-question"></i> Lupa Password</a></li>
                            <li><a href="#"><i class="fa fa-envelope-o"></i> Kontak Admin</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="fa fa-info-circle"></i> Bantuan</a></li>
                        </ul>
                    </li>
                </ul>
            </div> <!-- /topNav -->		
        </div> <!-- /topBar -->

    </div> <!-- /top -->
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }}
        <div class="widget-content pad20 clearfix">
            <div class="userImg">
                <img src="images/lock.jpg" rel="user">
            </div>
            <h3 class="center">Panel Logins</h3>
            <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                <div class="col-lg-12">
                    <input type="text" name="username" class="form-control" placeholder="Username"/>
                    @if ($errors->has('username'))
                    <label for="username" class="control-label">{{ $errors->first('username') }}</label>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <div class="col-lg-12">
                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                    @if ($errors->has('password'))
                    <label for="password" class="control-label">{{ $errors->first('password') }}</label>
                    @endif
                </div>
            </div>
            <button class="btn btn-blue btn-full" type="submit">LOGIN</button>
            <span class="custom-input">
                <input type="checkbox" id="chkbx-1"><label for="chkbx-1">Remember me</label>
            </span>
        </div>	<!-- /widget-content -->	
    </form>
</div>  <!-- /wrapper -->
@endsection