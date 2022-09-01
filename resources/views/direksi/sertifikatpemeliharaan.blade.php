@extends('layouts.app')

@section('content')	
	<div id="main" class="clearfix">
		<div class="secInfo">
			<h1 class="secTitle">Draft Sertifikat Surety Bond</h1>
			<span class="secExtra"></span>
		</div> <!-- /SecInfo -->
		<div class="fluid form-horizontal">
			<div class="widget-content pad20f">
				@if(Auth::check())
				@can('staff-access')
				<form id="sppsbPenomoran" class="form-horizontal" method="POST" action="{{ url('/') }}/sppsb-penomoran">
				{!! csrf_field() !!}
				<input type="hidden" id="id" name="id" value="{{ $sppsb->id }}">
				<div class="alert alert-info" role="alert">
					<strong><i class="fa fa-info-circle"></i> Informasi!</strong> Silahkan menginputkan nomor jaminan SPPSB sebelum di kembalikan ke agen untuk dicetak
				</div>
				<hr/>
				<div class="form-group">
					<h4 class="text-center"><strong>JAMINAN PEMELIHARAAN</strong></h4>
				</div>
				<div class="form-group">
					<div class="col-xs-6">
						<div class="input-group">
      						<div class="input-group-addon">Nomor: </div>
							<input type="text" name="no_jaminan" class="form-control" required>
						</div>
					</div>
					<div class="col-xs-6 text-right"><strong>Nilai Jaminan Rp.<span class="numeric">{{ $sppsb->nilai_jaminan }}</span></strong></div>
				</div>				
				@endcan
				@can('direksi-access')
				<div class="form-group">
					<h4 class="text-center"><strong>JAMINAN PEMELIHARAAN</strong></h4>
				</div>
				<div class="form-group">
					<div class="col-xs-6"><strong>Nomor : </strong></div>
					<div class="col-xs-6 text-right"><strong>Nilai Jaminan Rp.<span class="numeric">{{ $sppsb->nilai_jaminan }}</span></strong></div>
				</div>
				@endcan
				@endif
				<div class="form-group">
					<div class="col-sm-12">
						<ol class="sertifikat-list">
							<li class="text-justify">Dengan ini dinyatakan bahwa kami <span class="text-uppercase"><strong>{{ $sppsb->nama_kontraktor }}</strong></span>
								{{ $sppsb->alamat_kontraktor }} sebagai PENYEDIA, selanjutnya disebut <strong>TERJAMIN</strong> dan 
								<strong>PT. JAMKRIDA NTB BERSAING Jl. Langko No. 63, Mataram</strong> sebagai <strong>PENJAMIN</strong>, selanjutnya disebut 
								<strong>PENJAMIN</strong>, bertanggung jawab dan dengan tegas terikat pada <span class="text-uppercase"><strong>{{ $sppsb->jabatan_pejabat }} {{ $sppsb->pemilik_proyek }}</strong></span> 
								sebagai <strong>PEMILIK PEKERJAAN</strong>, selanjutnya disebut sebagai <strong>PENERIMA JAMINAN</strong> atas
								uang sejumlah Rp <span class="numeric">{{ $sppsb->nilai_jaminan }}</span> ({{ $nilaiJaminan }} Rupiah ).
							</li>
							<li class="text-justify">Maka kami, <strong>TERJAMIN</strong> dan <strong>PENJAMIN</strong> dengan ini mengikatkan diri 
								untuk melakukan pembayaran jumlah tersebut di atas dengan baik dan benar, bilamana <strong>TERJAMIN</strong> tidak 
								memenuhi kewajibannya dalam masa pemeliharaan <strong>PEKERJAAN : {{ $sppsb->jenis_pekerjaan }}</strong> yang dilakukan atas dasar <strong>{{ $sppsb->nama_dokumen }}</strong> dari
								<strong>PENERIMA JAMINAN</strong> Nomor : <strong>{{ $sppsb->no_dokumen }}</strong> tanggal {{ tgl_indo($sppsb->tgl_dokumen) }}.
							</li>
							<li class="text-justify">Surat jaminan ini berlaku selama {{ $sppsb->durasi }} ({{$selisih}} ) hari kalender dan efektif mulai tanggal {{ tgl_indo($sppsb->waktu_mulai) }} sampai dengan
								tanggal {{ tgl_indo($sppsb->waktu_selesai) }}.							
							</li>
							<li class="text-justify">Jaminan ini berlaku apabila <strong>TERJAMIN</strong> tidak memenuhi kewajibannya melakukan pemeliharaan atau
								perbaikan atas pekerjaan yang telah dilakukannya berdasarkan dokumen Kontrak.
							</li>
							<li class="text-justify"><strong>PENJAMIN</strong> akan membayar kepada <strong>PENERIMA JAMINAN</strong> sejumlah nilai jaminan tersebut di atas dalam
								waktu paling lambat 14 ( Empat Belas ) hari kerja tanpa syarat (unconditional) setelah menerima tuntutan
								pencairan secara tertulis dari <strong>PENERIMA JAMINAN</strong> berdasarkan keputusan PENERIMA JAMINAN mengenai
								pengenaan sanksi akibat <strong>TERJAMIN</strong> cidera janji/wan prestasi.
							</li>
							<li class="text-justify">Menunjuk pasal 1832 KUH Perdata, dengan ini ditegaskan kembali bahwa <strong>PENJAMIN</strong> melepaskan hak-hak
								istimewanya untuk menuntut supaya harta benda <strong>TERJAMIN</strong> lebih dahulu disita dan dijual guna melunasi
								hutang-hutangnya sebagaimana dimaksud dalam pasal 1831 KUH Perdata.
							</li>
							<li class="text-justify">Tuntutan pencairan terhadap <strong>TERJAMIN</strong> berdasarkan jaminan ini harus sudah diajukan selambat-lambatnya
								dalam waktu 7 ( Tujuh ) hari kalender sesudah berakhirnya masa laku jaminan ini.
							</li>
						</ol>	
					</div>
				</div>
				@if(Auth::check())
				@can('staff-access')
				<div class="form-group">
					<div class="col-sm-12">Dikeluarkan di Mataram pada tanggal {{ tgl_indo($sppsb->tgl_cetak) }}</div>
				</div>
				<div class="form-group">
					<div class="col-xs-5 text-center text-uppercase">
						<strong>{{ $sppsb->nama_kontraktor }}<br/>TERJAMIN</strong>
						<div class="signed-box">
							<span class="text-uppercase"><strong>{{ $sppsb->direksi }}</strong></span>
						</div>
					</div>
					<div class="col-xs-5 col-xs-offset-2 text-center">
						<strong>PT. JAMKRIDA NTB BERSAING<br/>PENJAMIN</strong>
						<div class="signed-box">
							<div id="current-signature"><img src="{{ $result->ttd }}" /></div>
							<span class="text-uppercase"><strong>Indra Manthica</strong></span>
						</div>
						Direktur
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">Service Charges Rp <span class="numeric">{{ $result->service_charge }}</span></div>
				</div>
				<hr/>
				<div class="form-group">
					<div class="col-sm-6">
						<a href="" id="template" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
					</div>
					<div class="col-sm-6 text-right">
						<button id="prosesClose" type="submit" class="btn btn-blue"><i class="fa fa-save"></i> PROSES</button>
					</div>
				</div>
				</form>
				@endcan
				@can('direksi-access')						
				<div class="form-group">
					<div class="col-sm-12">Dikeluarkan di Mataram pada tanggal {{ tgl_indo($sppsb->tgl_cetak) }}</div>
				</div>
				<div class="form-group">
					<div class="col-xs-5 text-center text-uppercase">
						<strong>{{ $sppsb->nama_kontraktor }}<br/>TERJAMIN</strong>
						<div class="signed-box">
							<span class="text-uppercase"><strong>{{ $sppsb->direksi }}</strong></span>
						</div>
						{{ $sppsb->jabatan_direksi }}
					</div>
					<div class="col-xs-5 col-xs-offset-2 text-center">
						<strong>PT. JAMKRIDA NTB BERSAING<br/>PENJAMIN</strong>
						<div class="signed-box">
							<div id="current-signature"></div>
							<span class="text-uppercase"><strong>Indra Manthica</strong></span>
						</div>
						Direktur Utama
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">Service Charges Rp <span class="numeric">{{ $charge }}</span></div>
				</div>
                                
                                <hr/>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <h4 class="text-center"><strong>ANALISA STAFF SURETY BOND</strong></h4>
                                        
                                    </div>
                                   <div class="col-xs-6"><strong>{{$sppsb->remark}}</strong></div>
                                     
                                </div> 
                                
                                
				<hr/>
				<div class="form-group">
<!--					<div class="col-sm-12">
					<button id="template" type="button" class="btn btn-turquoise"><i class="fa fa-folder"></i> Gunakan TTD Template</button>
					<span class="pull-right">
						<button type="button" class="btn btn-blue" data-toggle="modal" data-target="#modalSignature"><i class="fa fa-pencil"></i> Gunakan TTD Baru</button>
					</span>
					</div>-->
				</div>
				<hr/>
				<div class="form-group">
					<form id="sppsbForm" class="form-horizontal" method="POST" action="{{ url('/') }}/sppsb-direksi-update">
					{!! csrf_field() !!}
						<input type="hidden" id="id" name="id" value="{{ $sppsb->id }}">
						<input type="hidden" id="no_registrasi" name="no_registrasi" value="{{ $sppsb->no_registrasi }}">
						<input type="hidden" id="sppsb_status" name="status" value="{{ $sppsb->status }}">
						<input type="hidden" id="charge" name="charge" value="{{ $charge }}">
						<input type="hidden" id="ttd" name="ttd" value="">
						<input type="hidden" id="ttd_type" name="ttd_type" value="">

						<div class="col-sm-6">
							<a id="back" href="{{ url('/home') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
						</div>
						<div class="col-sm-6 text-right">
							<button id="tolak" type="button" class="btn btn-red"><i class="fa fa-folder"></i> TOLAK</button>
							<button id="revisi" type="button" class="btn btn-yellow"><i class="fa fa-edit"></i> REVISI</button>
							<button id="proses" type="button" class="btn"><i class="fa fa-check"></i> PROSES</button>
						</div>
						<!-- MODAL TOLAK -->
						<div class="modal fade remark-modal-md" role="dialog" aria-labelledby="mySmallModalLabel">
						    <div class="modal-dialog" role="document">
						        <div class="panel panel-info">
						            <div class="panel-heading">
						                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						                <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-edit"></i> Catatan</h4>
						            </div>
						            <div class="panel-body">
						            	<div class="form-group">
						            		<div class="col-md-12">
						            			<textarea class="form-control" name="remark" required></textarea>
						            			<span class="help-block"><small>silahkan inputkan alasan penolakan/revisi dari SPPSB yang di maksud</small></span>
						            		</div>
						            	</div>
						            </div>
						            <div class="panel-footer text-center">
						                <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Keluar</button>
						                <button id="prosesRevisiTolak" type="submit" class="btn btn-blue"><i class="fa fa-save"></i> Proses</button>
						            </div>
						        </div>
						    </div>
						</div>
                                                
                                                <div class="modal fade modal-md analisa-direksi" role="dialog" aria-labelledby="mySmallModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="panel panel-success">
                                                    <div class="panel-heading">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-edit"></i> Analisa/Tanggapan Direksi</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <textarea id="remark" class="form-control" name="remark" required></textarea>
                                                                <span class="help-block"><small>silahkan inputkan Analisa/Tanggapan Anda </small></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer text-center">
                                                        <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Keluar</button>
                                                        <button id="analisa" type="submit" class="btn btn-blue"><i class="fa fa-save"></i> Proses</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
					</form>	
				</div>
				@endcan
				@endif
			</div>
		</div> <!-- /fluid -->

	</div> <!-- /main -->

	<!-- MODAL SIGNATURE -->
	<div id="modalSignature" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel">
	    <div class="modal-dialog" role="document">

	        <div id="signature-pad" class="m-signature-pad" style="margin:0 auto;">
			    <div class="m-signature-pad--body">
			    	<canvas></canvas>
			    </div>
			    <div class="m-signature-pad--footer">
					<div class="description">Sign above</div>
					<div class="left">
						<button type="button" class="btn btn-red clear" data-action="clear"><i class="fa fa-eraser"></i> hapus</button>
					</div>
					<div class="right">
						<button type="button" class="btn save" data-action="save-png"><i class="fa fa-save"></i> simpan</button>
					</div>
			    </div>
			</div>

	    </div>
	</div>

@endsection
@if(Auth::check())
@can('staff-access')
@push('scripts')
<script>
	$(document).ready(function() {
		$("#sppsbPenomoran").submit(function (e){
			$('#prosesClose').prop('disabled',true);
			$('#customLoad').show();
		});
	})
</script>
@endpush
@endcan
@can('direksi-access')
@push('scripts')
<link rel="stylesheet" href="{{ asset('/css/signature-pad.css') }}" />

<script type="text/javascript" src="{{ asset('/js/signature_pad.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/app_signature.js') }}"></script>

<script>
	$(document).ready(function() {
		var canvas = document.getElementsByTagName('canvas')[0];
		canvas.width  = 456;
		canvas.height = 294;

		$('#template').on('click',function(){
			$('#current-signature').html('<img src="{{ $ttd->value }}"/>');
			$('#ttd_type').val('1');
		});

		$('#tolak').on('click',function(){
			$('#sppsb_status').val('T');
			$('.remark-modal-md').modal('show');
		});

		$('#revisi').on('click',function(){
			$('#sppsb_status').val('R');
			$('.remark-modal-md').modal('show');
		});

		$('#proses').on('click',function(){
			var img = $('#current-signature img').attr('src');
			$(this).prop('disabled',true);				
			if(img == undefined){
				//$('.formcheck-modal-sm .panel-body').html('Anda belum membubuhkan tanda tangan');
				//$('.formcheck-modal-sm').modal('show');
				$('#ttd').val('');				
			}else{
				$('#ttd').val(img);
			}
			$('#sppsb_status').val('C');
                        $('.analisa-direksi').modal('show');
		        $('#analisa').on('click', function () {
                                    $(this).prop('disabled', true);
                                    $('#customLoad').show();
                                    $( "#sppsbForm" ).submit();
                        });
		});		
		$("#sppsbForm").submit(function (e){
			$('#prosesRevisiTolak').prop('disabled',true);
			$('#customLoad').show();
		});
	})
</script>  
@endpush
@endcan
@endif  