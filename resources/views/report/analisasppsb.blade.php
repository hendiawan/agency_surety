<!DOCTYPE html>
<html lang="en"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Cetak Analisa Surety Bond</title>
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
    </head><body>
        <div id="wrapper" class="container">
            <div id="main" class="form-horizontal clearfix">
                @if ($sppsb->jenis_sppsb!='2')
                <div style="height:40px;"></div>
                @endif
                <div class="widget-content pad20f">
                    <div class="widget-header">
                        <h2 class="widget-title" align="center">ANALISA PERMOHONAN  SURETY BOND</h2>
                    </div>		
<!--			<p align="center">
                            Nomor : {{ $sppsb->no_registrasi }}
                    </p>-->
                    <p>&nbsp;</p>	
<!--			<p align="left"><strong>KEPADA YTH.<br/>PT JAMKRIDA NTB BERSAING<br/>DI MATARAM</strong></p>
                    
                    <p>Dengan hormat,<br/>Dengan ini kami mohon diterbitkan jaminan surety bond sesuai data sebagai berikut:</p>-->
                </div>
                <div class="widget-header">
                    <h3 class="widget-title">I. IDENTIFIKASI  (TERJAMIN)</h3>
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

                @if(count($data_kontraktor)>0)  
                <div class="widget-header">
                    <h3 class="widget-title">HISTORY PENJAMINAN PADA PT. JAMKRIDA NTB : </h3>
                </div>

                <table class="table table-striped table-hover"> 
                    <tr>
                        <th>No</th>
                        <th>Jenis Pekerjaan</th>
                        <th>Tanggal</th>
                        <th>Jenis Penjaminan</th>
                        <th>Nilai Proyek</th>  
                    </tr>  
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
                        <td> Rp. <span class="numeric">{{ number_format($data->nilai_proyek,2,",",".") }}</span></td>
<!--                                      <td> Rp. <span class="numeric">{{ $data->nilai_jaminan }}</span></td>-->
                    </tr>
                    <?php $i++; ?>
                    @endforeach 
                </table>

                @endif
                @if( $sppsb->nama_asuransi!=null) 
                <div class="widget-header">
                    <h3 class="widget-title">HISTORY PENJAMINAN LAINNYA</h3>
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
                            <td><p>Rp. {{ $nilaiProyekFormat }} <em>(Terbilang: {{ $nilaiProyek }} Rupiah)</em></p></td>
                        </tr>
                        <tr valign="top">
                            <td width="180px"><p><strong>Jangka Waktu Proyek</strong></p></td>
                            <td width="10px">:</td>
                            <td><p>{{ tgl_indo($sppsb->waktu_mulai) }} <strong>s/d</strong> {{ tgl_indo($sppsb->waktu_selesai) }} <em>({{ $sppsb->durasi }} Hari)</em></p></td>
                        </tr>
                    </table>

                </div>	
                <!--		<div class="page-break"></div>	-->
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
                            <td><p>Rp. {{ $nilaiJaminanFormat }} <em>(Terbilang: {{ $nilaiJaminan }} Rupiah)</em></p></td>
                        </tr>
                        <tr valign="top">
                            <td width="180px"><p><strong>Rate IJP Proyek</strong></p></td>
                            <td width="10px">:</td>
                            <td><p> {{ $rate }}  %</p></td>
                        </tr>
                        <tr valign="top">
                            <td width="180px"><p><strong>Admin</strong></p></td>
                            <td width="10px">:</td>
                            <td><p>Rp.  {{  number_format($feeAdmin,2,",",".")  }} (Terbilang: {{ ucwords(terbilang($feeAdmin)) }}) Rupiah </p></td>
                        </tr>
                        <tr valign="top">
                            <td width="180px"><p><strong>Materai</strong></p></td>
                            <td width="10px">:</td>
                            <td><p> Rp. {{ number_format($materai,2,",",".")  }}  (Terbilang: {{ucwords(terbilang($materai)) }} Rupiah) </p></td>
                        </tr>

                        <tr valign="top">
                            <td width="180px"><p><strong>Gross IJP</strong></p></td>
                            <td width="10px">:</td>
                            <td><p>Rp.  {{ number_format($grossIjp,2,",",".") }} (Terbilang: {{ucwords(terbilang($grossIjp))}} Rupiah) </p></td>
                        </tr>
                        <tr valign="top">
                            <td width="180px"><p><strong>Service Charge</strong></p></td>
                            <td width="10px">:</td>
                            <td><p>Rp.  {{ number_format($charge,2,",",".")  }}  (Terbilang:{{ ucwords(terbilang($charge))}} Rupiah) </p></td>
                        </tr>



                    </table>
                </div>
                <div class="page-break"></div>	
                <div  class="widget-header">
                    <h3 class="widget-title">IV. ANALISA KELAYAKAN PENJAMINAN</h3>
                </div>
                <div class="widget-content pad20f">

                    <table rules='none' border="1">
                        <tr align="justify">
                            @if($hasilAnalisa) 
                            @foreach($hasilAnalisa as $data)
                            <td width="695px" >Analisa ({{ tgl_indo($sppsb->tgl_cetak) }}): {{ $data->analisa }}</td>
                            @endforeach
                            @else
                            <td  width="695px" height="100px" align=left valign=top> Analisa ({{ tgl_indo($sppsb->tgl_cetak) }}):</td>
                            @endif
                        </tr>
                        <tr>

                            <td  width="695px" height="100px" align=left valign=bottom>   
                                <p>  
                                    @if($historyStaff!=null)<b><u>{{strtoupper($historyStaff->author)}}</u></b>  <br style="line-height:0.3;">@endif
                                    <b>(Staff Penjaminan)</b>
                                </p>
                            </td>
                        </tr>
                        <tr align="justify"> 
                            @if($analisa)
                            <td   width="695px"> Analisa ({{ tgl_indo($sppsb->tgl_cetak) }}):{{ $analisa->analisa_kabag }}</td> 
                            @else
                            <td  width="695px" height="100px" align=left valign=top>Analisa  ({{ tgl_indo($sppsb->tgl_cetak) }}):</td>
                            @endif
                        </tr>
                        <tr>
                            <td  width="695px" height="100px" align=left valign=bottom>  
                                <p> 
                                    @if($historyKabag!=null)  
                                    <b>
                                        <u>{{$historyKabag->author}}</u>
                                    </b>  
                                    <br style="line-height:0.3;">
                                    @endif
                                    <b> (Kabag Penjaminan)</b>
                                </p>
                            </td>
                        </tr>
                    </table> 
                </div>

                <div  class="widget-header">
                    <h3 class="widget-title">V. KEPUTUSAN DIREKSI</h3>
                </div>
                <div class="widget-content pad20f"> 
                    <table rules='none' border="1">
                        <tr align="justify"> 
                            @if($analisa)
                            <td width="695px">Keputusan        @if(isset($historyDirektur->author)) ({{ tgl_indo($sppsb->tgl_cetak) }}): {{ $historyDirektur->remark }} @endif</td> 
                            @else
                            <td  width="695px" height="100px" align=left valign=top> Keputusan ({{ tgl_indo($sppsb->tgl_cetak) }}):</td>
                            @endif
                        </tr>
                        <tr>
                            <td  width="695px" height="120px"align=left valign=bottom>  
                                @if(isset($historyDirektur->author))
                                <b> 
                                    <u>{{strtoupper($historyDirektur->author)}}</u> 
                                </b>  
                                <br style="line-height:0.3;">
                                <b> {{strtoupper($historyDirektur->keterangan)}}</b>
                                @endif
                            </td>

                        </tr>
                        <tr align="justify">

                            @if($analisa)
                            <td width="695px">Keputusan  @if(isset($historyDireksi->author)) ({{ tgl_indo($sppsb->tgl_cetak) }}): {{ $analisa->keputusan }} @endif</td> 
                            @else
                            <td  width="695px" height="100px" align=left valign=top> Keputusan ({{ tgl_indo($sppsb->tgl_cetak) }}):</td>
                            @endif

                        </tr>
                        <tr>
                            <td  width="695px" height="120px"align=left valign=bottom>  
                                @if(isset($historyDireksi->author))
                                <b>
                                    <u>{{strtoupper($historyDireksi->author)}}</u>
                                </b>  
                                <br style="line-height:0.3;">
                                <b> {{strtoupper($historyDireksi->keterangan)}}</b>
                                @endif
                            </td>

                        </tr>
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
            </div>
        </div>
    </body></html>