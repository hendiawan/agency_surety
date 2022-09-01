<?php

namespace App\Http\Controllers;

use App\Sppsb;
use App\Sp3kbg;
use App\Result;
use App\Bank;
use App\Agen;
use App\RateSppsb;
use App\RateSp3kbg;
use Auth;
use DB;
use PDF;
use App\Http\Controllers\SppsbController;
use App\Http\Controllers\DireksiController;
use Illuminate\Http\Request;
use App\Analisa;
use App\History;
class ReportController extends Controller
{
	        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('role:agen');
    }

    public function detailSppsb($id)
    {
           $sppsb = Sppsb::
                      select('*','sppsb.created_at as tgl_pengajuan')
               ->leftJoin('users','users.id','=','sppsb.user_id')
              -> findOrFail($id);
           
        $agen = DB::table('agens')
                ->select(
                    'agens.no_agen',
                    'agens.wilayah_agensi',
                    'agens.code_wilayah',
                    'agens.fee_sppsb',
                    'users.name')
                ->leftJoin('users','users.id','=','agens.user_id')
                ->where('users.id', $sppsb['user_id'])->first();
//        dd($agen);
        $dokPendukung = json_decode($sppsb->dokumen_pendukung);
        $brgAgunan = json_decode($sppsb->barang_agunan);
        //$selisih = ((abs(strtotime ($sppsb->waktu_mulai) - strtotime ($sppsb->waktu_selesai)))/(60*60*24)+1);
        $selisih = ucwords((new SppsbController)->terbilang($sppsb->durasi));
        $nilaiProyek = ucwords((new SppsbController)->terbilang($sppsb->nilai_proyek));
        $nilaiJaminan = ucwords((new SppsbController)->terbilang($sppsb->nilai_jaminan));
        $nilaiProyekFormat = number_format($sppsb->nilai_proyek,2,",",".");
        $nilaiJaminanFormat = number_format($sppsb->nilai_jaminan,2,",",".");

        //$serviceCharge = ceil((new DireksiController)->calculateIjp($sppsb->waktu_mulai,$sppsb->waktu_selesai,$sppsb->nilai_jaminan,$sppsb->jenis_sppsb));
        //$charge = (new DireksiController)->pembulatan($serviceCharge);
        //$chargeFormat = number_format($charge,2,",",".");
        
        //$rate = (new SppsbController)->getRate($sppsb->waktu_mulai, $sppsb->waktu_selesai, $sppsb->jenis_sppsb);

		$pdf = PDF::loadView('report.detailsppsb',compact('sppsb','dokPendukung','brgAgunan','selisih','nilaiProyekFormat','nilaiJaminanFormat','nilaiProyek','nilaiJaminan','agen'));
		//$pdf->setPaper('a4', 'landscape');		
		return $pdf->stream('detail.pdf');

		//return view('report.detail',compact('sppsb','dokPendukung','brgAgunan','selisih','nilaiProyekFormat','nilaiJaminanFormat','nilaiProyek','nilaiJaminan','agen'));
		
    }
    
    public function analisaSppsb($id)
    {
//           $sppsb = Sppsb::
//                      select('*','sppsb.created_at as tgl_pengajuan')
//               ->leftJoin('users','users.id','=','sppsb.user_id')
//              -> findOrFail($id);
           
              $sppsb = DB::table('sppsb')
                ->select('*','sppsb.id as sppsb_id','sppsb.created_at as tgl_pengajuan')
                ->leftjoin('history_penjaminans','history_penjaminans.sppsb_id','=','sppsb.id')
                ->leftjoin('analisas','analisas.sppsb_id','=','sppsb.id')
                 ->leftJoin('users','users.id','=','sppsb.user_id')
                ->where('sppsb.id',$id)
                 ->first();   
        $agen = DB::table('agens')
                ->select(
                    'agens.no_agen',
                    'agens.wilayah_agensi',
                    'agens.code_wilayah',
                    'agens.fee_sppsb',
                    'users.name')
                ->leftJoin('users','users.id','=','agens.user_id')
                ->where('users.id', Auth::user()->id)->first();

        $dokPendukung = json_decode($sppsb->dokumen_pendukung);
        $brgAgunan = json_decode($sppsb->barang_agunan);
        //$selisih = ((abs(strtotime ($sppsb->waktu_mulai) - strtotime ($sppsb->waktu_selesai)))/(60*60*24)+1);
        $selisih = ucwords((new SppsbController)->terbilang($sppsb->durasi));
        $nilaiProyek = ucwords((new SppsbController)->terbilang($sppsb->nilai_proyek));
        $nilaiJaminan = ucwords((new SppsbController)->terbilang($sppsb->nilai_jaminan));
        $nilaiProyekFormat = number_format($sppsb->nilai_proyek,2,",",".");
        $nilaiJaminanFormat = number_format($sppsb->nilai_jaminan,2,",",".");
      
        $hasilAnalisa = json_decode($sppsb->analisa_staff);
        $analisa = Analisa::where('sppsb_id',$id)->first();
        $data_kontraktor = Sppsb::where('nama_kontraktor', $sppsb->nama_kontraktor) 
                            ->whereNotIn('id',[$sppsb->sppsb_id])
                            ->orderBy('tgl_dokumen','Asc')
                            ->get(); 
//        dd($data_kontraktor);
//        DD($hasilAnalisa);
        //$serviceCharge = ceil((new DireksiController)->calculateIjp($sppsb->waktu_mulai,$sppsb->waktu_selesai,$sppsb->nilai_jaminan,$sppsb->jenis_sppsb));
        //$charge = (new DireksiController)->pembulatan($serviceCharge);
        //$chargeFormat = number_format($charge,2,",",".");
          
           $historyStaff    = History::where([
                        ['sppsb_id',$id],
                        ['proses','Kabag'],
                        ['users.keterangan','Staf']
                            ]
              )   ->leftJoin('users','users.name','=','historys.author')
                   ->OrderBy('historys.created_at','Desc')  
                   ->first();
//           dd($historyStaff);
           $historyKabag   = History::where([
                        ['sppsb_id',$id],
//                        ['proses','Proses'],
                        ['users.keterangan','Kabag']
                            ]
              )
                   ->leftJoin('users','users.name','=','historys.author')
                   ->OrderBy('historys.created_at','Desc')  
                   ->first();
//                   dd($historyKabag);
//           dd($historyKabag);
           
           $historyDirektur = History::where([
                        ['sppsb_id',$id],
//                        ['proses','Proses'],
                        ['users.keterangan','Direktur']
                            ]
              ) ->leftJoin('users','users.name','=','historys.author')
                   ->OrderBy('historys.created_at','Desc')  
                   ->first();
//           dd($historyDirektur);
//                   ->groupBy('sppsb_id')   ->first();
           
           $historyDireksi  = History::where([
                        ['sppsb_id',$id],
//                        ['proses','Setuju'],
                         ['users.keterangan','Direktur Utama']
                            ]
              )  ->leftJoin('users','users.name','=','historys.author')
                   ->OrderBy('historys.created_at','Desc')   
                   ->first();
    
//               dd($historyDirektur);
           
                 $biayaadmin = DB::
                table('options')
                ->where('id','2')
                ->first();   
       
        //        $materai = DB::connection('KONEKSIWEB')//KONEKSI KE WEB
                $biayamaterai = DB::
                        table('options')
                        ->where('id','3')
                        ->first();  
        
            $serviceCharge = ceil((new DireksiController)->calculateIjp($sppsb->waktu_mulai,$sppsb->waktu_selesai,$sppsb->nilai_jaminan,$sppsb->jenis_sppsb,$biayaadmin->value,$biayamaterai->value,'SPPSB'));
            $charge = (new DireksiController)->pembulatan($serviceCharge);
//           dd( getenv('COMPUTERNAME'));
            $rate = getRate($sppsb->waktu_mulai, $sppsb->waktu_selesai, $sppsb->jenis_sppsb);
            
            if($sppsb->fee<1){
                        $fee = $agen->fee_sppsb;
             }else{
                        $fee = $sppsb->fee;
             }
             
            $feeAdmin = $biayaadmin->value;
            $materai = $biayamaterai->value;
            $nilaipembulatanGrosIJP = ceil(($sppsb->nilai_jaminan*$rate)/100);
             $grossIjp = (new DireksiController)->pembulatan($nilaipembulatanGrosIJP);
//            dd($grossIjp);
            $feeAgen = ($grossIjp*$fee)/100;
           
//            dd($fee);
                   
        //$rate = (new SppsbController)->getRate($sppsb->waktu_mulai, $sppsb->waktu_selesai, $sppsb->jenis_sppsb);

		$pdf = PDF::loadView('report.analisasppsb',compact(
                                            'sppsb',
                                            'historyStaff',
                                            'historyKabag',
                                            'historyDireksi',
                                            'historyDirektur',
                                            'dokPendukung',
                                            'hasilAnalisa',
                                            'analisa',
                                            'data_kontraktor',
                                            'brgAgunan',
                                            'selisih',
                                            'charge',
                                            'rate',
                                            'grossIjp',
                                            'feeAgen',
                                            'fee',
                                            'feeAdmin',
                                            'materai',
                                            'nilaiProyekFormat',
                                            'nilaiJaminanFormat',
                                            'nilaiProyek',
                                            'nilaiJaminan'
                                            ,'agen'));
		//$pdf->setPaper('a4', 'landscape');		
		return $pdf->stream('detail.pdf');

		//return view('report.detail',compact('sppsb','dokPendukung','brgAgunan','selisih','nilaiProyekFormat','nilaiJaminanFormat','nilaiProyek','nilaiJaminan','agen'));
		
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
                ->where('users.id', Auth::user()->id)->first();
        $bank = Bank::findOrFail($sp3kbg->bank_id);
        $dokPendukung = json_decode($sp3kbg->dokumen_pendukung);
        $brgAgunan = json_decode($sp3kbg->barang_agunan);
        //$selisih = ((abs(strtotime ($sppsb->waktu_mulai) - strtotime ($sppsb->waktu_selesai)))/(60*60*24)+1);
        $selisih = ucwords((new SppsbController)->terbilang($sp3kbg->durasi));
        $nilaiProyek = ucwords((new SppsbController)->terbilang($sp3kbg->nilai_proyek));
        $nilaiJaminan = ucwords((new SppsbController)->terbilang($sp3kbg->nilai_jaminan));
        $nilaiProyekFormat = number_format($sp3kbg->nilai_proyek,2,",",".");
        $nilaiJaminanFormat = number_format($sp3kbg->nilai_jaminan,2,",",".");

        //$serviceCharge = ceil((new DireksiController)->calculateIjp($sppsb->waktu_mulai,$sppsb->waktu_selesai,$sppsb->nilai_jaminan,$sppsb->jenis_sppsb));
        //$charge = (new DireksiController)->pembulatan($serviceCharge);
        //$chargeFormat = number_format($charge,2,",",".");
        
        //$rate = (new SppsbController)->getRate($sppsb->waktu_mulai, $sppsb->waktu_selesai, $sppsb->jenis_sppsb);

        $pdf = PDF::loadView('report.detailsp3kbg',compact('sp3kbg','bank','dokPendukung','brgAgunan','selisih','nilaiProyekFormat','nilaiJaminanFormat','nilaiProyek','nilaiJaminan','agen'));
        //$pdf->setPaper('a4', 'landscape');        
        return $pdf->stream('detail.pdf');

        //return view('report.detail',compact('sppsb','dokPendukung','brgAgunan','selisih','nilaiProyekFormat','nilaiJaminanFormat','nilaiProyek','nilaiJaminan','agen'));
        
    }
    public function perjanjian($id)
    {
        $sppsb = Sppsb::findOrFail($id);        
        $result = Result::where('sppsb_id',$id)->first(); 
        $pdf = PDF::loadView('report.perjanjian',compact('sppsb','result'));
        //$pdf->setPaper('a4', 'landscape');        
        return $pdf->stream('perjanjian.pdf');
    }
    public function sertifikatSppsb($id)
    {
        $sppsb = Sppsb::select('*','sppsb.created_at as tgl_input','sppsb.id as id')-> leftJoin('users','users.id','=','sppsb.user_id')->findOrFail($id);
//       dd($sppsb);
        $result = Result::where('sppsb_id',$id)->first();        
           
        //$selisih = ((abs(strtotime ($sppsb->waktu_mulai) - strtotime ($sppsb->waktu_selesai)))/(60*60*24));
        $selisih = ucwords((new SppsbController)->terbilang($sppsb->durasi));
//       dd($selisih);
        $nilaiProyek = ucwords((new SppsbController)->terbilang($sppsb->nilai_proyek));
        $nilaiJaminan = ucwords((new SppsbController)->terbilang($sppsb->nilai_jaminan));
        $nilaiProyekFormat = number_format($sppsb->nilai_proyek,2,",",".");
        $nilaiJaminanFormat = number_format($sppsb->nilai_jaminan,2,",",".");
        $charge = number_format($result->service_charge,2,",",".");
        
//        dd($charge); 
       
        if($sppsb->jenis_sppsb == '1'){
            $pathSppsb = 'report.sertifikatpenawaran';
        }elseif($sppsb->jenis_sppsb == '2'){
            $pathSppsb = 'report.sertifikatpelaksanaan';
        }elseif($sppsb->jenis_sppsb == '3'){
            $pathSppsb = 'report.sertifikatuangmuka';
        }elseif($sppsb->jenis_sppsb == '4'){
            $pathSppsb = 'report.sertifikatpemeliharaan';
        }elseif($sppsb->jenis_sppsb == '5'){
            $pathSppsb = 'report.sertifikatpembayaran';
        }elseif($sppsb->jenis_sppsb == '6'){
            $pathSppsb = 'report.sertifikatsanggahbanding';
        }
        
        $pdf = PDF::loadView($pathSppsb, compact(
                'sppsb',
                'result',
                'selisih',
                'nilaiJaminan',
                'nilaiJaminanFormat',
                'charge'))->setPaper('a3', 'landscape'); ;
//                dd($pdf);
//          $customPaper = array(0,0,612.283, 963.78);
//          $pdf->setPaper('f4', 'landscape');
         
          $batas_tahun = 2021;
          $tahun_input = date('Y',strtotime($sppsb->tgl_input));
//         dd($tahun_input);
//        if($tahun_input<$batas_tahun){
          
//         $pdf->set_paper($customPaper); 
         $direksi = new DireksiController();
        if($sppsb->digitalSign!=1){
//            dd($pdf);
            return $pdf->stream('sertifikat.pdf');
        }else{
            $id=$direksi->enkripsi($id); 
            return redirect('https://penjaminan.jamkridantb.com/verifikasi-doc-sertifikat-surety/'.$id);
        }
        

        //return view($pathSppsb, compact('sppsb','result','selisih','nilaiJaminan','nilaiJaminanFormat','charge'));
        
    }
    public function sertifikatSp3kbg($id)
    {
        $sp3kbg = Sp3kbg::findOrFail($id);
        $result = Result::where('sp3kbg_id',$id)->first();        
        $bank = Bank::findOrFail($sp3kbg->bank_id); 
        //$selisih = ((abs(strtotime ($sp3kbg->waktu_mulai) - strtotime ($sp3kbg->waktu_selesai)))/(60*60*24));
        $selisih = ucwords((new SppsbController)->terbilang($sp3kbg->durasi));
        /*$nilaiProyek = ucwords((new SppsbController)->terbilang($sp3kbg->nilai_proyek));
        $nilaiJaminan = ucwords((new SppsbController)->terbilang($sp3kbg->nilai_jaminan));
        $nilaiProyekFormat = number_format($sp3kbg->nilai_proyek,2,",",".");
        $nilaiJaminanFormat = number_format($sp3kbg->nilai_jaminan,2,",",".");
        $charge = number_format($result->service_charge,2,",",".");*/


        $pdf = PDF::loadView('report.sertifikatsp3kbg', compact('sp3kbg','bank','result','selisih'));
        return $pdf->stream('sertifikat.pdf');
        
    }
    public function cetakSp3kbg($id)
    {
        $sp3kbg = Sp3kbg::findOrFail($id);
        $result = Result::where('sp3kbg_id',$id)->first();        
        $bank = Bank::findOrFail($sp3kbg->bank_id); 
        //$selisih = ((abs(strtotime ($sp3kbg->waktu_mulai) - strtotime ($sp3kbg->waktu_selesai)))/(60*60*24));
        $selisih = ucwords((new SppsbController)->terbilang($sp3kbg->durasi));
        /*
        $nilaiProyek = ucwords((new SppsbController)->terbilang($sp3kbg->nilai_proyek));
        $nilaiJaminan = ucwords((new SppsbController)->terbilang($sp3kbg->nilai_jaminan));
        $nilaiProyekFormat = number_format($sp3kbg->nilai_proyek,2,",",".");
        $nilaiJaminanFormat = number_format($sp3kbg->nilai_jaminan,2,",",".");
        $charge = number_format($result->service_charge,2,",",".");
        */
        $ijp = ($sp3kbg->nilai_jaminan*$result->rate_ijp)/100;
        $feeBank = ($ijp*$result->rate_bank)/100;
        $feeJnb = ($ijp-$feeBank);
        
        $pdf = PDF::loadView('report.sp3kbg', compact('sp3kbg','bank','result','selisih','ijp','feeBank','feeJnb'));
        return $pdf->stream('sertifikat.pdf');
    }
    
    public function cetakAgenDetail(Request $request)
    { 
 //untuk cetak laporan PDF Agen
      
        $sumIjp = 0;
        $sumBulatIjp = 0;
        $sumGrossIjp = 0;
        $sumFee = 0;

        $data = $request->all();
//         dd($data);
        if($data['startDate']=="" || $data['endDate']=="")
         {
            $sppsb = DB::table('v_report_sppsb')
                        ->select('v_report_sppsb.*')
                        ->where('user_id',$data['agen']);
          
            $report = DB::table('v_report_sp3kbg')
                        ->select('v_report_sp3kbg.*')
                        ->where('user_id',$data['agen'])
                        ->union($sppsb)->get();
            
        }
        else
        {
 
//            $startDate  = date('Y-m-d', strtotime('01-'.$data['startDate']));
            $startDate  = date('Y-m-d', strtotime($data['startDate']));
//            $endDate    = date('Y-m-t', strtotime('10-'.$data['endDate'])); //menga,bil nilai akhir tanggal di setiap bulannya
            $endDate    = date('Y-m-d', strtotime($data['endDate'])); //menga,bil nilai akhir tanggal di setiap bulannya
//            dd($endDate);
            
            $tglMulai   = $data['startDate'];
            $tglSelesai = $data['endDate'];
            
//            dd($data);
            $sppsb = DB::table('v_report_sppsb')
                            ->select('v_report_sppsb.*')
                            ->where('v_report_sppsb.status','C')  
                            ->where('user_id',$data['agen'])
                            ->whereBetween('v_report_sppsb.updated_at',[$startDate,$endDate])   ;
               
            if($request->agen=='all')
            {
                 
                   $report = DB::table('v_report_all')
                            ->select('v_report_all.*') 
                            ->whereBetween('v_report_all.updated_at',[$startDate,$endDate])  
                            ->where('v_report_all.status','C')  
                           ->get(); 
//                        dd($report);
            }
            else
            {
              
//                    $report = DB::table('v_report_sp3kbg')
//                            ->select('v_report_sp3kbg.*')
//                            ->where('user_id',$data['agen'])
//                            ->whereBetween('v_report_sp3kbg.updated_at',[$startDate,$endDate])
//                            ->union($sppsb)
//                            ->get();
                    
                      $report = DB::table('v_report_sp3kbg')
                            ->select('v_report_sp3kbg.*')
                            ->where('user_id',$data['agen'])
                            ->whereBetween('v_report_sp3kbg.updated_at',[$startDate,$endDate])
                            ->union($sppsb)
                            ->get();
            }
            
//                           dd($report);
        
//                 dd($report);
     
        }
        $agen = DB::table('agens')
                            ->select(
                                'agens.no_agen',
                                'agens.wilayah_agensi',
                                'agens.code_wilayah',
                                'users.name')
                            ->leftJoin('users','users.id','=','agens.user_id')
                            ->where('users.id', $data['agen'])
                            ->first();

        foreach ($report as $key => $data) {
            $sumIjp += $data->net_ijp;
            $sumBulatIjp += $data->net_ijp;
            $sumGrossIjp += $data->gross_ijp;
            $sumFee += $data->fee_agen;
        }
        
//        dd($report);
        
              
//            if($request->agen=='all'){
//                 
//                   $report = DB::table('v_report_all')
//                            ->select('v_report_all.*') 
//                            ->whereBetween('v_report_all.updated_at',[$startDate,$endDate])  
//                            ->where('v_report_all.status','C')  
//                           ->get(); 
////                        dd($report);
//            }else{
//              
//                    $report = DB::table('v_report_sp3kbg')
//                            ->select('v_report_sp3kbg.*')
//                            ->where('user_id',$data['agen'])
//                            ->whereBetween('v_report_sp3kbg.updated_at',[$startDate,$endDate])
//                            ->union($sppsb)
//                            ->get();
//            }
        
          if($request->agen=='all'){
              $pdf = view('report.agendetailAll', 
                compact(
                        'report',
                        'tglMulai',
                        'tglSelesai',
                        'agen',
                        'sumIjp',
                        'sumGrossIjp',
                        'sumBulatIjp',
                        'sumFee')
                      );
//                ->setPaper('a3', 'landscape');
              
//              $data = 
          }else{
                $pdf = view('report.agendetail', compact('report',
                'agen',
                'tglMulai',
                 'tglSelesai',
                'sumIjp',
                'sumGrossIjp',
                'sumBulatIjp',
                'sumFee'));
          } 
//          dd($report);
//        return $pdf->stream('laporan-agen-detail.pdf');
          
     //      return $pdf->stream('laporan-agen-detail.pdf');
        return $pdf;
        
    }
     
    
    public function cetakRekapAgen(Request $request)
    {
        $data = $request->all();
        $tglMulai = "";
        $tglSelesai = "";

        if($data['startDate1']=="" || $data['endDate1']=="")
        {

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
        }
        else
        {

            $startDate  = date('Y-m-d', strtotime($data['startDate1']));
            $endDate    = date('Y-m-d', strtotime($data['endDate1'])); 
            $tglMulai   = $data['startDate1'];
            $tglSelesai = $data['endDate1'];
            
         
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
//            dd($endDate);
            
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

        $pdf = PDF::loadView('report.rekapagen', compact('report','tglMulai','tglSelesai'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-rekap-agen.pdf');
    }
    
    public function cetakPerWilayah(Request $request)
    {
        $data = $request->all();
        $tglMulai = "";
        $tglSelesai = "";

        if($data['startDate2']=="" || $data['endDate2']==""){
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

            $startDate  = date('Y-m-d', strtotime($data['startDate2']));
            $endDate    = date('Y-m-d', strtotime($data['endDate2'])); 
            $tglMulai   = $data['startDate2'];
            $tglSelesai = $data['endDate2'];

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

        $pdf = PDF::loadView('report.perwilayah', compact('report','tglMulai','tglSelesai'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-perwilayah.pdf');
    }
    public function cetakBelumTerbit(Request $request)
    {
        $data = $request->all();
        $sppsb     = DB::table(DB::raw('sppsb, (SELECT @rownum := 0) r'))
                        ->select('sppsb.id','sppsb.no_registrasi','sppsb.nama_kontraktor', DB::raw('"sppsb" AS type'), DB::raw('@rownum := @rownum + 1 AS rank'))
                        ->where('sppsb.user_id',$data['agen'])
                        ->whereIn('sppsb.status',['D','B','P','R']);
        $report     = DB::table(DB::raw('sp3kbg, (SELECT @rownum := 0) r'))
                        ->select('sp3kbg.id','sp3kbg.no_registrasi','sp3kbg.nama_kontraktor', DB::raw('"sp3kbg" AS type'), DB::raw('@rownum := @rownum + 1 AS rank'))
                        ->where('sp3kbg.user_id',$data['agen'])
                        ->whereIn('sp3kbg.status',['D','B','P','R'])->union($sppsb)->get();

        $agen = DB::table('agens')
                ->select(
                    'agens.no_agen',
                    'agens.wilayah_agensi',
                    'agens.code_wilayah',
                    'users.name')
                ->leftJoin('users','users.id','=','agens.user_id')
                ->where('users.id', $data['agen'])->first();

        $pdf = PDF::loadView('report.belumterbit', compact('report','agen'));
        return $pdf->stream('laporan-belum-terbit.pdf');
    }
    public function cetakLapAgen(Request $request)
    {
        $data = $request->all();
        $tglMulai = "";
        $tglSelesai = "";
        $sumIjp = 0;
        $sumBulatIjp = 0;
        $sumGrossIjp = 0;
        $sumFee = 0;

        if($data['startDate']=="" || $data['endDate']==""){

            $sppsb = DB::table('v_report_sppsb')
                        ->select('v_report_sppsb.*')->where('user_id',Auth::user()->id);
            $report = DB::table('v_report_sp3kbg')
                        ->select('v_report_sp3kbg.*')->where('user_id',Auth::user()->id)->union($sppsb)->get();
        }else{            
            $startDate  = date('Y-m-d', strtotime($data['startDate']));
            $endDate    = date('Y-m-d', strtotime($data['endDate'])); 
            $tglMulai   = $data['startDate'];
            $tglSelesai = $data['endDate'];

            $sppsb = DB::table('v_report_sppsb')
                        ->select('v_report_sppsb.*')
                        ->where('user_id',Auth::user()->id)
                        ->whereBetween('created_at',[$startDate,$endDate]);
            $report = DB::table('v_report_sp3kbg')
                        ->select('v_report_sp3kbg.*')
                        ->where('user_id',Auth::user()->id)
                        ->whereBetween('created_at',[$startDate,$endDate])->union($sppsb)->get();

        }
        foreach ($report as $key => $data) {
            $sumIjp += $data->net_ijp;
            $sumBulatIjp += $data->net_ijp;
            $sumGrossIjp += $data->gross_ijp;
            $sumFee += $data->fee_agen;
        }

        $agen = DB::table('users')
                    ->select('users.name','agens.no_agen','agens.code_wilayah','agens.wilayah_agensi')
                    ->leftJoin('agens','agens.user_id','=','users.id')
                    ->where('users.id',Auth::user()->id)->first();


        $pdf = PDF::loadView('report.laporanagen', compact('report','agen', 'tglMulai','tglSelesai','sumIjp','sumBulatIjp','sumGrossIjp','sumFee'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-agen.pdf');
    }

}
