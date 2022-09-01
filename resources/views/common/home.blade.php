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
                            <i class="fa fa-th"></i><br>Quick Menu Actions
                        </span>
                        <i class="fa icon-hidden fa-th ttip" data-ttip="Quick Menu"></i>
                    </a>
                </li>
                <li class="tab">
                    <a href="#tab2">
                        <span class="to-hide">
                            <i class="fa fa-bar-chart-o"></i><br>Web Site Statistics
                        </span>
                        <i class="fa icon-hidden fa-bar-chart-o ttip" data-ttip="Site Statistics"></i>
                    </a>
                </li>
                <li class="tab">
                    <a href="#tab3">
                        <span class="to-hide">
                            <i class="fa fa-calendar"></i><br>Calendar
                        </span>
                        <i class="fa icon-hidden fa-calendar ttip" data-ttip="Calendar"></i>
                    </a>
                </li>
            </ul> <!-- /tabs -->
            </div><!-- /topTabs-header -->

            <div class="topTabsContent">
                    <div id="tab1">
                        <a href="#" class="hexagon orange ttip" data-ttip="shortcut menu 1"><i class="fa fa-plus"></i></a>
                        <a href="#" class="hexagon aqua ttip" data-ttip="shortcut menu 2"><i class="fa fa-signal"></i></a>
                        <a href="#" class="hexagon lavender ttip" data-ttip="shortcut menu 3"><i class="fa fa-refresh"></i></a>
                        <a href="#" class="hexagon red ttip" data-ttip="shortcut menu 4"><i class="fa fa-cog"></i></a>
                        <a href="#" class="hexagon blue ttip" data-ttip="shortcut menu 5"><i class="fa fa-cloud-download"></i></a>
                        <a href="#" class="hexagon grey ttip" data-ttip="website PT JAMKRIDA NTB Bersaing"><i class="fa fa-globe"></i></a>
                    </div>
                    <div id="tab2">
                        <div id="chart-quick" class="chart"></div>
                    </div>
                    <div id="tab3">
                        <div class="small-calendar cal-tab"></div>
                    </div>
            </div> <!-- /topTabContent -->

        </div> <!-- /tab-container -->

        <!-- </div> -->
    </div> <!-- /topTabs -->
    
    <div class="divider"></div>
    
    <div class="fluid">
        
        <div class="widget leftcontent grid12">
            <div class="widget-header">
                <div class="widget-controls">
                    <div class="btn-group xtra"> <!-- btn dd -->
                        <a href="#" onclick="return false;" class="icon-button dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="#"><i class="fa fa-pencil"></i> Edit</a></li>
                            <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                            <li><a href="#"><i class="fa fa-ban"></i> Ban</a></li>
                            <li class="divider"></li>
                            <li><a href="#"> Other actions</a></li>
                        </ul>
                    </div><!-- /btn dd -->
                </div>
            </div>
            <div id="statsTabs-container">
                <ul class="etabs stats-tabs">
                    <li class="tab"><a href="#stat-tab1">Visitors Statistic</a></li>
                    <li class="tab"><a href="#stat-tab2">Orders Statistic</a></li>
                    <li class="tab"><a href="#stat-tab3">Users Statistic</a></li>
                </ul>
                <div class="statsTabsContent">

                    <div id="stat-tab1">
                        <div class="chart-desc grid2">
                            <div class="stat-tab-title">Today's visitors</div>
                            <div class="stat-tab-hour"><i class="fa fa-clock-o"></i> 5:23 pm</div>
                            <a class="stat-tab-q">16,481</a>
                        </div>
                        <div class="chart-wrapper grid10">
                            <div id="chart-visitors" class="chart"></div>
                        </div>
                    </div>

                    <div id="stat-tab2">
                        <div class="chart-desc grid2">
                            <div class="stat-tab-title">Today's orders</div>
                            <div class="stat-tab-hour"><i class="fa fa-clock-o"></i> 7:24 pm</div>
                            <a class="stat-tab-q">3,280</a>
                        </div>
                        <div class="chart-wrapper grid10">
                            <div id="chart-orders" class="chart"></div>
                        </div>
                    </div>
                    <div id="stat-tab3">
                        <div class="chart-desc grid2">
                            <div class="stat-tab-title">Today's users</div>
                            <div class="stat-tab-hour"><i class="fa fa-clock-o"></i> 1:24 am</div>
                            <a class="stat-tab-q">7,060</a>
                        </div>
                        <div class="chart-wrapper grid10">
                            <div id="chart-users" class="chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

        </div> <!-- /widget -->
        
    </div> <!-- /fluid -->

</div> <!-- /main -->
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/jquery.flot.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jquery.flot.resize.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/charts.js') }}"></script>
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
        
    </script>
@endpush