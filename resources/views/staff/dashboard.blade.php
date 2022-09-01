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
                                <i class="fa fa-bar-chart-o"></i><br>Rate IJP SPPSB
                            </span>
                            <i class="fa icon-hidden fa-bar-chart-o ttip" data-ttip="Rate IJP SPPSB"></i>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#tab3">
                            <span class="to-hide">
                                <i class="fa fa-bar-chart-o"></i><br>Rate IJP SP3 KBG
                            </span>
                            <i class="fa icon-hidden fa-bar-chart-o ttip" data-ttip="Rate IJP SP3 KBG"></i>
                        </a>
                    </li>
                </ul> <!-- /tabs -->
            </div><!-- /topTabs-header -->

            <div class="topTabsContent">
                <div id="tab1">
                    <a href="{{ url('/sppsb-sp3kbg-masuk') }}" class="hexagon aqua ttip" data-ttip="Data SPPSB"><i class="fa fa-inbox"></i></a>
                    <a href="{{ url('/laporan') }}" class="hexagon lavender ttip" data-ttip="Laporan"><i class="fa fa-folder-open"></i></a>
                    <a href="{{ url('/ganti-password') }}" class="hexagon red ttip" data-ttip="Ganti Password"><i class="fa fa-asterisk"></i></a>
                    <a href="{{ url('/profil-pengguna') }}" class="hexagon blue ttip" data-ttip="Update Profile"><i class="fa fa-user"></i></a>
                    <a href="http://jamkridantbbersaing.com/" target="blank" class="hexagon grey ttip" data-ttip="website PT JAMKRIDA NTB Bersaing"><i class="fa fa-globe"></i></a>
                </div>
                <div id="tab2">		
                    <div class="widget content-tab grid12">
                        <table id="sppsb-ijp-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr class="bg-success">
                                    <th width="25%">Uraian</th>
                                    <th>3 Bln</th>
                                    <th>4 Bln</th>
                                    <th>5 Bln</th>
                                    <th>6 Bln</th>
                                    <th>7 Bln</th>
                                    <th>8 Bln</th>
                                    <th>9 Bln</th>
                                    <th>10 Bln</th>
                                    <th>11 Bln</th>
                                    <th>12 Bln</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rateSppsb as $key => $data)
                                <tr>
                                    <td>Jaminan {{ $data->title }}
                                        <div class="secExtra"><i class="fa fa-minus-square"></i> Min. biaya Rp.<span class="numeric text-danger">{{$data->min_biaya}}</span></div>
                                    </td>
                                    <td>{{ $data->tiga }}%</td>
                                    <td>{{ $data->empat }}%</td>
                                    <td>{{ $data->lima }}%</td>
                                    <td>{{ $data->enam }}%</td>
                                    <td>{{ $data->tujuh }}%</td>
                                    <td>{{ $data->delapan }}%</td>
                                    <td>{{ $data->sembilan }}%</td>
                                    <td>{{ $data->sepuluh }}%</td>
                                    <td>{{ $data->sebelas }}%</td>
                                    <td>{{ $data->duabelas }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tab3">		
                    <div class="widget content-tab grid12">
                        <table id="sp3kbg-ijp-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr class="bg-success">
                                    <th width="25%">Uraian</th>
                                    <th>3 Bln</th>
                                    <th>4 Bln</th>
                                    <th>5 Bln</th>
                                    <th>6 Bln</th>
                                    <th>7 Bln</th>
                                    <th>8 Bln</th>
                                    <th>9 Bln</th>
                                    <th>10 Bln</th>
                                    <th>11 Bln</th>
                                    <th>12 Bln</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rateSp3kbg as $key => $data)
                                <tr>
                                    <td>Jaminan {{ $data->title }}
                                        <div class="secExtra"><i class="fa fa-minus-square"></i> Min. biaya Rp.<span class="numeric text-danger">{{$data->min_biaya}}</span></div>
                                    </td>
                                    <td>{{ $data->tiga }}%</td>
                                    <td>{{ $data->empat }}%</td>
                                    <td>{{ $data->lima }}%</td>
                                    <td>{{ $data->enam }}%</td>
                                    <td>{{ $data->tujuh }}%</td>
                                    <td>{{ $data->delapan }}%</td>
                                    <td>{{ $data->sembilan }}%</td>
                                    <td>{{ $data->sepuluh }}%</td>
                                    <td>{{ $data->sebelas }}%</td>
                                    <td>{{ $data->duabelas }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- /topTabContent -->

        </div> <!-- /tab-container -->

        <!-- </div> -->
    </div> <!-- /topTabs -->

    <div class="divider"></div>

    <div class="fluid">				
        <div class="widget leftcontent grid12">
            <div class="widget-header">
                <h3 class="widget-title">INFORMASI DATA MASUK</h3>
                <div class="widget-controls">
                    <div class="btn-group xtra"> 
                        <!-- 
                        <a href="#" onclick="return false;" class="icon-button dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
                        <ul class="dropdown-menu pull-right">
    <li><a href="#"><i class="fa fa-pencil"></i> Edit</a></li>
    <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
    <li><a href="#"><i class="fa fa-ban"></i> Ban</a></li>
    <li class="divider"></li>
    <li><a href="#"> Other actions</a></li>
</ul>
                        -->
                    </div>
                </div>
            </div>
            <div class="widget-content pad20f">	
                <div class="alert alert-info" role="alert">
                    <h4><i class="fa fa-info-circle"></i> Informasi!</h4>
                    <ul style="padding-left: 20px !important;">
                        @if ($countBaru > 0)
                        <li>Terdapat <strong>{{ $countBaru }}</strong> SPPSB baru yang harus anda analisa kelayakan penjaminanya. Silahkan klik <a href="{{ url('/sppsb-sp3kbg-masuk') }}"><strong>disini</strong></a> untuk selengkapnya</li>
                        @else
                        <li>Belum ada SPPSB baru yang memerlukan analisa dari anda </li>
                        @endif
                        @if ($countSetuju > 0)
                        <li>Terdapat <strong>{{ $countSetuju }}</strong> SPPSB yang telah disetujui oleh Direksi dan butuh tindakan lanjutan untuk pengisian nomor registrasi dan pembuatan surat perjanjian mengganti kerugian. Silahkan klik <a href="{{ url('/sppsb-sp3kbg-masuk') }}"><strong>disini</strong></a> untuk selengkapnya</li>
                        @else
                        <li>Belum ada SPPSB yang telah disetujui oleh Direksi untuk anda tindak lanjuti</li>
                        @endif
                    </ul>
                </div>
            </div>					
            <div class="divider"></div>
        </div> <!-- /widget -->
    </div> <!-- /fluid -->
</div> <!-- /main -->
@endsection
@push('scripts')
<script>
    $(document).ready(function () {


    });
</script>    
@endpush