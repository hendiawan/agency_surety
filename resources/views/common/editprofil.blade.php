@extends('layouts.app')

@section('content')	
	<div id="main" class="clearfix">
		<div class="secInfo">
			<h1 class="secTitle">Edit Profil Pengguna</h1>
			<span class="secExtra"></span>
		</div> <!-- /SecInfo -->
		<div class="fluid">
			<form id="sppsbForm" method="POST" action="{{ url('/') }}/update-profil-pengguna" enctype="multipart/form-data">
			{!! csrf_field() !!}
			<div class="widget leftcontent col-sm-4">
				<div class="widget-header" style="background:transparent">
					<h3 class="widget-title">Ganti Foto Profil</h3>
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
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="fileupload-preview thumbnail" data-trigger="fileupload" style="width: 200px; height: auto;">
							<img src="{{ asset('uploads/profil') }}/{{$user->foto}}" rel="user" />
						</div>
						<div>
							<span class="btn btn-default btn-file">
								<span class="fileupload-new">Select image</span>
								<span class="fileupload-exists">Change</span>
								<input type="file" name="foto">
							</span>
							<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
						</div>
					</div>
				</div> <!-- /widget-content -->

				<div class="divider"></div>

			</div> <!-- /widget -->
			<div class="widget col-sm-8 form-horizontal">
				<div class="widget-header" style="background:transparent">
					<h3 class="widget-title">Data Pengguna </h3>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="widget-content pad20f">
				
					<div class="form-group">
						<label id="name" class="col-sm-4 control-label"><strong>Nama Pengguna</strong></label>
						<div class="col-sm-8">
							<input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" id="name">
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
							<input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="form-control" id="no_hp">
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
							<input type="text" name="no_ktp" value="{{ old('no_ktp', $agen->no_ktp) }}" class="form-control" id="no_ktp">
						</div>
					</div>					
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>Alamat</strong></label>
						<div class="col-sm-8">
							<textarea class="form-control" name="alamat" id="alamat" rows="3">{{ old('alamat',$agen->alamat) }}</textarea>
						</div>
					</div>				
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>Tempat Lahir</strong></label>
						<div class="col-sm-8">
							<div class="input-group">
								<input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $agen->tempat_lahir) }}" class="form-control">
								<span class="input-group-addon">Tgl Lahir</span>
								<input id="tgl_lahir" type="text" name="tgl_lahir" value="{{ Carbon\Carbon::parse(old('tgl_lahir', $agen->tgl_lahir))->format('d-m-Y') }}" class="form-control">
							</div>
						</div>
					</div>						
					<div class="form-group">
						<label class="col-sm-4 control-label"><strong>Sertifikasi</strong></label>
						<div class="col-sm-8">
							<textarea class="form-control" name="sertifikasi" rows="3">{{ old('sertifikasi', $agen->sertifikasi) }}</textarea>
						</div>
					</div>	
				</div>
				@endif
			</div> <!-- /widget -->

			<div class="widget col-sm-12 form-horizontal">
				<div class="widget-content pad20f">
					<hr/>
					<div class="form-group">
						<div class="col-sm-6">
							<a href="{{ url('/home') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
						</div>
						<div class="col-sm-6 text-right">
							<button type="submit" class="btn"><i class="fa fa-save"></i> UPDATE</button>
						</div>
					</div>
					<hr/>
				</div>
			</div>
			</form>
		</div> <!-- /fluid -->

	</div> <!-- /main -->
@endsection
@push('scripts')
<link rel="stylesheet" href="{{ asset('/css/bootstrap-fileupload.css') }}" />
<script type="text/javascript" src="{{ asset('/js/bootstrap-fileupload.js') }}"></script>
@if($user->role=='AA')
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker3.min.css') }}" />
<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#tgl_lahir').datepicker({
	        format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
	});
</script>
@endif
@endpush