<?php

use think\facade\Route;

Route::group('register', function () {
    Route::group('mobile', function () {
        Route::get('', '\app\user\controller\mobile\RegisterController@sendCode');
        Route::post('', '\app\user\controller\mobile\RegisterController@register');
    });
    Route::group('mail', function () {
        Route::get('', '\app\user\controller\mail\RegisterController@sendCode');
        Route::post('', '\app\user\controller\mail\RegisterController@register');
    });
});
Route::group('password', function () {
    Route::group('forget/mobile', function () {
        Route::get('', '\app\user\controller\mobile\ForgetController@sendCode');
        Route::post('', '\app\user\controller\mobile\ForgetController@forget');
    });
    Route::group('forget/mail', function () {
        Route::get('', '\app\user\controller\mail\ForgetController@sendCode');
        Route::post('', '\app\user\controller\mail\ForgetController@forget');
    });
});
Route::group('login', function () {
    Route::group('mobile', function () {
        Route::get('', '\app\user\controller\mobile\LoginController@sendCode');
        Route::post('', '\app\user\controller\mobile\LoginController@login');
    });
    Route::post('', '\app\user\controller\LoginController@login');
});

Route::group('', function () {
    Route::group('reset', function () {
        Route::group('mobile', function () {
            Route::get('newCode', '\app\user\controller\mobile\ResetController@sendNewCode');
            Route::get('oldCode', '\app\user\controller\mobile\ResetController@sendOldCode');
            Route::post('verify', '\app\user\controller\mobile\ResetController@validateOld');
            Route::post('', '\app\user\controller\mobile\ResetController@reset');
        });
        Route::group('mail', function () {
            Route::get('newCode', '\app\user\controller\mail\ResetController@sendNewCode');
            Route::get('oldCode', '\app\user\controller\mail\ResetController@sendOldCode');
            Route::post('verify', '\app\user\controller\mail\ResetController@validateOld');
            Route::post('', '\app\user\controller\mail\ResetController@reset');
        });
    });
    Route::group('bind', function () {
        Route::group('mobile', function () {
            Route::get('', '\app\user\controller\mobile\BindController@sendCode');
            Route::post('', '\app\user\controller\mobile\BindController@bind');
        });
        Route::group('mail', function () {
            Route::get('', '\app\user\controller\mail\BindController@sendCode');
            Route::post('', '\app\user\controller\mail\BindController@bind');
        });
    });
    Route::group('user', function () {
        Route::post('setting', '\app\user\controller\SettingController@setting');
        Route::post('avatar', '\app\user\controller\SettingController@avatar');
        Route::post('password', '\app\user\controller\SettingController@password');
    });
})->middleware(\thans\jwt\middleware\JWTAuthAndRefresh::class);

Route::group('admin', function () {
    Route::resource('user', '\app\admin\controller\UserController');
})->middleware([
    thans\layuiAdmin\middleware\Login::class,
    thans\layuiAdmin\middleware\AdminsAuth::class,
]);