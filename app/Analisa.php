<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analisa extends Model
{
    //
     protected $fillable = [
    	'analisa_staff',
    	'analisa_kabag',
    	'analisa_direktur',
    	'keputusan',
    	'rekomendasi',
    	'sppsb_id',
    	'created_at',
    	'updated_at',
    	'updated_by',
    	'created_by', 
    ];
}
