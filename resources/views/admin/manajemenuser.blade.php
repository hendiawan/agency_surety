@extends('layouts.app')

@section('content')
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Data Pengguna</h1>
        <span class="secExtra">List data pengguna aplikasi surety bond online</span>
    </div> <!-- /SecInfo -->
    <div class="fluid">
        <div class="widget leftcontent grid12">
            <div class="widget-header">
                <div class="icon-grp" style="padding-top:10px;">
                    <a href="/tambah-pengguna" class="btn btn-blue">
                        <i class="fa fa-user-plus"></i> Tambah Pengguna
                    </a>
                </div>
            </div>
            <div class="widget-content pad20f">		
                <!--		
                <div class="alert alert-info" role="alert">
                        <h4><i class="fa fa-info-circle"></i> Informasi!</h4>
                        <ul style="padding-left: 20px !important;">
                                <li>Silahkan lakukan pengecekan kembali secara menyeluruh sebelum memberikan tanda tangan persetujuan</li>
                                <li>Belum ada SPPSB baru yang memerlukan persetujuan dari anda </li>
                        </ul>
                </div>
                -->
                @if(Session::has('msgupdate'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
                </div>
                @endif
                <div id="resultInfo"></div>
                <table id="user-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="25%">Nama Pengguna</th>
                            <th>Jabatan</th>
                            <th>Email</th>
                            <th>Status</th>
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
    $(document).ready(function () {

        $("#user-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("/") }}/getdata-manajemen-pengguna',
            columns: [
                {data: 'name', name: 'name',
                    render: function (data, type, row) {
                        return '<strong>' + data + '</strong><div class="secExtra"><i class="fa fa-user"></i> <code>' + row.username + '</code></div>';
                    }
                },
                {data: 'jabatan', name: 'jabatan'},
                {data: 'email', name: 'email'},
                {data: 'is_active', name: 'is_active', sClass: 'text-center',
                    render: function (data, type, row) {
                        if (data == '1')
                            isActive = 'checked';
                        else
                            isActive = '';
                        return '<input type="checkbox" name="status" class="sl" id="slider-' + row.id + '" ' + isActive + ' /><label class="slider center" onclick="updateStatus(this, ' + row.id + ');" for="slider-' + row.id + '"></label>';
                    }
                },
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            aaSorting: []
        });
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('[name="_token"]').val()
        }
    });
    function updateStatus(elem, id) {
        var activeVal = $(elem).siblings('input[name="status"]').prop('checked');
        $.ajax({
            dataType: "json",
            data: {id: id, is_active: activeVal},
            type: 'POST',
            url: "{{ url('/update-status-pengguna') }}",
            success: function (result) {
                $('#resultInfo').html('<div class="alert alert-success">'
                        + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                        + '<i class="fa fa-info-circle"></i> SUKSES! Anda sukses melakukan update status agen</div>');
            },
            error: function (e) {
                $('#resultInfo').html('<div class="alert alert-danger">'
                        + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                        + '<i class="fa fa-info-circle"></i> ERROR! proses update status agen gagal, silahkan refresh page/halaman dan ulangi</div>');
            }
        });
    }
</script>    
@endpush