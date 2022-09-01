<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Datatables;
use App\Sppsb;
use App\Sp3kbg;
use App\Bank;
use App\History;
use App\Result;
use App\Option;
use App\RateSppsb;
use App\RateSp3kbg;
use App\Agen;
use App\User;
use Mail;
use App\Mail\Reminder;
use Carbon\Carbon;
use App\Http\Controllers\SppsbController;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Analisa;
 
class DireksiController extends Controller
{
    /**
	* Create a new controller instance.
	*
	* @return void
	*/
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:direksi');
    }

    public function getLayakSppsbTable()
    {
        
        $jabatan = Auth::user()->keterangan;  
    	$sppsb = DB::
//              connection('KONEKSIWEB')//KONEKSI KE WEB
                  table('sppsb')
                ->select('sppsb.id',
                        'sppsb.nama_kontraktor',
                        'sppsb.direksi',
                        'sppsb.jenis_sppsb',
                        DB::raw("(DATE_FORMAT(sppsb.created_at,'%d/%m/%Y')) AS tgl_pengajuan"),
                        'users.jabatan',
                        'users.name'
                )
                ->leftJoin('users','users.id','=','sppsb.user_id')
                ->where([
                    $jabatan=="Direktur"?['sppsb.status','=','I']:['sppsb.status','=','P']
                 ])
                ->orderBy('sppsb.created_at','DESC')
                ->get();
//dd($sppsb);
            return Datatables::of($sppsb)
                ->addColumn('action', function ($sppsb) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sppsb-detail-direksi/'.$sppsb->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                            </div>';
                })
                ->make(true);
    }

    public function getLayakSp3kbgTable()
    {
        $sp3kbg = DB::table('sp3kbg')
                ->select('sp3kbg.id',
                        'banks.name AS nama_bank',
                        'banks.address',
                        'banks.wilayah',
                        'sp3kbg.direksi',
                        'sp3kbg.jenis_sp3kbg',
                        DB::raw("(DATE_FORMAT(sp3kbg.created_at,'%d/%m/%Y')) AS tgl_pengajuan"),
                        'users.jabatan',
                        'users.name'
                )
                ->leftJoin('users','users.id','=','sp3kbg.user_id')
                ->leftJoin('banks','banks.id','=','sp3kbg.bank_id')
                ->where('sp3kbg.status','=','P')
                ->orderBy('sp3kbg.created_at','DESC')
                ->get();

            return Datatables::of($sp3kbg)
                ->addColumn('action', function ($sp3kbg) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sp3kbg-detail-direksi/'.$sp3kbg->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                            </div>';
                })
                ->make(true);
    }

    public function detailSppsb($id)
    { 
//        $sppsb = DB::connection('KONEKSIWEB')
        $sppsb = DB::table('sppsb')
                ->select('*','sppsb.id')
                ->leftjoin('historys','historys.sppsb_id','sppsb.id')
                ->leftjoin('history_penjaminans','history_penjaminans.sppsb_id','=','sppsb.id')
                ->leftjoin('results','results.sppsb_id','=','sppsb.id')
                ->orderby('historys.id','desc')
                ->where('sppsb.id',$id)->first();    
//    dd($sppsb);
        //$template = DB::table('templates')
                    //->select('id','ttd',DB::raw("(DATE_FORMAT(created_at,'%d/%m/%Y %H:%i:%s')) AS create_date"))->first();
        
          $data_kontraktor = Sppsb::where('nama_kontraktor', $sppsb->nama_kontraktor) 
                            ->whereNotIn('id',[$sppsb->id])
                            ->orderBy('tgl_dokumen','Asc')
                            ->get(); 
//          dd($sppsb->nama_kontraktor);
//              DD($data_kontraktor);
        $ttd = DB::table('options')
                        ->select('id','title','value',DB::raw("(DATE_FORMAT(created_at,'%d/%m/%Y %H:%i:%s')) AS created_date"))
                        ->where('title','ttd')->first();

        //$selisih = ((abs(strtotime ($sppsb->waktu_mulai) - strtotime ($sppsb->waktu_selesai)))/(60*60*24));
        $selisih = ucwords((new SppsbController)->terbilang($sppsb->durasi));
        $nilaiProyek = ucwords((new SppsbController)->terbilang($sppsb->nilai_proyek));
        $nilaiJaminan = ucwords((new SppsbController)->terbilang($sppsb->nilai_jaminan));

         $admin = DB::
                table('options')
                ->where('id','2')
                ->first();   
       
//        $materai = DB::connection('KONEKSIWEB')//KONEKSI KE WEB
        $materai = DB::
                table('options')
                ->where('id','3')
                ->first();  
//        dd($materai->value);
         
        
//      dd($sppsb);
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
          
            $serviceCharge = ceil((new DireksiController)->calculateIjp($sppsb->waktu_mulai,$sppsb->waktu_selesai,$sppsb->nilai_jaminan,$sppsb->jenis_sppsb,$admin->value,$materai->value,'SPPSB'));
            $charge = (new DireksiController)->pembulatan($serviceCharge);

            $rate = getRate($sppsb->waktu_mulai, $sppsb->waktu_selesai, $sppsb->jenis_sppsb);
            $fee = $agen->fee_sppsb;
            $feeAdmin = $admin->value; 
            $dokPendukung = json_decode($sppsb->dokumen_pendukung);
            $pengalamanKontraktor = json_decode($sppsb->pengalaman_kontraktor);
            $brgAgunan = json_decode($sppsb->barang_agunan);
            $materai = $materai->value;
            $grossIjp = ($sppsb->nilai_jaminan*$rate)/100;
            $feeAgen = ($grossIjp*$fee)/100;
           $pengalamanKontraktor = json_decode($sppsb->pengalaman_kontraktor);
           
            $analisa = Analisa::where('sppsb_id',$id)->first();
//            DD($id);
            $hasilAnalisa = json_decode($analisa->analisa_staff); 
//           dd($analisa);
//dd( $brgAgunan);
          
        if($sppsb->status == 'P'||$sppsb->status == 'I'){
            
//            if($sppsb->jenis_sppsb == '1'){
//            	$pathSppsb = 'direksi.sertifikatpenawaran';
//            }elseif($sppsb->jenis_sppsb == '2'){
//            	$pathSppsb = 'direksi.sertifikatpelaksanaan';
//            }elseif($sppsb->jenis_sppsb == '3'){
//            	$pathSppsb = 'direksi.sertifikatuangmuka';
//            }elseif($sppsb->jenis_sppsb == '4'){
//            	$pathSppsb = 'direksi.sertifikatpemeliharaan';
//            }elseif($sppsb->jenis_sppsb == '5'){
//            	$pathSppsb = 'direksi.sertifikatpembayaran';
//            }elseif($sppsb->jenis_sppsb == '6'){
//            	$pathSppsb = 'direksi.sertifikatsanggahbanding';
//            }
            
            $pathSppsb = 'direksi.approvalsb';
//            DD($sppsb);
            return view($pathSppsb, 
                    compact('sppsb',
                    'selisih',
                     'nilaiProyek',
                     'nilaiJaminan',
                     'ttd',
                     'charge',
                     'dokPendukung',
                     'pengalamanKontraktor',
                      'rate',
                       'fee',
                       'agen',
                       'feeAgen',
                       'grossIjp',
                       'materai',
                       'brgAgunan',
                        'analisa',
                       'hasilAnalisa',
                       'data_kontraktor',
                       'feeAdmin'));
        }else{
            return view('errors.permissions', compact('sppsb'));
        }
        
    }

    public function detailSp3kbg($id)
    {
        $sp3kbg = Sp3kbg::findOrFail($id);  
        $agen = DB::table('agens')
                ->select(
                    'agens.no_agen',
                    'agens.wilayah_agensi',
                    'agens.code_wilayah',
                    'agens.fee_sp3kbg',
                    'users.name')
                ->leftJoin('users','users.id','=','agens.user_id')
                ->where('users.id', $sp3kbg->user_id)->first();
        $dokPendukung = json_decode($sp3kbg->dokumen_pendukung);
        $bank = Bank::findOrFail($sp3kbg->bank_id);      
        //$template = DB::table('templates')
                    //->select('id','ttd',DB::raw("(DATE_FORMAT(created_at,'%d/%m/%Y %H:%i:%s')) AS create_date"))->first();
        $ttd = DB::table('options')
                        ->select('id','title','value',DB::raw("(DATE_FORMAT(created_at,'%d/%m/%Y %H:%i:%s')) AS created_date"))
                        ->where('title','ttd')->first();

        //$selisih = ((abs(strtotime ($sppsb->waktu_mulai) - strtotime ($sppsb->waktu_selesai)))/(60*60*24));
        $selisih = ucwords((new SppsbController)->terbilang($sp3kbg->durasi));
        $nilaiProyek = ucwords((new SppsbController)->terbilang($sp3kbg->nilai_proyek));
        $nilaiJaminan = ucwords((new SppsbController)->terbilang($sp3kbg->nilai_jaminan));

        $admin = DB::
                table('options')
                ->where('id','4')
                ->first();   
        $feeAdmin = $admin->value; 
        
//        $materai = DB::connection('KONEKSIWEB')//KONEKSI KE WEB
        $materai = DB::
                table('options')
                ->where('id','3')
                ->first();  
                
           $materai = $materai->value;     
         
        $rate = $this->rateIjp($sp3kbg->waktu_mulai,$sp3kbg->waktu_selesai,$sp3kbg->jenis_sp3kbg,'SP3KBG');
       
        $ijp = ($sp3kbg->nilai_jaminan*$rate['rateIjp'])/100;
        $grossIjp = ($sp3kbg->nilai_jaminan*$rate['rateIjp'])/100;
        
        $serviceCharge = ceil($this->calculateIjp(
            $sp3kbg->waktu_mulai,
            $sp3kbg->waktu_selesai,
            $sp3kbg->nilai_jaminan,
            $sp3kbg->jenis_sp3kbg,
            $admin->value,
            $materai,
            'SP3KBG'));
        $charge = $this->pembulatan($serviceCharge);
        $feeBank = ($ijp*$bank->rate)/100;
       
        $fee = $agen->fee_sp3kbg;
        $feeAgen = ($grossIjp*$fee)/100;
        $brgAgunan = json_decode($sp3kbg->barang_agunan);
         
        if($sp3kbg->status == 'P'){   
//            return view('direksi.sertifikatsp3kbg', compact('sp3kbg','bank','rate','ijp','admin','materai','agen','ttd','serviceCharge','feeBank'));
            return view('direksi.approvalsp3kbg', compact(
                    'sp3kbg',
                    'selisih',
                    'nilaiProyek',
                    'nilaiJaminan',
                    'ttd',
                    'charge',
                    'dokPendukung',
                    'rate',
                    'fee',
                    'agen',
                    'feeAgen',
                    'grossIjp',
                    'materai',
                    'brgAgunan',
                    'bank',
                    'feeAdmin'
                    
                    ));
        }else{
            return view('errors.permissions', compact('sp3kbg'));
        }
    }

//     public function updateSppsb(Request $request)
//    {
//    	$data = $request->all();
//        
//        $sppsb = Sppsb::findOrFail($data['id']);
//     
//        $type = jenisSppsbCode($sppsb->jenis_sppsb);
//   
//        $agen = Agen::where('user_id',$sppsb->user_id)
//                ->leftjoin('users','users.id','agens.user_id') 
//                ->first();
//       
//        
//        $lastNo = DB::table('sppsb')
//                ->select(DB::raw('MAX(no_jaminan) AS lastno'))
//                ->where('no_jaminan','LIKE',$type.'.%.'.$agen->no_agen.'.%.'.Carbon::now()->year.'.%')
//                ->first();
//        $wilayah = kodeWilayah($agen->code_wilayah);
//        //PEMBERIAN NOMOR SERTIFKAT
//          
//        if($agen->jabatan=='Staff')
//        {
//          
//            
//              $lastNo = DB::table('sppsb')->select('no_jaminan as lastno')
//                             ->where('user_id',$agen->user_id)
//                             ->where('status','C') 
//                             ->take(1)
//                              ->orderBy('updated_at','desc')
//                             ->first();
//          
////          $newNo = referenceNo($type,$lastNo->lastno,$agen->no_agen,$wilayah);
//          
//            
//             
//            if($lastNo==null){
//                  $nourutsertifikat=0;
//            }else{
//                //  $nourutsertifikat=substr($lastNo->lastno,3,3);
//                $nourutsertifikat= explode(".",$lastNo->lastno);
//            }
//            
//        
////            if($lastNo->lastno==null){
////                $nourutsertifikat=0;
////            }
//           
//            $koderegistrasibank=$sppsb->skpd;
//            
//          if($nourutsertifikat[1]==null){
//              $nourutsertifikat=0;
//          }else{
//             $nourutsertifikat=$nourutsertifikat[1];
//          }
//             
//            
//            $nomorurutsertifikat=str_pad(++$nourutsertifikat, 4, '0', STR_PAD_LEFT);
//           
//           // dd($nomorurutsertifikat);
//            $kodeagen='01';
//            $kodebank='01';
//            $jenispenjaminan=$type;
//            //sistem penomeraan sesuai SKD
////             dd($nomorurutsertifikat);
//            $newNo = $koderegistrasibank.'.'.$nomorurutsertifikat.'.'.$jenispenjaminan.'.'.$kodeagen.'.'.$kodebank.'.'.date('m').'.'.date('Y');
////          dd($newNo);
//            
//        }
//        else
//        {
//           $newNo = referenceNo($type,$lastNo->lastno,$agen->no_agen,$wilayah);
//        }
////        dd($agen);
//        //PEMBERIAN NOMOR SERI PADA SERTIFKAT
//        $lastNoSertifikat = DB::table('sppsb')
//                     ->select(DB::raw('MAX(no_sertifikat) as no_reg'))
//                     ->where([['user_id', $sppsb->user_id],['created_at', '>', '2017-06-13']])
//                     ->first();
//        //$agen   = DB::table('agens')->select('min_no_reg')->where('user_id',$sppsb->user_id)->first();
//        $newNoSertifikat = incrementValueSertifikat($lastNoSertifikat->no_reg, $agen->min_no_reg);
////        dd($newNoSertifikat);
//        
//        if($data['status']=='C'){
//            $remark = $data['remark'];
//            $proses = 'Setuju';
////            dd($remark);
//            $rate = $this->rateIjp($sppsb->waktu_mulai,$sppsb->waktu_selesai,$sppsb->jenis_sppsb,'SPPSB');
//            $agen = Agen::where('user_id',$sppsb->user_id)->first();
//            $admin = Option::findOrFail('2');
//            $materai = Option::findOrFail('3');
//            //insert result
//            $result = Result::create([
//                'sppsb_id'  => $data['id'],
//                'ttd'       => $data['ttd'],
//                'ttd_type'  => $data['ttd_type'],
//                'service_charge' => $data['charge'],
//                'min_biaya' => $rate['minBiaya'],
//                'rate_ijp'  => $rate['rateIjp'],
//                'fee_agen'  => $agen->fee_sppsb,
//                'fee_admin'  => $admin->value,
//                'materai'   => $materai->value,
//                'author'    => Auth::user()->name
//            ]);
//        }elseif($data['status']=='R'){            
//            $remark = $data['remark'];
//            $proses = 'Revisi';
//        }elseif($data['status']=='T'){            
//            $remark = $data['remark'];
//            $proses = 'Tolak';
//        }
//
//        //insert new history
//        $history = History::create([
//            'sppsb_id'  => $data['id'],
//            'proses'    => $proses,
//            'author'    => Auth::user()->name,
//            'remark'    => $remark
//        ]);
//
//        //update status sppsb
//        $sppsb->no_jaminan      = $newNo;
//        $sppsb->no_sertifikat   = $newNoSertifikat;
//        $sppsb->status          = $data['status'];
//        $sppsb->updated_by      = Auth::user()->username;
//        $sppsb->save();
//
//        /*if($data['status']=='R' || $data['status']=='T' || $data['status']=='S'){
//            $users = User::where('role','SA')->get();
//            foreach($users as $user)
//            {
//                //Mail::to($user->email,$user->name)->send(new Reminder($data));
//            }
//        }
//*/
//        Session::flash('msgupdate','SPPSB dengan no registrasi '.$sppsb->no_registrasi.' berhasil di update dengan status '.$proses.'');
//        return redirect('/home');
//    }
//    
    
    public function updateSppsb(Request $request)
    {
        $data         = $request->all(); 
        $sppsb      = Sppsb::findOrFail($data['id']); 
        $type         = jenisSppsbCode($sppsb->jenis_sppsb); 
        $agen        = Agen::where('user_id',$sppsb->user_id)
                            ->leftjoin('users','users.id','agens.user_id') 
                            ->first(); 
//        $lastNo = DB::table('sppsb')
//                ->select(DB::raw('MAX(no_jaminan) AS lastno'))
//                ->where('no_jaminan','LIKE', $type.'.%.'.$agen->no_agen.'.%.'. Carbon::now()->year.'.%')
//                ->first(); 
//                
//          $lastNo = DB::table('sppsb')->select('no_jaminan as lastno')
//                             ->where('user_id',$agen->user_id)
//                             ->where('status','C') 
//                             ->take(1)
//                             ->orderBy('updated_at','desc')
//                             ->first(); 
          
               $lastNo = DB::table('sppsb')->select('no_jaminan as lastno')
                              ->leftJoin('historys','historys.sppsb_id','=','sppsb.id')
                              ->where(\DB::raw("(DATE_FORMAT(historys.updated_at,'%Y'))"), date('Y'))
                              ->where('user_id',$agen->user_id)
                              ->where('status','C') 
                              ->take(1)
                              ->orderBy('historys.updated_at','desc')
                              ->first();
               
//        dd($lastNo);
//          dd($lastNo); 
            if($lastNo==null){
                  $nourutsertifikat=0;
            }else{
                //  $nourutsertifikat=substr($lastNo->lastno,3,3);
                $nourutsertifikat= explode(".",$lastNo->lastno);
                $nourutsertifikat=$nourutsertifikat[1];
            } 
//                dd($nourutsertifikat);
          
        $wilayah = kodeWilayah($agen->code_wilayah);
        //PEMBERIAN NOMOR SERTIFKAT
          
        if($agen->jabatan=='Staff')
        {
            //ketentutan jika yang menginput staff 
            
            
//            $lastNo = DB::table('sppsb')->select('no_jaminan as lastno')
//                             ->where('user_id',$agen->user_id)
//                             ->where('status','C') 
//                             ->take(1)
//                              ->orderBy('updated_at','desc')
//                             ->first();
            
            $lastNo = DB::table('sppsb')->select('no_jaminan as lastno')
                              ->leftJoin('historys','historys.sppsb_id','=','sppsb.id')
                              ->where(\DB::raw("(DATE_FORMAT(historys.updated_at,'%Y'))"), date('Y'))
                              ->where('user_id',$agen->user_id)
                              ->where('status','C') 
                              ->take(1)
                              ->orderBy('historys.updated_at','desc')
                              ->first();
//        dd($lastNo);
          
//          $newNo = referenceNo($type,$lastNo->lastno,$agen->no_agen,$wilayah);
          
            
//             dd($lastNo);
             
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
//             dd($nomorurutsertifikat);
            $nomor_sertifikat = $koderegistrasibank.'.'.$nomorurutsertifikat.'.'.$jenispenjaminan.'.'.$kodebank.'.'.$kodeagen.'.'.date('m').'.'.date('Y');
      
            
        }
        else
        {
                 $kodeagen                     = $agen->no_agen;
                 $kodeDinas                   = '01';
                 $koderegistrasimitra = $wilayah;//--->Penomoran SKPD
                 $jenispenjaminan       = $type;
                 $nomorurutsertifikat =str_pad(++$nourutsertifikat, 4, '0', STR_PAD_LEFT); 
            //sistem penomeraan sesuai SKD
//             dd($nomorurutsertifikat);
                $nomor_sertifikat = $koderegistrasimitra.'.'.$nomorurutsertifikat.'.'.$jenispenjaminan.'.'.$kodeDinas.'.'.$kodeagen.'.'.date('m').'.'.date('Y');
      
//            $nomor_sertifikat = referenceNo($type,$lastNo->lastno,$agen->no_agen,$wilayah);//pemberian nomor sertifikat jika merupakan agen
//            $nomor_sertifikat = referenceNo($type,$nourutsertifikat,$agen->no_agen,$wilayah);//pemberian nomor sertifikat jika merupakan agen
        }
//            dd($nomor_sertifikat);
//        dd($agen);
        //PEMBERIAN NOMOR SERI PADA SERTIFKAT
           $lastNoSertifikat = DB::table('sppsb')
                     ->select(DB::raw('MAX(no_sertifikat) as no_reg'))
                     ->where([['user_id', $sppsb->user_id],['created_at', '>', '2017-06-13']])
                     ->first();
        //$agen   = DB::table('agens')->select('min_no_reg')->where('user_id',$sppsb->user_id)->first();
//        $NoSeriSertifikat = incrementValueSertifikat($lastNoSertifikat->no_reg, $agen->min_no_reg);
             $NoSeriSertifikat =str_pad(++$lastNoSertifikat->no_reg, 8, '0', STR_PAD_LEFT);   
    
        
        if($data['status']=='C')
        { 
           if( $sppsb->status=='P')
           {
               $this->penomoranSertifikat($sppsb,$data,$nomor_sertifikat,$NoSeriSertifikat);
                  //telegram Notification for Staff
                                $hostname =$_SERVER['SERVER_NAME'];
                                $jenis = (new SppsbController)->jenisSppsb($sppsb->jenis_sppsb); 
                               $url = 'https://'.$hostname.'/cetak-sertifikat-sppsb/'.$sppsb->id;
                               $pesan = "$sppsb->id - Dear Staf, terdapat satu pengajuan JAMINAN $jenis  "
                                        . "dari $sppsb->nama_kontraktor dengan nilai jaminan Rp. ".number_format($sppsb->nilai_jaminan, 2,",",".") 
                                        ." telah diapprov oleh Direktur Utama: ";
                               $notifikasi = (new SppsbController)->sendMessageTelegramBot($pesan, "887489020", $url);//
               
           } 
             $remark = $data['remark'];
             $proses = 'Setuju'; 
             $status = $data['status'];
        }
        elseif($data['status']=='R')
            {            
            $remark = $data['remark'];
            $proses = 'Revisi';
             $status = $data['status'];
        }
        elseif($data['status']=='T')
         {            
            $remark = $data['remark'];
            $proses = 'Tolak'; 
             $status = $data['status'];
        }
        elseif($data['status']=='P')
        {        
            
              $remark = $data['remark'];
            //  $remark = ''; 
            if($sppsb->nilai_jaminan<=200000000)
            { //limit penerbitan sertifikat untuk direktur
                
//                  dd($sppsb);
                    $this->penomoranSertifikat($sppsb,$data,$nomor_sertifikat,$NoSeriSertifikat); // pada method ini status sudah ter close
                    
                    $proses = 'Setuju';
                    $status = "C"; //hanya untuk ngisi variabel status agar tidak error
                          
                             
                   //   $sign = new SppsbController();
                    //  $sign->signSbFromCloud($data['id'], $nik, $passphrase);
                    
                    //memberikan informasi bahwa direktur telah menerbitkan sertifikat
//                       Mail::to('hendiawan.dipa@gmail.com')
//                    ->cc(['it.dev@jamkridantb.com','direktur@jamkridantb.com']) 
//                    ->send(new Reminder($sppsb)); 
                       
                    
        
                               
                                                 //telegram Notification for Staff
                                $hostname =$_SERVER['SERVER_NAME'];
                                $jenis = (new SppsbController)->jenisSppsb($sppsb->jenis_sppsb); 
                                $url = 'https://'.$hostname.'/cetak-sertifikat-sppsb/'.$sppsb->id;
                               $pesan = "Dear Staf, terdapat satu pengajuan JAMINAN $jenis  "
                                        . "dari $sppsb->nama_kontraktor dengan nilai jaminan Rp. ".number_format($sppsb->nilai_jaminan, 2,",",".") 
                                        ." telah diapprov oleh Direktur : ";
                               $notifikasi = (new SppsbController)->sendMessageTelegramBot($pesan, "887489020", $url);//
                               
                               
            }
            else
            {
                   $proses = 'Proses';
                   $status = $data['status'];
                   
                                   //telegram Notification for Direksi
                                $hostname =$_SERVER['SERVER_NAME'];
                                $jenis = (new SppsbController)->jenisSppsb($sppsb->jenis_sppsb); 
                                $url = 'https://'.$hostname.'/sppsb-detail-direksi/'.$sppsb->id;
                                $pesan = "Yth. Bapak Direktur Utama, terdapat satu pengajuan JAMINAN $jenis  "
                                        . "dari $sppsb->nama_kontraktor dengan nilai jaminan Rp. ".number_format($sppsb->nilai_jaminan, 2,",",".") 
                                        ." untuk memproses silahkan klik link di bawah ini : "; 
                               $notifikasi = (new SppsbController)->sendMessageTelegramBot($pesan, "887489020", $url);//
             }
             
             
            
               
            $analisa= Analisa::
                     where('sppsb_id',$data['id'])
                        -> update([ 
                                    'analisa_direktur'=>$data['remark'],
                                    'sppsb_id'=>$data['id'],
                                    'updated_by'=>Auth::user()->name,
                           ]); 
        }

        //insert new history
        $history = History::create([
            'sppsb_id'  => $data['id'],
            'proses'    => $proses,
            'author'    => Auth::user()->name,
            'keterangan'    => Auth::user()->keterangan,
            'remark'    => $remark
        ]);

        //update status sppsb 
//                $sppsb->no_jaminan          = $nomor_sertifikat;//nomor sertifikat
//                $sppsb->no_sertifikat        = $NoSeriSertifikat; //nomor seri sertifikat
         
                $sppsb->status                      = $status;
                $sppsb->updated_by          = Auth::user()->username;
                $sppsb->save();
                


        /*if($data['status']=='R' || $data['status']=='T' || $data['status']=='S'){
            $users = User::where('role','SA')->get();
            foreach($users as $user)
            {
                //Mail::to($user->email,$user->name)->send(new Reminder($data));
            }
        }
*/
        Session::flash('msgupdate','SPPSB dengan no registrasi '.$sppsb->no_registrasi.' berhasil di update dengan status '.$proses.'');
        return redirect('/home');
    }

    public function penomoranSertifikat($sppsb,$data,$nomor_sertifikat,$NoSeriSertifikat)
    {
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
                
//                     if($sppsb->nilai_jaminan>5000000){
//                           $materai = Option::findOrFail('3');
//                     }else{
//                            $materai = 0;
//                     }
                       $materai = Option::findOrFail('3');
                   
                     //insert result
                       
                      $cekResult = Result::where('id',$data['id'])->first();
                     
                      if(!$cekResult){
                       
                          $result = Result::create([
                              'sppsb_id'  => $data['id'],
                              'ttd'       => $data['ttd'],
                              'ttd_type'  => $data['ttd_type'],
                              'service_charge' => $data['charge'],
                              'min_biaya' => $rate['minBiaya'],
                              'rate_ijp'  => $rate['rateIjp'],
                              'fee_agen'  => $agen->fee_sppsb,
                              'fee_admin'  => $admin->value,
                              'materai'   => $materai->value,
                              'author'    => Auth::user()->name
                          ]);    
                          
                      }
                     
 
                           $analisa = Analisa::
                           where('sppsb_id', $data['id'])
                           ->update([
                                     'keputusan' => $data['remark'],
                                     'updated_by' => Auth::user()->name,
                             ]); 
                         $sppsb->no_jaminan          = $nomor_sertifikat;//nomor sertifikat
                         $sppsb->no_sertifikat        = $NoSeriSertifikat; //nomor seri sertifikat
//                         $sppsb->status                      = $data['status'];
                         $sppsb->status                      = 'C';
                         $sppsb->updated_by          = Auth::user()->username;
                         $sppsb->save(); 
    }
    
    public function updateSp3kbg(Request $request)
    {
        $data = $request->all();
        $sp3kbg = Sp3kbg::findOrFail($data['id']);
//        DD($sp3kbg);
        $bank = Bank::findOrFail($sp3kbg->bank_id);  
        $type = jenisSp3kbgCode($sp3kbg->jenis_sp3kbg);
        $agen = Agen::where('user_id',$sp3kbg->user_id)->first();
        $lastNo = DB::table('sp3kbg')->select(DB::raw('MAX(no_jaminan) AS lastno'))->where('no_jaminan','LIKE',$type.'.%.'.$agen->no_agen.'.%.'.Carbon::now()->year.'.%')->first();
//          DD($lastNo);
        $wilayah = kodeWilayah($agen->code_wilayah);
        
        $lastNoSertifikat = DB::table('sp3kbg')
                     ->select(DB::raw('MAX(no_sertifikat) as no_reg'))
                     ->where([['user_id', $sp3kbg->user_id],['created_at', '>', '2017-06-13']])
                     ->first();
        //$agen   = DB::table('agens')->select('min_no_reg')->where('user_id',$sppsb->user_id)->first();
        $newNoSertifikat = incrementValueSertifikat($lastNoSertifikat->no_reg, $agen->min_no_reg);
        
        $newNo = referenceNo($type,$lastNo->lastno,$agen->no_agen,$wilayah);  
        
        if($data['status']=='C'){
            $remark = '';
            $proses = 'Setuju';
            $rate = $this->rateIjp($sp3kbg->waktu_mulai,$sp3kbg->waktu_selesai,$sp3kbg->jenis_sp3kbg,'SP3KBG');
            $agen = Agen::where('user_id',$sp3kbg->user_id)->first();
            $admin = Option::findOrFail('4');
            $materai = Option::findOrFail('3');
            //insert result
            
//            if ($sp3kbg->nilai_jaminan > 5000000) {
//                $materai = Option::findOrFail('3');
//            } else {
//                $materai = 0;
//            }

            $materai = Option::findOrFail('3');
            
            $result = Result::create([
                'sp3kbg_id'  => $data['id'],
                'ttd'       => $data['ttd'],
                'ttd_type'  => $data['ttd_type'],
                'service_charge' => $data['charge'],
                'min_biaya' => $rate['minBiaya'],
                'rate_ijp'  => $rate['rateIjp'],
                'rate_bank'  => $bank->rate,
                'fee_agen'  => $agen->fee_sp3kbg,
                'fee_admin'  => $admin->value,
                'materai'   => $materai->value,
                'author'    => Auth::user()->name
            ]);
        }elseif($data['status']=='R'){            
            $remark = $data['remark'];
            $proses = 'Revisi';
        }elseif($data['status']=='T'){            
            $remark = $data['remark'];
            $proses = 'Tolak';
        }

        //insert new history
        $history = History::create([
            'sp3kbg_id'  => $data['id'],
            'proses'    => $proses,
            'author'    => Auth::user()->name,
            'remark'    => $remark
        ]);

        //update status sp3kbg
        $sp3kbg->no_sertifikat = $newNoSertifikat;
        $sp3kbg->no_jaminan = $newNo;
        $sp3kbg->status = $data['status'];
        $sp3kbg->updated_by = Auth::user()->username;
        $sp3kbg->save();

        /*if($data['status']=='R' || $data['status']=='T' || $data['status']=='S'){
            $users = User::where('role','SA')->get();
            foreach($users as $user)
            {
                Mail::to($user->email,$user->name)->send(new Reminder($data));
            }
        }*/

        Session::flash('msgupdate','SP3KBG dengan no registrasi '.$sp3kbg->no_registrasi.' berhasil di update dengan status '.$proses.'');
        return redirect('/home');
    }

    public function signedUpdate(Request $request)
    {
        $data = $request->all();
        $option = Option::findOrFail($data['id']);
        $option->value = $data['ttd'];
        $option->save();

        Session::flash('msgupdate','Anda telah berhasil melakukan update template tanda tangan');
        return redirect('/home');
    }
    
    public function calculateIjp($date1,$date2,$jaminan,$jenis,$admin,$materai,$type){
//         if ($jaminan > 5000000) {
//            $materai = $materai;
//        } else {
//            $materai = 0;
//        }
//        
            $materai = $materai;
        $d1 = strtotime($date1);
        $d2 = strtotime($date2);
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $month = 1;
        $materaiAdmin = $admin + $materai;
        $biaya = 0;
        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
            $month++;
        }
        if ($type == 'SPPSB') {
            $rates = RateSppsb::all();
        } else {
            $rates = RateSp3kbg::all();
        }
        foreach ($rates as $key => $rate) {
            # code...
            if ($rate->id == $jenis) {
                if ($month <= 3) {
                    $biaya = (($jaminan * $rate->tiga) / 100) + $materaiAdmin;
                } elseif ($month == 4) {
                    $biaya = (($jaminan * $rate->empat) / 100) + $materaiAdmin;
                } elseif ($month == 5) {
                    $biaya = (($jaminan * $rate->lima) / 100) + $materaiAdmin;
                } elseif ($month == 6) {
                    $biaya = (($jaminan * $rate->enam) / 100) + $materaiAdmin;
                } elseif ($month == 7) {
                    $biaya = (($jaminan * $rate->tujuh) / 100) + $materaiAdmin;
                } elseif ($month == 8) {
                    $biaya = (($jaminan * $rate->delapan) / 100) + $materaiAdmin;
                } elseif ($month == 9) {
                    $biaya = (($jaminan * $rate->sembilan) / 100) + $materaiAdmin;
                } elseif ($month == 10) {
                    $biaya = (($jaminan * $rate->sepuluh) / 100) + $materaiAdmin;
                } elseif ($month == 11) {
                    $biaya = (($jaminan * $rate->sebelas) / 100) + $materaiAdmin;
                } elseif ($month == 12) {
                    $biaya = (($jaminan * $rate->duabelas) / 100) + $materaiAdmin;
                }elseif ($month == 13) {
                    $biaya = (($jaminan * $rate->tigabelas) / 100) + $materaiAdmin;
                }elseif ($month == 14) {
                    $biaya = (($jaminan * $rate->empatbelas) / 100) + $materaiAdmin;
                }elseif ($month == 15) {
                    $biaya = (($jaminan * $rate->limabelas) / 100) + $materaiAdmin;
                }elseif ($month == 16) {
                    $biaya = (($jaminan * $rate->enambelas) / 100) + $materaiAdmin;
                }elseif ($month == 17) {
                    $biaya = (($jaminan * $rate->tujuhbelas) / 100) + $materaiAdmin;
                }elseif ($month == 18) {
                    $biaya = (($jaminan * $rate->delapanbelas) / 100) + $materaiAdmin;
                }elseif ($month == 19) {
                    $biaya = (($jaminan * $rate->sembilanbelas) / 100) + $materaiAdmin;
                }elseif ($month == 20) {
                    $biaya = (($jaminan * $rate->duapuluh) / 100) + $materaiAdmin;
                }elseif ($month == 21) {
                    $biaya = (($jaminan * $rate->duasatu) / 100) + $materaiAdmin;
                }elseif ($month == 22) {
                    $biaya = (($jaminan * $rate->duadua) / 100) + $materaiAdmin;
                }elseif ($month == 23) {
                    $biaya = (($jaminan * $rate->duatiga) / 100) + $materaiAdmin;
                }elseif ($month == 24) {
                    $biaya = (($jaminan * $rate->duaempat) / 100) + $materaiAdmin;
                }elseif ($month == 25) {
                    $biaya = (($jaminan * $rate->dualima) / 100) + $materaiAdmin;
                }
                //check biaya minimal
                if ($biaya < $rate->min_biaya) {
                    $biaya = $rate->min_biaya;
                } else {
                    $biaya = $biaya;
                }
            }
        }
        return $biaya;
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
                }elseif($month==12){
                  $rateIjp = $rate->duabelas;
                } else if ($month == 13) {
                      $rateIjp = $rate->tigabelas;
                } else if ($month == 14) {
                     $rateIjp = $rate->empatbelas;
                } else if ($month == 15) {
                  $rateIjp = $rate->limabelas;
                } else if ($month == 16) {
                     $rateIjp = $rate->enambelas;
                } else if ($month == 17) {
                       $rateIjp = $rate->tujuhbelas;
                } else if ($month == 18) {
                       $rateIjp = $rate->delapanbelas;
                } else if ($month == 19) {
                     $rateIjp = $rate->sembilanbelas;
                } else if ($month == 20) {
                       $rateIjp = $rate->duapuluh;
                } else if ($month == 21) {
                       $rateIjp = $rate->duasatu;
                } else if ($month == 22) {
                      $rateIjp = $rate->duadua;
                } else if ($month == 23) {
                     $rateIjp = $rate->duatiga;
                } else if ($month == 24) {
                      $rateIjp = $rate->duaempat;
                } else if ($month == 25) {
                      $rateIjp = $rate->dualima;
                }
                $minBiaya = $rate->min_biaya;
            }
        }
        return array('minBiaya'=>$minBiaya, 'rateIjp'=>$rateIjp);
    }
    
    public function pembulatan($uang){
        $ratusan = substr($uang, -3);
        if($ratusan>0)
            $akhir = $uang + (1000-$ratusan);
        else
            $akhir = $uang;
        return $akhir;
    }
    
    
    function enkripsi( $string )
{
    $output = false;
 
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'bismillahirrahmanirrahim';
    $secret_iv = 'bismillahirrahmanirrahim';
 
    // hash
    $key = hash('sha256', $secret_key);
     
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
 
    return $output;
}
 

   
function dekripsi($string)
{
    $output = false;
 
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'bismillahirrahmanirrahim';
    $secret_iv = 'bismillahirrahmanirrahim';
 
    // hash
    $key = hash('sha256', $secret_key);
     
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
 
    return $output;
}
    
}

