<?php

namespace App\Http\Controllers;

use App\User;
use App\Agen;
use App\Sppsb;
use App\Sp3kbg;
use App\RateSppsb;
use App\RateSp3kbg;
use App\Option;
use DB;
use Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function userList()
    {
        return view('admin.manajemenuser');
    }
    public function formUser()
    {

        return view('admin.tambahpengguna');
    }
    public function insertUser(Request $request)
    {

        $this->validate($request, [
            'jabatan' => 'required',
            'name' => 'required',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
        ]);

        $data = $request->all();

        $role = 'SA';
        if($data['jabatan']=='Agen'){
            $this->validate($request, [
                'jabatan' => 'required',
                'min_no_reg' => 'required',
                'max_no_reg' => 'required',
                'name' => 'required',
                'username' => 'required|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'no_agen' => 'required|unique:agens',
                'wilayah_agensi' => 'required',
                'no_ktp' => 'required',
            ]);                
            $role = 'AA';
        }

         $user = User::create([
            'name'      => $data['name'],
            'username'  => $data['username'],
            'email'     => $data['email'],
            'jabatan'   => $data['jabatan'],
            'password'  => bcrypt('password123'),
            'role'      => $role,
            'foto'      => 'user.jpg'
        ]);

        if($data['jabatan']=='Agen'){
            $agen = Agen::create([
                'user_id'       => $user->id,
                'alamat'        => $data['alamat'],
                'no_ktp'        => $data['no_ktp'],
                'tempat_lahir'  => $data['tempat_lahir'],
                'tgl_lahir'     => date('Y-m-d', strtotime($data['tgl_lahir'])),
                'sertifikasi'   => $data['sertifikasi'],
                'wilayah_agensi'=> $this->switchWilayah($data['wilayah_agensi']),
                'code_wilayah'  => $data['wilayah_agensi'],
                'no_agen'       => $data['no_agen'],
                'min_no_reg'    => $data['min_no_reg'],
                'max_no_reg'    => $data['max_no_reg'],
            ]);
        }


        Session::flash('msgupdate','Pengguna baru dengan jabatan '.$data['jabatan'].' berhasil di tambahkan');
        return redirect('/manajemen-pengguna');
    }
    public function editUser($id)
    {
        
        $user = User::findOrFail($id);
        $agen = Agen::where('user_id', $id)->first();
        return view('admin.editpengguna', compact('user','agen'));
    }

    public function updateUser(Request $request)
    {
        $this->validate($request, [
            'jabatan' => 'required',
            'name' => 'required',
        ]);

        $data = $request->all();

        $role = 'SA';
        if($data['jabatan']=='Agen'){
            $this->validate($request, [
                'jabatan' => 'required',
                'name' => 'required',
                'wilayah_agensi' => 'required',
                'no_ktp' => 'required',
            ]);                
            $role = 'AA';
        }
        $user = User::findOrFail($data['id']);
        $user->name = $data['name'];
        $user->jabatan = $data['jabatan'];
        $user->no_hp = $data['no_hp'];
        $user->save();

        if($data['jabatan']=='Agen'){
            $agen = Agen::where('user_id', $data['id'])->first();
            
            $agen->no_ktp       = $data['no_ktp'];
            $agen->min_no_reg = $data['min_no_reg'];
            $agen->max_no_reg = $data['max_no_reg'];
            $agen->wilayah_agensi   = $this->switchWilayah($data['wilayah_agensi']);
            $agen->code_wilayah = $data['wilayah_agensi'];
            $agen->alamat       = $data['alamat'];
            $agen->tempat_lahir = $data['tempat_lahir'];
            $agen->tgl_lahir    = date('Y-m-d', strtotime($data['tgl_lahir']));
            $agen->sertifikasi  = $data['sertifikasi'];
            $agen->save();

        }

        Session::flash('msgupdate','update pengguna dengan username '.$user->username.' berhasil di lakukan');
        return redirect('/manajemen-pengguna');
    }
    public function getUserList(){

        $user = User::where('role','!=','0A')->orderBy('id','desc')->get();

        return Datatables::of($user)
            ->addColumn('action', function ($user) {
                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="edit-pengguna/'.$user->id.'" class="icon-button icon-color-blue">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="detail-pengguna/'.$user->id.'" class="icon-button icon-color-grey">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>';
            })
            ->make(true);
    }
    public function getAgenList(){

        $user = DB::table('users')
                ->select('users.id','users.name','agens.no_agen','agens.wilayah_agensi','agens.code_wilayah','agens.fee_sppsb','agens.fee_sp3kbg')
                ->leftJoin('agens','agens.user_id','=','users.id')
                ->where([['users.role','=','AA'],['users.is_active','=','1']])->orderBy('users.id','desc')->get();

        return Datatables::of($user)
            ->addColumn('action', function ($user) {
                return '<a href="javascript:void(0)" onclick="event.preventDefault();updateFee(this, '.$user->id.');" class="icon-button icon-color-green"><i class="fa fa-check"></i></a>';
            })
            ->make(true);
    }
    public function detailPengguna($id)
    {

        $user = User::findOrFail($id);
        $agen = Agen::where('user_id', $id)->first();

        return view('common.profil', compact('user','agen'));
    }
    public function updateFee(Request $request)
    {
        $data = $request->all();
        $agen = Agen::where('user_id',$data['id'])->first();

        $agen->fee_sppsb = $data['fee_sppsb'];
        $agen->fee_sp3kbg = $data['fee_sp3kbg'];
        $agen->save();

        return response()->json(compact('agen'));
    }
    public function updateRateSppsb(Request $request)
    {
        $data = $request->all();

        foreach ($data['id'] as $key => $id){            
            $rate = RateSppsb::findOrFail($id);
            $rate->min_biaya = $data['min_biaya'][$key];
            $rate->tiga     = $data['tiga'][$key];
            $rate->empat    = $data['empat'][$key];
            $rate->lima     = $data['lima'][$key];
            $rate->enam     = $data['enam'][$key];
            $rate->tujuh    = $data['tujuh'][$key];
            $rate->delapan  = $data['delapan'][$key];
            $rate->sembilan = $data['sembilan'][$key];
            $rate->sepuluh  = $data['sepuluh'][$key];
            $rate->sebelas  = $data['sebelas'][$key];
            $rate->duabelas = $data['duabelas'][$key];
            $rate->save();
        }
        $admin = Option::findOrFail('2');
        $admin->value = $data['fee_admin_sppsb'];
        $admin->save();

        $materai = Option::findOrFail('3');
        $materai->value = $data['materai_sppsb'];
        $materai->save();

        return response()->json('');
    }
    public function updateRateSp3kbg(Request $request)
    {
        $data = $request->all();

        foreach ($data['id'] as $key => $id){            
            $rate = RateSp3kbg::findOrFail($id);
            $rate->min_biaya = $data['min_biaya'][$key];
            $rate->tiga     = $data['tiga'][$key];
            $rate->empat    = $data['empat'][$key];
            $rate->lima     = $data['lima'][$key];
            $rate->enam     = $data['enam'][$key];
            $rate->tujuh    = $data['tujuh'][$key];
            $rate->delapan  = $data['delapan'][$key];
            $rate->sembilan = $data['sembilan'][$key];
            $rate->sepuluh  = $data['sepuluh'][$key];
            $rate->sebelas  = $data['sebelas'][$key];
            $rate->duabelas = $data['duabelas'][$key];
            $rate->save();
        }

        $admin = Option::findOrFail('4');
        $admin->value = $data['fee_admin_sp3kbg'];
        $admin->save();

        $materai = Option::findOrFail('3');
        $materai->value = $data['materai_sp3kbg'];
        $materai->save();

        return response()->json('');
    }
    public function updateStatus(Request $request)
    {
        $data = $request->all();
        $user = User::findOrFail($data['id']);

        if($data['is_active']=='true'){
            $user->is_active = '0';
        }else{ 
            $user->is_active = '1';
        }

        $user->save();

        return response()->json(compact('user'));
    }
    public function manageData()
    {
        return view('admin.manajemendatapengajuan');
    }
    
    public function getSppsbDraftTable()
    {
        $sppsb = DB::table('sppsb')
                        ->select('sppsb.id',
                                'sppsb.nama_kontraktor',
                                'sppsb.jenis_sppsb',
                                'sppsb.nilai_jaminan',
                                'sppsb.no_jaminan',
                                'sppsb.direksi',
                                'sppsb.status',
                                DB::raw("(DATE_FORMAT(sppsb.created_at,'%d/%m/%Y')) AS tgl_pengajuan"),
                                'users.jabatan',
                                'users.name'
                        )
                        ->leftJoin('users','users.id','=','sppsb.user_id')
                        ->whereIn('sppsb.status',array('D','B','R','T','P','C'))
                        ->orderBy('sppsb.created_at','DESC')
                        ->get();

        return Datatables::of($sppsb)
            ->addColumn('action', function ($sppsb) {
                return '<a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="<strong>Hapus Data</strong>" data-content=\'<p>Apakah Anda Yakin?</p><a class="btn btn-red btn-sm po-delete-sppsb" id="'.$sppsb->id.'" href="#">Yakin</a> <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                            <i class="fa fa-ban"></i>
                        </a>';
            })
             ->addColumn('nilai_jaminan', function ($sppsb) {
                return number_format($sppsb->nilai_jaminan, 2,",",".");
            })
            ->make(true);
    }
    
    public function getSp3kbgDraftTable()
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
                        ->whereIn('sp3kbg.status',array('D','B','R','T','P'))
                        ->orderBy('sp3kbg.created_at','DESC')
                        ->get();

        return Datatables::of($sp3kbg)
            ->addColumn('action', function ($sp3kbg) {
                return '<a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="<strong>Hapus Principal</strong>" data-content=\'<p>Apakah Anda Yakin?</p><a class="btn btn-danger btn-sm po-delete-sp3kbg" id="'.$sp3kbg->id.'" href="#">Yakin</a> <button class="btn btn-sm po-close">Tidak</button>\' data-toggle="tooltip" data-placement="left">
                                <i class="fa fa-ban"></i>
                            </a>';
            })
            ->make(true);
    }    
    public function deleteDataSppsb($id)
    {
        $sppsb    = Sppsb::findOrFail($id);
        $sppsb->delete();
        return response()->json(true);
    }
    public function deleteDataSp3kbg($id)
    {
        $sp3kbg    = Sp3kbg::findOrFail($id);
        $sp3kbg->delete();
        return response()->json(true);
    }
    public function backupDB()
    {
        return view('admin.backupdb');
    }
    function switchWilayah($kode){
        switch ($kode) {
            case 'KBM':
                return 'Kota Bima';
                break;
            case 'MTR':
                return 'Kota Mataram';
                break;
            case 'LB':
                return 'Lombok Barat';
                break;
            case 'LTH':
                return 'Lombok Tengah';
                break;
            case 'LTR':
                return 'Lombok Timur';
                break;
            case 'LU':
                return 'Lombok Utara';
                break;
            case 'DM':
                return 'Dompu';
                break;
            case 'BM':
                return 'Bima';
                break;
            case 'SB':
                return 'Sumbawa';
                break;
            case 'SBB':
                return 'Sumbawa Barat';
                break;
        }
    }
}
