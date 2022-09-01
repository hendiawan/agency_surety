@extends('layouts.app')

@section('content')	
<div id="main" class="clearfix">
            @if(Auth::check())
            @can('direksi-access')	
                <div class="topTabs">

                    <div id="topTabs-container-home">
                        <div class="topTabs-header clearfix">
                            <div class="secInfo">
                                <h1 class="secTitle">Detail SP3KBG</h1>
                                <span class="secExtra">Dengan Nomor Registrasi <strong>{{ $sp3kbg->no_registrasi }}</strong></span>
                            </div>   

                            <ul class="etabs tabs">
                                <li class="tab">
                                    <a href="#tab1">
                                        <span class="to-hide">
                                            <i class="fa fa-newspaper-o"></i><br>Data SP3KBG
                                        </span>
                                        <i class="fa icon-hidden fa-newspaper-o ttip" data-ttip="Data"></i>
                                    </a>
                                </li>
<!--                                <li class="tab">
                                    <a href="#tab2">
                                        <span class="to-hide">
                                            <i class="fa fa-download"></i><br>Attachments Dokumen
                                        </span>
                                        <i class="fa icon-hidden fa-download ttip" data-ttip="Attachments Dokumen"></i>
                                    </a>
                                </li>-->
                            </ul>
                        </div> 

                        <div class="topTabsContent" style="padding-left:0;">
                            @if(Session::has('msgupdate'))
                            <div class="widget-content pad20">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
                                </div>
                            </div>
                            @endif
                            @if($sp3kbg->status=='R')
                            <div class="widget-content pad20">
                                <div class="alert alert-warning">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="fa fa-warning"></i> CATATAN REVISI:</h4> {{ $history->remark }}
                                </div>
                            </div>
                            @endif
                            @if($sp3kbg->status=='T')
                            <div class="widget-content pad20">
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="fa fa-warning"></i> ALASAN PENOLAKAN:</h4> {{ $history->remark }}
                                </div>
                            </div>
                            @endif	
                            <div id="tab1">					
                     
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $sp3kbg->id }}">		
                                    <input type="hidden" name="no_registrasi" value="{{$sp3kbg->no_registrasi}}">	
                                    <div class="widget-header">
                                        <h3 class="widget-title">I. IDENTIFIKASI KONTRAKTOR (TERJAMIN)</h3>
                                    </div>
                                    <div class="widget-content pad20f">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Nama Kontraktor</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->nama_kontraktor }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Alamat Kontraktor</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->alamat_kontraktor }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Bidang Usaha</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->bidang_usaha }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Nama Direksi</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->direksi }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Jabatan</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->jabatan_direksi }}</p>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Dokumen Pendukung</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">
                                                    @foreach($dokPendukung as $dok)
                                                    - {{ $dok }}<br/>
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                    </div>	
                                    <div class="divider"></div>		
                                    <div class="widget-header">
                                        <h3 class="widget-title">II. IDENTIFIKASI PROYEK</h3>
                                    </div>
                                    <div class="widget-content pad20f">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Pemilik Proyek</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->pemilik_proyek }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Nama Pejabat</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->nama_pejabat }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Jabatan</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->jabatan_pejabat }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Alamat</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->alamat }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Jenis Pekerjaan</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->jenis_pekerjaan }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Jenis Dokumen</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->nama_dokumen }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>No Dokumen</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->no_dokumen }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Tanggal Dokumen</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ tgl_indo($sp3kbg->tgl_dokumen) }}</p>
                                            </div>
                                        </div>
                                        @if ($sp3kbg->jenis_sppsb=='2')
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Uang Muka</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->fasilitas }}</p>
                                            </div>
                                        </div>
                                        @if ($sp3kbg->fasilitas=='Ada Uang Muka')
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Persentase Uang Muka</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->persentase }}%</p>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Termin</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->pembayaran }}</p>
                                            </div>
                                        </div>
                                        @if ($sp3kbg->pembayaran=='Ada Termin')
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Jumlah Termin</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->jml_termin }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Sumber Dana</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $sp3kbg->sumber_dana }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Nilai Proyek</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">Rp.<span class="numeric">{{ $sp3kbg->nilai_proyek }}</span> (<code>{{ $nilaiProyek }} Rupiah</code>)</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="divider"></div>		
                                    <div id="questions" class="widget-header">
                                        <h3 class="widget-title">III. PENERIMA JAMINAN</h3>
                                    </div>
                                    <div class="widget-content pad20f">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Bank</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $bank->name }}<br/>{{ $bank->address }}<br/>{{ $bank->wilayah }}<br/>Telp. {{ $bank->phone }}</p>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="divider"></div>
                                    <div id="questions" class="widget-header">
                                        <h3 class="widget-title">IV. URAIAN PENJAMINAN</h3>
                                    </div>
                                     
                                    <div class="widget-content pad20f">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Janis Penjaminan</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">
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
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Nilai Jaminan</strong></label>
                                               
                                            <div class="col-sm-9">
                                                <p class="form-control-static">Rp.<span class="numeric">{{ $sp3kbg->nilai_jaminan }}</span> (<code>{{ $nilaiJaminan }} Rupiah</code>)</p>
                                            </div>
                                        </div>    
                                         
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Jangka Waktu Proyek</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ tgl_indo($sp3kbg->waktu_mulai) }} <strong>s/d</strong> {{ tgl_indo($sp3kbg->waktu_selesai) }} (<code>{{ $sp3kbg->durasi }} Hari</code>)</p>
                                            </div>
                                        </div>
                                         
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Rate IJP Proyek</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $rate['rateIjp'] }}%</p>
                                               
                                            </div>
                                        </div><div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Admin</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">Rp. <span class="numeric">{{ $feeAdmin }}</span> (<code>{{ucwords(terbilang($feeAdmin))}} Rupiah</code>)</p>
                                            </div>
                                            
                                        </div><div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Materai</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">Rp. <span class="numeric">{{ $materai }}</span> (<code>{{ucwords(terbilang($materai))}} Rupiah</code>)</p>
                                            </div>
                                         
                                        </div><div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Gross IJP</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">Rp. <span class="numeric">{{ $grossIjp }}</span> (<code>{{ucwords(terbilang($grossIjp))}} Rupiah</code>)</p>
                                            </div>
                                        </div><div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Total IJP</strong></label>
                                             
                                            <div class="col-sm-9">
                                                <p class="form-control-static">Rp. <span class="numeric">{{ $charge }}</span> (<code>{{ucwords(terbilang($charge))}} Rupiah</code>)</p>
                                            </div>
                                        </div><div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Rate Fee Agen</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $fee }}%</p>
                                            </div>
                                        </div><div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Fee Agen</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">Rp. <span class="numeric">{{ $feeAgen }}</span> (<code>{{ucwords(terbilang($feeAgen))}} Rupiah</code>)</p>
                                            </div>
                                            
                                        </div><div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Net IJP</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">Rp. <span class="numeric">{{ $charge-$feeAgen }}</span> (<code>{{ucwords(terbilang($charge-$feeAgen ))}} Rupiah</code>)</p>
                                            </div>
                                        </div>


                                        @foreach($brgAgunan as $brg)
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Janis Agunan</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $brg->type }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>No Dokumen Agunan</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $brg->no }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Nama Pemilik</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $brg->nama }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Taksiran</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $brg->taksiran }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>	 
                                    <div class="divider"></div>		
                                    <div id="questions" class="widget-header">
                                        <h3 class="widget-title">V. STAFF REGISTER</h3>
                                    </div>
                                    <div class="widget-content pad20f">							
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>Nama Staff </strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{$agen->name}}</p>
                                            </div>
                                        </div>					
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><strong>No Staff</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{$agen->no_agen}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>

                                    @if($sp3kbg->dokumen6 ==""||$sp3kbg->dokumen5 =="")
                                    @if ($sp3kbg->status =='B' || $sp3kbg->status =='R')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Informasi!</strong> Silahkan Klik Tombol       <a id="edit" href="{{ url('/sppsb-edit-staff') }}/{{ $sp3kbg->id }}" class="btn btn-blue"><i class="fa fa-edit"></i> EDIT</a> Kemudian, Upload <b style="color:black">SURAT PENGAJUAN</b> Yang Sudah Di tandatangani  & <b style="color:black">ANALISA SURETY BOND</b> yang telah anda Tangani! ! !
                                    </div>
                                    @endif
                                    @endif 				                    	
                            </div>
                            
<!--                            <div id="tab2">
                                <div class="widget-content pad20f">	
                                    <div class="alert alert-info" role="alert">
                                        <strong>Informasi!</strong> Silahkan download file pada table berikut (jika ada) sebagai dokumen pendukung dalam melakukan analisa...
                                    </div>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>File Name</th>
                                                <th width="15%">Download</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($sp3kbg->dokumen1 !='')
                                            <tr>
                                                <td>{{ $sp3kbg->dokumen1 }}</td>
                                                <td><a href="{{URL::asset('/').$sp3kbg->dokumen1}}" target="_blank"  class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                            </tr>
                                            @endif
                                            @if ($sp3kbg->dokumen2 !='')
                                            <tr>
                                                <td>{{ $sp3kbg->dokumen2 }}</td>
                                                <td><a href="{{URL::asset('/').$sp3kbg->dokumen2}}" target="_blank" class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                            </tr>
                                            @endif
                                            @if ($sp3kbg->dokumen3 !='')
                                            <tr>
                                                <td>{{ $sp3kbg->dokumen3 }}</td>
                                                <td><a href="{{URL::asset('/').$sp3kbg->dokumen3}}" target="_blank" class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                            </tr>
                                            @endif
                                            @if ($sp3kbg->dokumen4 !='')
                                            <tr>
                                                <td>{{ $sp3kbg->dokumen4 }}</td>
                                                <td><a href="{{URL::asset('/').$sp3kbg->dokumen4}}" target="_blank"class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                            </tr>
                                            @endif
                                            @if ($sp3kbg->dokumen5 !='')
                                            <tr>
                                                <td>{{ $sp3kbg->dokumen5 }}</td>
                                                <td><a href="{{URL::asset('/').$sp3kbg->dokumen5}}" target="_blank" class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                            </tr>
                                            @endif
                                            @if ($sp3kbg->dokumen6 !='')
                                            <tr>
                                                <td>{{ $sp3kbg->dokumen6 }}</td>
                                                <td><a href="{{URL::asset('/').$sp3kbg->dokumen6}}" target="_blank"class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>-->
                        </div>
                        
                        <div class="form-group">

                            <div class="divider"></div>		
                            <div id="questions" class="widget-header">
                                <h3 class="widget-title">VI. ANALISA STAFF SURETY BOND</h3>
                            </div>
                            <div class="col-xs-12">
                                  <div class="col-xs-6"><strong> {{$sp3kbg->remark}}</strong></div>
                            </div>
                        </div> 
                           <hr/>
                           <div class="form-group">
                               <div class="divider"></div>		
                               <div id="questions" class="widget-header">
                                   <h3 class="widget-title">VI. LAMPIRAN</h3>
                               </div>
                                
                               <div class="col-xs-12">
                                   <table class="table table-striped table-hover">
                                       <thead>
                                           <tr>
                                               <th>File Name</th>
                                               <th width="15%">Download</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @if ($sp3kbg->dokumen1 !='')
                                           <tr>
                                               <td>{{ $sp3kbg->dokumen1 }}</td>
                                               <td><a href="{{URL::asset('/').$sp3kbg->dokumen1}}" target="_blank"  class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                           </tr>
                                           @endif
                                           @if ($sp3kbg->dokumen2 !='')
                                           <tr>
                                               <td>{{ $sp3kbg->dokumen2 }}</td>
                                               <td><a href="{{URL::asset('/').$sp3kbg->dokumen2}}" target="_blank" class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                           </tr>
                                           @endif
                                           @if ($sp3kbg->dokumen3 !='')
                                         
                                           <tr>
                                               <td>{{ $sp3kbg->dokumen3 }}</td>
                                               <td><a href="{{URL::asset('/').$sp3kbg->dokumen3}}" target="_blank" class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                           </tr>
                                           @endif
                                           @if ($sp3kbg->dokumen4 !='')
                                           <tr>
                                               <td>{{ $sp3kbg->dokumen4 }}</td>
                                               <td><a href="{{URL::asset('/').$sp3kbg->dokumen4}}" target="_blank"class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                           </tr>
                                           @endif
                                           @if ($sp3kbg->dokumen5 !='')
                                           <tr>
                                               <td>{{ $sp3kbg->dokumen5 }}</td>
                                               <td><a href="{{URL::asset('/').$sp3kbg->dokumen5}}" target="_blank" class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                           </tr>
                                           @endif
                                           @if ($sp3kbg->dokumen6 !='')
                                           <tr>
                                               <td>{{ $sp3kbg->dokumen6 }}</td>
                                               <td><a href="{{URL::asset('/').$sp3kbg->dokumen6}}" target="_blank"class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                           </tr>
                                           @endif
                                       </tbody>
                                   </table>
                               </div>
                              
                           </div> 
                             <hr/>
                        
                    </div>
                </div>
            <hr/>
            <div class="form-group">
                <!--					<div class="col-sm-12">
                                                        <button id="template" type="button" class="btn btn-turquoise"><i class="fa fa-folder"></i> Gunakan TTD Template</button>
                                                        <span class="pull-right">
                                                                <button type="button" class="btn btn-blue" data-toggle="modal" data-target="#modalSignature"><i class="fa fa-pencil"></i> Gunakan TTD Baru</button>
                                                        </span>
                                                        </div>-->
            </div>
            <hr/>
            <div class="form-group">
                <form id="sp3kbgPenomoran" class="form-horizontal" method="POST" action="{{ url('/') }}/sp3kbg-direksi-update">
                    {!! csrf_field() !!}
                    <input type="hidden" id="id" name="id" value="{{ $sp3kbg->id }}">
                    <input type="hidden" id="no_registrasi" name="no_registrasi" value="{{ $sp3kbg->no_registrasi }}">
                    <input type="hidden" id="sppsb_status" name="status" value="{{ $sp3kbg->status }}">
                    <input type="hidden" id="charge" name="charge" value="{{ $charge }}">
                    <input type="hidden" id="ttd" name="ttd" value="">
                    <input type="hidden" id="ttd_type" name="ttd_type" value="">

                    <div class="col-sm-6">
                        <a id="back" href="{{ url('/home') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button id="tolak" type="button" class="btn btn-red"><i class="fa fa-folder"></i> TOLAK</button>
                        <button id="revisi" type="button" class="btn btn-yellow"><i class="fa fa-edit"></i> REVISI</button>
                        <button id="proses" type="button" class="btn btn-green"><i class="fa fa-check"></i> PROSES</button>
                    </div>
                    <!-- MODAL  -->
                    <div class="modal fade remark-modal-md" role="dialog" aria-labelledby="mySmallModalLabel">
                        <div class="modal-dialog" role="document">
                            <div id="ModalColor" class="panel">
                                <div class="panel-heading">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-edit" ></i> Catatan</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <textarea class="form-control" name="remark" required></textarea>
                                            <span class="help-block"><small id="txtModal"></small></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button type="button" class="btn btn-red" data-dismiss="modal"><i class="fa fa-close"></i> Keluar</button>
                                    <button id="btnSave" type="submit" class="btn btn-blue"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
 
                    
                </form>	
            </div>
            @endcan
            @endif
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
    $(document).ready(function () {
        $("#sppsbPenomoran").submit(function (e) {
            $('#prosesClose').prop('disabled', true);
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
    $(document).ready(function () {
        var canvas = document.getElementsByTagName('canvas')[0];
        canvas.width = 456;
        canvas.height = 294;

        $('#template').on('click', function () {
            $('#current-signature').html('<img src="{{ $ttd->value }}"/>');
            $('#ttd_type').val('1');
        });

        $('#tolak').on('click', function () {
              $("#ModalColor").attr("class","panel panel-danger");
              $("#txtModal").html('<b>Silahkan Masukkan Alasan Penolakan !!!</b>');
            $('#sppsb_status').val('T');
            $('.remark-modal-md').modal('show');
        });

   // kondisi ketika tombol proses ditekan 
        $('#revisi').on('click', function () {
              $("#ModalColor").attr("class","panel panel-warning");
              $("#txtModal").html('<b>Silahkan Masukkan Catatan Revisi !!! </b>');
                $('#sppsb_status').val('R');
                $('.remark-modal-md').modal('show');
        });

   // kondisi ketika tombol proses ditekan
        $('#proses').on('click', function () {
         
         $("#ModalColor").attr("class","panel panel-success");
         $("#txtModal").html('<b> </b>');
            var img = $('#current-signature img').attr('src');
//			$(this).prop('disabled',true);				
            if (img == undefined) {
                //$('.formcheck-modal-sm .panel-body').html('Anda belum membubuhkan tanda tangan');
                //$('.formcheck-modal-sm').modal('show');
                $('#ttd').val('');
            } else {
                $('#ttd').val(img);
            }
            $('#sppsb_status').val('C');
             $('.remark-modal-md').modal('show');
        
        $('#btnSave').on('click', function () {
                $(this).prop('disabled', true);
                $('#customLoad').show();
                $("#sp3kbgPenomoran").submit();
            });
 
        });

//		$("#sppsbForm").submit(function (e){
//			$('#prosesRevisiTolak').prop('disabled',true);
//			$('#customLoad').show();
//		});
    })
</script>  
@endpush
@endcan
@endif  