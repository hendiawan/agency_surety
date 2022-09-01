<?php
use App\Http\Controllers\DireksiController;

?>
@extends('layouts.app')

@section('content')	
<div id="main" class="clearfix">
            @if(Auth::check())
            @can('direksi-access')	
                <div class="topTabs">
                    <div id="topTabs-container-home">
                        <div class="topTabs-header clearfix">
                            <div class="secInfo">
                                <h1 class="secTitle">Detail SPPSB</h1>
                                <span class="secExtra">Dengan Nomor Registrasi <strong>{{ $sppsb->no_registrasi }}</strong></span>
                            </div>   

                            <ul class="etabs tabs">
                                <li class="tab">
                                    <a href="#tab1">
                                        <span class="to-hide">
                                            <i class="fa fa-newspaper-o"></i><br>Data SPPSB
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
                                <form id="sppsbForm" class="form-horizontal" action="{{ url('/sppsb-update-staff') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $sppsb->id }}">		
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
                                    
                                    <!--                        //JIKA MERUPAKAN JAMINAN PEMELIHARAAN-->
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
                  
                        @if($sppsb->jenis_sppsb=='4') 
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
                         <div class="widget-header">
                            <h3 class="widget-title">III. PENGALAMAN KONTRAKTOR</h3>
                        </div>
                    
                        @endif
                        
                                    
                                    
                                    <div class="divider"></div>		
                                    <div class="widget-header">
                                        <h3 class="widget-title">II. IDENTIFIKASI PROYEK (PENERIMA JAMINAN)</h3>
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
                                        <h3 class="widget-title">III. URAIAN PENJAMINAN</h3>
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
                                            <label class="col-sm-3 control-label"><strong>Total IJP (Service Charge)</strong></label>
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
                                        <h3 class="widget-title">IV. STAFF REGISTER</h3>
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
                             
                                    
                                    <div id="questions" class="widget-header">
                                    <h3 class="widget-title">ANALISA STAFF SURETY BOND</h3>
                                    </div>
                                    <div class="widget-content pad20f">							
                                        @if($hasilAnalisa) 
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
                                        </div>
                                    <div id="questions" class="widget-header">
                                     <h3 class="widget-title">ANALISA KABAG</h3>
                                    </div>
                                    <div class="widget-content pad20f">
                                        <div class="col-sm-9">
                                                           <p class="form-control-static">{{$analisa->analisa_kabag}}</p>
                                            </div>
                                    </div> 
                                    
                                    
                       @if($sppsb->original_rate>0)
                        <div id="AnalisaKelayakan" class="widget-header">
                                    <h3 class="widget-title">PENGAJUAN SPECIAL RATE</h3>
                                    <div class="widget-controls"> 
                                </div>
                       </div>
                        <div class="widget-content pad20f">							
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Service Charge Awal</th>
                                            <th>Service Charge Baru</th>
                                            <th>Selisih</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <tr>
                                            <td style="color: #006cad"><b><span class="numeric">{{ (new DireksiController)->pembulatan($awal=($sppsb->nilai_jaminan*$sppsb->original_rate/100)+$sppsb->fee_admin+$sppsb->materai)}}</span></b></td>
                                            <td style="color: red"><b><span class="numeric">{{$baru=$sppsb->service_charge}}</span></b></td>
                                            <td><b><span class="numeric">{{$hasil=$baru-$awal}}</span></b></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                                
                            </div>					
                             
                        </div> 
                       @endif
                        
                                    <br>
                                    @if(!is_null($analisa->analisa_direktur))
                                    <div id="questions" class="widget-header">
                                     <h3 class="widget-title">ANALISA DIREKTUR</h3>
                                    </div>
                                    <div class="widget-content pad20f">
                                        <div class="col-sm-9">
                                                           <p class="form-control-static">{{$analisa->analisa_direktur}}</p>
                                            </div>
                                    </div>  
                                    </div> 
                                    @endif

                                    @if($sppsb->dokumen6 ==""||$sppsb->dokumen5 =="")
                                    @if ($sppsb->status =='B' || $sppsb->status =='R')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Informasi!</strong> Silahkan Klik Tombol       <a id="edit" href="{{ url('/sppsb-edit-staff') }}/{{ $sppsb->id }}" class="btn btn-blue"><i class="fa fa-edit"></i> EDIT</a> Kemudian, Upload <b style="color:black">SURAT PENGAJUAN</b> Yang Sudah Di tandatangani  & <b style="color:black">ANALISA SURETY BOND</b> yang telah anda Tangani! ! !
                                    </div>
                                    @endif
                                    @endif

                                </form>					                    	
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
                            </div>-->
                        </div>
                         <div class="form-group">
                               <div class="divider"></div>		
                               <div id="questions" class="widget-header">
                                   <h3 class="widget-title">DOKUMEN LAMPIRAN</h3>
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
                    <div class="form-group">
                        <form id="sppsbForm" class="form-horizontal" method="POST" action="{{ url('/') }}/sppsb-direksi-update">
                            {!! csrf_field() !!}
                            <input type="hidden" id="id" name="id" value="{{ $sppsb->id }}">
                            <input type="hidden" id="no_registrasi" name="no_registrasi" value="{{ $sppsb->no_registrasi }}">
                            <input type="hidden" id="sppsb_status" name="status" value="{{ $sppsb->status }}">
                            <input type="hidden" id="charge" name="charge" value="{{ $charge }}">
                            <input type="hidden" id="ttd" name="ttd" value="">
                            <input type="hidden" id="ttd_type" name="ttd_type" value="">

                            <div class="col-sm-6">
                                <a id="back" href="{{ url('/home') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button id="tolak" type="button" class="btn btn-red"><i class="fa fa-folder"></i> TOLAK</button>
                                <button id="revisi" type="button" class="btn btn-yellow"><i class="fa fa-edit"></i> REVISI</button>
                                @if(Auth::user()->keterangan=='Direktur')
                                <button id="proses_ke_dirut" type="button" class="btn btn-green"><i class="fa fa-check"></i>PROSES</button>
                                @else
                                <button id="proses" type="button" class="btn btn-green"><i class="fa fa-check"></i> PROSES</button>
                                @endif
                                
                            </div>
                            <!-- MODAL  -->
                            <div class="modal fade remark-modal-md" role="dialog" aria-labelledby="mySmallModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div id="ModalColor" class="panel">
                                        <div class="panel-heading">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            @if(Auth::user()->keterangan=='Direktur')
                                            <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-edit" ></i>Silahkan Masukkan Analisa Anda</h4>
                                            @else
                                            <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-edit" ></i>Silahkan Masukkan Catatan</h4>
                                            @endif
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <textarea class="form-control" name="remark" required id="analisa"></textarea>
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

                            <div class="form-group">
                                <!--					<div class="col-sm-12">
                                                                        <button id="template" type="button" class="btn btn-turquoise"><i class="fa fa-folder"></i> Gunakan TTD Template</button>
                                                                        <span class="pull-right">
                                                                                <button type="button" class="btn btn-blue" data-toggle="modal" data-target="#modalSignature"><i class="fa fa-pencil"></i> Gunakan TTD Baru</button>
                                                                        </span>
                                                                        </div>-->
                            </div>
                        </form>	
                    </div>

                </div>
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
            $('#analisa').attr('required',true);
            $('.remark-modal-md').modal('show');
        });

   // kondisi ketika tombol proses ditekan 
        $('#revisi').on('click', function () {
              $("#ModalColor").attr("class","panel panel-warning");
              $("#txtModal").html('<b>Silahkan Masukkan Catatan Revisi !!! </b>');
                $('#sppsb_status').val('R');
                $('#analisa').attr('required',true);
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
            $('#analisa').attr('required',true);
             $('.remark-modal-md').modal('show');
        
        $('#btnSave').on('click', function () {
            
            if( $('#analisa').val()!=""){
                  $(this).prop('disabled', true);
                $('#customLoad').show();
                $("#sppsbForm").submit();
            }else{
                alert('Silahkan masukkan analisa anda!!');
            }
              
            });
 
        });
       
       $('#proses_ke_dirut').on('click', function () {
         
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
            $('#sppsb_status').val('P');
            $('#analisa').attr('required',true);
             $('.remark-modal-md').modal('show');
        
        $('#btnSave').on('click', function () { 
               if( $('#analisa').val()!=""){
                  $(this).prop('disabled', true);
                $('#customLoad').show();
                $("#sppsbForm").submit();
            }else{
                alert('Silahkan masukkan analisa anda!!');
            } 
            
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