<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Books
Route::get('/books','BookController@index');
Route::get('/books/{catid}','BookController@getBooksByCat');
Route::get('/books/search/{keyword}','BookController@searchBook');
Route::get('/book/{id}','BookController@getBook');

Route::post('/books','BookController@store');

Route::put('/book/{id}','BookController@update');

Route::delete('/book/{id}','BookController@destroy');

// Roune::post('/books','BookController@store');
// Categories
Route::get('/categories','CategoryController@index');
Route::get('/category/{catid}','CategoryController@getCategory');
Route::get('/categories/search/{keyword}','CategoryController@searchCategory');

Route::post('/categories','CategoryController@store');

Route::put('/category/{catid}','CategoryController@update');

Route::delete('/category/{catid}','CategoryController@destroy');

//Orders
Route::get('/orders','OrderController@index');
Route::get('/order/{id}','OrderController@getOrder');

Route::post('/order','OrderController@store');

Route::put('/order/{id}','OrderController@update');

Route::delete('/order/{id}','OrderController@destroy');

//Account
Route::get('/accounts','AccountController@index');