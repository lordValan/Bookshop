<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use \Illuminate\Http\Response;
use \App\Http\Controllers\Auth\LoginController;

/**
* Main routes.
*/
Route::get('/', 'HelpController@index')->name('home');

/**
* Book routes.
*/
Route::get('/books', 'BookController@books')->name('allbooks');
Route::get('books/{book}', 'BookController@book');
Route::post('/reviews/{book}', 'UserReviewController@add');
Route::post('/ratings/{book}', 'UserRatingController@add');
Route::get('/find', 'BookController@findAllBooks');
Route::get('/findthree', 'BookController@findThreeBooks');
Route::get('/toprated', 'BookController@toprated')->name('topratedbooks');
Route::get('/bestsellers', 'BookController@bestsellers')->name('bestsellingbooks');
Route::get('/recomended', 'BookController@recomended')->name('recomendedbooks');
Route::get('/sale', 'BookController@sale')->name('salebooks');

/**
* Author routes.
*/
Route::get('authors/', 'AuthorController@authors')->name('allauthors');
Route::get('authors/{author}', 'AuthorController@author');

/**
* Cart routes.
*/
Route::get('cart/', 'CartController@cart')->name('cart');
Route::post('/cartitems/{book}', 'CartController@add');
Route::put('/cartitems/{id}', 'CartController@change');
Route::delete('/cartitems/{id}', 'CartController@delete');
Route::get('/checkout', 'CartController@checkout')->name('checkout');
Route::post('/confirm', 'CartController@confirmpurchase')->name('confirm');

/**
* Auth routes.
*/
Route::get('logout', 'Auth\LoginController@logout');
Auth::routes();

/**
* Genre routes.
*/
Route::get('/genres/{genre}', 'GenreController@genre');

/**
* User routes.
*/
Route::get('/users/{user}', 'UserController@user');
Route::get('/user/edit', 'UserController@edit')->name('useredit');
Route::put('/user/save', 'UserController@saveChanges')->name('saveUserChanges');

