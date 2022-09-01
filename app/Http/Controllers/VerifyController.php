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
use App\Option;

class VerifyController extends Controller
{
	        /**
     * Create a new controller instance.
     *
     * @return void
     */
    

     public function detail1($id)
    {
        $id= dekripsi($id);
        $sppsb = Sppsb::findOrFail($id);
        $result = Result::where('sppsb_id',$id)->first();        
        
        //$selisih = ((abs(strtotime ($sppsb->waktu_mulai) - strtotime ($sppsb->waktu_selesai)))/(60*60*24));
        $selisih = ucwords((new SppsbController)->terbilang($sppsb->durasi));
        $nilaiProyek = ucwords((new SppsbController)->terbilang($sppsb->nilai_proyek));
        $nilaiJaminan = ucwords((new SppsbController)->terbilang($sppsb->nilai_jaminan));
        $nilaiProyekFormat = number_format($sppsb->nilai_proyek,2,",",".");
        $nilaiJaminanFormat = number_format($sppsb->nilai_jaminan,2,",",".");
        $charge = number_format($result->service_charge,2,",",".");
        
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
                'charge'));
        
              return view('verify.sertifikatpemeliharaan', compact(
                'sppsb',
                'result',
                'selisih',
                'nilaiJaminan',
                'nilaiJaminanFormat',
                'charge'));

        //return view($pathSppsb, compact('sppsb','result','selisih','nilaiJaminan','nilaiJaminanFormat','charge'));
        
    }
    
        public function detail($id)
      {
        $id= dekripsi($id);
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
	    if($sppsb->status=='R'){
            $where = ['proses' => 'revisi', 'sppsb_id' => $id];
            $history = History::where($where)->first();
        }elseif($sppsb->status=='T'){
            $where = ['proses' => 'tolak', 'sppsb_id' => $id];
            $history = History::where($where)->first();
        }
        

        return view('verify.detailsppsb', compact('sppsb','agen','dokPendukung','brgAgunan','nilaiProyek','nilaiJaminan','history','charge','rate','grossIjp','feeAgen','fee','feeAdmin','materai'));
    }
    
    function terbilang($x)
    {
        
      $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
      if ($x < 12)
        return " " . $abil[$x];
      elseif ($x < 20)
        return $this->terbilang($x - 10) . " belas";
      elseif ($x < 100)
        return $this->terbilang($x / 10) . " puluh" . $this->terbilang($x % 10);
      elseif ($x < 200)
        return " seratus" . $this->terbilang($x - 100);
      elseif ($x < 1000)
        return $this->terbilang($x / 100) . " ratus" . $this->terbilang($x % 100);
      elseif ($x < 2000)
        return " seribu" . $this->terbilang($x - 1000);
      elseif ($x < 1000000)
        return $this->terbilang($x / 1000) . " ribu" . $this->terbilang($x % 1000);
      elseif ($x < 1000000000)
        return $this->terbilang($x / 1000000) . " juta" . $this->terbilang($x % 1000000);
      elseif ($x < 1000000000000)
        return $this->terbilang($x / 1000000000) . " milyar" . $this->terbilang(fmod($x,1000000000));
     
    }

    

}
