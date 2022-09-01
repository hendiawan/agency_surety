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
                                <i class="fa fa-inbox"></i><br>SPPSB Masuk
                            </span>
                            <i class="fa icon-hidden fa-inbox ttip" data-ttip="SPPSB Masuk"></i>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#tab2">
                            <span class="to-hide">
                                <i class="fa fa-inbox"></i><br>SP3 KBG Masuk
                            </span>
                            <i class="fa icon-hidden fa-inbox ttip" data-ttip="SP3 KBG Masuk"></i>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#tab3">
                            <span class="to-hide">
                                <i class="fa fa-pencil"></i><br>Manage Tanda Tangan
                            </span>
                            <i class="fa icon-hidden fa-pencil ttip" data-ttip="Manage Tanda Tangan"></i>
                        </a>
                    </li>
                </ul> <!-- /tabs -->
            </div><!-- /topTabs-header -->

            <div class="topTabsContent" style="padding-left:0;">
                <div id="tab1" style="padding-left:30px;">			
                    <div class="widget content-tab grid12">
                        <div class="alert alert-info" role="alert">
                            <h4><i class="fa fa-info-circle"></i> Informasi!</h4>
                            <ul style="padding-left: 20px !important;">
                                @if ($countProses > 0)	
                                <li>Terdapat <strong>{{ $countProses }}</strong> SPPSB baru yang memerlukan persetujuan dari anda</li>
                                <li>Silahkan lakukan pengecekan kembali secara menyeluruh sebelum memberikan tanda tangan persetujuan</li>
                                @else
                                <li>Belum ada SPPSB baru yang memerlukan persetujuan dari anda </li>
                                @endif
                            </ul>
                        </div>
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
                                    <th>Agen/Pemasar</th>
                                    <th>Jenis SPPSB</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
                <div id="tab2" style="padding-left:30px;">			
                    <div class="widget content-tab grid12">
                        <div class="alert alert-info" role="alert">
                            <h4><i class="fa fa-info-circle"></i> Informasi!</h4>
                            <ul style="padding-left: 20px !important;">
                                @if ($countProses > 0)	
                                <li>Terdapat <strong>{{ $countProses }}</strong> SP3 KBG baru yang memerlukan persetujuan dari anda</li>
                                <li>Silahkan lakukan pengecekan kembali secara menyeluruh sebelum memberikan tanda tangan persetujuan</li>
                                @else
                                <li>Belum ada SP3 KBG baru yang memerlukan persetujuan dari anda </li>
                                @endif
                            </ul>
                        </div>
                        <table id="sp3kbg-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="25%">Nama Bank</th>
                                    <th>Agen/Pemasar</th>
                                    <th>Jenis SP3 KBG</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
                <div id="tab3">
                    <div class="widget-header">
                        <h3 class="widget-title">SETUP TEMPLATE TANDA TANGAN DIREKSI</h3>
                    </div>
                    <div class="widget-content pad20f">
                        <div id="smoothed" class="form-group">
                            <div class="col-md-8">
                                <div id="signature-pad" class="m-signature-pad">
                                    <div class="m-signature-pad--body">
                                        <canvas></canvas>
                                    </div>
                                    <div class="m-signature-pad--footer">
                                        <div class="description">Sign above</div>
                                        <div class="left">
                                            <button type="button" class="btn btn-red clear" data-action="clear"><i class="fa fa-eraser"></i> hapus</button>
                                        </div>
                                        <div class="right">
                                            <button id="updateSign" type="button" class="btn save" data-action="save-png"><i class="fa fa-save"></i> simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="subtitle">Template Tanda Tangan Saat ini</p>
                                <p id="current-signature">
                                    <img src="{{ $ttd->value }}" />
                                </p>
                                <p class="subtitle">Dibuat tgl: <span>{{ $ttd->created_date }}</span></p>
                                <form method="POST" action="{{ url('/') }}/update-signed-master">
                                    {!! csrf_field() !!}
                                    <input type="hidden" id="sppsb_id" name="id" value="1">
                                    <input type="hidden" id="ttdImg" name="ttd" value="{{ $ttd->value }}">
                                    <p id="btnUpdate" class="hide"><button type="submit" class="btn btn-blue"><i class="fa fa-save"></i> UPDATE TTD</button></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /topTabContent -->

        </div> <!-- /tab-container -->

        <!-- </div> -->
    </div> <!-- /topTabs -->

</div> <!-- /main -->
@endsection

@push('scripts')
<link rel="stylesheet" href="{{ asset('/css/signature-pad.css') }}" />

<script type="text/javascript" src="{{ asset('/js/signature_pad.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/app_signature.js') }}"></script>
<script>
$(document).ready(function () {

    $("#sppsb-datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url("/") }}/getdata-sppsb-layak',
        columns: [
            {data: 'nama_kontraktor', name: 'nama_kontraktor',
                render: function (data, type, row) {
                    return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-user"></i> ' + row.direksi + '</div>';
                }
            },
            {data: 'jabatan', name: 'jabatan',
                render: function (data, type, row) {
                    return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-address-card-o"></i> ' + row.name + '</div>';
                }
            },
            {data: 'jenis_sppsb', name: 'jenis_sppsb',
                render: function (data, type, row) {
                    var title = "";
                    if (data == '1')
                        title = "Jaminan Penawaran";
                    else if (data == '2')
                        title = "Jaminan Pelaksanaan";
                    else if (data == '3')
                        title = "Jaminan Uang Muka";
                    else if (data == '4')
                        title = "Jaminan Pemeliharaan";
                    else if (data == '5')
                        title = "Jaminan pembayaran";
                    else if (data == '6')
                        title = "Jaminan Sanggah Banding";
                    return '<strong>' + title + '</strong>';
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
        ajax: '{{ url("/") }}/getdata-sp3kbg-layak',
        columns: [
            {data: 'nama_bank', name: 'nama_bank',
                render: function (data, type, row) {
                    return '<strong>' + data + '</strong><div class="secExtra">' + row.address + '<br/>' + row.wilayah + '</div>';
                }
            },
            {data: 'jabatan', name: 'jabatan',
                render: function (data, type, row) {
                    return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-address-card-o"></i> ' + row.name + '</div>';
                }
            },
            {data: 'jenis_sp3kbg', name: 'jenis_sp3kbg',
                render: function (data, type, row) {
                    var title = "";
                    if (data == '1')
                        title = "Jaminan Penawaran";
                    else if (data == '2')
                        title = "Jaminan Pelaksanaan";
                    else if (data == '3')
                        title = "Jaminan Uang Muka";
                    else if (data == '4')
                        title = "Jaminan Pemeliharaan";
                    else if (data == '5')
                        title = "Jaminan pembayaran";
                    else if (data == '6')
                        title = "Jaminan Sanggah Banding";
                    return '<strong>' + title + '</strong>';
                }
            },
            {data: 'tgl_pengajuan', name: 'tgl_pengajuan', sClass: 'text-center'},
            {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
        ],
        aaSorting: []
    });
    /*
     $('#updateSign').on('click', function(){
     var sign = $('#current-signature img').atrr('src');
     alert(sign);
     
     $.ajax({
     url: '/ajax-update-signed-master/',
     data: {ttd : signaturePad.toDataURL()},
     type: 'POST',
     success:function(response){
     
     },
     error:function(e){
     alert("there are something wrong "+e);
     }
     });
     })
     */
});
</script>    
@endpush