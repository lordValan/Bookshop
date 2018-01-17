<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_info extends Model
{
    public $table = "user_info";

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
