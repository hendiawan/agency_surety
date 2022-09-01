<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cetak Perjanjian Ganti Rugi</title>
    <style type="text/css">
       	body{
/*    		font-family: 'Helvetica';*/
    		letter-spacing: 0.25px;
    		padding: 120px 30px 0 50px;
    	}
    	ol li, table tr, p, div{
    		font-size: 14px;
    		font-weight: lighter;
    		text-align: justify;
    		line-height: 18px;
    		padding-top: -3px;
    	}
    	ol li{
    		padding-bottom: 4px;
    	}
    	ol.sertifikat-list, ol.sertifikat-list li ol {
			padding-left: 10px;
		}
		ol.sertifikat-list li {
			padding-left: 10px;
			margin-bottom: 5px;
		}
		ol.sertifikat-list li ol li{
			margin-bottom: 0;
		}
		.form-group{
			padding: 10px 0
		}
		.relative {
			position: relative;
		}
		.signed-image{
			position: absolute;
			top: 25px;
			left: 0;
		}
		.signed-image img{
			width: 320px;
		}
		h3{
			font-size: 20px;
			line-height: 26px;
			margin-bottom: 40px
		}
		#footer {
		    position: fixed;
		    bottom: 85px;
		    width: 100%;
		}
		p{
			margin: 0;
			padding: 0;
			text-align: justify;
		}
		td.endLine{
			background: url('/images/dot-line.jpg') repeat;
			background-position: 0px 24px; 
		}
		td.endLine span{
			background: #fff;
		}
    </style>
</head>
<body>
<div id="wrapper" class="container">
	<div id="main" class="form-horizontal clearfix">
		<div class="widget-content pad20">
			<h3 align="center"><strong>SURAT PERSETUJUAN PRINSIP PENJAMINAN (SP3)<br/>KONTRA BANK GARANSI</strong></h3>
			<div style="padding-bottom:10px;">
				<div class="col-xs-6">Nomor : {{$sp3kbg->no_jaminan}}</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12" style="text-transform:uppercase"><strong>KEPADA YTH. <br/>{{$bank->name}}<br/>{{$bank->address}}<br/>{{$bank->wilayah}}</strong></div>
			</div>
			<div class="form-group">
				<div class="col-xs-6">Dengan hormat,</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<ol class="sertifikat-list">
						<li class="text-justify">Dengan ini Direksi PT. Jamkrida NTB Bersaing menyampaikan Persetujuan Prinsip Penjaminan atas permohonan penerbitan Bank Garansi 
atas nama Terjamin dan Obyek Penjaminan sebagai berikut :
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr valign="top">
									<td width="4%">a.</td>
									<td width="35%">Nama Terjamin</td>
									<td width="1%">:</td>
									<td>{{$sp3kbg->nama_kontraktor}}</td>
								</tr>					
								<tr valign="top">
									<td width="4%">b.</td>
									<td width="35%">Nama Kepala Cabang</td>
									<td width="1%">:</td>
									<td>{{$sp3kbg->direksi}}</td>
								</tr>
								<tr valign="top">
									<td width="4%">c.</td>
									<td width="35%">Alamat Terjamin</td>
									<td width="1%">:</td>
									<td>{{$sp3kbg->alamat_kontraktor}}</td>
								</tr>
								<tr valign="top">
									<td width="4%">d.</td>
									<td width="35%">Jenis Jaminan</td>
									<td width="1%">:</td>
									<td>@if($sp3kbg->jenis_sp3kbg=='1')
										JAMINAN PENAWARAN
									@endif
									@if($sp3kbg->jenis_sp3kbg=='2')
										JAMINAN PELAKSANAAN
									@endif
									@if($sp3kbg->jenis_sp3kbg=='3')
										JAMINAN UANG MUKA
									@endif
									@if($sp3kbg->jenis_sp3kbg=='4')
										JAMINAN PEMELIHARAAN
									@endif
									@if($sp3kbg->jenis_sp3kbg=='5')
										JAMINAN PEMBAYARAN
									@endif
									@if($sp3kbg->jenis_sp3kbg=='6')
										JAMINAN SANGGAH BANDING
									@endif</td>
								</tr>
								<tr valign="top">
									<td width="4%">e.</td>
									<td width="35%">Nilai Proyek</td>
									<td width="1%">:</td>
									<td>Rp.{{ number_format($sp3kbg->nilai_proyek,2,",",".") }} ({{ucwords(terbilang($sp3kbg->nilai_proyek))}} Rupiah)</td>
								</tr>
								<tr valign="top">
									<td width="4%">f.</td>
									<td width="35%">Nilai Jaminan</td>
									<td width="1%">:</td>
									<td>Rp.{{ number_format($sp3kbg->nilai_jaminan,2,",",".") }} ({{ucwords(terbilang($sp3kbg->nilai_jaminan))}} Rupiah)</td>
								</tr>
								<tr valign="top">
									<td width="4%">g.</td>
									<td width="35%">No Addedum Kontrak</td>
									<td width="1%">:</td>
									<td>{{$sp3kbg->no_dokumen}}</td>
								</tr>
								<tr valign="top">
									<td width="4%">h.</td>
									<td width="35%">Jenis Pekerjaan</td>
									<td width="1%">:</td>
									<td>{{$sp3kbg->jenis_pekerjaan}}</td>
								</tr>
								<tr valign="top">
									<td width="4%">i.</td>
									<td width="35%">Pemilik Pekerjaan</td>
									<td width="1%">:</td>
									<td>{{$sp3kbg->pemilik_proyek}}</td>
								</tr>
								<tr valign="top">
									<td width="4%">j.</td>
									<td width="35%">Jangka Waktu Pelaksanaan</td>
									<td width="1%">:</td>
									<td>{{ $sp3kbg->durasi }} hari terhitung sejak tanggal {{ tgl_indo($sp3kbg->waktu_mulai) }} sampai dengan {{ tgl_indo($sp3kbg->waktu_selesai) }}</td>
								</tr>
								<tr valign="top">
									<td width="4%">k.</td>
									<td width="35%">Lokasi Proyek</td>
									<td width="1%">:</td>
									<td>{{$sp3kbg->alamat}}</td>
								</tr>			
							</table>
						</li>
						<li class="text-justify">Surat Persetujuan Prinsip Penjaminan (SP3) ini bukan merupakan jaminan atas Bank Garansi yang diterbitkan oleh {{$bank->name}}. Jaminan atas Bank
Garansi (Kontra Bank Garansi) akan kami terbitkan setelah {{$bank->name}} menerbitkan Bank Garansi sebagaimana data tersebut di atas.
						</li>
						<li class="text-justify">
							Surat Persetujuan Prinsip Penjaminan (SP3) ini berlaku selama 7 ( Tujuh ) hari terhitung sejak tanggal diterima oleh {{$bank->name}}. Apabila sampai dengan
batas waktu tersebut {{$bank->name}} belum menerbitkan Bank Garansi, maka Surat Persetujuan Prinsip Penjaminan (SP3) ini dinyatakan batal.
						</li>
						<li class="text-justify">Perhitungan Imbal Jasa Penjaminan (IJP) adalah sebagai berikut :
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr valign="top">
									<td width="4%" valign="middle"><img src="images/dot.jpg"></td>
									<td width="56%" class="endLine"><span>Imbal Jasa Penjaminan (IJP) N.Jaminan x {{$result->rate_ijp}}%</span></td>
									<td width="5%" align="right">Rp.</td>
									<td width="17%" align="right">{{ number_format($ijp,2,",",".") }}</td>
									<td></td>
								</tr>
								<tr valign="top">
									<td width="4%" valign="middle"><img src="images/dot.jpg"></td>
									<td width="56%" class="endLine"><span>Biaya administrasi</span></td>
									<td width="5%" align="right">Rp.</td>
									<td width="17%" align="right">{{ number_format($result->fee_admin,2,",",".") }}</td>
									<td></td>
								</tr>
								<tr valign="top">
									<td width="4%" valign="middle"><img src="images/dot.jpg"></td>
									<td width="56%" class="endLine"><span>Biaya materai</span></td>
									<td width="5%" align="right">Rp.</td>
									<td width="17%" align="right">{{ number_format($result->materai,2,",",".") }}</td>
									<td></td>
								</tr>
								<tr valign="top">
									<td width="4%" valign="middle"><img src="images/dot.jpg"></td>
									<td width="56%" class="endLine"><span>Total Imbal Jasa Penjaminan</span></td>
									<td width="5%" align="right">Rp.</td>
									<td width="17%" align="right">{{ number_format($result->service_charge,2,",",".") }}</td>
									<td></td>
								</tr>
								<tr valign="top">
									<td width="4%" valign="middle"><img src="images/dot.jpg"></td>
									<td width="56%" class="endLine"><span>IJP bagian dari {{$bank->name}}</span></td>
									<td width="5%" align="right">Rp.</td>
									<td width="17%" align="right">{{ number_format($feeBank,2,",",".") }}</td>
									<td></td>
								</tr>
								<tr valign="top">
									<td width="4%" valign="middle"><img src="images/dot.jpg"></td>
									<td width="56%" class="endLine"><span>IJP bagian dari PT. Jamkrida NTB Bersaing</span></td>
									<td width="5%" align="right">Rp.</td>
									<td width="17%" align="right">{{ number_format($feeJnb+$result->materai+$result->fee_admin,2,",",".") }}</td>
									<td></td>
								</tr>
							</table>
							
						</li>
					</ol>	
				Kami mohon kiranya Total IJP sebesar Rp. {{ number_format($result->service_charge,2,",",".") }} ({{ucwords(terbilang($result->service_charge))}} Rupiah) 
				tersebut dapat ditagih kepada Terjamin ({{ $sp3kbg->nama_kontraktor }}) dan selanjutnya IJP sebesar Rp. {{ number_format($feeJnb+$result->materai+$result->fee_admin,2,",",".") }} ({{ucwords(terbilang($feeJnb+$result->materai+$result->fee_admin))}} Rupiah) 
				yang merupakan bagian dari PT. Jamkrida NTB Bersaing dapat dilimpahkan ke rekening Nomor : {{$bank->no_rek}} atas nama PT. Jamkrida NTB Bersaing
				</div>
			</div>				
			<div class="form-group">
				<div class="col-sm-12">Mataram, {{ tgl_indo($sp3kbg->tgl_cetak) }}</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<div class="relative" style="width:400px;height:150px;">
						PT. JAMKRIDA NTB BERSAING
						<div class="signed-image" >
							<img src="{{ $result->ttd }}" width="50%">
						</div>
					</div>
					<div>
						<strong><u>INDRA MANTHICA</u></strong><br/>
						Direktur Utama
					</div>				
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>