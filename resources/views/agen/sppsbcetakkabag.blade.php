@extends('layouts.app')

@section('content')	
<div id="main" class="clearfix">
    <div class="topTabs">
        @if(Session::has('msgupdateaxis'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-info-circle"></i> {{ Session::get('msgupdateaxis') }}
        </div>
        @endif
        @if(Session::has('msgupdate'))
        <br>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
        </div>
        @endif
        <div id="topTabs-container-home">
            <div class="topTabs-header clearfix">

                <div class="secInfo sec-dashboard">
                    <h1 class="secTitle">Cetak Sertifikat</h1>
                    <span class="secExtra">Tabel daftar seluruh data:</span>
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
            <div class="topTabsContent" style="padding-left:0;">
                <div id="tab1">
                    <div class="widget content-tab grid12" style="padding-left:30px;">
                        <table id="sppsb-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                     <th>Nomor Sertifikat</th>
                                    <th width="30%">Nama Kontraktor</th>
                                    <th>Jenis</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Tgl Disetujui</th>
                                    <th width="15%">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tab2">
                    <div class="widget content-tab grid12" style="padding-left:30px;">
                        <table id="sp3kbg-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="30%">Nama Kontraktor</th>
                                    <th>Jenis SP3KBG</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Tgl Disetujui</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
          
        </div>
    </div> <!-- /fluid -->

</div> <!-- /main -->
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('/js/jquery.printPage.js') }}"></script>
<script>
$(document).ready(function () {
    $(document).ajaxComplete(function () {
 
    });
    
 
      var url = "getdata-sppsb-cetak-kabag";
      function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        }
        

    $("#sppsb-datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url("/") }}/'+url,
        columns: [
            
        { data: 'no_jaminan', name: 'no_jaminan',
	            	render: function ( data, type, row ) {
                                            if(data==null){var pesan ='Belum Terbit'}else{pesan=data}
	                	return '<strong>'+pesan+'</strong>\n\
                                              <div class="secExtra"><i class="fa fa-user"></i> '+row.name+'</div>\n\
                                               <strong>'+row.no_sertifikat+'</strong>   <div class="secExtra"> Nilai Jaminan : Rp.  '+formatNumber(Math.ceil(row.nilai_jaminan))+'</div>';
	                }
	            },
            {data: 'nama_kontraktor', name: 'nama_kontraktor',
                render: function (data, type, row) {
                    return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-user"></i> ' + row.direksi + '</div>';
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
            {data: 'tgl_disetujui', name: 'tgl_disetujui', sClass: 'text-center'},
            {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
        ],
        aaSorting: []
    });

    $("#sp3kbg-datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url("/") }}/getdata-sp3kbg-cetak',
        columns: [
            {data: 'nama_kontraktor', name: 'nama_kontraktor',
                render: function (data, type, row) {
                    return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-user"></i> ' + row.direksi + '</div>';
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
            {data: 'tgl_disetujui', name: 'tgl_disetujui', sClass: 'text-center'},
            {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
        ],
        aaSorting: []
    });

});
</script>    
@endpush