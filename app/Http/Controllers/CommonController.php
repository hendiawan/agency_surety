<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Hash;
use App\Sppsb;
use App\Sp3kbg;
use App\User;
use App\Agen;
use App\RateSppsb;
use App\RateSp3kbg;
use App\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class CommonController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function ceksertifikat(request $request) {
       
        $data_sertifikat = Sppsb::where('no_jaminan',$request->nomorsertifikat)->get(); 
        $data= json_encode($data_sertifikat);
//        dd($data);
        return $data;
    }
    
    public function index()
    {
        
          $lastNo = DB::table('sppsb')->select('no_jaminan as lastno')
                              ->leftJoin('historys','historys.sppsb_id','=','sppsb.id')
                             -> where(\DB::raw("(DATE_FORMAT(historys.updated_at,'%Y'))"), date('Y'))
                             ->where('user_id','18')
                             ->where('status','C') 
                             ->take(1)
                             ->orderBy('historys.updated_at','desc')
                             ->first();
          
//            $sppsb = Sppsb::findOrFail(1903);
//        dd($sppsb->status);
     
        if(Auth::user()->jabatan == 'Admin'){

            $rateSppsb = RateSppsb::all();
            $rateSp3kbg = RateSp3kbg::all();
            $feeAdminSppsb = Option::findOrFail('2');
            $materai = Option::findOrFail('3');
            $feeAdminSp3kbg = Option::findOrFail('4');
            return view('admin.dashboard', compact('rateSppsb','rateSp3kbg','feeAdminSppsb','feeAdminSp3kbg','materai'));
                
        }elseif(Auth::user()->jabatan == 'Direksi'){
            
             $jabatan = Auth::user()->keterangan;  
//               dd($jabatan);
            if($jabatan=="Direktur"){
                  $countProses = Sppsb::where('status','I')->count();
            }else{
                  $countProses = Sppsb::where('status','P')->count();
            } 
   
            
            $ttd = DB::table('options')
                        ->select('id','title','value',DB::raw("(DATE_FORMAT(created_at,'%d/%m/%Y %H:%i:%s')) AS created_date"))
                        ->where('title','ttd')->first();
            return view('direksi.dashboard', compact('ttd','countProses'));

        }elseif (Auth::user()->jabatan == 'Staff') {
        
            $countBaru = Sppsb::where('status','B')->count();//untuk status baru
            $countSetuju = Sppsb::where('status','S')->count();//untuk statu setuju
            $rateSppsb = RateSppsb::all();
            $rateSp3kbg = RateSp3kbg::all();
            return view('staff.dashboard', compact('countBaru','countSetuju','rateSppsb','rateSp3kbg'));
        
        }elseif (Auth::user()->jabatan == 'Kabag') { 
            $countBaru = Sppsb::where('status','B')->count();//untuk status baru
            $countSetuju = Sppsb::where('status','K')->count();//untuk approval kabag
            $rateSppsb = RateSppsb::all();
            $rateSp3kbg = RateSp3kbg::all();
            return view('staff.dashboard', compact('countBaru','countSetuju','rateSppsb','rateSp3kbg'));
        
        }else{            
            $fee = 0;
            $ijp = 0;
            $results = DB::table('results')
                    ->select('results.service_charge','results.rate_ijp','results.fee_agen',DB::raw("CASE WHEN sppsb.nilai_jaminan IS NULL THEN sp3kbg.nilai_jaminan ELSE sppsb.nilai_jaminan END AS nilai_jaminan"))
                    ->leftJoin('sppsb','sppsb.id','=','results.sppsb_id')
                    ->leftJoin('sp3kbg','sp3kbg.id','=','results.sp3kbg_id')
                    ->where(function($query)
                    {               
                        $query->where('sppsb.status','C')
                        ->orWhere('sp3kbg.status','C');
                    })
                    ->where(function($query)
                    {
                        $query->where('sppsb.user_id',Auth::user()->id)
                        ->orWhere('sp3kbg.user_id',Auth::user()->id);
                    })
                    ->get();
            foreach ($results as $key => $result) {                           
                $fee += (($result->service_charge - 22000)*$result->fee_agen)/100;
                $ijp += $result->service_charge; 
            } 
          
            $statistik =   DB::select('SELECT 
                                            cal.my_date AS date_field, 
                                            t.sppsb,
                                            t.sp3kbg
                                        FROM 
                                            (SELECT 
                                                s.start_date + INTERVAL (days.d) DAY AS my_date
                                            FROM 
                                              ( SELECT LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL 1 MONTH AS start_date,
                                                LAST_DAY(CURRENT_DATE) AS end_date
                                              ) AS s
                                            JOIN days ON  days.d <= DATEDIFF(s.end_date, s.start_date)
                                            ) AS cal
                                        LEFT JOIN (
                                            SELECT CASE WHEN r.sp3kbg_id IS NULL THEN r.service_charge ELSE "" END AS sppsb, CASE WHEN r.sppsb_id IS NULL THEN r.service_charge ELSE "" END AS sp3kbg, r.created_at AS c_date FROM results r WHERE DATE_FORMAT(NOW(),"%Y-%m") = DATE_FORMAT(r.created_at,"%Y-%m") ORDER BY r.created_at DESC
                                        ) AS t ON  t.c_date >= cal.my_date AND t.c_date < cal.my_date + INTERVAL 1 DAY ORDER BY date_field ASC');
            $statSppsb = array();
            $statSp3kbg = array();
            $labelStat = array();
            foreach ($statistik as $key => $stat) {  
                $statSppsb[] = array((int)strtotime($stat->date_field) * 1000, (int)$stat->sppsb );
                $statSp3kbg[] = array((int)strtotime($stat->date_field) * 1000, (int)$stat->sp3kbg );
                $labelStat[] = array((int)strtotime($stat->date_field) * 1000);
            }                      

            $penawaran_sppsb      = Sppsb::where(['status'=>'C', 'jenis_sppsb'=>'1', 'user_id'=>Auth::user()->id])->count();
            $pelaksanaan_sppsb    = Sppsb::where(['status'=>'C', 'jenis_sppsb'=>'2', 'user_id'=>Auth::user()->id])->count();
            $uangmuka_sppsb       = Sppsb::where(['status'=>'C', 'jenis_sppsb'=>'3', 'user_id'=>Auth::user()->id])->count();
            $pemeliharaan_sppsb   = Sppsb::where(['status'=>'C', 'jenis_sppsb'=>'4', 'user_id'=>Auth::user()->id])->count();
            $pembayaran_sppsb     = Sppsb::where(['status'=>'C', 'jenis_sppsb'=>'5', 'user_id'=>Auth::user()->id])->count();
            $sanggahbanding_sppsb = Sppsb::where(['status'=>'C', 'jenis_sppsb'=>'6', 'user_id'=>Auth::user()->id])->count();
            
            $penawaran_sp3kbg      = Sp3kbg::where(['status'=>'C', 'jenis_sp3kbg'=>'1', 'user_id'=>Auth::user()->id])->count();
            $pelaksanaan_sp3kbg    = Sp3kbg::where(['status'=>'C', 'jenis_sp3kbg'=>'2', 'user_id'=>Auth::user()->id])->count();
            $uangmuka_sp3kbg       = Sp3kbg::where(['status'=>'C', 'jenis_sp3kbg'=>'3', 'user_id'=>Auth::user()->id])->count();
            $pemeliharaan_sp3kbg   = Sp3kbg::where(['status'=>'C', 'jenis_sp3kbg'=>'4', 'user_id'=>Auth::user()->id])->count();
            $pembayaran_sp3kbg     = Sp3kbg::where(['status'=>'C', 'jenis_sp3kbg'=>'5', 'user_id'=>Auth::user()->id])->count();
            $sanggahbanding_sp3kbg = Sp3kbg::where(['status'=>'C', 'jenis_sp3kbg'=>'6', 'user_id'=>Auth::user()->id])->count();
            return view('agen.dashboard',compact(
                    'ijp',
                    'fee',
                    'penawaran_sppsb',
                    'pelaksanaan_sppsb',
                    'uangmuka_sppsb',
                    'pemeliharaan_sppsb',
                    'pembayaran_sppsb',
                    'sanggahbanding_sppsb',
                    'penawaran_sp3kbg',
                    'pelaksanaan_sp3kbg',
                    'uangmuka_sp3kbg',
                    'pemeliharaan_sp3kbg',
                    'pembayaran_sp3kbg',
                    'sanggahbanding_sp3kbg',
                    'statSppsb',
                    'statSp3kbg',
                    'labelStat'));
        }
    }

    public function profil()
    {

        $user = User::findOrFail(Auth::user()->id);
        $agen = Agen::where('user_id', Auth::user()->id)->first();

        return view('common.profil', compact('user','agen'));
    }

    public function editProfil()
    {
        $user = User::findOrFail(Auth::user()->id);
        $agen = Agen::where('user_id', Auth::user()->id)->first();

        return view('common.editprofil' , compact('user','agen'));
    }

    public function updateProfil(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $data = $request->all();            
        $user = User::findOrFail(Auth::user()->id);
        $user->name = $data['name'];
        $user->no_hp = $data['no_hp'];
        if ($request->hasFile('foto')) {
            $data['foto'] = $this->saveResizePhoto($request->file('foto'));
            $user->foto = $data['foto'];
        }
        $user->save();
        if(Auth::user()->role=='AA'){
            $agen = Agen::findOrFail(Auth::user()->id);
            $agen->no_ktp = $data['no_ktp'];
            $agen->alamat = $data['alamat'];
            $agen->tempat_lahir = $data['tempat_lahir'];
            $agen->tgl_lahir    = date('Y-m-d', strtotime($data['tgl_lahir']));
            $agen->sertifikasi = $data['sertifikasi'];
            $agen->save();
        }

        return redirect('/profil-pengguna');
    }
    
    public function gantiPassword()
    {
        return view('common.gantipassword');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);
        $data = $request->all();
        $user = User::findOrFail(Auth::user()->id);

        if(!Hash::check($data['current_password'], $user->password)){
            Session::flash('msgalert','Password sekarang (current password) yang anda masukkan tidak sesuai');
            return redirect('/ganti-password');
        }else{
            $user = User::where('username',Auth::user()->username)->update(['password' => bcrypt($data['password'])]);
        }

        Session::flash('msgupdate','Anda berhasil melakukan update password');
        return redirect('/ganti-password');
    }


    /**
     * Move uploaded photo to public/uploads folder
     * @param  UploadedFile $photo
     * @return string
     */
    protected function saveResizePhoto($image)
    {
        /*
        $fileName = str_random(40) . '.' . $photo->getClientOriginalExtension();
        $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'uploads';
        $photo->move($destinationPath, $fileName);
        return $fileName;
        */
        try 
        {
            $extension      =   $image->getClientOriginalExtension();
            $imageRealPath  =   $image->getRealPath();
            $thumbName      =   str_random(10) . '-' . $image->getClientOriginalName();
            
            //$imageManager = new ImageManager(); // use this if you don't want facade style code
            //$img = $imageManager->make($imageRealPath);
        
            $img = Image::make($imageRealPath); // use this if you want facade style code
            $img->resize(intval(200), null, function($constraint) {
                 $constraint->aspectRatio();
            });
            $img->save(public_path('uploads'). '/profil/'. $thumbName,80);
            //
            //save thumb image
            //
            $thumbimg = Image::make($imageRealPath); // use this if you want facade style code
            $thumbimg->resize(90,90);
            $thumbimg->save(public_path('uploads'). '/profil/thumb_'. $thumbName,80);
            return $thumbName;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}
