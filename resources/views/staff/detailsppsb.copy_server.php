<?php
use Carbon\Carbon;
?>
@extends('layouts.app')

@section('content')
<div id="main" class="clearfix">
    <div class="topTabs">

        <div id="topTabs-container-home">
            <div class="topTabs-header clearfix">
                <div class="secInfo">
                    <h1 class="secTitle">Detail SPPSB</h1>
                    <span class="secExtra">Dengan Nomor Registrasi <strong>{{ $sppsb->no_registrasi }}</strong></span>
                </div> <!-- /SecInfo -->

                <ul class="etabs tabs">
                    <li class="tab">
                        <a href="#tab1">
                            <span class="to-hide">
                                <i class="fa fa-newspaper-o"></i><br>Data SPPSB
                            </span>
                            <i class="fa icon-hidden fa-newspaper-o ttip" data-ttip="Data"></i>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#tab2">
                            <span class="to-hide">
                                <i class="fa fa-download"></i><br>Attachments Dokumen
                            </span>
                            <i class="fa icon-hidden fa-download ttip" data-ttip="Attachments Dokumen"></i>
                        </a>
                    </li>
                </ul> <!-- /tabs -->
            </div><!-- /topTabs-header -->

            <div class="topTabsContent" style="padding-left:0;">
                @if(Session::has('msgupdate'))
                <div class="widget-content pad20">
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
                    </div>
                </div>
                @endif
                @if($sppsb->status=='R')
                <div class="widget-content pad20">
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="fa fa-warning"></i> CATATAN REVISI:</h4> {{ $history->remark }}
                    </div>
                </div>
                @endif
                @if($sppsb->status=='T')
                <div class="widget-content pad20">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="fa fa-warning"></i> ALASAN PENOLAKAN:</h4> {{ $history->remark }}
                    </div>
                </div>
                @endif	
                <div id="tab1">					
                    <form id="sppsbForm" class="form-horizontal" action="{{ url('/sppsb-update-staff') }}" enctype="multipart/form-data" method="POST">
                        {{ csrf_field() }}
                        
                        <input type="hidden" name="id" value="{{ $sppsb->sppsb_id }}">		
                        <input type="hidden" name="no_registrasi" value="{{$sppsb->no_registrasi}}">	
                        <div class="widget-header">
                            <h3 class="widget-title">I. IDENTIFIKASI KONTRAKTOR (TERJAMIN)</h3>
                        </div>
                        <div class="widget-content pad20f">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nama Kontraktor</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->nama_kontraktor }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Alamat Kontraktor</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->alamat_kontraktor }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Bidang Usaha</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->bidang_usaha }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nama Direksi</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->direksi }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jabatan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->jabatan_direksi }}</p>
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
                        
<!--                        //JIKA MERUPAKAN JAMINAN PEMELIHARAAN-->
                  
                        @if($sppsb->jenis_sppsb=='4') 
                        @if( $sppsb->nama_asuransi!=null)

                        <div class="widget-header">
                            <h3 class="widget-title">II. HISTORY PENJAMINAN</h3>
                        </div>
                        <div class="widget-content pad20f">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Penjaminan Sebelumnya Berada di : </strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->nama_asuransi }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Deskripsi Singkat Penjaminan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->deskripsi_singkat }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Status Pengerjaan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">@if ( $sppsb->penyelesaian_tepat=='Ya') {{"Proyek Selesai Tepat Waktu "}} @else {{"Proyek Tidak Selsai Tepat Waktu"}} @endif</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Deskripsi Kendala</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->deskripsi_kendala }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif 
                             @if(!is_null($data_kontraktor)) 
                             <div class="widget-header">
                                 <h3 class="widget-title">HISTORY PENJAMINAN PADA PT. JAMKRIDA NTB : </h3>
                             </div>
                             <div class="widget-content pad20f">
                                 <div class="form-group">
                                     <table class="table table-striped table-hover">
                                         <thead>
                                             <tr>
                                                 <th>No</th>
                                                 <th >Jenis Pekerjaan</th>
                                                 <th >Tanggal</th>
                                                 <th >Jenis Penjaminan</th>
                                                 <th >Nilai Proyek</th> 
             <!--                                    <th >Nilai Penjaminan</th> -->
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <?php $i = 1; ?>
                                             @foreach ($data_kontraktor as $data) 
                                             <tr>
                                                 <td>{{$i}}</td>
                                                 <td>{{$data->jenis_pekerjaan}}</td>
                                                 <td>{{date('d-m-Y',strtotime($data->tgl_dokumen))}}</td>
                                                 <td>
                                                     @if($data->jenis_sppsb=='1')
                                                     PENAWARAN
                                                     @endif
                                                     @if($data->jenis_sppsb=='2')
                                                     PELAKSANAAN
                                                     @endif
                                                     @if($data->jenis_sppsb=='3')
                                                     UANG MUKA
                                                     @endif
                                                     @if($data->jenis_sppsb=='4')
                                                     PEMELIHARAAN
                                                     @endif
                                                     @if($data->jenis_sppsb=='5')
                                                     PEMBAYARAN
                                                     @endif
                                                     @if($data->jenis_sppsb=='6')
                                                     SANGGAH BANDING
                                                     @endif
                                                 </td> 
                                                 <td> Rp. <span class="numeric">{{ $data->nilai_proyek }}</span></td>
           <!--                                      <td> Rp. <span class="numeric">{{ $data->nilai_jaminan }}</span></td>-->
                                             </tr>
                                             <?php $i++; ?>
                                             @endforeach
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                             @endif
                      
                          @if($pengalamanKontraktor!=null)
                         <div class="widget-header">
                            <h3 class="widget-title">PENGALAMAN KONTRAKTOR</h3>
                        </div>
                         <br>
                          <?php $i=1; ?>
                       
                         @foreach ($pengalamanKontraktor as $data) 
                         <div class="widget-header">
                            <h3 class="widget-title">PENGALAMAN {{$i}}</h3>
                        </div>
                            <i class="fa icon-hidden fa-newspaper-o ttip" data-ttip="Data"></i>
                        <div class="widget-content pad20f">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jenis Pengerjaan </strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{$data->jenispekerjaan}}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Pemilik Proyek</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{$data->pemilikproyek}}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nomor Dokumen Penunjukan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{$data->nodokumen}}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Tanggal Dokumen</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $data->tgldokumen }}</p>
                                </div>
                            </div>
                        </div> 
                        <?php $i++ ?>
                        @endforeach
                        @endif
                        <div class="widget-header">
                            <h3 class="widget-title">@if($sppsb->jenis_sppsb=='4')IV. @else  II. @endif  IDENTIFIKASI PROYEK (PENERIMA JAMINAN)</h3>
                        </div>
                        <div class="widget-content pad20f">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Pemilik Proyek</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->pemilik_proyek }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nama Pejabat</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->nama_pejabat }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jabatan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->jabatan_pejabat }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Alamat</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->alamat }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jenis Pekerjaan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->jenis_pekerjaan }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jenis Dokumen</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->nama_dokumen }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>No Dokumen</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->no_dokumen }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Tanggal Dokumen</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ tgl_indo($sppsb->tgl_dokumen) }}</p>
                                </div>
                            </div>
                            @if ($sppsb->jenis_sppsb=='2')
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Uang Muka</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->fasilitas }}</p>
                                </div>
                            </div>
                            @if ($sppsb->fasilitas=='Ada Uang Muka')
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Persentase Uang Muka</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->persentase }}%</p>
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Termin</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->pembayaran }}</p>
                                </div>
                            </div>
                            @if ($sppsb->pembayaran=='Ada Termin')
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jumlah Termin</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->jml_termin }}</p>
                                </div>
                            </div>
                            @endif
                            @endif
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Sumber Dana</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $sppsb->sumber_dana }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nilai Proyek</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">Rp.<span class="numeric">{{ $sppsb->nilai_proyek }}</span> (<code>{{ $nilaiProyek }} Rupiah</code>)</p>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>		
                        <div id="questions" class="widget-header">
                            <h3 class="widget-title">@if($sppsb->jenis_sppsb=='4')V. @else  III. @endif  URAIAN PENJAMINAN</h3>
                        </div>
                        <div class="widget-content pad20f">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Janis Penjaminan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">
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
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nilai Jaminan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">Rp.<span class="numeric">{{ $sppsb->nilai_jaminan }}</span> (<code>{{ $nilaiJaminan }} Rupiah</code>)</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Jangka Waktu Proyek</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ tgl_indo($sppsb->waktu_mulai) }} <strong>s/d</strong> {{ tgl_indo($sppsb->waktu_selesai) }} (<code>{{ $sppsb->durasi }} Hari</code>)</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Rate IJP Proyek</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $rate }}%</p>
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
                            <h3 class="widget-title">@if($sppsb->jenis_sppsb=='4')VI. @else  VI. @endif  REGISTER</h3>
                        </div>
                        <div class="widget-content pad20f">							
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Nama  </strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{$agen->name}}</p>
                                </div>
                            </div>					
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>No </strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{$agen->no_agen}}</p>
                                </div>
                            </div>
                        </div> 
                        
                        @if($sppsb->status=='B'||$sppsb->status=='R')
                         <div id="AnalisaKelayakan" class="widget-header">
                                    <h3 class="widget-title">ANALISA KELAYAKAN PENJAMINAN</h3>
                                    <div class="widget-controls">
                                    <div class="btn-group xtra">
                                        <button class="btn btn-blue addDeskripsi" data-toggle="tooltip" data-placement="top" title="Tambah Deskripsi">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div><!-- /btn dd -->
                                </div>
                          </div>
                        <div class="widget-content pad20f">
                                    <div id="contentCloneDeskripsi">
                                        <div id="deskripsiClone">
                                            <div id="cloneWrapperDeskripsi">
                                                <div class="form-group">									
                                                    <button class="btn btn-red remove-optSelect hidden">
                                                        <i class="fa fa-remove"></i>
                                                    </button>
                                                </div> 
                                                <div class="form-group {{ $errors->has('deskripsi') ? ' has-error' : '' }}">
                                                    <label for="deskripsi" class="col-sm-3 control-label">Deskripsi <span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <textarea  required="" class="form-control clearClone" name="deskripsi[]" rows="3">{{ old('deskripsi') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                        
                        @endif
                        
                 
                        
                        @if($hasilAnalisa) 
                        <div  class="widget-header">
                              <h3 class="widget-title">VII. HASIL ANALISA KELAYAKAN PENJAMINAN</h3>
                        </div>
                        <div class="widget-content pad20">
                             <br>
                             @if(Auth::user()->jabatan=='Staff' && $sppsb->status!='C')
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="fa fa-warning"></i> CATATAN :</h4> {{ $analisa->analisa_kabag }}
                            </div>
                             @endif
                        </div>
                         @foreach($hasilAnalisa as $data)
                           <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>-</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $data->analisa }}</p>
                                </div>
                            </div>
                          @endforeach
                           <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Kesimpulan</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{$analisa->rekomendasi}}</p>
                                </div>
                            </div> 
                     
                        @endif
                                    @if($sppsb->status=='C')
                        <div  class="widget-header">
                              <h3 class="widget-title">Fee dan Status Pembayaran</h3>
                        </div>
                         <br>
                         <div class="form-group {{ $errors->has('deskripsi') ? ' has-error' : '' }}">
                                            <label class="col-sm-3 control-label">Persentase Fee Agen</label>
                                            <div class="col-sm-2">
                                                <div class="input-group">
                                                    <input type="number" id="persentase" name="persentase" value="{{ $sppsb->fee,old('persentase') }}" class="form-control text-right" placeholder="0">
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div> 
                          </div>  
                         <div class="form-group ">
                              <label class="col-sm-3 control-label">Status Pembayaran</label>
                              <div class="col-sm-2">
                                  <div class="input-group">

                                      <div class="btn-group" data-toggle="buttons">
                                          <label class="btn btn-blue btn-default @if ($sppsb->status_bayar=="Ya")  active @endif">
                                              <input required="" id="sudahbayar" type="radio" name="pembayaran" value="Ya" >
                                                     Ya
                                          </label>
                                          <label class="btn btn-red  btn-default  @if ($sppsb->status_bayar=="Tidak") active @endif">
                                              <input required="" checked="" id="belumbayar" type="radio" name="pembayaran" value="Tidak">
                                                     Tidak
                                          </label>
                                      </div>  
                                  </div>
                              
                              </div>
                          </div> 
                         <div class="form-group ">
                              <label class="col-sm-3 control-label">File Pembayaran</label>
                              <div class="col-sm-2">
                                  <div class="input-group">
                                          <div class="input-group">               
                                      <div class="fileupload fileupload-new" data-provides="fileupload">
                                          <span class="btn btn-red btn-file">
                                              <span class="fileupload-new"><i class="fa fa-paperclip"></i> Unggah Kwitansi Pembayaran</span>
                                              <span class="fileupload-exists"><i class="fa fa-undo"></i> Ganti</span>
                                              <input type="file" name="kwitansi" class="default">
                                               @if($sppsb->dokumen7!=null)  <a href="{{URL::asset('/').$sppsb->dokumen7}}" target="_blank"  class="icon-button icon-color-green"><i class="fa fa-save"></i></a>@endif
                                          </span>
                                       
                                          <span class="fileupload-preview" style="margin-left:5px;"></span>
                                          <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                      </div> 
                                     @if($sppsb->dokumen7==null)       <button id="proses_update" type="button" class="btn"><i class="fa fa-check"></i> Simpan</button>  @endif
                                  </div>
                                  </div>
                              </div>
                          </div> 
                        @endif 
                            </div> 
                        
                        <div class="widget-content pad20f">
                            
                            
            
                          
         
                   
               
<!--                         @if($sppsb->dokumen6 ==""||$sppsb->dokumen5 =="")
                         @if ($sppsb->status =='B' || $sppsb->status =='R')
                        <div class="alert alert-danger" role="alert">
                            @if($agen->role=="AA") 
                            <strong>Informasi!</strong> Silahkan Klik Tombol       <a id="edit" href="{{ url('/sppsb-edit') }}/{{ $sppsb->id }}" class="btn btn-blue"><i class="fa fa-edit"></i> EDIT</a> Kemudian, Upload  @if($sppsb->dokumen6 =="") <b style="color:black">SURAT PENGAJUAN</b> Yang Sudah Di tandatangani & @endif  <b style="color:black">ANALISA SURETY BOND</b> yang telah anda Tangani! ! !
                            @else
                            <strong>Informasi!</strong> Silahkan Klik Tombol       <a id="edit" href="{{ url('/sppsb-edit-staff') }}/{{ $sppsb->id }}" class="btn btn-blue"><i class="fa fa-edit"></i> EDIT</a> Kemudian, Upload  @if($sppsb->dokumen6 =="") <b style="color:black">SURAT PENGAJUAN</b> Yang Sudah Di tandatangani & @endif  <b style="color:black">ANALISA SURETY BOND</b> yang telah anda Tangani! ! !
                            @endif
                        </div>
                         @endif
                        @endif-->
                        <div class="widget-content pad20f">	
                            
       
                            
                            @if(Auth::check()) 
                                    @can('staff-access')
                                        @if ($sppsb->status =='B' || $sppsb->status =='R'|| $sppsb->status =='K')
                                        
                                           @if(Auth::user()->jabatan=='Kabag'&&$sppsb->status =='K') 
                                            <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <span class="custom-input">
                                                    <input type="checkbox" id="checkRemark"><label for="checkRemark"> Form SPPSB Layak di proses</label>
                                                </span>
                                            </div>
                                        </div>
                                           @endif
                                                 @if ($sppsb->status =='B'||$sppsb->status =='R')
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <span class="custom-input">
                                                    <input type="checkbox" id="checkRemark"><label for="checkRemark"> Form SPPSB Layak di proses</label>
                                                </span>
                                            </div>
                                        </div>
                                                    @endif
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                     
                                                <input id="sppsb_status" type="hidden" name="status" value="">
                                                        @if(Auth::user()->jabatan=='Kabag')
                                                       <button id="proses_ke_direksi" type="button" class="btn"><i class="fa fa-check"></i> KIRIM KE DIREKSI</button>
                                                       <button id="revisi_staff" type="button" class="btn btn-yellow"><i class="fa fa-refresh"></i> KEMBALIKAN KE STAFF</button>
                                                       @else
                                                        @if ($sppsb->status =='B'||$sppsb->status =='R')
                                                        <button id="proses" type="button" class="btn"><i class="fa fa-check"></i> KIRIM KE KABAG</button>
                                                        
                                                        @if($agen->role!='SA')  
                                                                <a id="edit" href="{{ url('/sppsb-edit') }}/{{ $sppsb->sppsb_id }}" class="btn btn-blue"><i class="fa fa-edit"></i> EDIT</a>
                                                        @else 
                                                        @if ($sppsb->status =='B'||$sppsb->status =='R')
                                                              <a id="edit" href="{{ url('/sppsb-edit-staff') }}/{{ $sppsb->sppsb_id }}" class="btn btn-blue"><i class="fa fa-edit"></i> EDIT</a
                                                        @endif
                                                        @endif
                                                        @if($agen->role!='SA')<button id="revisi" type="button" class="btn btn-yellow"><i class="fa fa-edit"></i> REVISI</button>@endif
                                                        @if($agen->role!='SA')<button id="tolak" type="button" class="btn btn-red"><i class="fa fa-hand-stop-o"></i> TOLAK</button>@endif

                                                        
                                                        @endif
                                                       @endif
                                                
                                               
                                            </div>
                                        </div>

                                        <!-- MODAL CHECK ALERT -->
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
                                        
                                   @endif 
                                   @endcan

                                    @can('staff-access')
                                  <br>
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <a id="back" href="{{ url('/sppsb-sp3kbg-data-table-staff') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
                                                    <a id="print" href="{{ url('/cetak-detail-sppsb') }}/{{ $sppsb->sppsb_id }}" class="btn btn-lavender" target="blank"><i class="fa fa-print"></i> PRINT</a>
                                                    <a id="print" href="{{ url('/cetak-analisa-sppsb') }}/{{ $sppsb->sppsb_id }}" class="btn btn-lavender" target="blank"><i class="fa fa-print"></i> PRINT ANALISA</a>
                                                </div>
                                                @if ($sppsb->status =='D' )
                                                <div class="col-sm-6 text-right">
                                                    <a id="edit" href="{{ url('/sppsb-edit-staff') }}/{{ $sppsb->sppsb_id }}" class="btn btn-blue"><i class="fa fa-edit"></i> EDIT</a>
                                                    <!--<button id="kirim" type="button" class="btn btn-green" data-toggle="modal" data-target=".confirm-modal-sm"><i class="fa fa-upload"></i> TRANSFER UNTUK DI VERIFIKASI</button>-->
                                                </div>
                                                @endif
                                                @if ($sppsb->status =='C')
                                                <div class="col-sm-6 text-right">
                                                    <button id="kirim" type="button" class="btn btn-red" data-toggle="modal" data-target=".konfirmasi_export"><i class="fa fa-save"></i> EXPORT KE SIM PK</button>
                                                </div>
                                                
                                                <!--modal untuk transfer ke sim PK-->
                                                <div class="modal fade confirm-modal-sm konfirmasi_export" role="dialog" aria-labelledby="mySmallModalLabel">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-question-circle"></i> Data Penjaminan</h4>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="col-md-12">
                                                                <span class="help-block"><small>NOMOR SERTIFIKAT</small></span>
                                                                <input disabled="" value="{{$sppsb->no_jaminan}}" class="form-control" name="nomor_sertifikat" id="nomor_sertifikat">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <span class="help-block"><small>NAMA KONTRAKTOR</small></span>
                                                                <input disabled="" value="{{$sppsb->nama_kontraktor}}" class="form-control" name="nama_kontraktor" >
                                                            </div>
                                                            <div class="col-md-12">
                                                                <span class="help-block"><small>TGL VERIFIKASI KASI</small></span>
                                                                <input value="{{date('d-m-Y',strtotime($sppsb->tgl_cetak))}}" class="form-control tanggal" name="tgl_ver_kasi" id="tgl_ver_kasi">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <span class="help-block"><small>TGL VERIFIKASI KEUANGAN</small></span>
                                                                <input value="{{date('d-m-Y',strtotime($sppsb->tgl_cetak))}}" class="form-control tanggal" name="tgl_ver_keu" id="tgl_ver_keu">
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="panel-footer">
                                                            <input id="sppsb_status" type="hidden" name="status"   value="E">
                                                            <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Tidak</button>
                                                            <button id="export" type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ya</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                @endif
                                            </div>
                                    @endcan
                                    
                                    
                                    @can('agen-access')
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <a id="back" href="{{ url('/sppsb-sp3kbg-data-table') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
                                                    <a id="print" href="{{ url('/cetak-detail-sppsb') }}/{{ $sppsb->id }}" class="btn btn-lavender" target="blank"><i class="fa fa-print"></i> PRINT</a>
                                                </div>
                                                @if ($sppsb->status =='D' || $sppsb->status =='R')
                                                <div class="col-sm-6 text-right">
                                                    <a id="edit" href="{{ url('/sppsb-edit-staff') }}/{{ $sppsb->id }}" class="btn btn-blue"><i class="fa fa-edit"></i> EDIT</a>
                                                    <button id="kirim" type="button" class="btn btn-green" data-toggle="modal" data-target=".confirm-modal-sm"><i class="fa fa-upload"></i> KIRIM KE STAFF SURETY BOND</button>
                                                </div>
                                                @endif
                                            </div>
                                            @if ($sppsb->status =='D' || $sppsb->status =='R')
                                            <!-- MODAL LOGOUT -->
                                            <div class="modal fade confirm-modal-sm" role="dialog" aria-labelledby="mySmallModalLabel">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-question-circle"></i> Konfirmasi</h4>
                                                        </div>
                                                        <div class="panel-body">
                                                            Apakah anda yakin data yang akan anda serahkan kepada staff surety bond sudah sesuai dan lengkap?
                                                        </div>
                                                        <div class="panel-footer">
                                                            <input type="hidden" name="status" value="B">
                                                            <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Tidak</button>
                                                            <button id="proses" type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ya</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                    @endcan
                            @endif 
                        </div>    
                    </form>					                    	
                </div>
                <div id="tab2">
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
                                @if ($sppsb->dokumen1 !='')
                                <tr>
                                    <td>{{ $sppsb->dokumen1 }}</td>
                                    <td><a href="{{URL::asset('/').$sppsb->dokumen1}}" target="_blank"  class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                </tr>
                                @endif
                                @if ($sppsb->dokumen2 !='')
                                <tr>
                                    <td>{{ $sppsb->dokumen2 }}</td>
                                    <td><a href="{{URL::asset('/').$sppsb->dokumen2}}" target="_blank" class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                </tr>
                                @endif
                                @if ($sppsb->dokumen3 !='')
                                <tr>
                                    <td>{{ $sppsb->dokumen3 }}</td>
                                    <td><a href="{{URL::asset('/').$sppsb->dokumen3}}" target="_blank" class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                </tr>
                                @endif
                                @if ($sppsb->dokumen4 !='')
                                <tr>
                                    <td>{{ $sppsb->dokumen4 }}</td>
                                    <td><a href="{{URL::asset('/').$sppsb->dokumen4}}" target="_blank"class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                </tr>
                                @endif
                                @if ($sppsb->dokumen5 !='')
                                <tr>
                                    <td>{{ $sppsb->dokumen5 }}</td>
                                    <td><a href="{{URL::asset('/').$sppsb->dokumen5}}" target="_blank" class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                </tr>
                                @endif
                                @if ($sppsb->dokumen6 !='')
                                <tr>
                                    <td>{{ $sppsb->dokumen6 }}</td>
                                    <td><a href="{{URL::asset('/').$sppsb->dokumen6}}" target="_blank"class="icon-button icon-color-green"><i class="fa fa-save"></i></a></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@if(Auth::check())

@can('staff-access')
@push('scripts')
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker3.min.css') }}" />
<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/bootstrap-fileupload.css') }}" />
<script type="text/javascript" src="{{ asset('/js/bootstrap-fileupload.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        
          $('#proses').on('click', function () {            
            if ($('#checkRemark').prop('checked')) {
                
                $(this).prop('disabled', true);
//               $('#customLoad').show(); 
                    $("#ModalColor").attr("class","panel panel-success");
                    $("#txtModal").html('<b> Silahkan Masukkan Rekomendasi dari hasil Analisa Anda !!!</b>');
                    $('#sppsb_status').val('K');
//                $('.analisa-staff').modal('show');
//                $("#sppsbForm").submit();
                    $('.remark-modal-md').modal('show');  
                    $('#btnSave').on('click', function () {
                            $(this).prop('disabled', true);
                            $('#customLoad').show();
                            $("#sppsbForm").submit();
                     });
                 
            } else {
                    $('.formcheck-modal-sm .panel-body').html('Silahkan checklist pernyataan akan kelayakan SPPSB untuk di proses lanjutan');
                    $('.formcheck-modal-sm').modal('show');
            }
              
        })
        
        $('#proses_update').on('click', function () {
               $('#sppsb_status').val('Update');
               $("#sppsbForm").submit();
            
         })     
         
          $('#proses_ke_direksi').on('click', function () {            
            if ($('#checkRemark').prop('checked')) {
                
                $(this).prop('disabled', true);
//               $('#customLoad').show(); 
                    $("#ModalColor").attr("class","panel panel-success");
                    $("#txtModal").html('<b> Silahkan Masukkan Rekomendasi Kabag !!!</b>');
                    $('#sppsb_status').val('P');
//                $('.analisa-staff').modal('show');
//                $("#sppsbForm").submit();
                    $('.remark-modal-md').modal('show');  
                    $('#btnSave').on('click', function () {
                            $(this).prop('disabled', true);
                            $('#customLoad').show();
                            $("#sppsbForm").submit();
                     });
                 
            } else {
                    $('.formcheck-modal-sm .panel-body').html('Silahkan checklist pernyataan akan kelayakan SPPSB untuk di proses lanjutan');
                    $('.formcheck-modal-sm').modal('show');
            }
        })
        
          $('#revisi_staff').on('click', function () {            
            if ($('#checkRemark').prop('checked')) {
                
                $(this).prop('disabled', true);
//               $('#customLoad').show(); 
                    $("#ModalColor").attr("class","panel panel-danger");
                    $("#txtModal").html('<b> Silahkan Masukkan Alasan Revisi Kabag !!!</b>');
                    $('#sppsb_status').val('B');
//                $('.analisa-staff').modal('show');
//                $("#sppsbForm").submit();
                    $('.remark-modal-md').modal('show');  
                    $('#btnSave').on('click', function () {
                            $(this).prop('disabled', true);
                            $('#customLoad').show();
                            $("#sppsbForm").submit();
                     });
                 
            } else {
                    $('.formcheck-modal-sm .panel-body').html('Silahkan checklist pernyataan akan kelayakan SPPSB untuk di proses lanjutan');
                    $('.formcheck-modal-sm').modal('show');
            }
        })
        
       // kondisi ketika tombol Tolak ditekan 
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
        
        $("#sppsbForm").submit(function (e) {
            $('#prosesRevisiTolak').prop('disabled', true);
            $('#customLoad').show();
        });
        
        
    });
    
    
//remove Deskripsi
    
$('#AnalisaKelayakan').on('click', '.addDeskripsi', function (e) {
//        alert('Tambah Data Deskripsi');
            e.preventDefault();
                    $('.autoNumeric').autoNumeric('destroy');//
                    var tpl = $('#deskripsiClone').clone();
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

                tpl.appendTo('#contentCloneDeskripsi');
                $('.autoNumeric').autoNumeric('init');
                

                
});

//remove Deskripsi
$('#contentCloneDeskripsi').on('click', '.remove-optSelect', function (e) {
            e.preventDefault();
             var row = $(this).closest('#cloneWrapperDeskripsi');
             row.remove();
});




</script>
@endpush
@endcan

@can('agen-access')
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('#proses').on('click', function () {
            $(this).prop('disabled', true);
            $('#customLoad').show();
            $("#sppsbForm").submit();
        });
    });
</script>
@endpush
@endcan

@can('staff-access')
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
       
        
        $('#export').on('click', function () {
            $(this).prop('disabled', true);
            $('#customLoad').show();
            $('#sppsb_status').val('E');
            $("#sppsbForm").submit();
        });
        
        $('#tgl_ver_kasi,#tgl_ver_keu').datepicker({
		format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            });
            
               $('#persentase').on('keyup', function () {
        var jumlah = $('#persentase').val();
        if (jumlah > 20) {
alert('Inputan tidak boleh lebih dari 20 % !!');
        $('#persentase').val(0);
}
 
});
        
    });
</script>
@endpush
@endcan

@endif 