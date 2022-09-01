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
				<h3 align="center"><strong>LAPORAN DOKUMEN BELUM TERBIT</strong></h3>
			</div>
			<table cellspacing="0" width="100%">
			    <tr>
					<td width="10%">Nama Agen</td>
					<td>: {{$agen->name}} ({{$agen->no_agen}})</td>
				</tr>
				<tr>
					<td width="10%">Wilayah</td>
					<td>: {{$agen->wilayah_agensi}} ({{$agen->code_wilayah}})</td>
				</tr>
			</table>
			<p>&nbsp;</p>
			<div class="form-group">
				<div class="col-sm-12">
				<table class="data" cellspacing="0" cellpadding="2" width="100%" border="1">
					    <thead>
					        <tr>
					        	<th>No</th>
				            	<th>Type</th>
					            <th>No Resi</th>
					            <th>Terjamin</th>
					        </tr>
					    </thead>
					    <tbody>
					    @foreach($report as $key => $item)
					    	<tr>
					    		<td align="center">{{$item->rank}}</td>
					    		<td align="center">{{$item->type}}</td>
					    		<td>{{$item->no_registrasi}}</td>
					    		<td>{{$item->nama_kontraktor}}</td>
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