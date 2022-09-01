@extends('layouts.app')

@section('content')	
	<div id="main" class="clearfix">
		<!-- <div class="secInfo">
			<h1 class="secTitle">Data SPPSB Disetujui</h1>
			<span class="secExtra">Tabel daftar seluruh Surat Permohonan Penerbitan Surety Bond (SPPSB) yang disetujui</span>
		</div> 
		<div class="fluid">
			<div class="widget leftcontent grid12">
				<div class="widget-header">
					<div class="icon-grp">
						<strong>Keterangan:</strong>
						<a href="#" onclick="return false;" class="icon-button icon-color-grey">
							<i class="fa fa-search"></i>
						</a> lihat detail SPPSB
					</div>
				</div> -->
		<div class="topTabs">
			
			<div id="topTabs-container-home">
				<div class="topTabs-header clearfix">

					<div class="secInfo sec-dashboard">
						<h1 class="secTitle">Data Disetujui</h1>
						<span class="secExtra">Tabel daftar seluruh data yang disetujui:</span>
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
							<div class="widget-content">
								<table id="sppsb-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
								    <thead>
								        <tr>
								            <th width="30%">Nama Kontraktor</th>
								            <th>Jenis SPPSB</th>
								            <th>Tgl Pengajuan</th>
								            <th>Tgl Disetujui</th>
								            <th width="8%">Aksi</th>
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
								<table id="sp3kbg-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
								    <thead>
								        <tr>
								            <th width="30%">Nama Bank</th>
								            <th>Jenis SP3 KBG</th>
								            <th>Tgl Pengajuan</th>
								            <th>Tgl Disetujui</th>
								            <th width="8%">Aksi</th>
								        </tr>
								    </thead>
								    <tbody>
								    </tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="widget-content pad20f">	
					<div class="alert alert-info" role="alert">
						<strong><i class="fa fa-info-circle"></i> Informasi!</strong> Tabel diatas memuat semua data SPPSB yang telah disetujui oleh direksi
					</div>
				</div> -->
			</div>
		</div> <!-- /fluid -->

	</div> <!-- /main -->
@endsection

@push('scripts')
	<script>
	$(document).ready(function() {

	    $("#sppsb-datatable").DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '{{ url("/") }}/getdata-sppsb-disetujui',
	        columns: [
	            { data: 'nama_kontraktor', name: 'nama_kontraktor',
	            	render: function ( data, type, row ) {
	                	return '<strong>'+data+'</strong><div class="secExtra"><i class="fa fa-user"></i> '+row.direksi+'</div>';
	                }
	            },
	            { data: 'jenis_sppsb', name: 'jenis_sppsb',
	            	render: function ( data, type, row ) {
	            		var title = "";
	                    if(data=='1')title="Jaminan Penawaran";
	                    else if(data=='2')title="Jaminan Pelaksanaan";
	                    else if(data=='3')title="Jaminan Uang Muka";
	                    else if(data=='4')title="Jaminan Pemeliharaan";
	                    else if(data=='5')title="Jaminan pembayaran";
	                    else if(data=='6')title="Jaminan Sanggah Banding";
	                	return '<strong>'+title+'</strong>';
	                }
	            },
	            { data: 'tgl_pengajuan', name: 'tgl_pengajuan', sClass:'text-center' },
	            { data: 'tgl_disetujui', name: 'tgl_disetujui', sClass:'text-center' },
	            { data: 'action', name: 'action', sClass:'text-center', orderable: false, searchable: false }
	        ],
	        aaSorting: []
	    });
		$("#sp3kbg-datatable").DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '{{ url("/") }}/getdata-sp3kbg-disetujui',
	        columns: [
	            { data: 'name', name: 'name',
	            	render: function ( data, type, row ) {
	                	return '<strong>'+data+'</strong><div class="secExtra">'+row.address+'<br/>'+row.wilayah+'</div>';
	                }
	            },
	            { data: 'jenis_sp3kbg', name: 'jenis_sp3kbg',
	            	render: function ( data, type, row ) {
	            		var title = "";
	                    if(data=='1')title="Jaminan Penawaran";
	                    else if(data=='2')title="Jaminan Pelaksanaan";
	                    else if(data=='3')title="Jaminan Uang Muka";
	                    else if(data=='4')title="Jaminan Pemeliharaan";
	                    else if(data=='5')title="Jaminan pembayaran";
	                    else if(data=='6')title="Jaminan Sanggah Banding";
	                	return '<strong>'+title+'</strong>';
	                }
	            },
	            { data: 'tgl_pengajuan', name: 'tgl_pengajuan', sClass:'text-center' },
	            { data: 'tgl_disetujui', name: 'tgl_disetujui', sClass:'text-center' },
	            { data: 'action', name: 'action', sClass:'text-center', orderable: false, searchable: false }
	        ],
	        aaSorting: []
	    });
	});
	</script>    
@endpush