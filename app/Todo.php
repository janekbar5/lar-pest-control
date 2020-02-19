<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
	protected $fillable = [	   
        'user_id', 
		'title',		
		'description',
        
    ];
    ////////////////////////////////////////////////////////////////belongsTo
    // Task-->belongsTo-->Location   <==>  Location-->hasMany-->Task
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');		
    }
}
