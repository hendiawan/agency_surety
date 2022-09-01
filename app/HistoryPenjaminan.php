<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryPenjaminan extends Model
{
//    protected $table = 'history_penjaminans';

    protected $fillable = [
    	'sppsb_id',
    	'dijaminan_jamkrida',
    	'no_sertifikat',
    	'nama_asuransi',
    	'deskripsi_singkat',
    	'penyelesaian_tepat',
    	'deskripsi_kendala',
    ];
    
}
