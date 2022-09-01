<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Cetak Sertifikat Surety Bond</title>
        <style type="text/css">

            body{
                font-family: 'calibry';
                letter-spacing: 0.2px;
                padding: 0 35px 0 25px;
            }
            ol li, table tr, p{
                font-size: 10px;
                font-weight: lighter;
                text-align: justify;
                line-height: 18px;
                padding-top: -3px;
            }
            ol li{
                padding-bottom: 4px;
            }
            ol.sertifikat-list, ol.sertifikat-list li ol {
                padding-left: 10px;
            }
            ol.sertifikat-list li {
                padding-left: 10px;
                margin-bottom: 0px;
            }
            ol.sertifikat-list li ol li{
                margin-bottom: 0;
            }
            .relative {
                position: relative;
            }
            .signed-image{
                position: absolute;
                top: 25px;
                left: 0;
                width: 320px;
            }
            /*		.signed-image img{
                                    width: 320px;
                            }*/
            h3{
                line-height: 0;
            }
            #footer {
                /*position: fixed;*/
                bottom: 100px;
                width: 100%;
                left:25px;
                right: -25px;
            }
            @page { size: 595pt 841pt; }
        </style>
    </head>
    <body>
        <div id="wrapper" class="container">
            <div id="main" class="form-horizontal clearfix">
                <div class="widget-content pad20f">
                    <div style="height:40px;"></div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table width="100%" cellpadding="0" cellspacing="0" style="color:#FF8989;">
                                <tr>
                                    @if(Auth::check())
                                    @can('staff-access')
                                            <!--<td width="50%"><div style="font-size:20px;padding-left:100px;"><strong>DUPLICATE</strong></div></td>-->
                                    @endcan
                                    @can('agen-access')
                                            <!--<td width="50%"><div style="font-size:20px;padding-left:100px;"><strong>ORIGINAL</strong></div></td>-->
                                    @endcan
                                    @endif 
                                            <!--<td width="50%"><div align="right" style="font-size:20px;padding-right:40px;"><strong>No.{{ $sppsb->no_sertifikat}}</strong></div></td>-->
                                </tr>
                            </table>
                            <div style="height:20px;"></div>
                            <div style="height:8px">
                                <h3 align="center" style="font-size:20px;"><strong>JAMINAN SANGGAH BANDING</strong></h3>
                                <img align="right" src= "data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(122.9)->merge('images/jamkrida.png', 0.35, true)->generate('https://demo.jamkridantb.com/sb-detail/'.enkripsi($sppsb->id)))}} ">
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>

                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr style="font-size:14px;">
                                    <td height="40px" width="50%"><div style="padding-left:5px;"><strong>Nomor: {{ $sppsb->no_jaminan}}</strong></div></td>
                                    <td align="right"><strong>Nilai Jaminan Rp. {{ $nilaiJaminanFormat}}</strong></td>
                                </tr>
                            </table>
                            <ol class="sertifikat-list">
                                <li class="text-justify">Dengan ini dinyatakan bahwa kami <span class="text-uppercase"><strong>{{ $sppsb->nama_kontraktor }}</strong></span>
                                    {{ $sppsb->alamat_kontraktor }} sebagai pihak yang mengajukan Sanggah Banding, selanjutnya disebut <strong>TERJAMIN</strong> dan 
                                    <strong>PT. JAMKRIDA NTB BERSAING Ruko Bung Karno Jaya No.11, Jl. Bung Karno - Cilinaya, Mataram, NTB</strong> sebagai <strong>PENJAMIN</strong>, selanjutnya disebut 
                                    <strong>PENJAMIN</strong>, bertanggung jawab dan dengan tegas terikat pada <span class="text-uppercase"><strong>{{ $sppsb->jabatan_pejabat }} {{ $sppsb->pemilik_proyek }} {{ $sppsb->alamat }}</strong></span> 
                                    sebagai <strong>PELAKSANA PELELANGAN</strong>, selanjutnya disebut sebagai <strong>PENERIMA JAMINAN</strong> atas
                                    uang sejumlah Rp. {{ $nilaiJaminanFormat}} ({{ $nilaiJaminan }} Rupiah ).
                                </li>
                                <li class="text-justify">Maka kami, <strong>TERJAMIN</strong> dan <strong>PENJAMIN</strong> dengan ini mengikatkan diri 
                                    untuk melakukan pembayaran jumlah tersebut di atas dengan baik dan benar, bilamana <strong>TERJAMIN</strong> dinyatakan kalah dalam proses sanggah banding
                                    atas <strong>{{ $sppsb->nama_dokumen }}</strong> proyek <strong>{{ $sppsb->jenis_pekerjaan }}</strong> yang telah dilaksanakan oleh 
                                    <strong>PENERIMA JAMINAN</strong> Nomor : <strong>{{ $sppsb->no_dokumen }}</strong> Tanggal {{ tgl_indo($sppsb->tgl_dokumen) }}.
                                </li>
                                <li class="text-justify">Surat jaminan ini berlaku selama {{ $sppsb->durasi }} ({{$selisih}} ) hari kalender dan efektif mulai tanggal {{ tgl_indo($sppsb->waktu_mulai) }} sampai dengan
                                    tanggal {{ tgl_indo($sppsb->waktu_selesai) }}.							
                                </li>
                                <li class="text-justify">Jaminan ini berlaku apabila <strong>TERJAMIN</strong> dinyatakan kalah dalam proses banding.
                                </li>
                                <li class="text-justify"><strong>PENJAMIN</strong> akan membayar kepada <strong>PENERIMA JAMINAN</strong> sejumlah nilai jaminan tersebut di atas dalam
                                    waktu paling lambat 14 ( Empat Belas ) hari kerja <strong>tanpa syarat (unconditional)</strong> setelah menerima tuntutan
                                    penagihan secara tertulis dari <strong>PENERIMA JAMINAN</strong> berdasarkan keputusan <strong>PENERIMA JAMINAN</strong>.
                                </li>
                                <li class="text-justify">Menunjuk pasal 1832 KUH Perdata, dengan ini ditegaskan kembali bahwa <strong>PENJAMIN</strong> melepaskan hak-hak
                                    istimewanya untuk menuntut supaya harta benda <strong>TERJAMIN</strong> lebih dahulu disita dan dijual guna melunasi
                                    hutang-hutangnya sebagaimana dimaksud dalam pasal 1831 KUH Perdata.
                                </li>
                                <li class="text-justify">Tuntutan pencairan terhadap <strong>TERJAMIN</strong> berdasarkan jaminan ini harus sudah diajukan selambat-lambatnya
                                    dalam waktu 7 ( Tujuh ) hari kalender sesudah berakhirnya masa laku jaminan ini.
                                </li>
                            </ol>
                            <p style="padding-top:0; padding-left:5px;line-height:10px;">Dikeluarkan di Mataram pada tanggal {{ tgl_indo($sppsb->tgl_cetak) }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr align="center" valign="top">
                                    <td width="45%" style="text-transform:uppercase"><strong>{{ $sppsb->nama_kontraktor }}<br/>TERJAMIN</strong></td>
                                    <td></td>
                                    <td width="45%" height="150px">
                                        <div class="relative">
                                            <strong>PT. JAMKRIDA NTB BERSAING<br>PENJAMIN</strong>
                                            <div class="signed-image" >
                                                <br>
                                                @can('staff-access')
                                                <img src="images/ttd.png" class="img-responsive" width='69.5%' >
                                                <!--<img src="images/ttd.png" class="img-responsive" width='50%' >-->
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <div id="footer">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr align="center" style="text-transform:uppercase">
                                        <td width="45%"><span style="font-weight:bold;border-bottom:1px solid #000;padding:0 5px;">{{ $sppsb->direksi }}</span></td>
                                        <td></td>
                                        <td width="45%"><span style="font-weight:bold;border-bottom:1px solid #000;padding:0 5px;">INDRA MANTHICA</span></td>
                                    </tr>
                                    <tr align="center">
                                        <td>{{ $sppsb->jabatan_direksi }}</td>
                                        <td></td>
                                        <td>Direktur Utama</td>
                                    </tr>
                                </table>
                                <p style="padding-top:0;font-size:9px;padding-left:30px;line-height:10px;">Service Charge Rp. {{ $charge }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>