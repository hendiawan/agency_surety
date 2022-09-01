@extends('layouts.app')

@section('content')
<div id="main" class="clearfix">
	<div class="secInfo">
		<h1 class="secTitle">Data Bank</h1>
		<span class="secExtra">List data bank</span>
	</div> <!-- /SecInfo -->
	<div class="fluid">
	    <div class="widget leftcontent grid12">
	    	<div class="widget-header">
				<div class="icon-grp" style="padding-top:10px;">
					<a href="/tambah-bank" class="btn btn-blue">
						<i class="fa fa-plus-circle"></i> Tambah Bank
					</a>
				</div>
			</div>
			<div class="widget-content pad20f">	
				@if(Session::has('msgupdate'))
		        <div class="alert alert-success">
		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		            <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
		        </div>
		        @endif
				<table id="bank-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
				    <thead>
				        <tr>
				            <th>Nama Bank</th>
				            <th>Alamat</th>
				            <th>Kota/Kabupaten</th>
				            <th>No Rekening</th>
				            <th>Rate (%)</th>
				            <th>Aksi</th>
				        </tr>
				    </thead>
				    <tbody>
				    </tbody>
				</table>
			</div>
		</div>	
	</div>
</div> <!-- /main -->
@endsection
@push('scripts')
<script>
$(document).ready(function() {

  $("#bank-datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url("/") }}/getdata-bank-tablelist',
        columns: [
            { data: 'name', name: 'name'},
            { data: 'address', name: 'address',
            	render: function ( data, type, row ) {
                	return data+'<div class="secExtra"><i class="fa fa-phone-square"></i> Telp. <strong>'+row.phone+'<strong></div>';
                }
            },
            { data: 'wilayah', name: 'wilayah'},
            { data: 'no_rek', name: 'no_rek'},
            { data: 'rate', name: 'rate'},
            { data: 'action', name: 'action', sClass:'text-center', orderable: false, searchable: false }
        ],
        aaSorting: []
    });
});
</script>    
@endpush