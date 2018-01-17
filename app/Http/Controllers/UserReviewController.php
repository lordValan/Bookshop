<?php

namespace App\Http\Controllers;

use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;
use Auth;
use App\User_review;
use App\Book;

class UserReviewController extends Controller
{
     /*
    |--------------------------------------------------------------------------
    | User Review Controller
    |--------------------------------------------------------------------------
    */

    /**
     * Function for adding review to book.
     *
     * @return array
     */
    public function add(Book $book, Request $request){
        if(Auth::check() && !Auth::user()->reviews->contains('book_id', $book->id) && Auth::user()->id == $request->user()->id)
        {
            $request->user()->reviews()->create([
                'book_id' => $book->id,
                'review' => $request->review
            ]);

            return array(
                'result' => 2,
                'date' => date('M d, Y'),
                'text' => $request->review,
                'rate' => Auth::user()->ratings->contains('book_id', $book->id) ? Auth::user()->ratings->where('book_id', $book->id)->first()->rate : 0
            );
        }

        return array('result' => 3);
    }
}
