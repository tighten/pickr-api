<?php

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

Route::post('users', 'UserController@store');

Route::middleware('auth:api')->group(function () {
    Route::patch('users/{user}', 'UserController@update');

    Route::get('categories', 'CategoryController@index');
    Route::post('categories', 'CategoryController@store');
    Route::put('categories/{category}', 'CategoryController@update');
    Route::delete('categories/{category}', 'CategoryController@destroy');

    Route::post('categories/{category}/items', 'ItemController@store');
    Route::put('categories/{category}/items/{item}', 'ItemController@update');
    Route::delete('categories/{category}/items/{item}', 'ItemController@destroy');
});
