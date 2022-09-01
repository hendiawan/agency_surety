<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{

    protected $fillable = [
    	'sppsb_id',
        'sp3kbg_id',
    	'ttd',
    	'ttd_type',
    	'service_charge',
    	'min_biaya',
    	'rate_ijp',
        'rate_bank',
    	'fee_agen',
        'fee_admin',
        'materai',
    	'descr',
    	'author',
    	'print_status',
    	'print_count',
    ];
}
