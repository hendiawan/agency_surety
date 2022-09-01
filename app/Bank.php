<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
    	'name',
    	'address',
    	'wilayah',
    	'phone',
    	'no_rek',
    	'rate',
    ];
}
