<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function genres()
    {
        return $this->belongsToMany('App\Genre');
    }

    public function author()
    {
        return $this->belongsTo('App\Author');
    }

    public function ratings(){
        return $this->hasMany('App\User_rating');
    }

    public function reviews(){
        return $this->hasMany('App\User_review');
    }

    public function orders(){
        return $this->hasMany('App\Ordered_book');
    }

    public function sale_percent(){
        return $this->hasOne('App\Sale_book');
    }

    /**
     * Help function for getting current book's price.
     *
     * @return view
     */
    public function getCurrentPrice(){
        return $price = count($this->sale_percent) > 0 ? number_format($this->price / 100 * (100-$this->sale_percent->percentoff), 2) : $this->price;
    }
}
