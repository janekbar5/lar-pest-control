<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubStatus extends Model
{
    protected $fillable = [
        'status_id',
	    'title',
        'description',
    ];
    /////////////////////////////////////////////////////////////////Belongsto   
    //SubStatus-->belongsTo-->Status  <==>   Status-->hasMany-->SubStatus     
    public function status()
    {
        return $this->BelongsTo('App\Status');
    }
}
