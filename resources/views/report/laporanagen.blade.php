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
				<h3 align="center"><strong>LAPORAN AGEN</strong></h3>
			</div>
			<table cellspacing="0" width="100%">
				<tr>
					<td width="14%">No Agen</td>
					<td>: {{ $agen->no_agen }}</td>
				</tr>
				<tr>
					<td width="14%">Nama Agen</td>
					<td>: {{ $agen->name }}</td>
				</tr>
				<tr>
					<td width="14%">Wilayah</td>
					<td>: {{ $agen->wilayah_agensi }} (Kode: {{ $agen->code_wilayah }})</td>
				</tr>
			    <tr>
					<td width="14%">Tanggal Dokumen</td>
					<td>: {{$tglMulai}} s/d {{$tglSelesai}}</td>
				</tr>
			</table>
			<p>&nbsp;</p>
			<div class="form-group">
				<div class="col-sm-12">
				<table class="data" cellspacing="0" cellpadding="2" width="100%" border="1">
					    <thead>
					        <tr>
				            	<th>No.</th>
					            <th>No Register</th>
					            <th>No Sertifikat</th>
					            <th>Terjamin</th>
					            <th>Nominal Penjaminan</th>
					            <th>Rate</th>
					            <th>Service Charge</th>
					            <th>Gross IJP</th>
					            <th>Fee Agen</th>
					        </tr>
					    </thead>
					    <tbody>
				        @php 
                            $b = 0;
                            $c = 0;
                            $d = 0;
                        @endphp
					    @foreach($report as $key => $item)
					        @php 
                                $b += $item->bulat_ijp;
                                $c += $item->gross_ijp;
                                $d += $item->fee_agen;
                            @endphp
					    	<tr>
					    		<td align="center">{{$key+1}}</td>
					    		<td>{{$item->no_registrasi}}</td>
					    		<td>{{$item->no_jaminan}}</td>
					    		<td>{{$item->nama_kontraktor}}</td>
					    		<td align="right">{{ number_format($item->nilai_jaminan,2,",",".") }}</td>
					    		<td align="right">{{ number_format($item->rate_ijp,2,",",".") }}</td>
					    		<td align="right">{{ number_format($item->bulat_ijp,2,",",".") }}</td>
					    		<td align="right">{{ number_format($item->gross_ijp,2,",",".") }}</td>
					    		<td align="right">{{ number_format($item->fee_agen,2,",",".") }}</td>
					    	</tr>
					    @endforeach
					    </tbody>
					    <tfoot>
					        <tr>
					            <td colspan="6" align="right"><strong>Total</strong></td>
					            <td align="right"><strong>{{ number_format($b,2,",",".") }}</strong></td>
					            <td align="right"><strong>{{ number_format($c,2,",",".") }}</strong></td>
					            <td align="right"><strong>{{ number_format($d,2,",",".") }}</strong></td>
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