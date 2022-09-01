@extends('layouts.app')

@section('content')	
	<div id="main" class="clearfix">
		<div class="fluid form-horizontal">

			<div class="topTabs">		
				<div id="topTabs-container-home">
					<div class="topTabs-header clearfix">

						<div class="secInfo sec-dashboard">
							<h1 class="secTitle">Draft</h1>
							<span class="secExtra">Draft persetujuan untuk:</span>
						</div> <!-- /SecInfo -->
						
						<ul class="etabs tabs">
							<li class="tab">
								<a href="#tab1">
									<span class="to-hide">
										<i class="fa fa-folder-open"></i><br>Sertifikat
									</span>
									<i class="fa icon-hidden fa-folder-open ttip" data-ttip="Data SPPSB"></i>
								</a>
							</li>
							<li class="tab">
								<a href="#tab2">
									<span class="to-hide">
										<i class="fa fa-folder-open-o"></i><br>SP3 KBG
									</span>
									<i class="fa icon-hidden fa-folder-open-o ttip" data-ttip="Data SP3 KBG"></i>
								</a>
							</li>
						</ul> <!-- /tabs -->
					</div><!-- /topTabs-header -->

					<div class="topTabsContent" style="padding-left:0;">
						<div id="tab1">
							<div class="widget-content pad20f">

								@if(Auth::check())
								@can('staff-access')
								<form id="sp3kbgPenomoran" class="form-horizontal" method="POST" action="{{ url('/') }}/sp3kbg-penomoran">
								{!! csrf_field() !!}
								<input type="hidden" id="id" name="id" value="{{ $sp3kbg->id }}">
								<div class="alert alert-info" role="alert">
									<strong><i class="fa fa-info-circle"></i> Informasi!</strong> Silahkan menginputkan nomor SP3KBG sebelum di kembalikan ke agen untuk dicetak
								</div>
								<hr/>
								<div class="form-group">
									<h4 class="text-center"><strong>SERTIFIKAT PERJANJIAN BANK GARANSI<br/>
										@if($sp3kbg->jenis_sp3kbg=='1')
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
												@endif</strong></h4>
								</div>
								<div class="form-group">
									<div class="col-xs-6">
										<div class="input-group">
				      						<div class="input-group-addon">Nomor: </div>
											<input type="text" name="no_jaminan" class="form-control" required>
										</div>
									</div>
									<div class="col-xs-6 text-right"><strong>Nilai Jaminan Rp.<span class="numeric">{{ $sp3kbg->nilai_jaminan }}</span></strong></div>
								</div>				
								@endcan
								@can('direksi-access')
								<div class="form-group">
									<h4 class="text-center"><strong>SERTIFIKAT PERJANJIAN BANK GARANSI<br/>
										@if($sp3kbg->jenis_sp3kbg=='1')
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
												@endif</strong></h4>
								</div>
								<div class="form-group">
									<div class="col-xs-6"><strong>Nomor : </strong></div>
									<div class="col-xs-6 text-right"><strong>Nilai Jaminan Rp.<span class="numeric">{{ $sp3kbg->nilai_jaminan }}</span></strong></div>
								</div>
								@endcan
								@endif		
								<div class="form-group">
									<div class="col-sm-12 text-justify">
										<p>Direksi <strong>PT. JAMKRIDA NTB BERSAING</strong> bertindak untuk dan atas nama <strong>PT. JAMKRIDA NTB BERSAING</strong> berkedudukan di Jl. Langko No. 63, Mataram 
										yang selanjutnya disebut <strong>PENJAMIN</strong>. Bahwa atas permintaan dari <span class="text-uppercase"><strong>{{ $sp3kbg->nama_kontraktor }}</strong></span> Berkedudukan di 
										<strong>{{ $sp3kbg->alamat_kontraktor }}</strong> yang selanjutnya disebut TERJAMIN guna memberikan jaminan kepada PENERIMA JAMINAN :</p>
										<table width="100%" cellspacing="0" cellpadding="0">
											<tr>
												<td width="15%"><span style="padding-left:5px">Nama</span></td>
												<td width="2%">:</td>
												<td align="left"><span class="text-uppercase">{{$bank->name}}</span></td>
											</tr>
											<tr>
												<td><span style="padding-left:5px;">Alamat</span></td>
												<td>:</td>
												<td align="left">{{$bank->address}}</td>
											</tr>
										</table>
										<p style="padding-top:5px">Sertifikat Penjaminan Bank Garansi <strong>PELAKSANAAN</strong> ini diterbitkan oleh <strong>PENJAMIN</strong> sehubungan dengan akan diterbitkannya BANK GARANSI oleh 
										<strong>PENERIMA JAMINAN</strong> untuk kepentingan TERJAMIN guna keperluan <strong>{{ $sp3kbg->jenis_pekerjaan }}</strong> berdasarkan 
										Surat Penunjukan Penyediaan Barang/Jasa (SPPBJ) Nomor <strong>{{ $sp3kbg->no_dokumen }}</strong> tanggal {{ tgl_indo($sp3kbg->tgl_dokumen) }} dengan harga kontrak 
										Rp. {{ number_format($sp3kbg->nilai_proyek,2,",",".") }} ({{ucwords(terbilang($sp3kbg->nilai_proyek))}} Rupiah ) yang berlaku dalam {{ $sp3kbg->durasi }} hari kalender 
										terhitung sejak tanggal {{ tgl_indo($sp3kbg->waktu_mulai) }} sampai dengan tanggal {{ tgl_indo($sp3kbg->waktu_selesai) }} yang ditujukan kepada 
										<span class="text-uppercase"><strong>{{ $sp3kbg->jabatan_pejabat }} {{ $sp3kbg->pemilik_proyek }}</strong></span>.</p>
										<p>Bahwa apabila selama masa berlakunya Sertifikat Penjaminan ini TERJAMIN telah lalai atau terjadi wanprestasi sebagaimana yang ditentukan di dalam 
										BANK GARANSI dimaksud sehingga terjadi pencairan BANK GARANSI, maka <strong>PENERIMA JAMINAN</strong> wajib terlebih dahulu memberitahukan kepada PENJAMINAN secara tertulis 
										dengan disertai asli SERTIFIKAT PENJAMINAN BANK GARANSI dan bukti-bukti pencairan BANK GARANSI tersebut di atas dengan batas waktu pengajuan klaim selambat-lambatnya 
										30 (tiga puluh) Hari Kalender sejak tanggal berakhirnya SERTIFIKAT PENJAMINAN BANK GARANSI.</p>
										<p>Pembayaran sejumlah uang tersebut diatas dilaksanakan selambat-lambatnya 7 (tujuh) hari kalender sejak tanggal diterimanya Surat Klaim Penjaminan Bank Garansi dari Pihak Penerima Jaminan.</p>
										<p>Bahwa Sertifikat Penjaminan ini dengan sendirinya tidak berlaku lagi apabila :</p>
										<p>
											<ol class="sertifikat-list" type="a">
												<li><strong>TERJAMIN</strong> telah memenuhi kewajibannya sebagaimana yang telah disebutkan dalam BANK GARANSI yang bersangkutan, walaupun angka waktu berlakunya Sertifikat Penjaminan ini belum berakhir.</li>
												<li>Jangka waktu untuk pengajuan klaim telah berakhir dan atau tidak adanya klaim dari <strong>PENERIMA JAMINAN</strong>.</li>
												<li>Adanya pernyataan dari <strong>PENERIMA JAMINAN</strong> dan <strong>TERJAMIN</strong> yang menyatakan telah selesainya hal yang dijamin dalam BANK GARANSI tersebut yang dituangkan dalam 
												Surat Pernyataan bermaterai serta ditandatangani oleh kedua belah pihak.</li>
											</ol>
										</p>
										<p>Menunjuk pada Pasal 1852 KUH Perdata dengan ini ditegaskan kembali bahwa Penjamin melepaskan hak-hak istimewanya untuk menuntut supaya 
										harta benda pihak yang dijamin lebih dahulu disita dan dijual guna melunasi hutangnya sebagaimana dimaksud dalam Pasal 1831 KUH Perdata.</p>
										<p>Sertifikat Penjaminan Bank Garansi ini merupakan bagian yang tak terpisahkan dari Perjanjian Penjaminan Bank Garansi Antara PT. JAMKRIDA NTB BERSAING dengan PT. Bank Pembangunan Daerah NTB Nomor :
										<img src="/images/no-penjaminan-bank.png" />
										tanggal 4 Februari 2013 dan tidak dapat dipindahtangankan atau dijadikan jaminan kepada pihak lain.</p>
									</div>
								</div>
								@if(Auth::check())	
								@can('staff-access')		
								<div class="form-group">
									<div class="col-sm-12">Mataram, {{ tgl_indo($sp3kbg->tgl_cetak) }}</div>
								</div>
								<div class="form-group">
									<div class="col-xs-4">
										<strong>PT. JAMKRIDA NTB BERSAING</strong>
										<div class="signed-box">
											<div id="current-signature"><img src="{{ $result->ttd }}" /></div>
											<span class="text-uppercase"><strong>Indra Manthica</strong></span>
										</div>
										Direktur
									</div>
								</div>
								<hr/>
								<div class="form-group">
									<div class="col-sm-6">
										<a href="" id="template" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
									</div>
									<div class="col-sm-6 text-right">
										<button id="prosesClose" type="submit" class="btn btn-blue"><i class="fa fa-save"></i> PROSES</button>
									</div>
								</div>
								</form>
								@endcan
								@can('direksi-access')					
								<div class="form-group">
									<div class="col-sm-12">Mataram, {{ tgl_indo($sp3kbg->tgl_cetak) }}</div>
								</div>
								<div class="form-group">
									<div class="col-xs-4">
										<strong>PT. JAMKRIDA NTB BERSAING</strong>
										<div class="signed-box">
											<div id="current-signature"></div>
											<span class="text-uppercase"><strong>Indra Manthica</strong></span>
										</div>
										Direktur Utama
									</div>
								</div>
								<hr/>
								<div class="form-group">
<!--									<div class="col-sm-12">
									<button id="template" type="button" class="btn btn-turquoise"><i class="fa fa-folder"></i> Gunakan TTD Template</button>
									<span class="pull-right">
										<button type="button" class="btn btn-blue" data-toggle="modal" data-target="#modalSignature"><i class="fa fa-pencil"></i> Gunakan TTD Baru</button>
									</span>
									</div>-->
								</div>								
								@endcan
								@endif
							</div>
						</div>
						<div id="tab2">
							<div class="widget-content pad20f">
								<h3 align="center"><strong>SURAT PERSETUJUAN PRINSIP PENJAMINAN (SP3)<br/>KONTRA BANK GARANSI</strong></h3>
								<div style="padding-bottom:10px;">
									<div class="text-center">Nomor : {{$sp3kbg->no_jaminan}}</div>
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
														<td width="4%" valign="middle"><img src="../images/dot.jpg"></td>
														<td width="56%" class="endLine"><span>Imbal Jasa Penjaminan (IJP) N.Jaminan x {{$rate['rateIjp']}}%</span></td>
														<td width="5%" align="right">Rp.</td>
														<td width="17%" align="right">{{ number_format($ijp,2,",",".") }}</td>
														<td></td>
													</tr>
													<tr valign="top">
														<td width="4%" valign="middle"><img src="../images/dot.jpg"></td>
														<td width="56%" class="endLine"><span>Biaya administrasi</span></td>
														<td width="5%" align="right">Rp.</td>
														<td width="17%" align="right">{{ number_format($admin->value,2,",",".") }}</td>
														<td></td>
													</tr>
													<tr valign="top">
														<td width="4%" valign="middle"><img src="../images/dot.jpg"></td>
														<td width="56%" class="endLine"><span>Biaya materai</span></td>
														<td width="5%" align="right">Rp.</td>
														<td width="17%" align="right">{{ number_format($materai->value,2,",",".") }}</td>
														<td></td>
													</tr>
													<tr valign="top">
														<td width="4%" valign="middle"><img src="../images/dot.jpg"></td>
														<td width="56%" class="endLine"><span>Total Imbal Jasa Penjaminan</span></td>
														<td width="5%" align="right">Rp.</td>
														<td width="17%" align="right">{{ number_format($serviceCharge,2,",",".") }}</td>
														<td></td>
													</tr>
													<tr valign="top">
														<td width="4%" valign="middle"><img src="../images/dot.jpg"></td>
														<td width="56%" class="endLine"><span>IJP bagian dari {{$bank->name}}</span></td>
														<td width="5%" align="right">Rp.</td>
														<td width="17%" align="right">{{ number_format($feeBank,2,",",".") }}</td>
														<td></td>
													</tr>
													<tr valign="top">
														<td width="4%" valign="middle"><img src="../images/dot.jpg"></td>
														<td width="56%" class="endLine"><span>IJP bagian dari PT. Jamkrida NTB Bersaing</span></td>
														<td width="5%" align="right">Rp.</td>
														<td width="17%" align="right">{{ number_format(($ijp-$feeBank)+$materai->value+$admin->value,2,",",".") }}</td>
														<td></td>
													</tr>
												</table>
												
											</li>
										</ol>	
									Kami mohon kiranya Total IJP sebesar Rp. {{ number_format($serviceCharge,2,",",".") }} ({{ucwords(terbilang($serviceCharge))}} Rupiah ) 
									tersebut dapat ditagih kepada Terjamin ({{ $sp3kbg->nama_kontraktor }}) dan selanjutnya IJP sebesar Rp. {{ number_format(($ijp-$feeBank)+$materai->value+$admin->value,2,",",".") }} ({{ucwords(terbilang(($ijp-$feeBank)+$materai->value+$admin->value))}} Rupiah ) 
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
				</div>
			</div>
			@if(Auth::check())	
			@can('direksi-access')
			<div class="widget-content pad20f">
				<hr/>
				<div class="form-group">
					<form id="sp3kbgPenomoran" class="form-horizontal" method="POST" action="{{ url('/') }}/sp3kbg-direksi-update">
					{!! csrf_field() !!}
						<input type="hidden" id="id" name="id" value="{{ $sp3kbg->id }}">
						<input type="hidden" id="no_registrasi" name="no_registrasi" value="{{ $sp3kbg->no_registrasi }}">
						<input type="hidden" id="sp3kbg_status" name="status" value="{{ $sp3kbg->status }}">
						<input type="hidden" id="charge" name="charge" value="{{ $serviceCharge }}">
						<input type="hidden" id="ttd" name="ttd" value="">
						<input type="hidden" id="ttd_type" name="ttd_type" value="">

						<div class="col-sm-6">
							<a id="back" href="{{ url('/home') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
						</div>
						<div class="col-sm-6 text-right">
							<button id="tolak" type="button" class="btn btn-red"><i class="fa fa-folder"></i> TOLAK</button>
							<button id="revisi" type="button" class="btn btn-yellow"><i class="fa fa-edit"></i> REVISI</button>
							<button id="proses" type="button" class="btn"><i class="fa fa-check"></i> PROSES</button>
						</div>
						<!-- MODAL TOLAK -->
						<div class="modal fade remark-modal-md" role="dialog" aria-labelledby="mySmallModalLabel">
						    <div class="modal-dialog" role="document">
						        <div class="panel panel-info">
						            <div class="panel-heading">
						                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						                <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-edit"></i> Catatan</h4>
						            </div>
						            <div class="panel-body">
						            	<div class="form-group">
						            		<div class="col-md-12">
						            			<textarea class="form-control" name="remark" required></textarea>
						            			<span class="help-block"><small>silahkan inputkan alasan penolakan/revisi dari SP3KBG yang di maksud</small></span>
						            		</div>
						            	</div>
						            </div>
						            <div class="panel-footer text-center">
						                <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Keluar</button>
						                <button id="prosesRevisiTolak" type="submit" class="btn btn-blue"><i class="fa fa-save"></i> Proses</button>
						            </div>
						        </div>
						    </div>
						</div>
                                                
                                                <div class="modal fade modal-md analisa-direksi" role="dialog" aria-labelledby="mySmallModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="panel panel-success">
                                                    <div class="panel-heading">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-edit"></i> Analisa/Tanggapan Direksi</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <textarea id="remark" class="form-control" name="remark" required></textarea>
                                                                <span class="help-block"><small>silahkan inputkan Analisa/Tanggapan Anda </small></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer text-center">
                                                        <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Keluar</button>
                                                        <button id="analisa" type="submit" class="btn btn-blue"><i class="fa fa-save"></i> Proses</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
					</form>	
				</div>
			</div>							
			@endcan
			@endif
		</div> <!-- /fluid -->

	</div> <!-- /main -->

	<!-- MODAL SIGNATURE -->
	<div id="modalSignature" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel">
	    <div class="modal-dialog" role="document">

	        <div id="signature-pad" class="m-signature-pad" style="margin:0 auto;">
			    <div class="m-signature-pad--body">
			    	<canvas></canvas>
			    </div>
			    <div class="m-signature-pad--footer">
					<div class="description">Sign above</div>
					<div class="left">
						<button type="button" class="btn btn-red clear" data-action="clear"><i class="fa fa-eraser"></i> hapus</button>
					</div>
					<div class="right">
						<button type="button" class="btn save" data-action="save-png"><i class="fa fa-save"></i> simpan</button>
					</div>
			    </div>
			</div>

	    </div>
	</div>

@endsection
@if(Auth::check())
@can('staff-access')
@push('scripts')
<script>
	$(document).ready(function() {
		$("#sp3kbgPenomoran").submit(function (e){
			$('#prosesClose').prop('disabled',true);
			$('#customLoad').show();
		});
	})
</script>
@endpush
@endcan
@can('direksi-access')
@push('scripts')
<link rel="stylesheet" href="{{ asset('/css/signature-pad.css') }}" />

<script type="text/javascript" src="{{ asset('/js/signature_pad.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/app_signature.js') }}"></script>

<script>
	$(document).ready(function() {
		var canvas = document.getElementsByTagName('canvas')[0];
		canvas.width  = 456;
		canvas.height = 294;

		$('#template').on('click',function(){
			$('#current-signature').html('<img src="{{ $ttd->value }}"/>');
			$('#ttd_type').val('1');
		});

		$('#tolak').on('click',function(){
			$('#sp3kbg_status').val('T');
			$('.remark-modal-md').modal('show');
		});

		$('#revisi').on('click',function(){
			$('#sp3kbg_status').val('R');
			$('.remark-modal-md').modal('show');
		});

		$('#proses').on('click',function(){
			var img = $('#current-signature img').attr('src');
			$(this).prop('disabled',true);				
			if(img == undefined){
				//$('.formcheck-modal-sm .panel-body').html('Anda belum membubuhkan tanda tangan');
				//$('.formcheck-modal-sm').modal('show');
				$('#ttd').val('');				
			}else{
				$('#ttd').val(img);
			}
			$('#sp3kbg_status').val('C');
                        $('.analisa-direksi').modal('show');
                        $('#analisa').on('click', function () {
                                    $(this).prop('disabled', true);
                                    $('#customLoad').show();
                                    $( "#sp3kbgPenomoran" ).submit();
                        });
		});	
		$("#sp3kbgForm").submit(function (e){
			$('#prosesRevisiTolak').prop('disabled',true);
			$('#customLoad').show();
		});
	})
</script>  
@endpush
@endcan
@endif  