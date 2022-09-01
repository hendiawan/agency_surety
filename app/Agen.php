<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agen extends Model
{
    protected $fillable = [
    	'user_id',
    	'alamat',
    	'no_ktp',
    	'tempat_lahir',
    	'tgl_lahir',
    	'sertifikasi',
    	'wilayah_agensi',
    	'code_wilayah',
    	'no_agen',
                    'fee_sppsb',
                    'fee_sp3kbg',
                    'min_no_reg',
                    'max_no_reg',
    ];
}
