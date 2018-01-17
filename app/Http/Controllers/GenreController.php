<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Genre;
use Auth;
use function MongoDB\BSON\toJSON;

class GenreController extends Controller
{
     /*
    |--------------------------------------------------------------------------
    | Genre Controller
    |--------------------------------------------------------------------------
    */

    /**
     * Get page with chosen genre.
     *
     * @return view
     */
    public function genre(Genre $genre, Request $request)
    {
        $page = isset($request->page) ? intval($request->page) : 1;
        $books = $genre->books;
        $pages = ceil(count($books) / 12);

        if(HelpController::isOutOfRange($pages, $page) && count($books) > 0)
            abort(404);

        $pagination = HelpController::getPag($page, $pages);

        return view('books.bookslist', [
            'user' => Auth::check() ? Auth::user() : null,
            'books' => $books->forPage($page, 12),
            'pagination' => $pagination,
            'link' => HelpController::createUrl(url()->current(), []),
            'head_title' => $genre->title,
            'message' => 'Nothing was found'
        ]);
    }
}
