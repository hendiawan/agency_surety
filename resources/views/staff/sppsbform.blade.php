@extends('layouts.app')

@section('content')
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Form Input SPPSB</h1>
        <span class="secExtra">Form penginputan/pengisian Surat Permohonan Penerbitan Surety Bond (SPPSB)</span>

    </div> <!-- /SecInfo -->
    <div class="fluid">				
        <div class="widget leftcontent grid12">
            <div class="topTabs">					
                <div id="topTabs-container-form">
                    <div class="topTabs-header clearfix">						
                        <ul class="etabs tabs">
                            <li class="tab">
                                <a href="#tab1" class="penawaran">
                                    <span class="to-hide">
                                        <i class="fa fa-tag"></i><br>Penawaran
                                    </span>
                                    <i class="fa icon-hidden fa-tag" data-toggle="tooltip" data-placement="bottom" title="SPPSB Type Penawaran"></i>
                                </a>
                            </li>
                            <li class="tab">
                                <a href="#tab2" class="pelaksanaan">
                                    <span class="to-hide">
                                        <i class="fa fa-play"></i><br>Pelaksanaan
                                    </span>
                                    <i class="fa icon-hidden fa-play" data-toggle="tooltip" data-placement="bottom" title="SPPSB Type Pelaksanaan"></i>
                                </a>
                            </li>
                            <li class="tab">
                                <a href="#tab3" class="uangMuka">
                                    <span class="to-hide">
                                        <i class="fa fa-money"></i><br>Uang Muka
                                    </span>
                                    <i class="fa icon-hidden fa-money" data-toggle="tooltip" data-placement="bottom" title="SPPSB Type Uang Muka"></i>
                                </a>
                            </li>
                            <li class="tab">
                                <a href="#tab4" class="pemeliharaan">
                                    <span class="to-hide">
                                        <i class="fa fa-wrench"></i><br>Pemeliharaan
                                    </span>
                                    <i class="fa icon-hidden fa-wrench" data-toggle="tooltip" data-placement="bottom" title="SPPSB Type Pemeliharaan"></i>
                                </a>
                            </li>
                            <li class="tab">
                                <a href="#tab5" class="pembayaran">
                                    <span class="to-hide">
                                        <i class="fa fa-money"></i><br>Pembayaran
                                    </span>
                                    <i class="fa icon-hidden fa-money" data-toggle="tooltip" data-placement="bottom" title="SPPSB Type Pembayaran"></i>
                                </a>
                            </li>
                            <li class="tab">
                                <a href="#tab6" class="sanggahBanding">
                                    <span class="to-hide">
                                        <i class="fa fa-gavel"></i><br>Sanggah Banding
                                    </span>
                                    <i class="fa icon-hidden fa-gavel" data-toggle="tooltip" data-placement="bottom" title="SPPSB Type Sanggah Banding"></i>
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
                        <form id="sbbsb-staff" class="form-horizontal" method="POST" action="{{ url('/') }}/sppsb-form-staff" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" id="spps_type" name="jenis" value="{{ old('jenis', 1) }}">
                            <div class="widget-content pad20f">
                                <div class="form-group {{ $errors->has('no_registrasi') ? ' has-error' : '' }}" style="margin-bottom:0">
                                    <label for="no_registrasi" class="col-sm-3 control-label">No. Registrasi SBBSB <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="no_registrasi" value="{{ old('no_registrasi') }}" class="form-control" id="no_registrasi">
                                    </div>
                                </div>
                            </div>
                            
                            <div id="history_penjaminan" class="@if (old('jenis')!='4') hide @endif">
                                    <div class="widget-header">
                                    <h3 class="widget-title">HISTORY PENJAMINAN</h3>
                                    </div>
                                 <div class="widget-content pad20f">
                                        <div id="pialang" class="form-group">
                                            <label class="col-sm-3 control-label">Apakah Penjaminan Sebelumnya di Jamkrida ?</label>
                                            <div class="col-sm-9">
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-blue btn-default @if (old('pialang')=='Ya') active @endif">
                                                        <input checked="" required="" id="telahdijamin" type="radio" name="pialang" value="Ya" @if (old('pialang')=='Ya') checked @endif autocomplete="off">
                                                               Ya
                                                    </label>
                                                    <label class="btn btn-red  btn-default @if (old('pialang')=='Tidak') active @endif">
                                                        <input required="" id="belumdijamin" type="radio" name="pialang" value="Tidak" @if (old('pialang')=='Tidak') checked @endif autocomplete="off">
                                                               Tidak
                                                    </label>
                                                </div>
                                                <span class="help-block"><small>silahkan klik salah satu tab untuk memilih (tab terpilih akan berubah warna menjadi abu-abu)</small></span>
                                            </div>
                                        </div>
                                        <div id="nomorsertifikat" class="form-group @if (old('pialang')!='Ya') hide @endif">
                                            <label for="nomor" class="col-sm-3 control-label">Nomor Sertifikat</label>
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <input type="text" name="nomor_sertifikat" value="{{ old('nomor_sertifikat') }}" class="form-control text-right" id="nomor_sertifikat" placeholder="Masukkan Nomor Sertifikat">
                                                    <span class="input-group-addon">    <a class="fa fa-search"></a></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="nama_pialang" class="form-group  form-group @if (old('pialang')=='Ya'||old('pialang')=='') hide @endif {{ $errors->has('nama_asuransi') ? ' has-error' : '' }}">
                                            <label for="nama_kontraktor" class="col-sm-3 control-label">Nama Perusahaan Asuransi <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="nama_asuransi" value="{{ old('nama_asuransi') }}" class="form-control" id="nama_asuransi">
                                            </div>
                                        </div>

                                        <div id="deskripsi" class="form-group @if (old('pialang')=='Ya'||old('pialang')=='') hide @endif  {{ $errors->has('deskripsi') ? ' has-error' : '' }}">
                                            <label for="alamat_kontraktor" class="col-sm-3 control-label">Deskripsi Singkat Jaminan Pelaksanaan Dan  Jaminan Uang Muka Sebelumnya<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="deskripsi" id="" rows="3">{{ old('deskripsi') }}</textarea>
                                            </div>
                                        </div>

                                        <div id="pengerjaan" class="form-group @if (old('jenis')!='4') hide @endif">
                                            <label class="col-sm-3 control-label">Apakah Proyek Selesai Tepat Waktu ?</label>
                                            <div class="col-sm-9">
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-blue btn-default @if (old('pengerjaan_proyek')=='Ya') active @endif">
                                                        <input id="" type="radio" name="pengerjaan_proyek" value="Ya" @if (old('pengerjaan_proyek')=='Ya') checked @endif autocomplete="off">
                                                               Ya
                                                    </label>
                                                    <label class="btn btn-red  btn-default @if (old('pengerjaan_proyek')=='Tidak') active @endif">
                                                        <input id="" type="radio" name="pengerjaan_proyek" value="Tidak" @if (old('pengerjaan_proyek')=='Tidak') checked @endif autocomplete="off">
                                                               Tidak
                                                    </label>
                                                </div>
                                                <span class="help-block"><small>silahkan klik salah satu tab untuk memilih (tab terpilih akan berubah warna menjadi abu-abu)</small></span>
                                            </div>
                                        </div> 
                                        <div id="kendala" class="form-group  @if (old('pengerjaan_proyek')=='Ya'||old('pialang')=='') hide @endif {{ $errors->has('kendala') ? ' has-error' : '' }}">
                                            <label for="kendala" class="col-sm-3 control-label">Deskripsikan Kendala Proyek Tidak Selesai Tepat Waktu<span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="kendala" id="deskripsi_kendala" rows="3">{{ old('kendala') }}</textarea>
                                            </div>
                                        </div>



                                    </div> 
                                       
                            </div>

                            <div class="widget-header">
                                <h3 class="widget-title">IDENTIFIKASI KONTRAKTOR (TERJAMIN)</h3>
                            </div>
                            <div class="widget-content pad20f">
                                <div class="form-group {{ $errors->has('nama_kontraktor') ? ' has-error' : '' }}">
                                    <label for="nama_kontraktor" class="col-sm-3 control-label">Nama Kontraktor <span class="text-danger">*</span></label>

                                    <div class="col-sm-9">
                                        <input type="text" name="nama_kontraktor" value="{{ old('nama_kontraktor') }}" class="form-control" id="nama_kontraktor">
                                        <div id="kontraktor_list"></div> 
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('alamat_kontraktor') ? ' has-error' : '' }}">
                                    <label for="alamat_kontraktor" class="col-sm-3 control-label">Alamat Kontraktor <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="alamat_kontraktor" id="alamat_kontraktor" rows="3">{{ old('alamat_kontraktor') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bidang_usaha" class="col-sm-3 control-label">Bidang Usaha</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="bidang_usaha" value="{{ old('bidang_usaha') }}" class="form-control" id="bidang_usaha">
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('direksi') ? ' has-error' : '' }}">
                                    <label for="direksi" class="col-sm-3 control-label">Nama Direksi <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="direksi" value="{{ old('direksi') }}" class="form-control" id="direksi">
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('jabatan_direksi') ? ' has-error' : '' }}">
                                    <label class="col-sm-3 control-label">Jabatan <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="btn-group" data-toggle="buttons">
                                            <label id="labeldirektur"  class="btn btn-blue btn-default @if (old('jabatan_direksi')=='Direktur') active @endif">
                                                <input  id="direktur" type="radio" name="jabatan_direksi" value="Direktur" @if (old('jabatan_direksi')=='Direktur') checked @endif autocomplete="off">
                                                        Direktur
                                            </label>
                                            <label id="labelDirektris" class="btn btn-turquoise btn-default @if (old('jabatan_direksi')=='Direktris') active @endif">
                                                <input id='Direktris' type="radio" name="jabatan_direksi" value="Direktris" @if (old('jabatan_direksi')=='Direktris') checked @endif autocomplete="off">
                                                       Direktris
                                            </label>
                                            <label id="labelKuasaDirektur" class="btn btn-yellow btn-default @if (old('jabatan_direksi')=='Kuasa Direktur') active @endif">
                                                <input id="KuasaDirektur" type="radio" name="jabatan_direksi" value="Kuasa Direktur" @if (old('jabatan_direksi')=='Kuasa Direktur') checked @endif autocomplete="off">
                                                       Kuasa Direktur
                                            </label>
                                            <label id="labelKuasaDirektris" class="btn btn-orange btn-default @if (old('jabatan_direksi')=='Kuasa Direktris') active @endif">
                                                <input id="KuasaDirektris" type="radio" name="jabatan_direksi" value="Kuasa Direktris" @if (old('jabatan_direksi')=='Kuasa Direktris') checked @endif autocomplete="off">
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
                                            <label class="btn btn-blue btn-default">
                                                <input type="checkbox" name="dokumen_pendukung[]" value="Company Profile" autocomplete="off">
                                                Company Profile
                                            </label>
                                            <label class="btn btn-turquoise btn-default">
                                                <input type="checkbox" name="dokumen_pendukung[]" value="Referensi Bank" autocomplete="off">
                                                Referensi Bank
                                            </label>
                                            <label class="btn btn-yellow btn-default">
                                                <input type="checkbox" name="dokumen_pendukung[]" value="Asosiasi" autocomplete="off">
                                                Asosiasi
                                            </label>
                                            <label class="btn btn-orange btn-default">
                                                <input type="checkbox" name="dokumen_pendukung[]" value="Neraca Audit" autocomplete="off">
                                                Neraca Audit
                                            </label>
                                        </div>
                                        <span class="help-block"><small>silahkan klik tab-tab berikut untuk memilih (tab terpilih akan berubah warna menjadi abu-abu)</small></span>
                                    </div>
                                </div>
                            </div>	
                            
                                             <div id="pengalaman" class="widget-header">
                                    <h3 class="widget-title">PENGALAMAN KERJA KONTRAKTOR</h3> 
                                    <div class="widget-controls">
                                    <div class="btn-group xtra">
                                        <button class="btn btn-blue addPengalaman" data-toggle="tooltip" data-placement="top" title="Tambah Pengalaman">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div><!-- /btn dd -->
                                </div>
                              </div>
                             <div class="widget-content pad20f">
                                 <div id="history_penjaminan_jamkrida" hidden="">
                                         <h3 class="widget-title">History Penjaminan Pada PT. Jamkrida NTB Bersaing : </h3> 
                               <table id="sp3kbg-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <td>
                                                   No
                                                </td>
                                                <td>
                                                   Jenis Pekerjaan
                                                </td>
                                                <td>
                                                   Tanggal
                                                </td>
                                                <td>
                                                   Jenis Penjaminan
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody id="tblPengalaman">
                                      
                                        </tbody>
                                    </table>
                                 </div>
                           
                                    <div id="contentClonePengalaman">
                                        <div id="pengalamanClone">
                                            
                                            <div id="cloneWrapperPengalaman">
                                                <div class="form-group">									
                                                    <button class="btn btn-red remove-optSelect hidden">
                                                        <i class="fa fa-remove"></i>
                                                    </button>
                                                </div> 
                                                @php  
                                                if(old())
                                                { 
                                                        $i=0;
                                                        foreach( old('jenispekerjaan') as $key => $n ) 
                                                        { 
                                                        @endphp
                                                                <div class="form-group {{ $errors->has('jenispekerjaan')? ' has-error' : '' }}">
                                                                    <label for="jenis_pekerjaan" class="col-sm-3 control-label">Jenis Pekerjaan / Proyek <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-9">
                                                                        <textarea class="form-control clearClone" name="jenispekerjaan[]" rows="3"><?php echo old('jenispekerjaan')[ $i ]?></textarea>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="form-group {{ $errors->has('pemilikproyek')[$i] ? ' has-error' : '' }}">
                                                                    <label for="pemilik_proyek" class="col-sm-3 control-label">Pemilik Proyek <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-9">
                                                                        <textarea class="form-control clearClone" name="pemilikproyek[]" rows="3"><?php echo old('pemilikproyek')[ $i ]?></textarea>
                                                                        <!--<div id="pemilik_proyek_list"></div>--> 
                                                                    </div>
                                                                </div>
                                                                <div class="form-group {{ $errors->has('nodokumen[]') ? ' has-error' : '' }}">
                                                                    <label for="no_dokumen[]" class="col-sm-3 control-label">No Dokumen Penunjukan <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" name="nodokumen[]" value="<?php echo old('nodokumen')[ $i ]?>" class="form-control clearClone"  >
                                                                    </div>
                                                                </div>
                                                                <div class="form-group {{ $errors->has('tgldokumen') ? ' has-error' : '' }}">
                                                                    <label for="tgl_dokumen" class="col-sm-3 control-label">Tgl Dokumen <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <div class="input-group">
                                                                            <input type="text" name="tgldokumen[]" value="<?php echo old('tgldokumen')[ $i ]?>" class="form-control  clearClone tgl_dokumen " placeholder="dd-mm-yyyy">
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                          <hr/>
                                                        @php
                                                        $i++;
                                                        }
                                                     
                                                }else{
                                                        @endphp
                                                         <div class="form-group {{ $errors->has('jenis_pekerjaan') ? ' has-error' : '' }}">
                                                                    <label for="jenis_pekerjaan" class="col-sm-3 control-label">Jenis Pekerjaan / Proyek <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-9">
                                                                        <textarea class="form-control clearClone" name="jenispekerjaan[]" rows="3">{{ old('jenis_pekerjaan') }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group {{ $errors->has('pemilik_proyek[]') ? ' has-error' : '' }}">
                                                                    <label for="pemilik_proyek" class="col-sm-3 control-label">Pemilik Proyek <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-9">
                                                                        <textarea class="form-control clearClone" name="pemilikproyek[]" rows="3">{{ old('pemilik_proyek[]') }}</textarea>
                                                                        <!--<div id="pemilik_proyek_list"></div>--> 
                                                                    </div>
                                                                </div>
                                                                <div class="form-group {{ $errors->has('no_dokumen[]') ? ' has-error' : '' }}">
                                                                    <label for="no_dokumen[]" class="col-sm-3 control-label">No Dokumen Penunjukan <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" name="nodokumen[]" value="{{ old('nodokumen[]') }}" class="form-control clearClone"  >
                                                                    </div>
                                                                </div>
                                                                <div class="form-group {{ $errors->has('tgl_dokumen') ? ' has-error' : '' }}">
                                                                    <label for="tgl_dokumen" class="col-sm-3 control-label">Tgl Dokumen <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <div class="input-group">
                                                                            <input type="text" name="tgldokumen[]" value="{{ old('tgl_dokumen[]') }}" class="form-control  clearClone tgl_dokumen " placeholder="dd-mm-yyyy">
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                          <hr/>
                                                            @php
                                                }
                                                @endphp
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 
                            
                            <div class="divider"></div>			
                            <div class="widget-header">
                                <h3 class="widget-title">IDENTIFIKASI PEMILIK PROYEK (PENERIMA JAMINAN)</h3>
                            </div>
                            <div class="widget-content pad20f">
                                <div class="form-group {{ $errors->has('skpd') ? ' has-error' : '' }}">
                                    <label for="skpd" class="col-sm-3 control-label">SKPD Proyek <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select required="" class="form-control" name="skpd" id="skpd">
                                            <option value="">Pilih SKPD</option>
                                            <option value="6" @if (old('skpd')=='6') selected @endif>SKPD Tingkat I NTB</option>
                                            <option value="7" @if (old('skpd')=='7') selected @endif>SKPD Tingkat II MATARAM</option>
                                            <option value="8" @if (old('skpd')=='8') selected @endif>SKPD Tingkat II LOTENG</option>
                                            <option value="9" @if (old('skpd')=='9') selected @endif>SKPD Tingkat II LOTIM</option>
                                            <option value="10"@if (old('skpd')=='10') selected @endif>SKPD Tingkat II KLU</option>
                                            <option value="11"@if (old('skpd')=='11') selected @endif>SKPD Tingkat II KSB</option>
                                            <option value="13"@if (old('skpd')=='12') selected @endif>SKPD Tingkat II SUMBAWA</option>
                                            <option value="13"@if (old('skpd')=='13') selected @endif>SKPD Tingkat II DOMPU</option>
                                            <option value="14"@if (old('skpd')=='14') selected @endif>SKPD Tingkat II KAB. BIMA</option>
                                            <option value="15"@if (old('skpd')=='15') selected @endif>SKPD Tingkat II KOTA BIMA</option>
                                            <option value="16"@if (old('skpd')=='16') selected @endif>SKPD Tingkat II LOBAR</option>
                                            <option value="17"@if (old('skpd')=='17') selected @endif>INSTANSI VERTIKAL/APBN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('pemilik_proyek') ? ' has-error' : '' }}">
                                    <label for="pemilik_proyek" class="col-sm-3 control-label">Pemilik Proyek <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="pemilik_proyek" id="pemilik_proyek" rows="3">{{ old('pemilik_proyek') }}</textarea>
                                        <div id="pemilik_proyek_list"></div> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_pejabat" class="col-sm-3 control-label">Nama Pejabat</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_pejabat" value="{{ old('nama_pejabat') }}" class="form-control" id="nama_pejabat">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jabatan_pejabat" class="col-sm-3 control-label">Jabatan </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="jabatan_pejabat" value="{{ old('jabatan_pejabat') }}" class="form-control" id="jabatan_pejabat">
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('alamat') ? ' has-error' : '' }}">
                                    <label for="alamat" class="col-sm-3 control-label">Alamat Penerima Jaminan *</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="alamat" id="alamat_pejabat" rows="3">{{ old('alamat') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('jenis_pekerjaan') ? ' has-error' : '' }}">
                                    <label for="jenis_pekerjaan" class="col-sm-3 control-label">Jenis Pekerjaan / Proyek <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="jenis_pekerjaan" id="jenis_pekerjaan" rows="3">{{ old('jenis_pekerjaan') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('nama_dokumen') ? ' has-error' : '' }}">
                                    <label for="nama_dokumen" class="col-sm-3 control-label">Nama Dokumen <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_dokumen" value="{{ old('nama_dokumen') }}" class="form-control" id="nama_dokumen">
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('no_dokumen') ? ' has-error' : '' }}">
                                    <label for="no_dokumen" class="col-sm-3 control-label">No Dokumen Penunjukan <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="no_dokumen" value="{{ old('no_dokumen') }}" class="form-control" id="no_dokumen">
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('tgl_dokumen') ? ' has-error' : '' }}">
                                    <label for="tgl_dokumen" class="col-sm-3 control-label">Tgl Dokumen <span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" name="tgl_dokumen" value="{{ old('tgl_dokumen') }}" class="form-control" id="tgl_dokumen" placeholder="dd-mm-yyyy">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div id="pembayaran" class="form-group @if (old('jenis')!='2') hide @endif">
                                    <label class="col-sm-3 control-label">Pembayaran </label>
                                    <div class="col-sm-9">
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-blue btn-default @if (old('pembayaran')=='Ada Termin') active @endif">
                                                <input id="adaTermin" type="radio" name="pembayaran" value="Ada Termin" @if (old('pembayaran')=='Ada Termin') checked @endif autocomplete="off">
                                                       Ada Termin
                                            </label>
                                            <label class="btn btn-red  btn-default @if (old('pembayaran')=='Tanpa Termin') active @endif">
                                                <input id="tanpaTermin" type="radio" name="pembayaran" value="Tanpa Termin" @if (old('pembayaran')=='Tanpa Termin') checked @endif autocomplete="off">
                                                       Tanpa Termin
                                            </label>
                                        </div>
                                        <span class="help-block"><small>silahkan klik salah satu tab untuk memilih (tab terpilih akan berubah warna menjadi abu-abu)</small></span>
                                    </div>
                                </div>																	
                                <div id="jmlTermin" class="form-group hide">
                                    <label for="jml_termin" class="col-sm-3 control-label">Jumlah Termin</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="number" name="jml_termin" value="{{ old('jml_termin') }}" class="form-control text-right" id="jml_termin" placeholder="0">
                                            <span class="input-group-addon">kali</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="fasilitas" class="form-group @if (old('jenis')!='2') hide @endif">
                                    <label class="col-sm-3 control-label">Fasilitas </label>
                                    <div class="col-sm-9">
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-blue btn-default @if (old('fasilitas')=='Ada Uang Muka') active @endif">
                                                <input id="adaUangMuka" type="radio" name="fasilitas" value="Ada Uang Muka" @if (old('fasilitas')=='Ada Uang Muka') checked @endif autocomplete="off">
                                                       Ada Uang Muka
                                            </label>
                                            <label class="btn btn-red  btn-default @if (old('fasilitas')=='Tanpa Uang Muka') active @endif">
                                                <input id="tanpaUangMuka" type="radio" name="fasilitas" value="Tanpa Uang Muka" @if (old('fasilitas')=='Tanpa Uang Muka') checked @endif autocomplete="off">
                                                       Tanpa Uang Muka
                                            </label>
                                        </div>
                                        <span class="help-block"><small>silahkan klik salah satu tab untuk memilih (tab terpilih akan berubah warna menjadi abu-abu)</small></span>
                                    </div>
                                </div>																	
                                <div id="persentase" class="form-group hide">
                                    <label class="col-sm-3 control-label">Persentase Uang Muka</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="number" name="persentase" value="{{ old('persentase') }}" class="form-control text-right" placeholder="0">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('sumber_dana') ? ' has-error' : '' }}">
                                    <label class="col-sm-3 control-label">Sumber Dana <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-blue btn-default @if (old('sumber_dana')=='APBN') active @endif">
                                                <input type="radio" name="sumber_dana" value="APBN" @if (old('sumber_dana')=='APBN') checked @endif autocomplete="off">
                                                       APBN
                                            </label>
                                            <label class="btn btn-default @if (old('sumber_dana')=='APBD I') active @endif">
                                                <input type="radio" name="sumber_dana" value="APBD I" @if (old('sumber_dana')=='APBD I') checked @endif autocomplete="off">
                                                       APBD I
                                            </label>
                                            <label class="btn btn-turquoise btn-default @if (old('sumber_dana')=='APBD II') active @endif">
                                                <input type="radio" name="sumber_dana" value="APBD II" @if (old('sumber_dana')=='APBD II') checked @endif autocomplete="off">
                                                       APBD II
                                            </label>
                                            <label class="btn btn-green btn-default @if (old('sumber_dana')=='Join Venture') active @endif">
                                                <input type="radio" name="sumber_dana" value="Join Venture" @if (old('sumber_dana')=='Join Venture') checked @endif autocomplete="off">
                                                       Join Venture
                                            </label>
                                            <label class="btn btn-yellow btn-default @if (old('sumber_dana')=='Asing') active @endif">
                                                <input type="radio" name="sumber_dana" value="Asing" @if (old('sumber_dana')=='Asing') checked @endif autocomplete="off">
                                                       Asing
                                            </label>
                                            <label class="btn btn-orange btn-default @if (old('sumber_dana')=='Lain-lain') active @endif">
                                                <input type="radio" name="sumber_dana" value="Lain-lain" @if (old('sumber_dana')=='Lain-lain') checked @endif autocomplete="off">
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
                                            <input type="text" name="nilai_proyek" value="{{ old('nilai_proyek') }}" class="form-control text-right numeric" id="nilai_proyek">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('nilai_proyek') ? ' has-error' : '' }}">
                                    <label for="persentase_penjaminan" class="col-sm-3 control-label">Persentase Pejaminan <span class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="number" maxlength="2" name="persentase_penjaminan" value="{{ old('nilai_proyek') }}" class="form-control text-right numeric" id="persentase_penjaminan">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('nilai_jaminan') ? ' has-error' : '' }}">
                                    <label for="nilai_jaminan" class="col-sm-3 control-label">Nilai Jaminan <span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp.</span>
                                            <input readonly="" type="text"  value="{{ old('nilai_jaminan') }}" class="form-control text-right numeric" id="nilai_jaminan_show">
                                            <input hidden="" type="text"  name="nilai_jaminan" value="{{ old('nilai_jaminan') }}" class=" numeric" id="nilai_jaminan">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('startDate') ? ' has-error' : '' }}">
                                    <label class="col-sm-3 control-label">Jangka Waktu Proyek <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <span class="input-group-addon">Mulai</span>
                                            <input type="text" id="startDate" class="form-control" name="startDate" value="{{ old('startDate') }}" placeholder="dd-mm-yyyy">
                                            <span class="input-group-addon">s/d</span>
                                            <input type="text" id="expiredDate" class="form-control" name="endDate" value="{{ old('endDate') }}" placeholder="dd-mm-yyyy">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="text" name="durasi" value="{{ old('durasi') }}" class="form-control" id="durasi" placeholder="0">
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
                                                <input type="file" name="dok1" class="default">
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
                                                <span class="fileupload-new"><i class="fa fa-paperclip"></i> Unggah file 6</span>
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
                                    <div id="qstnClone">
                                        <div id="cloneWrapper">
                                            <div class="form-group">									
                                                <button class="btn btn-red remove-optSelect hidden">
                                                    <i class="fa fa-remove"></i>
                                                </button>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Jenis Agunan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="type[]" class="form-control clearClone">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">No Dokumen Agunan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="no[]" class="form-control clearClone">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Nama Pemilik</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="nama[]" class="form-control clearClone">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Taksiran</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Rp.</span>
                                                        <input type="text" name="taksiran[]" class="form-control clearClone text-right autoNumeric">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                        </div>
                                    </div>
                                </div>									
                                <div class="form-group {{ $errors->has('tgl_cetak') ? ' has-error' : '' }}">
                                    <label for="tgl_cetak" class="col-sm-3 control-label">Tgl Cetak Surat <span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" name="tgl_cetak" value="{{ old('tgl_cetak') }}" class="form-control" id="tgl_cetak" placeholder="dd-mm-yyyy">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <!--
                                <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                                <span class="custom-input">
                        <input type="checkbox" id="checkRemark"><label for="checkRemark"> data yang saya inputkan sudah sesuai dan benar</label>
                </span>
                                        </div>
                                </div>
                                -->
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
                                        <li>Klik tombol <code>Kembali</code> jika anda batal melakukan penginputan data </li>
                                        <li>Klik tombol <code>Proses</code> untuk menyimpan data yang sudah anda inputkan. Data yang anda inputkan akan berstatus "DRAFT", sehingga masih dapat dilakukan pengeditan kembali sebelum diajukan kepada staff surety bond</li>
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
<link rel="stylesheet" href="{{ asset('/css/select2-4.0.3.css') }}" />

<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/select2.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
var li = 'li:first-child';
        @if (old('jenis') == 1) var li = 'li:first-child'; @endif
        @if (old('jenis') == 2) var li = 'li:nth-child(2)'; @endif
        @if (old('jenis') == 3) var li = 'li:nth-child(3)'; @endif
        @if (old('jenis') == 4) var li = 'li:nth-child(4)'; @endif
        @if (old('jenis') == 5) var li = 'li:nth-child(5)'; @endif
        @if (old('jenis') == 6) var li = 'li:nth-child(6)'; @endif
 
 $('#topTabs-container-form').easytabs({
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

$('.tgl_dokumen').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
});

 if (($('#startDate').length) && ($('#expiredDate').length)) {
            $('#startDate').datepicker({
            format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true
            }).on('changeDate', function (e) {
            $('#expiredDate').datepicker('setStartDate', e.date);
            });
                    $('#expiredDate').datepicker({
            format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true
            }).on('changeDate', function (e) {
            $('#startDate').datepicker('setEndDate', e.date)
                    calculate();
            });
}
//tambah form input
$('#questions').on('click', '.addQuestion', function (e) {

            e.preventDefault();
                   $('.autoNumeric').autoNumeric('destroy');
                    var tpl = $('#qstnClone').clone();
                    tpl.attr('id', '');
                    tpl.find('input.clearClone').each(function () {
                          $(this).val('');
                    });
        //tpl.find('.optSelect').addClass('hidden');
                tpl.find('.remove-optSelect').removeClass('hidden');
        //tpl.find('.dragSortable').removeClass('hidden');

                tpl.appendTo('#contentClone');
                $('.autoNumeric').autoNumeric('init');
});


//remove duplicate
 
$('#contentClone').on('click', '.remove-optSelect', function (e) {
            e.preventDefault();
             var row = $(this).closest('#cloneWrapper');
             row.remove();
});


//tambah form pengalaman kerja
$('#pengalaman').on('click', '.addPengalaman', function (e) {
//        alert('Tambah Data Pengalaman');
            e.preventDefault();
                    $('.autoNumeric').autoNumeric('destroy');//
                    var tpl = $('#pengalamanClone').clone();
                    tpl.attr('id', '');
                    tpl.find('input.clearClone').each(function () { // MENEMUKAN INPUTAN TYPE INPUT YANG BERISI  CLEARCLONE
                            $(this).val('');
                    });
                    tpl.find('textarea.clearClone').each(function () { // MENEMUKAN INPUTAN TYPE TEXTAREA YANG BERISI  CLEARCLONE
                            $(this).val('');
                    });
        //tpl.find('.optSelect').addClass('hidden');
                tpl.find('.remove-optSelect').removeClass('hidden');
        //tpl.find('.dragSortable').removeClass('hidden');

                tpl.appendTo('#contentClonePengalaman');
                $('.autoNumeric').autoNumeric('init');
                

                $('.tgl_dokumen').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        todayHighlight: true
                });
                
});

//remove pengalaman
$('#contentClonePengalaman').on('click', '.remove-optSelect', function (e) {
            e.preventDefault();
             var row = $(this).closest('#cloneWrapperPengalaman');
             row.remove();
});


 $('a.penawaran').on('click', function () {
        $('#spps_type').val('1');
        $('#pembayaran').addClass('hide');
//$('#jmlTermin').addClass('hide');
        $('#fasilitas').addClass('hide');
        $('#history_penjaminan').addClass('hide');
});


$('a.pelaksanaan').on('click', function () {
        $('#spps_type').val('2');
        $('#pembayaran').removeClass('hide');
//$('#jmlTermin').removeClass('hide');
        $('#fasilitas').removeClass('hide');
        $('#history_penjaminan').addClass('hide');
});


$('a.uangMuka').on('click', function () 
 {
        $('#spps_type').val('3');
        $('#pembayaran').addClass('hide');
//$('#jmlTermin').addClass('hide');
        $('#fasilitas').addClass('hide');
         $('#history_penjaminan').addClass('hide');

});

 $('a.pemeliharaan').on('click', function () {
        $('#spps_type').val('4');
         $('#pembayaran').addClass('hide');
        //$('#jmlTermin').addClass('hide');
         $('#pialang').removeClass('hide');
         $('#pengerjaan').removeClass('hide');
         $('#fasilitas').addClass('hide');
         $('#history_penjaminan').removeClass('hide');
});
 
 $('a.pembayaran').on('click', function () {
        $('#spps_type').val('5');
        $('#pembayaran').addClass('hide');
//$('#jmlTermin').addClass('hide');
        $('#fasilitas').addClass('hide');
        $('#history_penjaminan').addClass('hide');
});
        
$('a.sanggahBanding').on('click', function () {
        $('#spps_type').val('6');
        $('#pembayaran').addClass('hide');
//$('#jmlTermin').addClass('hide');
        $('#fasilitas').addClass('hide');
        $('#history_penjaminan').addClass('hide');

});
        /*
         $('#proses').on('click',function(){
         var nilaiProyek = parseFloat($('#nilai_proyek').autoNumeric('get'))||0;
         var nilaiJaminan = parseFloat($('#nilai_jaminan').autoNumeric('get'))||0;
         if($('#checkRemark').prop('checked')){
         $('#nilai_proyek').val(nilaiProyek);
         $('#nilai_jaminan').val(nilaiJaminan);
         $( "#sp3kbgForm" ).submit();
         }else{
         $('.formcheck-modal-sm .panel-body').html('Silahkan checklist pernyataan akan kebenaran data yang anda inputkan');
         $('.formcheck-modal-sm').modal('show');
         }
         })
         */
        $('#bank').select2({
placeholder: "Silahkan pilih Bank...",
        allowClear: true
});
 $('input:radio[name=fasilitas]').change(function () {
        if (this.value == 'Ada Uang Muka')
            $('#persentase').removeClass('hide');
        else
            $('#persentase').addClass('hide');
            $('#persentase').find('input').val('');
});
        
$('input:radio[name=pembayaran]').change(function () {
        if (this.value == 'Ada Termin')
            $('#jmlTermin').removeClass('hide');
        else
            $('#jmlTermin').addClass('hide');
            $('#jmlTermin').find('input').val('');
});


     //tambahan untuk kondisi jika penjaminan sebelumnya dilakukan di jamkirda
 $('input:radio[name=pialang]').change(function () {
            if (this.value == 'Ya')
            {
                 $('#nomorsertifikat').removeClass('hide');
                 $('#nama_pialang').addClass('hide'); 
                 $('#deskripsi').addClass('hide'); 

            }
             else
              {
                   $('#nomorsertifikat').addClass('hide'); 
                   $('#nama_pialang').removeClass('hide');
                   $('#deskripsi').removeClass('hide'); 

              }
                  
        });
        
        $('input:radio[name=pengerjaan_proyek]').change(function () 
        {
            if (this.value == 'Ya')
            {
                  $('#kendala').addClass('hide');

            }
             else
              {
                   $('#kendala').removeClass('hide');
              }
                  
        });
        
        
         $('#nomor_sertifikat').on('change',function() {
                    // the text typed in the input field is assigned to a variable 
                    var query = $(this).val();
                    // call to an ajax function
                    $.ajax({
                        // assign a controller function to perform search action - route name is search
                        url:"/cek-sertifikat",
                        // since we are getting data methos is assigned as GET
                        type:"GET",
                        // data kembalian akan dibaca sebebai file Json
                        dataType: 'json',
                        // data are sent the server
                        data:{'nomorsertifikat':query},
                        // if search is succcessfully done, this callback function is called
                        success:function (data) {
//                        alert(data);
//                            var isi = data;
                            // print the search results in the div called country_list(id)
                              console.dir(data);
//                          console.log(data)
                           
                            Object.keys(data).forEach(function(key) {

                                     console.log(data[key].nama_kontraktor);
                                     $('#nama_kontraktor').val(data[key].nama_kontraktor);
//                                     alert(data[key].nama_kontraktor);
                                     
                                     $("#tblPengalaman"). append(" <tr>"+data[key].nama_kontraktor+"</b> <br>");

                            });
                            
                            
                            $('#nama_kontraktor').val(data[0].nama_kontraktor);
                            $('#alamat_kontraktor').val(data[0].alamat_kontraktor);
                            $('#bidang_usaha').val(data[0].bidang_usaha);
                            $('#direksi').val(data[0].direksi);
                            
                            if(data[0].jabatan_direksi=='Direktur'){
                                 $('#direktur').attr("checked",true);
                                 $('#labeldirektur').attr("class",'btn btn-blue btn-default active');
                            }else if(data[0].jabatan_direksi=='Direktris'){
                                 $('#Direktris').attr("checked",true);
                                 $('#labelDirektris').attr("class",'btn btn-turquoise btn-default active');
                            }else if(data[0].jabatan_direksi=='Kuasa Direktur'){
                                 $('#KuasaDirektur').attr("checked",true);
                                 $('#labelKuasaDirektur').attr("class",'btn btn-yellow btn-default active');
                            }else if(data[0].jabatan_direksi=='Kuasa Direktris'){
                                 $('#KuasaDirektris').attr("checked",true);
                                 $('#labelKuasaDirektris').attr("class",'btn btn-orange btn-default active');
                            }
                             
                        }
                    })
                    // end of ajax call
                });
        


$('#proses').on('click', function () {
                $(this).prop('disabled', true);
                var nilaiProyek = parseFloat($('#nilai_proyek').autoNumeric('get')) || 0;
                var nilaiJaminan = parseFloat($('#nilai_jaminan').autoNumeric('get')) || 0;
                $('#nilai_proyek').val(nilaiProyek);
                $('#nilai_jaminan').val(nilaiJaminan);
                $("#sbbsb-staff").submit();
})

        function calculate() {
        var d1 = $('#startDate').datepicker('getDate');
                var d2 = $('#expiredDate').datepicker('getDate');
                var oneDay = 24 * 60 * 60 * 1000;
                var diff = 0;
                if (d1 && d2) {

        diff = Math.round(Math.abs((d2.getTime() - d1.getTime()) / (oneDay)));
        }
        $('#durasi').val(diff + 1);
//$('.minim').val(d1)
        }

});
        $(document).ready(function () {
// keyup function looks at the keys typed on the search box

 $('#nama_kontraktor').on('keyup', function () {
// the text typed in the input field is assigned to a variable 
var query = $(this).val();
// call to an ajax function
        $.ajax({
        // assign a controller function to perform search action - route name is search
        url: "carikontraktor",
                // since we are getting data methos is assigned as GET
                type: "GET",
                // data are sent the server
                data: {'kontraktor': query},
                // if search is succcessfully done, this callback function is called
                success: function (data) {
                    
                    
                // print the search results in the div called country_list(id)
                $('#kontraktor_list').html(data);
                if(data=='Register'){
                           $("#history_penjaminan_jamkrida"). attr("hidden",true); 
                           $('#alamat_kontraktor').val("");
                           $('#bidang_usaha').val("");
                           $('#direksi').val("");
                }
           
                }
        })
// end of ajax call
});
// initiate a click function on each search result
 $(document).on('click', 'li', function () {
// declare the value in the input field to a variable
var value = $(this).text();
        var idsppsb = $(this).attr("id");
        var nama = $(this).attr("name");
        $.ajax({
        // assign a controller function to perform search action - route name is search
        url: "carikontraktor",
                // since we are getting data methos is assigned as GET
                dataType: 'json',
                // data are sent the server
                data: {'idsppb': idsppsb},
                // if search is succcessfully done, this callback function is called
                success: function (data) {
                            var jenis="";
                            var dataku =   data.data_kontraktor;
//                            console.dir(data.data_kontraktor[0]['tgl_dokumen']);
//                            var tahun = data.data_kontraktor[0]['tgl_dokumen'].split("-")[0];
                            
//                            console.log(tahun);
                            
                            let i = 1;
                            
                             $("#tblPengalaman").empty();
                             
                            for (var print of dataku) 
                            {
                                
                                var tanggal = print.tgl_dokumen.split("-")[2]+"/"+print.tgl_dokumen.split("-")[1]+"/"+print.tgl_dokumen.split("-")[0];
                                        
                                        
                                $("#history_penjaminan_jamkrida"). attr("hidden",false);
                                
                                if(print.jenis_sppsb==1){
                                     jenis = "Penawaran";
                                }
                                else if (print.jenis_sppsb==2){
                                    jenis="Pelaksanaan";
                                }
                                else if (print.jenis_sppsb==3){
                                      jenis="Uang Muka"; 
                                }
                                else if (print.jenis_sppsb==4){
                                      jenis="Pemeliharaan";
                                }
                                else if (print.jenis_sppsb==5){
                                      jenis="Pembayaran";
                                }
                                else if (print.jenis_sppsb==6){
                                      jenis="Sanggah Banding";
                                }
                                  
                                
//                              document.write(car.name + "<br />");
//                                  $("#tblPengalaman"). append(" <table>"+print.nama_kontraktor+"</b> </table>");
                                     $("#tblPengalaman"). append(" <tr>\n\
                                       <td>"+i+"</td>\n\
                                       <td>"+print.jenis_pekerjaan+"</td>\n\
                                      <td>"+tanggal+"</td>\n\
                                      <td>"+jenis+"</td>\n\
                                  </tr>"); 
                                  i++;
                            }
                            
                            
                // assign the value to the search box
                $('#nama_kontraktor').val(data.nama_kontraktor);
                        $('#alamat_kontraktor').val(data.alamat_kontraktor);
                        $('#bidang_usaha').val(data.bidang_usaha);
                        $('#direksi').val(data.nama_direksi);
                        if (data.jabatan_direksi == 'Direktur') {
                $('#direktur').attr("checked", true);
                        $('#labeldirektur').attr("class", 'btn btn-blue btn-default active');
                } else if (data.jabatan_direksi == 'Direktris') {
                $('#Direktris').attr("checked", true);
                        $('#labelDirektris').attr("class", 'btn btn-turquoise btn-default active');
                } else if (data.jabatan_direksi == 'Kuasa Direktur') {
                $('#KuasaDirektur').attr("checked", true);
                        $('#labelKuasaDirektur').attr("class", 'btn btn-yellow btn-default active');
                } else if (data.jabatan_direksi == 'Kuasa Direktris') {
                $('#KuasaDirektris').attr("checked", true);
                        $('#labelKuasaDirektris').attr("class", 'btn btn-orange btn-default active');
                }
                // after click is done, search results segment is made empty
                $('#kontraktor_list').html("");
                }
        })

});
});
        $(document).ready(function () {
// keyup function looks at the keys typed on the search box
$('#pemilik_proyek').on('keyup', function () {
// the text typed in the input field is assigned to a variable 
var query = $(this).val();
// call to an ajax function
        $.ajax({
        // assign a controller function to perform search action - route name is search
        url: "cari-pemilik-proyek",
                // since we are getting data methos is assigned as GET
                type: "GET",
                // data are sent the server
                data: {'pemilik_proyek': query},
                // if search is succcessfully done, this callback function is called
                success: function (data) {
                // print the search results in the div called country_list(id)
                $('#pemilik_proyek_list').html(data);
                }
        })
// end of ajax call
});
// initiate a click function on each search result
        $(document).on('click', 'b', function () {
// declare the value in the input field to a variable
var value = $(this).text();
        var kd_penerima = $(this).attr("id");
        var nama = $(this).attr("name");
        $.ajax({
        // assign a controller function to perform search action - route name is search
        url: "cari-pemilik-proyek",
                // since we are getting data methos is assigned as GET
                dataType: 'json',
                // data are sent the server
                data: {'kd_penerima': kd_penerima},
                // if search is succcessfully done, this callback function is called
                success: function (data) {
                // assign the value to the search box
                $('#pemilik_proyek').val(data.pemilik_proyek);
                        $('#nama_pejabat').val(data.nama_pejabat);
                        $('#jabatan_pejabat').val(data.jabatan_pejabat);
                        $('#alamat_pejabat').val(data.alamat_dinas);
                        $('#jenis_pekerjaan').val(data.jenis_pekerjaan);
                        $('#pemilik_proyek_list').html("");
                }
        })



});

$('#persentase_penjaminan').on('keyup', function () {
        var jumlah = $('#persentase_penjaminan').val().length;
                if (jumlah > 2) {
        alert('Inputan tidak boleh >= 100 % !!');
                $('#persentase_penjaminan').val(0);
        }
                var nilaiProyek = parseFloat($('#nilai_proyek').autoNumeric('get')) || 0;
                var persentseJaminan = $('#persentase_penjaminan').val();
        //                 
                var nilaiJaminan = (nilaiProyek * persentseJaminan / 100);
                $('#nilai_jaminan').val(nilaiJaminan);
                $('#nilai_jaminan_show').val(formatMoney(nilaiJaminan));
        //                          alert(total);
});

});
         
function formatMoney(amount, decimalCount = 2, decimal = ",", thousands = ".") {
  try {
    decimalCount = Math.abs(decimalCount);
    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

    const negativeSign = amount < 0 ? "-" : "";

    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
    let j = (i.length > 3) ? i.length % 3 : 0;

    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
  } catch (e) {
    console.log(e)
  }
};
        
</script>
@endpush