@extends('layouts.app')

@section('content')	
	<div id="main" class="clearfix">
		<div class="secInfo">
			<h1 class="secTitle">Error - Forbidden</h1>
			<span class="secExtra"></span>
		</div> <!-- /SecInfo -->
		<div class="fluid form-horizontal">
			<div class="widget-content pad20f">
                <div class="alert alert-warning">
                    <h4><i class="fa fa-warning"></i> WARNING!</h4>
                    Anda tidak dapat mengakses data yang dimaksud dengan berbagai alasan diantaranya:
                    <ul style="padding-left: 20px !important;">
						<li>Data yang anda maksud belum seharusnya ada dalam proses yang anda maksudkan saat ini</li>
						<li>Data yang anda maksud telah melalui proses yang anda maksudkan saat ini</li>
					</ul>
					Silahkan kembali ke <a href="{{ url('/home') }}">halaman depan</a> untuk melanjutkan proses yang lainnya
                </div>
			</div>
		</div> <!-- /fluid -->

	</div> <!-- /main -->
@endsection