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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/phpinfo', function () {
   phpinfo();
});
Route::prefix('/test')->group(function(){
    Route::get('redis','TestController@testRedis');
    Route::get('test002','TestController@test002');
    Route::get('/test003','TestController@test003');
    Route::get('/wx/token','TestController@getAccessToken');
    Route::get('/curl1','TestController@curl1');
    Route::get('/curl2','TestController@curl2');
    Route::get('/guzzle1','TestController@guzzle1');

    Route::get('/guzzle','TestController@guzzle');

    Route::get('/count1','TestController@count1');

    Route::get('/api2','TestController@api2');
    Route::get('/api3','TestController@api3');


});
Route::prefix('/api')->group(function(){
    Route::get('/user/info','Api\UserController@info');
    Route::post('/user/reg','Api\UserController@reg');
});

Route::get('/goods','GoodsController@goods');


    