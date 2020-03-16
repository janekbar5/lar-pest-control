<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reccurence extends Model
{
    protected $fillable = [
	    'title',
        //'colour',
    ];
	////////////////////////////////////////////first photo  Assesors setAttribute
    /* protected $appends = [
        'name','value',
    ];
    function getNameAttribute()
    {        
        return $this->title;	  
    }
	function getValueAttribute()
    {        
        return $this->id;	  
    } */
}
