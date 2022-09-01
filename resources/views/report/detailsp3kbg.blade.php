<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cetak Detail SP3KBG</title>
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
			margin-bottom: 0px;
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
		@if ($sp3kbg->jenis_sp3kbg!='2')
		<div style="height:40px;"></div>
		@endif
		<div class="widget-content pad20f">
			<div class="widget-header">
				<h2 class="widget-title" align="center">SURAT PERMOHONAN PENERBITAN SURETY BOND</h2>
			</div>		
			<p align="center">
				Nomor : {{ $sp3kbg->no_registrasi }}
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
					<td><p>{{ $sp3kbg->nama_kontraktor }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Alamat Kontraktor</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->alamat_kontraktor }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Bidang Usaha</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->bidang_usaha }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Nama Direksi</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->direksi }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Jabatan</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->jabatan_direksi }}</p></td>
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
			<h3 class="widget-title">II. IDENTIFIKASI PROYEK</h3>
		</div>
		<div class="divider" style="padding-bottom:15px;"></div>	
		<div class="widget-content pad20f">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td width="180px"><p><strong>Pemilik Proyek</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->pemilik_proyek }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Nama Pejabat</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->nama_pejabat }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Alamat</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->alamat }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Jenis Pekerjaan</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->jenis_pekerjaan }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Jenis Dokumen</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->nama_dokumen }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>No. Dokumen</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->no_dokumen }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Tanggal Dokumen</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ tgl_indo($sp3kbg->tgl_dokumen) }}</p></td>
				</tr>
				@if ($sp3kbg->jenis_sp3kbg=='2')
				<tr valign="top">
					<td width="180px"><p><strong>Uang Muka</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->fasilitas }}</p></td>
				</tr>
				@if ($sp3kbg->fasilitas=='Ada Uang Muka')	
				<tr valign="top">
					<td width="180px"><p><strong>Persentase Uang Muka</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->persentase }}%</p></td>
				</tr>		
				@endif
				<tr valign="top">
					<td width="180px"><p><strong>Termin</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->pembayaran }}</p></td>
				</tr>
				@if ($sp3kbg->pembayaran=='Ada Termin')
				<tr valign="top">
					<td width="180px"><p><strong>Jumlah Termin</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->jml_termin }} kali</p></td>
				</tr>			
				@endif
				@endif
				<tr valign="top">
					<td width="180px"><p><strong>Sumber Dana</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $sp3kbg->sumber_dana }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Nilai Proyek</strong></p></td>
					<td width="10px">:</td>
					<td><p>Rp. {{ $nilaiProyekFormat }} <em>(Terbilang: {{ $nilaiProyek }} Rupiah)</em></p></td>
				</tr>
			</table>
			
		</div>	
		<div class="page-break"></div>
		<div class="widget-header">
			<h3 class="widget-title">III. PENERIMA JAMINAN</h3>
		</div>
		<div class="divider" style="padding-bottom:15px;"></div>	
		<div class="widget-content pad20f">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td width="180px"><p><strong>Bank</strong></p></td>
					<td width="10px">:</td>
					<td><p><strong>{{ $bank->name }}</strong><br/>{{ $bank->address }}<br/>{{ $bank->wilayah }}<br/>Telp. {{ $bank->phone }}</p></td>
				</tr>
			</table>
			
		</div>	
		<div id="questions" class="widget-header">
			<h3 class="widget-title">IV. URAIAN PENJAMINAN</h3>
		</div>
		<div class="divider" style="padding-bottom:15px;"></div>	
		<div class="widget-content pad20f" style="padding-bottom:10px;">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td width="180px"><p><strong>Jenis Penjaminan</strong></p></td>
					<td width="10px">:</td>
					<td><p>
						@if($sp3kbg->jenis_sp3kbg=='1')
							JAMINAN PENAWARAN
						@endif
						@if($sp3kbg->jenis_sp3kbg=='2')
							JAMINAN PELAKSANAAN
						@endif
						@if($sp3kbg->jenis_sp3kbg=='3')
							sJAMINAN UANG MUKA
						@endif
						@if($sp3kbg->jenis_sp3kbg=='4')
							JAMINAN PEMELIHARAAN
						@endif
						@if($sp3kbg->jenis_sp3kbg=='5')
							JAMINAN PEMBAYARAN
						@endif
						@if($sp3kbg->jenis_sp3kbg=='6')
							JAMINAN SANGGAH BANDING
						@endif
					</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Nilai Jaminan</strong></p></td>
					<td width="10px">:</td>
					<td><p>Rp. {{ $nilaiJaminanFormat }} <em>(Terbilang: {{ $nilaiJaminan }} Rupiah)</em></p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>Jangka Waktu Proyek</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ tgl_indo($sp3kbg->waktu_mulai) }} <strong>s/d</strong> {{ tgl_indo($sp3kbg->waktu_selesai) }} <em>({{ $sp3kbg->durasi }} Hari)</em></p></td>
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
		<div class="widget-header">
			<h3 class="widget-title">V. AGEN</h3>
		</div>
		<div class="divider" style="padding-bottom:15px;"></div>
		<div class="widget-content pad20f">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td width="180px"><p><strong>Nama Agen</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ Auth::user()->name }}</p></td>
				</tr>
				<tr valign="top">
					<td width="180px"><p><strong>No Agen</strong></p></td>
					<td width="10px">:</td>
					<td><p>{{ $agen->no_agen }}</p></td>
				</tr>
			</table>
		</div>
		<div class="divider"></div>	
		<div class="widget-content pad20f">
			<p>Semua data informasi tersebut adalah benar.</p>
			<p>Apabila dikemudian hari ternyata data / informasi tersebut tidak benar, 
			maka sertifikat penjaminan yang dibuat berdasarkan sp3kbg ini menjadi batal dengan sendirinya.</p>
			<p>Demikian permohonan ini kami ajukan dan terima kasih atas perhatianya</p>
		</div>
		<div class="widget-content pad20f">
			<p>{{ $agen->wilayah_agensi }}, {{ tgl_indo($sp3kbg->tgl_cetak) }}</p>
			<p>Calon Terjamin<br/>{{ $sp3kbg->nama_kontraktor }}</p>
			<p style="text-transform: uppercase;margin-top:100px">
			( {{ $sp3kbg->direksi }} )
			<div style="border:1px solid #000;width:140px;"></div> 
			{{ $sp3kbg->jabatan_direksi }}
			</p>
		</div>
	</div>
</div>
</body>
</html>