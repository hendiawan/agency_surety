@extends('layouts.app')

@section('content')	
	<div id="main" class="clearfix">
		<div class="secInfo">
			<h1 class="secTitle">Edit Data Bank</h1>
			<span class="secExtra">Form editing data bank</span>
		</div> <!-- /SecInfo -->
		<div class="fluid">
			<div class="widget leftcontent grid12">
				<form id="bankForm" class="form-horizontal" method="POST" action="{{ url('/') }}/update-bank">
				{!! csrf_field() !!}
					<input type="hidden" id="user_id" name="id" value="{{ $bank->id }}">
					<div class="widget-content pad20f">
						<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-sm-3 control-label">Nama Bank <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="name" value="{{ old('name',$bank->name) }}" class="form-control" id="name">
								@if ($errors->has('name'))
                                    <code>{{ $errors->first('name') }}</code>
                                @endif
							</div>
						</div>
						<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
							<label for="address" class="col-sm-3 control-label">Alamat <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<textarea name="address" class="form-control" id="address">{{ old('address',$bank->address) }}</textarea>
								 @if ($errors->has('address'))
                                    <code>{{ $errors->first('address') }}</code>
                                @endif
							</div>
						</div>
						<div class="form-group {{ $errors->has('wilayah') ? ' has-error' : '' }}">
							<label class="col-sm-3 control-label">Kota/Kabupaten<span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<select name="wilayah" class="form-control">
									<option disabled selected>Silahkan pilih Kota/Kabupaten...</option>
									<optgroup label="KOTA">
										<option value="Kota Bima" @if (old('wilayah', $bank->wilayah)=='Kota Bima') selected @endif>Kota Bima</option>
										<option value="Kota Mataram" @if (old('wilayah', $bank->wilayah)=='Kota Mataram') selected @endif>Kota Mataram</option>
									</optgroup>
									<optgroup label="KABUPATEN">
										<option value="Bima" @if (old('wilayah', $bank->wilayah)=='Bima') selected @endif>Bima</option>
										<option value="Dompu" @if (old('wilayah', $bank->wilayah)=='Dompu') selected @endif>Dompu</option>
										<option value="Lombok Barat" @if (old('wilayah', $bank->wilayah)=='Lombok Barat') selected @endif>Lombok Barat</option>
										<option value="Lombok Tengah" @if (old('wilayah', $bank->wilayah)=='Lombok Tengah') selected @endif>Lombok Tengah</option>
										<option value="Lombok Timur" @if (old('wilayah', $bank->wilayah)=='Lombok Timur') selected @endif>Lombok Timur</option>
										<option value="Lombok Utara" @if (old('wilayah', $bank->wilayah)=='Lombok Utara') selected @endif>Lombok Utara</option>
										<option value="Sumbawa" @if (old('wilayah', $bank->wilayah)=='Sumbawa') selected @endif>Sumbawa</option>
										<option value="Sumbawa Barat" @if (old('wilayah', $bank->wilayah)=='Sumbawa Barat') selected @endif>Sumbawa Barat</option>
									</optgroup>
								</select>
								@if ($errors->has('wilayah'))
                                    <code>{{ $errors->first('wilayah') }}</code>
                                @endif
							</div>
						</div>
						<div class="form-group">
							<label for="phone" class="col-sm-3 control-label">Telepon </label>
							<div class="col-sm-9">
								<input type="text" name="phone" value="{{ old('phone',$bank->phone) }}" class="form-control" id="phone">
							</div>
						</div>
						<div class="form-group {{ $errors->has('no_rek') ? ' has-error' : '' }}">
							<label for="no_rek" class="col-sm-3 control-label">Nomor Rekening <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="no_rek" value="{{ old('no_rek',$bank->no_rek) }}" class="form-control" id="no_rek">
								@if ($errors->has('no_rek'))
                                    <code>{{ $errors->first('no_rek') }}</code>
                                @endif
							</div>
						</div>
						<div class="form-group {{ $errors->has('rate') ? ' has-error' : '' }}">
							<label for="rate" class="col-sm-3 control-label">Rate <span class="text-danger">*</span></label>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" name="rate" value="{{ old('rate',$bank->rate) }}" class="form-control text-right" id="rate">
									<span class="input-group-addon">%</span>
                                </div>
								@if ($errors->has('rate'))
                                    <code>{{ $errors->first('rate') }}</code>
                                @endif
                                <span class="help-block"><small>gunakan titik (.) untuk bilangan decimal</small></span>
							</div>
						</div>
					</div>
					<hr/>
					<div class="widget-content pad20f">
						<div class="form-group">
							<div class="col-sm-6">
								<a href="{{ url('/bank') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
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
<script>
$(document).ready(function() {

	$('#proses').on('click',function(){
		$(this).prop('disabled',true);
		$( "#bankForm" ).submit();
	})
});
</script>    
@endpush