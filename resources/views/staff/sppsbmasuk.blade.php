@extends('layouts.app')

@section('content')	
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Data SPPSB Masuk</h1>
        <span class="secExtra">Tabel daftar seluruh Surat Permohonan Penerbitan Surety Bond (SPPSB) baru dari agen ataupun yang telah disetujui oleh direksi</span>
    </div> <!-- /SecInfo -->
    <div class="fluid">
        <div class="widget leftcontent grid12">
            <div class="widget-header">
                <div class="icon-grp">
                    <strong>Keterangan:</strong>
                    <a href="#" onclick="return false;" class="icon-button icon-color-blue">
                        <i class="fa fa-pencil-square-o"></i>
                    </a> cek detail SPPSB untuk analisa
                    <a href="#" onclick="return false;" class="icon-button icon-color-green">
                        <i class="fa fa-barcode"></i>
                    </a> penomoran SPPSB yang disetujui
                </div>
            </div>
            <div class="widget-content pad20f">	
                @if(Session::has('msgupdate'))
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
                </div>
                @endif
                <table id="sppsb-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="25%">Nama Kontraktor</th>
                            <th>Alamat</th>
                            <th>Agen/Pemasar</th>
                            <th>Status</th>
                            <th>Tgl Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>					        
                    </tbody>
                </table>
            </div>
            <div class="widget-content pad20f">	
                <div class="alert alert-info" role="alert">
                    <h4><i class="fa fa-info-circle"></i> Informasi!</h4>
                    <ul style="padding-left: 20px !important;">
                        <li>Tabel diatas memuat semua data SPPSB yang telah disetujui oleh direksi ataupun yang baru diajukan oleh agen</li>
                        <li>
                            Untuk tombol "penomoran SPPSB yang disetujui" pada kolom "Aksi" hanya akan mucul untuk data SPPSB yang telah disetujui oleh direksi
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div> <!-- /fluid -->

</div> <!-- /main -->
@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        $("#sppsb-datatable").DataTable({
            processing: true,
            serverSide: true,
            scrollX:true,
            ajax: '{{ url("/") }}/getdata-sppsb-masuk',
            columns: [
                {data: 'nama_kontraktor', name: 'nama_kontraktor',
                    render: function (data, type, row) {
                        return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-user"></i> ' + row.direksi + '</div>';
                    }
                },
                {data: 'alamat_kontraktor', name: 'alamat_kontraktor'},
                {data: 'jabatan', name: 'jabatan',
                    render: function (data, type, row) {
                        return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-address-card-o"></i> ' + row.name + '</div>';
                    }
                },
                {data: 'status', name: 'status', sClass: 'text-center',
                    render: function (data, type, row) {
                        var label = "", title = "";
                        if (data == 'B') {
                            label = "label-primary";
                            title = "baru"
                        } else if (data == 'T') {
                            label = "label-danger";
                            title = "ditolak"
                        } else if (data == 'R') {
                            label = "label-warning";
                            title = "direvisi"
                        } else if (data == 'S') {
                            label = "label-success";
                            title = "disetujui"
                        }
                        return '<span class="label ' + label + ' label-mini ' + row.direksi + '">' + title + '</span>';
                    }
                },
                {data: 'tgl_pengajuan', name: 'tgl_pengajuan', sClass: 'text-center'},
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            aaSorting: []
        });
    });
</script>    
@endpush