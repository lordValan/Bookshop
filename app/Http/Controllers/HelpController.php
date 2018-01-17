<?php

namespace App\Http\Controllers;

use App\Book;
use Auth;
use App\Genre;
use App\Order;
use App\Customer_opinion;

class HelpController extends Controller
{
     /*
    |--------------------------------------------------------------------------
    | Help Controller
    |--------------------------------------------------------------------------
    */

    /**
     * Get home page.
     *
     * @return view
     */
    public function index(){
        return view('index', [
            'lastThreeBooks' => BookController::lastThreeBooks(),
            'bestsellers' => BookController::getBestsellers()->take(10),
            'toprated' => BookController::getTopRatedBooks()->take(10),
            'onsale' => BookController::getOnSaleBooks()->take(10),
            'user' => Auth::check() ? Auth::user() : null,
            'customers' => Customer_opinion::all()
        ]);
    }

    /**
     * Help function for creating pagination.
     *
     * @return array
     */
    public static function getPag($curPage, $pagesAmount){
        $pagArr = array();

        $pagArr['firstPagPage'] = $pagesAmount > 5 ? $curPage <= 3 ? 1 : ($curPage >= $pagesAmount - 2 ? $pagesAmount - 4 : $curPage - 2) : 1;
        $pagArr['lastPagPage'] = $pagesAmount > 5 ? $curPage <= 3 ? 5 : ($curPage >= $pagesAmount - 2 ? $pagesAmount : $curPage + 2) : $pagesAmount;
        $pagArr['currPagPage'] = $curPage;
        $pagArr['pagesAmount'] = $pagesAmount;

        return $pagArr;
    }

    /**
     * Help function for checking range in pagination.
     *
     * @return boolean
     */
    public static function isOutOfRange($range, $value){
        if($value <= 0 || $value > $range)
            return true;

        return false;
    }

    /**
     * Help function for counting average book rate.
     *
     * @return decimal
     */
    public static function averageRate(Book $book){
        $aver = 0;

        foreach ($book->ratings as $rating){
            $aver += $rating->rate;
        }

        return $aver > 0 ? $aver / count($book->ratings) : 1;
    }

    /**
     * Help function for getting top nine genres for sorting block.
     *
     * @return array
     */
    public static function getGenres(){
        return Genre::all()->sortBy(function (Genre $genre){
            return count($genre->books);
        }, 0, true)->map(function ($item) {
            return $item->title;
        })->take(9);
    }

    /**
     * Help function for creating url when sorting book or aurhors.
     *
     * @return string
     */
    public static function createUrl($currUrl, $params){
        $link = $currUrl . '?';
        $str_params = http_build_query($params);
        $link .= strlen($str_params) > 0 ? $str_params . '&page=' : 'page=';

        return $link;
    }
}
