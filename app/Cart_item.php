<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart_item extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['book_id', 'amount', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function book()
    {
        return $this->belongsTo('App\Book');
    }
}
