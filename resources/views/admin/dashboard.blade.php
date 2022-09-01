@extends('layouts.app')

@section('content')
<div id="main" class="clearfix">
	<div class="topTabs">
			
			<div id="topTabs-container-home">
				<div class="topTabs-header clearfix">

				<div class="secInfo sec-dashboard">
					<h1 class="secTitle">Dashboard</h1>
					<span class="secExtra">Selamat datang!</span>
				</div> <!-- /SecInfo -->
				
				<ul class="etabs tabs">
					<li class="tab">
						<a href="#tab1">
							<span class="to-hide">
								<i class="fa fa-percent"></i><br>Persentase Fee Agen
							</span>
							<i class="fa icon-hidden fa-percent ttip" data-ttip="Persentase Fee Agen"></i>
						</a>
					</li>
					<li class="tab">
						<a href="#tab2">
							<span class="to-hide">
								<i class="fa fa-bar-chart-o"></i><br>Rate IJP SPPSB
							</span>
							<i class="fa icon-hidden fa-bar-chart-o ttip" data-ttip="Rate IJP + Biaya Admin SPPSB"></i>
						</a>
					</li>
					<li class="tab">
						<a href="#tab3">
							<span class="to-hide">
								<i class="fa fa-bar-chart-o"></i><br>Rate IJP SP3KBG
							</span>
							<i class="fa icon-hidden fa-bar-chart-o ttip" data-ttip="Rate IJP + Biaya Admin SP3KBG"></i>
						</a>
					</li>
				</ul> <!-- /tabs -->
				</div><!-- /topTabs-header -->

				<div class="topTabsContent">
					<div id="tab1">
	                    <div class="widget content-tab grid12">
							<div class="alert alert-info" role="alert">
								<h4><i class="fa fa-info-circle"></i> Informasi!</h4>
								<ul style="padding-left: 20px !important;">
									<li>Silahkan lakukan perubahan nilai persentase fee SPPSB atau SP3 KBG untuk masing-masing agen</li>
									<li>Klik tombol <i class="fa fa-check"></i> setelah dilakukan perubahan fee dari agen yang dimaksud </li>
									<li>Perubahan hanya dapat dilakukan per agen</li>
								</ul>
							</div>
							@if(Session::has('msgupdate'))
	                        <div class="alert alert-success">
	                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                            <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
	                        </div>
		                    @endif
		                    <div id="resultInfo"></div>
							<table id="fee-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
							    <thead>
							        <tr>
							            <th>No Agen</th>
							            <th width="25%">Nama Agen</th>
							            <th>Wilayah Agensi</th>
							            <th>Fee SPPSB</th>
							            <th>Fee SP3 KBG</th>
							            <th>Action</th>
							        </tr>
							    </thead>
							    <tbody>
							    </tbody>
							</table>
						</div>
	                </div>
					<div id="tab2">	
						<form id="rateFormSppsb" class="form-horizontal">	
						{!! csrf_field() !!}
						<div class="widget content-tab grid12">
							<div class="alert alert-info" role="alert">
								<h4><i class="fa fa-info-circle"></i> Informasi!</h4>
								<ul style="padding-left: 20px !important;">
									<li>Silahkan lakukan perubahan nilai rate ijp</li>
									<li>Klik tombol <code>UPDATE</code> untuk melakukan proses update terhadap perubahan-perubahan nilai rate ijp atau min. biaya yang telah dilakukan</li>
								</ul>
							</div>
					    	<table id="ijp-sppsb-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
							    <thead>
							        <tr class="bg-success">
							            <th width="25%">Uraian</th>
							            <th>3 Bln</th>
							            <th>4 Bln</th>
							            <th>5 Bln</th>
							            <th>6 Bln</th>
							            <th>7 Bln</th>
							            <th>8 Bln</th>
							            <th>9 Bln</th>
							            <th>10 Bln</th>
							            <th>11 Bln</th>
							            <th>12 Bln</th>
							        </tr>
							    </thead>
							    <tbody>
							    	@foreach($rateSppsb as $key => $data)
							    	<tr>
							    		<td>Jaminan {{ $data->title }}
							    			<div class="input-group">
												<span class="input-group-addon">Min. Biaya</span>
												<input type="hidden" name="id[]" value="{{ $data->id }}">
												<input type="text" name="min_biaya[]" value="{{ $data->min_biaya }}" class="form-control text-right" placeholder="0">
											</div>
							    		</td>
							    		<td><input type="text" name="tiga[]" value="{{ $data->tiga }}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="empat[]" value="{{ $data->empat}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="lima[]" value="{{ $data->lima}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="enam[]" value="{{ $data->enam}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="tujuh[]" value="{{ $data->tujuh}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="delapan[]" value="{{ $data->delapan}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="sembilan[]" value="{{ $data->sembilan}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="sepuluh[]" value="{{ $data->sepuluh}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="sebelas[]" value="{{ $data->sebelas}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="duabelas[]" value="{{ $data->duabelas}}" class="text-right" size="4" /></td>
							    	</tr>
							    	@endforeach
							    </tbody>
							</table>
							<div class="widget-header">
								<h3 class="widget-title">Fee Admin &amp; Biaya Materai</h3>
							</div>
							<div class="widget-content pad20f">
								<div class="form-group">
									<label for="fee_admin" class="col-sm-3 control-label">Biaya Admin SPPSB<span class="text-danger">*</span></label>
									<div class="col-sm-5">
										<div class="input-group">
											<span class="input-group-addon">Rp.</span>
											<input type="text" name="fee_admin_sppsb" value="{{ $feeAdminSppsb->value }}" class="form-control text-right" id="fee_admin">
										</div>
									</div>
								</div>
								<!-- <div class="form-group">
									<label for="fee_admin" class="col-sm-3 control-label">Biaya Admin SP3 KBG<span class="text-danger">*</span></label>
									<div class="col-sm-5">
										<div class="input-group">
											<span class="input-group-addon">Rp.</span>
											<input type="text" name="fee_admin_sp3kbg" value="{{ $feeAdminSp3kbg->value }}" class="form-control text-right" id="fee_admin">
										</div>
									</div>
								</div> -->
								<div class="form-group">
									<label for="materai" class="col-sm-3 control-label">Biaya Materai <span class="text-danger">*</span></label>
									<div class="col-sm-5">
										<div class="input-group">
											<span class="input-group-addon">Rp.</span>
											<input type="text" name="materai_sppsb" value="{{ $materai->value }}" class="form-control text-right" id="materai">
										</div>
									</div>
								</div>
								<hr/>
								<div class="form-group">
									<div class="col-sm-12 text-center">
										<button id="proses" type="submit" class="btn"><i class="fa fa-save"></i> UPDATE</button>
									</div>
								</div>
								<hr/>
							</div>
					    </div>
					    </form>
					</div>
					<div id="tab3">	
						<form id="rateFormSp3kbg" class="form-horizontal">	
						{!! csrf_field() !!}
						<div class="widget content-tab grid12">
							<div class="alert alert-info" role="alert">
								<h4><i class="fa fa-info-circle"></i> Informasi!</h4>
								<ul style="padding-left: 20px !important;">
									<li>Silahkan lakukan perubahan nilai rate ijp</li>
									<li>Klik tombol <code>UPDATE</code> untuk melakukan proses update terhadap perubahan-perubahan nilai rate ijp atau min. biaya yang telah dilakukan</li>
								</ul>
							</div>
					    	<table id="ijp-sp3kbg-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
							    <thead>
							        <tr class="bg-success">
							            <th width="25%">Uraian</th>
							            <th>3 Bln</th>
							            <th>4 Bln</th>
							            <th>5 Bln</th>
							            <th>6 Bln</th>
							            <th>7 Bln</th>
							            <th>8 Bln</th>
							            <th>9 Bln</th>
							            <th>10 Bln</th>
							            <th>11 Bln</th>
							            <th>12 Bln</th>
							        </tr>
							    </thead>
							    <tbody>
							    	@foreach($rateSp3kbg as $key => $data)
							    	<tr>
							    		<td>Jaminan {{ $data->title }}
							    			<div class="input-group">
												<span class="input-group-addon">Min. Biaya</span>
												<input type="hidden" name="id[]" value="{{ $data->id }}">
												<input type="text" name="min_biaya[]" value="{{ $data->min_biaya }}" class="form-control text-right" placeholder="0">
											</div>
							    		</td>
							    		<td><input type="text" name="tiga[]" value="{{ $data->tiga }}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="empat[]" value="{{ $data->empat}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="lima[]" value="{{ $data->lima}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="enam[]" value="{{ $data->enam}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="tujuh[]" value="{{ $data->tujuh}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="delapan[]" value="{{ $data->delapan}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="sembilan[]" value="{{ $data->sembilan}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="sepuluh[]" value="{{ $data->sepuluh}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="sebelas[]" value="{{ $data->sebelas}}" class="text-right" size="4" /></td>
							    		<td><input type="text" name="duabelas[]" value="{{ $data->duabelas}}" class="text-right" size="4" /></td>
							    	</tr>
							    	@endforeach
							    </tbody>
							</table>
							<div class="widget-header">
								<h3 class="widget-title">Fee Admin &amp; Biaya Materai</h3>
							</div>
							<div class="widget-content pad20f">
								<div class="form-group">
									<label for="fee_admin" class="col-sm-3 control-label">Biaya Admin SPPSB<span class="text-danger">*</span></label>
									<div class="col-sm-5">
										<div class="input-group">
											<span class="input-group-addon">Rp.</span>
											<input type="text" name="fee_admin_sp3kbg" value="{{ $feeAdminSp3kbg->value }}" class="form-control text-right" id="fee_admin">
										</div>
									</div>
								</div>
								<!-- <div class="form-group">
									<label for="fee_admin" class="col-sm-3 control-label">Biaya Admin SP3 KBG<span class="text-danger">*</span></label>
									<div class="col-sm-5">
										<div class="input-group">
											<span class="input-group-addon">Rp.</span>
											<input type="text" name="fee_admin_sp3kbg" value="{{ $feeAdminSp3kbg->value }}" class="form-control text-right" id="fee_admin">
										</div>
									</div>
								</div> -->
								<div class="form-group">
									<label for="materai" class="col-sm-3 control-label">Biaya Materai <span class="text-danger">*</span></label>
									<div class="col-sm-5">
										<div class="input-group">
											<span class="input-group-addon">Rp.</span>
											<input type="text" name="materai_sp3kbg" value="{{ $materai->value }}" class="form-control text-right" id="materai">
										</div>
									</div>
								</div>
								<hr/>
								<div class="form-group">
									<div class="col-sm-12 text-center">
										<button id="proses" type="submit" class="btn"><i class="fa fa-save"></i> UPDATE</button>
									</div>
								</div>
								<hr/>
							</div>
					    </div>
					    </form>
					</div>
				</div> <!-- /topTabContent -->

			</div> <!-- /tab-container -->

		<!-- </div> -->
	</div> <!-- /topTabs -->	
</div> <!-- /main -->
@endsection
@push('scripts')
	<script>


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('[name="_token"]').val()
        }
    });
	$(document).ready(function() {
		$("#fee-datatable").DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '{{ url("/") }}/getdata-agen',
	        columns: [
	            { data: 'no_agen', name: 'no_agen'},
	            { data: 'name', name: 'name' },
	            { data: 'wilayah_agensi', name: 'wilayah_agensi',
	                render: function ( data, type, row ) {
	                    return data + ' (Kode: ' + row.code_wilayah + ')';
	                }
	            },
	            { data: 'fee_sppsb', name: 'fee_sppsb', sClass:'text-center',
	                render: function ( data, type, row ) {
	                    return '<div class="input-group">'
								+'<input type="text" name="fee_sppsb" class="form-control text-right" size="4" value="'+data+'">'
								+'<span class="input-group-addon">%</span></div>';
	                }
	            },
	            { data: 'fee_sp3kbg', name: 'fee_sp3kbg', sClass:'text-center',
	                render: function ( data, type, row ) {
	                    return '<div class="input-group">'
								+'<input type="text" name="fee_sp3kbg" class="form-control text-right" size="4" value="'+data+'">'
								+'<span class="input-group-addon">%</span></div>';
	                }
	            },
	            { data: 'action', name: 'action', sClass:'text-center', orderable: false, searchable: false }
	        ],
	        aaSorting: []
	    });		
	});
	$('#rateFormSppsb').on( "submit", function( event ) {
	  	$.ajax({
        	type: "POST",
           	url: "{{ url('/') }}/update-rate-ijp-sppsb",
           	data: $("#rateFormSppsb").serialize(),
            success: function(result) {
            	$('#ijp-sppsb-datatable').before('<div class="alert alert-success">'
	                            +'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
	                            +'<i class="fa fa-info-circle"></i> SUKSES! Anda sukses melakukan update rate ijp dan biaya admin</div>');
            },
            error:function(e){
            	$('#ijp-sppsb-datatable').before('<div class="alert alert-danger">'
	                            +'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
	                            +'<i class="fa fa-info-circle"></i> ERROR! proses update rate ijp gagal, silahkan refresh page/halaman dan ulangi</div>');
            }
       	});
       	$('html, body').animate({
            scrollTop: $("#tab2").offset().top
        }, 500);
		event.preventDefault();
	});
	$('#rateFormSp3kbg').on( "submit", function( event ) {
	  	$.ajax({
        	type: "POST",
           	url: "{{ url('/') }}/update-rate-ijp-sp3kbg",
           	data: $("#rateFormSp3kbg").serialize(),
            success: function(result) {
            	$('#ijp-sp3kbg-datatable').before('<div class="alert alert-success">'
	                            +'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
	                            +'<i class="fa fa-info-circle"></i> SUKSES! Anda sukses melakukan update rate ijp dan biaya admin</div>');
            },
            error:function(e){
            	$('#ijp-sp3kbg-datatable').before('<div class="alert alert-danger">'
	                            +'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
	                            +'<i class="fa fa-info-circle"></i> ERROR! proses update rate ijp gagal, silahkan refresh page/halaman dan ulangi</div>');
            }
       	});
       	$('html, body').animate({
            scrollTop: $("#tab3").offset().top
        }, 500);
		event.preventDefault();
	});
    function updateFee(elem, id){
    	var feeSppsb = $(elem).parents('tr').find('input[name="fee_sppsb"]').val();
    	var feeSp3kbg = $(elem).parents('tr').find('input[name="fee_sp3kbg"]').val();
    	$.ajax({
            dataType: "json",
            data: {id : id, fee_sppsb : feeSppsb, fee_sp3kbg : feeSp3kbg},
            type: 'POST',
            url: "{{ url('/update-fee-pengguna') }}",
            success: function(result) {
            	$('#resultInfo').html('<div class="alert alert-success">'
	                            +'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
	                            +'<i class="fa fa-info-circle"></i> SUKSES! Anda sukses melakukan update fee untuk agen '+result['agen'].no_agen+'</div>');
            },
            error:function(e){
            	$('#resultInfo').html('<div class="alert alert-danger">'
	                            +'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
	                            +'<i class="fa fa-info-circle"></i> ERROR! proses update fee gagal dilakukan, silahkan refresh page/halaman dan ulangi</div>');
            }
        });
    }
	</script>    
@endpush