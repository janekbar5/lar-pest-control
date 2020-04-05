<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
	    'addressable_type',
        'addressable_id', 
		'user_id',
		'address_line1',
		'address_line2',
		'city',
		'postcode',	
		'lat',
		'lng',
			
    ];
}
