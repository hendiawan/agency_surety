@extends('layouts.app')

@section('content')	
	<div id="main" class="clearfix">
		<div class="secInfo">
			<h1 class="secTitle">Tambah Pengguna</h1>
			<span class="secExtra">Form untuk menambahkan data pengguna</span>
		</div> <!-- /SecInfo -->
		<div class="fluid">
			<div class="widget leftcontent grid12">
				<form id="penggunaForm" class="form-horizontal" method="POST" action="{{ url('/') }}/tambah-pengguna">
				{!! csrf_field() !!}
					<div class="widget-content pad20f">
						<div class="form-group {{ $errors->has('jabatan') ? ' has-error' : '' }}">
							<label class="col-sm-3 control-label">Jabatan <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-blue btn-default @if (old('jabatan')=='Staff') active @endif">
										<input type="radio" name="jabatan" value="Staff" @if (old('jabatan')=='Staff') checked @endif autocomplete="off">
										Staff Surety Bond
									</label>
									<label class="btn btn-orange btn-default @if (old('jabatan')=='Agen') active @endif">
										<input type="radio" name="jabatan" value="Agen" @if (old('jabatan')=='Agen') checked @endif autocomplete="off">
										Agen Surety Bond
									</label>
								</div>
								<span class="help-block"><small>silahkan klik salah satu tab untuk memilih (tab terpilih akan berubah warna menjadi abu-abu)</small></span>
							</div>
						</div>
						<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-sm-3 control-label">Nama Lengkap <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="name" value="{{ old('name') }}" class="form-control" id="name">
								@if ($errors->has('name'))
                                    <code>{{ $errors->first('name') }}</code>
                                @endif
							</div>
						</div>
						<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="email" class="col-sm-3 control-label">Email <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email">
								 @if ($errors->has('email'))
                                    <code>{{ $errors->first('email') }}</code>
                                @endif
							</div>
						</div>
						<div class="form-group">
							<label for="no_hp" class="col-sm-3 control-label">No HP </label>
							<div class="col-sm-9">
								<input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control" id="no_hp">
							</div>
						</div>
						<div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
							<label for="username" class="col-sm-3 control-label">Username <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="username" value="{{ old('username') }}" class="form-control" id="username">
								@if ($errors->has('username'))
                                    <code>{{ $errors->first('username') }}</code>
                                @endif
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Password <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<p class="form-control-static text-danger">password123</p>
								<span class="help-block"><small>password default dari pengguna</small></span>
							</div>
						</div>
					</div>
					<div id="dataAgen" class="@if (old('jabatan')!='Agen') hide @endif">
						<div class="widget-header">
							<h3 class="widget-title">DATA AGEN</h3>
						</div>
						<div class="widget-content pad20f">									
							<div class="form-group {{ $errors->has('no_agen') ? ' has-error' : '' }}">
								<label for="no_agen" class="col-sm-3 control-label">No Agen <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input type="text" name="no_agen" value="{{ old('no_agen') }}" class="form-control" id="no_agen">
									@if ($errors->has('no_agen'))
	                                    <code>{{ $errors->first('no_agen') }}</code>
	                                @endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('max_no_reg') ? ' has-error' : '' }}">
								<label class="col-sm-3 control-label">No Registrasi <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<div class="input-group">
										<input type="text" name="min_no_reg" value="{{ old('min_no_reg') }}" class="form-control text-right" placeholder="nilai minimal">
										<span class="input-group-addon">s/d</span>
										<input type="text" name="max_no_reg" value="{{ old('max_no_reg') }}" class="form-control text-right" placeholder="nilai maximal">
									</div>
									@if ($errors->has('max_no_reg'))
	                                    <code>{{ $errors->first('max_no_reg') }}</code>
	                                @endif
									<span class="help-block"><small>pastikan nilai maximal lebih dari atau sama dengan nilai minimal</small></span>
								</div>
							</div>									
							<div class="form-group {{ $errors->has('wilayah_agensi') ? ' has-error' : '' }}">
								<label class="col-sm-3 control-label">Wilayah Agensi <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<select name="wilayah_agensi" class="form-control">
										<option disabled selected>Silahkan pilih Wilayah Agensi...</option>
										<optgroup label="KOTA">
											<option value="KBM">KBM - Kota Bima</option>
											<option value="MTR">MTR - Kota Mataram</option>
										</optgroup>
										<optgroup label="KABUPATEN">
											<option value="BM">BM - Bima</option>
											<option value="DM">DM - Dompu</option>
											<option value="LB">LB - Lombok Barat</option>
											<option value="LTH">LTH - Lombok Tengah</option>
											<option value="LT">LTT - Lombok Timur</option>
											<option value="LU">LU - Lombok Utara</option>
											<option value="SB">SB - Sumbawa</option>
											<option value="SBB">SBB - Sumbawa Barat</option>
										</optgroup>
									</select>
									@if ($errors->has('wilayah_agensi'))
	                                    <code>{{ $errors->first('wilayah_agensi') }}</code>
	                                @endif
								</div>
							</div>						
							<div class="form-group {{ $errors->has('no_ktp') ? ' has-error' : '' }}">
								<label for="no_ktp" class="col-sm-3 control-label">No KTP <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input type="text" name="no_ktp" value="{{ old('no_ktp') }}" class="form-control" id="no_ktp">
									@if ($errors->has('no_ktp'))
	                                    <code>{{ $errors->first('no_ktp') }}</code>
	                                @endif
								</div>
							</div>					
							<div class="form-group">
								<label for="alamat" class="col-sm-3 control-label">Alamat </label>
								<div class="col-sm-9">
									<input type="text" name="alamat" value="{{ old('alamat') }}" class="form-control" id="alamat">
								</div>
							</div>					
							<div class="form-group">
								<label class="col-sm-3 control-label">Tempat Lahir </label>
								<div class="col-sm-9">
									<div class="input-group">
										<input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-control">
										<span class="input-group-addon">Tgl Lahir</span>
										<input id="tgl_lahir" type="text" name="tgl_lahir" value="{{ old('tgl_lahir') }}" class="form-control">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>					
							<div class="form-group">
								<label class="col-sm-3 control-label">Sertifikasi</label>
								<div class="col-sm-9">
									<textarea class="form-control" name="sertifikasi" rows="3">{{ old('sertifikasi') }}</textarea>
								</div>
							</div>	
						</div>
					</div>
					<hr/>
					<div class="widget-content pad20f">
						<div class="form-group">
							<div class="col-sm-6">
								<a href="{{ url('/home') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
							</div>
							<div class="col-sm-6 text-right">
								<button id="proses" type="button" class="btn"><i class="fa fa-save"></i> PROSES</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div> <!-- /fluid -->

	</div> <!-- /main -->
@endsection
@push('scripts')
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker3.min.css') }}" />
<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
	<script>
	$(document).ready(function() {

		$('#tgl_lahir').datepicker({
	        format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
		$('input:radio[name=jabatan]').change(function(){	
			if(this.value=='Agen')			
				$('#dataAgen').removeClass('hide');
			else
				$('#dataAgen').addClass('hide');
		});
		$('#proses').on('click',function(){
			$(this).prop('disabled',true);
			$( "#penggunaForm" ).submit();
		})
	});
	</script>    
@endpush