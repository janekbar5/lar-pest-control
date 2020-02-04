<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [  
        'user_id',
        'client_id',        
        'title',
        'description',        
    ];
    /////////////////////////////////////////////////////////////For typehead search
    protected $appends = ['text'];
    public function getTextAttribute()
    {
        return $this->attributes['name']. ' - '.$this->attributes['person_name'];
    }
    
    ////////////////////////////////////////////////////////////////HASMANY
    // Location-->belongsTo-->Client   <==>  Client-->hasMany-->Location
    public function locations()
    {
        return $this->hasMany('App\Location');		
    }

}
