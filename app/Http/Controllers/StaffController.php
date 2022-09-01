<?php

namespace App\Http\Controllers;

use DB;
use Datatables;
use Auth;
use App\Sppsb;
use App\Sp3kbg;
use App\Bank;
use App\History;
use App\Result;
use App\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\DireksiController;
use Illuminate\Support\Facades\Session;
use App\HistoryPenjaminan;
use App\Analisa;
class StaffController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(
                            ['role:staff'] 
                ); 
//        $this->middleware('role:direksi'); 
    }

	public function masuk()
    {
        return view('staff.datamasuk');
    }

    public function getSppsbMasukTable()
    {
//        $sppsb = DB::connection('KONEKSIWEB') 
        $sppsb = DB::table('sppsb')
                        ->select('sppsb.id',
                                'sppsb.nama_kontraktor',
                                'sppsb.alamat_kontraktor',
                                'sppsb.direksi',
                                'sppsb.status',
                                DB::raw("(DATE_FORMAT(sppsb.created_at,'%d/%m/%Y')) AS tgl_pengajuan"),
                                'users.jabatan',
                                'users.name'
                        )
                        ->leftJoin('users','users.id','=','sppsb.user_id')
                        ->whereIn('sppsb.status',array('B','S','R','T'))
                        ->orderBy('sppsb.created_at','DESC')
                        ->get();

        return Datatables::of($sppsb)
            ->addColumn('action', function ($sppsb) {
                if($sppsb->status == 'B' || $sppsb->status == 'R'){
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sppsb-detail-staff/'.$sppsb->id.'" class="icon-button icon-color-blue">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                            </div>';
                }elseif($sppsb->status == 'T'){
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sppsb-detail-staff/'.$sppsb->id.'" class="icon-button icon-color-grey">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>';
                }else{
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sppsb-penomoran/'.$sppsb->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-barcode"></i>
                                </a>
                            </div>';
                }
            })
            ->make(true);
    }

    public function getSp3kbgMasukTable()
    {
        $sp3kbg = DB::table('sp3kbg')
                        ->select('sp3kbg.id',
                                'sp3kbg.nama_kontraktor',
                                'sp3kbg.alamat_kontraktor',
                                'sp3kbg.direksi',
                                'sp3kbg.status',
                                DB::raw("(DATE_FORMAT(sp3kbg.created_at,'%d/%m/%Y')) AS tgl_pengajuan"),
                                'users.jabatan',
                                'users.name'
                        )
                        ->leftJoin('users','users.id','=','sp3kbg.user_id')
                        ->whereIn('sp3kbg.status',array('B','S','R','T'))
                        ->orderBy('sp3kbg.created_at','DESC')
                        ->get();

        return Datatables::of($sp3kbg)
            ->addColumn('action', function ($sp3kbg) {
                if($sp3kbg->status == 'B' || $sp3kbg->status == 'R'){
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sp3kbg-detail/'.$sp3kbg->id.'" class="icon-button icon-color-blue">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                            </div>';
                }elseif($sp3kbg->status == 'T'){
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sp3kbg-detail/'.$sp3kbg->id.'" class="icon-button icon-color-grey">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>';
                }else{
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sp3kbg-penomoran/'.$sp3kbg->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-barcode"></i>
                                </a>
                            </div>';
                }
            })
            ->make(true);
    }

    public function penomoranSppsb($id)
    {
//        dd($id);
        $sppsb = Sppsb::findOrFail($id); 

        $result = Result::where('sppsb_id', $id)->first();

        //$selisih = ((abs(strtotime ($sppsb->waktu_mulai) - strtotime ($sppsb->waktu_selesai)))/(60*60*24));
        $selisih = ucwords((new SppsbController)->terbilang($sppsb->durasi));
        $nilaiProyek = ucwords((new SppsbController)->terbilang($sppsb->nilai_proyek));
        $nilaiJaminan = ucwords((new SppsbController)->terbilang($sppsb->nilai_jaminan));
        if($sppsb->status == 'S'){
            if($sppsb->jenis_sppsb == '1'){
                $pathSppsb = 'direksi.sertifikatpenawaran';
            }elseif($sppsb->jenis_sppsb == '2'){
                $pathSppsb = 'direksi.sertifikatpelaksanaan';
            }elseif($sppsb->jenis_sppsb == '3'){
                $pathSppsb = 'direksi.sertifikatuangmuka';
            }elseif($sppsb->jenis_sppsb == '4'){
                $pathSppsb = 'direksi.sertifikatpemeliharaan';
            }elseif($sppsb->jenis_sppsb == '5'){
                $pathSppsb = 'direksi.sertifikatpembayaran';
            }elseif($sppsb->jenis_sppsb == '6'){
                $pathSppsb = 'direksi.sertifikatsanggahbanding';
            }
            
            return view($pathSppsb, compact('sppsb','selisih','nilaiProyek','nilaiJaminan','result'));
        }else{
            return view('errors.permissions', compact('sppsb'));
        }
    }

    public function updateSppsb(Request $request)
    {
        $data = $request->all();
        
        $sppsb = Sppsb::findOrFail($data['id']);

        $lastNoSertifikat = DB::table('sppsb')
                     ->select(DB::raw('MAX(no_sertifikat) as no_reg'))
                     ->where([['user_id', $sppsb->user_id],['created_at', '>', '2017-06-13']])
                     ->first();
        $agen   = DB::table('agens')->select('min_no_reg')->where('user_id',$sppsb->user_id)->first();
        $newNoSertifikat = $this->incrementValue($lastNoSertifikat->no_reg, $agen->min_no_reg);

        $sppsb->no_sertifikat  = $newNoSertifikat;
        $sppsb->no_jaminan  = $data['no_jaminan'];
        $sppsb->status      = 'C';
        $sppsb->updated_by  = Auth::user()->username;
        $sppsb->save();

                //insert new history
        $history = History::create([
            'sppsb_id'  => $data['id'],
            'proses'    => 'Closing',
            'author'    => Auth::user()->name
        ]);

        Session::flash('msgupdate','SPPSB dengan no registrasi '.$sppsb->no_registrasi.' berhasil di update dengan nomor jaminan '.$data['no_jaminan']);
        return redirect('/sppsb-sp3kbg-masuk');

    }

    public function penomoranSp3kbg($id)
    {
        $sp3kbg = Sp3kbg::findOrFail($id); 
        $bank = Bank::findOrFail($sp3kbg->bank_id);   

        $admin = Option::findOrFail('4');
        $materai = Option::findOrFail('3');   

        $result = Result::where('sp3kbg_id', $id)->first();
        $rate = (new DireksiController)->rateIjp($sp3kbg->waktu_mulai,$sp3kbg->waktu_selesai,$sp3kbg->jenis_sp3kbg,'SP3KBG');
        $ijp = ($sp3kbg->nilai_jaminan*$rate['rateIjp'])/100;

        /*$selisih = ((abs(strtotime ($sp3kbg->waktu_mulai) - strtotime ($sp3kbg->waktu_selesai)))/(60*60*24));
        $nilaiProyek = ucwords((new SppsbController)->terbilang($sp3kbg->nilai_proyek));
        $nilaiJaminan = ucwords((new SppsbController)->terbilang($sp3kbg->nilai_jaminan));*/
        $serviceCharge = $result->service_charge;
        $feeBank = ($ijp*$bank->rate)/100;
        if($sp3kbg->status == 'S'){            
            return view('direksi.sertifikatsp3kbg', compact('sp3kbg','bank','rate','ijp','admin','materai','serviceCharge','result','feeBank'));
        }else{
            return view('errors.permissions', compact('sp3kbg'));
        }
    }

    public function updateSp3kbg(Request $request)
    {
        $data = $request->all();
//        dd($data);
        $sp3kbg = Sp3kbg::findOrFail($data['id']);

        $lastNoSertifikat = DB::table('sp3kbg')
                     ->select(DB::raw('MAX(no_sertifikat) as no_reg'))
                     //->where('user_id', Auth::user()->id)
                     ->where([['user_id', $sp3kbg->user_id],['created_at', '>', '2017-06-13']])
                     ->first();
        $agen   = DB::table('agens')->select('min_no_reg')->where('user_id',$sp3kbg->user_id)->first();
        $newNoSertifikat = $this->incrementValue($lastNoSertifikat->no_reg, $agen->min_no_reg);

        $sp3kbg->no_sertifikat  = $newNoSertifikat;
        $sp3kbg->no_jaminan  = $data['no_jaminan'];
        $sp3kbg->status      = 'C';
        $sp3kbg->updated_by  = Auth::user()->username;
        $sp3kbg->save();

                //insert new history
        $history = History::create([
            'sp3kbg_id'  => $data['id'],
            'proses'    => 'Closing',
            'author'    => Auth::user()->name
        ]);

        Session::flash('msgupdate','SP3KBG dengan no registrasi '.$sp3kbg->no_registrasi.' berhasil di update dengan nomor jaminan '.$data['no_jaminan']);
        return redirect('/sppsb-sp3kbg-masuk');

    }
    protected function incrementValue($value, $min)
    {
        $length = strlen($value);
        $lasNoReg = ltrim($value, '0');
        if($lasNoReg=='0' || $lasNoReg==''){
            $newNoReg = $min;    
        }else{
            $newNoReg = $lasNoReg+1;
        }
        $zeroLength = 8-(strlen($newNoReg)); 
        $zero = "";
        for ($i = 0 ; $i < $zeroLength ; $i++){
            $zero = $zero."0";
        }
        $r = $zero."".$newNoReg;

        return $r;
    }
    
    public function formStaff()
    {
        $bank = Bank::all();
      
        return view('staff.sppsbform', compact('bank'));
    }
  
    
 //  --->  untuk dua method searchPemilikProyek() dan search() digunakan untuk cek data dari sim PK.
 //  
//    public function searchPemilikProyek(Request $request) {
//        // check if ajax request is coming or not
//         if (isset($request->kd_penerima)){
//             
//                $data =db::CONNECTION('sqlsrv')->table('t_penjaminan')
//                ->rightJoin('m_terjamin', 'm_terjamin.kd_terjamin', '=', 't_penjaminan.kd_terjamin')
//                ->rightJoin('m_penerima_jaminan', 'm_penerima_jaminan.kd_penerima', '=', 't_penjaminan.kd_penerima')
//                ->select(
//                        'm_penerima_jaminan.nama as nama_dinas',
//                        'm_penerima_jaminan.direktur as nama_pejabat',
//                        'm_penerima_jaminan.alamat as alamat_dinas', 
//                        't_penjaminan.jenis_kredit as jenis_pekerjaan', 
//                        't_penjaminan.nilai as nilai_jaminan', 
//                        'm_terjamin.tanggal_daftar as tanggal_daftar_terjamin', 
//                         '*')
//                ->where('m_penerima_jaminan.kd_penerima',$request->kd_penerima)
//                ->first();
//              
//                $output = [
//                'pemilik_proyek'   => $data->nama_dinas,
//                'nama_pejabat'   => $data->nama_pejabat,
//                'jabatan_pejabat' => '-',
//                'alamat_dinas'   => $data->alamat_dinas,
//                'jenis_pekerjaan'   => $data->jenis_pekerjaan, 
//                'nilai_jaminan'   => $data->nilai_jaminan, 
////                'nama_dokumen'   => $data->no_permintaan_penjamin, 
////                'no_permintaan_dokumen'   => $data->no_perjanjian, 
//                ];
//              
//            echo json_encode($output);
//              
//         } else {
//            if ($request->ajax()) {
//               
//               $data = db::CONNECTION('sqlsrv')->table('m_penerima_jaminan')
//                        ->where('nama', 'LIKE', '%' . $request->pemilik_proyek . '%')
//                        ->whereNotIn('status',[1])
//                        ->get();
//              
//
//                // select country name from database
////                $data = Sppsb::where('pemilik_proyek', 'LIKE', '%' . $request->pemilik_proyek . '%')
////                        ->groupBy('Sppsb.pemilik_proyek')
////                        ->get();
//                // declare an empty array for output
//                $output = '';
//                // if searched countries count is larager than zero
//                if (count($data) > 0) {
//                    // concatenate output to the array
//                    $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
//                    // loop through the result array
//                    foreach ($data as $row) {
//                        // concatenate output to the array
//                        $output .= '<b class="list-group-item" name="'.$row->nama.'" id="' . $row->kd_penerima . '" > <a class="btn">' . $row->nama.'/'.$row->kd_penerima . '</a></b>';
//                    }
//                    // end of output
//                    $output .= '</ul>';
//                } else {
//                    // if there's no matching results according to the input
//                    $output .= '<li class="list-group-item" STYLE="COLOR:RED">Pemilik Proyek Belum Terdaftar </li>';
//                }
//                // return output result array
//                return $output;
//            }
//        }
//    }
//    
//    //proses pencarian terjamin/ Kontraktor
//     public function search(Request $request) {
//        // check if ajax request is coming or not
//         if (isset($request->idsppb)){
//             
//                $data = db::CONNECTION('sqlsrv')->table('m_terjamin')
//                        ->where('kd_terjamin',$request->idsppb)
//                        ->first();
//                $output = [
//                'nama_kontraktor'   => $data->nama,
//                'alamat_kontraktor' => $data->alamat, 
//                'bidang_usaha' => $data->jenis_usaha,
//                'nama_direksi' => $data->direktur,
//                'jabatan_direksi' => 'Direktur',
//                ];
//                
//                
//            echo json_encode($output);
//              
//         } else {
//             //untuk menampilkan dalam bentuk li
//         if ($request->ajax()) {
//                // select kontraktor name from database
//                $data = db::CONNECTION('sqlsrv')->table('m_terjamin')
//                        ->where('nama', 'LIKE', '%' . $request->kontraktor . '%')
//                        ->where('status','1')
////                      ->groupBy('nama')
//                        ->get();
//                // declare an empty array for output
//                $output = '';
//                // if searched countries count is larager than zero
//                if (count($data) > 0) {
//                    // concatenate output to the array
//                    $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
//                    // loop through the result array
//                    foreach ($data as $row) {
//                        // concatenate output to the array
//                        $output .= '<li class="list-group-item" name="'.$row->nama.'" id="' . $row->kd_terjamin . '" > <a class="btn">' . $row->nama . '</a></li>';
//                    }
//                    // end of output
//                    $output .= '</ul>';
//                } else {
//                    // if there's no matching results according to the input
//                    $output .= '<li class="list-group-item" STYLE="COLOR:RED">Kontraktor Belum Terdaftar </li>';
//                }
//                // return output result array
//                return $output;
//            }
//        }
//    }
//    
    
    
    public function searchPemilikProyek(Request $request) {
     
      
        // check if ajax request is coming or not
         if (isset($request->kd_penerima)){
             
                         $data = Sppsb::where('id',  $request->kd_penerima )
//                        ->groupBy('Sppsb.pemilik_proyek')
                        ->first();
//              dd($data);
                $output = [
                'pemilik_proyek'   => $data->pemilik_proyek,
                'nama_pejabat'   => $data->nama_pejabat,
                'jabatan_pejabat' =>  $data->jabatan_pejabat,
                'alamat_dinas'   => $data->alamat,
                'jenis_pekerjaan'   => $data->jenis_pekerjaan, 
                'nilai_jaminan'   => $data->nilai_jaminan, 
//                'nama_dokumen'   => $data->no_permintaan_penjamin, 
//                'no_permintaan_dokumen'   => $data->no_perjanjian, 
                ];
              
            echo json_encode($output);
              
         } else {
                ;
//            if ($request->ajax()) {
            if ($request) {
               
//               $data = db::CONNECTION('sqlsrv')->table('m_penerima_jaminan')
//                        ->where('nama', 'LIKE', '%' . $request->pemilik_proyek . '%')
//                        ->whereNotIn('status',[1])
//                        ->get();
//              

                // select country name from database
                $data = Sppsb::where('pemilik_proyek', 'LIKE', '%' . $request->pemilik_proyek . '%')
                        ->groupBy('Sppsb.pemilik_proyek')
                        ->get();
                    
                // declare an empty array for output
                $output = '';
                // if searched countries count is larager than zero
                if (count($data) > 0) {
                    // concatenate output to the array
                    $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                    // loop through the result array
                    foreach ($data as $row) {
                        // concatenate output to the array
                        $output .= '<b class="list-group-item" name="'.$row->pemilik_proyek.'" id="' . $row->id . '" > <a class="btn">' . $row->pemilik_proyek. '</a></b>';
                    }
                    // end of output
                    $output .= '</ul>';
                } else {
                    // if there's no matching results according to the input
                    $output .= '<li class="list-group-item" STYLE="COLOR:RED">Pemilik Proyek Belum Terdaftar </li>';
                }
                // return output result array
                return $output;
            }
        }
    }
    
    //proses pencarian terjamin/ Kontraktor
     public function search(Request $request) {
        // check if ajax request is coming or not
         if (isset($request->idsppb)){
             
                         $data = Sppsb::where('id',  $request->idsppb )
                        ->first();
//              dd($data);
                    $data_kontraktor = Sppsb::where('nama_kontraktor', $data->nama_kontraktor)
                            ->orderBy('tgl_dokumen','Asc')
                            ->get();
                 
            $output = [
                 'nama_kontraktor'   => $data->nama_kontraktor,
                'alamat_kontraktor' => $data->alamat_kontraktor, 
                'bidang_usaha' => $data->bidang_usaha,
                'nama_direksi' => $data->direksi,
                'jabatan_direksi' =>  $data->jabatan_direksi,
                'data_kontraktor'   => $data_kontraktor, 
//                'no_permintaan_dokumen'   => $data->no_perjanjian, 
                ];
              
                
            echo json_encode($output);
              
         } else {
             //untuk menampilkan dalam bentuk li
          
//         if ($request->ajax()) {
         if ($request) {
           
                // select kontraktor name from database
                 $data = Sppsb::where('nama_kontraktor', 'LIKE', '%' . $request->kontraktor . '%')
                        ->groupBy('Sppsb.nama_kontraktor')
                        ->get();
                    
                // declare an empty array for output
                $output = '';
                // if searched countries count is larager than zero
                if (count($data) > 0) {
                    // concatenate output to the array
                    $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                    // loop through the result array
                    foreach ($data as $row) {
                        // concatenate output to the array
                        $output .= '<li class="list-group-item" name="'.$row->nama_kontraktor.'" id="' . $row->id . '" > <a class="btn">' . $row->nama_kontraktor . '</a></li>';
                    }
                    // end of output
                    $output .= '</ul>';
                } else {
                    // if there's no matching results according to the input
                    $output .= 'Register';
                }
                // return output result array
                return $output;
            }
        }
    }
    
   
     public function data()
    {
        return view('staff.sppsbtable');
    }
    
     
    public function insert(Request $request)
    { 
        $this->validate($request, [
            'no_registrasi' => 'required',
            'nama_kontraktor' => 'required',
            'alamat_kontraktor' => 'required',
            'alamat' => 'required',//alamat dinas(Penerima Jaminan)
            'direksi' => 'required',
            'jabatan_direksi' => 'required',
            'pemilik_proyek' => 'required',
            //'jabatan_pejabat' => 'required',
            'jenis_pekerjaan' => 'required',
            'nama_dokumen' => 'required',
            'no_dokumen' => 'required',
            'tgl_dokumen' => 'required',
            'sumber_dana' => 'required',
            'nilai_proyek' => 'required|numeric',
            'nilai_jaminan' => 'required|numeric',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:waktu_mulai',
            'tgl_cetak' => 'required',
            'skpd' => 'required', 
        ]);

        $data = $request->all();
        $nilaipenjaminan=($data['nilai_proyek']*$data['persentase_penjaminan'])/100;
        
//           dd(!is_null(  $data['pengerjaan_proyek']));
      
        if ($request->hasFile('dok1')) {
            $data['dok1'] =saveFile($request->file('dok1'));
        }else{
            $data['dok1'] = '';
        }
        if ($request->hasFile('dok2')) {
            $data['dok2'] = saveFile($request->file('dok2'));
        }else{
            $data['dok2'] = '';
        }
        if ($request->hasFile('dok3')) {
            $data['dok3'] = saveFile($request->file('dok3'));
        }else{
            $data['dok3'] = '';
        }
        if ($request->hasFile('dok4')) {
            $data['dok4'] = saveFile($request->file('dok4'));
        }else{
            $data['dok4'] = '';
        }
        if ($request->hasFile('dok5')) {
            $data['dok5'] = saveFile($request->file('dok5'));
        }else{
            $data['dok5'] = '';
        }
        if ($request->hasFile('dok6')) {
            $data['dok6'] = saveFile($request->file('dok6'));
        }else{
            $data['dok6'] = '';
        }
        //set data checkbox type (multiplechoise)

        $dokumen_pendukung = array(); 
        if(isset($data['dokumen_pendukung'])) {
            foreach ($data['dokumen_pendukung'] as $dokPendukung){
                $dokumen_pendukung[] = $dokPendukung;
            }
        }
        //set data radio button type
        if(!isset($data['pembayaran'])) {
            $data['pembayaran'] = '';
        }
        if(!isset($data['fasilitas'])) {
            $data['fasilitas'] = '';
        }

        //collect and set data JSON for web
        foreach( $data['type'] as $key => $n ) {
            $dataform[] = [
                            'type'     => $n,
                            'no'        => $data['no'][$key],
                            'nama'      => $data['nama'][$key],
                            'taksiran'  => $data['taksiran'][$key]
                        ];
        }
        
        foreach( $data['jenispekerjaan'] as $key => $n ) {
            $datapengalaman[] = [
                            'jenispekerjaan'     => $n,
                            'pemilikproyek'        => $data['pemilikproyek'][$key],
                            'nodokumen'      => $data['nodokumen'][$key],
                            'tgldokumen'  => $data['tgldokumen'][$key]
                        ];
        }
        
//        dd($data);
        
        
//        $sppsb = DB::connection('KONEKSIWEB')//KONEKSI KE WEB
//            ->table('sppsb')
//            ->insert([
//                    'user_id'           => Auth::user()->id,
//                    'no_registrasi'     => $data['no_registrasi'], 
//                    'nama_dokumen'      => $data['nama_dokumen'], 
//                    'no_dokumen'        => $data['no_dokumen'], 
//                    'tgl_dokumen'       => date('Y-m-d', strtotime($data['tgl_dokumen'])),
//                    'nama_kontraktor'   => $data['nama_kontraktor'],
//                    'bidang_usaha'      => $data['bidang_usaha'],
//                    'alamat_kontraktor' => $data['alamat_kontraktor'],
//                    'direksi'           => $data['direksi'],
//                    'jabatan_direksi'   => $data['jabatan_direksi'],
//                    'dokumen_pendukung' => json_encode($dokumen_pendukung),
//                    'pemilik_proyek'    => $data['pemilik_proyek'],
//                    'nama_pejabat'      => $data['nama_pejabat'],
//                    'jabatan_pejabat'   => $data['jabatan_pejabat'],
//                    'alamat'            => $data['alamat'],
//                    'jenis_pekerjaan'   => $data['jenis_pekerjaan'],  
//                    'pembayaran'        => $data['pembayaran'],
//                    'jml_termin'        => $data['jml_termin'], 
//                    'fasilitas'         => $data['fasilitas'],  
//                    'persentase'        => $data['persentase'], 
//                    'sumber_dana'       => $data['sumber_dana'], 
//                    'nilai_proyek'      => $data['nilai_proyek'], 
//                    'nilai_jaminan'     => $data['nilai_jaminan'], 
//                    'waktu_mulai'       => date('Y-m-d', strtotime($data['startDate'])),
//                    'waktu_selesai'     => date('Y-m-d', strtotime($data['endDate'])),     
//                    'durasi'            => $data['durasi'],  
//                    'tgl_cetak'         => date('Y-m-d', strtotime($data['tgl_cetak'])),     
//                    'dokumen1'          => $data['dok1'],        
//                    'dokumen2'          => $data['dok2'],        
//                    'dokumen3'          => $data['dok3'],        
//                    'dokumen4'          => $data['dok4'],        
//                    'dokumen5'          => $data['dok5'],        
//                    'dokumen6'          => $data['dok6'],  
//                    'barang_agunan'     => json_encode($dataform),             
//                    'jenis_sppsb'       => $data['jenis'],
//                    'skpd'              => $data['skpd'],
//                    'status'            => 'B',
//                    'created_by'        => Auth::user()->username
//                ]);	
        $sppsbsimpan = new Sppsb;
//        $sppsbsimpan->setConnection('KONEKSIWEB'); // non-static method
      
//        $sppsb = $sppsbsimpan->create([
           $sppsb =   Sppsb::create([
            'user_id'           => Auth::user()->id,
            'no_registrasi'     => $data['no_registrasi'], 
            'nama_dokumen'      => $data['nama_dokumen'], 
            'no_dokumen'        => $data['no_dokumen'], 
            'tgl_dokumen'       => date('Y-m-d', strtotime($data['tgl_dokumen'])),
            'nama_kontraktor'   => $data['nama_kontraktor'],
            'bidang_usaha'      => $data['bidang_usaha'],
            'alamat_kontraktor' => $data['alamat_kontraktor'],
            'direksi'           => $data['direksi'],
            'jabatan_direksi'   => $data['jabatan_direksi'],
            'dokumen_pendukung' => json_encode($dokumen_pendukung),
            'pemilik_proyek'    => $data['pemilik_proyek'],
            'nama_pejabat'      => $data['nama_pejabat'],
            'jabatan_pejabat'   => $data['jabatan_pejabat'],
            'alamat'            => $data['alamat'],
            'jenis_pekerjaan'   => $data['jenis_pekerjaan'],  
            'pembayaran'        => $data['pembayaran'],
            'jml_termin'        => $data['jml_termin'], 
            'fasilitas'         => $data['fasilitas'],  
            'persentase'        => $data['persentase'], 
            'sumber_dana'       => $data['sumber_dana'], 
            'nilai_proyek'      => $data['nilai_proyek'], 
            'nilai_jaminan'     => $nilaipenjaminan, 
            'waktu_mulai'       => date('Y-m-d', strtotime($data['startDate'])),
            'waktu_selesai'     => date('Y-m-d', strtotime($data['endDate'])),     
            'durasi'            => $data['durasi'],  
            'tgl_cetak'         => date('Y-m-d', strtotime($data['tgl_cetak'])),     
            'dokumen1'          => $data['dok1'],        
            'dokumen2'          => $data['dok2'],        
            'dokumen3'          => $data['dok3'],        
            'dokumen4'          => $data['dok4'],        
            'dokumen5'          => $data['dok5'],        
            'dokumen6'          => $data['dok6'],  
            'barang_agunan'     => json_encode($dataform),             
            'pengalaman_kontraktor'     => json_encode($datapengalaman),             
            'jenis_sppsb'       => $data['jenis'],
            'skpd'              => $data['skpd'],
            'status'            => 'B',
            'created_by'        => Auth::user()->username
        ]);	
             
//             dd($sppsb);
           $history = 
//              DB::connection('KONEKSIWEB')//KONEKSI KE WEB
              DB::
             table('historys')
            ->insert([
                'sppsb_id'  => $sppsb->id,
                'proses'    => 'Baru',
                'author'    => Auth::user()->name,
                'remark'    => ''
            ]); 
           
         
//              DB::connection('KONEKSIWEB')//KONEKSI KE WEB
//              DB::
//             table('history_penjaminans')
//            ->insert([
           
           
        // if($data['jenis']=='4'){
        //    $history_penjaminan = 
        //     HistoryPenjaminan::create([// jika menggunanak class create maka akan terbentu created_at dan update_at secara otomatis
        //     'sppsb_id'  => $sppsb->id,
        //      'dijamin_jamkrida'  => $data['pialang'],
        //     'no_sertifikat'    => $data['nomor_sertifikat'],
        //      'nama_asuransi'    => $data['nama_asuransi'],
        //     'deskripsi_singkat'    => $data['deskripsi'],
        //     'penyelesaian_tepat'    => $data['pengerjaan_proyek'],
        //      'deskripsi_kendala'    => $data['kendala'], 
        //  ]); 
        // }

        if($data['jenis']=='4'){
               
                if( !is_null( $request->pengerjaan_proyek)){
               
                      $history_penjaminan = 
                     HistoryPenjaminan::create([// jika menggunanak class create maka akan terbentu created_at dan update_at secara otomatis
                     'sppsb_id'  => $sppsb->id,
                     'dijamin_jamkrida'  => $request->pialang,
                     'no_sertifikat'    => $request->nomor_sertifikat,
                     'nama_asuransi'    => $request->nama_asuransi,
                     'deskripsi_singkat'    => $request->deskripsi,
                     'penyelesaian_tepat'    => $request->pengerjaan_proyek,
                     'deskripsi_kendala'    => $request-kendala
                 ]); 
           }
             
           
           }
       
           
        
        return redirect('/sppsb-detail-staff/'.$sppsb->id);
    }

    public function edit($id)
    {       
  
//        $sppsb = Sppsb::findOrFail($id);  
        $sppsb = Sppsb::select('*','sppsb.id as sppsb_id','sppsb.id')
                 ->leftJoin('history_penjaminans','history_penjaminans.sppsb_id','=','sppsb.id')
                ->where('sppsb.id',$id)->first();
     
        $dokPendukung = json_decode($sppsb->dokumen_pendukung);
        $brgAgunan = json_decode($sppsb->barang_agunan);
        $pengalamanKontraktor = json_decode($sppsb->pengalaman_kontraktor);
//           dd($sppsb);
        return view('staff.sppsbedit',compact('sppsb','dokPendukung','brgAgunan','pengalamanKontraktor'));
    }

    public function update(Request $request)
    {
      
        $this->validate($request, [
            'no_registrasi' => 'required',
            'nama_kontraktor' => 'required',
            'alamat_kontraktor' => 'required',
            'direksi' => 'required',
            'jabatan_direksi' => 'required',
            'pemilik_proyek' => 'required',
            //'jabatan_pejabat' => 'required',
            'jenis_pekerjaan' => 'required',
            'nama_dokumen' => 'required',
            'no_dokumen' => 'required',
            'tgl_dokumen' => 'required',
            'sumber_dana' => 'required',
            'nilai_proyek' => 'required',
            'nilai_jaminan' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:waktu_mulai',
            'tgl_cetak' => 'required',
            'skpd' => 'required',
        ]);
        $data = $request->all();  
        //set data checkbox type (multiplechoise)
        $dokumen_pendukung = array(); 
        if(isset($data['dokumen_pendukung'])) {
            foreach ($data['dokumen_pendukung'] as $dokPendukung){
                $dokumen_pendukung[] = $dokPendukung;
            }
        }else{
            $dokumen_pendukung[]='';
        }
        //set data radio button type
        if(!isset($data['pembayaran'])) {
            $data['pembayaran'] = '';
        }
        if(!isset($data['fasilitas'])) {
            $data['fasilitas'] = '';
        }
        //collect and set data JSON for web
        foreach( $data['type'] as $key => $n ) {
            $dataform[] = [
                            'type'     => $n,
                            'no'        => $data['no'][$key],
                            'nama'      => $data['nama'][$key],
                            'taksiran'  => $data['taksiran'][$key]
                        ];
            
        }
        
            

        if ($request->jenispekerjaan==null){ 
                   $pengalaman=null;
        }else{
         
                foreach ($data['jenispekerjaan'] as $key => $n) {
                        $datapengalaman[] = [
                            'jenispekerjaan' => $n,
                            'pemilikproyek' => $data['pemilikproyek'][$key],
                            'nodokumen' => $data['nodokumen'][$key],
                            'tgldokumen' => $data['tgldokumen'][$key]
                        ];
                    }
                   $pengalaman= json_encode($datapengalaman);
        }
       
        
//           dd($data);
        $sppsb = Sppsb::findOrFail($data['id']);
    
//       $sppsb = Sppsb::leftJoin('history_penjaminans','history_penjaminans.sppsb_id','=','Sppsb.id')->where('Sppsb.id',$data['id'])->first();
          
        if ($request->hasFile('dok1')) {
            $data['dok1'] = saveFile($request->file('dok1'));
            $sppsb->dokumen1            = $data['dok1'];
        }
        if ($request->hasFile('dok2')) {
            $data['dok2'] = saveFile($request->file('dok2'));
            $sppsb->dokumen2            = $data['dok2'];
        }
        if ($request->hasFile('dok3')) {
            $data['dok3'] = saveFile($request->file('dok3'));
            $sppsb->dokumen3            = $data['dok3'];
        }
        if ($request->hasFile('dok4')) {
            $data['dok4'] = saveFile($request->file('dok4'));
            $sppsb->dokumen4            = $data['dok4'];
        }
        if ($request->hasFile('dok5')) {
            $data['dok5'] = saveFile($request->file('dok5'));
            $sppsb->dokumen5            = $data['dok5'];
        }
        if ($request->hasFile('dok6')) {
            $data['dok6'] = saveFile($request->file('dok6'));
            $sppsb->dokumen6     = $data['dok6'];
        }
        
    
        $sppsb->no_registrasi = $data['no_registrasi'];
        $sppsb->nama_dokumen = $data['nama_dokumen'];
        $sppsb->no_dokumen = $data['no_dokumen'];
        $sppsb->tgl_dokumen = date('Y-m-d', strtotime($data['tgl_dokumen']));
        $sppsb->nama_kontraktor = $data['nama_kontraktor'];
        $sppsb->bidang_usaha = $data['bidang_usaha'];
        $sppsb->alamat_kontraktor = $data['alamat_kontraktor'];
        $sppsb->direksi = $data['direksi'];
        $sppsb->jabatan_direksi = $data['jabatan_direksi'];
        $sppsb->dokumen_pendukung = json_encode($dokumen_pendukung);
        $sppsb->pengalaman_kontraktor = $pengalaman;
        $sppsb->pemilik_proyek = $data['pemilik_proyek'];
        $sppsb->nama_pejabat = $data['nama_pejabat'];
        $sppsb->jabatan_pejabat = $data['jabatan_pejabat'];
        $sppsb->alamat = $data['alamat'];
        $sppsb->jenis_pekerjaan = $data['jenis_pekerjaan'];
        $sppsb->pembayaran = $data['pembayaran'];
        $sppsb->jml_termin = $data['jml_termin'];
        $sppsb->fasilitas = $data['fasilitas'];
        $sppsb->persentase = $data['persentase'];
        $sppsb->sumber_dana = $data['sumber_dana'];
        $sppsb->nilai_proyek = $data['nilai_proyek'];
        $sppsb->nilai_jaminan = $data['nilai_jaminan'];
        $sppsb->waktu_mulai = date('Y-m-d', strtotime($data['startDate']));
        $sppsb->waktu_selesai = date('Y-m-d', strtotime($data['endDate']));
        $sppsb->durasi = $data['durasi'];
        $sppsb->tgl_cetak = date('Y-m-d', strtotime($data['tgl_cetak']));
        $sppsb->barang_agunan = json_encode($dataform);
        $sppsb->jenis_sppsb = $data['jenis'];
        $sppsb->skpd = $data['skpd'];
        $sppsb->updated_by = Auth::user()->username;
        $sppsb->save();
        
      
                
          if ($request->pialang) {
                HistoryPenjaminan::where('sppsb_id',$data['id'])
                ->  update([// jika menggunanak class create maka akan terbentu created_at dan update_at secara otomatis 
                  'dijaminan_jamkrida'  => $data['pialang'],
                  'no_sertifikat'    => $data['nomor_sertifikat'],
                  'nama_asuransi'    => $data['nama_asuransi'],
                  'deskripsi_singkat'    => $data['deskripsi'],
                  'penyelesaian_tepat'    => $data['pengerjaan_proyek'],
                  'deskripsi_kendala'    => $data['kendala'], 
              ]);
          }
        
        
       
        Session::flash('msgupdate','SPPSB dengan no registrasi '.$sppsb->no_registrasi.' berhasil di update');
		return redirect('/sppsb-detail-staff/'.$data['id']);
    }
    
     public function detail($id)
     {
//        $sppsb = DB::connection('KONEKSIWEB')//KONEKSI KE WEB
        $sppsb = DB::table('sppsb')
                ->select('*','sppsb.id as sppsb_id')
                ->leftjoin('history_penjaminans','history_penjaminans.sppsb_id','=','sppsb.id')
                ->leftjoin('analisas','analisas.sppsb_id','=','sppsb.id')
                ->leftjoin('results','results.sppsb_id','=','sppsb.id')
                ->where('sppsb.id',$id)
                 ->first();   
        
          $data_kontraktor = Sppsb::where('nama_kontraktor', $sppsb->nama_kontraktor) 
                            ->whereNotIn('id',[$sppsb->sppsb_id])
                            ->orderBy('tgl_dokumen','Asc')
                            ->get(); 
          
          
//                dd($data_kontraktor);
//             dd(Auth::user()->role);
   
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
//        dd($sppsb->user_id);
        $dokPendukung = json_decode($sppsb->dokumen_pendukung);
        $brgAgunan = json_decode($sppsb->barang_agunan);
        $pengalamanKontraktor = json_decode($sppsb->pengalaman_kontraktor);
        $nilaiProyek = ucwords(terbilang($sppsb->nilai_proyek));
        $nilaiJaminan = ucwords(terbilang($sppsb->nilai_jaminan));
        
//        dd($pengalamanKontraktor);
        
//        $admin = DB::connection('KONEKSIWEB')//KONEKSI KE WEB
        $admin = DB::
                table('options')
                ->where('id','2')
                ->first();   
       
//        $materai = DB::connection('KONEKSIWEB')//KONEKSI KE WEB
        $materai = DB::
                table('options')
                ->where('id','3')
                ->first();  
        
        $analisa = Analisa::where('sppsb_id',$id)->first();
        
        $hasilAnalisa = json_decode($sppsb->analisa_staff);
                
//          dd($analisa);
        
        if($sppsb->status=='C' || $sppsb->status=='S'){
//            $result = DB::connection('KONEKSIWEB')//KONEKSI KE WEB
            $result = DB::table('results')
                ->where('sppsb_id',$id)
                ->first(); 
            $charge = $result->service_charge;
            $rate = $result->rate_ijp;
            $fee = $result->fee_agen;
            $feeAdmin = $result->fee_admin;
            $materai = $result->materai;
        }else{            
//            $serviceCharge = ceil((new DireksiController)->calculateIjp($sppsb->waktu_mulai,$sppsb->waktu_selesai,$sppsb->nilai_jaminan,$sppsb->jenis_sppsb,$admin->value,$materai->value,'SPPSB'));
//            $charge = (new DireksiController)->pembulatan($serviceCharge);
//            $rate = getRate($sppsb->waktu_mulai, $sppsb->waktu_selesai, $sppsb->jenis_sppsb);
//            $fee = $agen->fee_sppsb;
//            $feeAdmin = $admin->value;
//            $materai = $materai->value;
            
            $result = DB::table('results')
                ->where('sppsb_id',$id)
                ->first(); 
//            dd(!$result);
            if(!$result){
                $charge =  0;
                $rate =0;
                $fee = 0;
                $feeAdmin = 0;
                $materai = 0;
            }else{
                 $charge =  (new DireksiController)->pembulatan($result->service_charge);
                $rate = $result->rate_ijp;
                $fee = $result->fee_agen;
                $feeAdmin = $result->fee_admin;
                $materai = $result->materai;
            }
           
        }
//           dd($charge);
//             dd($result);
//                dd($rate);
                
//                        dd($sppsb);
          if($sppsb->fee<1){
                   $fee = $agen->fee_sppsb;
          }else{
                 $fee = $sppsb->fee;
          }
          
//          dd($fee);
//          dd($sppsb);
//        $grossIjp = ($sppsb->nilai_jaminan*$rate)/100;
        $grossIjp = ($sppsb->service_charge-($sppsb->fee_admin+$sppsb->materai));
        $feeAgen = ($grossIjp*$fee)/100;
     
//        dd($grossIjp);
        
        $history = '';
        if ($sppsb->status == 'R') {
            $where = ['proses' => 'revisi', 'sppsb_id' => $id];
          
            $history = 
//                     DB::connection('KONEKSIWEB')//KONEKSI KE WEB
                     DB::table('historys')
                ->where($where)
                ->orderBy('id', 'desc')
                ->first();  
                    
        } elseif ($sppsb->status == 'T') {
            $where = ['proses' => 'tolak', 'sppsb_id' => $id];
            $history = 
//                     DB::connection('KONEKSIWEB')//KONEKSI KE WEB
                     DB::table('historys')
                ->where($where)
                ->orderBy('id', 'desc')
                ->first();  
        }
        
   


        return view('staff.detailsppsb', compact(
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
                'analisa',
                'hasilAnalisa',
                'data_kontraktor',
                'pengalamanKontraktor',
                'materai'));
    }
    
     public function getDataTable()
    {
            IF(Auth::user()->jabatan=='Kabag'){
                    $sppsb = DB::table('sppsb')
                        ->select('sppsb.id',
                                'sppsb.nama_kontraktor',
                                'sppsb.direksi',
                                'sppsb.no_jaminan',
                                'sppsb.jenis_sppsb',
                                'sppsb.status',
                                'sppsb.status_bayar',
                                'sppsb.fee',
                                'users.name',
                                DB::raw("(DATE_FORMAT(sppsb.created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                        )
                        ->leftJoin('users','users.id','=','sppsb.user_id') 
                        ->orderBy('sppsb.updated_at','DESC')
                        ->get();
            }else{
                    $sppsb = DB::table('sppsb')
                        ->select('sppsb.id',
                                'sppsb.nama_kontraktor',
                                'sppsb.direksi',
                                'sppsb.no_jaminan',
                                'sppsb.jenis_sppsb',
                                'sppsb.status',
                                'sppsb.fee',
                                'sppsb.status_bayar',
                                'users.name',
                                DB::raw("(DATE_FORMAT(sppsb.created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                        )
                        ->leftJoin('users','users.id','=','sppsb.user_id')
                        ->where('sppsb.user_id',Auth::user()->id)
                        ->orderBy('sppsb.updated_at','DESC')
                        ->get();
            }
         

        return Datatables::of($sppsb)
            ->addColumn('action', function ($sppsb) {
                IF(Auth::user()->jabatan=='Kabag'){
                       if ($sppsb->status == 'D' || $sppsb->status == 'R' || $sppsb->status == 'B') {
                                        $disabled = 'href="#" onclick="return false;" class="icon-button"';  
                                        $disabled1 = 'href="#" onclick="return false;" class="icon-button"';  
                            }else{      
                                if($sppsb->status=='C')
                                {
                                       $disabled ='href="#" onclick="return false;" class="icon-button"'; 
                                       $disabled1 = 'href="sppsb-detail-staff/' . $sppsb->id . '" class="icon-button icon-color-blue"';
                                }
                                else
                                {
                                       $disabled ='href="#" onclick="return false;" class="icon-button"'; 
                                       $disabled1 = 'href="sppsb-detail-staff/' . $sppsb->id . '" class="icon-button icon-color-blue"';
                                }
                                    

                             }
                 }else{
                       if ($sppsb->status == 'D' || $sppsb->status == 'R' || $sppsb->status == 'B') {
                                    $disabled = 'href="sppsb-edit-staff/' . $sppsb->id . '" class="icon-button icon-color-blue"';
                                    $disabled1 = 'href="sppsb-detail-staff/' . $sppsb->id . '" class="icon-button icon-color-grey"';

                            }else{
                                 if($sppsb->status=='C')
                                {
                                      $disabled = 'href="#" onclick="return false;" class="icon-button"';   
                                     $disabled1 = 'href="sppsb-detail-staff/' . $sppsb->id . '" class="icon-button icon-color-grey"';  
                                }else{
                                     $disabled = 'href="#" onclick="return false;" class="icon-button"';   
                                     $disabled1 = 'href="#" onclick="return false;" class="icon-button"';  
                                }
                                     
 
                             }
                  }
               
                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                            <a '. $disabled .'>
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a '.$disabled1.'>
                                <i class="fa fa-search"></i>
                                
                            </a>
                        </div>';
            })
            
            ->make(true);
    }
    
       
}
