<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Datatables;
use App\Sppsb;
use App\History;
use App\RateSppsb;
use App\Option;
use App\Result;
use App\Agen;
use App\User;
use Mail;
use App\Mail\Reminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Analisa;
class SppsbController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function disetujui()
    {
        return view('common.sppsbsetuju');
    }

    public function getDisetujuiTable()
    {
      
       if(Auth::user()->role=='AA'){
            
            $sppsb = DB::table('sppsb')
                            ->select('sppsb.id',
                                    'sppsb.nama_kontraktor',
                                    'sppsb.direksi',
                                    'sppsb.status',
                                    'sppsb.jenis_sppsb',
                                    'historys.author',
                                    'historys.remark',
                                    DB::raw("(DATE_FORMAT(historys.created_at,'%d/%m/%Y')) AS tgl_disetujui"),
                                    DB::raw("(DATE_FORMAT(sppsb.created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                            )
                            ->leftJoin('historys','historys.sppsb_id','=','sppsb.id')
                            ->where([
                                ['historys.proses','Setuju'],
                                ['sppsb.user_id',Auth::user()->id],
                                ['sppsb.status','=','S'],
                            ])
                            ->orWhere([
                                ['historys.proses','Closing'],
                                ['sppsb.user_id',Auth::user()->id],
                                ['sppsb.status','=','C'],
                            ])
                            ->orderBy('sppsb.created_at','DESC')
                            ->get(); 
        }else{
            $sppsb = DB::table('sppsb')
                            ->select('sppsb.id',
                                    'sppsb.nama_kontraktor',
                                    'sppsb.direksi',
                                    'sppsb.status',
                                    'sppsb.jenis_sppsb',
                                    'historys.author',
                                    'historys.remark',
                                    DB::raw("(DATE_FORMAT(historys.created_at,'%d/%m/%Y')) AS tgl_disetujui"),
                                    DB::raw("(DATE_FORMAT(sppsb.created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                            )
                            ->leftJoin('historys','historys.sppsb_id','=','sppsb.id')
                            ->where([
                                ['historys.proses','Setuju'],
//                                ['sppsb.status','=','S'],
                                ['sppsb.status','=','C'],
                            ])
//                            ->orWhere([
//                                ['historys.proses','Setuju'],
//                                ['sppsb.status','=','C'],
//                            ])
                            ->orderBy('sppsb.created_at','DESC')
                            ->get(); 
        }
        
         if(Auth::user()->role=='SA'){
              return Datatables::of($sppsb)
                            ->addColumn('action', function ($sppsb) {
                                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sppsb-detail-staff/' . $sppsb->id . '" class="icon-button icon-color-grey">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>';
                            })
                            ->make(true);
        }else{
             return Datatables::of($sppsb)
            ->addColumn('action', function ($sppsb) {
                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sppsb-detail/'.$sppsb->id.'" class="icon-button icon-color-grey">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>';
            })
            ->make(true);
         }
       
    }

    public function ditolak()
    {
        return view('common.sppsbtolak');
    }

    public function getDitolakTable()
    {
        if(Auth::user()->role=='AA'){
            $sppsb = DB::table('sppsb')
                            ->select('sppsb.id',
                                    'sppsb.nama_kontraktor',
                                    'sppsb.direksi',
                                    'sppsb.status',
                                    'sppsb.jenis_sppsb',
                                    'historys.author',
                                    'historys.remark',
                                    DB::raw("(DATE_FORMAT(historys.created_at,'%d/%m/%Y')) AS tgl_penolakan"),
                                    DB::raw("(DATE_FORMAT(sppsb.created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                            )
                            ->leftJoin('historys','historys.sppsb_id','=','sppsb.id')
                            ->where([
                                ['historys.proses','Tolak'],
                                ['sppsb.user_id',Auth::user()->id],
                                ['sppsb.status','=','T'],
                            ])
                            ->orderBy('sppsb.created_at','DESC')
                            ->get(); 
        }else{
            $sppsb = DB::table('sppsb')
                            ->select('sppsb.id',
                                    'sppsb.nama_kontraktor',
                                    'sppsb.direksi',
                                    'sppsb.status',
                                    'sppsb.jenis_sppsb',
                                    'historys.author',
                                    'historys.remark',
                                    DB::raw("(DATE_FORMAT(historys.created_at,'%d/%m/%Y')) AS tgl_penolakan"),
                                    DB::raw("(DATE_FORMAT(sppsb.created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                            )
                            ->leftJoin('historys','historys.sppsb_id','=','sppsb.id')
                            ->where([
                                ['historys.proses','Tolak'],
                                ['sppsb.status','=','T'],
                            ])
                            ->orderBy('sppsb.created_at','DESC')
                            ->get(); 
        }

        return Datatables::of($sppsb)
            ->addColumn('action', function ($sppsb) {
                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sppsb-detail/'.$sppsb->id.'" class="icon-button icon-color-grey">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>';
            })
            ->make(true);
    }

    public function detail($id)
    {
        $sppsb = Sppsb::findOrFail($id);     
        $agen = DB::table('agens')
                ->select(
                    'agens.no_agen',
                    'agens.wilayah_agensi',
                    'agens.code_wilayah',
                    'agens.fee_sppsb',
                    'users.name')
                ->leftJoin('users','users.id','=','agens.user_id')
                ->where('users.id', $sppsb->user_id)->first();

        $dokPendukung = json_decode($sppsb->dokumen_pendukung);
        $brgAgunan = json_decode($sppsb->barang_agunan);
        
        $nilaiProyek = ucwords($this->terbilang($sppsb->nilai_proyek));
        $nilaiJaminan = ucwords($this->terbilang($sppsb->nilai_jaminan));

        $admin = Option::findOrFail('2');
        $materai = Option::findOrFail('3');

        if($sppsb->status=='C' || $sppsb->status=='S'){
            $result = Result::where('sppsb_id',$sppsb->id)->first();
            $charge = $result->service_charge;
            $rate = $result->rate_ijp;
            $fee = $result->fee_agen;
            $feeAdmin = $result->fee_admin;
            $materai = $result->materai;
        }else{            
            $serviceCharge = ceil((new DireksiController)->calculateIjp($sppsb->waktu_mulai,$sppsb->waktu_selesai,$sppsb->nilai_jaminan,$sppsb->jenis_sppsb,$admin->value,$materai->value,'SPPSB'));
            $charge = (new DireksiController)->pembulatan($serviceCharge);

            $rate = $this->getRate($sppsb->waktu_mulai, $sppsb->waktu_selesai, $sppsb->jenis_sppsb);

            $fee = $agen->fee_sppsb;
            $feeAdmin = $admin->value;
            $materai = $materai->value;
        }
 
        
        $grossIjp = ($sppsb->nilai_jaminan*$rate)/100;
        $feeAgen = ($grossIjp*$fee)/100;
	                
        $history = '';
        if ($sppsb->status == 'R') {
            $where = ['proses' => 'revisi', 'sppsb_id' => $id];
            $history = History::where($where)->orderBy('id', 'desc')->first();
        } elseif ($sppsb->status == 'T') {
            $where = ['proses' => 'tolak', 'sppsb_id' => $id];
            $history = History::where($where)->orderBy('id', 'desc')->first();
        }

//   dd($serviceCharge);
        return view('common.detailsppsb', compact(
                'sppsb',
                'agen',
                'dokPendukung',
                'brgAgunan',
                'nilaiProyek',
                'nilaiJaminan',
                'history',
                'charge',
                'rate',
                'grossIjp',
                'feeAgen',
                'fee',
                'feeAdmin',
                'materai'));
    }
    
    public function setRate($sppsb_id){
          $admin = DB::
                table('options')
                ->where('id','2')
                ->first();   
                   
          $materai = DB::
                table('options')
                ->where('id','3')
                ->first();  
         
          $sppsb= Sppsb:: where('id',$sppsb_id) ->first();
          $rate = (new DireksiController)->rateIjp($sppsb->waktu_mulai,$sppsb->waktu_selesai,$sppsb->jenis_sppsb,'SPPSB');
         
          $agen = DB::
//                connection('KONEKSIWEB')//KONEKSI KE WEB
                table('agens')
                ->select(
                    'agens.no_agen',
                    'agens.wilayah_agensi',
                    'agens.code_wilayah',
                    'agens.fee_sppsb',
                    'users.role',
                    'users.name')
                ->leftJoin('users','users.id','=','agens.user_id')
                ->where('users.id', $sppsb->user_id)->first();
          
            $serviceCharge  = ceil((new DireksiController)->calculateIjp($sppsb->waktu_mulai,$sppsb->waktu_selesai,$sppsb->nilai_jaminan,$sppsb->jenis_sppsb,$admin->value,$materai->value,'SPPSB'));
            $charge                 = (new DireksiController)->pembulatan($serviceCharge); 
//            $rate                      = getRate($sppsb->waktu_mulai, $sppsb->waktu_selesai, $sppsb->jenis_sppsb); 
            $fee                        = $agen->fee_sppsb; 
            $feeAdmin          = $admin->value;  
            $materai              = $materai->value; 
            $grossIjp             = ($sppsb->nilai_jaminan*$rate['rateIjp'])/100;
            $feeAgen             = ($grossIjp*$fee)/100;  
            $data = [
                        'service_charge' =>$charge,
                         'min_biaya' => $rate['minBiaya'],
                         'rate_ijp'  => $rate['rateIjp'],
                         'fee_agen'  => $agen->fee_sppsb,
                         'fee_admin'  => $admin->value,
                         'materai'   => $materai,
            ];
            return ($data);
    }
   
    public function createResult($sppsp_id,$sevice_charge,$min_biaya,$rate_ijp,$fee_agen,$admin,$materai){
        $result = Result::create([
                         'sppsb_id'               => $sppsp_id,
                         'service_charge'  => $sevice_charge,
                         'min_biaya'            => $min_biaya,
                         'rate_ijp'                 => $rate_ijp,
                         'fee_agen'               => $fee_agen,
                         'fee_admin'            => $admin,
                         'materai'                 => $materai,
                         'author'                   => Auth::user()->name
                     ]);
    }
    
      public function update_backup_server(Request $request)
    {
       
//                   dd($request);
        
        IF($request->deskripsi)
        {
            $data = $request->all();

            foreach ($data['deskripsi'] as $key => $isiData) {
                $deskripsi[] = [
                    'analisa' => $isiData,
                ];
            }

            $dataDeskripsi = json_encode($deskripsi);
            
        }else{
            
             $dataDeskripsi='';
             
        }
          
        
      
        $data = $request->all();
        //update status
//             dd($data);
//        $sppsb = Sppsb::leftjoin('results','results.sppsb_id','sppsb.id')
//                ->select('*','sppsb.created_at') 
//                ->leftjoin('users','sppsb.user_id','users.id')
//                ->findOrFail($data['id']);
       $sppsb = DB::table('v_report_export')
                            ->select('v_report_export.*') 
                            ->where('v_report_export.id',$data['id'])
                            ->first();
    
//    dd($sppsb);
      if($data['status']=='Update')//CEK JIKA STATUS  UPDATE
       {
            if ($request->hasFile('kwitansi')) {
                   $filebuktibayar = saveFile($request->file('kwitansi'));
            }ELSE{
                    $filebuktibayar="";
            }
//             dd($data);
                  $data= Sppsb::
                         where('id',$data['id'])
                            -> update([ 
                                        'dokumen7'=>$filebuktibayar,
                                        'fee'=>$data['persentase'],
                                        'status_bayar'=>$data['pembayaran'],
                                        'updated_by'=>Auth::user()->name,
                               ]);
        
                       return redirect('/sppsb-sp3kbg-data-table-staff');
       }
       
       
        if($data['status']=='E')//CEK JIKA STATUS BERISI E(EXPORT)
        {
            $tgl_verifikasi_keu=date('Y-m-d',strtotime($data['tgl_ver_keu']));
            $tgl_verifikasi_kasi=date('Y-m-d',strtotime($data['tgl_ver_kasi']));
//            dd($data);
             $m_penjaminan = db::CONNECTION('sqlsrv')
                ->table('t_penjaminan')
                ->leftjoin('m_terjamin','m_terjamin.kd_terjamin','t_penjaminan.kd_terjamin')
                ->where([
                    ['t_penjaminan.no_perjanjian',$sppsb->nama_dokumen],
                    ['t_penjaminan.nilai',$sppsb->nilai_jaminan],
                    ['t_penjaminan.jenis_kredit',$sppsb->jenis_pekerjaan],
                        ])
                ->whereDate('t_penjaminan.mulai',$sppsb->waktu_mulai)
                ->whereDate('t_penjaminan.akhir', $sppsb->waktu_selesai)
                ->where('m_terjamin.nama', $sppsb->nama_kontraktor)
//                ->select(\DB::raw('count(*) as total'),'*')
                ->count();
             
//             dd($m_penjaminan);
//             dd($m_penjaminan->total);
//             $m_penjaminan=0;
             
          if ($m_penjaminan > 0) 
          {
                 $session=Session::flash('msgupdateaxis','Data Sudah Ada Sebelumnya dengan nomor sertifikat ');
//                $session=Session::flash('msgupdate','Data Sudah Ada Sebelumnya');

          } 
          else 
          {
               //mengambil kode terakhir terjamin yang di input

               $m_terjamin_last=db::CONNECTION('sqlsrv')
                       ->table('m_terjamin')
                       ->orderBy('kd_terjamin', 'desc')
                       ->take(1)
                       ->first();
//               DD($m_terjamin);
               
               $jumlah_m_terjamin = db::CONNECTION('sqlsrv')
                       ->table('m_terjamin')
                       ->select('nama','kd_terjamin')
                       ->where('nama',$sppsb->nama_kontraktor)
                       ->take(1)
                       ->count();
               
               $data_m_terjamin = db::CONNECTION('sqlsrv')
                       ->table('m_terjamin')
                       ->select('nama','kd_terjamin')
                       ->where('nama',$sppsb->nama_kontraktor)
//                       ->where('nama','like', '%'.$sppsb->nama_kontraktor.'%')
                       ->take(1)
                       ->first();
               
//               dd($data_m_terjamin);
                      
//               $jumlahDataTerajmin=count($m_terjamin);
//                       dd($jumlahDataTerajmin);
//               $sppsb= db::table('sppsb')->where('id',$data['id'])->get();
//                          dd(count($sppsb));
//               echo '<pre>';
//               print_r($m_terjamin_cekjumlah);
//               echo '</pre>';
//              dd($m_terjamin_cekjumlah);
               
              if($jumlah_m_terjamin<1)
              { //cek jumalh terjamin yang ada di sitem

               $kodeterjamin=++$m_terjamin_last->kd_terjamin;
       
               db::CONNECTION('sqlsrv')->table('m_terjamin')->insert(
               [
                 //input data kontraktor(Terjamin) ke Sql Server Lokal
                   'kd_terjamin'   => $kodeterjamin,
                   'kd_kota'       => 'KAA002',
                   'nama'          => $sppsb->nama_kontraktor,
                   'kontak'        => '-',
                   'npwp'          => '-',
                   'alamat'        => $sppsb->alamat_kontraktor,
                   'telepon'       => '-',
                   'fax'           => '-',
                   'email'         => '-',
                   'lahir'         => date('Y-m-d'),
                   'perusahaan'    => '-',
                   'jenis_usaha'   => $sppsb->bidang_usaha,
                   'nomor'         => '-',
                   'direktur'      =>$sppsb->direksi,
                   'status'        => '1',//status terjamin untuk sb (1=sb;2=kredit)
                   'keterangan'    => '-',
                    //tanggal daftar yang terbaca di ambil dari tanggal pengajuan di sistem
                   'tanggal_daftar' => date('Y-m-d', strtotime($sppsb->created_at)),
                   'referensi'     => 'TAH996',
               ]);

               }
               else
               {
                   
                   
                    $kodeterjamin = $data_m_terjamin->kd_terjamin;
                  
                    db::CONNECTION('sqlsrv')
                         ->table('m_terjamin')
                         ->where('kd_terjamin',$kodeterjamin)
                         ->update([
                                //input data kontraktor(Terjamin) ke Sql Server Lokal
                                'kd_kota' => 'KAA002',
                                'nama' => $sppsb->nama_kontraktor,
                                'kontak' => '-',
                                'npwp' => '-',
                                'alamat' => $sppsb->alamat_kontraktor,
                                'telepon' => '-',
                                'fax' => '-',
                                'email'=> '-',
                                'perusahaan' => '-',
                                'jenis_usaha' => $sppsb->bidang_usaha,
                                'nomor' => '-',
                                'direktur' => $sppsb->direksi,
                                'status' => '2',
                                'keterangan' => '-',
                //tanggal daftar yang terbaca di ambil dari tanggal pengajuan di sistem
//                                'tanggal_daftar' => date('Y-m-d', strtotime($sppsb->created_at)),
                                'referensi' => 'TAH996',
                      ]);
                }
               //input data Penjaminan ke sql server Lokal

              
               
//               dd($m_penjaminan);
               

                //cek apakah penerima jaminan sudah ada di tabel server lokal jnb
               $jumlah_m_penerima_jaminan = 
                       db::CONNECTION('sqlsrv')
                       ->table('m_penerima_jaminan')
                       ->where('nama',$sppsb->pemilik_proyek)
                       ->take(1)
                       ->count();
                $m_penerima_jaminan = 
                       db::CONNECTION('sqlsrv')
                       ->table('m_penerima_jaminan')
                       ->where('nama',$sppsb->pemilik_proyek)
                       ->take(1)
                       ->first();
                
//               dd($jumlah_m_penerima_jaminan);
////               
//               $jumlahDataPenerimajaminan=count($m_penerima_jaminan);

               if($jumlah_m_penerima_jaminan<1){
                   
                   //MENGAMBIL KODE PENERIMA JMINAN TERAKHIR
                   $m_penerima_jaminan = db::CONNECTION('sqlsrv')
                            ->table('m_penerima_jaminan')
                            ->orderBy('kd_penerima', 'desc')
                            ->take(1)
                            ->first();
         
                   $kode_penerima=++$m_penerima_jaminan->kd_penerima;
                   $insert_penerima_jaminan=
                           db::CONNECTION('sqlsrv')->table('m_penerima_jaminan')
                           ->insert(
                           [
                             'kd_penerima'     => $kode_penerima,
                             'kd_kota'         => 'KAA001' ,//kodemataram
                             'nama'            => $sppsb->pemilik_proyek,
                             'kontak'          => '-',
                             'alamat'          => $sppsb->alamat,
                             'telepon'         => '-',
                             'fax'             => '-',
                             'email'           => '-',
                             'website'         => '-',
                             'direktur'        =>$sppsb->nama_pejabat,
                             'tanggal_daftar'  =>date('Y-m-d', strtotime($sppsb->created_at)),
                             'keterangan'      => '-',
                             'status'          => '2',
                             'referensi'       => '-',
                            ]);

               }
               else
               {
                    $kode_penerima=$m_penerima_jaminan->kd_penerima; 
                    db::CONNECTION('sqlsrv')->table('m_penerima_jaminan')
                         ->where('kd_penerima',$kode_penerima)
                         ->update(
                          [ 
                             'kd_kota'         => 'KAA001' ,//kodemataram
                             'nama'            => $sppsb->pemilik_proyek,
                             'kontak'          => '-',
                             'alamat'          => '-',
                             'telepon'         => '-',
                             'fax'             => '-',
                             'email'           => '-',
                             'website'         => '-',
                             'direktur'        =>$sppsb->nama_pejabat, 
                             'keterangan'      => '-',
                             'status'          => '1',
                             'referensi'       => '-',
                          ]
                                 );
               }
            
               //UNTUK MENGECEK NO TRANSAKSI TERAKHIR DALAM SATU HARI
               $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                        ->where('t_penjaminan.no_transaksi', 'like', '%'.'KU'.date('ymd').'%')
                        ->orderBy('t_penjaminan.no_transaksi', 'desc')
                        ->take(1)
                        ->first();
                
                if($m_penjaminan){
                     $sub_kalimat = substr($m_penjaminan->no_transaksi, 8);
                }else{
                     $sub_kalimat =0;
                }
               
                $no_transaksi = 'KU' . date('ymd') . str_pad($sub_kalimat, 4, '0', STR_PAD_LEFT);

//               dd($no_transaksi);
                
//                $BiayaAdminstrasi       =  $sppsb->fee_admin+$sppsb->materai;
//                $ijpBulat                          =   $sppsb->service_charge-22000;
//                $feeAgen                          =   $ijpBulat- ($sppsb->fee_agen/100);
//                $NettIJP                            =  $ijpBulat+$BiayaAdminstrasi-$feeAgen;
                
                
                $DATA_T_PENJAMINAN_INSERT = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                       ->insert(
                       [
                           'no_transaksi' => ++$no_transaksi,
                           'kd_divisi' => 'DAA001',
                           'kd_penerima' => $kode_penerima,
                           'kd_terjamin' => $kodeterjamin,
                           'kd_produk' => $sppsb->kd_produk,
                           'no_sertifikat' => $sppsb->no_jaminan,
                           'tanggal_sertifikat' => '2001-01-01',
                           //tanggal verifikasi  di sistem yaitu tanggal sinkronisasi
                           'tanggal' => date('Y-m-d', strtotime($sppsb->tgl_cetak)),//digunakan sebagai tanggal terbit sertifikat
                           'mulai' => date('Y-m-d', strtotime($sppsb->waktu_mulai)),
                           'akhir' => date('Y-m-d', strtotime($sppsb->waktu_selesai)),
                           'tarif_ijp' => $sppsb->rate_ijp,
                           'total_ijp_kotor' => $sppsb->gross_ijp,
                           'total_ijp_bersih' => $sppsb->net_ijp,
                           'nilai' => $sppsb->nilai_jaminan,
                           'nilai_penjaminan' =>'100',
                           'diskon' => $sppsb->diskon,
                           'biaya1' => $sppsb->materai,
                           'biaya2' => $sppsb->fee_admin,
                           'biaya3' =>  '0',
                           'keterangan' =>$sppsb->durasi,
//                           'kd_user' => 'UAA020', //KODE USERNYA DENTICKHA MAGHFIRA
                           'kd_user' => 'UAA003', //KODE USERNYA FUAD
                           'jenis' => '2',
                           'no_permintaan_penjamin' => $sppsb->no_dokumen,
                           'tanggal_permintaan_penjamin' => $sppsb->tgl_dokumen,//TANGGAL DOKUMEN PENDUNJUKAN
                           'no_perjanjian' => $sppsb->nama_dokumen,
                           'tanggal_perjanjian' => date('Y-m-d', strtotime($sppsb->tgl_dokumen)),//TANGGAL DOKUMEN PENDUNJUKAN
                           'jenis_kredit' => $sppsb->jenis_pekerjaan,
                       
                         ]);

               //INSERT DATA KE TABEL VERIFIKASI PENJAMINAN 
                //INSERT DATA KE TABEL VERIFIKASI PENJAMINAN
//            $data_t_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
//                    ->where('kd_terjamin', $kode_terjamin)
//                    ->first();
//                dd($no_transaksi);
               $DATA_INSERT_VERIFIKASI = db::CONNECTION('sqlsrv')->table('t_penjaminan_verifikasi')->insert(
                       [
                           'no_transaksi' =>$no_transaksi,
                           //tanggal verifikasi keuangan di sistem yaitu tanggal sinkronisasi
                           'tanggal' =>$sppsb->created_at,
                           'kd_user' =>'UAA020',
                           'keterangan' => '-',
                           'tanggal_server' => $sppsb->created_at,
                           'status' => '1'
                       ]
               );

               //INSERT DATA KE TABEL VERIFIKASI KEUANGAN
              
//               $DATA_INSERT_PENJAMINAN_KEUANGAN = db::CONNECTION('sqlsrv')
//                       ->table('t_penjaminan_keuangan')->insert(
//                       [
//                           'no_transaksi' =>$no_transaksi,
//                           'tanggal' => $tgl_verifikasi_keu,
//                           'kd_jenis' => 'JAA001',
//                           'kd_kas' => 'KAA002',//kode kas untuk Giro Pada Bank NTB Syariah Pejanggik
//                           'no_bukti' => '-',
//                           'keterangan' => '-',
//                           'kd_user' => 'UAA009', //KODE USERNYA SIGIT
//                           'tanggal_server' =>$tgl_verifikasi_keu
//                       ]
//               );
               
               $session=Session::flash('msgupdate','Data berhasil di masukkan');
           }
        }
        else
        {
            if($data['status']=='B')
            {
//                dd($data);
                //kondisi jika di revisi oleh kabag
                  IF(Auth::user()->jabatan=='Kabag'){
                     
                    Analisa::  where('sppsb_id',$data['id'])
                            -> update([ 
                                        'analisa_kabag'=>$data['remark'],
                                        'sppsb_id'=>$data['id'],
                                        'updated_by'=>Auth::user()->name,
                               ]);
                    
                        $remark = $data['remark'];
                        $proses = 'Baru';
                         
                  }else{
   //DI GUNAKAN UNTUK AGEN MENGIRIMKAN DATA SB KE STAFF BY EMAIL
                $remark = '';
                $proses = 'Baru';
                $users = User::where('role','SA')->get();
    //            dd($users);
//                foreach($users as $user)
//                {
//                    Mail::to($user->email)->send(new Reminder($data));
//                }
                  }
                   $status=$data['status'];
            }
             elseif($data['status']=='K')    //Kabag
            {  
               $remark = $data['remark'];
            //  $remark = '';
                $proses = 'Kabag';
                $cekAnalisa = Analisa::where('sppsb_id',$data['id'])->count();
//               dd($data);
                if($cekAnalisa<1)
                {
                       $analisa= Analisa::create([
                            'analisa_staff'=>$dataDeskripsi,
                            'rekomendasi'=>$data['remark'],
                            'sppsb_id'=>$data['id'],
                            'created_by'=>Auth::user()->name,
                ]);
                }
                else
                {
                    $cekAnalisa = Analisa::where('sppsb_id',$data['id'])->first();
                    if($request->deskripsi[0]==""){
                        $dataDeskripsi = $cekAnalisa->analisa_staff;
                    }
                    
                    if($data['remark']==""){
                        $datarekomendasi = $cekAnalisa->rekomendasi;
                    }else{
                        $datarekomendasi=$data['remark'];
                    }
                    
                        Analisa::where('sppsb_id',$data['id'])
                            -> update([ 
                                         'analisa_staff'=>$dataDeskripsi,
                                         'rekomendasi'=>$datarekomendasi
                               ]);
                }
                $status=$data['status'];
            } 
            elseif($data['status']=='I')
            {
                 
                    //DI GUNAKAN UNTUK KABAG  MENGIRIMKAN DATA SB KE DIREKTUR
                    $sppsb      = Sppsb::findOrFail($data['id']);   
//                    dd($data);
                    if( $sppsb->nilai_jaminan<=50000000) //limit kabag penjaminan untuk memutus berdasarkan SK Penjaminan
                    {
                         $type         = jenisSppsbCode($sppsb->jenis_sppsb); 
                         $agen        = Agen::where('user_id',$sppsb->user_id)
                                             ->leftjoin('users','users.id','agens.user_id') 
                                             ->first(); 
                          $lastNo = DB::table('sppsb')->select('no_jaminan as lastno')
                                       ->leftJoin('historys','historys.sppsb_id','=','sppsb.id')
                                       ->where(\DB::raw("(DATE_FORMAT(historys.updated_at,'%Y'))"), date('Y'))
                                       ->where('user_id',$agen->user_id)
                                       ->where('status','C') 
                                       ->take(1)
                                       ->orderBy('historys.updated_at','desc')
                                       ->first();
                      if($lastNo==null){
                           $nourutsertifikat=0;
                     }else{
                         $nourutsertifikat= explode(".",$lastNo->lastno);
                         $nourutsertifikat=$nourutsertifikat[1];
                     } 

                  if($agen->jabatan=='Staff')
                     {
                         //ketentutan penomoran sertifikat jika yang menginput staff   
                         $lastNo = DB::table('sppsb')->select('no_jaminan as lastno')
                                           ->leftJoin('historys','historys.sppsb_id','=','sppsb.id')
                                           ->where(\DB::raw("(DATE_FORMAT(historys.updated_at,'%Y'))"), date('Y'))
                                           ->where('user_id',$agen->user_id)
                                           ->where('status','C') 
                                           ->take(1)
                                           ->orderBy('historys.updated_at','desc')
                                           ->first(); 

                         if($lastNo==null){
                               $nourutsertifikat=0;
                         }else{
                             //  $nourutsertifikat=substr($lastNo->lastno,3,3);
                               $nourutsertifikat= explode(".",$lastNo->lastno);
                         }


                       if($nourutsertifikat[1]==null){
                           $nourutsertifikat=0;
                       }else{
                          $nourutsertifikat=$nourutsertifikat[1];
                       }

                         $koderegistrasibank=$sppsb->skpd;
                         $nomorurutsertifikat=str_pad(++$nourutsertifikat, 4, '0', STR_PAD_LEFT); 
                         $kodeagen='01';
                         $kodebank='01';
                         $jenispenjaminan=$type;
                         //sistem penomeraan sesuai SKD 
                         $nomor_sertifikat = $koderegistrasibank.'.'.$nomorurutsertifikat.'.'.$jenispenjaminan.'.'.$kodebank.'.'.$kodeagen.'.'.date('m').'.'.date('Y');
                          
                  }
                 else
                     {
                         $wilayah = kodeWilayah($agen->code_wilayah);
                          $kodeagen                     = $agen->no_agen;
                          $kodeDinas                   = '01';
                          $koderegistrasimitra = $wilayah;//--->Penomoran SKPD
                          $jenispenjaminan       = $type;
                          $nomorurutsertifikat =str_pad(++$nourutsertifikat, 4, '0', STR_PAD_LEFT); 
                     //sistem penomeraan sesuai SKD 
                         $nomor_sertifikat = $koderegistrasimitra.'.'.$nomorurutsertifikat.'.'.$jenispenjaminan.'.'.$kodeDinas.'.'.$kodeagen.'.'.date('m').'.'.date('Y');
                    }  
                         //PEMBERIAN NOMOR SERI PADA SERTIFKAT
                            $lastNoSertifikat = DB::table('sppsb')
                                      ->select(DB::raw('MAX(no_sertifikat) as no_reg'))
                                      ->where([['user_id', $sppsb->user_id],['created_at', '>', '2017-06-13']])
                                      ->first(); 
                              $NoSeriSertifikat =str_pad(++$lastNoSertifikat->no_reg, 8, '0', STR_PAD_LEFT);   
                            //jika status terakhirnya Proses, maka akan diberikan nomor sertifikat, agar tidak terdapat dua kali penomoran
                             date_default_timezone_set("Asia/Jakarta");
                             date('Y-m-d H:i:s',strtotime('+1 hour')); 

                  //            dd($data);
                              $remark = $data['remark'];
                              $proses = 'Setuju';
                  //            dd($remark);
                              $rate = $this->rateIjp($sppsb->waktu_mulai,$sppsb->waktu_selesai,$sppsb->jenis_sppsb,'SPPSB');
                              $agen = Agen::where('user_id',$sppsb->user_id)->first();
                              $admin = Option::findOrFail('2');

                           //   if($sppsb->nilai_jaminan>5000000){
                                //    $materai = Option::findOrFail('3');
                                 //   $materai = $materai->value;
                            //  }else{
                           //          $materai = 0;
                          //    }
//                                  dd($materai);

                                 $materai = Option::findOrFail('3');
                                 
                                 $materai = $materai->value;
                                 $serviceCharge = ceil((new DireksiController)->
                                         calculateIjp(
                                                 $sppsb->waktu_mulai,
                                                 $sppsb->waktu_selesai,
                                                 $sppsb->nilai_jaminan,
                                                 $sppsb->jenis_sppsb,
                                                 $admin->value,
                                                 $materai,
                                                 'SPPSB'));
                                 
//                                       dd($serviceCharge);
                                       
                              $charge = (new DireksiController)->pembulatan($serviceCharge);
                              //insert result
                          
                              $result = Result::create([
                                  'sppsb_id'  => $data['id'],
                                  'ttd'       => '',
                                  'ttd_type'  =>'',
                                  'service_charge' => $charge,
                                  'min_biaya' => $rate['minBiaya'],
                                  'rate_ijp'  => $rate['rateIjp'],
                                  'fee_agen'  => $agen->fee_sppsb,
                                  'fee_admin'  => $admin->value,
                                  'materai'   => $materai,
                                  'author'    => Auth::user()->name
                              ]);


                                    $analisa = Analisa::
                                    where('sppsb_id', $data['id'])
                                    ->update([
                                              'keputusan' => $data['remark'],
                                              'updated_by' => Auth::user()->name,
                                      ]);

                                  $sppsb->no_jaminan           = $nomor_sertifikat;//nomor sertifikat
                                  $sppsb->no_sertifikat        = $NoSeriSertifikat; //nomor seri sertifikat
                                  $sppsb->status               = 'C';
                                  $sppsb->updated_by           = Auth::user()->username;
                                  $sppsb->save();

                                  
                               //  $dataSign=[
                                  //    "nik"=>'5271051910800001',
                               //       "passphrase"=> 'Bismillah2'  
                              //    ];
                                  
                                 //    $this->signSbFromCloud($data['id'],$dataSign['nik'],$dataSign['passphrase']);
                                  
                               $dataSign=[
                                            "nik"=>'5271051910800001',
                                             "passphrase"=> 'Bismillah2'  
                                  ];
                                  //proses ttd dokumen sertifikat
                                   $this->signSbFromCloud($data['id'], $dataSign['nik'], $dataSign['passphrase']);
                                   
                              
                                    
                                 $status = 'C'; //hanya untuk ngisi variabel status agar tidak error
                                 $proses = 'Kabag'; 
//                                dd($proses);

                                    // Email Direktur
                                 Mail::to('lalutaufikmulyajati@yahoo.co.id')
                                 ->cc('it.dev@jamkridantb.com') 
                                 ->bcc('direktur@jamkridantb.com') 
                                 ->send(new Reminder($sppsb)); 
                               
                    }
                    else
                    {
                         $status = 'I'; //status untuk ke direktur "P" untuk ke Dirut
                         $proses = 'Direktur';
                            Mail::to('it.dev@jamkridantb.com')
                                // ->cc('it.dev@jamkridantb.com') 
                                 ->send(new Reminder($sppsb)); 
                    } 
                     $remark = $data['remark'];
                     //  $remark = ''; 
                     $analisa= Analisa::where('sppsb_id',$data['id'])
                         -> update([ 
                             'analisa_kabag'=>$data['remark'],
                             'sppsb_id'=>$data['id'],
                             'updated_by'=>Auth::user()->name,
                            ]);  
   
                   
                }  
            elseif($data['status']=='P')
            { 
     //DI GUNAKAN UNTUK STAFF MENGIRIMKAN DATA SB KE DIRUT
//                dd($data);
               $remark = $data['remark'];
            //  $remark = '';
                $proses = 'Proses';
                
                 $analisa= Analisa::
                         where('sppsb_id',$data['id'])
                            -> update([ 
                                        'analisa_direktur'=>$data['remark'],
                                        'sppsb_id'=>$data['id'],
                                        'updated_by'=>Auth::user()->name,
                               ]);
                
//                Mail::to('dirut@jamkridantb.com')
//                Mail::to('hendiawan.dipa@gmail.com')
////                        ->cc('it.dev@jamkridantb.com')
////                        ->cc('indrajamkridantb@gmail.com')
//                        ->send(new Reminder($data));
                 
                 $status=$data['status'];
            }  
            elseif($data['status']=='R')
            {            
                $remark = $data['remark'];
                $proses = 'Revisi';
                $status=$data['status'];
            }
            elseif($data['status']=='T')
            {            
                $remark = $data['remark'];
                $proses = 'Tolak';
                 $status=$data['status'];
            }
           
            $sppsb                                   = Sppsb::findOrFail($data['id']);
            $sppsb->status                  = $status;
            $sppsb->updated_by      = Auth::user()->username;
            $sppsb->save();
//            dd($data);
                      $history = History::create([
                            'sppsb_id'  => $data['id'],
                            'proses'    => $proses,
                            'author'    => Auth::user()->name,
                            'remark'    => $remark
                        ]); 
        }
        
         if ($data['status'] == 'B') 
         {
             
              //telegram Notification
                                $jenis = $this->jenisSppsb($sppsb->jenis_sppsb); 
                                $hostname =$_SERVER['SERVER_NAME'];
                                $url = 'https://'.$hostname.'/sppsb-detail-staf/'.$sppsb->id;
                                $pesan = "$sppsb->id - Dear Staf, terdapat satu pengajuan JAMINAN $jenis  "
                                        . "dari $sppsb->nama_kontraktor dengan nilai jaminan Rp. ".number_format($sppsb->nilai_jaminan, 2,",",".") 
                                        ." untuk memproses silahkan klik link di bawah ini : ";

                                $this->sendMessageTelegramBot($pesan, "814160380",$url); //  id fuad
                                $this->sendMessageTelegramBot($pesan, "887489020",$url); // telegram id 
             
                Session::flash('msgupdate', 'SPPSB dengan no registrasi ' . $sppsb->no_registrasi . ' berhasil di kirim ke staff surety bond');
                return redirect('/sppsb-sp3kbg-data-table');
         }   
         else if ($data['status'] == 'E')  
         {
                $session;
                return redirect('/sppsb-cetak-sertifikat');
         } 
         else
         {
                Session::flash('msgupdate', 'SPPSB dengan no registrasi ' . $sppsb->no_registrasi . ' berhasil di update dengan status ' . $proses . '');
                return redirect('/sppsb-sp3kbg-masuk');
         }
     
    }

    public function update(Request $request)
    {
       
        IF($request->deskripsi)
        {
            $data = $request->all();

            foreach ($data['deskripsi'] as $key => $isiData) {
                $deskripsi[] = [
                    'analisa' => $isiData,
                ];
            }

            $dataDeskripsi = json_encode($deskripsi);
            
        }
        else
        {            
             $dataDeskripsi='';
          }
          
        $data = $request->all();
        //update status
//             dd($data);
//        $sppsb = Sppsb::leftjoin('results','results.sppsb_id','sppsb.id')
//                ->select('*','sppsb.created_at') 
//                ->leftjoin('users','sppsb.user_id','users.id')
//                ->findOrFail($data['id']);
       $sppsb = DB::table('v_report_export')
                            ->select('v_report_export.*') 
                            ->where('v_report_export.id',$data['id'])
                            ->first();
     
//    dd($sppsb);
      if($data['status']=='Update')//CEK JIKA STATUS  UPDATE
      {
            if ($request->hasFile('kwitansi')) 
            {
                   $filebuktibayar = saveFile($request->file('kwitansi'));
            }
            ELSE
            {
                    $filebuktibayar="";
            }
//             dd($data);
            $data= Sppsb::where('id',$data['id'])
                            -> update([ 
                                        'dokumen7'=>$filebuktibayar,
                                        'fee'=>$data['persentase'],
                                        'status_bayar'=>$data['pembayaran'],
                                        'updated_by'=>Auth::user()->name,
                               ]); 
                       return redirect('/sppsb-sp3kbg-data-table-staff');
       }
              
        if($data['status']=='E')//CEK JIKA STATUS BERISI E(EXPORT)
        {
            $tgl_verifikasi_keu=date('Y-m-d',strtotime($data['tgl_ver_keu']));
            $tgl_verifikasi_kasi=date('Y-m-d',strtotime($data['tgl_ver_kasi']));
//            dd($data);
             $m_penjaminan = db::CONNECTION('sqlsrv')
                ->table('t_penjaminan')
                ->leftjoin('m_terjamin','m_terjamin.kd_terjamin','t_penjaminan.kd_terjamin')
                ->where([
                    ['t_penjaminan.no_perjanjian',$sppsb->nama_dokumen],
                    ['t_penjaminan.nilai',$sppsb->nilai_jaminan],
                    ['t_penjaminan.jenis_kredit',$sppsb->jenis_pekerjaan],
                        ])
                ->whereDate('t_penjaminan.mulai',$sppsb->waktu_mulai)
                ->whereDate('t_penjaminan.akhir', $sppsb->waktu_selesai)
                ->where('m_terjamin.nama', $sppsb->nama_kontraktor)
//                ->where('m_terjamin.nama', $sppsb->nama_kontraktor)
//                ->select(\DB::raw('count(*) as total'),'*')
                ->first();
//             dd($sppsb);
//             dd($m_penjaminan);
//             dd($m_penjaminan->total);
//             $m_penjaminan=0;
//             dd($m_penjaminan);
          if (isset($m_penjaminan->no_sertifikat)) 
          {
                 $session=Session::flash('msgupdateaxis','Nomor Sertifikat : '.$sppsb->no_jaminan.' Sudah Ada pada SIM PK dengan nomor sertifikat: '.$m_penjaminan->no_sertifikat);
//                $session=Session::flash('msgupdate','Data Sudah Ada Sebelumnya');
          } 
          else 
          {
               //mengambil kode terakhir terjamin yang di input
               $m_terjamin_last=db::CONNECTION('sqlsrv')
                       ->table('m_terjamin')
                       ->orderBy('kd_terjamin', 'desc')
                       ->take(1)
                       ->first();
//               DD($m_terjamin);
               
               $jumlah_m_terjamin = db::CONNECTION('sqlsrv')
                       ->table('m_terjamin')
                       ->select('nama','kd_terjamin')
                       ->where('nama',$sppsb->nama_kontraktor)
                       ->take(1)
                       ->count();
               
               $data_m_terjamin = db::CONNECTION('sqlsrv')
                       ->table('m_terjamin')
                       ->select('nama','kd_terjamin')
                       ->where('nama',$sppsb->nama_kontraktor)
//                       ->where('nama','like', '%'.$sppsb->nama_kontraktor.'%')
                       ->take(1)
                       ->first();
//               dd($data_m_terjamin);
//               $jumlahDataTerajmin=count($m_terjamin);
//                       dd($jumlahDataTerajmin);
//               $sppsb= db::table('sppsb')->where('id',$data['id'])->get();
//                          dd(count($sppsb));
//               echo '<pre>';
//               print_r($m_terjamin_cekjumlah);
//               echo '</pre>';
//              dd($m_terjamin_cekjumlah);
               
              if($jumlah_m_terjamin<1)
              { //cek jumalh terjamin yang ada di sitem

               $kodeterjamin=++$m_terjamin_last->kd_terjamin;
       
               db::CONNECTION('sqlsrv')->table('m_terjamin')->insert(
               [
                 //input data kontraktor(Terjamin) ke Sql Server Lokal
                   'kd_terjamin'   => $kodeterjamin,
                   'kd_kota'       => 'KAA002',
                   'nama'          => $sppsb->nama_kontraktor,
                   'kontak'        => '-',
                   'npwp'          => '-',
                   'alamat'        => $sppsb->alamat_kontraktor,
                   'telepon'       => '-',
                   'fax'           => '-',
                   'email'         => '-',
                   'lahir'         => date('Y-m-d'),
                   'perusahaan'    => '-',
                   'jenis_usaha'   => $sppsb->bidang_usaha,
                   'nomor'         => '-',
                   'direktur'      =>$sppsb->direksi,
                   'status'        => '1',//status terjamin untuk sb (1=sb;2=kredit)
                   'keterangan'    => '-',
                    //tanggal daftar yang terbaca di ambil dari tanggal pengajuan di sistem
                   'tanggal_daftar' => date('Y-m-d', strtotime($sppsb->created_at)),
                   'referensi'     => 'TAH996',
               ]);

               }
               else
               { 
                    $kodeterjamin = $data_m_terjamin->kd_terjamin; 
                    db::CONNECTION('sqlsrv')
                         ->table('m_terjamin')
                         ->where('kd_terjamin',$kodeterjamin)
                         ->update([
                                //input data kontraktor(Terjamin) ke Sql Server Lokal
                                'kd_kota' => 'KAA002',
                                'nama' => $sppsb->nama_kontraktor,
                                'kontak' => '-',
                                'npwp' => '-',
                                'alamat' => $sppsb->alamat_kontraktor,
                                'telepon' => '-',
                                'fax' => '-',
                                'email'=> '-',
                                'perusahaan' => '-',
                                'jenis_usaha' => $sppsb->bidang_usaha,
                                'nomor' => '-',
                                'direktur' => $sppsb->direksi,
                                'status' => '2',
                                'keterangan' => '-',
                //tanggal daftar yang terbaca di ambil dari tanggal pengajuan di sistem
//                                'tanggal_daftar' => date('Y-m-d', strtotime($sppsb->created_at)),
                                'referensi' => 'TAH996',
                      ]);
                }
               //input data Penjaminan ke sql server Lokal 
//               dd($m_penjaminan);
               

                //cek apakah penerima jaminan sudah ada di tabel server lokal jnb
               $jumlah_m_penerima_jaminan = 
                       db::CONNECTION('sqlsrv')
                       ->table('m_penerima_jaminan')
                       ->where('nama',$sppsb->pemilik_proyek)
                       ->take(1)
                       ->count();
                $m_penerima_jaminan = 
                       db::CONNECTION('sqlsrv')
                       ->table('m_penerima_jaminan')
                       ->where('nama',$sppsb->pemilik_proyek)
                       ->take(1)
                       ->first();
                
//               dd($jumlah_m_penerima_jaminan);
////               
//               $jumlahDataPenerimajaminan=count($m_penerima_jaminan);

               if($jumlah_m_penerima_jaminan<1){
                   
                   //MENGAMBIL KODE PENERIMA JMINAN TERAKHIR
                   $m_penerima_jaminan = db::CONNECTION('sqlsrv')
                            ->table('m_penerima_jaminan')
                            ->orderBy('kd_penerima', 'desc')
                            ->take(1)
                            ->first();
         
                   $kode_penerima=++$m_penerima_jaminan->kd_penerima;
                   $insert_penerima_jaminan=
                           db::CONNECTION('sqlsrv')->table('m_penerima_jaminan')
                           ->insert(
                           [
                             'kd_penerima'     => $kode_penerima,
                             'kd_kota'         => 'KAA001' ,//kodemataram
                             'nama'            => $sppsb->pemilik_proyek,
                             'kontak'          => '-',
                             'alamat'          => $sppsb->alamat,
                             'telepon'         => '-',
                             'fax'             => '-',
                             'email'           => '-',
                             'website'         => '-',
                             'direktur'        =>$sppsb->nama_pejabat,
                             'tanggal_daftar'  =>date('Y-m-d', strtotime($sppsb->created_at)),
                             'keterangan'      => '-',
                             'status'          => '3', //jenis penerima jaminan bukan lembaga keuangan
                             'referensi'       => '-',
                            ]);

               }
               else
               {
                    $kode_penerima=$m_penerima_jaminan->kd_penerima; 
                    db::CONNECTION('sqlsrv')->table('m_penerima_jaminan')
                         ->where('kd_penerima',$kode_penerima)
                         ->update(
                          [ 
                             'kd_kota'         => 'KAA001' ,//kodemataram
                             'nama'            => $sppsb->pemilik_proyek,
                             'kontak'          => '-',
                             'alamat'          => '-',
                             'telepon'         => '-',
                             'fax'             => '-',
                             'email'           => '-',
                             'website'         => '-',
                             'direktur'        =>$sppsb->nama_pejabat, 
                             'keterangan'      => '-',
                             'status'          => '3', //jenis penerima jaminan bukan lembaga keuangan
                             'referensi'       => '-',
                          ]
                                 );
               }
            
               //UNTUK MENGECEK NO TRANSAKSI TERAKHIR DALAM SATU HARI
               $m_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                        ->where('t_penjaminan.no_transaksi', 'like', '%'.'KU'.date('ymd').'%')
                        ->orderBy('t_penjaminan.no_transaksi', 'desc')
                        ->take(1)
                        ->first();
                
                if($m_penjaminan){
                     $sub_kalimat = substr($m_penjaminan->no_transaksi, 8);
                }else{
                     $sub_kalimat =0;
                }
               
                $no_transaksi = 'KU' . date('ymd') . str_pad($sub_kalimat, 4, '0', STR_PAD_LEFT);

//               dd($no_transaksi);
                
//                $BiayaAdminstrasi       =  $sppsb->fee_admin+$sppsb->materai;
//                $ijpBulat                          =   $sppsb->service_charge-22000;
//                $feeAgen                          =   $ijpBulat- ($sppsb->fee_agen/100);
//                $NettIJP                            =  $ijpBulat+$BiayaAdminstrasi-$feeAgen;
                
                
                $DATA_T_PENJAMINAN_INSERT = db::CONNECTION('sqlsrv')->table('t_penjaminan')
                       ->insert(
                       [
                           'no_transaksi' => ++$no_transaksi,
                           'kd_divisi' => 'DAA001',
                           'kd_penerima' => $kode_penerima,
                           'kd_terjamin' => $kodeterjamin,
                           'kd_produk' => $sppsb->kd_produk,
                           'no_sertifikat' => $sppsb->no_jaminan,
                           'tanggal_sertifikat' => '2001-01-01',
                           //tanggal verifikasi  di sistem yaitu tanggal sinkronisasi
//                           'tanggal' => date('Y-m-d', strtotime($sppsb->tgl_cetak)),//digunakan sebagai tanggal terbit sertifikat
                           'tanggal' => date('Y-m-d', strtotime($sppsb->created_at)),//digunakan sebagai tanggal terbit sertifikat
                           'mulai' => date('Y-m-d', strtotime($sppsb->waktu_mulai)),
                           'akhir' => date('Y-m-d', strtotime($sppsb->waktu_selesai)),
                           'tarif_ijp' => $sppsb->rate_ijp,
                           'total_ijp_kotor' => $sppsb->gross_ijp,
                           'total_ijp_bersih' => $sppsb->net_ijp,
                           'nilai' => $sppsb->nilai_jaminan,
                           'nilai_penjaminan' =>'100',
                           'diskon' => $sppsb->diskon,
                           'biaya1' => $sppsb->materai,
                           'biaya2' => $sppsb->fee_admin,
                           'biaya3' =>  '0',
                           'keterangan' =>$sppsb->durasi,
//                           'kd_user' => 'UAA020', //KODE USERNYA DENTICKHA MAGHFIRA
                           'kd_user' => 'UAA003', //KODE USERNYA FUAD
                           'jenis' => '2',
                           'no_permintaan_penjamin' => $sppsb->no_dokumen,
                           'tanggal_permintaan_penjamin' => $sppsb->tgl_dokumen,//TANGGAL DOKUMEN PENDUNJUKAN
                           'no_perjanjian' => $sppsb->nama_dokumen,
                           'tanggal_perjanjian' => date('Y-m-d', strtotime($sppsb->tgl_dokumen)),//TANGGAL DOKUMEN PENDUNJUKAN
                           'jenis_kredit' => $sppsb->jenis_pekerjaan,
                       
                         ]);

               //INSERT DATA KE TABEL VERIFIKASI PENJAMINAN 
                //INSERT DATA KE TABEL VERIFIKASI PENJAMINAN
//            $data_t_penjaminan = db::CONNECTION('sqlsrv')->table('t_penjaminan')
//                    ->where('kd_terjamin', $kode_terjamin)
//                    ->first();
//                dd($no_transaksi);
               $DATA_INSERT_VERIFIKASI = db::CONNECTION('sqlsrv')->table('t_penjaminan_verifikasi')->insert(
                       [
                           'no_transaksi' =>$no_transaksi,
                           //tanggal verifikasi keuangan di sistem yaitu tanggal sinkronisasi
                           'tanggal' =>$sppsb->created_at,
                           'kd_user' =>'UAA020',
                           'keterangan' => '-',
                           'tanggal_server' => $sppsb->created_at,
                           'status' => '1'
                       ]
               );

               //INSERT DATA KE TABEL VERIFIKASI KEUANGAN
              
//               $DATA_INSERT_PENJAMINAN_KEUANGAN = db::CONNECTION('sqlsrv')
//                       ->table('t_penjaminan_keuangan')->insert(
//                       [
//                           'no_transaksi' =>$no_transaksi,
//                           'tanggal' => $tgl_verifikasi_keu,
//                           'kd_jenis' => 'JAA001',
//                           'kd_kas' => 'KAA002',//kode kas untuk Giro Pada Bank NTB Syariah Pejanggik
//                           'no_bukti' => '-',
//                           'keterangan' => '-',
//                           'kd_user' => 'UAA009', //KODE USERNYA SIGIT
//                           'tanggal_server' =>$tgl_verifikasi_keu
//                       ]
//               );
               
               $session=Session::flash('msgupdate','Data berhasil di masukkan');
           }
        }
        else
        {
        
            //untuk memberikan nama referensi pembawa proyek
            if($data['status']=='B') //Status Pengajuan Pada Posisi Agen, akan diajukan ke Staf
            {
                //kondisi jika di revisi oleh kabag
                  IF(Auth::user()->jabatan=='Kabag'){ 
                    Analisa::  where('sppsb_id',$data['id'])
                            -> update([ 
                                        'analisa_kabag'=>$data['remark'],
                                        'sppsb_id'=>$data['id'],
                                        'updated_by'=>Auth::user()->name,
                               ]);
                    
                        $remark = $data['remark'];
                        $proses = 'Baru';
                         
                  }
                  else
                  {
   //DI GUNAKAN UNTUK AGEN MENGIRIMKAN DATA SB KE STAFF BY EMAIL
                $remark = '';
                $proses = 'Baru';
                $users = User::where('role','SA')->get();
    //            dd($users);
//                foreach($users as $user)
//                {
//                    Mail::to($user->email)->send(new Reminder($data));
//                }
                  }
                   $status=$data['status'];
            }
             elseif($data['status']=='K')    // Status Pengajuan Pada Posisi Staf, akan diajukan ke kabag
            {  
               $sppsb         = Sppsb:: where('id',$data['id'])->first();
               $rate          = $this->setRate($data['id']); 
               $cekResult     = Result::where('sppsb_id',$data['id'])->first();   
               $admin         = $rate['fee_admin']+$rate['materai']; 
              
               $jenis = $this->jenisSppsb($sppsb->jenis_sppsb); 
                
               if ($request->special_rate=="Ya")
                { 
                   $grosIjp = ceil($sppsb->nilai_jaminan*  $request->jml_rate/100);
                   $sevice_charge = (new DireksiController)->pembulatan($grosIjp+$admin) ;
                   ($sevice_charge>$rate['min_biaya'])? $sevice_charge:$sevice_charge=$rate['min_biaya']; 

                    if (!$cekResult)
                    {
                        $this->createResult($data['id'], $sevice_charge, $rate['min_biaya'], $request->jml_rate, $rate['fee_agen'],$rate['fee_admin'],$rate['materai']);
    //                    $this->createResult($data['id'], $sevice_charge, $rate['min_biaya'], $rate['rate_ijp'], $rate['fee_agen'],$rate['fee_admin'],$rate['materai']);
                         $tabel= Sppsb:: where('id',$data['id'])  
                                          -> update([ 
                                              'referensi'=>$request->referensi,
                                              'special_rate'=> $request->special_rate,
                                              'original_rate'=>$rate['rate_ijp']]);

                    }            
                }
                else if ($request->special_rate=="Tidak")
                { 
                    $sevice_charge     = (new DireksiController)->pembulatan(ceil($request->service_charge)); 
                    if (!$cekResult)
                    {  
                        $ijpGross = $sevice_charge-($rate['fee_admin']+$rate['materai']);
                        $nilairate = $ijpGross/$sppsb->nilai_jaminan*100;
                                
//                        dd($nilairate);
                          ($sevice_charge>$rate['min_biaya'])? $sevice_charge:$sevice_charge=$rate['min_biaya']; 
                         $this->createResult($data['id'], $sevice_charge, $rate['min_biaya'], $nilairate, $rate['fee_agen'],$rate['fee_admin'],$rate['materai']);
    //                    $this->createResult($data['id'], $sevice_charge, $rate['min_biaya'], $rate['rate_ijp'], $rate['fee_agen'],$rate['fee_admin'],$rate['materai']);
                          $tabel= Sppsb:: where('id',$data['id'])  
                                          -> update([ 
                                              'referensi'=>$request->referensi,
                                              'special_rate'=> $request->special_rate,
                                              'original_rate'=>$rate['rate_ijp']]); 
                    }        
                }
                else
                {
                     if (!$cekResult)
                    {
                        $grosIjp           = (new DireksiController)->pembulatan(ceil($sppsb->nilai_jaminan * $rate['rate_ijp']/100));
                        $sevice_charge     = (new DireksiController)->pembulatan($grosIjp+$admin) ;
                        ($sevice_charge>$rate['min_biaya'])? $sevice_charge:$sevice_charge=$rate['min_biaya']; 
                        // dd($sevice_charge);
                         $this->createResult($data['id'], $sevice_charge, $rate['min_biaya'], $rate['rate_ijp'], $rate['fee_agen'],$rate['fee_admin'],$rate['materai']);
                      }                  
                } 
             
                $remark = $data['remark']; 
                $proses = 'Kabag';
                $cekAnalisa = Analisa::where('sppsb_id',$data['id'])->count();
//               dd($data);
                if($cekAnalisa<1)
                {
                       $analisa= Analisa::create([
                            'analisa_staff'=>$dataDeskripsi,
                            'rekomendasi'=>$data['remark'],
                            'sppsb_id'=>$data['id'],
                            'created_by'=>Auth::user()->name,
                       ]);
                }
                else
                {
                    $cekAnalisa = Analisa::where('sppsb_id',$data['id'])->first();
                    if($request->deskripsi[0]==""){
                        $dataDeskripsi = $cekAnalisa->analisa_staff;
                    }
                    
                    if($data['remark']==""){
                        $datarekomendasi = $cekAnalisa->rekomendasi;
                    }else{
                        $datarekomendasi=$data['remark'];
                    }
                    
                        Analisa::where('sppsb_id',$data['id'])
                            -> update([ 
                                         'analisa_staff'=>$dataDeskripsi,
                                         'rekomendasi'=>$datarekomendasi
                               ]);
                }
                $status=$data['status'];
              
                  //telegram Notification Kabag
                                 $jenis = $this->jenisSppsb($sppsb->jenis_sppsb); 
                                $hostname =$_SERVER['SERVER_NAME'];
                                $url = 'https://'.$hostname.'/sppsb-detail-staff/'.$sppsb->id;
                                $pesan = "$sppsb->id - Dear Kabag, terdapat satu pengajuan JAMINAN $jenis  "
                                        . "dari $sppsb->nama_kontraktor dengan nilai jaminan Rp. ".number_format($sppsb->nilai_jaminan, 2,",",".") 
                                        ." untuk memproses silahkan klik link di bawah : ";

                                $this->sendMessageTelegramBot($pesan, "887489020",$url);
                
            }
             elseif($data['status']=='I') // Status Pengajuan Lanjutan, Dari Kabag -> Direktur
            { 
                    //DI GUNAKAN UNTUK KABAG  MENGIRIMKAN DATA SB KE DIREKTUR
                    $sppsb      = Sppsb::findOrFail($data['id']);  
                    if( $sppsb->nilai_jaminan<=50000000) //limit kabag penjaminan untuk memutus berdasarkan SK Penjaminan
                    {
                         $type         = jenisSppsbCode($sppsb->jenis_sppsb); 
                         $agen        = Agen::where('user_id',$sppsb->user_id)
                                             ->leftjoin('users','users.id','agens.user_id') 
                                             ->first(); 
                          $lastNo = DB::table('sppsb')->select('no_jaminan as lastno')
                                       ->leftJoin('historys','historys.sppsb_id','=','sppsb.id')
                                       ->where(\DB::raw("(DATE_FORMAT(historys.updated_at,'%Y'))"), date('Y'))
                                       ->where('user_id',$agen->user_id)
                                       ->where('status','C') 
                                       ->take(1)
                                       ->orderBy('historys.updated_at','desc')
                                       ->first();
                      if($lastNo==null){
                           $nourutsertifikat=0;
                     }else{
                         $nourutsertifikat= explode(".",$lastNo->lastno);
                         $nourutsertifikat=$nourutsertifikat[1];
                     } 
                      
                              
         
                  if($agen->jabatan=='Staff')
                     {
                         //ketentutan penomoran sertifikat jika yang menginput staff   
                         $lastNo = DB::table('sppsb')->select('no_jaminan as lastno')
                                           ->leftJoin('historys','historys.sppsb_id','=','sppsb.id')
                                           ->where(\DB::raw("(DATE_FORMAT(historys.updated_at,'%Y'))"), date('Y'))
                                           ->where('user_id',$agen->user_id)
                                           ->where('status','C') 
                                           ->take(1)
                                           ->orderBy('historys.updated_at','desc')
                                           ->first(); 

                         if($lastNo==null){
                               $nourutsertifikat=0;
                         }else{
                             //  $nourutsertifikat=substr($lastNo->lastno,3,3);
                               $nourutsertifikat= explode(".",$lastNo->lastno);
                         }


                       if($nourutsertifikat[1]==null){
                           $nourutsertifikat=0;
                       }else{
                          $nourutsertifikat=$nourutsertifikat[1];
                       }

                         $koderegistrasibank=$sppsb->skpd;
                         $nomorurutsertifikat=str_pad(++$nourutsertifikat, 4, '0', STR_PAD_LEFT); 
                         $kodeagen='01';
                         $kodebank='01';
                         $jenispenjaminan=$type;
                         //sistem penomeraan sesuai SKD 
                         $nomor_sertifikat = $koderegistrasibank.'.'.$nomorurutsertifikat.'.'.$jenispenjaminan.'.'.$kodebank.'.'.$kodeagen.'.'.date('m').'.'.date('Y');
                          
                  }
                  else
                   {
                         $wilayah = kodeWilayah($agen->code_wilayah);
                          $kodeagen                     = $agen->no_agen;
                          $kodeDinas                   = '01';
                          $koderegistrasimitra = $wilayah;//--->Penomoran SKPD
                          $jenispenjaminan       = $type;
                          $nomorurutsertifikat =str_pad(++$nourutsertifikat, 4, '0', STR_PAD_LEFT); 
                     //sistem penomeraan sesuai SKD 
                         $nomor_sertifikat = $koderegistrasimitra.'.'.$nomorurutsertifikat.'.'.$jenispenjaminan.'.'.$kodeDinas.'.'.$kodeagen.'.'.date('m').'.'.date('Y');
                    }  
                         //PEMBERIAN NOMOR SERI PADA SERTIFKAT
                            $lastNoSertifikat = DB::table('sppsb')
                                      ->select(DB::raw('MAX(no_sertifikat) as no_reg'))
                                      ->where([['user_id', $sppsb->user_id],['created_at', '>', '2017-06-13']])
                                      ->first(); 
                              $NoSeriSertifikat =str_pad(++$lastNoSertifikat->no_reg, 8, '0', STR_PAD_LEFT);   
                            //jika status terakhirnya Proses, maka akan diberikan nomor sertifikat, agar tidak terdapat dua kali penomoran
                             date_default_timezone_set("Asia/Jakarta");
                             date('Y-m-d H:i:s',strtotime('+1 hour')); 

                  //            dd($data);
                              $remark = $data['remark'];
                              $proses = 'Setuju';
                  //            dd($remark);
                              $rate     = $this->rateIjp($sppsb->waktu_mulai,$sppsb->waktu_selesai,$sppsb->jenis_sppsb,'SPPSB');
                              $agen     = Agen::where('user_id',$sppsb->user_id)->first();
                              $admin    = Option::findOrFail('2');

                              $materai = Option::findOrFail('3');
                              $materai = $materai->value;
                              $serviceCharge = ceil((new DireksiController)->
                                         calculateIjp(
                                                 $sppsb->waktu_mulai,
                                                 $sppsb->waktu_selesai,
                                                 $sppsb->nilai_jaminan,
                                                 $sppsb->jenis_sppsb,
                                                 $admin->value,
                                                 $materai,
                                                 'SPPSB'));
                                 
                                $charge = (new DireksiController)->pembulatan($serviceCharge);
                                $analisa = Analisa::
                                where('sppsb_id', $data['id'])
                                ->update([
                                          'keputusan' => $data['remark'],
                                          'updated_by' => Auth::user()->name,
                                  ]);

                                  $sppsb->no_jaminan           = $nomor_sertifikat;//nomor sertifikat
                                  $sppsb->no_sertifikat        = $NoSeriSertifikat; //nomor seri sertifikat
                                  $sppsb->status               = 'C'; // status sudah ter close
                                  $sppsb->updated_by          = Auth::user()->username;
                                  $sppsb->save();
                                  
                                  $dataSign=[
                                      "nik"=>'5208051004930002',
                                      "passphrase"=> 'Hend!4wandip@'  
                                  ];
                                  //proses ttd dokumen sertifikat
                                 
                                  //$this->signSbFromCloud($data['id'], $dataSign['nik'], $dataSign['passphrase']);
                                   
                                 $status = 'C'; //hanya untuk ngisi variabel status agar tidak error
                                 $proses = 'Kabag'; 
//                                dd($proses);
                                 //email dirut
//                                 Mail::to('hendiawan.dipa@gmail.com')//di isi alamat email dirut
//                                ->cc(['it.dev@jamkridantb.com','direktur@jamkridantb.com']) 
//                                 ->send(new Reminder($sppsb)); 
                                 
                                
                                //telegram Notification
                                $jenis = $this->jenisSppsb($sppsb->jenis_sppsb); 
                                $hostname =$_SERVER['SERVER_NAME'];
                                $url = 'https://'.$hostname.'/cetak-sertifikat-sppsb/'.$sppsb->id;
                                $pesan = "$sppsb->id - Dear Staf, terdapat satu pengajuan JAMINAN $jenis  "
                                        . "dari $sppsb->nama_kontraktor dengan nilai jaminan Rp. ".number_format($sppsb->nilai_jaminan, 2,",",".") 
                                        ." telah diapprov oleh kabag : ";

                                $this->sendMessageTelegramBot($pesan, "887489020",$url);
                               
                    }
                    else
                    {
                     
                         $status = 'I'; //status untuk ke direktur ,"P" untuk ke Dirut
                         $proses = 'Direktur';
                       // Kirim Email Pemberitahuan ke direktur
                         Mail::to('direktur@jamkridantb.com')
                                 ->cc('it.dev@jamkridantb.com') 
                                 ->send(new Reminder($sppsb)); 
                         
                           //telegram Notification for Direksi
                                $hostname =$_SERVER['SERVER_NAME'];
//                                $symbols=array(' ','!','"','#','$','%','&','\'','(',')','*','+',',','-','.','/',':',';','<','>','=','?','@','[',']','\\','^','_','{','}','|','~','`','\r','\n');
//                                $result = str_replace($symbols,'',$sppsb->pemilik_proyek); 
//                                 echo $result;
//                                 dd($data['status']);
                                $jenis = $this->jenisSppsb($sppsb->jenis_sppsb); 
                                $url = 'https://'.$hostname.'/sppsb-detail-direksi/'.$sppsb->id;
                                $pesan = "$sppsb->id - Yth Bapak Direktur, terdapat satu pengajuan JAMINAN $jenis  "
                                        . "dari $sppsb->nama_kontraktor dengan nilai jaminan Rp. ".number_format($sppsb->nilai_jaminan, 2,",",".") 
                                        ." untuk memproses silahkan klik link di bawah ini : ";

                                $this->sendMessageTelegramBot($pesan, "887489020",$url);
                                
                                //telegram Notification for Staf
                    } 
                    //
                
                  
                
                    
                    $remark = $data['remark'];
                     //  $remark = ''; 
                     $analisa= Analisa::where('sppsb_id',$data['id'])
                         -> update([ 
                                     'analisa_kabag'=>$data['remark'],
                                     'sppsb_id'=>$data['id'],
                                     'updated_by'=>Auth::user()->name,
                            ]);   
                        
            } 
            elseif($data['status']=='P') // Status Pengajuan Lanjutan, Dari Direktur -> Dirut
            { 
     //DI GUNAKAN UNTUK STAFF MENGIRIMKAN DATA SB KE DIRUT
//                dd($data);
               $remark = $data['remark'];
            //  $remark = '';
                $proses = 'Proses';
                
                 $analisa= Analisa::
                         where('sppsb_id',$data['id'])
                            -> update([ 
                                        'analisa_direktur'=>$data['remark'],
                                        'sppsb_id'=>$data['id'],
                                        'updated_by'=>Auth::user()->name,
                               ]);
                
//                Mail::to('dirut@jamkridantb.com')
//                Mail::to('hendiawan.dipa@gmail.com')
////                        ->cc('it.dev@jamkridantb.com')
////                        ->cc('indrajamkridantb@gmail.com')
//                        ->send(new Reminder($data));
                 
                 $status=$data['status'];
            }  
            elseif($data['status']=='R') // Status untuk Pengajuan Revisi
            {            
                $remark = $data['remark'];
                $proses = 'Revisi';
                $status=$data['status'];
            }
            elseif($data['status']=='T') // Status untuk Pengajuan Tolak
            {            
                $remark = $data['remark'];
                $proses = 'Tolak';
                $status=$data['status'];
            }
           
            $sppsb                                   = Sppsb::findOrFail($data['id']);
            $sppsb->status                 = $status;
            $sppsb->updated_by    = Auth::user()->username;
            $sppsb->save();
//            dd($data);
                      $history = History::create([
                            'sppsb_id'  => $data['id'],
                            'proses'    => $proses,
                            'author'    => Auth::user()->name,
                            'remark'    => $remark
                        ]); 
                      
                  
        }
      
        if ($data['status'] == 'B') 
        {
                Session::flash('msgupdate', 'SPPSB dengan no registrasi ' . $sppsb->no_registrasi . ' berhasil di kirim ke staff surety bond');
                return redirect('/sppsb-sp3kbg-data-table');
        }   
        else if ($data['status'] == 'E')  
        {
                $session;
                return redirect('/sppsb-cetak-sertifikat');
         } 
         else
         {
//             dd(Auth::user()->jabatan=="Kabag");
                Session::flash('msgupdate', 'SPPSB dengan no registrasi ' . $sppsb->no_registrasi . ' berhasil di update dengan status ' . $proses . '');
                if (Auth::user()->jabatan=="Kabag"){
                        return redirect('/sppsb-sp3kbg-data-table-staff');
                }else{
                     return redirect('/sppsb-sp3kbg-masuk');
                }
//            $redirect =     (Auth::user()->jabatan=="Kabag") ?  return redirect('/sppsb-sp3kbg-data-table-staff'): return redirect('/sppsb-sp3kbg-masuk');
              
    
         }
     
    }

    public function laporan()
    {
        if(Auth::user()->role=='AA')
        {
            $agen = DB::table('users')
                    ->select('users.name','agens.no_agen','agens.code_wilayah','agens.wilayah_agensi')
                    ->leftJoin('agens','agens.user_id','=','users.id')
                    ->where('users.id',Auth::user()->id)
                    ->first();
            return view('agen.laporan',compact('agen'));
        }
        else
        {
            $agen = DB::table('users') 
                    ->where('users.is_active',1)
                    ->whereIn('users.role',['AA','SA']) 
                    ->get();
//            dd($agen);
            return view('staff.laporan',compact('agen'));
        }
    }
    ///report untuk halaman laporan staff dan agen
    public function getDataReportAgen()
    {

        $id         = $_GET['id'];
        $startDate  = $_GET['startDate'];
        $endDate  = $_GET['endDate'];
 
//        dd($id);       
        if($startDate=="01-" || $endDate=="01-"){
            /*$sppsb = DB::table(DB::raw('v_report_sppsb, (SELECT @rownum := 0) r'))
                        ->select('v_report_sppsb.*', DB::raw('@rownum := @rownum + 1 AS rank'))->where('user_id',$id);
            $report = DB::table(DB::raw('v_report_sp3kbg, (SELECT @rownum := 0) r'))
                        ->select('v_report_sp3kbg.*', DB::raw('@rownum := @rownum + 1 AS rank'))->where('user_id',$id)->union($sppsb)->get();*/
          
                   $sppsb = DB::table('v_report_sppsb')
                                        ->select('v_report_sppsb.*')
                                       ->where('v_report_sppsb.status','C')  
                                       ->where('user_id', $id);
                    $report = DB::table('v_report_sp3kbg')
                                      ->select('v_report_sp3kbg.*')
                                      ->where('user_id', $id)
                                      ->union($sppsb)->get();
          
         
        }else{            
            $startDate  = date('Y-m-d', strtotime($_GET['startDate']));
            $endDate    = date('Y-m-d', strtotime($_GET['endDate'])); 
//            $startDate  = Carbon::parse($startDate1)->startOfMonth();
//            $endDate  = Carbon::parse($endDate1)->endOfMonth();

            /*$sppsb = DB::table(DB::raw('v_report_sppsb, (SELECT @rownum := 0) r'))
                        ->select('v_report_sppsb.*', DB::raw('@rownum := @rownum + 1 AS rank'))
                        ->where('user_id',$id)
                        ->whereBetween('created_at',[$startDate,$endDate]);
            $report = DB::table(DB::raw('v_report_sp3kbg, (SELECT @rownum := 0) r'))
                        ->select('v_report_sp3kbg.*', DB::raw('@rownum := @rownum + 1 AS rank'))
                        ->where('user_id',$id)
                        ->whereBetween('created_at',[$startDate,$endDate])->union($sppsb)->get();*/
              if ($id == 'all') {

                $sppsb = DB::table('v_report_sppsb')
                                ->select('v_report_sppsb.*')
                               ->where('v_report_sppsb.status','C')  
                               ->whereBetween('updated_at', [$startDate, $endDate]);
                $report = DB::table('v_report_sp3kbg')
                                ->select('v_report_sp3kbg.*')
                                 ->whereBetween('updated_at', [$startDate, $endDate])
                                ->union($sppsb)->get();
            } else {
                $sppsb = DB::table('v_report_sppsb')
                        ->select('v_report_sppsb.*')
                        ->where('v_report_sppsb.status','C')  
                        ->where('user_id', $id)
                        ->whereBetween('updated_at', [$startDate, $endDate]);
                $report = DB::table('v_report_sp3kbg')
                                ->select('v_report_sp3kbg.*')
                                ->where('user_id', $id)
                                ->whereBetween('updated_at', [$startDate, $endDate])
                                ->union($sppsb)
                                ->get();
            }
        }
        
        return Datatables::of($report)
            ->editColumn('id', function ($report) {
                return $report->id;
            })
            ->editColumn('nama', function ($report) {
                return $report->nama;
            })
            ->editColumn('created_at', function ($report) {
                return Carbon::parse($report->created_at)->format('d/m/Y');
            })
            ->editColumn('bulat_ijp', function ($report) {
                return number_format($report->bulat_ijp, 2,",",".");
            })
        
            ->editColumn('mulai', function ($report) {
                return $report->mulai;
            })
                ->editColumn('waktu_selesai', function ($report) {
               return $report->akhir;
            })
            
            ->editColumn('gross_ijp', function ($report) {
                return number_format($report->gross_ijp, 2,",",".");
            })
            ->editColumn('fee_agen', function ($report) {
                return number_format($report->fee_agen, 2,",",".");
            })
            ->editColumn('net_ijp', function ($report) {
                return number_format($report->net_ijp, 2,",",".");
            })
            ->make(true);
    }
    
     
    public function getDataRekapAgen()
    {
        $startDate  = $_GET['startDate'];
        $endDate  = $_GET['endDate'];

        if($startDate=="" || $endDate==""){

            $sppsb = DB::table('v_status_sppsb')
                            ->select(
                                'v_status_sppsb.type',
                                'v_status_sppsb.name',
                                DB::raw('SUM(v_status_sppsb.count_terbit) AS count_terbit'),
                                DB::raw('SUM(v_status_sppsb.count_belum) AS count_belum'),
                                DB::raw('SUM(v_status_sppsb.gross_ijp) AS gross_ijp'),
                                DB::raw('SUM(v_status_sppsb.fee_admin) AS fee_admin'),
                                DB::raw('SUM(v_status_sppsb.fee_agen) AS fee_agen'),
                                DB::raw('SUM(v_status_sppsb.net_ijp) AS net_ijp')
                            );

            $report = DB::table('v_status_sp3kbg')
                            ->select(
                                'v_status_sp3kbg.type',
                                'v_status_sp3kbg.name',
                                DB::raw('SUM(v_status_sp3kbg.count_terbit) AS count_terbit'),
                                DB::raw('SUM(v_status_sp3kbg.count_belum) AS count_belum'),
                                DB::raw('SUM(v_status_sp3kbg.gross_ijp) AS gross_ijp'),
                                DB::raw('SUM(v_status_sp3kbg.fee_admin) AS fee_admin'),
                                DB::raw('SUM(v_status_sp3kbg.fee_agen) AS fee_agen'),
                                DB::raw('SUM(v_status_sp3kbg.net_ijp) AS net_ijp')
                            )
                            ->union($sppsb)
                            ->get();
        }else{

            $startDate  = date('Y-m-d', strtotime($_GET['startDate']));
            $endDate    = date('Y-m-d', strtotime($_GET['endDate'])); 

            $sppsb = DB::table('v_status_sppsb')
                            ->select(
                                'v_status_sppsb.type',
                                'v_status_sppsb.name',
                                DB::raw('SUM(v_status_sppsb.count_terbit) AS count_terbit'),
                                DB::raw('SUM(v_status_sppsb.count_belum) AS count_belum'),
                                DB::raw('SUM(v_status_sppsb.gross_ijp) AS gross_ijp'),
                                DB::raw('SUM(v_status_sppsb.fee_admin) AS fee_admin'),
                                DB::raw('SUM(v_status_sppsb.fee_agen) AS fee_agen'),
                                DB::raw('SUM(v_status_sppsb.net_ijp) AS net_ijp')
                            )
                            ->whereBetween('v_status_sppsb.created_at',[$startDate,$endDate]);

            $report = DB::table('v_status_sp3kbg')
                            ->select(
                                'v_status_sp3kbg.type',
                                'v_status_sp3kbg.name',
                                DB::raw('SUM(v_status_sp3kbg.count_terbit) AS count_terbit'),
                                DB::raw('SUM(v_status_sp3kbg.count_belum) AS count_belum'),
                                DB::raw('SUM(v_status_sp3kbg.gross_ijp) AS gross_ijp'),
                                DB::raw('SUM(v_status_sp3kbg.fee_admin) AS fee_admin'),
                                DB::raw('SUM(v_status_sp3kbg.fee_agen) AS fee_agen'),
                                DB::raw('SUM(v_status_sp3kbg.net_ijp) AS net_ijp')
                            )
                            ->whereBetween('v_status_sp3kbg.created_at',[$startDate,$endDate])
                            ->union($sppsb)
                            ->get();
        }

        return Datatables::of($report)
            ->editColumn('gross_ijp', function ($report) {
                return number_format($report->gross_ijp, 2,",",".");
            })
            ->editColumn('fee_admin', function ($report) {
                return number_format($report->fee_admin, 2,",",".");
            })
            ->editColumn('fee_agen', function ($report) {
                return number_format($report->fee_agen, 2,",",".");
            })
            ->editColumn('net_ijp', function ($report) {
                return number_format($report->net_ijp, 2,",",".");
            })
            ->make(true);
    }

    public function getDataRekapWilayah()
    {
        $startDate  = $_GET['startDate'];
        $endDate  = $_GET['endDate'];

        if($startDate=="" || $endDate==""){
            $sppsb = DB::table('v_status_sppsb')
                            ->select(
                                DB::raw('"sppsb" AS type'),
                                'v_status_sppsb.wilayah_agensi',
                                DB::raw('SUM(v_status_sppsb.count_terbit) AS count_terbit'),
                                DB::raw('SUM(v_status_sppsb.count_belum) AS count_belum'),
                                DB::raw('SUM(v_status_sppsb.gross_ijp) AS gross_ijp'),
                                DB::raw('SUM(v_status_sppsb.fee_admin) AS fee_admin'),
                                DB::raw('SUM(v_status_sppsb.fee_agen) AS fee_agen'),
                                DB::raw('SUM(v_status_sppsb.net_ijp) AS net_ijp')
                            )
                            ->groupBy('v_status_sppsb.wilayah_agensi');

            $report = DB::table('v_status_sp3kbg')
                            ->select(
                                DB::raw('"sp3kbg" AS type'),
                                'v_status_sp3kbg.wilayah_agensi',
                                DB::raw('SUM(v_status_sp3kbg.count_terbit) AS count_terbit'),
                                DB::raw('SUM(v_status_sp3kbg.count_belum) AS count_belum'),
                                DB::raw('SUM(v_status_sp3kbg.gross_ijp) AS gross_ijp'),
                                DB::raw('SUM(v_status_sp3kbg.fee_admin) AS fee_admin'),
                                DB::raw('SUM(v_status_sp3kbg.fee_agen) AS fee_agen'),
                                DB::raw('SUM(v_status_sp3kbg.net_ijp) AS net_ijp')
                            )
                            ->groupBy('v_status_sp3kbg.wilayah_agensi')->union($sppsb)->get();
        }else{

            $startDate  = date('Y-m-d', strtotime($_GET['startDate']));
            $endDate    = date('Y-m-d', strtotime($_GET['endDate'])); 

            $sppsb = DB::table('v_status_sppsb')
                            ->select(
                                DB::raw('"sppsb" AS type'),
                                'v_status_sppsb.wilayah_agensi',
                                DB::raw('SUM(v_status_sppsb.count_terbit) AS count_terbit'),
                                DB::raw('SUM(v_status_sppsb.count_belum) AS count_belum'),
                                DB::raw('SUM(v_status_sppsb.gross_ijp) AS gross_ijp'),
                                DB::raw('SUM(v_status_sppsb.fee_admin) AS fee_admin'),
                                DB::raw('SUM(v_status_sppsb.fee_agen) AS fee_agen'),
                                DB::raw('SUM(v_status_sppsb.net_ijp) AS net_ijp')
                            )
                            ->whereBetween('v_status_sppsb.created_at',[$startDate,$endDate])
                            ->groupBy('v_status_sppsb.wilayah_agensi');

            $report = DB::table('v_status_sp3kbg')
                            ->select(
                                DB::raw('"sp3kbg" AS type'),
                                'v_status_sp3kbg.wilayah_agensi',
                                DB::raw('SUM(v_status_sp3kbg.count_terbit) AS count_terbit'),
                                DB::raw('SUM(v_status_sp3kbg.count_belum) AS count_belum'),
                                DB::raw('SUM(v_status_sp3kbg.gross_ijp) AS gross_ijp'),
                                DB::raw('SUM(v_status_sp3kbg.fee_admin) AS fee_admin'),
                                DB::raw('SUM(v_status_sp3kbg.fee_agen) AS fee_agen'),
                                DB::raw('SUM(v_status_sp3kbg.net_ijp) AS net_ijp')
                            )
                            ->whereBetween('v_status_sp3kbg.created_at',[$startDate,$endDate])
                            ->groupBy('v_status_sp3kbg.wilayah_agensi')->union($sppsb)->get();
        }
        
        return Datatables::of($report)
            ->editColumn('gross_ijp', function ($report) {
                return number_format($report->gross_ijp, 2,",",".");
            })
            ->editColumn('fee_admin', function ($report) {
                return number_format($report->fee_admin, 2,",",".");
            })
            ->editColumn('fee_agen', function ($report) {
                return number_format($report->fee_agen, 2,",",".");
            })
            ->editColumn('net_ijp', function ($report) {
                return number_format($report->net_ijp, 2,",",".");
            })
            ->make(true);
    }

    public function getDataBlmTerbit()
    {
        $id         = $_GET['id'];

        $sppsb     = DB::table(DB::raw('sppsb, (SELECT @rownum := 0) r'))
                        ->select('sppsb.id','sppsb.no_registrasi', DB::raw('"sppsb" AS type'), DB::raw('@rownum := @rownum + 1 AS rank'))
                        ->where('sppsb.user_id',$id)
                        ->whereIn('sppsb.status',['D','B','P','R']);
        $report     = DB::table(DB::raw('sp3kbg, (SELECT @rownum := 0) r'))
                        ->select('sp3kbg.id','sp3kbg.no_registrasi', DB::raw('"sp3kbg" AS type'), DB::raw('@rownum := @rownum + 1 AS rank'))
                        ->where('sp3kbg.user_id',$id)
                        ->whereIn('sp3kbg.status',['D','B','P','R'])->union($sppsb)->get();


        return Datatables::of($report)
            ->addColumn('action', function ($report) {
                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="'.$report->type.'-detail/'.$report->id.'" class="icon-button icon-color-grey">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>';
            })
            ->make(true);
    }

    public function getRate($date1,$date2,$id){
        $d1 = strtotime($date1);
        $d2 = strtotime($date2);
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $month = 1;
        $rateIjp = '0';
        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) { 
            $month++;
        }
        $rate = RateSppsb::findOrFail($id);
      
        
        if($month<=3){
            $rateIjp = $rate->tiga;  
        }elseif($month==4){
            $rateIjp = $rate->empat;
        }elseif($month==5){
            $rateIjp = $rate->lima;
        }elseif($month==6){
            $rateIjp = $rate->enam;
        }elseif($month==7){
            $rateIjp = $rate->tujuh;
        }elseif($month==8){
            $rateIjp = $rate->delapan;
        }elseif($month==9){
            $rateIjp = $rate->sembilan;
        }elseif($month==10){
            $rateIjp = $rate->sepuluh;
        }elseif($month==11){
            $rateIjp = $rate->sebelas;
        }elseif($month==12){
            $rateIjp = $rate->duabelas;
        } else if($month==13){
            $rateIjp = $rate->tigabelas;
        } else if($month==14){
               $rateIjp = $rate->empatbelas;
        } else if($month==15){
             $rateIjp = $rate->limabelas;
        } else if($month==16){
             $rateIjp = $rate->enambelas;
        } else if($month==17){
            $rateIjp = $rate->tujuhbelas;
        } else if($month==18){
              $rateIjp = $rate->delapanbelas;
        } else if($month==19){
             $rateIjp = $rate->sembilanbelas;
        } else if($month==20){
            $rateIjp = $rate->duapuluh;
        } else if($month==21){
            $rateIjp = $rate->duasatu;
        } else if($month==13){
              $rateIjp = $rate->duadua;
        } else if($month==22){
             $rateIjp = $rate->duatiga;
        } else if($month==23){
          $rateIjp = $rate->duabelas;
        } else if($month==24){
              $rateIjp = $rate->duaempat;
        } else if($month==25){
             $rateIjp = $rate->dualima;
        } 
//       dd($month);
        return $rateIjp;
    }

    /// fungsi konversi angka ke terbilang
//    function terbilang($x)
//    {
//        
//      $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
//      if ($x < 12)
//        return " " . $abil[$x];
//      elseif ($x < 20)
//        return $this->terbilang($x - 10) . " belas";
//      elseif ($x < 100)
//        return $this->terbilang($x / 10) . " puluh" . $this->terbilang($x % 10);
//      elseif ($x < 200)
//        return " seratus" . $this->terbilang($x - 100);
//      elseif ($x < 1000)
//        return $this->terbilang($x / 100) . " ratus" . $this->terbilang($x % 100);
//      elseif ($x < 2000)
//        return " seribu" . $this->terbilang($x - 1000);
//      elseif ($x < 1000000)
//        return $this->terbilang($x / 1000) . " ribu" . $this->terbilang($x % 1000);
//      elseif ($x < 1000000000)
//        return $this->terbilang($x / 1000000) . " juta" . $this->terbilang($x % 1000000);
//      elseif ($x < 1000000000000)
//        return $this->terbilang($x / 1000000000) . " milyar" . $this->terbilang(fmod($x,1000000000));
//     
//    }
    
    
    function konversi($x) {

        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";

        if ($x < 12) {
            $temp = " " . $angka[$x];
        } else if ($x < 20) {
            $temp = $this->konversi($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = $this->konversi($x / 10) . " puluh" . $this->konversi($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . $this->konversi($x - 100);
        } else if ($x < 1000) {
            $temp = $this->konversi($x / 100) . " ratus" . $this->konversi($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . konversi($x - 1000);
        } else if ($x < 1000000) {
            $temp = $this->konversi($x / 1000) . " ribu" . $this->konversi($x % 1000);
        } else if ($x < 1000000000) {
            $temp = $this->konversi($x / 1000000) . " juta" . $this->konversi($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = $this->konversi($x / 1000000000) . " milyar" . $this->konversi($x % 1000000000);
        }

        return $temp;
    }

    function tkoma($x) {
  
     
        $str = stristr($x, ".");
        $ex = explode('.', $x);
       
          
//        echo $ex[1];
//        dd($ex[1]);
//     echo $ex[1] ;
            if(isset($ex[1])){
            $nilai = $ex[1] / 10;
            if ($nilai >= 1) {
                $a = abs($ex[1]);
            }else{
                 $a = 0;
            }
            
//dd($x);

            $string = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";

            $a2 = $ex[1] / 10;
            $pjg = strlen($str);
            $i = 1;


            if ($a >= 1 && $a < 12) {
                $temp .= " " . $string[$a];
            } else if ($a > 12 && $a < 20) {
                $temp .= $this->konversi($a - 10) . " ";
            } else if ($a > 20 && $a < 100) {
                $temp .= $this->konversi($a / 10) . " " . $this->konversi($a % 10);
            } else {
                if ($a2 < 1) {

                    while ($i < $pjg) {
                        $char = substr($str, $i, 1);
                        $i++;
                        $temp .= " " . $string[$char];
                    }
                }
            } 
             return $temp;
        }
       
    }

    function terbilang($x) {
        if ($x < 0) {
            $hasil = "minus " . trim(konversi(x));
        } else {
            $poin = trim($this->tkoma($x));
            $hasil = trim($this->konversi($x));
        }

        if ($poin) {
            $hasil = $hasil . " " . $poin." Sen";
        } else {
            $hasil = $hasil." ";
        }
        return $hasil;
    }
    
    
    public function rateIjp($date1,$date2,$jenis,$type){
        $d1 = strtotime($date1);
        $d2 = strtotime($date2);
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $month = 1;
        $rateIjp = 0;
        $minBiaya = 0;
        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
            $month++;
        }

        if($type=='SPPSB'){
          $rates = RateSppsb::all();
        }else{
          $rates = RateSp3kbg::all();  
        } 
        foreach ($rates as $key => $rate) {
          # code...
            if($rate->id == $jenis){
                if($month<=3){
                  $rateIjp = $rate->tiga;  
                }elseif($month==4){
                  $rateIjp = $rate->empat;
                }elseif($month==5){
                  $rateIjp = $rate->lima;
                }elseif($month==6){
                  $rateIjp = $rate->enam;
                }elseif($month==7){
                  $rateIjp = $rate->tujuh;
                }elseif($month==8){
                  $rateIjp = $rate->delapan;
                }elseif($month==9){
                  $rateIjp = $rate->sembilan;
                }elseif($month==10){
                  $rateIjp = $rate->sepuluh;
                }elseif($month==11){
                  $rateIjp = $rate->sebelas;
                }elseif($month==12){
                  $rateIjp = $rate->duabelas;
                }
                $minBiaya = $rate->min_biaya;
            }
        }
        return array('minBiaya'=>$minBiaya, 'rateIjp'=>$rateIjp);
    }
    
public function signSbFromCloud($sppsb_id,$nik,$passphrase){
 
        $url      = "https://sign.jamkridantb.com/proses-sign-sb"; 
        $headers  = [
                "Accept: application/json",
                "Authorization: Bearer allahuakbar",
        ];
         $data  =[
                "sppsb_id"=>$sppsb_id,
                "nik"=>$nik,
                "passphrase"=>$passphrase,
         ];
            
        $curl           = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
        $resp = curl_exec($curl);
        curl_close($curl); 
        // konversi json ke array
        $ArraySign     = json_decode($resp, true); 
        // konversi array ke object
        $ObjectSign = (object) $ArraySign; 
        
        //    echo $resp;
       // print_r($ObejctSertifikat->nama);
         print_r($ObjectSign);
       
    }
    
public function  sendMessageTelegramBot($pesan,$chat_id,$url){
        
    if(isset($chat_id)) {$chat_id;}else{$chat_id="887489020";}
    
//    $token = "1977822334:AAEXQuaqFh10uV-r0PebN9chDZ2NrhlWiRQ"; // token bot jamkridantb
        $token = "5361719578:AAHdgaUOFME55hLtRvLuBrrkPwwPf1yA4Bc"; // token bot suretybond
        $data = [
            'text' => "$pesan",
//            'chat_id' => '887489020'  //contoh bot, chat_id Telegram Hendiawan Dipa
               'chat_id' => "$chat_id"   
        ];
        $data = file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data).'&reply_markup={"inline_keyboard":[[{"text":"Press here to open URL","url":"'.$url.'"}]]}');
//        dd($data);
//        file_get_contents($boturl.'/sendmessage?chat_id='.$chat_id.'&text='.$c.'&reply_markup={"inline_keyboard":[[{"text":"Press here to open URL","url":"https://example.com"}]]}');

    }    

function jenisSppsb($type){
  switch ($type) {
    case 1:
      return 'PENAWARAN';
      break;
    case 2:
      return 'PELAKSANAAN';
      break;
    case 3:
      return 'UANG MUKA';
      break;
    case 4:
      return 'PEMELIHARAAN';
      break;
    case 5:
      return 'PEMBAYARAN';
      break;
    default:
      return '00';
      break;
  }
}    
}
