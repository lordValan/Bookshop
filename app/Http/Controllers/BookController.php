<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use App\Genre;
use App\Sale_book;
use App\Ordered_book;
use function foo\func;
use Illuminate\Http\Request;
use Auth;

class BookController extends Controller
{
     /*
    |--------------------------------------------------------------------------
    | Book Controller
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

        $this->sort_items = collect(['Newest Books', 'Title (A-Z)', 'Title (Z-A)', 'Price (low to high)', 'Price (high to low)']);
    }

    /**
     * Get page with books.
     *
     * @return view
     */
    public function books(Request $request)
    {
        $page = $request->page ? intval($request->page) : 1;
        $books = null;

        if(isset($request->genre) && $request->genre != $this->genre_items[0]){
            $books = Genre::all()->where('title', $request->genre)->first()->books;
        }
        else{
            $books = Book::all();
        }

        $pages = ceil(count($books) / 12);

        if(HelpController::isOutOfRange($pages, $page))
            abort(404);

        $books = $this->sortBooks($request->sort_item, $books);

        $pagination = HelpController::getPag($page, $pages);

        $search_items = [
            'genres' => $this->genre_items,
            'chosen_genre' => isset($request->genre) ? $request->genre : $this->genre_items[0],
            'sort_items' => $this->sort_items,
            'chosen_sort' => isset($request->sort_item) ? $request->sort_item : $this->sort_items[0],
        ];

        $params = ['genre' => $request->genre, 'sort_item' => $request->sort_item];

        return view('books.books', [
            'books' => $books->forPage($page, 12),
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
    public function book(Book $book)
    {
        $authorBooks = $book->author->books;
        $genreBooks = $book->genres[rand(0, 2)]->books;
        $relatedBooks = array();
        $i = 1;

        foreach ($authorBooks as $aBook) {
            if($i == 3)
                break;

            if($aBook->title != $book->title){
                array_push($relatedBooks, $aBook);
                $i++;
            }
        }

        foreach ($genreBooks as $gBook) {
            if(count($relatedBooks) == 4)
                break;

            if($gBook->title != $book->title && !$this->isHere($relatedBooks, $gBook->title)){
                array_push($relatedBooks, $gBook);
            }
        }

        return view('books.book', [
            'book' => $book,
            'relatedBooks' => $relatedBooks,
            'user' => Auth::check() ? Auth::user() : null,
            'averageRating' => HelpController::averageRate($book)
        ]);
    }

    /**
     * Function for book searching.
     *
     * @return list with all found books
     */
    public function findAllBooks(Request $request)
    {
        $books = Book::where('title', 'LIKE', '%' . $request['query'] . '%')->get();

        $result = $this->getViewAttr($request->page, $books, Auth::check() ? Auth::user() : null,
            'books.bookslist', HelpController::createUrl(url()->current(), ['query' => $request['query']]),
            'Found books', 'Nothing was found');

        if(!$result)
            abort(404);

        return $result;
    }

    /**
     * Function for book searching.
     *
     * @return list with three found books for drop-down list
     */
    public function findThreeBooks(Request $request)
    {
        if(strlen($request['query']) == 0)
            return [];

        return Book::where('title', 'LIKE', '%' . $request['query'] . '%')->get()->take(3)->map(function ($value) {
            return [
                'id' => $value->id,
                'title' => $value->title,
                'author' => $value->author->first_name . ' ' . $value->author->last_name
            ];
        });
    }

    /**
     * Help function for checking if book is in list.
     *
     * @return boolean
     */
    private function isHere($relArr, $title){
        foreach ($relArr as $relBook) {
            if($relBook->title == $title) return true;
        }
        return false;
    }

    /**
     * Help function for index page.
     *
     * @return list with last three books
     */
    public static function lastThreeBooks(){
        return Book::all()->sortBy('created_at', 0, true)->take(3);
    }

    /**
     * Function for getting bestsellers.
     *
     * @return list 
     */
    public static function getBestsellers(){
        $books = Ordered_book::all()->groupBy('book_id');

        $books = $books->sortByDesc(function ($item){
            return count($item);
        })->map(function ($item){
            return $item->first()->book;
        });

        return $books;
    }

    /**
     * Function for getting recomended books for user.
     *
     * @return view 
     */
    public function recomended(Request $request)
    {
        if(Auth::check())
        {
            $result = $this->getViewAttr($request->page, $this->getRecomended(), Auth::check() ? Auth::user() : null,
                'books.bookslist', HelpController::createUrl(url()->current(), []), 'Recomended',
                'Please, rate one of our books');

            if(!$result)
                abort(404);

            return $result;
        }
        else
        {
            return redirect()->route('allbooks');
        }
    }

    /**
     * Function for getting books on sale.
     *
     * @return view 
     */
    public function sale(Request $request)
    {
        $result = $this->getViewAttr($request->page, $this->getOnSaleBooks(), Auth::check() ? Auth::user() : null,
            'books.bookslist', HelpController::createUrl(url()->current(), []), 'Sale',
            'Nothing is on sale at this moment!');

        if(!$result)
            abort(404);

        return $result;
    }

    /**
     * Function for getting bestsellers books.
     *
     * @return view 
     */
    public function bestsellers(Request $request)
    {
        $result = $this->getViewAttr($request->page, $this->getBestsellers()->take(36), Auth::check() ? Auth::user() : null,
            'books.bookslist', HelpController::createUrl(url()->current(), []), 'Bestsellers',
            'Nothing was found');

        if(!$result)
            abort(404);

        return $result;
    }

    /**
     * Function for getting toprated books.
     *
     * @return view 
     */
    public function toprated(Request $request)
    {
        $result = $this->getViewAttr($request->page, $this->getTopRatedBooks(), Auth::check() ? Auth::user() : null,
            'books.bookslist', HelpController::createUrl(url()->current(), []), 'Top rated books',
            'Nothing was found');

        if(!$result)
            abort(404);

        return $result;
    }

    /**
     * Function for getting recomended books for user.
     *
     * @return list 
     */
    public static function getRecomended(){
        if(Auth::check()){
            $books = Auth::user()->ratings->where('rate', '>=', 4)->map(function ($item){
                return $item->book;
            });

            $books = $books->groupBy('author_id')->map(function ($item){
                return $item->first()->author->books;
            });

            $result = collect();

            foreach ($books as $authorBooks) {
                foreach ($authorBooks as $book) {
                    $result->push($book);
                }
            };

            return $result;
        }

        return [];
    }

    /**
     * Function for getting recomended top rated books.
     *
     * @return list 
     */
    public static function getTopRatedBooks(){
        $books = Book::all()->filter(function ($book){
            return count($book->ratings) > 0;
        });

        $books = $books->filter(function ($book){
            return HelpController::averageRate($book) >= 4;
        });

        $books = $books->sortByDesc(function ($book){
            return HelpController::averageRate($book);
        });

        return $books;
    }

    /**
     * Function for getting all books on sale.
     *
     * @return list 
     */
    public static function getOnSaleBooks(){
        return Sale_book::all()->map(function($item){
            return $item->book;
        });
    }

    /**
     * Help private function for sorting books list.
     *
     * @return list
     */
    private function sortBooks($sort_item, $books){
        switch ($sort_item){
            case $this->sort_items[0]:
                return $books->sortBy('created_at');
            case $this->sort_items[1]:
                return $books->sortBy('title');
            case $this->sort_items[2]:
                return $books->sortByDesc('title');
            case $this->sort_items[3]:
                return $books->sortBy(function (Book $book){
                    return $book->getCurrentPrice();
                });
            case $this->sort_items[4]:
                return $books->sortByDesc(function (Book $book){
                    return $book->getCurrentPrice();
                });
            default:
                return $books->sortBy('created_at');
        }
    }

    /**
     * Help private function for generating view with books.
     *
     * @return list
     */
    private function getViewAttr($reqPage, $attBooks, $user, $viewPath, $link, $title, $mess){
        $page = $reqPage ? intval($reqPage) : 1;
        $books = $attBooks;
        $pages = ceil(count($books) / 12);

        if(HelpController::isOutOfRange($pages, $page) && count($books) > 0)
            return false;

        $pagination = HelpController::getPag($page, $pages);

        return view($viewPath, [
            'user' => $user,
            'books' => $books->forPage($page, 12),
            'pagination' => $pagination,
            'link' => $link,
            'head_title' => $title,
            'message' => $mess
        ]);
    }
}
