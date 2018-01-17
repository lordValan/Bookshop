<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Book;

class UserRatingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Rating Controller
    |--------------------------------------------------------------------------
    */

    /**
     * Function for rate book.
     *
     * @return array
     */
    public function add(Book $book, Request $request){
        if(Auth::check() && !Auth::user()->ratings->contains('book_id', $book->id) && Auth::user()->id == $request->user()->id)
        {
            $request->user()->ratings()->create([
                'book_id' => $book->id,
                'rate' => $request->value
            ]);

            return array(
                'result' => 2,
                'amount' => count($book->ratings),
                'average' => HelpController::averageRate($book)
            );
        }

        return array('result' => 3);
    }
}
