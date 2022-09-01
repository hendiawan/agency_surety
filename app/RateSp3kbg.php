<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RateSp3kbg extends Model
{
    protected $table = 'rate_sp3kbg';

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
