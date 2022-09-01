@extends('layouts.app')

@section('content')	
	<div id="main" class="clearfix">
		<div class="secInfo">
			<h1 class="secTitle">Edit Pengguna</h1>
			<span class="secExtra">Form untuk melakukan perubahan data pengguna</span>
		</div> <!-- /SecInfo -->
		<div class="fluid">
			<div class="widget leftcontent grid12">
				<form id="penggunaForm" class="form-horizontal" method="POST" action="{{ url('/') }}/update-pengguna">
				{!! csrf_field() !!}
					<input type="hidden" id="user_id" name="id" value="{{ $user->id }}">
					<input type="hidden" name="jabatan" value="{{ $user->jabatan }}">
					<div class="widget-content pad20f">
						<div class="form-group {{ $errors->has('jabatan') ? ' has-error' : '' }}">
							<label class="col-sm-3 control-label">Jabatan <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<p class="form-control-static text-danger">{{$user->jabatan}}</p>
							</div>
						</div>
						<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-sm-3 control-label">Nama Lengkap <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" id="name">
								@if ($errors->has('name'))
                                    <code>{{ $errors->first('name') }}</code>
                                @endif
							</div>
						</div>
						<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="email" class="col-sm-3 control-label">Email <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" disabled="disabled">
								 @if ($errors->has('email'))
                                    <code>{{ $errors->first('email') }}</code>
                                @endif
							</div>
						</div>
						<div class="form-group">
							<label for="no_hp" class="col-sm-3 control-label">No HP </label>
							<div class="col-sm-9">
								<input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="form-control" id="no_hp">
							</div>
						</div>
						<div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
							<label for="username" class="col-sm-3 control-label">Username <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" disabled="disabled">
								@if ($errors->has('username'))
                                    <code>{{ $errors->first('username') }}</code>
                                @endif
							</div>
						</div>
					</div>
					@if($user->jabatan=='Agen')
					<div id="dataAgen" class="@if (old('jabatan', $user->jabatan)!='Agen') hide @endif">
						<div class="widget-header">
							<h3 class="widget-title">DATA AGEN</h3>
						</div>
						<div class="widget-content pad20f">									
							<div class="form-group {{ $errors->has('no_agen') ? ' has-error' : '' }}">
								<label for="no_agen" class="col-sm-3 control-label">No Agen <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input type="text" name="no_agen" value="{{ old('no_agen', $agen->no_agen) }}" class="form-control" disabled="disabled">
									@if ($errors->has('no_agen'))
	                                    <code>{{ $errors->first('no_agen') }}</code>
	                                @endif
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-3 control-label">No Registrasi </label>
								<div class="col-sm-9">
									<div class="input-group">
										<input type="text" name="min_no_reg" value="{{ old('min_no_reg', $agen->min_no_reg) }}" class="form-control text-right">
										<span class="input-group-addon">s/d</span>
										<input type="text" name="max_no_reg" value="{{ old('max_no_reg', $agen->max_no_reg) }}" class="form-control text-right">
									</div>
									<span class="help-block"><small>pastikan nilai maximal lebih dari atau sama dengan nilai minimal</small></span>
								</div>
							</div>									
							<div class="form-group {{ $errors->has('wilayah_agensi') ? ' has-error' : '' }}">
								<label class="col-sm-3 control-label">Wilayah Agensi <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<select name="wilayah_agensi" class="form-control">
										<option disabled selected>Silahkan pilih Wilayah Agensi...</option>
										<optgroup label="KOTA">
											<option value="KBM" @if (old('wilayah-agensi', $agen->code_wilayah)=='KBM') selected @endif>KBM - Kota Bima</option>
											<option value="MTR" @if (old('wilayah-agensi', $agen->code_wilayah)=='MTR') selected @endif>MTR - Kota Mataram</option>
										</optgroup>
										<optgroup label="KABUPATEN">
											<option value="BM" @if (old('wilayah-agensi', $agen->code_wilayah)=='BM') selected @endif>BM - Bima</option>
											<option value="DM" @if (old('wilayah-agensi', $agen->code_wilayah)=='DM') selected @endif>DM - Dompu</option>
											<option value="LB" @if (old('wilayah-agensi', $agen->code_wilayah)=='LB') selected @endif>LB - Lombok Barat</option>
											<option value="LTH" @if (old('wilayah-agensi', $agen->code_wilayah)=='LTH') selected @endif>LTH - Lombok Tengah</option>
											<option value="LT" @if (old('wilayah-agensi', $agen->code_wilayah)=='LT') selected @endif>LTT - Lombok Timur</option>
											<option value="LU" @if (old('wilayah-agensi', $agen->code_wilayah)=='LU') selected @endif>LU - Lombok Utara</option>
											<option value="SB" @if (old('wilayah-agensi', $agen->code_wilayah)=='SB') selected @endif>SB - Sumbawa</option>
											<option value="SBB" @if (old('wilayah-agensi', $agen->code_wilayah)=='SBB') selected @endif>SBB - Sumbawa Barat</option>
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
									<input type="text" name="no_ktp" value="{{ old('no_ktp', $agen->no_ktp) }}" class="form-control" id="no_ktp">
									@if ($errors->has('no_ktp'))
	                                    <code>{{ $errors->first('no_ktp') }}</code>
	                                @endif
								</div>
							</div>					
							<div class="form-group">
								<label for="alamat" class="col-sm-3 control-label">Alamat </label>
								<div class="col-sm-9">
									<input type="text" name="alamat" value="{{ old('alamat', $agen->alamat) }}" class="form-control" id="alamat">
								</div>
							</div>					
							<div class="form-group">
								<label class="col-sm-3 control-label">Tempat Lahir </label>
								<div class="col-sm-9">
									<div class="input-group">
										<input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $agen->tempat_lahir) }}" class="form-control">
										<span class="input-group-addon">Tgl Lahir</span>
										<input id="tgl_lahir" type="text" name="tgl_lahir" value="{{ Carbon\Carbon::parse(old('tgl_lahir', $agen->tgl_lahir))->format('d-m-Y') }}" class="form-control">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>					
							<div class="form-group">
								<label class="col-sm-3 control-label">Sertifikasi</label>
								<div class="col-sm-9">
									<textarea class="form-control" name="sertifikasi" rows="3">{{ old('sertifikasi', $agen->sertifikasi) }}</textarea>
								</div>
							</div>	
						</div>
					</div>
					@endif
					<hr/>
					<div class="widget-content pad20f">
						<div class="form-group">
							<div class="col-sm-6">
								<a href="{{ url('/manajemen-pengguna') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
							</div>
							<div class="col-sm-6 text-right">
								<button id="proses" type="button" class="btn"><i class="fa fa-save"></i> UPDATE</button>
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