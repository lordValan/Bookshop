<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ordered_book extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'book_id', 'price'];

    public function book()
    {
        return $this->belongsTo('App\Book');
    }
}
