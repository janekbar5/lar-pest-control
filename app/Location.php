<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Location extends Model implements Auditable 
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [  
                'user_id',
                'client_id',
                'title',
                'description',
                
    ];
    ////////////////////////////////////////////////////////////////BELONGSTOMANY PIVOT
    // Location-->belongsToMany-->Treatment   <==>  Treatment-->belongsToMany-->Location
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class, 'location_treatment', 'location_id', 'treatment_id');
    }

    /////////////////////////////////////////////////////////////Address
    public function address()
    {
        return $this->morphOne('App\Address', 'addressable');
    }
   
}
