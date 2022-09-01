<div id="sidebar">
    <ul class="mainNav">

            <li class="{{ active(['home','sppsb-detail-direksi/*','sp3kbg-detail-direksi/*']) }}">
                <a href="{{ url('/home') }}"><i class="fa fa-connectdevelop"></i><br>Dashboard</a>
            </li>
    @if(Auth::check())        
        @can('admin-access')
            <li class="{{ active(['manajemen-pengguna','tambah-pengguna','*-pengguna/*']) }}">
                <a href="{{ url('/manajemen-pengguna') }}"><i class="fa fa-users"></i><br>Pengguna</a>
            </li>
            <li class="{{ active(['bank','tambah-bank','*-bank/*']) }}">
                <a href="{{ url('/bank') }}"><i class="fa fa-institution"></i><br>Data Bank</a>
            </li>
            <li class="{{ Request::is('manage-data-pengajuan') ? 'active' : '' }}">
                <a href="{{ url('/manage-data-pengajuan') }}"><i class="fa fa-folder"></i><br>Manage Data</a>
            </li>
            <li class="{{ Request::is('backup-database') ? 'active' : '' }}">
                <a href="{{ url('/backup-database') }}"><i class="fa fa-database"></i><br>Backup DB</a>
            </li>
        @endif
        @can('direksi-access')
            <li class="{{ Request::is('sppsb-disetujui') ? 'active' : '' }}">
                <a href="{{ url('/sppsb-disetujui') }}"><i class="fa fa-thumbs-o-up"></i><br>Disetujui</a>
                <!--<span class="badge badge-mNav">2</span>-->
            </li>
            <li class="{{ Request::is('sppsb-ditolak') ? 'active' : '' }}">
                <a href="{{ url('/sppsb-ditolak') }}"><i class="fa fa-thumbs-o-down"></i><br>Ditolak</a>
            </li>
            <li class="{{ Request::is('sppsb-cetak-sertifikat') ? 'active' : '' }}">
                <a href="{{ url('/sppsb-cetak-sertifikat') }}"><i class="fa fa-print"></i><br>Approval Direksi</a>
            </li>
            <li class="{{ Request::is('sppsb-cetak-sertifikat-kabag') ? 'active' : '' }}">
                <a href="{{ url('/sppsb-cetak-sertifikat-kabag') }}"><i class="fa fa-print"></i><br>Approval Kabag</a>
            </li>
        @endcan
        @can('staff-access')
            <li class="{{ active(['sppsb-sp3kbg-masuk','sppsb-penomoran/*','sppsb-edit/*']) }}">
                <a href="{{ url('/sppsb-sp3kbg-masuk') }}"><i class="fa fa-inbox"></i><br>Data Masuk</a>
                <!--<span class="badge badge-mNav">3</span>-->
            </li>
            <li class="{{ Request::is('sppsb-disetujui') ? 'active' : '' }}">
                <a href="{{ url('/sppsb-disetujui') }}"><i class="fa fa-thumbs-o-up"></i><br>Disetujui</a>
                <!--<span class="badge badge-mNav">2</span>-->
            </li>
            <li class="{{ Request::is('sppsb-ditolak') ? 'active' : '' }}">
                <a href="{{ url('/sppsb-ditolak') }}"><i class="fa fa-thumbs-o-down"></i><br>Ditolak</a>
            </li>
            <li class="{{ Request::is('sppsb-cetak-sertifikat') ? 'active' : '' }}">
                <a href="{{ url('/sppsb-cetak-sertifikat') }}"><i class="fa fa-print"></i><br>Print Out</a>
            </li>
            <li class="{{ active(['sppsb-form','sppsb-edit/*']) }}">
                <a href="{{ url('/sppsb-form-admin') }}"><i class="fa fa-pencil-square"></i><br>Input SPPSB</a>
            </li>
            <li class="{{ active(['sppsb-sp3kbg-data-table','sppsb-detail/*','sp3kbg-detail/*']) }}">
                <a href="{{ url('/sppsb-sp3kbg-data-table-staff') }}"><i class="fa fa-table"></i><br>Table Data Staff</a>
            </li>
            <li class="{{ Request::is('laporan') ? 'active' : '' }}">
                <a href="{{ url('/laporan') }}"><i class="fa fa-folder-open-o"></i><br>Laporan</a>
            </li>
        @endcan
        @can('agen-access')
            <li class="{{ active(['sppsb-form','sppsb-edit/*']) }}">
                <a href="{{ url('/sppsb-form') }}"><i class="fa fa-pencil-square"></i><br>Input SPPSB</a>
            </li>
            <li class="{{ active(['sp3kbg-form','sp3kbg-edit/*']) }}">
                <a href="{{ url('/sp3kbg-form') }}"><i class="fa fa-pencil-square-o"></i><br>Input SP3KBG</a>
            </li>
            <li class="{{ active(['sppsb-sp3kbg-data-table','sppsb-detail/*','sp3kbg-detail/*']) }}">
                <a href="{{ url('/sppsb-sp3kbg-data-table') }}"><i class="fa fa-table"></i><br>Table Data</a>
            </li>
            <li class="{{ Request::is('sppsb-cetak-sertifikat') ? 'active' : '' }}">
                <a href="{{ url('/sppsb-cetak-sertifikat') }}"><i class="fa fa-print"></i><br>Print Out</a>
            </li>
            <li class="{{ Request::is('laporan') ? 'active' : '' }}">
                <a href="{{ url('/laporan') }}"><i class="fa fa-folder-open-o"></i><br>Laporan</a>
            </li>
        @endcan
    @endif 
    </ul>
</div> <!-- /sidebar -->