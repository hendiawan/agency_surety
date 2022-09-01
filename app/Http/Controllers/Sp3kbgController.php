<?php

namespace App\Http\Controllers;

use App\Sp3kbg;
use App\Option;
use App\User;
use App\History;
use App\RateSp3kbg;
use App\Result;
use App\Bank;
use Datatables;
use Auth;
use DB;
use Mail;
use App\Mail\Reminder;
use Carbon\Carbon;
//use App\Http\Controllers\SppsbController;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class Sp3kbgController extends Controller
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

    public function getDataTable()
    {
        $sp3kbg = DB::table('sp3kbg')
                        ->select('sp3kbg.id',
                                'sp3kbg.nama_kontraktor',
                                'sp3kbg.direksi',
                                'sp3kbg.jenis_sp3kbg',
                                'sp3kbg.status',
                                DB::raw("(DATE_FORMAT(sp3kbg.created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                        )
                        ->leftJoin('users','users.id','=','sp3kbg.user_id')
                        ->where('sp3kbg.user_id',Auth::user()->id)
                        ->orderBy('sp3kbg.created_at','DESC')
                        ->get();

        return Datatables::of($sp3kbg)
            ->addColumn('action', function ($sp3kbg) {
                $disabled = 'href="#" onclick="return false;" class="icon-button"';               
                if($sp3kbg->status == 'D' || $sp3kbg->status == 'R'){
                    $disabled='href="sp3kbg-edit/'.$sp3kbg->id.'" class="icon-button icon-color-blue"'; 
                }
                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                            <a '. $disabled .'>
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="sp3kbg-detail/'.$sp3kbg->id.'" class="icon-button icon-color-grey">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>';
            })
            ->make(true);
    }

    public function getDisetujuiTable()
    {
        $sp3kbg = DB::table('sp3kbg')
                        ->select('sp3kbg.id',
                                'banks.name',
                                'banks.address',
                                'banks.wilayah',
                                'sp3kbg.status',
                                'sp3kbg.jenis_sp3kbg',
                                'historys.author',
                                'historys.remark',
                                DB::raw("(DATE_FORMAT(historys.created_at,'%d/%m/%Y')) AS tgl_disetujui"),
                                DB::raw("(DATE_FORMAT(sp3kbg.created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                        )
                        ->leftJoin('historys','historys.sp3kbg_id','=','sp3kbg.id')
                        ->leftJoin('banks','banks.id','=','sp3kbg.bank_id')
                        ->where([
                            ['historys.proses','Setuju'],
                            ['sp3kbg.status','=','S'],
                        ])
                        ->orWhere([
                            ['historys.proses','Closing'],
                            ['sp3kbg.status','=','C'],
                        ])
                        ->orderBy('sp3kbg.created_at','DESC')
                        ->get(); 

        return Datatables::of($sp3kbg)
            ->addColumn('action', function ($sp3kbg) {
                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sp3kbg-detail/'.$sp3kbg->id.'" class="icon-button icon-color-grey">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>';
            })
            ->make(true);
    }

    public function getDitolakTable()
    {

        $sp3kbg = DB::table('sp3kbg')
                        ->select('sp3kbg.id',
                                'banks.name',
                                'banks.address',
                                'banks.wilayah',
                                'sp3kbg.direksi',
                                'sp3kbg.status',
                                'sp3kbg.jenis_sp3kbg',
                                'historys.author',
                                'historys.remark',
                                DB::raw("(DATE_FORMAT(historys.created_at,'%d/%m/%Y')) AS tgl_penolakan"),
                                DB::raw("(DATE_FORMAT(sp3kbg.created_at,'%d/%m/%Y')) AS tgl_pengajuan")
                        )
                        ->leftJoin('historys','historys.sp3kbg_id','=','sp3kbg.id')
                        ->leftJoin('banks','banks.id','=','sp3kbg.bank_id')
                        ->where([
                            ['historys.proses','Tolak'],
                            ['sp3kbg.status','=','T'],
                        ])
                        ->orderBy('sp3kbg.created_at','DESC')
                        ->get(); 

        return Datatables::of($sp3kbg)
            ->addColumn('action', function ($sp3kbg) {
                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="sp3kbg-detail/'.$sp3kbg->id.'" class="icon-button icon-color-grey">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>';
            })
            ->make(true);
    }

    public function detail($id)
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
        $bank = Bank::findOrFail($sp3kbg->bank_id);

        $dokPendukung = json_decode($sp3kbg->dokumen_pendukung);
        $brgAgunan = json_decode($sp3kbg->barang_agunan);
        
        $nilaiProyek = $sp3kbg->nilai_proyek; //ucwords($this->terbilang($sp3kbg->nilai_proyek));
        $nilaiJaminan = $sp3kbg->nilai_jaminan; //ucwords($this->terbilang($sp3kbg->nilai_jaminan));

        $admin = Option::findOrFail('4');
        $materai = Option::findOrFail('3');

        if($sp3kbg->status=='C' || $sp3kbg->status=='S'){
            $result = Result::where('sp3kbg_id',$sp3kbg->id)->first();

            $charge = $result->service_charge;
            $rate = $result->rate_ijp;
            $fee = $result->fee_agen;
            $feeAdmin = $result->fee_admin;
            $materai = $result->materai;
            $rateBank = $result->rate_bank;
        }else{            
            $serviceCharge = ceil((new DireksiController)->calculateIjp($sp3kbg->waktu_mulai,$sp3kbg->waktu_selesai,$sp3kbg->nilai_jaminan,$sp3kbg->jenis_sp3kbg,$admin->value,$materai->value,'SP3KBG'));
            //$charge = (new DireksiController)->pembulatan($serviceCharge);
            $charge = $serviceCharge;

            $rate = $this->getRateSp3kbg($sp3kbg->waktu_mulai, $sp3kbg->waktu_selesai, $sp3kbg->jenis_sp3kbg);            
            //$rate = (new SppsbController)->getRate($sp3kbg->waktu_mulai, $sp3kbg->waktu_selesai, $sp3kbg->jenis_sp3kbg);
            
            $fee = $agen->fee_sp3kbg;
            $feeAdmin = $admin->value;
            $materai = $materai->value;
            $rateBank = $bank->rate;
        }
        $grossIjp = ($sp3kbg->nilai_jaminan*$rate)/100;
        $feeBank = (($sp3kbg->nilai_jaminan*$rate)/100*$rateBank)/100;
        $feeAgen = (($grossIjp-$feeBank)*$fee)/100;
    
    $history = '';
    if($sp3kbg->status=='R'){
            $where = ['proses' => 'revisi', 'sp3kbg_id' => $id];
            $history = History::where($where)->first();
        }elseif($sp3kbg->status=='T'){
            $where = ['proses' => 'tolak', 'sp3kbg_id' => $id];
            $history = History::where($where)->first();
        }
        

        return view('common.detailsp3kbg', compact('sp3kbg','agen','bank','dokPendukung','brgAgunan','nilaiProyek','nilaiJaminan','history','charge','rate','rateBank','grossIjp','feeAgen','feeBank','fee','feeAdmin','materai'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        //update status
        $sp3kbg = Sp3kbg::findOrFail($data['id']);

        if($data['status']=='B'){
            $remark = '';
            $proses = 'Baru';
            $users = User::where('role','SA')->get();
//            foreach($users as $user)
//            {
//                Mail::to($user->email,$user->name)->send(new Reminder($data));
//            }
        }elseif($data['status']=='P'){
           $remark = $data['remark'];
            //  $remark = '';
                $proses = 'Proses';
                Mail::to('it.dev@jamkridantb.com')->send(new Reminder($data));
        }elseif($data['status']=='R'){            
            $remark = $data['remark'];
            $proses = 'Revisi';
        }elseif($data['status']=='T'){            
            $remark = $data['remark'];
            $proses = 'Tolak';
        }

        $sp3kbg->status = $data['status'];
        $sp3kbg->updated_by = Auth::user()->username;
        $sp3kbg->save();
        //insert new history
        $history = History::create([
            'sp3kbg_id'  => $data['id'],
            'proses'    => $proses,
            'author'    => Auth::user()->name,
            'remark'    => $remark
        ]);
        if($data['status']=='B'){
            Session::flash('msgupdate','sp3kbg dengan no registrasi '.$sp3kbg->no_registrasi.' berhasil di kirim ke staff surety bond');
            return redirect('/sppsb-sp3kbg-data-table');
        }else{   
            Session::flash('msgupdate','SP3 KBG dengan no registrasi '.$sp3kbg->no_registrasi.' berhasil di update dengan status '.$proses.'');
            return redirect('/sppsb-sp3kbg-masuk');
        }
    }

    public function getRateSp3kbg($date1,$date2,$id){
        $d1 = strtotime($date1);
        $d2 = strtotime($date2);
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $month = 1;
        $rateIjp = '0';
        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
            $month++;
        }
        $rate = RateSp3kbg::findOrFail($id);
        
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

        return $rateIjp;
    }

}
