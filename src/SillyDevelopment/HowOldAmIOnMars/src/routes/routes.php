<?php

use \Illuminate\Support\Facades\Route;

Route::get('greeting', function () {
    return 'Hi, this is your awesome package!';
});

/**
 * API
 */
Route::group(
    [
        'prefix'    => 'api',
        //'middleware' => 'auth:api',
        'namespace' => '\SillyDevelopment\HowOldAmIOnMars\Controllers\Api',
    ],
    function () {

        Route::get('mymarsage/{dateOfBirth?}',
            'HowOldAmIOnMarsController@calculateMyAge');
        Route::get('amIAllowedToDrinkAlcoholOnMars/{dateOfBirth?}',
            'HowOldAmIOnMarsController@amIAllowedToDrinkAlcoholOnMars');
    });

/**
 * HTTP
 */

/**
 * Facebook
 */
Route::group(
    [
        'prefix'    => '/auth',
        'namespace' => '\SillyDevelopment\HowOldAmIOnMars\Controllers\Auth',
    ],
    function () {
        Route::get('/facebook', [
            'as'   => 'auth/facebook',
            'uses' => 'FacebookController@redirectToFacebook'
        ]);
        Route::get('/facebook/callback',
            'FacebookController@facebookCallback');
    });


Route::group(
    [
        'middleware' => 'auth',
        'namespace'  => '\SillyDevelopment\HowOldAmIOnMars\Controllers',
    ]
    , function () {
    /**
     * How old am i on mars
     */
    Route::get('/how-old-am-i-on-mars',
        [
            'as'   => '/how-old-am-i-on-mars',
            'uses' => 'HowOldAmIOnMarsController@getAge'
        ]
    );
    Route::post('/how-old-am-i-on-mars',
        [
            'as'   => '/how-old-am-i-on-mars',
            'uses' => 'HowOldAmIOnMarsController@postAge'
        ]
    );

    /**
     * Requests History
     */
    Route::get('/requests-history',
        [
            'as'   => 'requests-history',
            'uses' => 'RequestsHistoryController@getRequestsHistory'
        ]
    );
    /**
     * Login History
     */
    Route::get('/login-history',
        [
            'as'   => 'login-history',
            'uses' => 'LoginHistoryController@getLoginHistory'
        ]
    );
});