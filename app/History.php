<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
	protected $table = 'historys';

    protected $fillable = [
    	'sppsb_id',
    	'sp3kbg_id',
    	'proses',
    	'author',
    	'remark',
    ];
}
