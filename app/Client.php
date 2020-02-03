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

}