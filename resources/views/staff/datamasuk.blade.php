@extends('layouts.app')

@section('content')	
<div id="main" class="clearfix">
    <div class="topTabs">

        <div id="topTabs-container-home">
            <div class="topTabs-header clearfix">

                <div class="secInfo sec-dashboard">
                    <h1 class="secTitle">List Data Masuk</h1>
                    <span class="secExtra">Tabel daftar data masuk untuk:</span>
                </div> <!-- /SecInfo -->

                <ul class="etabs tabs">
                    <li class="tab">
                        <a href="#tab1">
                            <span class="to-hide">
                                <i class="fa fa-folder-open"></i><br>Data SPPSB
                            </span>
                            <i class="fa icon-hidden fa-folder-open ttip" data-ttip="Data SPPSB"></i>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#tab2">
                            <span class="to-hide">
                                <i class="fa fa-folder-open-o"></i><br>Data SP3 KBG
                            </span>
                            <i class="fa icon-hidden fa-folder-open-o ttip" data-ttip="Data SP3 KBG"></i>
                        </a>
                    </li>
                </ul> <!-- /tabs -->
            </div><!-- /topTabs-header -->

            <div class="widget-content pad20f" style="padding-bottom:0">	
                <div class="alert alert-info" style="margin-bottom:0" role="alert">
                    <h4><i class="fa fa-info-circle"></i> Informasi!</h4>
                    <ul style="padding-left: 20px !important;">
                        <li>Tabel dibawah memuat semua data SPPSB atau SP3 KBG yang telah disetujui oleh direksi ataupun yang baru diajukan oleh agen</li>
                        <li>
                            Untuk tombol penomoran data SPPSB atau SP3 KBG pada kolom "Aksi" hanya akan muncul untuk data SPPSB atau SP3 KBG yang telah disetujui oleh direksi
                        </li>
                    </ul>
                </div>
            </div>
            <div class="topTabsContent" style="padding-left:0;">
                <div id="tab1">
                    <div class="widget content-tab grid12" style="padding-left:30px;">
                        <!--
                        <div class="widget-header">
                                <div class="icon-grp">
                                        <strong>Keterangan:</strong>
                                        <a href="#" onclick="return false;" class="icon-button icon-color-blue">
                                                <i class="fa fa-pencil-square-o"></i>
                                        </a> cek detail SPPSB untuk analisa
                                        <a href="#" onclick="return false;" class="icon-button icon-color-green">
                                                <i class="fa fa-barcode"></i>
                                        </a> penomoran SPPSB yang disetujui
                                </div>
                        </div>
                        -->
                        <div class="widget-content">	
                            @if(Session::has('msgupdate'))
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
                            </div>
                            @endif
                            <table id="sppsb-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="25%">Nama Kontraktor</th>
                                        <th>Alamat</th>
                                        <th>Agen/Pemasar</th>
                                        <th>Status</th>
                                        <th>Tgl Pengajuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>					        
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="tab2">
                    <div class="widget content-tab grid12" style="padding-left:30px;">
                        <div class="widget-content">	
                            @if(Session::has('msgupdate'))
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
                            </div>
                            @endif
                            <table id="sp3kbg-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="25%">Nama Kontraktor</th>
                                        <th>Alamat</th>
                                        <th>Agen/Pemasar</th>
                                        <th>Status</th>
                                        <th>Tgl Pengajuan</th>
                                        <th>Aksi</th>
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
    </div> <!-- /fluid -->

</div> <!-- /main -->
@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        $("#sppsb-datatable").DataTable({
            processing: true,
            serverSide: true,
            scrollX:true,
            ajax: '{{ url("/") }}/getdata-sppsb-masuk',
            columns: [
                {data: 'nama_kontraktor', name: 'nama_kontraktor',
                    render: function (data, type, row) {
                        return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-user"></i> ' + row.direksi + '</div>';
                    }
                },
                {data: 'alamat_kontraktor', name: 'alamat_kontraktor'},
                {data: 'jabatan', name: 'jabatan',
                    render: function (data, type, row) {
                        return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-address-card-o"></i> ' + row.name + '</div>';
                    }
                },
                {data: 'status', name: 'status', sClass: 'text-center',
                    render: function (data, type, row) {
                        var label = "", title = "";
                        if (data == 'B') {
                            label = "label-primary";
                            title = "baru"
                        } else if (data == 'T') {
                            label = "label-danger";
                            title = "ditolak"
                        } else if (data == 'R') {
                            label = "label-warning";
                            title = "direvisi"
                        } else if (data == 'S') {
                            label = "label-success";
                            title = "disetujui"
                        }
                        return '<span class="label ' + label + ' label-mini ' + row.direksi + '">' + title + '</span>';
                    }
                },
                {data: 'tgl_pengajuan', name: 'tgl_pengajuan', sClass: 'text-center'},
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            aaSorting: []
        });

        $("#sp3kbg-datatable").DataTable({
            processing: true,
            serverSide: true,
            scrollX:true,
            ajax: '{{ url("/") }}/getdata-sp3kbg-masuk',
            columns: [
                {data: 'nama_kontraktor', name: 'nama_kontraktor',
                    render: function (data, type, row) {
                        return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-user"></i> ' + row.direksi + '</div>';
                    }
                },
                {data: 'alamat_kontraktor', name: 'alamat_kontraktor'},
                {data: 'jabatan', name: 'jabatan',
                    render: function (data, type, row) {
                        return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-address-card-o"></i> ' + row.name + '</div>';
                    }
                },
                {data: 'status', name: 'status', sClass: 'text-center',
                    render: function (data, type, row) {
                        var label = "", title = "";
                        if (data == 'B') {
                            label = "label-primary";
                            title = "baru"
                        } else if (data == 'T') {
                            label = "label-danger";
                            title = "ditolak"
                        } else if (data == 'R') {
                            label = "label-warning"; title = "direvisi" } else if (data == 'S') {
                            label = "label-success";
                            title = "disetujui"
                        }
                        return '<span class="label ' + label + ' label-mini ' + row.direksi + '">' + title + '</span>';
                    }
                },
                {data: 'tgl_pengajuan', name: 'tgl_pengajuan', sClass: 'text-center'},
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            aaSorting: []
        });
    });
</script>    
@endpush