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

Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){

    Route::post('showusers', 'Api\UserController@showusers');
    Route::post('barangs/simpan', 'Api\BarangController@simpan');
    Route::post('barangs/update', 'Api\BarangController@update');
    Route::get('barangs/delete/{id}', 'Api\BarangController@delete');
    Route::get('barangs/find/{id}', 'Api\BarangController@find');
    Route::post('barangs/cari', 'Api\BarangController@cari');

    Route::post('logout', 'Api\UserController@logout');
}); 


