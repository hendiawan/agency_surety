<?php

use Carbon\Carbon;
use App\RateSppsb;

function tgl_indo($tanggal)
{
    $bulan = array (1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
    );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}

function terbilang($x)
{
    
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");

  if ($x < 12)
   
  {
       return " " . $abil[$x];
     
  }
  elseif ($x < 20)
    return terbilang($x - 10) . " belas";
  elseif ($x < 100)
    return terbilang($x / 10) . " puluh" . terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . terbilang($x - 100);
  elseif ($x < 1000)
    return terbilang($x / 100) . " ratus" . terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . terbilang($x - 1000);
  elseif ($x < 1000000)
    return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
  elseif ($x < 1000000000)
    return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
  elseif ($x < 1000000000000)
    return terbilang($x / 1000000000) . " milyar" . terbilang(fmod($x,1000000000));
 
}
function jenisSppsbCode($type){
  switch ($type) {
    case 1:
      return '20';
      break;
    case 2:
      return '21';
      break;
    case 3:
      return '22';
      break;
    case 4:
      return '23';
      break;
    case 5:
      return '24';
      break;
    default:
      return '00';
      break;
  }
}
function jenisSp3kbgCode($type){
  switch ($type) {
    case 1:
      return '8';
      break;
    case 2:
      return '9';
      break;
    case 3:
      return '10';
      break;
    case 4:
      return '11';
      break;
    case 5:
      return '12';
      break;
    default:
      return '00';
      break;
  }
}
function kodeWilayah($code){
    
  switch ($code) { 
    case "MTR":
      return '07';
      break;
   case "LTH":
      return '08';
      break;
    case "LTT":
      return '09';
      break;
    case "LU":
      return '10';
      break;
     case "SBB":
      return '11';
      break;
    case "SB":
      return '12';
      break; 
   case "DM":
      return '13';
      break;
    case "BM":
      return '14';
      break;
   case "KBM":
      return '15';
      break; 
    case "LB":
      return '16';
      break;
    default:
      return '00';
      break;
  }
  
}
//reference number function
function referenceNo($type,$lastNo,$agen,$wilayah)
{
//    $currentNo =substr($lastNo,3,3);  
//    $currentNo =substr($lastNo,3,4);  
//    DD($currentNo);
//    $newNo  = incrementValue($currentNo);
    
    $newNo=str_pad(++$lastNo, 4, '0', STR_PAD_LEFT); 
    $now = Carbon::now();
    
//    $nomor_sertifikat = $koderegistrasibank.'.'.$nomorurutsertifikat.'.'.$jenispenjaminan.'.'.$kodebank.'.'.$kodeagen.'.'.date('m').'.'.date('Y');
      
    return $type.'.'.$newNo.'.'.$agen.'.'.$now->format('m').'.'.$now->year.'.'.$wilayah;
}
//increment reference number function
function incrementValue($number)
{
    $lengthNo = 4;
    $intNo = intval($number)+1;
    $zeroNo = 4-(strlen($intNo));
    $zero = "";
    for($i=0; $i<$zeroNo; $i++){
        $zero = $zero."0";
    }
    $finalNo = $zero.strval($intNo); 
    return $finalNo;
}

//increment reference number for sertifikat
function incrementValueSertifikat($value, $min)
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

  function getRate($date1,$date2,$id){
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
  function getRateOri($date1,$date2,$id){
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
        }

        return $rateIjp;
    }
 
    
     function saveFile($file)
    {
        
//        $fileName = str_random(8).date('ymdHis') . '-' . $file->getClientOriginalName();
        $fileName = date('ymdHis') . '-' . $file->getClientOriginalName();
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
