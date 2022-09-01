<?php

namespace App\Http\Controllers;

use App\Agen;
use App\Sppsb;
use App\Sp3kbg;
use App\Bank;
use App\History;
use Datatables;
use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AgenController extends Controller
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

    public function form()
    {
    	return view('agen.sppsbform');
    }
    
    public function insert(Request $request)
    {
        

        
        if($request->skpd){
           $cekskpd= $request->skpd;
        }else{
           $cekskpd ='T';
        }
        
        $this->validate($request,[
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
            ($cekskpd !='T') ? "'skpd' => 'required'":"", 
          
        ]);

        $data = $request->all();
        
        if ($request->hasFile('dok1')) {
            $data['dok1'] = $this->saveFile($request->file('dok1'));
        }else{
            $data['dok1'] = '';
        }
        if ($request->hasFile('dok2')) {
            $data['dok2'] = $this->saveFile($request->file('dok2'));
        }else{
            $data['dok2'] = '';
        }
        if ($request->hasFile('dok3')) {
            $data['dok3'] = $this->saveFile($request->file('dok3'));
        }else{
            $data['dok3'] = '';
        }
        if ($request->hasFile('dok4')) {
            $data['dok4'] = $this->saveFile($request->file('dok4'));
        }else{
            $data['dok4'] = '';
        }
        if ($request->hasFile('dok5')) {
            $data['dok5'] = $this->saveFile($request->file('dok5'));
        }else{
            $data['dok5'] = '';
        }
        if ($request->hasFile('dok6')) {
            $data['dok6'] = $this->saveFile($request->file('dok6'));
        }else{
            $data['dok6'] = '';
        }
        //set data checkbox type (multiplechoise)
        
        if(isset($data['skpd']))
        {
            $skpd=$data['skpd'];
        }
        else
        {
           $skpd='1';
        }
        
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

            $symbols=array(' ','!','"','#','$','%','&','\'','(',')','*','+',',','-','.','/',':',';','<','>','=','?','@','[',']','\\','^','_','{','}','|','~','`','\r','\n','\r\n');

        $sppsb = Sppsb::create([
            'user_id'           => Auth::user()->id,
            'no_registrasi'     => $data['no_registrasi'], 
            'nama_dokumen'      => $data['nama_dokumen'], 
            'no_dokumen'        => $data['no_dokumen'], 
            'tgl_dokumen'       => date('Y-m-d', strtotime($data['tgl_dokumen'])),
            'nama_kontraktor'   => str_replace($symbols,'',$data['nama_kontraktor']),
            'bidang_usaha'      => $data['bidang_usaha'],
            'alamat_kontraktor' => $data['alamat_kontraktor'],
            'direksi'           => $data['direksi'],
            'jabatan_direksi'   => $data['jabatan_direksi'],
            'dokumen_pendukung' => json_encode($dokumen_pendukung),
            'pemilik_proyek'    => str_replace($symbols,'',$data['pemilik_proyek']), 
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
            'nilai_jaminan'     => $data['nilai_jaminan'], 
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
            'jenis_sppsb'       => $data['jenis'],
            'skpd'              => $skpd,
            'created_by'        => Auth::user()->username
        ]);	
//       DD($request);
        return redirect('/sppsb-detail/'.$sppsb->id);
    }

    public function edit($id)
    {        
        $sppsb = Sppsb::findOrFail($id);  
        $dokPendukung = json_decode($sppsb->dokumen_pendukung);
        $brgAgunan = json_decode($sppsb->barang_agunan);
        return view('agen.sppsbedit',compact('sppsb','dokPendukung','brgAgunan'));
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
        $sppsb = Sppsb::findOrFail($data['id']);


        if ($request->hasFile('dok1')) {
            $data['dok1'] = $this->saveFile($request->file('dok1'));
            $sppsb->dokumen1            = $data['dok1'];
        }
        if ($request->hasFile('dok2')) {
            $data['dok2'] = $this->saveFile($request->file('dok2'));
            $sppsb->dokumen2            = $data['dok2'];
        }
        if ($request->hasFile('dok3')) {
            $data['dok3'] = $this->saveFile($request->file('dok3'));
            $sppsb->dokumen3            = $data['dok3'];
        }
        if ($request->hasFile('dok4')) {
            $data['dok4'] = $this->saveFile($request->file('dok4'));
            $sppsb->dokumen4            = $data['dok4'];
        }
        if ($request->hasFile('dok5')) {
            $data['dok5'] = $this->saveFile($request->file('dok5'));
            $sppsb->dokumen5            = $data['dok5'];
        }
        if ($request->hasFile('dok6')) {
            $data['dok6'] = $this->saveFile($request->file('dok6'));
            $sppsb->dokumen6            = $data['dok6'];
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
        $sppsb->updated_by = Auth::user()->username;
        $sppsb->save();

        IF ( Auth::user()->role=='AA'){
               Session::flash('msgupdate','SPPSB dengan no registrasi '.$sppsb->no_registrasi.' berhasil di update');
		return redirect('/sppsb-detail/'.$data['id']);
         }else{
               Session::flash('msgupdate','SPPSB dengan no registrasi '.$sppsb->no_registrasi.' berhasil di update');
		return redirect('/sppsb-detail-staff/'.$data['id']);
         }
      
    }

    public function data()
    {
        return view('agen.sppsbtable');
    }

    public function getDataTable()
    {
        $sppsb = DB::table('sppsb')
                        ->select('sppsb.id',
                                'sppsb.nama_kontraktor',
                                'sppsb.direksi',
                                'sppsb.jenis_sppsb',
                                'sppsb.status',
                                DB::raw("(DATE_FORMAT(sppsb.created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                        )
                        ->leftJoin('users','users.id','=','sppsb.user_id')
                        ->where('sppsb.user_id',Auth::user()->id)
                        ->whereIn('sppsb.status',array('D','B','R','T','P','C'))
                        ->orderBy('sppsb.created_at','DESC')
                        ->get();

        return Datatables::of($sppsb)
            ->addColumn('action', function ($sppsb) {
                $disabled = 'href="#" onclick="return false;" class="icon-button"';               
                if($sppsb->status == 'D' || $sppsb->status == 'R'){
                    $disabled='href="sppsb-edit/'.$sppsb->id.'" class="icon-button icon-color-blue"'; 
                }
               
                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                            <a '. $disabled .'>
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="sppsb-detail/'.$sppsb->id.'" class="icon-button icon-color-grey">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>';
            })
            
            ->make(true);
    }
    public function cetak()
    {
//        $data= $enkripsi('test');
//        dd($data);
        return view('agen.sppsbcetak');
    }
    
    function enkripsi( $string )
{
    $output = false;
 
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'sakkarupa';
    $secret_iv = 'sakkarupa';
 
    // hash
    $key = hash('sha256', $secret_key);
     
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
 
    return $output;
}

    public function getCetakSppsbTable()
    {
        if(Auth::user()->jabatan=='Agen'){
            $whereCondition = [['sppsb.user_id',Auth::user()->id],['sppsb.status','=','C']];
        }else{
            if(Auth::user()->jabatan=='Direksi'){
                $whereCondition = [['historys.author','=',Auth::user()->name]];   
            }else{
                $whereCondition = [['sppsb.status','=','C']];   
            }
           
        }
         
        $sppsb = DB::
//                    connection('KONEKSIWEB')//KONEKSI KE WEB
                     table('sppsb')
                    ->select('sppsb.id',
                            'sppsb.user_id',
                            'sppsb.user_id',
                            'sppsb.no_sertifikat',
                            'sppsb.nama_kontraktor',
                            'sppsb.direksi',
                            'sppsb.status',
                            'sppsb.nilai_jaminan',
                            'sppsb.jenis_sppsb',
                            'historys.author',
                            'historys.remark',
                            'users.name',
                             'sppsb.no_jaminan',
                            DB::raw("(DATE_FORMAT(historys.created_at,'%d/%m/%Y')) AS tgl_disetujui"),
                            DB::raw("(DATE_FORMAT(sppsb.created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                    )
                    ->leftJoin('historys','historys.sppsb_id','=','sppsb.id')
                    ->leftJoin('users','users.id','=','sppsb.user_id') 
                    ->leftJoin('results','results.sppsb_id','=','sppsb.id') 
                    ->where($whereCondition)
                    ->orderBy('sppsb.updated_at','DESC')
                    ->groupBy('sppsb.id')
                    ->get();

        return Datatables::of($sppsb)
            ->addColumn('action', function ($sppsb) {

                $agen = Agen::where('user_id',$sppsb->user_id)->first();
                $maxNoReg = ltrim($agen->max_no_reg, '0');
                $noSertifikat = ltrim($sppsb->no_sertifikat, '0');
                if($noSertifikat>$maxNoReg){
                    $linkSertifikat = '<a id="invalidCetak" href="javascript:void(0);" class="icon-button icon-color-green" target="blank">
                                            <i class="fa fa-print"></i>
                                        </a>';
                }else{
                    $linkSertifikat = '<a id="printSertifikat'.$sppsb->id.'" href="cetak-sertifikat-sppsb/'.$sppsb->id.'" class="icon-button icon-color-green" target="_blank">
                                            <i class="fa fa-print"></i>
                                        </a>';
                                    //    <script>$("#printSertifikat'.$sppsb->id.'").printPage();</script>';
                }

                if(Auth::user()->jabatan=='Agen'){

                    return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                '.$linkSertifikat.'
                                <a href="cetak-perjanjian-ganti-rugi/'.$sppsb->id.'" class="icon-button icon-color-blue" target="blank">
                                    <i class="fa fa-handshake-o"></i>
                                </a>
                                 
                                 <a href="cetak-detail-sppsb/' . $sppsb->id . '" class="icon-button icon-color-grey">
                                 <i class="glyphicon glyphicon-print"></i>
                                </a>
                                
                            </div>';
                }else{
                  
//                    dd(Auth::user()->jabatan);
                    if(Auth::user()->jabatan=='Direksi'){
                          return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                '.$linkSertifikat.' 
                            </div>';
                    }else{
                          return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                '.$linkSertifikat.' 
                                       <a href="cetak-perjanjian-ganti-rugi/'.$sppsb->id.'" class="icon-button icon-color-blue" target="blank">
                                    <i class="fa fa-handshake-o"></i>
                                </a>
                                
                                <a href="sppsb-detail-staff/' . $sppsb->id . '" class="icon-button icon-color-grey">
                                 <i class="fa fa-search"></i>
                                </a>
                            </div>';
//                            
                    }
                  
                }
            })
            ->make(true);
    }
    

    //////////////////////////////////////////////////////////////////////// modul sp3kbg /////////////////////////////////////////////
    public function formSp3kbg()
    {
        $bank = Bank::all();
        return view('agen.sp3kbgform', compact('bank'));
    }

    public function insertSp3kbg(Request $request)
    {
        $this->validate($request, [
            'no_registrasi' => 'required',
            'nama_kontraktor' => 'required',
            'alamat_kontraktor' => 'required',
            'direksi' => 'required',
            'jabatan_direksi' => 'required',
            'pemilik_proyek' => 'required',
            'bank' => 'required',
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
        ]);

        $data = $request->all();
        
        if ($request->hasFile('dok1')) {
            $data['dok1'] = $this->saveFile($request->file('dok1'));
        }else{
            $data['dok1'] = '';
        }
        if ($request->hasFile('dok2')) {
            $data['dok2'] = $this->saveFile($request->file('dok2'));
        }else{
            $data['dok2'] = '';
        }
        if ($request->hasFile('dok3')) {
            $data['dok3'] = $this->saveFile($request->file('dok3'));
        }else{
            $data['dok3'] = '';
        }
        if ($request->hasFile('dok4')) {
            $data['dok4'] = $this->saveFile($request->file('dok4'));
        }else{
            $data['dok4'] = '';
        }
        if ($request->hasFile('dok5')) {
            $data['dok5'] = $this->saveFile($request->file('dok5'));
        }else{
            $data['dok5'] = '';
        }
        if ($request->hasFile('dok6')) {
            $data['dok6'] = $this->saveFile($request->file('dok6'));
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

        $sp3kbg = Sp3kbg::create([
            'user_id'                   => Auth::user()->id,
            'bank_id'                   => $data['bank'],
            'no_registrasi'         => $data['no_registrasi'], 
            'nama_dokumen'   => $data['nama_dokumen'], 
            'no_dokumen'         => $data['no_dokumen'], 
            'tgl_dokumen'           => date('Y-m-d', strtotime($data['tgl_dokumen'])),
            'nama_kontraktor'   => $data['nama_kontraktor'],
            'bidang_usaha'          => $data['bidang_usaha'],
            'alamat_kontraktor' => $data['alamat_kontraktor'],
            'direksi'                       => $data['direksi'],
            'jabatan_direksi'       => $data['jabatan_direksi'],
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
            'nilai_jaminan'     => $data['nilai_jaminan'], 
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
            'jenis_sp3kbg'       => $data['jenis'],
            'created_by'        => Auth::user()->username
        ]); 

        return redirect('/sp3kbg-detail/'.$sp3kbg->id);
    }

    public function editSp3kbg($id)
    {        
        $sp3kbg = Sp3kbg::findOrFail($id);  
        $bank = Bank::all();
        $dokPendukung = json_decode($sp3kbg->dokumen_pendukung);
        $brgAgunan = json_decode($sp3kbg->barang_agunan);
        return view('agen.sp3kbgedit',compact('sp3kbg','bank','dokPendukung','brgAgunan'));
    }

    public function updateSp3kbg(Request $request)
    {
        $this->validate($request, [
            'no_registrasi' => 'required',
            'nama_kontraktor' => 'required',
            'alamat_kontraktor' => 'required',
            'direksi' => 'required',
            'jabatan_direksi' => 'required',
            'pemilik_proyek' => 'required',
            'bank' => 'required',
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
        $sp3kbg = Sp3kbg::findOrFail($data['id']);


        if ($request->hasFile('dok1')) {
            $data['dok1'] = $this->saveFile($request->file('dok1'));
            $sp3kbg->dokumen1            = $data['dok1'];
        }
        if ($request->hasFile('dok2')) {
            $data['dok2'] = $this->saveFile($request->file('dok2'));
            $sp3kbg->dokumen2            = $data['dok2'];
        }
        if ($request->hasFile('dok3')) {
            $data['dok3'] = $this->saveFile($request->file('dok3'));
            $sp3kbg->dokumen3            = $data['dok3'];
        }
        if ($request->hasFile('dok4')) {
            $data['dok4'] = $this->saveFile($request->file('dok4'));
            $sp3kbg->dokumen4            = $data['dok4'];
        }
        if ($request->hasFile('dok5')) {
            $data['dok5'] = $this->saveFile($request->file('dok5'));
            $sp3kbg->dokumen5            = $data['dok5'];
        }
        if ($request->hasFile('dok6')) {
            $data['dok6'] = $this->saveFile($request->file('dok6'));
            $sp3kbg->dokumen6            = $data['dok6'];
        }

        $sp3kbg->bank_id             = $data['bank'];
        $sp3kbg->no_registrasi       = $data['no_registrasi'];
        $sp3kbg->nama_dokumen        = $data['nama_dokumen'];
        $sp3kbg->no_dokumen          = $data['no_dokumen'];
        $sp3kbg->tgl_dokumen         = date('Y-m-d', strtotime($data['tgl_dokumen']));
        $sp3kbg->nama_kontraktor     = $data['nama_kontraktor'];
        $sp3kbg->bidang_usaha        = $data['bidang_usaha'];
        $sp3kbg->alamat_kontraktor   = $data['alamat_kontraktor'];
        $sp3kbg->direksi             = $data['direksi']; 
        $sp3kbg->jabatan_direksi     = $data['jabatan_direksi'];  
        $sp3kbg->dokumen_pendukung   = json_encode($dokumen_pendukung);
        $sp3kbg->pemilik_proyek      = $data['pemilik_proyek'];
        $sp3kbg->nama_pejabat        = $data['nama_pejabat'];
        $sp3kbg->jabatan_pejabat     = $data['jabatan_pejabat'];
        $sp3kbg->alamat              = $data['alamat'];   
        $sp3kbg->jenis_pekerjaan     = $data['jenis_pekerjaan'];  
        $sp3kbg->pembayaran          = $data['pembayaran']; 
        $sp3kbg->jml_termin          = $data['jml_termin'];   
        $sp3kbg->fasilitas           = $data['fasilitas']; 
        $sp3kbg->persentase          = $data['persentase']; 
        $sp3kbg->sumber_dana         = $data['sumber_dana'];
        $sp3kbg->nilai_proyek        = $data['nilai_proyek'];
        $sp3kbg->nilai_jaminan       = $data['nilai_jaminan'];
        $sp3kbg->waktu_mulai         = date('Y-m-d', strtotime($data['startDate'])); 
        $sp3kbg->waktu_selesai       = date('Y-m-d', strtotime($data['endDate']));
        $sp3kbg->durasi              = $data['durasi'];
        $sp3kbg->tgl_cetak           = date('Y-m-d', strtotime($data['tgl_cetak']));
        $sp3kbg->barang_agunan       = json_encode($dataform);
        $sp3kbg->jenis_sp3kbg         = $data['jenis'];
        $sp3kbg->updated_by          = Auth::user()->username;
        $sp3kbg->save();

        Session::flash('msgupdate','SP3 KBG dengan no registrasi '.$sp3kbg->no_registrasi.' berhasil di update');
        return redirect('/sp3kbg-detail/'.$data['id']);
    }

    public function getCetakSp3kbgTable()
    {
        if(Auth::user()->jabatan=='Agen'){
            $whereCondition = [['historys.proses','Setuju'],['sp3kbg.user_id',Auth::user()->id],['sp3kbg.status','=','C']];
        }else{
            $whereCondition = [['historys.proses','Setuju'],['sp3kbg.status','=','C']];
        }
        $sp3kbg = DB::table('sp3kbg')
                    ->select('sp3kbg.id',
                            'sp3kbg.user_id',
                            'sp3kbg.no_sertifikat',
                            'sp3kbg.nama_kontraktor',
                            'sp3kbg.direksi',
                            'sp3kbg.status',
                            'sp3kbg.jenis_sp3kbg',
                            'historys.author',
                            'historys.remark',
                            DB::raw("(DATE_FORMAT(historys.created_at,'%d/%m/%Y')) AS tgl_disetujui"),
                            DB::raw("(DATE_FORMAT(sp3kbg.created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                    )
                    ->leftJoin('historys','historys.sp3kbg_id','=','sp3kbg.id')
                    ->where($whereCondition)
                    ->orderBy('sp3kbg.created_at','DESC')
                    ->get();

            return Datatables::of($sp3kbg)
                ->addColumn('action', function ($sp3kbg) 
                 {
                    $agen = Agen::where('user_id',$sp3kbg->user_id)->first();
                    $maxNoReg = ltrim($agen->max_no_reg, '0');
                    $noSertifikat = ltrim($sp3kbg->no_sertifikat, '0');
                    if($noSertifikat>$maxNoReg)
                    {
                        $linkSertifikat = '<a href="#" class="icon-button icon-color-green" target="blank">
                                                <i class="fa fa-print"></i>
                                            </a>';
                    }
                    else
                    {
                        $linkSertifikat = '<a id="printSertifikat'.$sp3kbg->id.'" href="cetak-sertifikat-sp3kbg/'.$sp3kbg->id.'" class="icon-button icon-color-green" target="blank">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            <script>$("#printSertifikat'.$sp3kbg->id.'").printPage();</script>';
                    }

                    if(Auth::user()->jabatan=='Agen')
                    {
                        return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    '.$linkSertifikat.'
                                    <a href="cetak-sp3kbg/'.$sp3kbg->id.'" class="icon-button icon-color-blue" target="blank">
                                        <i class="fa fa-handshake-o"></i>
                                    </a>
                                </div>';
                    }
                    else
                    {
                        return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    '.$linkSertifikat.'
                                </div>';
                    }
                    
            })
            ->make(true);
        
    }

    protected function saveFile($file)
    {
        
        $fileName = str_random(8) . '-' . $file->getClientOriginalName();
        // You can change this to anything you want.
        $destinationPath = 'uploads/' . Carbon::now()->year . '/' . Carbon::now()->month;
     
        // Check to see if the "destinationPath" exists if it doesn't create it.
        if (!is_dir($destinationPath))
        {
            mkdir($destinationPath, 0777, true);
        }
        //$destinationPath = public_path() . DIRECTORY_SEPARATOR . 'uploads';
        $file->move($destinationPath, $fileName);
        
        return 'uploads/' . Carbon::now()->year . '/' . Carbon::now()->month.'/'.$fileName;
        
    }
    
    
    public function getCetakSppsbTableKabag()
    {
//        dd();
         
       
        
        $sppsb = DB::
//                    connection('KONEKSIWEB')//KONEKSI KE WEB
                     table('v_approval_kabag')
                    ->select( 
                            'id',
                            'user_id',
                            'no_sertifikat',
                            'nama_kontraktor',
                            'direksi',
                            'status',
                            'nilai_jaminan',
                            'jenis_sppsb',
                            'author', 
                            'name',
                            'jabatan',
                             'no_jaminan',
                            DB::raw("(DATE_FORMAT(created_at,'%d/%m/%Y')) AS tgl_disetujui"),
                            DB::raw("(DATE_FORMAT(created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                    )
                    ->orderBy('updated_at','DESC')
                    ->groupBy('id')
                    ->get();

        return Datatables::of($sppsb)
            ->addColumn('action', function ($sppsb) {

                $agen = Agen::where('user_id',$sppsb->user_id)->first();
                $maxNoReg = ltrim($agen->max_no_reg, '0');
                $noSertifikat = ltrim($sppsb->no_sertifikat, '0');
                if($noSertifikat>$maxNoReg){
                    $linkSertifikat = '<a id="invalidCetak" href="javascript:void(0);" class="icon-button icon-color-green" target="blank">
                                            <i class="fa fa-print"></i>
                                        </a>';
                }else{
                    $linkSertifikat = '<a id="printSertifikat'.$sppsb->id.'" href="cetak-sertifikat-sppsb/'.$sppsb->id.'" class="icon-button icon-color-green" target="_blank">
                                            <i class="fa fa-print"></i>
                                        </a>';
                                    //    <script>$("#printSertifikat'.$sppsb->id.'").printPage();</script>';
                }

                if(Auth::user()->jabatan=='Agen'){
                        
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                '.$linkSertifikat.'
                                <a href="cetak-perjanjian-ganti-rugi/'.$sppsb->id.'" class="icon-button icon-color-blue" target="blank">
                                    <i class="fa fa-handshake-o"></i>
                                </a>
                                 
                                 <a href="cetak-detail-sppsb/' . $sppsb->id . '" class="icon-button icon-color-grey">
                                 <i class="glyphicon glyphicon-print"></i>
                                </a>
                                
                            </div>';
                }else{
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                '.$linkSertifikat.'
                               
                            </div>';
                }
            })
            ->make(true);
    }
    
      public function cetakkabag()
    {
//        $data= $enkripsi('test');
//        dd($data);
        return view('agen.sppsbcetakkabag');
    }

}
