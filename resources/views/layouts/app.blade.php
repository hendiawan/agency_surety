<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-ipad-retina.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-iphone-retina.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-ipad.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-iphone.png" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-3.3.7/css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/dataTables.bootstrap.css') }}" />
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/font-awesome-4.7/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}"/>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <!--
    <div id="loading">
        <div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    -->
    <!-- loading style -->
    <div id="customLoad">
        <div class="spinner"></div>
        <strong>MOHON TUNGGU...</strong>
        <div class="loadInfo">proses update data sedang berlangsung</div>
    </div>
    <div id="wrapper" class="container">

        <div id="top">
            <div id="topBar">
                <div class="wrapper20">
                    <a class="logo" href="#" title="">
                        
                        <img src="{{ asset('/images/logo.png') }}" rel="logo">
                    </a>
                    <div class="topNav clearfix">
                        <input class="topSearch" type="text" placeholder="Search...">
                        <ul class="tNav clearfix">
                            <li><a href="#" onclick="return false;"><i class="fa fa-search icon-white"></i></a></li>
                            <li>
                                <a data-toggle="dropdown" href="#" class="dropdown-toggle"><i class="fa fa-gear icon-white"></i></a>
                                  <ul class="dropdown-menu pull-right">
                                    <li><a href="{{ url('/edit-profil-pengguna') }}"><i class="fa fa-user-circle"></i> Edit Profil</a></li>
                                    <li><a href="{{ url('/ganti-password') }}"><i class="fa fa-asterisk"></i> Ganti Password</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#"><i class="fa fa-info-circle"></i> Info Applikasi</a></li>
                                  </ul>
                            </li>
                            <li data-toggle="tooltip" data-placement="bottom" title="Profil Pengguna">
                                <a href="{{ url('/profil-pengguna') }}"><i class="fa fa-user icon-white"></i></a>
                            </li>
                            <li data-toggle="tooltip" data-placement="bottom" title="Keluar (Logout)">
                                <a href="" data-toggle="modal" data-target=".logout-modal-sm">
                                    <i class="fa fa-sign-out icon-white"></i>
                                </a>
                                <!--
                                <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out icon-white"></i>
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                -->
                            </li>
                        </ul>
                    </div> <!-- /topNav -->
                </div>
            </div> <!-- /topBar -->

            @include('layouts.header')
            
        </div> <!-- /top -->

        @include('layouts.leftsidebar')
        <!-- MODAL LOGOUT -->
        <div class="modal fade logout-modal-sm" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-warning"></i> Peringatan</h4>
                    </div>
                    <div class="panel-body">
                    Anda yakin akan keluar dari aplikasi?
                    </div>
                    <div class="panel-footer">
                        <form action="{{ url('/logout') }}" method="POST">
                            {{ csrf_field() }}
                        <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Tidak</button>
                        <button id="logoutButton" type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ya</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>        

        @yield('content')
    </div> <!-- /wrapper -->
    <div class="clearfix"></div>

    <!-- MODAL CHECK ALERT -->
    <div class="modal fade formcheck-modal-sm" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-warning"></i> Peringatan</h4>
                </div>
                <div class="panel-body">
                Silahkan checklist kebenaran data yang anda inputkan
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Keluar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL -->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Detail SPPSB</h4>
                </div>
                <div class="modal-body" style="max-height:460px;overflow:auto;">
                    <p>Loading...</p>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button class="btn btn-info" type="button"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->

    <div id="footer">
        2017 &copy; Surety Bond Online v1.0. Powered by <a href="#">CalateSectorSeven</a>
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/autoNumeric.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jquery.sparkline.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jquery.easytabs.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/excanvas.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/main.js') }}"></script>
    @stack('scripts')
    
</body>
</html>
