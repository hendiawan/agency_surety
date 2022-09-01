@extends('layouts.app')

@section('content')	
<div id="main" class="clearfix">
    <div class="topTabs">

        <div id="topTabs-container-home">
            <div class="topTabs-header clearfix">

                <div class="secInfo sec-dashboard">
                    <h1 class="secTitle">List Data Draft</h1>
                    <span class="secExtra">Tabel daftar data draft untuk:</span>
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
                        <li>
                            Tabel dibawah memuat semua data SPPSB atau SP3 KBG yang masih dalam status draft atau on progress
                        </li>
                        <li>
                            Untuk melakukan proses <code>delete data</code>, silahkan pastikan data benar-benar sudah tidak diperlukan lagi. <code>Data yang telah terhapus tidak dapat dikembalikan!</code>
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
                                        <th>Jenis</th>
                                        <th>Nilai Jaminan</th>
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
                                        <th>Jenis</th>
                                        <th>Nilai</th>
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

        $(document).on('click', '.popovers', function (e) {
            e.preventDefault();
            $('.popovers').popover({html: true, placement: 'left', trigger: 'manual'}).popover('show').not(this).popover('hide');
            return false;
        });
        $(document).on('click', '.po-close', function () {
            $('.popovers').popover('hide');
            return false;
        });

        var tableSppsb = $("#sppsb-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("/") }}/getdata-draft-sppsb',
            columns: [
                {data: 'nama_kontraktor', name: 'nama_kontraktor',
                    render: function (data, type, row) {
                        return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-user"></i> ' + row.direksi + '</div>';
                    }
                },
                {data: 'jenis_sppsb', name: 'jenis_sppsb',
                    render: function (data, type, row) {
                        var title = "";
                        if (data == '1')
                            title = " Penawaran";
                        else if (data == '2')
                            title = " Pelaksanaan";
                        else if (data == '3')
                            title = " Uang Muka";
                        else if (data == '4')
                            title = " Pemeliharaan";
                        else if (data == '5')
                            title = " pembayaran";
                        else if (data == '6')
                            title = " Sanggah Banding";
                        return '<strong>' + title + '</strong>';
                    }},
                {data: 'nilai_jaminan', name: 'nilai_jaminan'},
                {data: 'jabatan', name: 'jabatan',
                    render: function (data, type, row) {
                        return '<strong>' + data + ' (' + row.name + ')' + '</strong><div class="secExtra"><i class="fa fa-address-card-o"></i> ' + row.no_jaminan + '</div>';
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
                        } else if (data == 'P') {
                            label = "label-info";
                            title = "diProses" } else if (data == 'C') {
                            label = "label-success"; title = "Closeing"
                        } else if (data == 'H') {
                            label = "label-danger";
                            title = "Reject"
                        }
                        return '<span class="label ' + label + ' label-mini ' + row.direksi + '">' + title + ' </span>';
                    }
                },

                {data: 'tgl_pengajuan', name: 'tgl_pengajuan', sClass: 'text-center'},
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            aaSorting: []
        });

        var tableSp3kbg = $("#sp3kbg-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("/") }}/getdata-draft-sp3kbg',
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
                        } else if (data == 'P') {
                            label = "label-info";
                            title = "diproses"
                        }
                        return '<span class="label ' + label + ' label-mini ' + row.direksi + '">' + title + '</span>';
                    }
                },
                {data: 'tgl_pengajuan', name: 'tgl_pengajuan', sClass: 'text-center'},
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            aaSorting: []
        });
        //delete data sppsb
        $(document).on('click', '.po-delete-sppsb', function () {
            var id = $(this).attr('id');
            $('#customLoad').show();
            $('.popovers').popover('hide');
            $.ajax({
                url: '{{ url("/") }}/delete-data-sppsb/' + id,
                type: "GET",
                cache: false,
                data: "",
                success: function (response) {
                    $('#customLoad').hide();
                    if (response) {
                        $('#sppsb-datatable').before('<div class="alert alert-success">'
                                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                                + '<i class="fa fa-info-circle"></i> SUKSES! Anda berhasil menghapus data Obligee</div>');
                        tableSppsb.ajax.reload();
                    } else {
                        $('#sppsb-datatable').before('<div class="alert alert-danger">'
                                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                                + '<i class="fa fa-info-circle"></i> GAGAL! Anda gagal menghapus data Obligee karna telah digunakan oleh table Pengajuan</div>');
                    }
                },
                error: function (e) {
                    alert("there are something wrong " + e);
                    $('#customLoad').hide();
                }

            });
            setTimeout(function () {
                $('.alert-success, .alert-danger').slideUp("slow", function () {
                    $(this).remove();
                });
            }, 3000);
        });
        //delete data sp3kbg
        $(document).on('click', '.po-delete-sp3kbg', function () {
            var id = $(this).attr('id');
            $('#customLoad').show();
            $('.popovers').popover('hide');
            $.ajax({
                url: '{{ url("/") }}/delete-data-sp3kbg/' + id,
                type: "GET",
                cache: false,
                data: "",
                success: function (response) {
                    $('#customLoad').hide();
                    if (response) {
                        $('#sp3kbg-datatable').before('<div class="alert alert-success">'
                                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                                + '<i class="fa fa-info-circle"></i> SUKSES! Anda berhasil menghapus data Obligee</div>');
                        tableSp3kbg.ajax.reload();
                    } else {
                        $('#sp3kbg-datatable').before('<div class="alert alert-danger">'
                                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                                + '<i class="fa fa-info-circle"></i> GAGAL! Anda gagal menghapus data Obligee karna telah digunakan oleh table Pengajuan</div>');
                    }
                },
                error: function (e) {
                    alert("there are something wrong " + e);
                    $('#customLoad').hide();
                }

            });
            setTimeout(function () {
                $('.alert-success, .alert-danger').slideUp("slow", function () {
                    $(this).remove();
                });
            }, 3000);
        });
    });
</script>    
@endpush