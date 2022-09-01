<!DOCTYPE html>
<html lang="en"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cetak Perjanjian Ganti Rugi</title>
    <style type="text/css">
       
		p{
			margin: 0;
			padding: 0;
			text-align: justify;
		}
                body{
                /*font-family: 'calibri';*/
                font-size: 15px;
                margin-left: 40px;
                margin-right: 35px;
            }
    </style>
</head><body>
<div id="wrapper" class="container">
	<div id="main" class="form-horizontal clearfix">
		<div class="widget-content pad20f">
			<div class="form-group">
				<h3 align="center"><strong>PERJANJIAN MENGGANTI KERUGIAN</strong></h3>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<p>Dengan ini kami pihak Terjamin mengikat diri pada pihak Penjamin bahwa, 
					apabila pihak Penerima Jaminan melakukan pencairan Sertifikat Penjaminan Surety Bond 
					atas nama pihak Terjamin yang menyebabkan kerugian pada pihak Penjamin, 
					maka kami pihak Terjamin dan atau Pengurus, pihak Pengganti dan atau ahli warisnya, 
					secara sendiri-sendiri maupun secara bersama-sama, wajib mengganti kerugian yang dialami 
					oleh pihak Penjamin tersebut.</p>
                                        <br style="line-height:0.4;">
					<p>Besarnya kerugian yang dialami oleh pihak Penjamin adalah sebesar nilai yang telah 
					dibayarkan oleh pihak Penjamin kepada pihak Penerima Jaminan.</p>
                                        <br style="line-height:0.4;">
					<p>Pembayaran mengganti kerugian ini harus dilaksanakan oleh pihak Terjamin dan atau 
					Pengurus dan atau pihak Pengganti dan atau ahli warisnya, kepada pihak Penjamin 
					selambat-lambatnya dalam waktu 14 (empat belas) hari kalender terhitung sejak pihak 
					penjamin melakukan pembayaran kepada pihak Penerima Jaminan.</p>
                                        <br style="line-height:0.4;">
					<p>Apabila dalam waktu 14 (empat belas) hari dimaksud, pihak Terjamin dan atau Pengurus 
					dan atau pihak Pengganti dan atau ahli warisnya tidak dapat melaksanakan kewajiban membayar 
					kerugian pihak Penjamin dimaksud, maka pihak Terjamin dan atau Pengurus, pihak Pengganti 
					dan atau ahli warisnya baik secara sendiri-sendiri maupun secara bersama-sama memiliki hutang 
					kepada pihak Penjamin.</p>
                                        <br style="line-height:0.4;">
					<p>Besarnya hutang pihak Terjamin kepada pihak Penjamin dimaksud adalah sebesar nilai yang 
					telah dibayarkan oleh pihak Penjamin kepada pihak Penerima Jaminan ditambah dengan bunga 
					yang besarnya minimal setara dengan tingkat suku bunga pinjaman di 
					Bank.</p>
                                        <br style="line-height:0.4;">
					<p>Dalam hal terdapat barang agunan atau collateral yang merupakan syarat dari penerbitan 
					Sertifikat Penjaminan dimaksud, maka Perjanjian Mengganti Kerugian ini berfungsi sebagai 
					Surat Kuasa yang diberikan oleh pihak Terjamin dan atau Pengurus, pihak Pengganti dan atau 
					ahli warisnya maupun pihak lain sebagai Pemilik hak atas barang agunan atau collateral dimaksud 
					kepada Pihak Penjamin untuk menyita dan atau menjual barang agunan atau collateral dimaksud. 
					Hasil penjualan barang agunan atau collateral ini akan dipergunakan untuk membayar hutang pihak Terjamin kepada pihak 
					Penjamin.</p>
                                        <br style="line-height:0.4;">
					<p>Apabila terdapat kelebihan harga atas penjualan barang agunan atau collateral dimaksud, 
					maka kelebihan harga tersebut akan diserahkan atau dikembalikan kepada pihak Terjamin 
					dan atau Pengurus dan atau pihak Pengganti atau ahli warisnya dan Pihak yang memiliki Hak 
					atas barang agunan atau collateral yang telah dijual 
					tersebut.</p>
                                        <br style="line-height:0.4;">
					<p>Perjanjian Mengganti Kerugian ini berlaku dan merupakan bagian tidak terpisahkan untuk 
					Sertifikat
					@if($sppsb->jenis_sppsb=='1')
						<strong>JAMINAN PENAWARAN</strong>
					@endif
					@if($sppsb->jenis_sppsb=='2')
						<strong>JAMINAN PELAKSANAAN</strong>
					@endif
					@if($sppsb->jenis_sppsb=='3')
						<strong>JAMINAN UANG MUKA</strong>
					@endif
					@if($sppsb->jenis_sppsb=='4')
						<strong>JAMINAN PEMELIHARAAN</strong>
					@endif
					@if($sppsb->jenis_sppsb=='5')
						<strong>JAMINAN PEMBAYARAN</strong>
					@endif
					@if($sppsb->jenis_sppsb=='6')
						<strong>JAMINAN SANGGAH BANDING</strong>
					@endif
					Nomor <strong>{{ $sppsb->no_jaminan }}</strong> yang diterbitkan oleh Pihak penjamin untuk kepentingan Pihak 
					Terjamin</p>
                                        <br style="line-height:0.4;">
					<p>Dibuat pada  tanggal {{ tgl_indo($sppsb->tgl_cetak) }}</p>

				</div>
			</div>
			<div style="height:30px"></div>
			<div class="form-group">
				<div class="col-sm-12">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr align="center" valign="top">
						<td width="40%" style="text-transform:uppercase">{{ $sppsb->nama_kontraktor }}</td>
						<td></td>
						<td width="40%" height="140px">
						<div class="relative">
							PT. JAMKRIDA NTB BERSAING
							<div class="signed-image" >
								<!--<img src="{{ $result->ttd }}">-->
							</div>
						</div>
						</td>
					</tr>
					<tr align="center" style="text-transform:uppercase">
						<td><span style="font-weight:bold;border-bottom:1px solid #000;padding:0 5px">{{ $sppsb->direksi }}</span></td>
						<td></td>
						<td><span style="font-weight:bold;border-bottom:1px solid #000;padding:0 5px">INDRA MANTHICA</span></td>
					</tr>
					<!--<tr>
						<td><div style="width:60%;margin:0 auto;border-top: thin solid #3f3f3f;"></div></td>
						<td><div style="width:60%;margin:0 auto;border-top: thin solid #3f3f3f;"></div></td>
					</tr>-->
					<tr align="center">
						<td>{{ $sppsb->jabatan_direksi }}</td>
						<td></td>
						<td>Direktur Utama</td>
					</tr>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>
</body></html>