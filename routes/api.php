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

Route::prefix('v1')->namespace('Api')->group(function () {
  	Route::match(['get', 'post'], '/register','ApiController@register');
  	Route::match(['get', 'post'], '/login', 'ApiController@login');
	Route::match(['get', 'post'], '/create', 'ApiController@create');
  	
  	Route::middleware('Token')->group(function () {
    	Route::match(['post'], '/delete', 'ApiController@delete');
    	Route::match(['post'], '/logout', 'ApiController@logout');
  	});
});
