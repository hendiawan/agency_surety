<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cetak Detail SPPSB</title>
    <style type="text/css">

    	body{
    		font-family: 'Dejavu Sans';
    		font-size: 12px;
    	}
    	.widget-header {
			width: 100%;
		}
		.widget-header h3{
			font-size: 14px;
		}
		.widget-header h3{
			margin-bottom: 10px;
		}
		.widget-title {
			font-size: 18px;
			color: #3e3e3e;
			line-height: 26px;
			margin:0;
			margin-left: 20px;
		}
		.widget-content.pad20f {
		    padding: 0 20px 20px;
		}
		p {
		    margin: 0 0 10px;
		}
		.page-break {
		    page-break-after: always;
		}
		.divider {
		    clear: both;
		    width: 100%;
		    height: 1px;
		    border-top: thin solid #dcdcdc;
		    padding-bottom: 20px;
		}
		table{
			margin-left: 10px;
		}
    </style>
</head>
<body>
<div id="wrapper" class="container">
	<div id="main" class="form-horizontal clearfix">
		@if ($sppsb->jenis_sppsb!='2')
		<div style="height:40px;"></div>
		@endif
		<div class="widget-content pad20f">
			<div class="widget-header">
				<h2 class="widget-title" align="center">SURAT PERMOHONAN PENERBITAN SURETY BOND</h2>
			</div>		
			<p align="center">
				Nomor : {{ $sppsb->no_registrasi }}
			</p>
			<p>&nbsp;</p>	
			<p align="left"><strong>KEPADA YTH.<br/>PT JAMKRIDA NTB BERSAING<br/>DI MATARAM</strong></p>
			
			<p>Dengan hormat,<br/>Dengan ini kami mohon diterbitkan jaminan surety bond sesuai data sebagai berikut:</p>
		</div>
		<div class="widget-header">
			<h3 class="widget-title">I. IDENTIFIKASI KONTRAKTOR (TERJAMIN)</h3>
		</div>
		<div class="divider" style="padding-bottom:15px;"></div>	
		<div class="widget-content pad20f" style="padding-bottom:10px;">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td width="180px"><p><strong>Nama Kontraktor</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->nama_kontraktor }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Alamat Kontraktor</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->alamat_kontraktor }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Bidang Usaha</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->bidang_usaha }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Nama Direksi</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->direksi }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Jabatan</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->jabatan_direksi }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Dokumen Pendukung</strong></p></td>
					<td width="10px">:</td>
					<td>
						<p>
							@foreach($dokPendukung as $dok)
							- {{ $dok }}<br/>
							@endforeach
						</p>
					</td>
				</tr>
			</table>
		</div>			
		<div class="widget-header">
			<h3 class="widget-title">II. IDENTIFIKASI PROYEK (PENERIMA JAMINAN)</h3>
		</div>
		<div class="divider" style="padding-bottom:15px;"></div>	
		<div class="widget-content pad20f">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td width="180px"><p><strong>Pemilik Proyek</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->pemilik_proyek }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Nama Pejabat</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->nama_pejabat }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Alamat</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->alamat }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Jenis Pekerjaan</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->jenis_pekerjaan }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Jenis Dokumen</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->nama_dokumen }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>No. Dokumen</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->no_dokumen }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Tanggal Dokumen</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ tgl_indo($sppsb->tgl_dokumen) }}</p></td>
				</tr>
				@if ($sppsb->jenis_sppsb=='2')
				<tr valign="top">
					<td width="180px"><p><strong>Uang Muka</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->fasilitas }}</p></td>
				</tr>
				@if ($sppsb->fasilitas=='Ada Uang Muka')	
				<tr valign="top">
					<td width="180px"><p><strong>Persentase Uang Muka</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->persentase }}%</p></td>
				</tr>		
				@endif
				<tr valign="top">
					<td width="180px"><p><strong>Termin</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->pembayaran }}</p></td>
				</tr>
				@if ($sppsb->pembayaran=='Ada Termin')
				<tr valign="top">
					<td width="180px"><p><strong>Jumlah Termin</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->jml_termin }} kali</p></td>
				</tr>			
				@endif
				@endif
				<tr valign="top">
					<td width="180px"><p><strong>Sumber Dana</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->sumber_dana }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Nilai Proyek</strong></p></td>
					<td width="10px">:</td>
					<td><p>Rp. {{ $nilaiProyekFormat }} <em>(Terbilang: {{ $nilaiProyek }} )</em></p></td>
				</tr>
			</table>
			
		</div>	
		<div class="page-break"></div>	
		<div id="questions" class="widget-header">
			<h3 class="widget-title">III. URAIAN PENJAMINAN</h3>
		</div>
		<div class="divider" style="padding-bottom:15px;"></div>	
		<div class="widget-content pad20f" style="padding-bottom:10px;">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td width="180px"><p><strong>Jenis Penjaminan</strong></p></td>
					<td width="10px">:</td>
					<td><p>
						@if($sppsb->jenis_sppsb=='1')
							JAMINAN PENAWARAN
						@endif
						@if($sppsb->jenis_sppsb=='2')
							JAMINAN PELAKSANAAN
						@endif
						@if($sppsb->jenis_sppsb=='3')
							JAMINAN UANG MUKA
						@endif
						@if($sppsb->jenis_sppsb=='4')
							JAMINAN PEMELIHARAAN
						@endif
						@if($sppsb->jenis_sppsb=='5')
							JAMINAN PEMBAYARAN
						@endif
						@if($sppsb->jenis_sppsb=='6')
							JAMINAN SANGGAH BANDING
						@endif
					</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Nilai Jaminan</strong></p></td>
					<td width="10px">:</td>
					<td><p>Rp. {{ $nilaiJaminanFormat }} <em>(Terbilang: {{ $nilaiJaminan }} )</em></p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Jangka Waktu Proyek</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ tgl_indo($sppsb->waktu_mulai) }} <strong>s/d</strong> {{ tgl_indo($sppsb->waktu_selesai) }} <em>({{ $sppsb->durasi }} Hari)</em></p></td>
				</tr>
				
			@foreach($brgAgunan as $brg)
				<tr valign="top">
					<td width="180px"><p><strong>Janis Agunan</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $brg->type }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>No Dokumen Agunan</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $brg->no }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Nama Pemilik</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $brg->nama }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Taksiran</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $brg->taksiran }}</p></td>
				</tr>
			@endforeach
			</table>
		</div>
                
<!--		<div class="widget-header">
			<h3 class="widget-title">IV. @if($sppsb->role=="SA")STAFF REGISTER @else AGEN REGISTER @endif</h3>
		</div>
		<div class="divider" style="padding-bottom:15px;"></div>
		<div class="widget-content pad20f">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td width="180px"><p><strong>Nama </strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sppsb->name }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>No </strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $agen->no_agen }}</p></td>
				</tr>
			</table>
		</div>-->
                  
		<div class="divider"></div>	
		<div class="widget-content pad20f">
			<p>Semua data informasi tersebut adalah benar.</p>
			<p>Apabila dikemudian hari ternyata data / informasi tersebut tidak benar, 
			maka sertifikat penjaminan yang dibuat berdasarkan SPPSB ini menjadi batal dengan sendirinya.</p>
			<p>Demikian permohonan ini kami ajukan dan terima kasih atas perhatianya</p>
		</div>
		<div class="widget-content pad20f">
			<p>{{ $agen->wilayah_agensi }}, {{date('d-m-Y',strtotime($sppsb->tgl_pengajuan)) }}.</p>
			<p>Calon Terjamin<br/>{{ $sppsb->nama_kontraktor }}</p>
			<p style="text-transform: uppercase;margin-top:100px">
			( {{ $sppsb->direksi }} )
			<div style="border:1px solid #000;width:140px;"></div> 
			{{ $sppsb->jabatan_direksi }}
			</p>
		</div>
	</div>
</div>
</body>
</html>