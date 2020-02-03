<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Status extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = [
	    'title',
        'description',
    ];
    protected $auditInclude  = [
        'title', 'description'
    ];

    /////////////////////////////////////////////////////////////////Hasmany  
    // Status-->hasMany-->SubStatus   <==>  SubStatus-->belongsTo-->Status  
    // public function substatus()
    // {
    //     return $this->HasMany('App\SubStatus');
    // }
    public function tasks()
    {
	return $this->HasMany('App\Task');	
	}
}
