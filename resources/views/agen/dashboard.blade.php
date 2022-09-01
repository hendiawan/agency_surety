@extends('layouts.app')

@section('content')
<div id="main" class="clearfix">
    <div class="topTabs">
            
        <div id="topTabs-container-home">
            <div class="topTabs-header clearfix">

            <div class="secInfo sec-dashboard">
                <h1 class="secTitle">Dashboard</h1>
                <span class="secExtra">Selamat datang!</span>
            </div> <!-- /SecInfo -->
            
            <ul class="etabs tabs">
                <li class="tab">
                    <a href="#tab1">
                        <span class="to-hide">
                            <i class="fa fa-th"></i><br>Quick Menu
                        </span>
                        <i class="fa icon-hidden fa-th" data-toggle="tooltip" title="Quick Menu"></i>
                    </a>
                </li>
                <li class="tab">
                    <a href="#tab2">
                        <span class="to-hide">
                            <i class="fa fa-bar-chart-o"></i><br>Statistik IJP
                        </span>
                        <i class="fa icon-hidden fa-bar-chart-o" data-toggle="tooltip" title="Statistik IJP"></i>
                    </a>
                </li>
            </ul> <!-- /tabs -->
            </div><!-- /topTabs-header -->

            <div class="topTabsContent">
                <div id="tab1">
                    <a href="{{ url('/sppsb-form') }}" class="hexagon orange ttip" data-ttip="Input Data SPPSB"><i class="fa fa-plus"></i></a>
                    <a href="{{ url('/sppsb-sp3kbg-data-table') }}" class="hexagon aqua ttip" data-ttip="Data SPPSB &amp; SP3 KBG"><i class="fa fa-table"></i></a>
                    <a href="{{ url('/sppsb-cetak-sertifikat') }}" class="hexagon lavender ttip" data-ttip="Cetak Sertikat"><i class="fa fa-print"></i></a>
                    <a href="{{ url('/ganti-password') }}" class="hexagon red ttip" data-ttip="Ganti Password"><i class="fa fa-asterisk"></i></a>
                    <a href="{{ url('/profil-pengguna') }}" class="hexagon blue ttip" data-ttip="Update Profile"><i class="fa fa-user"></i></a>
                    <a href="http://jamkridantbbersaing.com/" target="blank" class="hexagon grey ttip" data-ttip="website PT JAMKRIDA NTB Bersaing"><i class="fa fa-globe"></i></a>
                </div>
                <div id="tab2" class="content-tab" style="padding-top:20px;">
                    <div id="orderChart"><div id="chart-orders" class="chart"></div></div>
                </div>
            </div> <!-- /topTabContent -->

        </div> <!-- /tab-container -->

        <!-- </div> -->
    </div> <!-- /topTabs -->
   
    <div class="divider"></div>
    
    <div class="fluid form-horizontal">             
        <div class="widget leftcontent grid12">
            <div class="widget-header">
                <h3 class="widget-title">INFORMASI SURETY BOND AGEN</h3>
            </div>
            <div class="widget-content pad20f">
                <div class="form-group">
                    <div class="chart-desc grid6">
                        <div class="stat-tab-title"><strong>TOTAL IJP</strong> (SPPSB+SP3KBG)</div>
                        <h3>Rp. <span class="numeric">{{$ijp}}</span></h3>
                    </div>
                    <div class="chart-desc grid6">
                        <div class="stat-tab-title"><strong>TOTAL FEE</strong> (SPPSB+SP3KBG)</div>
                        <h3>Rp. <span class="numeric">{{$fee}}</span></h3>
                    </div>
                </div>
            </div> 
            <div class="divider"></div>
            <div class="widget-content pad20">
                <div class="form-group">
                    <div class="chart-desc grid4">
                        <div class="stat-tab-title">Jaminan Penawaran</div>
                        <div class="stat-tab-hour">SPPSB / SP3 KBG</div>
                        <a class="stat-tab-q">{{$penawaran_sppsb}} / {{$penawaran_sp3kbg}}</a>
                    </div>
                    <div class="chart-desc grid4">
                        <div class="stat-tab-title">Jaminan Pelaksanaan</div>
                        <div class="stat-tab-hour">SPPSB / SP3 KBG</div>
                        <a class="stat-tab-q">{{$pelaksanaan_sppsb}} / {{$pelaksanaan_sp3kbg}}</a>
                    </div>
                    <div class="chart-desc grid4">
                        <div class="stat-tab-title">Jaminan Uang Muka</div>
                        <div class="stat-tab-hour">SPPSB / SP3 KBG</div>
                        <a class="stat-tab-q">{{$uangmuka_sppsb}} / {{$uangmuka_sp3kbg}}</a>
                    </div>
                </div>
            </div>     
            <div class="widget-content pad20f">
                <div class="form-group">
                    <div class="chart-desc grid4">
                        <div class="stat-tab-title">Jaminan Pemeliharaan</div>
                        <div class="stat-tab-hour">SPPSB / SP3 KBG</div>
                        <a class="stat-tab-q">{{$pemeliharaan_sppsb}} / {{$pemeliharaan_sp3kbg}}</a>
                    </div>
                    <div class="chart-desc grid4">
                        <div class="stat-tab-title">Jaminan Pembayaran</div>
                        <div class="stat-tab-hour">SPPSB / SP3 KBG</div>
                        <a class="stat-tab-q">{{$pembayaran_sppsb}} / {{$pembayaran_sp3kbg}}</a>
                    </div>
                    <div class="chart-desc grid4">
                        <div class="stat-tab-title">Jaminan Sanggah Banding</div>
                        <div class="stat-tab-hour">SPPSB / SP3 KBG</div>
                        <a class="stat-tab-q">{{$sanggahbanding_sppsb}} / {{$sanggahbanding_sp3kbg}}</a>
                    </div>
                </div>
            </div>                
        </div> <!-- /widget -->
    </div> <!-- /fluid -->

</div> <!-- /main -->
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/jquery.flot.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jquery.flot.resize.js') }}"></script>    
    <script type="text/javascript" src="{{ asset('/js/jquery.flot.tooltip_0.4.3.min.js') }}"></script>
    <script type="text/javascript">
        toastr.options = {
          "closeButton": true,
          "debug": false,
          "positionClass": "toast-bottom-right",
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
        setTimeout(function(){
            toastr.info('<span style="color:#333;">Selamat datang di aplikasi online Surety Bond</span>');  
        },2000) ;

        $(window).load(function(){

            var dataOrder = [
                        { label: " SPPSB", data: {{ json_encode($statSppsb) }} },
                        { label: " SP3 KBG", data: {{ json_encode($statSp3kbg) }} }
                    ];

            var labelOrder = {{ json_encode($labelStat) }};

            var optionOrder = {
                       series: {
                           lines: { show: true },
                           points: { show: true, fill:true, fillColor: '#8fd7d4' },
                           shadowSize: 5
                       },
                        tooltip: true,
                        tooltipOpts: {
                            content: "Date: %x<br/>Total Order: %y",
                            dateFormat: "%0d-%0m-%y",
                            shifts: {
                                x: 10,
                                y: 0
                            },
                            defaultTheme: false
                        },
                       grid: { hoverable: true, clickable: true },
                       yaxis: {tickFormatter: function numberWithCommas(x) {
                                      return x.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ".");
                                }
                        },
                       xaxis: { mode: "time", timeformat: "%d/%m", ticks: labelOrder },
                       legend: {
                            noColumns: 1,
                            margin: 5,
                            position: "ne"
                        },
                        colors: [ '#B0F430' ]
                     };
            $.plot($("#chart-orders"), dataOrder, optionOrder);
        })
        
    </script>
@endpush