@extends('layouts.app')

@section('content')	
	<div id="main" class="clearfix">
		<div class="secInfo">
			<h1 class="secTitle">Profil Pengguna</h1>
			<span class="secExtra"></span>
		</div> <!-- /SecInfo -->
		<div class="fluid">
			<div class="widget leftcontent grid4">
				<div class="widget-header" style="background:transparent">
					<h3 class="widget-title">Foto Profil</h3>
					<!--
					<div class="widget-controls">
  						<div class="btn-group xtra">
							<a href="#" onclick="return false;" class="icon-button dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
							<ul class="dropdown-menu pull-right">
                                    <li><a href="#"><i class="fa fa-pencil"></i> Edit</a></li>
                                    <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                                    <li><a href="#"><i class="fa fa-ban"></i> Ban</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#"> Other actions</a></li>
                                </ul>
                        </div>
					</div>
					-->
				</div>
				
				<div class="widget-content pad20f">
					<div class="profileImg">
			   			<img src="{{ asset('uploads/profil') }}/{{$user->foto}}" rel="user">					
			   		</div>
				</div> <!-- /widget-content -->

				<div class="divider"></div>

			</div> <!-- /widget -->

			<div class="widget grid8 form-horizontal">
				<div class="widget-header" style="background:transparent">
					<h3 class="widget-title">Data Pengguna </h3>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="widget-content pad20f">
				
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>Nama Pengguna</strong></label>
						<div class="col-sm-8">
							<p class="form-control-static">: {{ $user->name }}</p>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>Jabatan</strong></label>
						<div class="col-sm-8">
							<p class="form-control-static">: {{ $user->jabatan }}</p>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>Email</strong></label>
						<div class="col-sm-8">
							<p class="form-control-static">: {{ $user->email }}</p>
						</div>
					</div>			
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>No HP</strong></label>
						<div class="col-sm-8">
							<p class="form-control-static">: {{ $user->no_hp }}</p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>Username</strong></label>
						<div class="col-sm-8">
							<p class="form-control-static">: <code>{{ $user->username }}</code></p>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>Dibuat Tanggal</strong></label>
						<div class="col-sm-8">
							<p class="form-control-static">: {{ Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</p>
						</div>
					</div>	

				</div> <!-- /widget-content -->
				@if($user->role=='AA')
				<div class="clearfix"></div>
				<div class="divider"></div>
				<div class="widget-header" style="background:transparent">
					<h3 class="widget-title">Data Keagenan </h3>
				</div>
				<div class="widget-content pad20f">					
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>No Keagenan</strong></label>
						<div class="col-sm-8">
							<p class="form-control-static">: {{ $agen->no_agen }}</p>
						</div>
					</div>		
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>Wilayah Agensi</strong></label>
						<div class="col-sm-8">
							<p class="form-control-static">: {{ $agen->wilayah_agensi }} (code: {{ $agen->code_wilayah }})</p>
						</div>
					</div>					
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>No KTP</strong></label>
						<div class="col-sm-8">
							<p class="form-control-static">: {{ $agen->no_ktp }}</p>
						</div>
					</div>					
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>Alamat</strong></label>
						<div class="col-sm-8">
							<p class="form-control-static">: {{ $agen->alamat }}</p>
						</div>
					</div>				
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>Tempat, Tgl Lahir</strong></label>
						<div class="col-sm-8">
							<p class="form-control-static">: {{ $agen->tempat_lahir }}, {{ Carbon\Carbon::parse($agen->tgl_lahir)->format('d M Y') }}</p>
						</div>
					</div>						
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>Sertifikasi</strong></label>
						<div class="col-sm-8">
							<p class="form-control-static">: {{ $agen->sertifikasi }}</p>
						</div>
					</div>	
				</div>
				@endif
			</div> <!-- /widget -->
		</div> <!-- /fluid -->

	</div> <!-- /main -->
@endsection