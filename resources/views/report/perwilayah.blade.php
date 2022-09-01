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
    </style>
</head>
<body>
<div id="wrapper" class="container">
	<div id="main" class="form-horizontal clearfix">
		<div class="widget-content pad20f">
			<div class="form-group">
				<h3 align="center"><strong>LAPORAN DOKUMEN PER WILAYAH</strong></h3>
			</div>
			<table cellspacing="0" width="100%">
			    <tr>
					<td width="16%">Tanggal Dokumen</td>
					<td>: {{$tglMulai}} s/d {{$tglSelesai}}</td>
				</tr>
			</table>
			<p>&nbsp;</p>
			<div class="form-group">
				<div class="col-sm-12">
				<table class="data" cellspacing="0" cellpadding="2" width="100%" border="1">
					    <thead>
					        <tr>
				            	<th>Type</th>
					            <th>Wilayah</th>
					            <th>Sertifikat Terbit</th>
					            <th>Sisa Sertifikat</th>
					            <th>IJP Gross</th>
					            <th>Admin</th>
					            <th>Fee Agen</th>
					            <th>Net IJP</th>
					        </tr>
					    </thead>
					    <tbody>
					    @foreach($report as $key => $item)
					    	<tr>
					    		<td align="center">{{$item->type}}</td>
					    		<td>{{$item->wilayah_agensi}}</td>
					    		<td align="center">{{$item->count_terbit}}</td>
					    		<td align="center">{{$item->count_belum}}</td>
					    		<td align="right">{{ number_format($item->gross_ijp,2,",",".") }}</td>
					    		<td align="right">{{ number_format($item->fee_admin,2,",",".") }}</td>
					    		<td align="right">{{ number_format($item->fee_agen,2,",",".") }}</td>
					    		<td align="right">{{ number_format($item->net_ijp,2,",",".") }}</td>
					    	</tr>
					    @endforeach
					    </tbody>
					</table>
				</div>
			</div>
			
		</div>
	</div>
</div>
</body>
</html>