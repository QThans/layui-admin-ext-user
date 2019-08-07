<?php

use think\facade\Route;

Route::group('register', function () {
    Route::group('mobile', function () {
        Route::get('', '\app\user\controller\register\MobileController@sendCode');
        Route::post('', '\app\user\controller\register\MobileController@register');
    });
});
Route::group('password', function () {
    Route::group('forget/mobile', function () {
        Route::get('', '\app\user\controller\forget\MobileController@sendCode');
        Route::post('', '\app\user\controller\forget\MobileController@forget');
    });
});
Route::group('login', function () {
    Route::group('mobile', function () {
        Route::get('', '\app\user\controller\login\MobileController@sendCode');
        Route::post('', '\app\user\controller\login\MobileController@login');
    });
});
Route::group('reset', function () {
    Route::group('mobile', function () {
        Route::get('newCode', '\app\user\controller\reset\MobileController@sendNewCode');
        Route::get('oldCode', '\app\user\controller\reset\MobileController@sendOldCode');
        Route::post('vaerify', '\app\user\controller\reset\MobileController@validateOld');
        Route::post('', '\app\user\controller\reset\MobileController@reset');
    });
})->middleware(\thans\jwt\middleware\JWTAuthAndRefresh::class);