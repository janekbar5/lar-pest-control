<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'audits';
	
	public function users()
    {
        return $this->belongsTo('App\User', 'user_id');		
    }
	
	protected $appends = ['user'];	
	
	function getUserAttribute() {
		return $this->users->name.' '.$this->users->last_name;
	}
	
	
}
