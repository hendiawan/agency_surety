@extends('layouts.app')

@section('content')	
	<div id="main" class="clearfix">
		<div class="secInfo">
			<h1 class="secTitle">Backup Database</h1>
			<span class="secExtra"></span>
		</div> <!-- /SecInfo -->
		<div class="fluid">
			<div class="widget leftcontent grid12">
				<div class="widget-header">
					<div class="icon-grp text-center" style="padding-top:10px;">
						<a href="#" class="btn btn-blue">
							<i class="fa fa-database"></i> BACKUP DB
						</a>
					</div>
				</div>
				<div class="widget-content pad20f">
					<div class="alert alert-info" role="alert">
						<h4><i class="fa fa-info-circle"></i> Informasi!</h4>
						<ul style="padding-left: 20px !important;">
							<li>Silahkan lakukan Backup DB dengan menekan tombol <code>Backup DB</code></li>
							<li>Tunggulah sampai proses download file selesai sebelum anda berpindah halaman </li>
							<li>Lakukan proses Backup Data Base secara berkala untuk mengamankan data dari hal-hal yang tidak terduga</li>
						</ul>
					</div>
				</div>
			</div>
		</div> <!-- /fluid -->

	</div> <!-- /main -->
@endsection