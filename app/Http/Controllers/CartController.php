<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Cart_item;
use App\Book;
use App\Order;
use App\Ordered_book;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Book Controller
    |--------------------------------------------------------------------------
    */
    
    /**
     * Get cart page.
     *
     * @return view
     */
    public function cart(){
        if(Auth::check())
        {
            return view('cart.cart', [
                'items' => Auth::check() ? Auth::user()->cart_items : array(),
                'user' => Auth::check() ? Auth::user() : null
            ]); 
        }
        
        abort(404);
    }

    /**
     * Function for adding book to cart.
     *
     * @return array
     */
    public function add(Book $book, Request $request){
        if(Auth::check()){
            foreach (Auth::user()->cart_items as $cart_item){
                if($cart_item->book->id == $book->id)
                {
                    $cart_item->amount = $cart_item->amount + 1;
                    $cart_item->save();
                    return  array('result' => 1, 'items_amount' => count(Auth::user()->cart_items) + 1);
                }
            }

            Auth::user()->cart_items()->create([
                'book_id' => $book->id,
                'amount' => 1
            ]);

            return array('result' => 2, 'items_amount' => count(Auth::user()->cart_items) + 1);
        }

        return array('result' => 3, 'items_amount' => 0);
    }

    /**
     * Function for changing book in cart.
     *
     * @return array
     */
    public function change(Request $request){
        if(Auth::check()) {
            $cart_item_id = $request->cart_item_id;
            $amount = $request->amount;

            $item = Cart_item::find($cart_item_id);
            $item->amount = $amount;
            $item->save();

            $total_price = 0;

            foreach (Auth::user()->cart_items as $cart_item){
                $total_price += $cart_item->book->getCurrentPrice() * $cart_item->amount;
            }

            return array('result' => 1,
                'total_price' => number_format($total_price, 2),
                'item_total_price' => number_format($item->book->getCurrentPrice() * $item->amount, 2),
                'items_amount' => count(Auth::user()->cart_items));
        }
        else
            return 2;
    }

    /**
     * Function for deleting book in cart.
     *
     * @return array
     */
    public function delete(Request $request){
        if(Auth::check()) {
            $cart_item_id = $request->cart_item_id;

            $item = Cart_item::destroy($cart_item_id);

            $total_price = 0;

            foreach (Auth::user()->cart_items as $cart_item){
                $total_price += $cart_item->book->getCurrentPrice() * $cart_item->amount;
            }

            return array('result' => 1,
                'total_price' => number_format($total_price, 2),
                'items_amount' => count(Auth::user()->cart_items)
            );
        }
        else
            return 2;
    }

    /**
     * Get checkout page.
     *
     * @return view
     */
    public function checkout(){
        if(Auth::check()){
            if(count(Auth::user()->cart_items) <= 0){
                return redirect()->route('home');
            }

            return view('cart.checkout', ['user' => Auth::user()]);
        }
        else{
            abort(404);
        }
    }

    /**
     * Function for confirming purchase.
     *
     * @redirect to home
     */
    public function confirmpurchase(Request $request){
        if(Auth::check()){
            if(count(Auth::user()->cart_items) <= 0){
                return redirect()->route('home');
            }

            $validator = Validator::make($request->all(), [
                'fullname' => 'required|max:255',
                'phone' => 'required|regex:/\(?\+[0-9]{1,3}\)? ?-?[0-9]{1,3} ?-?[0-9]{3,5} ?-?[0-9]{4}( ?-?[0-9]{3})? ?(\w{1,10}\s?\d{1,6})?/',
                'adress' => 'required|max:100',
                'city' => 'required|max:100'
            ]);
            
            if ($validator->fails()){
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput(); 
            }

            $order = Auth::user()->orders()->create([
                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'adress' => $request->adress,
                'city' => $request->city,
            ]);

            foreach(Auth::user()->cart_items as $cart_item){
                for($i = 0; $i < $cart_item->amount; $i++){
                    $order->books()->create([
                        'book_id' => $cart_item->book_id,
                        'price' => $cart_item->book->price
                    ]);
                }
                $cart_item->delete();
            }

            return redirect()->route('home');
        }
        else{
            abort(404);
        }
    }
}
