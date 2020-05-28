<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password', 'profile_image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    // eloquent methods 
    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function friends(){
        return $this->belongsToMany('App\User','friends','user_id','friend_id')->withPivot('friendship_state');
    }

    public function likes(){
        return $this->belongsToMany('App\Post','likes','user_id','post_id');
    }
}
