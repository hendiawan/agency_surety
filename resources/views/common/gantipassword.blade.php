@extends('layouts.app')

@section('content')	
	<div id="main" class="clearfix">
		<div class="secInfo">
			<h1 class="secTitle">Ganti Password Pengguna</h1>
			<span class="secExtra"></span>
		</div> <!-- /SecInfo -->
		<div class="fluid">
			<div class="widget leftcontent grid12">
			<form id="sppsbForm" class="form-horizontal" method="POST" action="{{ url('/') }}/ganti-password" enctype="multipart/form-data">
			{!! csrf_field() !!}
				<div class="widget-content pad20f">
					<blockquote>
						<p>Untuk alasan keamanan, silahkan update password default anda dengan mengisi form update password berikut.</p>
					</blockquote>
					@if(Session::has('msgupdate'))
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
                        </div>
                    @endif
                    @if(Session::has('msgalert'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-warning"></i> {{ Session::get('msgalert') }}
                        </div>
                    @endif
					<div class="form-group {{ $errors->has('current_password') ? ' has-error' : '' }}">
						<label for="current_password" class="col-sm-3 control-label">Password Sekarang<span class="text-danger">*</span></label>
						<div class="col-sm-6">
							<input type="password" name="current_password" value="" class="form-control" id="current_password">
						</div>
					</div>
					<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
						<label for="password" class="col-sm-3 control-label">Password Baru<span class="text-danger">*</span></label>
						<div class="col-sm-6">
							<input type="password" name="password" value="" class="form-control" id="password">
						</div>
					</div>
					<div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
						<label for="password_confirmation" class="col-sm-3 control-label">Ulangi Password Baru<span class="text-danger">*</span></label>
						<div class="col-sm-6">
							<input type="password" name="password_confirmation" value="" class="form-control" id="password_confirmation">
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<div class="col-sm-6">
							<a href="{{ url('/home') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
						</div>
						<div class="col-sm-6 text-right">
							<button id="proses" type="submit" class="btn"><i class="fa fa-save"></i> UPDATE PASSWORD</button>
						</div>
					</div>
				</div>
			</form>
			</div>
		</div> <!-- /fluid -->

	</div> <!-- /main -->
@endsection