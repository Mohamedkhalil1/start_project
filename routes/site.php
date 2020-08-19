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
Route::group(['middleware' => ['api','checkPassword','changeLanguage'],'namespace'=>'Api'], function () {
    Route::post('get-categories','CategoriesController@index');
    Route::post('get-category-id','CategoriesController@show');
    Route::post('change-category-status','CategoriesController@changeStatus');

    Route::group(['prefix' => 'admin','namespace' =>'Admin'], function () {
        Route::post('login','AuthController@login');
    });
 
});




Route::group(['middleware' => ['api','checkPassword','changeLanguage','checkAdminToken:admin-api'],'namespace'=>'Api'], function () {
    Route::get('offer','CategoriesController@index');
});


