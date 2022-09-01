@extends('layouts.app')

@section('content')	
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Laporan SPPSB &amp; SP3 KBG</h1>			
        <span class="secExtra">Rincian laporan SPPSB dan SP3 KBG yang telah diterbitkan berdasarkan periode waktu</span>
    </div> <!-- /SecInfo -->
    <div class="fluid">
        <div class="widget leftcontent grid12">				
            <div class="widget-content pad20f">	
                <form id="sppsbForm" class="form-horizontal" action="{{ url('/cetak-laporan-agen') }}" method="POST" target="_blank">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-2 col-sm-3 control-label"><strong>No Agen</strong></label>
                        <div class="col-sm-6">
                            <p class="form-control-static">{{ $agen->no_agen }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-sm-3 control-label"><strong>Nama Agen</strong></label>
                        <div class="col-sm-6">
                            <p class="form-control-static">{{ $agen->name }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-sm-3 control-label"><strong>Wilayah</strong></label>
                        <div class="col-sm-6">
                            <p class="form-control-static">{{ $agen->wilayah_agensi }} (Kode: {{ $agen->code_wilayah }})</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-xs-2 control-label"><strong>Periode Terbit</strong></label>
                        <div class="col-sm-6 col-xs-5">
                            <div class="input-group">
                                <input type="text" id="startDate" class="form-control" name="startDate" value="{{ old('startDate') }}" placeholder="dd-mm-yyyy">
                                <span class="input-group-addon">s/d</span>
                                <input type="text" id="expiredDate" class="form-control" name="endDate" value="{{ old('endDate') }}" placeholder="dd-mm-yyyy">
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-5 text-right">
                            <button id="searchAgen" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                            <button id="cetakAgen" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>
                        </div>
                    </div>
                </form>
                <hr/>
                <div class="table-responsive">
                    <table id="detail-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tgl</th>
                                <th>Nama</th>
                                <th>No Sertifikat</th>
                                <th>Service Charge</th>
                                <th>Gross IJP</th>
                                <th>Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- /fluid -->

</div> <!-- /main -->
@endsection
@push('scripts')  
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker3.min.css') }}" />

<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
if (($('#startDate').length) && ($('#expiredDate').length)) {
$('#startDate').datepicker({
format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
}).on('changeDate', function(e){
$('#expiredDate').datepicker('setStartDate', e.date);
});
$('#expiredDate').datepicker({
format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
}).on('changeDate', function(e){
$('#startDate').datepicker('setEndDate', e.date);
});
}
$("#detail-datatable").DataTable();
$('#searchAgen').on('click', function(){
var agenId = $('#selectAgen').val();
$("#detail-datatable").DataTable().destroy();
$("#detail-datatable").DataTable({
processing: true,
        serverSide: true,
        ajax: {
        url : '{{ url("/") }}/getdata-detail-agen/{id}/{startDate}/{endDate}',
                type : 'GET',
                data : {
                id : {{ Auth::user() - > id }},
                        startDate : $('#startDate').val(),
                        endDate : $('#expiredDate').val()
                }

        },
        columns: [
        { data: 'id',
                render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
                }, sClass:'text-center'
        },
        { data: 'created_at', name: 'created_at' },
        { data: 'nama_kontraktor', name: 'nama_kontraktor' },
        { data: 'no_jaminan', name: 'no_jaminan' },
        { data: 'bulat_ijp', name: 'bulat_ijp', sClass:'text-right' },
        { data: 'gross_ijp', name: 'gross_ijp', sClass:'text-right' },
        { data: 'fee_agen', name: 'fee_agen', sClass:'text-right' }
        ],
        aaSorting: []
});
})
});
</script>
@endpush