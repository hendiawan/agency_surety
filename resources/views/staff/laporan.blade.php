@extends('layouts.app')

@section('content')	
<div id="main" class="clearfix">
    <div class="topTabs">

        <div id="topTabs-container-home">
            <div class="topTabs-header clearfix">

                <div class="secInfo sec-dashboard">
                    <h1 class="secTitle">Laporan</h1>
                    <span class="secExtra">Laporan  SPPSB &amp; SP3KBG berdasarkan:</span>
                </div> <!-- /SecInfo -->

                <ul class="etabs tabs">
                    <li class="tab">
                        <a href="#tab1">
                            <span class="to-hide">
                                <i class="fa fa-address-card-o"></i><br>Agen Detail
                            </span>
                            <i class="fa icon-hidden fa-address-card-o ttip" data-ttip="Agen Detail"></i>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#tab2">
                            <span class="to-hide">
                                <i class="fa fa-users"></i><br>Rekap Agen
                            </span>
                            <i class="fa icon-hidden fa-users ttip" data-ttip="Rekap Agen"></i>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#tab3">
                            <span class="to-hide">
                                <i class="fa fa-map-marker"></i><br>Per Wilayah
                            </span>
                            <i class="fa icon-hidden fa-map-marker ttip" data-ttip="Per Wilayah"></i>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#tab4">
                            <span class="to-hide">
                                <i class="fa fa-hand-paper-o"></i><br>Belum Terbit
                            </span>
                            <i class="fa icon-hidden fa-hand-paper-o ttip" data-ttip="Belum Terbit"></i>
                        </a>
                    </li>
                   
                </ul> <!-- /tabs -->
            </div><!-- /topTabs-header -->

            <div class="topTabsContent">
                <div id="tab1">	
                    <div class="widget content-tab grid12">	    
                        <form id="sppsbForm" class="form-horizontal" action="{{ url('/cetak-laporan-agen-detail') }}" method="POST" target="_blank">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-2 control-label"><strong>Nama Agen</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                    <select id="selectAgen" name="agen" class="form-control">
                                         <option value="all">Semua Penjaminan</option>
                                        @foreach($agen as $key => $item) 
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
                                        <!--<button id="searchAgenDetail" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                        <button id="cetakAgenDetail" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2 col-xs-2 control-label"><strong>Periode Terbit</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                    <div class="input-group">
                                        <input type="text" id="startDate" class="form-control" name="startDate" value="{{ old('startDate') }}" placeholder="dd-mm-yyyy">
                                        <span class="input-group-addon">s/d</span>
                                        <input type="text" id="expiredDate" class="form-control" name="endDate" value="{{ old('endDate') }}" placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
                                    <button id="searchAgenDetail" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                    <button id="cetakAgenDetail" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>
                                </div>
                            </div>
                        </form>
                        <hr/>
                        <div class="table-responsive">
                            <table id="agen-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sppsb ID</th>
                                        <th>Agen</th>
                                        <th>Tgl</th>
                                        <th>Nama</th>
                                        <th>No Sertifikat</th>
                                        <th>Mulai</th>
                                        <th>Akhir</th>
                                        <th>Service Charge</th>
                                        <th>Gross IJP</th>
                                        <th>Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="tab2">		
                    <div class="widget content-tab grid12">		    
                        <form id="sppsbForm" class="form-horizontal" action="{{ url('/cetak-laporan-rekap-agen') }}" method="POST" target="_blank">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-2 col-xs-2 control-label"><strong>Periode Terbit</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                    <div class="input-group">
                                        <input type="text" id="startDate1" class="form-control" name="startDate1" value="{{ old('startDate1') }}" placeholder="dd-mm-yyyy">
                                        <span class="input-group-addon">s/d</span>
                                        <input type="text" id="expiredDate1" class="form-control" name="endDate1" value="{{ old('endDate1') }}" placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
                                    <button id="searchRekapAgen" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                    <button id="cetakRekapAgen" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>
                                </div>
                            </div>
                        </form>
                        <hr/>
                        <div class="table-responsive">
                            <table id="rekap-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Agen</th>
                                        <th>Sertifikat Terbit</th>
                                        <th>Sisa Sertifikat</th>
                                        <th>IJP Gross</th>
                                        <th>Admin</th>
                                        <th>Fee Agen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="tab3">
                    <div class="widget content-tab grid12">	    
                        <form id="sppsbForm" class="form-horizontal" action="{{ url('/cetak-laporan-perwilayah') }}" method="POST" target="_blank">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-2 col-xs-2 control-label"><strong>Periode Terbit</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                    <div class="input-group">
                                        <input type="text" id="startDate2" class="form-control" name="startDate2" value="{{ old('startDate2') }}" placeholder="dd-mm-yyyy">
                                        <span class="input-group-addon">s/d</span>
                                        <input type="text" id="expiredDate2" class="form-control" name="endDate2" value="{{ old('endDate2') }}" placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
                                    <button id="searchPerWilayah" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                    <button id="cetakPerWilayah" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>

                                </div>
                            </div>
                        </form>
                        <hr/>
                        <div class="table-responsive">
                            <table id="wilayah-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Wilayah</th>
                                        <th>Sertifikat Terbit</th>
                                        <th>Sisa Sertifikat</th>
                                        <th>IJP Gross</th>
                                        <th>Admin</th>
                                        <th>Fee Agen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="tab4">
                    <div class="widget content-tab grid12">
                        <form id="sppsbForm" class="form-horizontal" action="{{ url('/cetak-laporan-belum-terbit') }}" method="POST" target="_blank">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-2 control-label"><strong>Nama Agen</strong></label>
                                <div class="col-xs-5">
                                    <select id="selectAgen2" name="agen" class="form-control">
                                        <option></option>
                                        @foreach($agen as $key => $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-5 text-right">
                                    <button id="searchBlmTampil" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                    <button id="cetakBlmTampil" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>
                                </div>
                            </div>
                        </form>
                        <hr/>
                        <table id="blmterbit-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>No Registrasi</th>
                                    <th>Type</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                 
            </div>
        </div>	
    </div>
</div>
@endsection
@push('scripts')  
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker3.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/select2-4.0.3.css') }}" />

<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/select2.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#selectAgen').select2({
        placeholder: "Silahkan pilih Agen...",
        allowClear: true
    });
    
    $('#selectAgen2').select2({
        placeholder: "Silahkan pilih Agen...",
        allowClear: true
    });
    $("#agen-datatable-all").DataTable();
    $("#agen-datatable").DataTable();
    $("#rekap-datatable").DataTable();
    $("#wilayah-datatable").DataTable();
    $("#blmterbit-datatable").DataTable();

    if (($('#startDate').length) && ($('#expiredDate').length)) {
        $('#startDate').datepicker({
//            format: 'mm-yyyy',
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
//            viewMode: "months",
//            minViewMode: "months"
        }).on('changeDate', function (e) {
            $('#expiredDate').datepicker('setStartDate', e.date);
        });
        $('#expiredDate').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
//            viewMode: "months",
//            minViewMode: "months"
        }).on('changeDate', function (e) {
            $('#startDate').datepicker('setEndDate', e.date);
        });
    }
    if (($('#startDateAll').length) && ($('#expiredDateAll').length)) {
        $('#startDateAll').datepicker({
            format: 'mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            viewMode: "months",
            minViewMode: "months"
        }).on('changeDate', function (e) {
            $('#expiredDateAll').datepicker('setStartDate', e.date);
        });
        $('#expiredDateAll').datepicker({
            format: 'mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            viewMode: "months",
            minViewMode: "months"
        }).on('changeDate', function (e) {
            $('#startDateAll').datepicker('setEndDate', e.date);
        });
    }
    if (($('#startDate1').length) && ($('#expiredDate1').length)) {
        $('#startDate1').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (e) {
            $('#expiredDate1').datepicker('setStartDate', e.date);
        });
        $('#expiredDate1').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (e) {
            $('#startDate1').datepicker('setEndDate', e.date);
        });
    }
    if (($('#startDate2').length) && ($('#expiredDate2').length)) {
        $('#startDate2').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (e) {
            $('#expiredDate2').datepicker('setStartDate', e.date);
        });
        $('#expiredDate2').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (e) {
            $('#startDate2').datepicker('setEndDate', e.date);
        });
    }
    ///proses search report detail by agen
    $('#searchAgenDetail').on('click', function () {
        //var agenId = $('#selectAgen').val();
        $('#agen-datatable').DataTable().destroy();
        $("#agen-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("/") }}/getdata-detail-agen/{id}/{startDate}/{endDate}',
                type: 'GET',
                data: {
                    id: $('#selectAgen').val(),
                    startDate: $('#startDate').val(),
//                    startDate: '01-' + $('#startDate').val(),
                    endDate: $('#expiredDate').val()
//                    endDate: '01-' + $('#expiredDate').val()
                }

            },
            columns: [
                {data: 'id',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }, sClass: 'text-center'
                },
                {data: 'id', name: 'id'},
                {data: 'nama', name: 'nama'},
                {data: 'created_at', name: 'created_at'},
                {data: 'nama_kontraktor', name: 'kontraktor'},
                {data: 'no_jaminan', name: 'no_jaminan'},
                {data: 'mulai', name: 'mulai'},
                {data: 'waktu_selesai', name: 'akhir'},
                {data: 'bulat_ijp', name: 'bulat_ijp', sClass: 'text-right'},
                {data: 'gross_ijp', name: 'gross_ijp', sClass: 'text-right'},
                {data: 'fee_agen', name: 'fee_agen', sClass: 'text-right'}
            ],
            aaSorting: []
        });
    })
    ///proses search report All
 

    ///proses search report detail by agen
    $('#searchRekapAgen').on('click', function () {
        //var agenId = $('#selectAgen').val();
        $('#rekap-datatable').DataTable().destroy();
        $("#rekap-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("/") }}/getdata-rekap-agen/{startDate}/{endDate}',
                type: 'GET',
                data: {
                    startDate: $('#startDate1').val(),
                    endDate: $('#expiredDate1').val()
                }

            },
            columns: [
                {data: 'type', name: 'type', sClass: 'text-center',
                    render: function (data, type, row) {
                        var label = "", title = "";
                        if (data == 'sppsb') {
                            label = "label-primary";
                            title = "SPPSB"
                        } else if (data == 'sp3kbg') {
                            label = "label-success";
                            title = "SP3 KBG"
                        }
                        return '<span class="label ' + label + '">' + title + '</span>';
                    }
                },
                {data: 'name', name: 'name'},
                {data: 'count_terbit', name: 'count_terbit'},
                {data: 'count_belum', name: 'count_belum'},
                {data: 'gross_ijp', name: 'gross_ijp', sClass: 'text-right'},
                {data: 'fee_admin', name: 'fee_admin', sClass: 'text-right'},
                {data: 'fee_agen', name: 'fee_agen', sClass: 'text-right'}
            ],
            aaSorting: []
        });
    })
    ///proses search report detail by wilayah
    $('#searchPerWilayah').on('click', function () {
        //var agenId = $('#selectAgen').val();
        $('#wilayah-datatable').DataTable().destroy();
        $("#wilayah-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("/") }}/getdata-rekap-wilayah/{startDate}/{endDate}',
                type: 'GET',
                data: {
                    startDate: $('#startDate2').val(),
                    endDate: $('#expiredDate2').val()
                }

            },
            columns: [
                {data: 'type', name: 'type', sClass: 'text-center',
                    render: function (data, type, row) {
                        var label = "", title = "";
                        if (data == 'sppsb') {
                            label = "label-primary";
                            title = "SPPSB"
                        } else if (data == 'sp3kbg') {
                            label = "label-success";
                            title = "SP3 KBG"
                        }
                        return '<span class="label ' + label + '">' + title + '</span>';
                    }
                },
                {data: 'wilayah_agensi', name: 'wilayah_agensi'},
                {data: 'count_terbit', name: 'count_terbit'},
                {data: 'count_belum', name: 'count_belum'},
                {data: 'gross_ijp', name: 'gross_ijp', sClass: 'text-right'},
                {data: 'fee_admin', name: 'fee_admin', sClass: 'text-right'},
                {data: 'fee_agen', name: 'fee_agen', sClass: 'text-right'}
            ],
            aaSorting: []
        });
    })
    ///proses search report data table belum terbit 
    $('#searchBlmTampil').on('click', function () {
        //var agenId = $('#selectAgen2').val();
        $('#blmterbit-datatable').DataTable().destroy();
        $("#blmterbit-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("/") }}/getdata-belum-terbit/{id}',
                type: 'GET',
                data: {
                    id: $('#selectAgen2').val()
                }

            },
            columns: [
                {data: 'rank', name: 'rank', sClass: 'text-center'},
                {data: 'no_registrasi', name: 'no_registrasi'},
                {data: 'type', name: 'type', sClass: 'text-center',
                    render: function (data, type, row) {
                        var label = "", title = "";
                        if (data == 'sppsb') {
                            label = "label-primary";
                            title = "SPPSB"
                        } else if (data == 'sp3kbg') {
                            label = "label-success";
                            title = "SP3 KBG"
                        }
                        return '<span class="label ' + label + '">' + title + '</span>';
                    }
                },
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            aaSorting: []
        });
    })
});
</script>
@endpush