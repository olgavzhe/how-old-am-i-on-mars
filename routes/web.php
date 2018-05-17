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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Facebook
 */
Route::group(['prefix' => '/auth'], function () {
    Route::get('/facebook', ['as' => 'auth/facebook', 'uses' => 'Auth\FacebookController@redirectToFacebook']);
    Route::get('/facebook/callback', 'Auth\FacebookController@facebookCallback');
});

/**
 * How old am i on mars
 */
Route::get('/how-old-am-i-on-mars',
    [
        'as'   => '/how-old-am-i-on-mars',
        'uses' => 'HowOldAmIOnMarsController@getAge'
    ]
)->middleware('auth');
Route::post('/how-old-am-i-on-mars',
    [
        'as'   => '/how-old-am-i-on-mars',
        'uses' => 'HowOldAmIOnMarsController@postAge'
    ]
)->middleware('auth');

/**
 * Requests History
 */
Route::get('/requests-history',
    [
        'as'   => 'requests-history',
        'uses' => 'RequestsHistoryController@getRequestsHistory'
    ]
)->middleware('auth');