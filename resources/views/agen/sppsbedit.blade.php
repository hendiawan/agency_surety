@extends('layouts.app')

@section('content')
	<div id="main" class="clearfix">
		<div class="secInfo">
			<h1 class="secTitle">Edit SPPSB</h1>
			<span class="secExtra">Form proses edit Surat Permohonan Penerbitan Surety Bond SPPSB</span>
		</div> <!-- /SecInfo -->
		<div class="fluid">				
			<div class="widget leftcontent grid12">
				<div class="topTabs">					
					<div id="topTabs-container-edit">
						<div class="topTabs-header clearfix">						
							<ul class="etabs tabs">
								<li class="tab">
									<a href="#tab1" class="penawaran">
										<span class="to-hide">
											<i class="fa fa-tag"></i><br>Penawaran
										</span>
										<i class="fa icon-hidden fa-tag" data-toggle="tooltip" title="SPPSB Type Penawaran"></i>
									</a>
								</li>
								<li class="tab">
									<a href="#tab2" class="pelaksanaan">
										<span class="to-hide">
											<i class="fa fa-play"></i><br>Pelaksanaan
										</span>
										<i class="fa icon-hidden fa-play" data-toggle="tooltip" title="SPPSB Type Pelaksanaan"></i>
									</a>
								</li>
								<li class="tab">
									<a href="#tab3" class="uangMuka">
										<span class="to-hide">
											<i class="fa fa-money"></i><br>Uang Muka
										</span>
										<i class="fa icon-hidden fa-money" data-toggle="tooltip" title="SPPSB Type Uang Muka"></i>
									</a>
								</li>
								<li class="tab">
									<a href="#tab4" class="pemeliharaan">
										<span class="to-hide">
											<i class="fa fa-wrench"></i><br>Pemeliharaan
										</span>
										<i class="fa icon-hidden fa-wrench" data-toggle="tooltip" title="SPPSB Type Pemeliharaan"></i>
									</a>
								</li>
								<li class="tab">
									<a href="#tab5" class="pembayaran">
										<span class="to-hide">
											<i class="fa fa-money"></i><br>Pembayaran
										</span>
										<i class="fa icon-hidden fa-money" data-toggle="tooltip" title="SPPSB Type Pembayaran"></i>
									</a>
								</li>
								<li class="tab">
									<a href="#tab6" class="sanggahBanding">
										<span class="to-hide">
											<i class="fa fa-gavel"></i><br>Sanggah Banding
										</span>
										<i class="fa icon-hidden fa-gavel" data-toggle="tooltip" title="SPPSB Type Sanggah Banding"></i>
									</a>
								</li>
							</ul> <!-- /tabs -->
						</div><!-- /topTabs-header -->

						<div class="topTabsContent" style="padding-left:0;">
							<!-- TAB PENAWARAN =========================================================================== -->
							<div id="tab1"></div>
							<div id="tab2"></div>
							<div id="tab3"></div>
							<div id="tab4"></div>
							<div id="tab5"></div>
							<div id="tab6"></div>

							<form id="sppsbForm" class="form-horizontal" method="POST" action="{{ url('/') }}/sppsb-edit" enctype="multipart/form-data">
							{!! csrf_field() !!}
								<input type="hidden" id="sppsb_id" name="id" value="{{ $sppsb->id }}">
								<input type="hidden" id="sppsb_type" name="jenis" value="{{ old('jenis', $sppsb->jenis_sppsb) }}">
								<div class="widget-content pad20f">
									<div class="form-group {{ $errors->has('no_registrasi') ? ' has-error' : '' }}" style="margin-bottom:0">
										<label for="no_registrasi" class="col-sm-3 control-label">No Registrasi SPPSB <span class="text-danger">*</span></label>
										<div class="col-sm-9">
											<input type="text" name="no_registrasi" value="{{ old('no_registrasi', $sppsb->no_registrasi) }}" class="form-control" id="no_registrasi">
										</div>
									</div>
								</div>
								<div class="widget-header">
									<h3 class="widget-title">IDENTIFIKASI KONTRAKTOR (TERJAMIN)</h3>
								</div>
								<div class="widget-content pad20f">
									<div class="form-group {{ $errors->has('no_dokumen') ? ' has-error' : '' }}">
										<label for="nama_kontraktor" class="col-sm-3 control-label">Nama Kontraktor <span class="text-danger">*</span></label>
										<div class="col-sm-9">
											<input type="text" name="nama_kontraktor" value="{{ old('nama_kontraktor', $sppsb->nama_kontraktor) }}" class="form-control" id="nama_kontraktor">
										</div>
									</div>
									<div class="form-group {{ $errors->has('alamat_kontraktor') ? ' has-error' : '' }}">
										<label for="alamat_kontraktor" class="col-sm-3 control-label">Alamat Kontraktor <span class="text-danger">*</span></label>
										<div class="col-sm-9">
											<textarea class="form-control" name="alamat_kontraktor" id="alamat_kontraktor" rows="3">{{ old('alamat_kontraktor', $sppsb->alamat_kontraktor) }}</textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="bidang_usaha" class="col-sm-3 control-label">Bidang Usaha</label>
										<div class="col-sm-9">
											<input type="text" name="bidang_usaha" value="{{ old('bidang_usaha', $sppsb->bidang_usaha) }}" class="form-control" id="bidang_usaha">
										</div>
									</div>
									<div class="form-group {{ $errors->has('direksi') ? ' has-error' : '' }}">
										<label for="direksi" class="col-sm-3 control-label">Nama Direksi <span class="text-danger">*</span></label>
										<div class="col-sm-9">
											<input type="text" name="direksi" value="{{ old('direksi', $sppsb->direksi) }}" class="form-control" id="direksi">
										</div>
									</div>

									<div class="form-group {{ $errors->has('jabatan_direksi') ? ' has-error' : '' }}">
										<label class="col-sm-3 control-label">Jabatan <span class="text-danger">*</span></label>
										<div class="col-sm-9">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-blue btn-default @if ($sppsb->jabatan_direksi=='Direktur') active @endif">
													<input type="radio" name="jabatan_direksi" value="Direktur" @if ($sppsb->jabatan_direksi=='Direktur') checked @endif autocomplete="off">
													Direktur
												</label>
												<label class="btn btn-turquoise btn-default @if ($sppsb->jabatan_direksi=='Direktris') active @endif">
													<input type="radio" name="jabatan_direksi" value="Direktris" @if ($sppsb->jabatan_direksi=='Direktris') checked @endif autocomplete="off">
													Direktris
												</label>
												<label class="btn btn-yellow btn-default @if ($sppsb->jabatan_direksi=='Kuasa Direktur') active @endif">
													<input type="radio" name="jabatan_direksi" value="Kuasa Direktur" @if ($sppsb->jabatan_direksi=='Kuasa Direktur') checked @endif autocomplete="off">
													Kuasa Direktur
												</label>
												<label class="btn btn-orange btn-default @if ($sppsb->jabatan_direksi=='Kuasa Direktris') active @endif">
													<input type="radio" name="jabatan_direksi" value="Kuasa Direktris" @if ($sppsb->jabatan_direksi=='Kuasa Direktris') checked @endif autocomplete="off">
													Kuasa Direktris
												</label>
											</div>
											<span class="help-block"><small>silahkan klik salah satu tab untuk memilih (tab terpilih akan berubah warna menjadi abu-abu)</small></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Dokumen Pendukung</label>
										<div class="col-sm-9">
											<div class="btn-group" data-toggle="buttons">
											<?php $aa = ''; $ac = ''; $ba = ''; $bc = ''; $ca = ''; $cc = ''; $da = ''; $dc = '';?>
											@foreach($dokPendukung as $dok)
												@if($dok=="Company Profile") 
													<?php $aa = 'active'; $ac = 'checked'; ?>
												@endif
												@if($dok=="Referensi Bank")
													<?php $ba = 'active'; $bc = 'checked'; ?>
												@endif
												@if($dok=="Asosiasi")
													<?php $ca = 'active'; $cc = 'checked'; ?>
												@endif
												@if($dok=="Neraca Audit")
													<?php $da = 'active'; $dc = 'checked'; ?>
												@endif
											@endforeach
												<label class="btn btn-blue btn-default {{ $aa }}">
													<input type="checkbox" name="dokumen_pendukung[]" value="Company Profile" {{ $ac }} autocomplete="off">
													Company Profile
												</label>
												<label class="btn btn-turquoise btn-default {{ $ba }}">
													<input type="checkbox" name="dokumen_pendukung[]" value="Referensi Bank" {{ $bc }} autocomplete="off">
													Referensi Bank
												</label>
												<label class="btn btn-yellow btn-default {{ $ca }}">
													<input type="checkbox" name="dokumen_pendukung[]" value="Asosiasi" {{ $cc }} autocomplete="off">
													Asosiasi
												</label>
												<label class="btn btn-orange btn-default {{ $da }}">
													<input type="checkbox" name="dokumen_pendukung[]" value="Neraca Audit" {{ $dc }} autocomplete="off">
													Neraca Audit
												</label>	
											</div>
											<span class="help-block"><small>silahkan klik tab-tab berikut untuk memilih (tab terpilih akan berubah warna menjadi abu-abu)</small></span>
										</div>
									</div>
								</div>	
								<div class="divider"></div>			
								<div class="widget-header">
									<h3 class="widget-title">IDENTIFIKASI PEMILIK PROYEK (PENERIMA JAMINAN)</h3>
								</div>
								<div class="widget-content pad20f">
									<div class="form-group {{ $errors->has('pemilik_proyek') ? ' has-error' : '' }}">
										<label for="pemilik_proyek" class="col-sm-3 control-label">Pemilik Proyek <span class="text-danger">*</span></label>
										<div class="col-sm-9">
											<textarea class="form-control" name="pemilik_proyek" id="pemilik_proyek" rows="3">{{ old('pemilik_proyek', $sppsb->pemilik_proyek) }}</textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="nama_pejabat" class="col-sm-3 control-label">Nama Pejabat</label>
										<div class="col-sm-9">
											<input type="text" name="nama_pejabat" value="{{ old('nama_pejabat', $sppsb->nama_pejabat) }}" class="form-control" id="nama_pejabat">
										</div>
									</div>
									<div class="form-group">
										<label for="jabatan_pejabat" class="col-sm-3 control-label">Jabatan </label>
										<div class="col-sm-9">
											<input type="text" name="jabatan_pejabat" value="{{ old('jabatan_pejabat', $sppsb->jabatan_pejabat) }}" class="form-control" id="jabatan_pejabat">
										</div>
									</div>
									<div class="form-group">
										<label for="alamat" class="col-sm-3 control-label">Alamat</label>
										<div class="col-sm-9">
											<textarea class="form-control" name="alamat" id="alamat" rows="3">{{ old('alamat', $sppsb->alamat) }}</textarea>
										</div>
									</div>
									<div class="form-group {{ $errors->has('jenis_pekerjaan') ? ' has-error' : '' }}">
										<label for="jenis_pekerjaan" class="col-sm-3 control-label">Jenis Pekerjaan / Proyek <span class="text-danger">*</span></label>
										<div class="col-sm-9">
											<textarea class="form-control" name="jenis_pekerjaan" id="jenis_pekerjaan" rows="3">{{ old('jenis_pekerjaan', $sppsb->jenis_pekerjaan) }}</textarea>
										</div>
									</div>
									<div class="form-group {{ $errors->has('nama_dokumen') ? ' has-error' : '' }}">
										<label for="nama_dokumen" class="col-sm-3 control-label">Nama Dokumen <span class="text-danger">*</span></label>
										<div class="col-sm-9">
											<input type="text" name="nama_dokumen" value="{{ old('nama_dokumen', $sppsb->nama_dokumen) }}" class="form-control" id="nama_dokumen">
										</div>
									</div>
									<div class="form-group {{ $errors->has('no_dokumen') ? ' has-error' : '' }}">
										<label for="no_dokumen" class="col-sm-3 control-label">No Dokumen Penunjukan <span class="text-danger">*</span></label>
										<div class="col-sm-9">
											<input type="text" name="no_dokumen" value="{{ old('no_dokumen', $sppsb->no_dokumen) }}" class="form-control" id="no_dokumen">
										</div>
									</div>
									<div class="form-group {{ $errors->has('tgl_dokumen') ? ' has-error' : '' }}">
										<label for="tgl_dokumen" class="col-sm-3 control-label">Tgl Dokumen <span class="text-danger">*</span></label>
										<div class="col-sm-4">
											<div class="input-group">
												<input type="text" name="tgl_dokumen" class="form-control" id="tgl_dokumen" value="{{ Carbon\Carbon::parse(old('tgl_dokumen', $sppsb->tgl_dokumen))->format('d-m-Y') }}" placeholder="dd-mm-yyyy">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											</div>
										</div>
									</div>
									<div id="pembayaran" class="form-group @if (($sppsb->jenis_sppsb)!='2') hide @endif">
										<label class="col-sm-3 control-label">Pembayaran </label>
										<div class="col-sm-9">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-blue btn-default @if ($sppsb->pembayaran=='Ada Termin') active @endif">
													<input type="radio" name="pembayaran" value="Ada Termin" @if ($sppsb->pembayaran=='Ada Termin') checked @endif autocomplete="off">
													Ada Termin
												</label>
												<label class="btn btn-red  btn-default @if ($sppsb->pembayaran=='Tanpa Termin') active @endif">
													<input type="radio" name="pembayaran" value="Tanpa Termin" @if ($sppsb->pembayaran=='Tanpa Termin') checked @endif autocomplete="off">
													Tanpa Termin
												</label>
											</div>
											<span class="help-block"><small>silahkan klik salah satu tab untuk memilih (tab terpilih akan berubah warna menjadi abu-abu)</small></span>
										</div>
									</div>		
									<div id="jmlTermin" class="form-group @if (($sppsb->pembayaran)!='Ada Termin') hide @endif">
										<label for="jml_termin" class="col-sm-3 control-label">Jumlah Termin</label>
										<div class="col-sm-2">
											<div class="input-group">
												<input type="number" name="jml_termin" value="{{ old('jml_termin', $sppsb->jml_termin) }}" class="form-control text-right" id="jml_termin" placeholder="0">
												<span class="input-group-addon">kali</span>
											</div>
										</div>
									</div>
									<div id="fasilitas" class="form-group @if (($sppsb->jenis_sppsb)!='2') hide @endif">
										<label class="col-sm-3 control-label">Fasilitas </label>
										<div class="col-sm-9">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-blue btn-default @if ($sppsb->fasilitas=='Ada Uang Muka') active @endif">
													<input type="radio" name="fasilitas" value="Ada Uang Muka" @if ($sppsb->fasilitas=='Ada Uang Muka') checked @endif autocomplete="off">
													Ada Uang Muka
												</label>
												<label class="btn btn-red  btn-default @if ($sppsb->pembayaran=='Tanpa Uang Muka') active @endif">
													<input type="radio" name="fasilitas" value="Tanpa Uang Muka" @if ($sppsb->fasilitas=='Tanpa Uang Muka') checked @endif autocomplete="off">
													Tanpa Uang Muka
												</label>
											</div>
											<span class="help-block"><small>silahkan klik salah satu tab untuk memilih (tab terpilih akan berubah warna menjadi abu-abu)</small></span>
										</div>
                                                                                  
									</div>																	
									 
									<div id="persentase" class="form-group   @if (($sppsb->fasilitas)!='Ada Uang Muka') hide @endif">
										<label class="col-sm-3 control-label">Persentase Uang Muka</label>
										<div class="col-sm-2">
											<div class="input-group">
												<input type="number" name="persentase" value="{{ old('persentase', $sppsb->persentase) }}" class="form-control text-right" placeholder="0">
												<span class="input-group-addon">%</span>
											</div>
										</div>
									</div>
									<div class="form-group {{ $errors->has('sumber_dana') ? ' has-error' : '' }}">
										<label class="col-sm-3 control-label">Sumber Dana <span class="text-danger">*</span></label>
										<div class="col-sm-9">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-blue btn-default @if ($sppsb->sumber_dana=='APBN') active @endif">
													<input type="radio" name="sumber_dana" value="APBN" @if ($sppsb->sumber_dana=='APBN') checked @endif autocomplete="off">
													APBN
												</label>
												<label class="btn btn-default @if ($sppsb->sumber_dana=='APBD I') active @endif">
													<input type="radio" name="sumber_dana" value="APBD I" @if ($sppsb->sumber_dana=='APBD I') checked @endif autocomplete="off">
													APBD I
												</label>
												<label class="btn btn-turquoise btn-default @if ($sppsb->sumber_dana=='APBD II') active @endif">
													<input type="radio" name="sumber_dana" value="APBD II" @if ($sppsb->sumber_dana=='APBD II') checked @endif autocomplete="off">
													APBD II
												</label>
												<label class="btn btn-green btn-default @if ($sppsb->sumber_dana=='Join Venture') active @endif">
													<input type="radio" name="sumber_dana" value="Join Venture" @if ($sppsb->sumber_dana=='Join Venture') checked @endif autocomplete="off">
													Join Venture
												</label>
												<label class="btn btn-yellow btn-default @if ($sppsb->sumber_dana=='Asing') active @endif">
													<input type="radio" name="sumber_dana" value="Asing" @if ($sppsb->sumber_dana=='Asing') checked @endif autocomplete="off">
													Asing
												</label>
												<label class="btn btn-orange btn-default @if ($sppsb->sumber_dana=='Lain-lain') active @endif">
													<input type="radio" name="sumber_dana" value="Lain-lain" @if ($sppsb->sumber_dana=='Lain-lain') checked @endif autocomplete="off">
													Lain-lain
												</label>
											</div>
											<span class="help-block"><small>silahkan klik salah satu tab untuk memilih (tab terpilih akan berubah warna menjadi abu-abu)</small></span>
										</div>
									</div>
									<div class="form-group {{ $errors->has('nilai_proyek') ? ' has-error' : '' }}">
										<label for="nilai_proyek" class="col-sm-3 control-label">Nilai Proyek <span class="text-danger">*</span></label>
										<div class="col-sm-6">
											<div class="input-group">
												<span class="input-group-addon">Rp.</span>
												<input type="text" name="nilai_proyek" value="{{ old('nilai_proyek', $sppsb->nilai_proyek) }}" class="form-control text-right numeric" id="nilai_proyek">
											</div>
										</div>
									</div>
									<div class="form-group {{ $errors->has('nilai_jaminan') ? ' has-error' : '' }}">
										<label for="nilai_jaminan" class="col-sm-3 control-label">Nilai Jaminan <span class="text-danger">*</span></label>
										<div class="col-sm-6">
											<div class="input-group">
												<span class="input-group-addon">Rp.</span>
												<input type="text" name="nilai_jaminan" value="{{ old('nilai_jaminan', $sppsb->nilai_jaminan) }}" class="form-control text-right numeric" id="nilai_jaminan">
											</div>
										</div>
									</div>
                                                                    <div class="form-group {{ $errors->has('startDate') ? ' has-error' : '' }}">
                                                                        <label class="col-sm-3 control-label">Jangka Waktu Proyek <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-7">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">Mulai</span>
                                                                                <input type="text" id="startDate" class="form-control" name="startDate" value="{{ Carbon\Carbon::parse(old('waktu_mulai', $sppsb->waktu_mulai))->format('d-m-Y') }}" placeholder="dd-mm-yyyy">
                                                                                <span class="input-group-addon">s/d</span>
                                                                                <input type="text" id="expiredDate" class="form-control" name="endDate" value="{{ Carbon\Carbon::parse(old('waktu_selesai', $sppsb->waktu_selesai))->format('d-m-Y') }}" placeholder="dd-mm-yyyy">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <div class="input-group">
                                                                                <input type="text" name="durasi" value="{{ old('durasi', $sppsb->durasi) }}" class="form-control" id="durasi" placeholder="0">
                                                                                <span class="input-group-addon">hari</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-sm-3 control-label">Dokumen Pendukung</label>
                                                                        <div class="col-sm-4">
                                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                                <span class="btn btn-red btn-file">
                                                                                    <span class="fileupload-new"><i class="fa fa-paperclip"></i> Unggah file 1</span>
                                                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Ganti</span>
                                                                                    <input required="" type="file" name="dok1" class="default">
                                                                                </span>
                                                                                <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                                                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                                            </div>
                                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                                <span class="btn btn-red btn-file">
                                                                                    <span class="fileupload-new"><i class="fa fa-paperclip"></i> Unggah file 2</span>
                                                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Ganti</span>
                                                                                    <input type="file" name="dok2" class="default">
                                                                                </span>
                                                                                <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                                                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                                            </div>
                                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                                <span class="btn btn-red btn-file">
                                                                                    <span class="fileupload-new"><i class="fa fa-paperclip"></i> Unggah file 3</span>
                                                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Ganti</span>
                                                                                    <input type="file" name="dok3" class="default">
                                                                                </span>
                                                                                <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                                                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-5">
                                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                                <span class="btn btn-red btn-file">
                                                                                    <span class="fileupload-new"><i class="fa fa-paperclip"></i> Unggah file 4</span>
                                                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Ganti</span>
                                                                                    <input type="file" name="dok4" class="default">
                                                                                </span>
                                                                                <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                                                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                                            </div>
                                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                                <span class="btn btn-red btn-file">
                                                                                    <span class="fileupload-new"><i class="fa fa-paperclip"></i> Unggah file 5</span>
                                                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Ganti</span>
                                                                                    <input type="file" name="dok5" class="default">
                                                                                </span>
                                                                                <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                                                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                                            </div>
                                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                                <span class="btn btn-red btn-file">
                                                                                    <span class="fileupload-new"><i class="fa fa-paperclip"></i>Unggah file 6</span>
                                                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Ganti</span>
                                                                                    <input type="file" name="dok6" class="default">
                                                                                </span>
                                                                                <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                                                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
								</div>	
								<div class="divider"></div>		
								<div id="questions" class="widget-header">
									<h3 class="widget-title">BARANG AGUNAN (COLLATERAL) DAN GARANSI</h3>
									<div class="widget-controls">
				  						<div class="btn-group xtra">
				  							<button class="btn btn-blue addQuestion" data-toggle="tooltip" data-placement="top" title="Tambah inputan">
				  								<i class="fa fa-plus"></i>
				  							</button>
			                            </div><!-- /btn dd -->
									</div>
								</div>
                                                                <div class="widget-content pad20f">						
                                                                    <div id="contentClone">
                                                                        @foreach($brgAgunan as $key => $item)
                                                                        <div @if ($key===0) id="qstnClone" @endif>
                                                                              <div id="cloneWrapper">
                                                                                <div class="form-group">									
                                                                                    <button class="btn btn-red remove-optSelect  @if ($key<1) hidden @endif">
                                                                                        <i class="fa fa-remove"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-sm-3 control-label">Jenis Agunan</label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="text" name="type[]" value="{{ old('type',$item->type) }}" class="form-control clearClone">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-sm-3 control-label">No Dokumen Agunan</label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="text" name="no[]" value="{{ old('no',$item->no) }}" class="form-control clearClone">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-sm-3 control-label">Nama Pemilik</label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="text" name="nama[]" value="{{ old('nama',$item->nama) }}" class="form-control clearClone">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-sm-3 control-label">Taksiran</label>
                                                                                    <div class="col-sm-6">
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon">Rp.</span>
                                                                                            <input type="text" name="taksiran[]" value="{{ old('taksiran',$item->taksiran) }}" class="form-control clearClone text-right autoNumeric">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <hr/>
                                                                            </div>
                                                                        </div>
                                                                        @endforeach
                                                                    </div>									
                                                                    <div class="form-group {{ $errors->has('tgl_cetak') ? ' has-error' : '' }}">
                                                                        <label for="tgl_cetak" class="col-sm-3 control-label">Tgl Cetak Surat <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-4">
                                                                            <div class="input-group">
                                                                                <input type="text" name="tgl_cetak" class="form-control" id="tgl_cetak" value="{{ Carbon\Carbon::parse(old('tgl_cetak', $sppsb->tgl_cetak))->format('d-m-Y') }}" placeholder="dd-mm-yyyy">
                                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <hr/>
                                                                    <div class="form-group">
                                                                        <div class="col-sm-6">
                                                                            <a href="{{ url('/home') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
                                                                        </div>
                                                                        <div class="col-sm-6 text-right">
                                                                            <button id="proses" type="button" class="btn"><i class="fa fa-save"></i> PROSES</button>
                                                                        </div>
                                                                    </div>
                                                                    <hr/>
                                                                    <div class="alert alert-info" role="alert">
                                                                        <h4><i class="fa fa-info-circle"></i> Informasi!</h4>
                                                                        <ul style="padding-left: 20px !important;">
                                                                            <li>Harap menginputkan semua data pada field bertanda <i class="fa fa-asterisk"></i>
                                                                            <li>Klik tombol <code>Kembali</code> jika anda batal melakukan proses editing data SPPSB</li>
                                                                            <li>Klik tombol <code>Proses</code> untuk mengupdate data SPPSB yang sudah anda edit/tambahkan</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>							
							</form>	
						</div>
					</div>
				</div>
			</div>
		</div> <!-- /fluid -->

	</div> <!-- /main -->

@endsection

@push('scripts')    
	<link rel="stylesheet" href="{{ asset('/css/bootstrap-fileupload.css') }}" />
	<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker3.min.css') }}" />

	<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/bootstrap-fileupload.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			@if ($sppsb->jenis_sppsb==1) var li='li:first-child'; @endif
			@if ($sppsb->jenis_sppsb==2) var li='li:nth-child(2)'; @endif
			@if ($sppsb->jenis_sppsb==3) var li='li:nth-child(3)'; @endif
			@if ($sppsb->jenis_sppsb==4) var li='li:nth-child(4)'; @endif
			@if ($sppsb->jenis_sppsb==5) var li='li:nth-child(5)'; @endif
			@if ($sppsb->jenis_sppsb==6) var li='li:nth-child(6)'; @endif
			$('#topTabs-container-edit').easytabs({				
				updateHash: false,
				tabs: "ul.etabs > li",
				animate: true,
				defaultTab: li,
		  		transitionIn: 'slideDown',
		  		transitionOut: 'slideUp'
			});
			$('.autoNumeric').autoNumeric('init');
        	$('#tgl_dokumen, #tgl_cetak').datepicker({
		        format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            });
			if( ($('#startDate').length) && ($('#expiredDate').length) ) {
		        $('#startDate').datepicker({
		            format: 'dd-mm-yyyy',
		            autoclose: true,
		            todayHighlight: true
		        }).on('changeDate', function(e){
		            $('#expiredDate').datepicker('setStartDate', e.date);
		        });
		        $('#expiredDate').datepicker({
		            format: 'dd-mm-yyyy',
		            autoclose: true,
		            todayHighlight: true
		        }).on('changeDate', function(e){
		            $('#startDate').datepicker('setEndDate', e.date)
		        });
		    }
		    //tambah form input
		    $('#questions').on('click','.addQuestion',function(e){
				e.preventDefault();

				$('.autoNumeric').autoNumeric('destroy');

				var tpl =  $('#qstnClone').clone();
				tpl.attr('id','');
				
				tpl.find('input.clearClone').each(function(){
					$(this).val('');
				});
				//tpl.find('.optSelect').addClass('hidden');
				tpl.find('.remove-optSelect').removeClass('hidden');
		        //tpl.find('.dragSortable').removeClass('hidden');
				
				tpl.appendTo('#contentClone');	
				$('.autoNumeric').autoNumeric('init');
			});
		    //remove duplicate
			$('#contentClone').on('click','.remove-optSelect',function(e){
				e.preventDefault();
				var row = $(this).closest('#cloneWrapper');
				row.remove();
			});

			$('a.penawaran').on('click',function(){
				$('#sppsb_type').val('1');
				$('#pembayaran').addClass('hide');
				$('#jmlTermin').addClass('hide');
				$('#fasilitas').addClass('hide');
			});
			$('a.pelaksanaan').on('click',function(){
				$('#sppsb_type').val('2');
				$('#pembayaran').removeClass('hide');
				$('#jmlTermin').removeClass('hide');
				$('#fasilitas').removeClass('hide');
			});
			$('a.uangMuka').on('click',function(){
				$('#sppsb_type').val('3');
				$('#pembayaran').addClass('hide');
				$('#jmlTermin').addClass('hide');
				$('#fasilitas').addClass('hide');
			});
			$('a.pemeliharaan').on('click',function(){
				$('#sppsb_type').val('4');
				$('#pembayaran').addClass('hide');
				$('#jmlTermin').addClass('hide');
				$('#fasilitas').addClass('hide');
			});
			$('a.pembayaran').on('click',function(){
				$('#sppsb_type').val('5');
				$('#pembayaran').addClass('hide');
				$('#jmlTermin').addClass('hide');
				$('#fasilitas').addClass('hide');
			});
			$('a.sanggahBanding').on('click',function(){
				$('#sppsb_type').val('6');
				$('#pembayaran').addClass('hide');
				$('#jmlTermin').addClass('hide');
				$('#fasilitas').addClass('hide');
			});
			$('#proses').on('click',function(){
				$(this).prop('disabled',true);
				var nilaiProyek = parseFloat($('#nilai_proyek').autoNumeric('get'))||0;
				var nilaiJaminan = parseFloat($('#nilai_jaminan').autoNumeric('get'))||0;
				$('#nilai_proyek').val(nilaiProyek);
				$('#nilai_jaminan').val(nilaiJaminan);
				$( "#sppsbForm" ).submit();
			})
                        
                                                                
                                                                  $('input:radio[name=fasilitas]').change(function(){	
                                                                        if(this.value=='Ada Uang Muka')			
                                                                                $('#persentase').removeClass('hide');
                                                                        else
                                                                                $('#persentase').addClass('hide');
                                                                               // $('#persentase').find('input').val('');
                                                                });
                                                                
                                                               
                                                                
                                                                $('input:radio[name=pembayaran]').change(function(){	
				if(this.value=='Ada Termin')			
					$('#jmlTermin').removeClass('hide');
				else
					$('#jmlTermin').addClass('hide');
					//$('#jmlTermin').find('input').val('');
			});

		});
	</script>
@endpush