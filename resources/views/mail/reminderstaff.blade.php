<p>Dear Staff,</p>
@if($data['status']=='S')
<p>Aplikasi Surety Bond online dengan nomor registrasi: <strong>{{$data['no_registrasi']}}</strong> telah disetujui oleh Direksi, 
selanjutnya silahkan inputkan nomor sertifikat dengan mengunjungi url berikut:<br>
<a href="http://demo.agenjnb.com/sppsb-penomoran/{{$data['id']}}" target="_blank">http://demo.agenjnb.com/sppsb-penomoran/{{$data['id']}}</a>
</p>
@else
@if($data['status']=='B')
<p>Aplikasi Surety Bond online mengirimkan Surat Permohonan Penerbitan Surety Bond (SPPSB) baru dari Agen dengan nomor registrasi:<strong>{{$data['no_registrasi']}}</strong>.</p>
<p>Silahkan kunjungi url berikut untuk melakukan analisa SPPSB:</p>
@else
<p>Aplikasi Surety Bond online mengirimkan kembali Surat Permohonan Penerbitan Surety Bond (SPPSB) dari Direksi dengan status Revisi/Penolakan </p>
<p>Silahkan kunjungi url berikut untuk melakukan pengecekan:</p>
@endif
<p><a href="http://demo.agenjnb.com/sppsb-detail/{{$data['id']}}" target="_blank">http://demo.agenjnb.com/sppsb-detail/{{$data['id']}}</a></p>
@endif