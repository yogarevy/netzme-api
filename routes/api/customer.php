<?php

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

// CUSTOMER
Route::group(['as' => 'api::', 'namespace' => 'Api', 'prefix' => 'v1', 'middleware' => ['auth:api']], function () {
    Route::group(['as' => 'customer.', 'prefix' => 'customer', 'middleware' => ['access.admin']], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'CustomerController@index']);
        Route::post('/create', ['as' => 'create', 'uses' => 'CustomerController@create']);
        Route::post('/update/{id}', ['as' => 'update', 'uses' => 'CustomerController@update']);
        Route::get('/show/{id}', ['as' => 'show', 'uses' => 'CustomerController@show']);
        Route::delete('/delete/{id}', ['as' => 'delete', 'uses' => 'CustomerController@destroy']);
    });
});
