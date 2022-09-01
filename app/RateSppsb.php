<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RateSppsb extends Model
{
    protected $table = 'rate_sppsb';

    protected $fillable = [
    	'title',
    	'tiga',
    	'empat',
    	'lima',
    	'enam',
    	'tujuh',
    	'delapan',
    	'sembilan',
    	'sepuluh',
    	'sebelas',
    	'duabelas',
    ];
}
