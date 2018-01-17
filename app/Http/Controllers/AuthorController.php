<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use App\Genre;
use Auth;

class AuthorController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Author Controller
    |--------------------------------------------------------------------------
    */

    private $genre_items, $sort_items;

    public function __construct()
    {
        /**
         * Create help variables for sorting.
         *
         */

        $this->genre_items = HelpController::getGenres();
        $this->genre_items->prepend('All genres');

        $this->sort_items = collect(['Name (A-Z)', 'Name (Z-A)', 'Books amount (low to high)', 'Book amount (high to low)']);
    }

    /**
     * Get page with authors.
     *
     * @return view
     */
    public function authors(Request $request)
    {
        $page = $request->page ? intval($request->page) : 1;
        $authors = null;

        if(isset($request->genre) && $request->genre != $this->genre_items[0]){
            $authors = Genre::all()->where('title', $request->genre)->first()->books->keyBy('author_id')->map(function ($item) {
                return $item->author;
            });
        }
        else{
            $authors = Author::all();
        }

        $pages = ceil(count($authors) / 12);

        if(HelpController::isOutOfRange($pages, $page))
            abort(404);

        $authors = $this->sortAuthors($request->sort_item, $authors);

        $pagination = HelpController::getPag($page, $pages);
        $search_items = [
            'genres' => $this->genre_items,
            'chosen_genre' => isset($request->genre) ? $request->genre : $this->genre_items[0],
            'sort_items' => $this->sort_items,
            'chosen_sort' => isset($request->sort_item) ? $request->sort_item : $this->sort_items[0],
        ];
        $params = ['genre' => $request->genre, 'sort_item' => $request->sort_item];

        return view('authors.authors', [
            'authors' => $authors->forPage($page, 12),
            'pagination' => $pagination,
            'user' => Auth::check() ? Auth::user() : null,
            'search_items' => $search_items,
            'link' => HelpController::createUrl(url()->current(), $params)
        ]);
    }

    /**
     * Get page with info about author.
     *
     * @return view
     */
    public function author(Author $author){
        return view('authors.author', [
            'author' => $author,
            'user' => Auth::check() ? Auth::user() : null
        ]);
    }

    /**
     * Help private function for sorting authors list.
     *
     * @return list
     */
    private function sortAuthors($sort_item, $authors){
        switch ($sort_item){
            case $this->sort_items[0]:
                return $authors->sortBy('first_name');
            case $this->sort_items[1]:
                return $authors->sortByDesc('first_name');
            case $this->sort_items[2]:
                return $authors->sortBy(function (Author $author){
                    return count($author->books);
                });
            case $this->sort_items[3]:
                return $authors->sortByDesc(function (Author $author){
                    return count($author->books);
                });
            default:
                return $authors->sortBy('first_name');
        }
    }
}
