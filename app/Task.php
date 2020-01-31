<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Task extends Model
{
    use SoftDeletes;

    //////////////////////////////////////////
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
	    'location_id',
        'treatment_id', 
		'status_id',
		'price_id',
		'title',
		'description',
        'comment',		
        'deadline',
    ];

   
}
