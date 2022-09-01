<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Rekap Detail</title>
    <style type="text/css">
       	body{
    		font-family: 'Dejavu Sans';
    		font-size: 12px;
    	}
    	.widget-content.pad20f {
		    padding: 0 20px 20px;
		}
		h3{
			font-size: 18px;
			line-height: 20px;
			margin-bottom: 40px
		}
		p{
			margin: 0;
			padding: 0;
			text-align: justify;
		}
		table.data thead tr{
			background: #efefef;
			padding: 4px 0;
		}
		table.data tr td{
			font-size: 10px;
		}
    </style>
</head>
<body>
    <div id="wrapper" class="container">
        <div id="main" class="form-horizontal clearfix">
            <div class="widget-content pad20f">
                <div class="form-group">
                    <h3 align="center"><strong>LAPORAN PENJAMINAN ALL DETAIL</strong></h3>
                     
                    <h4 align="center"><strong>Periode {{$tglMulai}} S/D {{$tglSelesai}} </strong></h4>
                </div> 
                <p>&nbsp;</p>
                <div class="form-group">
                    <div class="col-sm-12">
                        <table class="data" cellspacing="0" cellpadding="2" width="100%" border="1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Registrasi</th>
                                    <th>User</th>
                                    <th>Pengajuan</th>
                                    <th>Terjamin</th>
                                    <th>Jenis Jaminan</th>
                                    <th>No Sertifikat</th>
                                    <th>Mulai</th>
                                    <th>Akhir</th>
                                    <th>Status</th> 
                                    <th>Nominal Penjaminan</th>
                                    <th>Rate (%)</th>
                                    <th>Gross IJP</th>
                                    <th>Fee Agen</th>
                                    <th>Net IJP</th>
                                    <th>Admin</th>
                                    <th>Materai</th> 
                                    <th>Service Charge</th>
                               
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                        $net_ijp = 0;
                                        $bulat_ijp = 0;
                                        $gross_ijp = 0;
                                        $fee_agen = 0;
                                        $admin = 0;
                                        $materai = 0;
                                        $nilaiPenjaminan = 0;
                                @endphp
                                @foreach($report as $key => $item)
                                @php 
                                        $net_ijp += $item->net_ijp;
                                        $bulat_ijp += $item->bulat_ijp;
                                        $gross_ijp += $item->gross_ijp;
                                        $fee_agen += $item->fee_agen;
                                        $admin += $item->admin;
                                        $materai += $item->materai;
                                        $nilaiPenjaminan += $item->nilai_jaminan;
                                @endphp
                                
                                 
                                <tr>
                                    <td align="center">{{$key+1}}</td>
                                    <td>{{$item->no_registrasi}}</td>
                                    <td>{{$item->nama}}</td> 
                                    <td align="center">{{Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</td>
                                    <td>{{$item->nama_kontraktor}}</td>
                                        <td>
                                      @if($item->jenis=='1')
                                        JAMINAN PENAWARAN
                                        @endif
                                        @if($item->jenis=='2')
                                        JAMINAN PELAKSANAAN
                                        @endif
                                        @if($item->jenis=='3')
                                        JAMINAN UANG MUKA
                                        @endif
                                        @if($item->jenis=='4')
                                        JAMINAN PEMELIHARAAN
                                        @endif
                                        @if($item->jenis=='5')
                                        JAMINAN PEMBAYARAN
                                        @endif
                                        @if($item->jenis=='6')
                                        JAMINAN SANGGAH BANDING
                                        @endif
                                    
                                    </td>
                                    <td>{{$item->no_jaminan}}</td>
                                    <td>{{$item->mulai}}</td>
                                    <td>{{$item->akhir}}</td>
                                    <td>@if( (date('Y-m-d',strtotime($item->akhir))) > (date('Y-m-d')) ) <b style="color: red">Aktif</b>@else <b>Berakhir</b>@endif</td>
                                    <td align="right">{{ number_format($item->nilai_jaminan,2,",",".") }}</td>
                                    <td align="center">{{$item->rate_ijp}}</td>
                                    <td align="right">{{ number_format($item->gross_ijp,2,",",".") }}</td>
                                    <td align="right">{{ number_format($item->fee_agen,2,",",".") }}</td>
                                      <td align="right">{{ number_format($item->net_ijp,2,",",".") }}</td>
                                     <td align="right">{{ number_format($item->admin,2,",",".") }}</td>
                                    <td align="right">{{ number_format($item->materai,2,",",".") }}</td> 
                                    <td align="right">{{ number_format($item->bulat_ijp,2,",",".") }}</td> 
                                  
                                   
                                 
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="9" align="right"><strong>Total</strong></td> 
                                    <td align="right"><strong>{{ number_format($nilaiPenjaminan   ,2,",",".") }}</strong></td>
                                    <td align="right"><strong></strong></td>
                                    <td align="right"><strong>{{ number_format($gross_ijp ,2,",",".") }}</strong></td>
                                    <td align="right"><strong>{{ number_format($fee_agen  ,2,",",".") }}</strong></td>
                                        <td align="right"><strong>{{ number_format($net_ijp ,2,",",".") }}</strong></td>
                                    <td align="right"><strong>{{ number_format($admin  ,2,",",".") }}</strong></td>
                                    <td align="right"><strong>{{ number_format($materai   ,2,",",".") }}</strong></td> 
                                    <td align="right"><strong>{{ number_format($bulat_ijp ,2,",",".") }}</strong></td>
                           
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>