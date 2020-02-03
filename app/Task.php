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
        //'treatment_id', 
		'status_id',
		'price_id',
		'title',
		'description',
        'comment',		
        'deadline',
    ];
    ////////////////////////////////////////////////////////////////BELONGSTOMANY PIVOT
    // Location-->belongsToMany-->Treatment   <==>  Treatment-->belongsToMany-->Location
    public function selectedUsers()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }
    ////////////////////////////////////////////////////////////////belongsTo
    // Task-->belongsTo-->Location   <==>  Location-->hasMany-->Task
    public function locations()
    {
        return $this->belongsTo('App\Location', 'location_id');		
    }
    public function statuses()
    {
        return $this->belongsTo('App\Status', 'status_id');		
    }
    

   
}
