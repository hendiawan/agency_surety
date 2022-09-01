<p>Dear Direksi,</p>
<p>{{Auth::user()->name}} telah menerbitkan  Penjaminan Surety Bond dengan rencian data sebagai berikut :</p>
 <br>
<table>
    <tr>
        <td>id</td>
        <td>:</td>
        <td>{{$data->id}}</td>
    </tr>
    <tr>
        <td>Nama Kontraktor</td>
        <td>:</td>
        <td>{{$data->nama_kontraktor}}</td>
    </tr>
    <tr>
        <td>Nilai Proyek</td>
        <td>:</td>
        <td>Rp. {{number_format($data->nilai_proyek,2,",",".")}}</td>
    </tr>
    <tr>
        <td>Nilai Penjaminan</td>
        <td>:</td>
        <td>Rp. {{number_format($data->nilai_jaminan,2,",",".")}}</td>
    </tr>
    @php
            if($data->jenis_sppsb=='1')$jenis="Jaminan Penawaran";
           else if($data->jenis_sppsb=='2')$jenis="Jaminan Pelaksanaan";
           else if($data->jenis_sppsb=='3')$jenis="Jaminan Uang Muka";
           else if($data->jenis_sppsb=='4')$jenis="Jaminan Pemeliharaan";
           else if($data->jenis_sppsb=='5')$jenis="Jaminan pembayaran";
           else if($data->jenis_sppsb=='6')$jenis="Jaminan Sanggah Banding";
      @endphp
    <tr>
        <td>Jenis Jaminan</td>
        <td>:</td>
        <td>{{$jenis}}</td>
    </tr>
</table>
 
 @if(Auth::user()->jabatan=='Kabag') 
 <!--Jika yang menerbitkan sertifikat adalah kabag maka link dibawah harus dimunculkan-->
        <p>Silahkan kunjungi link berikut:<br> 
        <a href="https://agenjnb.com/sppsb-cetak-sertifikat-kabag" target="_blank">https://agenjnb.com/sppsb-cetak-sertifikat-kabag</a>
@endif
<p>Email dikirim otomatis oleh sistem Akseptasi Pengajuan Surety Bond</p>
<br>
<br>
<br>
<p>PT. Jamkrida NTB Bersaing</p>
<p>BUMD Provinsi NTB</p>
 <br>
 