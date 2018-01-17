<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'about', 'birthday', 'facebook', 'twitter', 'instagram'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart_items(){
        return $this->hasMany('App\Cart_item');
    }

    public function ratings(){
        return $this->hasMany('App\User_rating');
    }

    public function reviews(){
        return $this->hasMany('App\User_review');
    }
}
